<?php

namespace App\Http\Controllers\Admin\Modules\SystemSetting;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class AdminUserPermissionController extends Controller
{
    //my traits
    use Upload_Files;
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware([('permission:user permission index,web')])->only(['index']);
        $this->middleware([('permission:userPermissionAdding,web')])->only(['create']);
        $this->middleware([('permission:userPermissionsEditing,web')])->only(['edit']);
        $this->middleware([('permission:userPermissionSingleDeleting,web')])->only(['destroy']);
        $this->middleware([('permission:userPermissionMultiDeleting,web')])->only(['delete_all']);
    }

    public function index(Request $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة صلاحيات المستخدمين');

        $users = User::has('permissions')->withCount('permissions')->get();

        if ($request->ajax()) {

            return DataTables::of($users)

                ->editColumn('logo', function ($user) {
                    return ' <img src="'.get_file($user->logo).'" class=" rounded" style="height:50px;width:50px"
                             onclick="window.open(this.src)">';
                })
                ->editColumn('is_block', function ($user) {
                    $re_block = '';
                    if ($user->is_block == 'not_blocked') {
                        $re_block = '<span class="badge  ms-auto bg-primary">مفعل</span>';
                    }else{
                        $re_block = '<span class="badge  ms-auto bg-danger">موقوف</span>';

                    }
                    return $re_block;
                })

                ->editColumn('is_active', function ($user) {
                    $re_block = '';
                    if ($user->is_login == 'connected') {
                        $re_block = '<span class="badge ms-auto bg-success">متصل حالياً</span>';
                    }else{
                        // $last_time =\Carbon\Carbon::parse($user->logout_time)->diffForhumans();
                        $re_block = '<span class="badge ms-auto bg-danger">غير متصل </span>';

                    }
                    return $re_block;
                })
                ->addColumn('user_type', function ($user) {
                    $user_types = [
                        'admin'=>'مدير عام',
                        'cashier'=>'كاشير',
                    ];
                    $user_type = $user?$user_types[$user->user_type]:'';
                    return "<span class='badge bg-success'>".$user_type."</span>";
                })

                ->addColumn('delete_all', function ($user) {
                    return "<input type='checkbox' class=' delete-all' data-tablesaw-checkall name='delete_all' id='" . $user->id . "'>";
                })

                ->addColumn('actions', function ($user) {
                    return "<a href='" . route('userPermissions.edit',$user->id) . "'  class='btn mb-2 btn-info'> <i class='fad fa-edit'></i></a>
                   <button class='btn mb-2 btn-danger  delete' id='" . $user->id . "'><i class='fad fa-trash'></i> </button>";
                })->rawColumns(['actions','delete_all','logo','is_block','is_active','user_type'])->make(true);
        }
        return view('admin.modules.system-settings.user-permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة اضافة صلاحيات المستخدمين');

        $users = User::doesnthave('permissions')->get();
        $permissions=Permission::where('name','!=','Add Permissions')
            ->whereNull('parent_id')
            ->where('level','parent')
            ->orderBy('type_order')
            ->get();
        return view('admin.modules.system-settings.user-permissions.create',
            [
                'users'=>$users,
                'parent_permissions'=>$permissions,
            ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'permissions.*'=>'required|exists:permissions,id',
            'user_id'=>'required|exists:users,id',
        ]);
        $user = User::findOrFail($request->user_id);
        $permissions = Permission::whereIn('id',$request->permissions)
            ->pluck('name')
            ->toArray();

        $user->givePermissionTo($permissions);

        //log activities
        $this->add_log_activity($user,auth()->user()," تم حفظ  صلاحيات  للمستخدم {$user->name} ");

        return response()->json(['message'=>'good'],200);
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
        $user=User::findOrFail($id);
        //log activities
        $this->add_log_activity($user,auth()->user()," تم دخول صفحة تعديل  صلاحيات  للمستخدم {$user->name} ");

        $permissions=Permission::where('name','!=','Add Permissions')
            ->whereNull('parent_id')
            ->where('level','parent')
            ->orderBy('type_order')
            ->get();
        $userPermissions = $user->permissions()->pluck('id')->toArray();
        return view('admin.modules.system-settings.user-permissions.edit',
            [
                'user'=>$user,
                'users'=>User::get(),
                'parent_permissions'=>$permissions,
                'userPermissions'=>$userPermissions,
            ]);
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
        $this->validate($request,[
            'permissions.*'=>'required|exists:permissions,id',
        ]);
        $user=User::findOrFail($id);
        $user->syncPermissions($request->permissions);
        //log activities
        $this->add_log_activity($user,auth()->user()," تم  تعديل  صلاحيات  للمستخدم {$user->name} ");

        return response()->json(['message'=>'good'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);
        $this->add_log_activity($user,auth()->user()," تم  حذف  صلاحيات  المستخدم {$user->name} ");

        $permissions=User::findOrFail($id)->permissions()->get();
        foreach ($permissions as $permission){
            User::findOrFail($id)->revokePermissionTo($permission->name);
        }
        return response(['error' => ''], 200);
    }



    public function delete_all(Request $request)
    {
        foreach ($request->id as $item){
            //log activities
            $user = User::findOrFail($item);
            $this->add_log_activity($user,auth()->user()," تم  حذف  صلاحيات  المستخدم {$user->name} ");

            $permissions=User::findOrFail($item)->permissions()->get();
            foreach ($permissions as $permission){
                User::findOrFail($item)->revokePermissionTo($permission->name);
            }
        }

        return response()->json(1,200);
    }


}//end class
