<?php

namespace App\Domain\Address;

use App\Core\Controller\CrudController;

class AddressController extends CrudController
{
    public function __construct(AddressRepository $repository)
    {
        return parent::__construct($repository);
    }
}
