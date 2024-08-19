<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function list(){
        $states = State::orderBy('name', 'ASC')->get();
        $list = [];
       
        foreach($states as $state){
            $object = [
                'id' => $state->id,
                'name' => $state->name,
                'country' => $state->country_id,
				"status"=> $state->status
            ];
            array_push($list, $object);
        }
            return response()->json($list);
    }
    public function item($id) {

    	$state = State::findOrFail($id);

	

    	$object = [
        	'id' => $state->id,
            'name' => $state->name,
        	'country' => $state->country_id,
        	'created_at' => $state->created_at,
        	'updated_at' => $state->updated_at,
			"status"=> $state->status
    	];

    	return response()->json($object);
	}


    public function create(Request $request) {

    	$data = $request->validate([
        	'name' => 'required',
        	'country_id' => 'required',
    	]);
   	 
    	$state = State::create([

        	'name' => $data['name'],
        	'country_id' => $data['country_id'],

    	]);

    	if($state) {

        	$response = [
            	'response' => 1,
            	'message' => 'state created successfully',
            	'state' => $state
        	];

        	return response()->json($response);
    	} else {
        	$response = [
            	'response' => 0,
            	'message' => 'There was an error saving data',
        	];
    	}
	}

    
    public function update(Request $request) {


    	$data = $request->validate([
            'id' => 'required',
        	'name' => 'required',
        	'country_id' => 'required',
			"status"=> "required"
    	]);

    	$state = State::where('id', '=', $data['id'])->first();
    	$state->id = $data['id'];
    	$state->name = $data['name'];
    	$state->country_id = $data['country_id'];
		$state->status = $data['status'];


    	if($state->save()) {

        	$state->refresh();

        	$response = [
            	'response' => 1,
            	'message' => 'state updated successfully successfully',
            	'state' => $state
        	];

        	return response()->json($response);
    	} else {
        	$response = [
            	'response' => 0,
            	'message' => 'There was an error saving data',
        	];
    	}
	}

	public function delete($id) {
        $state = State::findOrFail($id);
		
		$state->status = 0;
		
        if ($state->save()) {
            $response = [
                'response' => 1,
                'message' => 'state deleted successfully',
            ];
            return response()->json($response);
        } else {
            $response = [
                'response' => 0,
                'message' => 'There was an error deleting the state',
            ];
            return response()->json($response);
        }
    }

}