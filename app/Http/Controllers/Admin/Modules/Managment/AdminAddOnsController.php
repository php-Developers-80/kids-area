<?php

namespace App\Http\Controllers\Admin\Modules\Managment;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\AddOn;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AdminAddOnsController extends Controller
{

    use Upload_Files;
    use LogActivityTrait;


    public function __construct()
    {
        $this->middleware([('permission:addOnsIndex,web')])->only(['index']);
        $this->middleware([('permission:addOnsAdding,web')])->only(['create']);
        $this->middleware([('permission:addOnsEditing,web')])->only(['edit']);
        $this->middleware([('permission:addOnsSingleDeleting,web')])->only(['destroy']);
        $this->middleware([('permission:addOnsMultiDeleting,web')])->only(['delete_all']);
        $this->middleware([('permission:addOnsShowHidden,web')])->only(['changeStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة كل  الإضافة');

        $addOns = AddOn::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($addOns)

                ->editColumn('created_at', function ($addOn) {
                    return date('Y/m/d', strtotime($addOn->created_at));
                })
                ->addColumn('delete_all', function ($addOn) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $addOn->id . "'>";
                })
                ->editColumn('is_shown', function ($addOn) {
                    if ($addOn->is_shown == 'shown') {
                        $re_block = '<span class="badge  ms-auto bg-primary">مفعل</span>';
                    } else {
                        $re_block = '<span class="badge  ms-auto bg-danger">موقوف</span>';

                    }
                    return $re_block;
                })
                ->addColumn('actions', function ($addOn) {

                    return "<button title='يمكنك تغيير حالة الإضافة'  class='btn mb-2 btn-info status' id='" . $addOn->id . "'> <span class='fad fa-bell'></span></button>
                    <button  class='btn mb-2 btn-secondary editButton' id='" . $addOn->id . "'> <i class='fad fa-edit'></i></button>
                   <button class='btn mb-2 btn-danger  delete' id='" . $addOn->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['logo', 'created_at', 'delete_all', 'is_shown', 'actions'])->make(true);
        }
        return view('admin.modules.managements.add-ons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة اضافة إضافة جديدة');


        if ($request->ajax()) {
            $returnHTML = view("admin.modules.managements.add-ons.parts.add_form")
                ->with([
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'=>'required',
            'price'=>'required'
        ]);
        $row = AddOn::create($data);

        //log activities
        $this->add_log_activity($row, auth()->user(), ' تم حفظ  إضافة جديدة');
        return response()->json(1, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     */
    public function edit($id,Request $request)
    {
        //log activities
        $this->add_log_activity(null, auth()->user(), "تم دخول صفحة تعديل الإضافة رقم {$id}");


        if ($request->ajax()) {
            $returnHTML = view("admin.modules.managements.add-ons.parts.edit_form")
                ->with([
                    "addOn"=>AddOn::findOrFail($id)
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title'=>'required',
            'price'=>'required'
        ]);

        AddOn::where('id',$id)->update($data);
        //log activities
        $row = AddOn::findOrFail($id);
        $this->add_log_activity($row, auth()->user(), " {$id} تم تعديل  إضافة رقم ");
        return response()->json(1, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //log activities
        $row = AddOn::findOrFail($id);
        $this->add_log_activity($row, auth()->user(), " تم حذف  الإضافة {$id}");

        return response()->json(AddOn::destroy($id), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function delete_all(Request $request)
    {

        //log activities
        if (isset($request->id) && is_array($request->id)) {
            foreach ($request->id as $id) {
                $row = AddOn::findOrFail($id);
                $this->add_log_activity($row, auth()->user(), " تم حذف  الإضافة {$id}");
            }
        }

        AddOn::destroy($request->id);
        return response()->json(1, 200);
    }


    /**
     * @param $id
     * @return JsonResponse
     *
     * Change status of Add ons
     *
     */

    public function changeStatus($id)
    {
        //log activity
        $row = AddOn::findOrFail($id);
        $this->add_log_activity($row, auth()->user(), " تم تعديل حالة الإضافة {$id}");

        $status = $row->is_shown == 'shown' ? 'hidden' : 'shown';
        $row->update(['is_shown' => $status]);
        return response()->json(1, 200);
    }
}//end class
