<?php

namespace App\Domain\Address;

use App\Core\Repository\Repository;
use App\Models\Address;

class AddressRepository extends Repository{
    public function __construct(Address $model)
    {
        return parent::__construct($model);
    }
}
