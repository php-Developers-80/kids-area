<?php

namespace App\Http\Controllers\Admin\Modules\SystemSetting;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminGeneralSettingController extends Controller
{
    use Upload_Files;
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware([('permission:editGeneralSetting,web')])->only(['index']);
        $this->middleware([('permission:saveGeneralSettings,web')])->only(['update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة الإعدادات العامة');
        return  view('admin.modules.system-settings.generalSettings.index');
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
        $this->add_log_activity(Setting::first(),auth()->user(),'تم تعديل الإعدادات العامة');

        $data = $request->all();
        $setting = Setting::first();


        if ($request->hasFile('header_logo'))
            $data['header_logo']= $request->hasFile('header_logo')
                ?$this->uploadFiles('settings',$request->header_logo,$setting->header_logo)
                :$setting->header_logo;

        if ($request->hasFile('login_banner'))
            $data['login_banner']= $request->hasFile('login_banner')
                ?$this->uploadFiles('settings',$request->login_banner,$setting->login_banner)
                :$setting->login_banner;

        Setting::updateOrCreate(['id' => 1],$data);
        return response()->json(1,200);
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
