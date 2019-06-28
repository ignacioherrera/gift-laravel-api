<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use App\Event;
use Illuminate\Support\Facades\Auth; 
use Validator;

class EventController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'event_date' => 'required'
        ]);
        $input = $request->all();   
        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 400);             
        }
        if(($input['for_user']===true || $input['for_user']==='true') && $input['user_id']==''){
            return response()->json(['error'=>['user_id'=>'The user is required']], 400);  
        } 
        
        $input['creator_id'] = Auth::user()->id;
        $event = Event::create($input); 
        return response()->json(['success'=>$event], 200);            
    }
    public function getAll(Request $request){
        $user = Auth::user();
        if($request->has('actives') && $request->input('actives')==='true'){
            $events = Event::where('active', 1)->get();
            return response()->json(['success'=>$events], 200);     
        }
        else{
            $events = Event::all();
            return response()->json(['success'=>$events], 200);     
        }
    }
}
