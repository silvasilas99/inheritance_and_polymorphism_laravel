<?php

namespace App\Core\Controller;

use App\Core\Repository\RepositoryInterface;
use App\Exceptions\InvalidParameters;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CrudController extends Controller
{
    protected $repository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {
            $data = $this->repository->all();
            return response()->json(
                ['data' => $data]
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

    public function findByDates(Request $req)
    {
        try {
            $startDate = $req->query('startDate', null);
            $endDate = $req->query('endDate', null);

            if (empty($startDate)) {
                throw new InvalidParameters("Start date is invalid.", 400);
            }

            $startDate = Carbon::parse($startDate);
            if ($endDate === null) {
                $endDate = Carbon::now();
            } else {
                $endDate = Carbon::parse($endDate);
            }

            if ($startDate->greaterThan($endDate)) {
                throw new InvalidParameters("Start date can not be greater than end date.", 400);
            }

            $data = $this->repository->findBetweenDates($startDate, $endDate);
            return response()->json(
                ['item' => $data]
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }

    public function store(Request $req)
    {
        try {
            $data = $req->all();
            $newItemId = $this->repository->insert($data);
            return response()->json(
                ['item_id' => $newItemId->id]
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }

    public function update(string $id, Request $req)
    {
        try {
            $data = $req->all();
            $this->repository->update($id, $data);
            return response()->json(
                ['message' => 'Request accepted']
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->repository->delete($id);
            return response()->json(
                ['message' => 'Request accepted']
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => $th->getMessage()]
            );
        }
    }
}
