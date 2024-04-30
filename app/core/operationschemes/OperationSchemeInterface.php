<?php
namespace App\core\operationschemes;

interface OperationSchemeInterface {
    public function getAllOperationSchemes();
    public function addNewOperationScheme($data);
    public function getOperationScheme($slug);
    public function deleteOperationScheme($slug);
    public function updateOperationScheme($data, $slug);
}