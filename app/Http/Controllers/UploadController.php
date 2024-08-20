<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function index()
    {
        return view("upload.index");
    }


    public function uploadDataFromText(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:txt',
        ]);
    
        $file = $request->file('file');
        $lines = file($file->getRealPath(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        $inserted = 0;
        $failed = 0;
        $alreadyExists = 0;
    
        DB::beginTransaction();
    
        try {
            foreach ($lines as $line) {
                // Depuración: Ver el contenido de la línea
                Log::info("Línea procesada: " . $line);
    
                // Validar el formato del INSERT y capturar tabla, columnas y valores
                if (preg_match('/INSERT INTO (\w+) \((.+)\) VALUES \((.+)\);/', $line, $matches)) {
                    $table = $matches[1];
                    $columns = array_map('trim', explode(',', str_replace('`', '', $matches[2])));
                    $values = array_map('trim', explode(',', str_replace(['\'', '"'], '', $matches[3])));
    
                    // Crear array de datos sin espacios innecesarios
                    $data = array_combine($columns, $values);
    
                    // Depuración: Ver los datos procesados
                    Log::info("Datos procesados para la tabla $table: ", $data);
    
                    // Verificar si el registro ya existe basado en todos los campos relevantes
                    $query = DB::table($table)
                        ->where(function($query) use ($data) {
                            foreach ($data as $column => $value) {
                                $query->where($column, $value);
                            }
                        })->first();
    
                    if ($query) {
                        $alreadyExists++;
                        Log::info("Registro ya existe en la tabla $table: ", $data);
                    } else {
                        $result = DB::table($table)->insert($data);
    
                        if ($result) {
                            $inserted++;
                            Log::info("Registro insertado en la tabla $table: ", $data);
                        } else {
                            $failed++;
                            Log::error("Error al insertar el registro en la tabla $table: ", $data);
                        }
                    }
                } else {
                    // Depuración: Ver líneas que no coinciden con el patrón esperado
                    Log::warning("Línea no coincide con el patrón esperado: " . $line);
                }
            }
    
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
    
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Ocurrió un error durante la carga de datos.',
                    'error' => $e->getMessage()
                ], 500);
            } else {
                return redirect()->route('archivo')->with('error', 'Ocurrió un error durante la carga de datos: ' . $e->getMessage());
            }
        }
    
        $total = $inserted + $alreadyExists + $failed;
    
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Carga de datos completada.',
                'inserted' => $inserted,
                'already_exists' => $alreadyExists,
                'failed' => $failed,
                'total' => $total
            ]);
        } else {
            return redirect()->route('archivo')->with('success', "Carga de datos completada. Insertados: $inserted, Ya existentes: $alreadyExists, Fallidos: $failed, Total: $total.");
        }
    }
    

}
