<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Patient;

class medicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerPatient(Request $request)
    {
        $respuesta = null;

        $reglas = [
            'nombre' => 'required|max:30',
            'username' => 'required|max:20|unique:patients',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $reglas);
        if ($validator->fails()) {
            $respuesta = json_encode([
                "message" => "Error en datos enviados",
                "errors" => $validator->errors(),
                "data" => []
            ]);
            return $respuesta;
        }

        $patient = Patient::create([
            "nombre" => $request->input('nombre'),
            "username" => $request->input('username'),
            "password" => bcrypt($request->input('password'))
        ]);

        $respuesta = json_encode([
            "message" => "¡Paciente registrado correctamente!",
            "errors" => [],
            "data" => [
                "paciente" => [
                    "nombre" => $patient->nombre,
                    "username" => $request->username,
                ]
            ]
        ]);
        return $respuesta;
    }

    public function loginPatient(Request $request)
    {
        $respuesta = null;

        $reglas = [
            'username' => 'required|exists:patients',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $reglas);

        if ($validator->fails()) {
            $respuesta = json_encode([
                "message" => "Error en datos enviados",
                "errors" => $validator->errors(),
                "data" => []
            ]);
            return $respuesta;
        }

        $patient = Patient::where('username', $request->input('username'))->first();

        if (Hash::check($request->input('password'), $patient->password)) {
            $respuesta = json_encode([
                "message" => "¡Sesión iniciada con éxito!",
                "errors" => [],
                "data" => [
                    "paciente" => [
                        "patient_id" => $patient->patient_id,
                        "nombre" => $patient->nombre,
                        "username" => $patient->username,
                    ]
                ]
            ]);
        } else {
            $respuesta = json_encode([
                "message" => "Contraseña incorrecta.",
                "errors" => [
                    "Contraseña" => [
                        "Contraseña incorrecta."
                    ]
                ],
                "data" => []
            ]);
        }

        return $respuesta;
    }

    public function getPatientAppointments(Request $request)
    {
        $respuesta = null;

        $reglas = [
            'patient_id' => 'required|exists:patients',
        ];
        $validator = Validator::make($request->all(), $reglas);
        if ($validator->fails()) {
            $respuesta = json_encode([
                "message" => "Error en datos enviados",
                "errors" => $validator->errors(),
                "data" => []
            ]);
            return $respuesta;
        }

        $patient = Patient::find($request->input('patient_id'));

        $respuesta = json_encode([
            "message" => "Citas obtenidas correctamente.",
            "errors" => [],
            "data" => [
                "citas" => $patient->appointments,
            ]
        ]);

        return $respuesta;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
