<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = 'patient_id';
    public $timestamps = false;
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany('App\Appointment', 'patient_id');
    }
}
