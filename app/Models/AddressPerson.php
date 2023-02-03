<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressPerson extends Model
{
    use HasFactory;

    protected $fillable = ['person_id', 'address_id'];
    protected $table = 'address_person';
}
