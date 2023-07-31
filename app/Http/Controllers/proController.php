<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\User;
use App\Models\projet;
use App\Models\feedback;
use App\Models\history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class proController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('can:acces_user')->except('restore','show_trash');
        $this->middleware('can:acces_mana')->only('restore','show_trash');

    }

    public function create(){
        $data=[];
        if(auth()->user()->role=='admin'){
            $data['user']=User::where('role','manager')->get();
        }
        return view('Projet.Create_pro',['data'=>$data ]);
    }
    public function insert(Request $request){
        $rules = [
            'nom' => 'required|string|max:255',
            'date_deb' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_deb',
            'desc' => 'required|string',
        ];
        if (auth()->user()->role === "admin") {
            $rules['id_ma'] =  'required|exists:users,id';
        }
        $validated = $request->validate($rules);
        $data = [
            'nom' => $validated["nom"],
            'desc' => $validated["desc"],
            'date_deb' => $validated["date_deb"],
            'date_fin' => $validated["date_fin"],
            'user_id' => (auth()->user()->role === "manager") ? auth()->user()->id : $validated["id_ma"],
            'etat' =>'new',
        ];
        $prj=projet::create($data);
        logAction('project_created', auth()->user()->id, 'projets', $prj->id,json_encode($prj));
        return redirect()->back()->with('success', 'Project created successfully.');
    }
    public function show_all(Request $request){

        $old='';
        $data = [];
        if (auth()->user()->role === 'manager') {
            $projects = Auth::user()->projects;
            $projectscount = count($projects);
            $proj_count_canc = $projects->where('etat', 'cancelled')->count();
            $proj_count_new = $projects->where('etat', 'new')->count();
            $proj_count_pen = $projects->where('etat', 'pending')->count();
            $proj_count_com = $projects->where('etat', 'completed')->count();
            $all = Auth::user()->projects();
            if($request->has('search') && $request->filled('search')){
                $search = $request->input('search');
                $all=$all->where('nom', 'like', '%'.$search.'%')
                ->orWhere('desc', 'like', '%'.$search.'%');
                $old=$search;
            }
            if($request->has('etat') && $request->filled('etat') && in_array($request->input('etat'),['cancelled','completed','pending','new'])){
                $search = $request->input('etat');
                $all=$all->where('etat', 'like', '%'.$search.'%');            
            }
            $all=$all->orderByDesc('created_at')->paginate(10);
            $data=[
                'old'=>$old,
                'data'=>$all,
                'count_new'=>  $proj_count_new,
                'count_com'=>$proj_count_com,
                'count_pen'=>$proj_count_pen,
                'count_canc'=> $proj_count_canc,
                'count_all'=>$projectscount
            ];
        }else if(auth()->user()->role === 'admin'){
            $all = projet::query();
        $projects = $all->get();
        $projectscount = $projects->count();
        $proj_count_canc = $projects->where('etat', 'cancelled')->count();
        $proj_count_new = $projects->where('etat', 'new')->count();
        $proj_count_pen = $projects->where('etat', 'pending')->count();
        $proj_count_com = $projects->where('etat', 'completed')->count();
        if ($request->has('search') && $request->filled('search')) {
            $search = $request->input('search');
            $all->where(function ($query) use ($search) {
            $query->where('nom', 'like', '%' . $search . '%')
            ->orWhere('desc', 'like', '%' . $search . '%');
            });
            $old = $search;
        }
        if ($request->has('etat') && $request->filled('etat') && in_array($request->input('etat'), ['cancelled', 'completed', 'pending', 'new'])) {
            $search = $request->input('etat');
            $all->where('etat', $search);
        }
        if ($request->has('id_u') && $request->filled('id_u')) {
            $search = $request->input('id_u');
            $all->where('user_id', $search);
        }
        $all = $all->orderByDesc('created_at')->paginate(10);
        $data = [
            'old'       => $old ?? '',
            'data'      => $all,
            'count_new' => $proj_count_new,
            'count_com' => $proj_count_com,
            'count_pen' => $proj_count_pen,
            'count_canc'=> $proj_count_canc,
            'count_all' => $projectscount,
        ];
        }
        return view('Projet.List_pro',$data);
    }
    public function show_edit($id){
        
        $data=projet::find($id);
        $man=null;
        if(!(auth()->user()->role==='manager' && $data->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
           abort(403);
        }
        if(auth()->user()->role=='admin'){
            $man=User::where('role','manager')->get();
        }
        return view('Projet.update_pro',['data'=>$data,'man'=>$man]);
    }
    public function update(Request $request, $id)
    {        $existingTask = projet::find($id);

        if(!(auth()->user()->role==='manager' && $existingTask->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
        abort(403);
     }
        $rules = [
            'nom' => 'required|string|max:255',
            'date_deb' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_deb',
            'desc' => 'required|string',
        ];
        if (auth()->user()->role === "admin") {
            $rules['id_ma'] =  'required|exists:users,id';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $newetat = 'cancelled';
        $existingTask = projet::find($id);
        if (!$request->input('Cancelled')) {
            $newetat = 'new';
            if ($existingTask->tasks()->where('etat', 'completed')->get()->count() > 0) {
                $newetat = 'pending';
            }
        }
        $existingTask->nom = $request->input('nom');
        $existingTask->date_deb = $request->input('date_deb');
        $existingTask->date_fin = $request->input('date_fin');
        $existingTask->desc = $request->input('desc');
        $existingTask->etat = $newetat;
        $existingTask->user_id= (auth()->user()->role === "manager") ? auth()->user()->id : $request->input("id_ma");
        $existingTask->save();
        $task_data = $existingTask->toArray();
        logAction('project_updated', auth()->user()->id , 'projets', $existingTask->id, json_encode($task_data));
        return redirect()->route('project.all')->with('success', 'Project updated successfully.');
    }
    public function delete($id){
        $project = projet::find($id);
        if(!(auth()->user()->role==='manager' && $project->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        if (!$project) {
            return redirect()->route('project.all')->with('error', 'Project not found.');
        }
        
        if ($project->tasks()->exists()) {
            foreach ($project->tasks as $task) {
                if ($task->feedbacks()->exists()) {
                    $task->feedbacks()->delete();
                }
            }
            $project->tasks()->delete();
        }
        $project->delete();
        $project_data = $project->toArray();
        logAction('project_deleted', auth()->user()->id, 'projets', $project->id, json_encode($project_data));
    return redirect()->route('project.all')->with('success', 'Project, tasks, and feedback deleted successfully.');
    }
    public function show($id){
        $project = projet::withTrashed()->find($id);
        if(!(auth()->user()->role==='manager' && $project->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
         $emp=[];
        if(auth()->user()->role==='manager'){
            $emp=User::where('user_id',auth()->user()->id)->where('role','employee')->get();
        }elseif (auth()->user()->role==='admin') {
            $man= task::where('pro_id',$project->id)->select('man_id', 'created_at')->distinct()->get();
           $mman=[];
           foreach ($man as $value) {
                if(!in_array($value->man_id,$mman)){
                    $mman[]=$value->man_id;
                }
           }
            $emp=User::whereIn('user_id',$mman)->where('role','employee')->get();
        }
           $data=[];
           $hist=history::where('model', 'projets')->where('model_id',$project->id)->orderBy('created_at','desc')->limit(8)->get();
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
        return view('Projet.Show_pro',['emp'=>$emp,'data'=>$project,'his'=>$data]);
    }
    public function show_trash(Request $request)
    {
        $old='';
        $trashedProjects = Projet::onlyTrashed()->get();
        $projectData = [];
        if($request->has('search') && $request->filled('search')){
            $search = $request->input('search');
            $trashedProjects=$trashedProjects->where('nom', 'like', '%'.$search.'%')
            ->orWhere('desc', 'like', '%'.$search.'%');
            $old=$search;
        }
        foreach ($trashedProjects as $project) {
            $tasksCount = Task::where('pro_id', $project->id)->onlyTrashed()->orderByDesc('created_at')->get()->pluck('id')->toArray();
            $feedbackscount = Feedback::whereIn('tag_id', $tasksCount)->onlyTrashed()->orderByDesc('created_at')->get();

            $projectData[] = [
                'project' => $project,
                'tasks_count' => count($tasksCount),
               'feedbacks_count' => $feedbackscount->count(),
            ];
        }
        $count = Projet::onlyTrashed()->count();
        $projectData = collect($projectData);

        $perPage = 8;
        $currentPage = request()->query('page', 1); 
        $paginatedData = new LengthAwarePaginator(
            $projectData->forPage($currentPage, $perPage),
            $projectData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );       
        return view('Projet.List_pro_trash', ['data' => $paginatedData, 'count' => $count,'old'=>$old]);
    }
    public function restore($id)
    {
        $project = projet::withTrashed()->find($id);
        if (!$project) {
            return redirect()->back()->with('error', 'Project not found.');
        }
        $project->restore();
        $project_data = $project->toArray();
        $restoredTasksCount = 0;
        $restoredFeedbacksCount = 0;
        
        foreach ($project->tasks()->withTrashed()->get() as $task) {
            if ($task->trashed()) {
                $task->restore();
                $restoredTasksCount++;
            }
            foreach ($task->feedbacks()->withTrashed()->get() as $feedback) {
                if ($feedback->trashed()) {
                    $feedback->restore();
                    $restoredFeedbacksCount++;
                }
            }
        }
        logAction('project_restored', auth()->user()->id, 'projets', $project->id, json_encode($project_data));
        return redirect()->route('project.trash')->with('success', 'Project, tasks, and feedbacks restored successfully. ' . $restoredTasksCount . ' tasks and ' . $restoredFeedbacksCount . ' feedbacks restored.');
    }
    public function get_empl($id){
        $project = projet::findOrFail($id);
        $user = $project->user;
        $em=User::where('user_id',$user->id)->where('role','employee')->get();
        $data=[];
        foreach ($em as $value) {
            $data[]=[
                'id'=>$value->id,
                'name'=>$value->firstName . ' ' . $value->lastName
            ];
        }
        return response()->json($data);
    }
}
