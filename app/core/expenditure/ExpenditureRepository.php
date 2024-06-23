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

   
}
