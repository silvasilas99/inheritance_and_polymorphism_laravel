<?php

namespace App\Domain\Person;

use App\Core\Controller\CrudController;

class PersonController extends CrudController
{
    private const NAME_ATTRIBUTE = "name";
    private const SSN_ATTRIBUTE = "social_security_number";

    public function __construct(PersonRepository $repository)
    {
        return parent::__construct($repository);
    }

    public function findByName(string $term)
    {
        try {
            $item = $this->repository
                ->findByAttribute(self::NAME_ATTRIBUTE, $term);
            return response()->json(
                ['item' => $item]
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }

    public function findBySsn(string $term)
    {
        try {
            $item = $this->repository
                ->findByAttribute(self::SSN_ATTRIBUTE, $term);
            return response()->json(
                ['item' => $item]
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }

    public function findById(string $id)
    {
        try {
            $item = $this->repository->findById($id);
            return response()->json(
                ['item' => $item]
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }
}
