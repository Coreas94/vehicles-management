<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['brand', 'model', 'license_plate', 'year', 'price', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function vehicleOwnershipHistories(){
        return $this->hasMany(VehicleOwnershipHistory::class);
    }
}