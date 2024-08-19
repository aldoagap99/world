<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function list(){
        $cities = City::orderBy('name', 'ASC')->whereget();
        $list = [];
        foreach($cities as $city){
            $object = [
                'id' => $city->id,
                'name' => $city->name,
                'state_id' => $city->state_id,
                'isCapital' => $city->isCapital,
                "status"=> $city->status
            ];
            array_push($list, $object);
        }
            return response()->json($list);
    }
	public function item($id) {

    	$city = City::findOrFail($id);

    	$object = [
        	'id' => $city->id,
        	'name' => $city->name,
        	'state_id' => $city->state_id,
        	'isCapital' => $city->isCapital,
            "status"=> $city->status,
        	'created_at' => $city->created_at,
        	'updated_at' => $city->updated_at,
    	];

    	return response()->json($object);
	}


    public function create(Request $request) {

    	$data = $request->validate([
        	'name' => 'required',
        	'state_id' => 'required',
        	'isCapital' => 'required',
    	]);
   	 
    	$city = City::create([
        	'name' => $data['name'],
        	'state_id' => $data['state_id'],
        	'isCapital' => $data['isCapital'],
    	]);

    	if($city) {

        	$response = [
            	'response' => 1,
            	'message' => 'city created successfully',
            	'city' => $city
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
        	'state_id' => 'required',
        	'isCapital' => 'required',
            "status"=> "required",
    	]);

    	$city = City::where('id', '=', $data['id'])->first();

    	$city->name = $data['name'];
    	$city->state_id = $data['state_id'];
    	$city->isCapital = $data['isCapital'];
        $city->status = $data["status"];



    	if($city->save()) {

        	$city->refresh();

        	$response = [
            	'response' => 1,
            	'message' => 'city updated successfully successfully',
            	'city' => $city
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
        $city = City::findOrFail($id);

        $city->status = 0;
        if ($city->save()) {
            $response = [
                'response' => 1,
                'message' => 'city deleted successfully',
            ];
            return response()->json($response);
        } else {
            $response = [
                'response' => 0,
                'message' => 'There was an error deleting the city',
            ];
            return response()->json($response);
        }
	}

}