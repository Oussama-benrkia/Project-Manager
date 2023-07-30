<?php

namespace App\Http\Controllers;

use App\Models\history;
use App\Models\projet;
use App\Models\task;
use App\Models\User;
use Illuminate\Http\Request;

class HisController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:acces_mana');

    }
    public function history_pro()
{
    $hist = history::where('model', 'projets')->orderBy('created_at')->paginate(10); // 10 items per page
    $data = [];
    foreach ($hist as $value) {
        $ar = explode("_", $value->action);
        $pro = Projet::find($value->model_id);
        $time = explode(" ", $value->created_at);
        $data[] = [
            'Action' => $ar[1],
            'User' => [
                'id' => $value->user->id,
                'name' => $value->user->firstName . ' ' . $value->user->lastName,
                'image' => $value->user->image,
            ],
            'project' => [
                'id' => $pro->id,
                'name' => $pro->nom,
            ],
            'Date' => $time[0],
            'Time' => $time[1],
        ];
    }
    return view('History.Hist_pr', ['data' => $data,'hist'=>$hist]);
}
public function history_task()
{
    $hist = history::where('model', 'task')->orderBy('created_at')->paginate(10); // 10 items per page
    $data = [];
    foreach ($hist as $value) {
        $ar = explode("_", $value->action);
        $pro = task::find($value->model_id);
        $time = explode(" ", $value->created_at);
        $data[] = [
            'Action' => $ar[1],
            'User' => [
                'id' => $value->user->id,
                'name' => $value->user->firstName . ' ' . $value->user->lastName,
                'image' => $value->user->image,
            ],
            'task' => [
                'id' => $pro->id,
                'name' => $pro->name,
            ],
            'Date' => $time[0],
            'Time' => $time[1],
        ];
    }
    return view('History.Hist_ta', ['data' => $data,'hist'=>$hist]);
}
    public function history_User()
    {
        $hist = history::where('model', 'User')->orderBy('created_at')->paginate(10); // 10 items per page
        $data = [];
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
        return view('History.Hist_User', ['data' => $data,'hist'=>$hist]);
    }
}
