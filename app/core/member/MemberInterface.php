<?php
namespace App\core\member;

interface MemberInterface {
    public function getAllMembers($type= null);
    public function addNewMember($data);
    public function getMember($slug);
    public function deleteMember($slug);
    public function updateMember($data, $slug);
}