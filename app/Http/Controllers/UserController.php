<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\task;
use App\Models\User;
use App\Models\projet;
use App\Models\history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acces_user')->except('restore','home','show_trash');
        $this->middleware('can:acces_mana')->only('restore','show_trash');

    }
    
    public function home(){
        $myArray = []; 
        if(auth()->user()->role=='employee'){
            $tagCounts = auth()->user()->assignedTasks()->select('etat', DB::raw('COUNT(*) as tag_count'))
            ->groupBy('etat')
            ->get();
            $tags = auth()->user()->assignedTasks()
            ->orderByDesc('prio')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();
            $sum = 0;
            foreach ($tagCounts as $object) {
                $sum += $object->tag_count;
            }
                $myArray=[
                'count'=>$tagCounts,
                'data'=>$tags,
                'all'=>$sum
            ];
        }elseif (auth()->user()->role=='manager') {
            $user_count = User::where('user_id', auth()->user()->id)->count();
            $prj_count = auth()->user()->projects()->count();
            $tas_count = auth()->user()->managedTasks()->get();
            $prj = auth()->user()->projects()->orderByDesc('created_at')->take(8)->get();
            $myArray = [
                'count' => [
                    'user' => $user_count,
                    'prj' => $prj_count,
                    'task' => $tas_count->count(),
                ],
                'task_count' => [
                'pend' => $tas_count->where('role', 'pending')->count(),
                'comp' => $tas_count->where('role', 'completed')->count(),
                'new' => $tas_count->where('role', 'new')->count(),
                'can' => $tas_count->where('role', 'cancelled')->count(),
                ],
                'data' => $prj,
            ];
        }elseif (auth()->user()->role=='admin') {
            $users = User::where('role', '<>', 'admin')->orderBy('created_at')->take(8)->get();
            $projects = Projet::orderBy('created_at')->take(8)->get();
            $myArray = [
                'count' => [
                    'user' => User::where('role', '<>', 'admin')->count(),
                    'prj' => Projet::count(),
                    'task' => Task::count(),
                    ],
                'data' => [
                    'user' => $users,
                    'prj' => $projects,
                    ],
                ];
        }
    return view('Home',['data'=>$myArray]);
    }
    
    public function show_create(){
        $data=null;
        if(auth()->user()->role==='admin'){
            $data=User::where('role','manager')->get();
        }
        return view('User.Cre_User',['data'=>$data]);
    }
    public function create(Request $request) {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'firstName' => 'required',
            'lastName' => 'required',
            'tel' => 'required',
            'image' => 'file|image',
        ];
        if (auth()->user()->role !== "manager") {
            $rules['type'] = 'required';
            $rules['manager'] = 'required_if:type,employee';
        }
        $validated = $request->validate($rules);
        if ($request->file("image")) {
            $imagePath = $request->file("image")->store("logos", "public");
        } else {
            $imagePath = null;
        }
        $data = [
            'firstName' => $validated["firstName"],
            'lastName' => $validated["lastName"],
            'email' => $validated["email"],
            'password' => $validated["password"],
            'user_id' => (auth()->user()->role === "manager") ? auth()->user()->id : $validated["manager"],
            'role' => (auth()->user()->role === "manager") ? 'employee' : $validated["type"],
            'tel' => $validated["tel"],
            'image' => $imagePath,
        ];
        $user=User::create($data);
        logAction('User_created', auth()->user()->id, 'User', $user->id, json_encode($user));
        return redirect()->route('user.create')->with("message", "User created successfully");
    }
    
    public function index(Request $request){
        $my=[];
        if(auth()->user()->role=='admin'){
            $alldata=count( User::where('role', 'manager')->orWhere('role', 'employee')->get());
            $cnt_em=count( User::where('role','employee')->get());
            $cnt_ma=count( User::where('role','manager')->get());
    
            $data = User::where('role', 'manager')->orWhere('role', 'employee')->orderByDesc('created_at')->paginate(8);
            if($request->type){
                $data=User::where('role', $request->type)->orderByDesc('created_at')->paginate(8);
            }
            if ($request->has('type') && $request->filled('type') && in_array($request->input('type'), ['employee', 'manager'])) {
                $search = $request->input('type');
                $data=User::where('role', $search)->orderByDesc('created_at')->paginate(8);
            }
            $my=[
                'data' => $data,
                'alldata'=> $alldata,
                'cnt_em'=>$cnt_em,
                'cnt_ma'=>$cnt_ma];
        }else{
            $data = User::where('role', 'employee')->Where('user_id', auth()->user()->id)->orderByDesc('created_at')->paginate(8);
            $alldata=count( User::where('role', 'employee')->Where('user_id', auth()->user()->id)->get());
            $my=[
                'data' => $data,
                'alldata'=> $alldata,
            ];
        }

        return view('User.List_User', $my);
    } 
    public function delete($id) {
        $user=User::find($id);
        if(!(auth()->user()->role==='manager' && $user->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        if (!$user) {
            return redirect()->back()->with('error', 'Project not found.');
        }
        if($user->role=='manager'){
            if($user->projects()->exists()){
                foreach($user->projects as $project){
                    if ($project->tasks()->exists()) {
                        foreach ($project->tasks as $task) {
                            if ($task->feedbacks()->exists()) {
                                $task->feedbacks()->delete();
                            }
                        }
                        $project->tasks()->delete();
                    }
                    $project->delete();
                }
            }
        }
        $user->delete();
        $userdata=$user->toArray();
        logAction('User_deleted', auth()->user()->id, 'User', $user->id, json_encode($userdata));
        return redirect()->back()->with("message","User deleted successfully");
    }
    public function show( $id){
        $user=User::withTrashed()->find($id);
        if(!(auth()->user()->role==='manager' && $user->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
         $data=[];
         $hist=history::where('model', 'User')->where('model_id',$user->id)->orderBy('created_at')->limit(8)->get();
         foreach ($hist as $value) {
            $ar = explode("_", $value->action);
            $user = User::find($value->model_id);
            $time = explode(" ", $value->created_at);
            $data[] = [
                'Action' => $ar[1],
                'User' => [
                    'id' => $value->user->id,
                    'name' => $value->user->firstName . ' ' . $value->user->lastName,
                    'image' => $value->user->image,
                ],
                'User_action' => [
                    'id' => $user->id,
                    'name' => $user->firstName . ' ' . $user->lastName,
                    'image' => $user->image,
                ],
                'Date' => $time[0],
                'Time' => $time[1],
            ];
      }
        return view('User.Show_User',['data'=>$user,'his'=>$data]);
    }
    public function edit($id){
        $x=User::find($id);
        if(!(auth()->user()->role==='manager' && $x->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        $data=null;
        if(auth()->user()->role==='admin'){
            $data['mana']=User::where('role','manager')->get();
        }
        $data['user']=$x;
        return view('User.Upd_User',['data'=>$data]);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if(!(auth()->user()->role==='manager' && $user->user_id==auth()->user()->id) && auth()->user()->role!=='admin' ){
            abort(403);
         }
        $rules = [
            'password' => 'nullable|confirmed|min:6',
            'firstName' => 'required',
            'lastName' => 'required',
            'tel' => 'required',
            'image' => 'file|image',
        ];
        if (auth()->user()->role !== "manager") {
            $rules['type'] = 'required';
            $rules['manager'] = 'required_if:type,employee';
        }
        $validated = $request->validate($rules);
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->tel = $request->tel;
        if (auth()->user()->role !== "manager") {
            $user->user_id = (auth()->user()->role === "manager") ? auth()->user()->id : $request->manager;
            $user->role = (auth()->user()->role === "manager") ? 'employee' : $request->type;
        }
        if ($request->hasFile('image')) {
            $user->image = $request->file("image")->store("logos", "public");
        }
        $user->save();
        $userdata=$user->toArray();
        logAction('User_updated', auth()->user()->id, 'User', $user->id, json_encode($userdata));
        return redirect()->route('user.all')->with('success', 'User updated successfully');
    }
    public function show_trash(){
        $user=User::onlyTrashed()->orderByDesc('created_at');
        return view('User.List_User_trash',['data'=>$user->paginate(8),'count'=>$user->get()->count()]);
    }
    public function restore($id){
        $user=User::withTrashed()->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Project not found.');
        }
        $user->restore();
        if ($user->role === 'manager') {
            $trashedProjects = $user->projects()->onlyTrashed()->get();
            foreach ($trashedProjects as $project) {
                $project->restore();
                foreach ($project->tasks()->onlyTrashed()->get() as $task) {
                    $task->restore();
                    foreach ($task->feedbacks()->onlyTrashed()->get() as $feedback) {
                        $feedback->restore();
                    }
                }
            }
        }
        $userdata=$user->toArray();
        logAction('User_restored', auth()->user()->id, 'User', $user->id, json_encode($userdata));
        return redirect()->back()->with("message","User restored successfully");
    }
    public function get_time($id,Request $request){
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::today(); 
        $endDate = $startDate->copy()->addDays(14);
        $tasks = Task::where('emp_id', $id)
            ->whereBetween('date_deb', [$startDate, $endDate])
            ->orderBy('date_deb')
            ->get();
        $data=[
            'data'=> $tasks,
            'start'=> date('Y-m-d', strtotime($startDate)),
            'end'=> date('Y-m-d', strtotime($endDate)),
        ];
        return response()->json($data);
    }
}
