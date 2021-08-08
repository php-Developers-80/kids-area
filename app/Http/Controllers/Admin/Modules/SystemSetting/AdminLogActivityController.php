<?php

namespace App\Http\Controllers\Admin\Modules\SystemSetting;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\DataTables;

class AdminLogActivityController extends Controller
{
    //my traits
    use Upload_Files;
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware([('permission:logs Index,web')])->only(['index']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     *
     * all users logs activities
     *
     */
    public function index(Request  $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة كل أنشطة المستخدمين');

        //return all log activities
        if ($request->ajax()) {
            $activities = Activity::latest()
                ->whereDate('created_at',date('Y-m-d'))
                ->get();

            return DataTables::of($activities)

                ->editColumn('created_at', function ($activity) {
                    return $activity->created_at->diffForHumans();;
                })

                ->editColumn('user_name', function ($activity) {
                    return isset($activity->causer->name)?$activity->causer->name:'';
                })

                ->editColumn('user_status', function ($activity) {
                    if ( isset($activity->causer->is_login) && $activity->causer->is_login=="connected") {
                      return "<span class='badge ms-auto bg-primary'>متصل</span>";
                    }else{
                     return  "<span class='badge ms-auto bg-danger'>غير متصل</span>";
                    }
                })
                ->editColumn('subject', function ($activity) {
                    return isset($activity->subject_type)?$activity->subject_type:'لا يوجد موضوع';
                })
                ->editColumn('description', function ($activity) {
                    return isset($activity->description)?$activity->description:'لا يوجد وصف';
                })

                ->addColumn('delete_all', function ($activity) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $activity->id . "'>";
                })
                 ->rawColumns(['created_at','delete_all','user_name','user_status','subject','description'])->make(true);
        }

        return view('admin.modules.system-settings.logActivities.index',['users'=>User::get()]);
    }//end fun



    public function filter(Request $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم عمل بحث فى أنشطة المستخدمين');

        //filter data
        $activities = Activity::latest();
        if ($request->user_id != null) {
            $activities = $activities->where('causer_id',$request->user_id);
        }
        if ($request->from_date != null) {
            $activities = $activities->whereDate('created_at',"<=",$request->from_date);
        }

        if ($request->to_date != null) {
            $activities = $activities->whereDate('created_at',">=",$request->to_date);
        }
        $activities = $activities->get();

        //return all log activities
        if ($request->ajax()) {

            return DataTables::of($activities)

                ->editColumn('created_at', function ($activity) {
                    return $activity->created_at->diffForHumans();;
                })

                ->editColumn('user_name', function ($activity) {
                    return isset($activity->causer->name)?$activity->causer->name:'';
                })

                ->editColumn('user_status', function ($activity) {
                    if ( isset($activity->causer->is_login) && $activity->causer->is_login=="connected") {
                        return "<span class='badge ms-auto bg-primary'>متصل</span>";
                    }else{
                        return  "<span class='badge ms-auto bg-danger'>غير متصل</span>";
                    }
                })
                ->editColumn('subject', function ($activity) {
                    return isset($activity->subject_type)?$activity->subject_type:'لا يوجد موضوع';
                })
                ->editColumn('description', function ($activity) {
                    return isset($activity->description)?$activity->description:'لا يوجد وصف';
                })

                ->addColumn('delete_all', function ($activity) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $activity->id . "'>";
                })
                ->rawColumns(['created_at','delete_all','user_name','user_status','subject','description'])->make(true);
        }
    }//end filter function


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
