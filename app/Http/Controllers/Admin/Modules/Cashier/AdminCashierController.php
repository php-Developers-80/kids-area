<?php

namespace App\Http\Controllers\Admin\Modules\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\AddOn;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderAddOn;
use App\Models\OrderDetail;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class AdminCashierController extends Controller
{

    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware([('permission:cashier,web')])->only(['index']);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     * Cashier Index
     *
     */
    public function index(Request $request)
    {

        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة الكاشير');

        if ($request->ajax()) {
            $orders = Order::whereDate('created_at','=',date("Y-m-d"))
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
                   <button hidden class='btn mb-2 btn-danger  delete' id='" . $order->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['actions','delete_all','created_at','name','phone','creator'])->make(true);

        }//end request

        $customers = Customer::whereNull('parent_id')->get();
        $tickets = Ticket::where('is_shown','shown')->get();
        $addOns = AddOn::where('is_shown','shown')->get();

        return view('admin.modules.cashier.index',[
            'customers'=>$customers,
            'tickets'=>$tickets,
            'addOns'=>$addOns,
        ]);
    }//end fun



    public function store(Request $request)
    {
        //validations
        $data = $request->validate([
           'ticket_id' =>'required',
           'original_cost' =>'required',
           'discount_rate' =>'required',
           'discount_value' =>'required',
           'total_cost' =>'required',
        ]);

        //customer
        $sonsIds = [];

        if ($request->type_of_client == 'exist_user') {

            $request->validate( ['client_id' =>'required','son_name_old' =>'required']);

            $data['customer_id'] = $request->client_id;

            //update the new names
            $this->update_names_of_sons($request->son_name_old,$request->son_name_id_old);

            //save new sons
            if (isset($request->son_name) && is_array($request->son_name)) {
                $newSonIds = $this->save_new_sons($request->son_name,$request->client_id);
                $sonsIds = array_merge($newSonIds,$request->son_name_id_old);
            }else{
                $sonsIds = $request->son_name_id_old;
            }

        }else{
            $request->validate( ['son_name' =>'required']);

            $data['customer_id'] =  $this->add_new_client();
        }

        //timing
        $ticket = Ticket::findOrFail($request->ticket_id);
        $time  = $this->add_mins_to_now($ticket->minutes_count);
        $data['started_at'] = $time[0];
        $data['finished_at'] = $time[1];
        $data['created_by'] = auth()->user()->id;

        //save new order
        $order = Order::create($data);


        //order  details saving
        if ($request->type_of_client == 'exist_user') {
           foreach ($sonsIds as $son_id)
           {
               OrderDetail::create([
                   'son_id'=>$son_id,
                   'order_id'=>$order->id,
                   'ticket_id'=>$request->ticket_id,
               ]);
           }
        }else{

            $customer = Customer::findOrFail($order->customer_id);
            foreach ($customer->sons as $son)
            {
                OrderDetail::create([
                    'son_id'=>$son->id,
                    'order_id'=>$order->id,
                    'ticket_id'=>$request->ticket_id,
                ]);
            }
        }

        //order add - ons
        if (isset($request->add_ons) && is_array($request->add_ons)) {

            foreach ($request->add_ons as $add_on)
            {
                OrderAddOn::create([
                    'order_id'=>$order->id,
                    'add_on_id'=>$add_on,
                ]);
            }
        }

        $this->add_log_activity($order, auth()->user(), "تم اضافة طلب جديد {$order->id}");

        return response()->json(route('cashier.show',$order->id),200);
    }//end fun



    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.modules.cashier.show',compact('order'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * when Cashier Select en existing Client
     *
     *
     */
    public function selectExistClient(Request $request)
    {
        $client = Customer::findOrFail($request->id);
        $returnHTML = view("admin.modules.cashier.parts.existingClient")
            ->with([
                'client'=>$client
            ])
            ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * when Cashier Select en new Client
     *
     *
     */

    public function selectNewClient(Request $request)
    {

        $returnHTML = view("admin.modules.cashier.parts.newClient")
            ->with([])
            ->render();
        return response()->json(array('success' => true, 'html' => $returnHTML));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * add min to time
     */

    public function add_mins_to_now($min)
    {
        $now = time();
        $minutes = $now + ($min * 60);
        $startDate = date('Y-m-d H:i:s', $now);
        $endDate = date('Y-m-d H:i:s', $minutes);

        return [$startDate,$endDate];
    }//end fun


    /**
     * @return mixed
     *
     * Add New client
     *
     */
    public function add_new_client()
    {
        //------------------- create -----------------------------
        $row = Customer::create(['name'=>request()->name,'phone'=>request()->phone]);
        //---------------- Create accounts -------------------

        if (isset(request()->son_name) && is_array(request()->son_name)) {
            foreach (request()->son_name as $index=>$value){
                Customer::create([
                    'parent_id'=>$row->id,
                    'name'=>$value,
                    'client_type'=>"son",
                ]);
            }
        }
        return $row->id;
    }

    /**
     * @return mixed
     *
     *  save new Sons
     *
     */
    public function save_new_sons($son_name,$client_id)
    {
        $ids = [];
        if (isset($son_name) && is_array($son_name)) {

            foreach ($son_name as $index=>$value){

                $son = Customer::create([
                    'parent_id'=>$client_id,
                    'name'=>$value,
                    'client_type'=>"son",
                ]);

                $ids[$index] =$son->id;
            }


        }
        return $ids;
    }//end fun

    /**
     * @param $son_name_old
     * @param $son_name_id_old
     *
     * Update name of son exists
     */
    public function update_names_of_sons($son_name_old,$son_name_id_old)
    {
        foreach ($son_name_id_old as $index=>$value){

            $son = Customer::findOrFail($value)->update([
                'name'=>$son_name_old[$index],
            ]);

        }
    }
}//end class


