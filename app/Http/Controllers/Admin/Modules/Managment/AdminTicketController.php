<?php

namespace App\Http\Controllers\Admin\Modules\Managment;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class AdminTicketController extends Controller
{

    use Upload_Files;
    use LogActivityTrait;


    public function __construct()
    {
        $this->middleware([('permission:ticketIndex,web')])->only(['index']);
        $this->middleware([('permission:ticketAdding,web')])->only(['create']);
        $this->middleware([('permission:ticketEditing,web')])->only(['edit']);
        $this->middleware([('permission:ticketSingleDeleting,web')])->only(['destroy']);
        $this->middleware([('permission:ticketMultiDeleting,web')])->only(['delete_all']);
        $this->middleware([('permission:ticketShowHidden,web')])->only(['changeStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة كل التذاكر');

        $tickets = Ticket::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($tickets)

                ->editColumn('created_at', function ($ticket) {
                    return date('Y/m/d', strtotime($ticket->created_at));
                })
                ->addColumn('delete_all', function ($ticket) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $ticket->id . "'>";
                })
                ->editColumn('is_shown', function ($ticket) {
                    if ($ticket->is_shown == 'shown') {
                        $re_block = '<span class="badge  ms-auto bg-primary">مفعل</span>';
                    } else {
                        $re_block = '<span class="badge  ms-auto bg-danger">موقوف</span>';

                    }
                    return $re_block;
                })
                ->addColumn('actions', function ($ticket) {

                    return "<button title='يمكنك تغيير حالة التذكرة'  class='btn mb-2 btn-info status' id='" . $ticket->id . "'> <span class='fad fa-bell'></span></button>
                    <button  class='btn mb-2 btn-secondary editButton' id='" . $ticket->id . "'> <i class='fad fa-edit'></i></button>
                   <button class='btn mb-2 btn-danger  delete' id='" . $ticket->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['logo', 'created_at', 'delete_all', 'is_shown', 'actions'])->make(true);
        }
        return view('admin.modules.managements.tickets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة اضافة تذكرة جديدة');


        if ($request->ajax()) {
            $returnHTML = view("admin.modules.managements.tickets.parts.add_form")
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
            'minutes_count'=>'required',
            'price'=>'required'
        ]);
        $ticket = Ticket::create($data);

        //log activities
        $this->add_log_activity($ticket, auth()->user(), ' تم حفظ  تذكرة جديدة');
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
        $this->add_log_activity(null, auth()->user(), "تم دخول صفحة تعديل التذكرة رقم {$id}");


        if ($request->ajax()) {
            $returnHTML = view("admin.modules.managements.tickets.parts.edit_form")
                ->with([
                    "ticket"=>Ticket::findOrFail($id)
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
            'minutes_count'=>'required',
            'price'=>'required'
        ]);

        Ticket::where('id',$id)->update($data);
        //log activities
        $ticket = Ticket::findOrFail($id);
        $this->add_log_activity($ticket, auth()->user(), " {$id} تم تعديل  تذكرة رقم ");
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
        $row = Ticket::findOrFail($id);
        $this->add_log_activity($row, auth()->user(), " تم حذف  التذكرة {$id}");

        return response()->json(Ticket::destroy($id), 200);
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
                $row = Ticket::findOrFail($id);
                $this->add_log_activity($row, auth()->user(), " تم حذف  التذكرة {$id}");
            }
        }

        Ticket::destroy($request->id);
        return response()->json(1, 200);
    }


    /**
     * @param $id
     * @return JsonResponse
     *
     * Change status of Ticket
     *
     */

    public function changeStatus($id)
    {
        //log activity
        $row = Ticket::findOrFail($id);
        $this->add_log_activity($row, auth()->user(), " تم تعديل حالة التذكرة {$id}");

        $status = $row->is_shown == 'shown' ? 'hidden' : 'shown';
        $row->update(['is_shown' => $status]);
        return response()->json(1, 200);
    }
}//end class
