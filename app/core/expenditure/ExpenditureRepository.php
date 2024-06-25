<?php

namespace App\core\expenditure;

use App\Models\Expenditure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use illuminate\Support\Str;

class ExpenditureRepository implements ExpenditureInterface
{
    public function getAllExpenditures()
    {
        return Expenditure::query()->orderByDesc('id');
    }

    public function storeExpenditure(array $data)
    {
        $store = Expenditure::create($data);
        if ($store instanceof Expenditure) {
            return true;
        } else {
            return false;
        }
    }

    public function getExpenditure(int $id)
    {
        return Expenditure::firstOrFail($id);
    }
}
