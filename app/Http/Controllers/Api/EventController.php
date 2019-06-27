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
        if ($validator->fails()) {          
            return response()->json(['error'=>$input], 400);             
        }    
        $input = $request->all();
        $input['creator_id'] = Auth::user()->id;
        $event = Event::create($input); 
        return response()->json(['success'=>$event], 200);            
    }
    public function getAll(Request $request){
        $user = Auth::user();
        if($request->has('actives') && $request->input('actives')==='true'){
            return Event::where('active', 1)->get();
        }
        else{
            return Event::all();
        }
    }
}
