<form action="{{route('profileControl.update',$user->id)}}" method="post" id="EditForm">
    @csrf
    @method("PUT")

    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            تعديل بيانات  {{$user->name}}
        </button>
    </div>

    <div class="row">

        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> الإسم بالكامل </label>
            <input type="text" name="name"  value="{{$user->name}}" class="form-control" data-validation="required">
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 ">إسم المستخدم </label>
            <input type="text" name="user_name" value="{{$user->user_name}}" class="form-control" data-validation="required">
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 ">كلمة المرور الجديدة </label>
            <input type="password" name="password" value="" class="form-control" >
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> إعادة كلمة المرور الجديدة </label>
            <input type="password" data-validation-match="password" name="password_confirmation" value="" class="form-control" >
        </div>



        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> رقم الهاتف </label>
            <input type="text" name="phone" value="{{$user->phone}}" class="form-control numbersOnly" data-validation="required">
        </div>


        <div class="col-lg-6 col-sm-4 mb-4">
            <label class="label mb-2 "> الصورة الشخصية </label>
            <input type="file" class="dropify" name="logo" data-default-file="{{get_file($user->logo)}}"/>
        </div>


    </div>


</form>
