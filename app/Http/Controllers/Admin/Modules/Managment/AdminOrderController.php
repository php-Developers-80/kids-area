<?php

namespace App\Http\Controllers\Admin\Modules\Managment;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminOrderController extends Controller
{
    //my traits
    use Upload_Files;
    use LogActivityTrait;


    public function __construct()
    {
        $this->middleware([('permission:ordersIndex,web')])->only(['index']);
        $this->middleware([('permission:ordersAdding,web')])->only(['create']);
        $this->middleware([('permission:ordersEditing,web')])->only(['edit']);
        $this->middleware([('permission:ordersSingleDeleting,web')])->only(['destroy']);
        $this->middleware([('permission:ordersMultiDeleting,web')])->only(['delete_all']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * return all Clients
     *
     */

    public function index(Request $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة كل الطلبات ');

        //return all orders
        if ($request->ajax()) {
            $orders = Order::latest();
            if (isset($request->date) && !is_null($request->date)) {
               $orders = $orders->whereDate("created_at",date("Y-m-d"));
            }
            $orders  = $orders->get();

            return DataTables::of($orders)

                ->editColumn('created_at', function ($order) {
                    return date('Y/m/d',strtotime($order->created_at));
                })

                ->addColumn('name', function ($order) {
                    return $order->customer? $order->customer->name:"";
                })

                ->addColumn('phone', function ($order) {
                    return $order->customer? $order->customer->phone:"";
                })

                ->addColumn('creator', function ($order) {
                    return $order->creator? $order->creator->name:"";
                })

                ->editColumn('created_at', function ($order) {
                    return date('Y/m/d',strtotime($order->created_at));
                })

                ->addColumn('delete_all', function ($order) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $order->id . "'>";
                })
                ->addColumn('actions', function ($order) {

                    return " <a  target='_blank' class='btn mb-2 btn-secondary ' href='" . route('cashier.show',$order->id) . "'> <i class='fad fa-eye'></i></a>
                   <button class='btn mb-2 btn-danger  delete' id='" . $order->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['actions','delete_all','created_at','name','phone','creator'])->make(true);

        }//end request
        $customers = Customer::whereNull('parent_id')->get();
        $users = User::where('user_type','cashier')->get();
        return view('admin.modules.managements.orders.index',[
            'customers'=>$customers,
            'users'=>$users,
        ]);
    }//end fun

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     *
     *
     */
    public function store(Request $request)
    {

    }//end fun



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */

    public function edit(Request $request , $id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     */
    public function update(Request $request,$id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * delete
     *
     */
    public function destroy($id)
    {
        //log activities
        $order = Order::findOrFail($id);
        $this->add_log_activity($order,auth()->user()," تم حذف  الطلب {$order->id}");

        //delete single row
        return response()->json(Order::destroy($id),200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * multi delete
     *
     */

    public function delete_all(Request $request)
    {
        //log activities
        if (isset($request->id)&&is_array($request->id)) {
            foreach ($request->id as $id){
                $order = Order::findOrFail($id);
                $this->add_log_activity($order,auth()->user()," تم حذف  الطلب {$order->id}");
            }
        }

        //delete all
        Order::destroy($request->id);
        return response()->json(1,200);
    }//end fun


    public function filter(Request $request)
    {
        $orders = Order::FilterByDate($request->get('from'),$request->get('to'))
            ->FilterByCode($request->get('code'))
            ->FilterByMoney($request->get('from_money'),$request->get('to_money'))
            ->FilterByUserId($request->get('user_id'))
            ->FilterByClientId($request->get('customer_id'))
            ->latest()
            ->get();

        return DataTables::of($orders)

            ->editColumn('created_at', function ($order) {
                return date('Y/m/d',strtotime($order->created_at));
            })

            ->addColumn('name', function ($order) {
                return $order->customer? $order->customer->name:"";
            })

            ->addColumn('phone', function ($order) {
                return $order->customer? $order->customer->phone:"";
            })

            ->addColumn('creator', function ($order) {
                return $order->creator? $order->creator->name:"";
            })

            ->editColumn('created_at', function ($order) {
                return date('Y/m/d',strtotime($order->created_at));
            })

            ->addColumn('delete_all', function ($order) {
                return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $order->id . "'>";
            })
            ->addColumn('actions', function ($order) {

                return " <a  target='_blank' class='btn mb-2 btn-secondary ' href='" . route('cashier.show',$order->id) . "'> <i class='fad fa-eye'></i></a>
                   <button class='btn mb-2 btn-danger  delete' id='" . $order->id . "'><i class='fad fa-trash'></i> </button>";
            })->rawColumns(['actions','delete_all','created_at','name','phone','creator'])->make(true);



    }//end function

}//end class
