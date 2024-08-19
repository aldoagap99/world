<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\City;
class CityController extends Controller
{
    public function index(){
        $cities = City::where("status", "=", "1")->paginate(25);

        return view("cities.index",compact("cities"));
    }

    public function item($id){
        $countries = City::where("status", "=", "1")->where("id",$id)->first();
        
        if (!$countries) {
            return response()->json(['error' => 'Country not found'], 404);
        }
    
        return response()->json($countries);

    }
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'state_id' => 'required|numeric',
            'isCapital' => 'required|boolean',
            'status' => 'required|boolean',
        ]);

        // Crear un nuevo país
        City::create($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('cities')->with('success', 'País agregado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validar los datos
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'state_id' => 'required|numeric',
        'isCapital' => 'required|boolean',
    ]);

    // Encontrar la ciudad por ID
    $city = City::findOrFail($id);

    // Actualizar la ciudad
    $city->update($validatedData);

    // Responder con JSON
    return response()->json(['success' => true, 'message' => 'Ciudad actualizada exitosamente.']);
}

    

    /**
     * Remove the specified resource from storage.
     */
    public function status(Request $request)
    {
        // Validar los datos recibidos
        $data = $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|numeric'
        ]);
    
        // Buscar la ciudad por ID
        $item = City::find($data['id']); // Cambio aquí
    
        if ($item) {
            // Actualizar el estado de la ciudad
            if ($data['status'] == 1) {
                $item->status = 0; // Desactivar
                $message = 'Ciudad desactivada exitosamente.';
            } else {
                $item->status = 1; // Reactivar
                $message = 'Ciudad reactivada exitosamente.';
            }
            $item->save();
    
            $response = [
                'response' => 1,
                'message' => $message,
                'City' => $item
            ];
        } else {
            $response = [
                'response' => 0,
                'message' => 'Ciudad no encontrada.',
            ];
        }
    
        return response()->json($response);
    }
}
