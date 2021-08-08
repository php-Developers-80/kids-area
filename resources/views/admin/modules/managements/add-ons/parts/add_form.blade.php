<form action="{{route('add-ons.store')}}" method="post" id="Form">
    @csrf


    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            إضافة  إضافة جديدة
        </button>
    </div>

    <div class="row">

        <div class="col-lg-6 col-sm-6 mb-6">
            <label class="label mb-2 ">اسم الإضافة </label>
            <input type="text"  name="title" value="" class="form-control" data-validation="required">
        </div>

        <div class="col-lg-6 col-sm-6 mb-6">
            <label class="label mb-2 "> قيمة الإضافة بالجنيه</label>
            <input type="text" name="price"  value="" class="form-control numbersOnly" data-validation="required">
        </div>





    </div>

</form>
