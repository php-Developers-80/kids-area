<?php

namespace App\Http\Controllers\Admin\Modules\Managment;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminCustomerController extends Controller
{
    //my traits
    use Upload_Files;
    use LogActivityTrait;


    public function __construct()
    {
        $this->middleware([('permission:clientsIndex,web')])->only(['index']);
        $this->middleware([('permission:clientsAdding,web')])->only(['create']);
        $this->middleware([('permission:clientsEditing,web')])->only(['edit']);
        $this->middleware([('permission:clientsSingleDeleting,web')])->only(['destroy']);
        $this->middleware([('permission:clientsMultiDeleting,web')])->only(['delete_all']);
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
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة كل العملاء ');

        //return all Suppliers
        if ($request->ajax()) {
            $clients = Customer::whereNull('parent_id')
                ->latest()
                ->get();

            return DataTables::of($clients)

                ->editColumn('created_at', function ($client) {
                    return date('Y/m/d',strtotime($client->created_at));
                })

                ->addColumn('delete_all', function ($client) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $client->id . "'>";
                })
                ->addColumn('actions', function ($client) {

                    return "
                    <button  class='btn mb-2 btn-secondary editButton' id='" . $client->id . "'> <i class='fad fa-edit'></i></button>
                   <button class='btn mb-2 btn-danger  delete' id='" . $client->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['actions','delete_all','created_at'])->make(true);
        }

        return view('admin.modules.managements.Clients.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     *  return Client creating view
     *
     */
    public function create(Request $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة اضافة عميل جديد');

        //return create branch page
        if ($request->ajax()){
            $returnHTML = view("admin.modules.managements.Clients.parts.add_form")
                ->with([
                ])
                ->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * Add New Client
     *
     */
    public function store(Request $request)
    {
        //----------------- Basic validation -------------------

        $data = $request->validate([
            'name'=>'required',
            'phone'=>'nullable',
        ]);

        if($request->is_there_son == "yes"){
            $request->validate([
                'son_name'=>'required|array',
            ]);
        }

        //------------------- create -----------------------------
        $row = Customer::create($data);
        //---------------- Create accounts -------------------

        if ($request->is_there_son == "yes") {
            foreach ($request->son_name as $index=>$value){
                Customer::create([
                    'parent_id'=>$row->id,
                    'name'=>$value,
                    'client_type'=>"son",
                ]);
            }
        }

        //log activities
        $this->add_log_activity($row,auth()->user(),' تم حفظ  بيانات عميل جديد');
        return response()->json(1,200);
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
     *  return Client edit view
     */

    public function edit(Request $request , $id)
    {
        //log activities
        $client = Customer::findOrFail($id);
        $this->add_log_activity($client,auth()->user()," تم دخول  صفحة تعديل عميل {$client->name}");

        //return edit page
        if ($request->ajax()){
            $returnHTML = view("admin.modules.managements.Clients.parts.edit_form")
                ->with([
                    'client' =>$client,
                ])
                ->render();
            return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * update Client row
     *
     */
    public function update(Request $request,$id)
    {
        //------------------ log activities ---------------

        $client = Customer::findOrFail($id);
        $this->add_log_activity($client,auth()->user()," تم تعديل  العميل  {$client->name}");

        //------------- basic validation -----------------

        $data = $this->validate($request,[
            'name'=>'required',
            'phone'=>'nullable',
        ]);

        $client->sons()->delete();
        if(isset($request->son_name) && is_array($request->son_name)){
            $request->validate([
                'son_name'=>'required|array',
            ]);

            foreach ($request->son_name as $index=>$value){
                Customer::create([
                    'parent_id'=>$client->id,
                    'name'=>$value,
                    'client_type'=>"son",
                ]);
            }
        }


        //------------------- update supplier  ----------------
        Customer::find($client->id)->update($data);

        return response()->json(1,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * delete Client
     *
     */
    public function destroy($id)
    {
        //log activities
        $client = Customer::findOrFail($id);
        $this->add_log_activity($client,auth()->user()," تم حذف  العميل {$client->name}");

        //delete single customer
        return response()->json(Customer::destroy($id),200);
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
                $client = Customer::findOrFail($id);
                //log activities
                $this->add_log_activity($client,auth()->user()," تم حذف العميل {$client->name}");

            }
        }

        //delete all Client had user selected
        Customer::destroy($request->id);
        return response()->json(1,200);
    }
}//end fun
