<?php

namespace App\core\operationschemes;

use App\core\operationschemes\OperationSchemeInterface;
use App\Models\Member;
use App\Models\OperationScheme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use illuminate\Support\Str;

class OperationSchemeRepository implements OperationSchemeInterface
{
    private $operationSchemeModel;
    public function __construct(){
        $this->operationSchemeModel = OperationScheme::query();
    }
    public function getAllOperationSchemes()
    {
        return $this->operationSchemeModel->orderByDesc('id');
    }

    public function addNewOperationScheme($data)
    {
       

        $slug = Str::slug($data['name']);
        $slug_count = DB::table('operation_schemes')->where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = random_int(100000, 999999) . '-' . $slug;
        }
        $data['slug'] = $slug;
        return $this->operationSchemeModel->create($data);
    }

    public function uploadImage($memberImage)
    {
        $db_image = time() . rand(0000, 9999) . '.' . $memberImage->getClientOriginalExtension();
        $memberImage->storeAs("public/MemberImage", $db_image);
        return $db_image;
    }

    public function getOperationScheme($slug) {
        return $this->operationSchemeModel->where('slug', $slug)->first();
    }

    public function updateOperationScheme($data, $slug) {
        
        return $this->operationSchemeModel->where('slug', $slug)->update($data);
    }
    public function deleteOperationScheme($slug){
        return $this->operationSchemeModel->where('slug', $slug)->delete();
    }
}
