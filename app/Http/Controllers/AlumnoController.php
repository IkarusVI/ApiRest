<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumnos;

use function PHPUnit\Framework\isEmpty;

class AlumnoController extends Controller{
    public function getAlumno(Request $request){
        $id = $request->input("id");
        $alumno = Alumnos::find($id);

        if ($alumno) {
            return response()->json($alumno);
        }
        $error = [
            "Status" => "Failed",
            "Message" => "Alumno no encontrado"
        ];
        return response()->json($error);
    }

    public function getAlumnos(){
        $alumnos = Alumnos::get();
        return response()->json($alumnos);
    }
    
    public function deleteAlumno(Request $request){
        $id = $request->input("id");

        $filasEliminadas = Alumnos::where('id', $id)->delete();

        if ($filasEliminadas > 0) {
            $result = [
                "Status" => "Sucesss",
                "Message" => "Alumno eliminado correctamente"
            ];
            return response()->json($result);
        }
        $result = [
            "Status" => "Failed",
            "Message" => "No se pudo eliminar el alumno ya que no se encontró en la base de datos"
        ];
        return response()->json($result);
    }

    public function createAlumno(Request $request){
    
        try {
            $request->validate([
                'nombre' => 'required|string',
                'telefono' => 'required|string',
                'edad' => 'required|integer',
                'password' => 'required|string',
                'email' => 'required|email|unique:alumnos,email',
                'sexo' => 'required|in:male,female',
            ]);
            Alumnos::create([
                'nombre' => $request->input('nombre'),
                'telefono' => $request->input('telefono'),
                'edad' => $request->input('edad'),
                'password' => bcrypt($request->input('password')),
                'email' => $request->input('email'),
                'sexo' => $request->input('sexo'),
            ]);
        } catch (\Exception $e) {
            $result = [
                "Status" => "Failed",
                "Message" => $e->getMessage()
            ];
            return response()->json($result);
        }
        $result = [
            "Status" => "Success",
            "Message" => "Alumno creado correctamente"
        ];
        return response()->json($result);
    }

    public function modifyAlumno(Request $request){
        $id = $request->input("id");
        $alumno = Alumnos::find($id);

        if ($alumno) {
            try {
                $request->validate([
                    'nombre' => 'string',
                    'telefono' => 'string',
                    'edad' => 'integer',
                    'password' => 'string',
                    'email' => 'email|unique:alumnos,email,' . $id,
                    'sexo' => 'in:male,female',
                ]);
                $dataToUpdate = array_filter($request->only([
                    'nombre', 'telefono', 'edad', 'password', 'email', 'sexo'
                ]), function ($value) {
                    return !is_null($value);
                });
    
                if(empty($dataToUpdate)){
                    $result = [
                        "Status" => "Failed",
                        "Message" => "Debes proporcionar al menos un dato para modificar el usuario"
                    ];
                    return response()->json($result);
                }

                $alumno->update($dataToUpdate);
                $result = [
                    "Status" => "Success",
                    "Message" => "Alumno modificado correctamente"
                ];
                return response()->json($result);

            } catch (\Exception $e) {
                $result = [
                    "Status" => "Success",
                    "Message" => $e->getMessage()
                ];
                return response()->json($result);
            }
        }
        $result = [
            "Status" => "Failed",
            "Message" => "El alumno con esta id no existe y por ello no se puede modificar"
        ];
        return response()->json($result);
    }
}