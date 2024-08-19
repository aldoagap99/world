<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;


class CountryController extends Controller {
    
	public function list() {

    		$countries = Country::orderBy('name', 'asc')->get();

    		$list = [];

    		foreach ($countries as $country) {

        	$object = [
            	'id' => $country->id,
            	'name' => $country->name,
            	'continent' => $this->getContinentName($country),
            	'population' => $country->population,
            	'language' => $country->language,
            	'currency' => $country->currency,
                "status"=> $country->status
        	];

        		array_push($list, $object);
    		}

    		return response()->json($list);
	}

	public function item($id) {

    	$country = Country::findOrFail($id);

    	$object = [
        	'id' => $country->id,
        	'name' => $country->name,
        	'continent' => $country->continent,
        	'language' => $country->language,
        	'currency' => $country->currency,
        	'created_at' => $country->created_at,
        	'updated_at' => $country->updated_at,
            "status"=> $country->status
    	];

    	return response()->json($object);
	}

	public function create(Request $request) {

    	$data = $request->validate([
            'name' => 'required',
        	'continent' => 'required|numeric',
        	'population' => 'required',
        	'language' => 'required',
        	'currency' => 'required',
    	]);
   	 
    	$country = Country::create([
            'name'=> $data['name'],
        	'continent' => $data['continent'],
        	'population' => $data['population'],
        	'language' => $data['language'],
        	'currency' => $data['currency'],
    	]);

    	if($country) {

        	$response = [
            	'response' => 1,
            	'message' => 'country created successfully',
            	'country' => $country
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
        	'id' => 'required|numeric',
            'name' => 'required',
        	'continent' => 'required|numeric',
        	'population' => 'required',
        	'language' => 'required',
        	'currency' => 'required',
            "status"=> "required"
    	]);

    	$country = Country::where('id', '=', $data['id'])->first();

    	$country->name = $data['name'];
    	$country->continent = $data['continent'];
    	$country->population = $data['population'];
    	$country->language = $data['language'];
    	$country->currency = $data['currency'];
        $country->status = $data['status'];

    	if($country->save()) {

        	$country->refresh();

        	$response = [
            	'response' => 1,
            	'message' => 'country updated successfully successfully',
            	'country' => $country
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
		$country = Country::findOrFail($id);
	
		// Cambiar el valor de 'status' de 1 a 0
		$country->status = 0;
	
		if ($country->save()) {
			$response = [
				'response' => 1,
				'message' => 'country status updated to 0 successfully',
			];
			return response()->json($response);
		} else {
			$response = [
				'response' => 0,
				'message' => 'There was an error updating the country status',
			];
			return response()->json($response);
		}
	}
	public function getContinentName($country) {

    	switch ($country->continent) {
        	case 1:
            	$continent_name = 'África';
            	break;
        	case 2:
            	$continent_name = 'Antartida';
            	break;
        	case 3:
            	$continent_name = 'Norteamérica';
            	break;
        	case 4:
            	$continent_name = 'Sudamérica';
            	break;
        	case 5:
            	$continent_name = 'Asia';
            	break;
        	case 6:
            	$continent_name = 'Europa';
            	break;
        	case 7:
            	$continent_name = 'Oceanía';
            	break;
        	default:
            	$continent_name = 'Pangea';
            	break;
    	}

    	return $continent_name;
	}
}