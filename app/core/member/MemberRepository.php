<?php

namespace App\core\member;

use App\core\member\MemberInterface;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use illuminate\Support\Str;

class MemberRepository implements MemberInterface
{
    public function getAllMembers($type = null)
    {
        if ($type && $type == 'stuffs') {
            return Member::query()->where('type', 1)->get();
        }
        if ($type && $type == 'members') {
            return Member::query()->where('type', 0)->get();
        }
        
        return Member::query()->orderByDesc('id');
    }

    public function addNewMember($data)
    {

        if (!empty($data['image'])) {

            $data['image'] = $this->uploadImage($data['image']);
        }
        if (isset($data['type'])) {
            $data['type'] = 1; //stuff
        } else {
            $data['type'] = 0; // not stuff
        }


        $slug = Str::slug($data['name']);
        $slug_count = DB::table('members')->where('slug', $slug)->count();
        if ($slug_count > 0) {
            $slug = random_int(100000, 999999) . '-' . $slug;
        }

        $data['slug'] = $slug;
        return Member::create($data);
    }

    public function uploadImage($memberImage)
    {
        $db_image = time() . rand(0000, 9999) . '.' . $memberImage->getClientOriginalExtension();
        $memberImage->storeAs("public/MemberImage", $db_image);
        return $db_image;
    }

    public function getMember($slug)
    {
        return Member::query()->where('slug', $slug)->first();
    }

    public function updateMember($data, $slug)
    {
        if (!empty($data['image'])) {
            $img = Member::where("slug", $slug)->select('image')->first();
            File::delete("storage/MemberImage/" . $img->image);
            $data['image'] = $this->uploadImage($data['image']);
        }
        return Member::where('slug', $slug)->update($data);
    }
    public function deleteMember($slug)
    {
        return Member::where('slug', $slug)->delete();
    }
}
