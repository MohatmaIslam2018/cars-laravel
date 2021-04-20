<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    //this will link will cars table
    protected $table = 'car_models';

    //we can also change the primary key
    protected $primaryKey = 'id';

    //a car model belongs to a Car
    public function car(){
        return $this->belongsTo(Car::class);
    }
}
