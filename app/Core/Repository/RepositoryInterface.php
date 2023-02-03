<?php

namespace App\Core\Repository;

use Carbon\Carbon;

interface RepositoryInterface
{
    public function insert(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);

    public function findById(string $id);

    public function findByAttribute(string $attribute, string $searchText);

    public function findBetweenDates(Carbon $startDate, Carbon $endDate);

    public function all();
}
