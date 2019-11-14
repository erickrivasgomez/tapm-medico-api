<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Patient;
use App\Http\Requests\RegisterPatient;

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
        $reglas = array(
            'nombre' => 'required',
        );

        $validator = Validator::make($request->all(), $reglas);
        $validacion = $validator->validate();

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
            
        } else {
            return response()->json($request->all());

            $patient = Patient::create([
                'nombre' => \request('nombre'),
                'email' => \request('email'),
                'password' => \request('password'),
            ]);
        }
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
