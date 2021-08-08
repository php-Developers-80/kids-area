<?php

namespace App\Http\Controllers\Admin\Modules\SystemSetting;

use App\Http\Controllers\Controller;
use App\Http\Traits\LogActivityTrait;
use App\Http\Traits\Upload_Files;
use App\Models\DynamicSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class AdminDynamicSliderController extends Controller
{
    use Upload_Files;
    use LogActivityTrait;

    public function __construct()
    {
        $this->middleware([('permission:lists index,web')])->only(['index']);
        $this->middleware([('permission:listsAdding,web')])->only(['create','reOrderAllDynamicSlidersAction']);
        $this->middleware([('permission:listsEditing,web')])->only(['edit','changeStatus']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     * return all dynamic sliders
     *
     */

    public function index()
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة كل القوائم');

        $dynamicSliders = DynamicSlider::whereNull('parent_id')
            ->orderBy('order_number','asc')
            ->get();
        return view('admin.modules.system-settings.dynamicSliders.index2',[
            'dynamicSliders'=>$dynamicSliders,
        ]);
    }//end fun


    public function reOrderAllDynamicSliders(Request $request)
    {

    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * reorder dynamic slider action
     *
     */

    public function reOrderAllDynamicSlidersAction(Request $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم إعادة ترتيب القوائم');

        //variables

        $parent_id = null;
        $index =0;
        $sun_index =0;
        $order_ids =$request->order;

        foreach ($order_ids as $item){
            $current_array = explode('-', $item);
            if ($current_array[0]=="parent") {
                $parent_id = $current_array[1];

                //update
               DynamicSlider::find($current_array[1])
                    ->update([
                        'order_number'=>$index,
                    ]);


                //re-init the counter of parent
                $index ++ ;

                //re-init the counter of sub
                $sun_index = 0;

            }
            if ($current_array[0]=="sub") {

                $sub_slider = DynamicSlider::find($current_array[1]);

                //update
                DynamicSlider::find($current_array[1])
                    ->update([
                        'parent_id'=>$parent_id,
                        'order_number'=>$sun_index,
                    ]);
                //increase counter of sub
                $sun_index ++;

            }

        }//end foreach
        return response()->json(['message'=>'good'],200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * reorder dynamic sliders (for basic dynamic slider)
     *
     */
    public function re_order_dynamic_sliders(Request  $request)
    {
        $order_ids =$request->order;
        foreach ($order_ids as $index=>$item){
            $row = DynamicSlider::find($item);
            $row->order_number=$index;
            $row->save();
            activity()
                ->performedOn($row)
                ->causedBy(auth()->user())
                ->log("إعادة ترتيب القوائم الرئيسية");
        }
        return response()->json(['message'=>'good'],200);
    }//end fun


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     * return creating new dynamic slider view
     *
     */
    public function create(Request $request)
    {
        //log activities
        $this->add_log_activity(null,auth()->user(),'تم دخول صفحة اضافة قائمة جديدة');

        $dynamicSliders = DynamicSlider::whereNull('parent_id')
            ->orderBy('order_number','asc')
            ->get();

        $subDynamicSliders = DynamicSlider::whereNotNull('parent_id')
            ->orderBy('order_number','asc')
            ->get();

        $routeLists = \Route::getRoutes();

        return view('admin.modules.system-settings.dynamicSliders.create',[
            'permissions'=>Permission::get(),
            'dynamicSliders'=>$dynamicSliders,
            'subDynamicSliders'=>$subDynamicSliders,
            'routeLists'=>$routeLists,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * store the new dynamic slider
     *
     */
    public function store(Request $request)
    {
        //basic validation
        $data = $request->validate([
            'ar_title'=>'required',
            'en_title'=>'required',
            'route_link'=>'required',
            'font_icon'=>'required',
            'image'=>'nullable',
            'permission_id'=>'nullable'
        ]);

        //validate slider type
        $request->validate([
            'is_parent'=>'required'
        ]);

        if ($request->is_parent == "child") {
            $request->validate([
                'parent_id'=>'required|exists:dynamic_sliders,id'
            ]);
            $data['parent_id']= $request->parent_id;

            //get order number of slider
            $dynamic_slider_row = DynamicSlider::where('parent_id',$request->parent_id)
                ->orderBy('order_number','desc')
                ->first();
            $data['order_number']=$dynamic_slider_row?($dynamic_slider_row->order_number+1):0;
        }else{
//            $request->validate([
//                'child_id'=>'required|array',
//                'child_id.*'=>'required|exists:dynamic_sliders,id'
//            ]);
            //get order number of slider
            $dynamic_slider = DynamicSlider::whereNull('parent_id')
                ->orderBy('order_number','desc')
                ->first();
            $data['order_number']=$dynamic_slider?($dynamic_slider->order_number+1):0;

        }

        //validate permission type
        if ($request->permission_id) {
            $permission = Permission::find($request->permission_id);
            $data['permission_name']=$permission->name;
        }

        //image upload
        if ($request->image) {
            $data['image']=$this->uploadFiles('dynamicSliders',$request->image,null);
        }else{
            $data['image']= $this->createImageFromTextManual('dynamicSliders' , $request->en_title , 256 , '#25D366','#fff');

        }

        //create new dynamic slider
        $row = DynamicSlider::create($data);
        if (isset($request->child_id)&& is_array($request->child_id) && $request->is_parent == "parent") {
            foreach ($request->child_id as $index=>$child_id){
                DynamicSlider::where('id',$child_id)->update([
                    'parent_id'=>$row->id,
                    'order_number'=>$index,
                ]);
            }
        }

        //log activities
        $this->add_log_activity($row,auth()->user()," تم إضافة قائمة جديدة {$row->ar_title} ");

        return response(['message'=>'good'],200);
    }//end fun

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
     *
     * return edit view
     *
     */
    public function edit($id)
    {

        //log activities
        $row = DynamicSlider::findOrFail($id);
        $this->add_log_activity($row,auth()->user(),'تم دخول صفحة تعديل قائمة ');

        $dynamicSliders = DynamicSlider::whereNull('parent_id')
            ->orderBy('order_number','asc')
            ->get();

        $subDynamicSliders = DynamicSlider::whereNotNull('parent_id')
            ->orderBy('order_number','asc')
            ->get();

        $routeLists = \Route::getRoutes();

        return view('admin.modules.system-settings.dynamicSliders.edit',[
            'permissions'=>Permission::get(),
            'dynamicSliders'=>$dynamicSliders,
            'subDynamicSliders'=>$subDynamicSliders,
            'routeLists'=>$routeLists,
            'row'=>$row
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     *
     * update dynamic slider
     *
     */
    public function update(Request $request, $id)
    {
        $row = DynamicSlider::findOrFail($id);

        //basic validation
        $data = $request->validate([
            'ar_title'=>'required',
            'en_title'=>'required',
            'route_link'=>'required',
            'font_icon'=>'required',
            'image'=>'nullable',
            'permission_id'=>'nullable'
        ]);


        //validate slider type
        $request->validate([
            'is_parent'=>'required'
        ]);


        if ($request->is_parent == "child") {
            $request->validate([
                'parent_id'=>'required|exists:dynamic_sliders,id'
            ]);

            //update childes of old dynamic slider
            $sub_dynamic_sliders = DynamicSlider::where('parent_id',$id)->get();
            if (count($sub_dynamic_sliders) > 0) {
                foreach ($sub_dynamic_sliders as $single){
                    $single->update(['parent_id'=>$request->parent_id]);
                }
            }
            $data['parent_id']= $request->parent_id;

            //get order number of slider
            $dynamic_slider_row = DynamicSlider::where('parent_id',$request->parent_id)
                ->orderBy('order_number','desc')
                ->first();
            $data['order_number']=$dynamic_slider_row?($dynamic_slider_row->order_number+1):0;
        }else{
//            $request->validate([
//                'child_id'=>'required|array',
//                'child_id.*'=>'required|exists:dynamic_sliders,id'
//            ]);
            //get order number of slider
            $dynamic_slider = DynamicSlider::whereNull('parent_id')
                ->orderBy('order_number','desc')
                ->first();
            $data['parent_id']= null;
            $data['order_number']=$dynamic_slider?($dynamic_slider->order_number+1):0;

        }

        //validate permission type
        if ($request->permission_id) {
            $permission = Permission::find($request->permission_id);
            $data['permission_name']=$permission->name;
        }

        //image upload
        if ($request->image) {
            $data['image']=$this->uploadFiles('dynamicSliders',$request->image,$row->image);
        }else{
            $data['image']= $row->image;
        }

        //update dynamic slider
        DynamicSlider::where('id',$id)->update($data);
        if (isset($request->child_id)&& is_array($request->child_id) && $request->is_parent == "parent") {
            foreach ($request->child_id as $index=>$child_id){
                DynamicSlider::where('id',$child_id)->update([
                    'parent_id'=>$row->id,
                    'order_number'=>$index,
                ]);
            }
        }

        //log activities
        $this->add_log_activity($row,auth()->user()," تم تعديل القائمة  {$row->ar_title} ");

        return response(['message'=>'good'],200);
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


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     *
     * Change status of dynamic sliders
     */
    public function changeStatus($id)
    {
        //log activity
        $row = DynamicSlider::findOrFail($id);
        $this->add_log_activity($row,auth()->user()," تم تعديل  حالة القائمة  {$row->ar_title} ");

        $status = $row->is_shown == 'shown'?'hidden':'shown';
        $row->update(['is_shown' => $status]);
        return response()->json($status,200);
    }


}//end class
