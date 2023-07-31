<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\task;
use App\Models\projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\history;
use App\Models\User;
use Illuminate\Console\View\Components\Task as ComponentsTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class taskController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acces_user')->except('restore','show_all','todo','edit_task_etat','show_trash');
        $this->middleware('can:acces_mana')->only('restore','show_trash');

    }
    public function todo(Request $request){
        $myArray = []; 
        if(auth()->user()->role=='employee'){
            $currentDate = date('Y-m-d');
             $tags = Task::where('emp_id',auth()->user()->id)->where(function ($query) use ($currentDate) {
                $query->where('date_deb', '<=', $currentDate)
                      ->where('date_fin', '>=', $currentDate);
            });
            $tagCounts =auth()->user()->assignedTasks()->
            select('etat', DB::raw('COUNT(*) as tag_count'))
            ->groupBy('etat')
            ->get();
            $search='';
            if($request->has('search') && $request->filled('search')){
                $search=$request->search;
                $tags=$tags->where('name','like','%'.$search.'%')->
                orwhere('desc','like','%'.$search.'%')
                ->orwhere('etat','like','%'.$search."%");
            }
            $tags=$tags->orderByDesc('prio')->orderByDesc('created_at')->paginate(10);
            $sum = 0;
            foreach ($tagCounts as $object) {
                $sum += $object->tag_count;
            }
                $myArray=[
                    'data'=>$tags,
                    'all'=>$sum,
                    'search'=>$search
            ];
        }
        return view('Task.Todo',['data'=>$myArray]);
    }
    public function edit_task_etat(Request $request){
        try{
        $etat=task::find($request->tag_id);
        if($etat->etat=='cancelled'){
            return ['message'=>'you cannot update etat of task'];
        }
        $etat->etat=$request->new_etat;
        $etat->prio=-1;
        $etat->save();
        $nbralltask= Task::where('pro_id', $etat->pro_id)->count();
        $nbrtaskcom=Task::where('pro_id', $etat->pro_id)->whereIn('etat', ['completed', 'cancelled'])->count();
        $proj=projet::find($etat->pro_id);
        if($nbralltask===$nbrtaskcom){
            $proj->etat='completed';
        }else{
            $proj->etat='pending';
        }
        $proj->save();
        logAction('task_updated_etat', auth()->user()->id, 'task', $etat->id, json_encode($etat));
        logAction('project_updated_etat', auth()->user()->id, 'projets', $proj->id, json_encode($proj));

        return ['message'=>'etat update'];
    }catch(Exception $e) {
        dd($e);
    }

}

    public function create(Request $request){
        $id= ($request->has('id') && $request->filled('id')) ? $request->input('id') : 0;
        $data = array();
        if(auth()->user()->role==='manager'){
            $data = [
                'projet' => Auth::user()->projects,
                'user' => User::where('user_id',auth()->user()->id)->get()
            ];
        }if(auth()->user()->role==='admin'){
            $data = [
                'projet' => projet::get(),
                'user' => User::where('role','employee')->get(),
            ];
        }
        return view('Task.Create_task',['data'=>$data,'id'=>$id]);
    }

    public function insert(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id_pr' => 'required|exists:projets,id', 
            'id_em' => 'nullable|exists:users,id', 
            'da_sta' => 'required|date', 
            'da_end' => 'required|date|after:da_sta', 
            'desc' => 'required|string',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id_user = Projet::find($request->input('id_pr'));
        if (!$id_user) {
            return redirect()->back()->with('error', 'Invalid project ID.');
        }
        $pr=0;
        if($request->has('urgent')){
            if ($request->input('urgent')=='urgent') {
                $pr=2;
            } elseif($request->input('urgent')=='medium') {
                $pr=1;
            }
            
        }

        $task=Task::create([
        'name' => $request->input('name'),
        'desc'=> $request->input('desc'),
        'date_deb'=> $request->input('da_sta'),
        'date_fin'=> $request->input('da_end'),
        'etat'=>'new',
        'prio'=>$pr,
        'man_id'=>(auth()->user()->role=='admin')? $id_user->user_id :auth()->user()->id,
        'emp_id'=>$request->filled('id_em') ? $request->input('id_em') : null,
        'pro_id'=>$request->input('id_pr'),
            ]);
        logAction('task_created', auth()->user()->id, 'task', $task->id, json_encode($task));
        return redirect()->back()->with('success', 'task information inserted successfully.');
    }

    public function show_all(Request $request){
        $data = [];
        if(auth()->user()->role === 'manager'){
            $tags = Auth::user()->managedTasks();
            $data['old']="";
            if($request->has('search') && $request->filled('search')){
                $search = $request->input('search');
                $tags = $tags->where('name', 'like', '%'.$search.'%')
                        ->orWhere('desc', 'like', '%'.$search.'%')
                        ->orWhere('etat', 'like', '%'.$search.'%');
                $data['old']=$search;
            }
            if($request->has('id_e') && $request->filled('id_e')){
                $search = $request->input('id_e');
                $tags = $tags->where('emp_id',$search);
            }
            if($request->has('id_m') && $request->filled('id_m')){
                $search = $request->input('id_m');
                $tags = $tags->where('man_id',$search)
                            ;
            }
            $data['task'] = $tags->orderByDesc('created_at')->paginate(8);
            $data['count']=count(Auth::user()->managedTasks);
            $data['emp']=User::where('user_id',auth()->user()->id)->where('role','employee')->get();
        }elseif (auth()->user()->role === 'admin') {
            $tags = task::query();
            $data['old']="";
            if($request->has('search') && $request->filled('search')){
                $search = $request->input('search');
                $tags = $tags->where('name', 'like', '%'.$search.'%')
                             ->orWhere('desc', 'like', '%'.$search.'%')
                             ->orWhere('etat', 'like', '%'.$search.'%');
                $data['old']=$search;
            }
            if($request->has('id_e') && $request->filled('id_e')){
                $search = $request->input('id_e');
                $tags = $tags->where('emp_id',$search);
            }
            if($request->has('id_m') && $request->filled('id_m')){
                $search = $request->input('id_m');
                $tags = $tags->where('man_id',$search)
                            ;
            }
            $data['task'] = $tags->orderByDesc('created_at')->paginate(8);
            $data['count']=task::get()->count();
           $man= $tags->select('man_id', 'created_at')->distinct()->get();
           $mman=[];
           foreach ($man as $value) {
                if(!in_array($value->man_id,$mman)){
                    $mman[]=$value->man_id;
                }
           }
            $data['emp']=User::whereIn('user_id',$mman)->where('role','employee')->get();
        }elseif (auth()->user()->role === 'employee') {
            $task=task::where('emp_id',auth()->user()->id);
            $data['old']="";
            if($request->has('search') && $request->filled('search')){
                $search = $request->input('search');
                $task= $task->where('name', 'like', '%'.$search.'%')
                             ->orWhere('desc', 'like', '%'.$search.'%')
                             ->orWhere('etat', 'like', '%'.$search.'%');
                $data['old']=$search;
                
            }
            $data['task'] = $task->orderByDesc('created_at')->paginate(8);
            $data['count']=$task->get()->count();
        }
        return view('Task.List_Task', ['data'=>$data]);
    }
    

    public function show_edit(Request $request, $id)
    {
        $x=task::find($id);
        if(!(auth()->user()->role==='manager' && $x->man_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        $data = [];
        if (auth()->user()->role === 'manager') {
            $data = [
                'projet' => Auth::user()->projects,
                'user' => User::where('user_id', auth()->user()->id)->get()
            ];
        }else{
            $data = [
                'projet' => projet::all(),
                'user' => User::where('role', 'employee')->where('user_id', $x->man_id)->get()
            ];
        }
        $data['task'] = $x;
        $var=0;
        if($request->has('redirect_to')){
            $var=intval($request->redirect_to);
        }
        return view('Task.Update_task', ['data' => $data,'redirect'=>$var]);
    }

    public function destroy($id){
        DB::beginTransaction();
    try {
        $task = Task::findOrFail($id);
        if(!(auth()->user()->role==='manager' && $task->man_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        if($task->feedbacks()->exists()){
            $task->feedbacks()->delete();
        }
        $task->delete();
        DB::commit();
        $task_dd = $task->toArray();
        logAction('task_deleted', auth()->user()->id, 'task', $task->id, json_encode($task_dd));
        return redirect()->route('task.all')->with('success', 'Task and associated feedback deleted successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Failed to delete the task and associated feedback.');
    }
    }

    public function update(Request $request,$id){
        $existingTask = Task::find($id);
        if(!(auth()->user()->role==='manager' && $existingTask->man_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        $rules = [
            'name' => 'required|max:255',
            'da_sta' => 'required|date',
            'da_end' => 'required|date|after:da_sta',
            'etat' => 'required|in:new,completed,pending,cancelled',
            'id_pr' => 'required|exists:projets,id', 
            'id_em' => 'nullable|exists:users,id', 
            'desc' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id_user = Projet::find($request->input('id_pr'));
        if (!$id_user) {
            return redirect()->back()->with('error', 'Invalid project ID.');
        }
        $pr=0;
        if($request->has('urgent')){
            if ($request->input('urgent')=='urgent') {
                $pr=2;
            } elseif($request->input('urgent')=='medium') {
                $pr=1;
            }
            
        }
         $existingTask->name = $request->input('name');
         $existingTask->desc = $request->input('desc');
         $existingTask->date_deb = $request->input('da_sta');
         $existingTask->date_fin = $request->input('da_end');
         $existingTask->etat =($request->has('urgent')) ? 'new' :   $request->input('etat');    
         $existingTask->prio = $request->has('urgent');
         $existingTask->pro_id = $request->input('id_pr');
         $existingTask->emp_id = $request->input('id_em');
         $existingTask->man_id =(auth()->user()->role=='admin')? $id_user->user_id :auth()->user()->id;
         $existingTask->save();
         logAction('task_updated', auth()->user()->id, 'task', $existingTask->id, json_encode($existingTask));
         if( $request->has('redirect')){
            return redirect()->route('task.show',['id'=>$id])->with('success', 'Task updated successfully.');
        }
        return redirect()->route('task.all')->with('success', 'Task updated successfully.');
    }

    public function show($id){
        $task=Task::withTrashed()->find($id);
        if(!(auth()->user()->role==='manager' && $task->man_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
         $emp=[];
        if(auth()->user()->role==='manager'){
            $emp=User::where('user_id',auth()->user()->id)->where('role','employee')->get();
        }elseif (auth()->user()->role==='manager') {
            $man= $task->select('man_id', 'created_at')->distinct()->get();
           $mman=[];
           foreach ($man as $value) {
                if(!in_array($value->man_id,$mman)){
                    $mman[]=$value->man_id;
                }
           }
            $emp=User::whereIn('user_id',$mman)->where('role','employee')->get();
        }
         $data = [];
         $hist=history::where('model', 'task')->where('model_id',$task->id)->orderBy('created_at','desc')->limit(8)->get();
         foreach ($hist as $value) {
            $ar = explode("_", $value->action);
            $time = explode(" ", $value->created_at);
            $data[] = [
                'Action' => $ar[1],
                'User' => [
                    'id' => $value->user->id,
                    'name' => $value->user->firstName . ' ' . $value->user->lastName,
                    'image' => $value->user->image,
                ],
                'Date' => $time[0],
                'Time' => $time[1],
            ];
        }
        return view('Task.Show_task',['emp'=>$emp,'data'=>$task,'his'=>$data]);
    }

    function detach($id){
        $task=Task::find($id);
        if(!(auth()->user()->role==='manager' && $task->man_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        $task->emp_id=null;
        $task->save();
        logAction('task_updated_user_empid', auth()->user()->id, 'task', $task->id, json_encode($task));
        return redirect()->back()->with('success', 'separate task from the user');
    }
    public function show_trash(Request $request) {
        $data = [];
        $tags = Task::onlyTrashed();
        $data['old']='';
        if ($request->filled('search')) {
            $search = $request->input('search');
            $tags = $tags->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('desc', 'like', '%' . $search . '%')
                    ->orWhere('etat', 'like', '%' . $search . '%');
            });
            $data['old'] = $search;
        }
        $data['task'] = $tags->orderByDesc('created_at')->with('project')->paginate(10); 
        $data['count'] = Task::onlyTrashed()->count();
        return view('Task.List_task_trash', ['data' => $data]);
    }

    public function restore($id){
        $task=task::withTrashed()->find($id);
        if (!$task) {
            return redirect()->back()->with('error', 'task not found.');
        }
        $task->restore();
        $task_data = $task->toArray();
        foreach ($task->feedbacks()->withTrashed()->get() as $feedback) {
            if ($feedback->trashed()) {
                $feedback->restore();
            }
        }
        logAction('task_restore', auth()->user()->id, 'task', $task->id, json_encode($task_data));
        return redirect()->back()->with('success', 'tasks, and feedbacks restored successfully');
    }
    public function edit_task_emp(Request $request,$id){
        if($request->has('id_emp')){
            $task =task::find($id);
            $task->emp_id=$request->id_emp;
            $task->save();
            logAction('task_update_employeee', auth()->user()->id, 'task', $task->id, json_encode($task));
            return redirect()->back()->with('success', ' Add an employee to the task');
        }
    }
}
