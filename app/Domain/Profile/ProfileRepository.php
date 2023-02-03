<?php

namespace App\Domain\Profile;

use App\Core\Repository\Repository;
use App\Models\Profile;

class ProfileRepository extends Repository{
    public function __construct(Profile $model)
    {
        return parent::__construct($model);
    }
}
