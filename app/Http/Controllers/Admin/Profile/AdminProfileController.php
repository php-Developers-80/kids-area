<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\User;
use App\Models\UserJob;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminProfileController extends Controller
{
    use Upload_Files;
    use LogActivityTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
    public function edit($id,Request $request)
    {
        //log activities
        $user = auth()->user();
        $this->add_log_activity($user,auth()->user()," تم دخول صفحة تعديل حساب {$user->name} ");


        if ($request->ajax()){
            $returnHTML = view("admin.profile.edit")
                ->with([
                  'user'=>auth()->user()
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
     */
    public function update(Request $request, $id)
    {
        //log activities
        $user = User::findOrFail($id);
        $this->add_log_activity($user,auth()->user()," تم تعديل  المستخدم {$user->name}");

        $data = $this->validate($request,[
            'name'=>'required',
            'user_name'=>Rule::unique('users')->ignore($id),
            'phone'=>Rule::unique('users')->ignore($id),
            'password'=>'nullable',
            'logo'=>'nullable',
        ]);

        if ($request->password)
            $data['password'] = bcrypt($request->password);
        else
            $data['password'] = $user->password;


        if ($request->hasFile('logo'))
            $data ['logo'] = $this->uploadFiles('users',$request->file('logo'),$user->logo );
        else
            $data ['logo'] = $user->logo;

        $user->update($data);
        $user = User::findOrFail($id);

        return response()->json(['logo'=>get_file($user->logo),"name"=>$user->name],200);
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
