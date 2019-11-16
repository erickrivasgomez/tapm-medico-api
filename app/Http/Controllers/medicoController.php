<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use App\Patient;
use App\Http\Requests\RegisterPatient;
use App\Http\Requests\GetPatientAppointments;
use App\Http\Requests\LoginPatient;

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
    public function registerPatient(RegisterPatient $request)
    {
        $respuesta = null;

        $patient = Patient::create([
            "nombre" => $request->input('nombre'),
            "username" => $request->input('username'),
            "password" => bcrypt($request->input('password'))
        ]);

        $respuesta = array([
            "message" => "¡Paciente registrado correctamente!",
            "data" => [
                "paciente" => [
                    "nombre" => $patient->nombre,
                    "username" => $request->username,
                ]
            ]
        ]);
        return $respuesta;
    }

    public function loginPatient(LoginPatient $request)
    {
        $respuesta = null;
        $patient = Patient::where('username', $request->input('username'))->first();

        if (Hash::check($request->input('password'), $patient->password)) {
            $respuesta = array([
                "message" => "¡Sesión iniciada con éxito!",
                "data" => [
                    "paciente" => [
                        "patient_id" => $patient->patient_id,
                        "nombre" => $patient->nombre,
                        "username" => $patient->username,
                    ]
                ]
            ]);
        } else {
            $respuesta = array([
                "message" => "Contraseña incorrecta.",
                "data" => []
            ]);
        }

        return $respuesta;
    }

    public function getPatientAppointments(GetPatientAppointments $request)
    {
        $respuesta = null;
        $patient = Patient::find($request->input('patient_id'));

        $respuesta = array([
            "message" => "Citas obtenidas correctamente.",
            "data" => [
                "citas" => $patient->appointments,
            ]
        ]);

        return $respuesta;
    }

    public function rp(RegisterPatient $request)
    {
        $reglas = array(
            'nombre' => 'required',
        );

        $validator = Validator::make($request->all(), $reglas);
        $validacion = $validator->validate();

        if ($validator->fails()) {
            return $validacion->errors();
        } else {
            return $request->all();
        }
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
