<?php

namespace App\Core\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\App;
use Throwable;

class Repository implements RepositoryInterface
{
    protected $model;
    protected $timestapAttribute = 'created_at';

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $modelInterface = $this->mountAndReturnModelInterface();
        return $modelInterface->all();
    }

    public function findBetweenDates(Carbon $startDate, Carbon $endDate)
    {
        $modelInterface = $this->mountAndReturnModelInterface();
        return $modelInterface
            ->whereBetween(
                $this->timestapAttribute,
                [
                    $startDate->toAtomString(),
                    $endDate->toAtomString()
                ]
            )
            ->get();
    }

    public function findByAttribute(string $attribute, string $searchText)
    {
        $modelInterface = $this->mountAndReturnModelInterface();
        return $modelInterface
            ->where($attribute, 'LIKE', '%' . $searchText . '%')
            ->get();
    }

    public function findById(string $id)
    {
        return $this->checkItemByIdAndReturnIfExists($id);
    }

    public function insert(array $data)
    {
        try {
            $modelInterface = $this->mountAndReturnModelInterface();
            $newItem = $modelInterface->create($data);
            $this->afterInsert($data, $newItem);
            return $newItem;
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function update(string $id, array $data)
    {
        try {
            $model = $this->checkItemByIdAndReturnIfExists($id);
            if ($model !== null) {
                $model->update($data);
                $this->afterUpdate($data, $model);
            }
        } catch (Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        try {
            $model = $this->checkItemByIdAndReturnIfExists($id);
            $this->beforeDelete($model);
            $model->delete();

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function beforeDelete(Model $model)
    {
        return true;
    }

    protected function afterInsert(array $data, Model $model)
    {
        return true;
    }

    protected function afterUpdate(array $data, Model $model)
    {
        return true;
    }

    protected function mountAndReturnModelInterface()
    {
        $model = clone $this->model;
        return App::make($model::class);
    }

    protected function checkItemByIdAndReturnIfExists(string $id)
    {
        $modelInterface = $this->mountAndReturnModelInterface();
        $item = $modelInterface->find($id);
        if ($item === null) {
            throw new ModelNotFoundException("Item not found", 404);
        }
        return $item;
    }
}
