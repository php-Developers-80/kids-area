<?php


use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;



if (!function_exists('setting')) {
    function setting() {
        return \App\Models\Setting::orderBy('id', 'desc')->first();
    }
}

if (!function_exists('dynamic_sliders')) {
    function dynamic_sliders() {
        return \App\Models\DynamicSlider::whereNull('parent_id')->OrderBy('order_number','asc')->get();
    }
}

if (!function_exists('years_between_two_date')) {
    function years_between_two_date($first) {
        $d1 = new DateTime($first);
        $d2 = new DateTime(date('Y-m-d'));

        $diff = $d2->diff($d1);

        return $diff->y;
    }
}

if (!function_exists('admin')) {
    function admin() {
        return auth()->guard('admin');
    }


}
if (!function_exists('user')) {
    function user() {
        return auth()->guard('user');
    }
}

if (!function_exists('aurl')) {
    function aurl($url = null) {
        return url('admin/'.$url);
    }
}

if (!function_exists('get_file')) {
    function get_file($file){
        if ($file){
            $file_path=asset('storage/uploads').'/'.$file;
        }else{
            $file_path=asset('admin/no_image.png');
        }
        return $file_path;
    }//end
}


if (!function_exists('permissionsList')) {
    function permissionsList()
    {
        return \App\Models\User::findOrFail(auth()->user()->id)
            ->permissions()
            ->pluck('name')->toArray();
    }
}

if (!function_exists('checkAdminHavePermission')) {
    function checkAdminHavePermission($permission_name)
    {
        if (in_array($permission_name,\App\Models\User::findOrFail(auth()->user()->id)
            ->permissions()
            ->pluck('name')
            ->toArray()))
        {
            return true;
        }
        return false;

    }
}


if (!function_exists('nameDays')) {
   function nameDays($nameday)
   {

       switch($nameday) {

           case "Saturday":
               $nameday = "ألسبت";
               break;


           case "Sunday":
               $nameday = "الأحد";
               break;

           case "Monday":
               $nameday = "الإثنين";
               break;

           case "Tuesday":
               $nameday = "الثلاثاء";
               break;

           case "Wednesday":
               $nameday = "الأربعاء";
               break;

           case "Thursday":
               $nameday = "الخميس";
               break;


           case "Friday":
               $nameday = "الجمعة";
               break;


       }

       return $nameday;
   }
}
if (!function_exists('delete_file')) {
    function delete_file($file) {
        Storage::delete('/public/' .'uploads/'.$file);
    }
}





