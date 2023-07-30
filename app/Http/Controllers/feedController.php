<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\feedback;
use App\Models\task;
use Illuminate\Http\Request;

class feedController extends Controller
{
    public function  add(Request $request){
        try{
            $feed=feedback::create(
                [
                    'content'=>$request->message,
                    'user_id'=>auth()->user()->id,
                    'tag_id'=>$request->tag_id,
                ]
                );
                logAction('feedback_created', auth()->user()->id, 'feedback', $feed->id, json_encode($feed));
        }catch(Exception $e) {
            dd($e);
        }

        
        return 'feedback est ajouter';
    }
    public function get_feed_back(Request $request)
    {

        $feedback = feedback::where('tag_id', $request->id_tag)->get();
        $data = array();
        foreach ($feedback as $item) {
            
            $ele = [
                'feedback' => $item->content,
                'date' => $item->created_at,
                'author' => $item->user->firstName.' '.$item->user->lastName,
                'email' => $item->user->email,
                'id_feed'=> $item->id,
                'image'=>(!is_null($item->user->image))?asset("storage/".$item->user->image):asset("storage/logos/inconnue.jpeg")
            ];
            array_push($data, $ele);
        }
        return response()->json($data);
    }
}
