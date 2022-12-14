<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicinesection extends Model
{
    use HasFactory;

    protected $fillable=[
        'description',
        'icon',
        'name',
        'id',
        'active'
    ];

    public function drugs(){
        return $this->hasMany(Drug::class);
    }
}
