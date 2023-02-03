<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'mail', 'social_security_number', 'profile_id'];

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function addresses()
    {
        return $this->belongsToMany(
            Address::class,
            'address_person',
            'person_id',
            'address_id'
        );
    }
}
