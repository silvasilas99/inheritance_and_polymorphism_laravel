<?php

namespace App\Domain\Person;

use App\Core\Repository\Repository;
use App\Models\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;

class PersonRepository extends Repository
{
    public function __construct(Person $model)
    {
        return parent::__construct($model);
    }

    public function findById(string $id)
    {
        $modelInterface = $this->mountAndReturnModelInterface();
        $person = $modelInterface
            ->where('id', $id)
            ->with('addresses')
            ->first();

        if ($person === null) {
            throw new ModelNotFoundException("Person does not exists!", 404);
        }

        return $person;
    }

    protected function afterInsert(array $data, Model $person)
    {
        try {
            App::make(PersonService::class)
                ->attachAddresses($person, $data);
            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function beforeDelete(Model $person)
    {
        App::make(PersonService::class)
            ->detachAddresses($person);
        return true;
    }

    protected function afterUpdate(array $data, Model $person)
    {
        App::make(PersonService::class)
            ->detachAddresses($person);
        App::make(PersonService::class)
            ->attachAddresses($person, $data);

        return true;
    }
}
