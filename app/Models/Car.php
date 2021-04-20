<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;



    //this will link will cars table
    protected $table = 'cars';

    //we can also change the primary key
    protected $primaryKey = 'id';

    //we can also make a column disable the timestamps
    //public $timestamps = true;

    //We are using it to store function since we are using create()
    //We are saying which item can be mass assigned
    protected $fillable = ['name', 'founded', 'description', 'image_path', 'user_id'];

    //method to hidden certain property
    //protected $hidden = ['name'];


    //method to hidden certain property
    //this is only show the column we want to show it to the user
    //protected $visible = ['founded'];

    //Car has many car_models
    public function carmodels(){
        return $this->hasMany(CarModel::class);
    }

    //One to one relationship between car and headquater
    //So every car has one headquater
    public function headquater(){
        return $this->hasOne(Headquater::class);
    }

    //Define a has many through relationship
    public function engines(){
        return $this->hasManyThrough(
                        Engine::class, 
                        CarModel::class,
                        'car_id', //Foreign key on CarModel table
                        'model_id'
                    );
    }

    //Define a has one through relationship
    public function productionDate(){
        return $this->hasOneThrough(
            CarProductionDate::class,
            CarModel::class,
            'car_id',
            'model_id'
        );
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }
}
