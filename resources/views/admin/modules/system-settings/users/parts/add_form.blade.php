<form action="{{route('users.store')}}" method="post" id="Form">
    @csrf


    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            إضافة  مستخدم جديد
        </button>
    </div>

    <div class="row">

        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> الإسم بالكامل </label>
            <input type="text" name="name"  value="" class="form-control" data-validation="required">
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 ">إسم المستخدم </label>
            <input type="text" name="user_name" value="" class="form-control" data-validation="required">
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 ">كلمة المرور </label>
            <input type="password" name="password" value="" class="form-control" data-validation="required">
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 ">إعادة كلمة المرور </label>
            <input type="password" data-validation-match="password" name="password_confirmation" value="" class="form-control" data-validation="required">
        </div>

        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 ">اختر درجة التحكم </label>
            <select class="form-control" id="user_type" name="user_type"  data-validation="required">
                <option value="" selected>اختر  درجة التحكم </option>
                @foreach($user_types as $user_type=>$value)
                    <option value="{{$user_type}}">{{$value}}</option>
                @endforeach
            </select>
        </div>

        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> رقم الهاتف </label>
            <input type="text" name="phone" value="" class="form-control numbersOnly" data-validation="required">
        </div>


        <div class="col-lg-4 col-sm-6 mb-4">
            <label class="label mb-2 "> الصورة الشخصية </label>
            <input type="file" class="dropify" name="logo"/>
        </div>


    </div>

</form>
