<?php
namespace App\core\expenditure;

use Illuminate\Http\Request;

interface  ExpenditureInterface {
    public function getAllExpenditures(Request $request);
    public function storeExpenditure(array $data);
    public function getExpenditure(int $id);

    public function deleteExpenditure($id);
    public function updateExpenditure($data, $id);
    public function getSeperateExpenditureTotal($type);
}