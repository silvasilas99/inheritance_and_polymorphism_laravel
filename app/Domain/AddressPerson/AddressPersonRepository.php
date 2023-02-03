<?php

namespace App\Domain\AddressPerson;

use App\Core\Repository\Repository;
use App\Models\AddressPerson;

class AddressPersonRepository extends Repository{
    public function __construct(AddressPerson $model)
    {
        return parent::__construct($model);
    }
}
