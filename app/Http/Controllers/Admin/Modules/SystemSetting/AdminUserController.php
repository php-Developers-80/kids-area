<?php

namespace App\Http\Controllers\Admin\Modules\SystemSetting;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Account;
use App\Models\Branch;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class AdminUserController extends Controller
{
    use Upload_Files;
    use LogActivityTrait;


    public function __construct()
    {
        $this->middleware([('permission:users index,web')])->only(['index']);
        $this->middleware([('permission:usersAdding,web')])->only(['create']);
        $this->middleware([('permission:usersEditing,web')])->only(['edit']);
        $this->middleware([('permission:usersSingleDeleting,web')])->only(['destroy']);
        $this->middleware([('permission:usersMultiDeleting,web')])->only(['delete_all']);
        $this->middleware([('permission:usersIsBlocking,web')])->only(['changeBlock']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {

        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة كل المستخدمين');

        $users = User::latest()->get();
        if ($request->ajax()) {

            return DataTables::of($users)
                ->editColumn('logo', function ($user) {
                    return ' <img src="' . get_file($user->logo) . '" class=" rounded" style="height:50px;width:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('created_at', function ($user) {
                    return date('Y/m/d', strtotime($user->created_at));
                })
                ->addColumn('delete_all', function ($user) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $user->id . "'>";
                })
                ->editColumn('is_block', function ($user) {
                    if ($user->is_block == 'not_blocked') {
                        $re_block = '<span class="badge  ms-auto bg-primary">مفعل</span>';
                    } else {
                        $re_block = '<span class="badge  ms-auto bg-danger">موقوف</span>';

                    }
                    return $re_block;
                })
                ->editColumn('is_active', function ($user) {
                    $re_block = '';
                    if ($user->is_login == 'connected') {
                        $re_block = '<span class="badge ms-auto bg-success">متصل حالياً</span>';
                    } else {
                        // $last_time =\Carbon\Carbon::parse($user->logout_time)->diffForhumans();
                        $re_block = '<span class="badge ms-auto bg-danger">غير متصل </span>';

                    }
                    return $re_block;
                })
                ->addColumn('actions', function ($user) {

                    return "<button title='يمكنك تغيير حالة المستخدم'  class='btn mb-2 btn-info status' id='" . $user->id . "'> <span class='fad fa-bell'></span></button>
                    <button  class='btn mb-2 btn-secondary editButton' id='" . $user->id . "'> <i class='fad fa-edit'></i></button>
                   <button class='btn mb-2 btn-danger  delete' id='" . $user->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['logo', 'created_at', 'delete_all', 'is_block', 'is_active', 'actions'])->make(true);
        }
        return view('admin.modules.system-settings.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //log activities
        $this->add_log_activity(null, auth()->user(), 'تم دخول صفحة اضافة مستخدم جديد');


        if ($request->ajax()) {
            $returnHTML = view("admin.modules.system-settings.users.parts.add_form")
                ->with([
                    'user_types' => [
                        'admin' => 'مدير ',
                        'cashier' => 'كاشير',
                    ]
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        //validation
        $data = $this->validate($request, [
            'name' => 'required',
            'user_name' => 'required|unique:users,user_name',
            'phone' => 'required|unique:users,phone',
            'password' => 'required',
//            'access_permission'=>'required',
            'user_type' => 'required',
            'logo' => 'nullable',
        ]);
        $request->validate([
            'password_confirmation' => "required_with:password|same:password",
        ]);

        $data['password'] = bcrypt($request->password);
        if ($request->hasFile('logo')) {
            $data ['logo'] = $this->uploadFiles('users', $request->file('logo'), null);

        } else {
            $data['logo'] = $this->createImageFromTextManual('users', $request->name, 256, '#25D366', '#fff');
        }
        $user = User::create($data);

        //log activities
        $this->add_log_activity($user, auth()->user(), ' تم حفظ  مستخدم جديد');
        return response()->json(1, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        //log activities
        $this->add_log_activity($user, auth()->user(), " تم دخول  صفحة تعديل المستخدم {$user->name}");

        if ($request->ajax()) {
            $returnHTML = view("admin.modules.system-settings.users.parts.edit_form")
                ->with([
                    'user' => $user,
                    'user_types' => [
                        'admin' => 'مدير ',
                        'cashier' => 'كاشير',
                    ]
                ])
                ->render();
            return response()->json(array('success' => true, 'html' => $returnHTML));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //log activities
        $user = User::findOrFail($id);
        $this->add_log_activity($user, auth()->user(), " تم تعديل  المستخدم {$user->name}");

        $data = $this->validate($request, [
            'name' => 'required',
            'user_name' => Rule::unique('users')->ignore($id),
            'phone' => Rule::unique('users')->ignore($id),
            'password' => 'nullable',
//            'access_permission'=>'required',
            'logo' => 'nullable',
            'user_type' => 'required'
        ]);
        $request->validate([
            'password_confirmation' => "required_with:password|same:password",

        ]);
        if ($request->password)
            $data['password'] = bcrypt($request->password);
        else
            $data['password'] = $user->password;


        if ($request->hasFile('logo'))
            $data ['logo'] = $this->uploadFiles('users', $request->file('logo'), $user->logo);
        else
            $data ['logo'] = $user->logo;

        $user->update($data);

        return response()->json(1, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //log activities
        $user = User::findOrFail($id);
        $this->add_log_activity($user, auth()->user(), " تم حذف  المستخدم {$user->name}");

        return response()->json(User::destroy($id), 200);
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
                $user = User::findOrFail($id);
                $this->add_log_activity($user, auth()->user(), " تم حذف  المستخدم {$user->name}");
            }
        }

        User::destroy($request->id);
        return response()->json(1, 200);
    }


    /**
     * @param $id
     * @return JsonResponse
     *
     * Change status of user
     *
     */

    public function changeBlock($id)
    {
        //log activity
        $row = User::findOrFail($id);
        $this->add_log_activity($row, auth()->user(), " تم تعديل حالة المستخدم {$row->name}");

        $status = $row->is_block == 'blocked' ? 'not_blocked' : 'blocked';
        $row->update(['is_block' => $status]);
        return response()->json(1, 200);
    }
}//end class
