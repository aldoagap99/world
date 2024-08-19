<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Country;

class CountryController extends Controller
{
    public function index(){
        $countries = Country::where("status", "=", "1")->paginate(25);

        return view("countries.index",compact("countries"));
    }

    public function item($id)
{
    $country = Country::where("status", "=", "1")->where("id", $id)->first();

    if (!$country) {
        return response()->json(['error' => 'Country not found'], 404);
    }

    return response()->json($country);
}
    public function store(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'continent' => 'required|string|max:255',
            'population' => 'required|numeric',
            'language' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        // Crear un nuevo país
        Country::create($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('countries')->with('success', 'País agregado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'continent' => 'required|string|max:255',
            'population' => 'required|numeric',
            'language' => 'required|string|max:255',
            'currency' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);
    
        // Encontrar el país por ID
        $country = Country::findOrFail($id);
    
        // Actualizar el país
        $country->update($validatedData);
    
        // Responder con JSON
        return response()->json(['success' => true, 'message' => 'País actualizado exitosamente.']);
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

        // Buscar el país por ID
        $item = Country::where('id', '=', $data['id'])->first();

        if ($item) {
            // Actualizar el estado del país
            if ($data['status'] == 1) {
                $item->status = 0; // Desactivar
                $message = 'País desactivado exitosamente.';
            } else {
                $item->status = 1; // Reactivar
                $message = 'País reactivado exitosamente.';
            }
            $item->save();

            $response = [
                'response' => 1,
                'message' => $message,
                'country' => $item
            ];
        } else {
            $response = [
                'response' => 0,
                'message' => 'País no encontrado.',
            ];
        }

        return response()->json($response);
    }
}
