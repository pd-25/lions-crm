<?php
namespace App\core\patient;

interface PatientInterface {
    public function getAllPatients($request);
    public function getSinglePatient($slug);
    
    // public function addNewMember($data);
    // public function getMember($slug);
    // public function deleteMember($slug);
    // public function updateMember($data, $slug);
}