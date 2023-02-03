<?php

namespace App\Domain\Person;

use App\Domain\AddressPerson\AddressPersonRepository;
use App\Models\AddressPerson;
use App\Models\Person;
use Illuminate\Support\Facades\App;

class PersonService
{
    public function attachAddresses(Person $person, array $data)
    {
        try {
            $pivotRepositoryInterface = App::make(AddressPersonRepository::class);
            $personId = data_get($person, 'id', null);

            if ($personId !== null) {
                collect(data_get($data, 'addresses', []))->map(
                    function ($addressId) use ($personId, $pivotRepositoryInterface) {
                        $pivotRepositoryInterface->insert([
                            'person_id' => $personId,
                            'address_id' => $addressId
                        ]);
                    }
                );
            }

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function detachAddresses(Person $person)
    {
        try {
            $addressesInPerson = App::make(AddressPerson::class)
                ->where('person_id', $person->id)
                ->get();
            if (!empty($addressesInPerson)) {
                collect($addressesInPerson)->map(
                    function ($addressesInPerson) {
                        $addressesInPerson->delete();
                    }
                );
            }

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
