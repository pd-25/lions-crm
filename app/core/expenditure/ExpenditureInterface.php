<?php
namespace App\core\expenditure;

interface  ExpenditureInterface {
    public function getAllExpenditures();
    public function storeExpenditure(array $data);
    public function getExpenditure(int $id);

    // public function deleteExpenditure($slug);
    // public function updateExpenditure($data, $slug);
}