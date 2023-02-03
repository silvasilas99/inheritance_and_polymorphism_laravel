<?php

namespace App\Domain\Profile;

use App\Core\Controller\CrudController;

class ProfileController extends CrudController
{
    public function __construct(ProfileRepository $repository)
    {
        return parent::__construct($repository);
    }
}
