<?php

namespace App\Http\Controllers\Admin\Home;


use App\Http\Controllers\Controller;


use App\Models\Category;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
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
        $data['month_cost'] = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_cost');

        $data['week_cost'] = Order::whereBetween('created_at',
            [Carbon::now()->subWeek()->format("Y-m-d H:i:s"), Carbon::now()])
            ->sum('total_cost');

        $data['daily_cost'] = Order::whereDate('created_at',date("Y-m-d"))->sum('total_cost');

        $data['all_cost'] = Order::sum('total_cost');

        return view('admin.home.dashboard',$data);

    }


}//end
