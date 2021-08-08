<?php

namespace App\Http\Controllers\Admin\Home;


use App\Http\Controllers\Controller;


use App\Models\Category;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;


class AdminController extends Controller
{

    public function __construct()
    {

    }

    /**
     * show dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home.dashboard');

    }


}//end
