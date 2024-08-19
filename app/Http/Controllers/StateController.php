<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\State;
class StateController extends Controller
{
    public function index(){
        $states = State::where("status", "=", "1")->paginate(25);

        return view("states.index",compact("states"));
    }

    public function item($id) {
        $state = State::where("status", "=", "1")->where("id", $id)->first();
        if ($state) {
            return response()->json($state);
        } else {
            return response()->json(['error' => 'State not found'], 404);
        }
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer',
        ]);

        $state = new State();
        $state->name = $validatedData['name'];
        $state->country_id = $validatedData['country_id'];
        $state->status = 1; // Estado activo por defecto
        $state->save();

        return redirect()->route('states')->with('success', 'Estado creado exitosamente.');
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer',
        ]);

        $state = State::findOrFail($id);
        $state->name = $validatedData['name'];
        $state->country_id = $validatedData['country_id'];
        $state->save();

        return response()->json(['response' => 1, 'message' => 'Estado actualizado exitosamente.']);
    }

    public function status(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|numeric'
        ]);
    
        $item = State::where('id', '=', $data['id'])->first();
    
        if ($item) {
            if ($data['status'] == 1) {
                $item->status = 0;
                $message = 'State desactivado exitosamente.';
            } else {
                $item->status = 1;
                $message = 'State reactivado exitosamente.';
            }
            $item->save();
    
            return response()->json(['response' => 1, 'message' => $message, 'state' => $item]);
        } else {
            return response()->json(['response' => 0, 'message' => 'State no encontrado.']);
        }
    }
    
}
