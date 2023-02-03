<?php

namespace App\Models;

use App\Domain\Person\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = ['postal_code', 'residence_number', 'complement'];

    public function people()
    {
        return $this->belongsToMany(
            Person::class,
            'address_person',
            'address_id',
            'person_id'
        );
    }
}
