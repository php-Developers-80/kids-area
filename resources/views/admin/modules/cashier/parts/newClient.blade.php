<div class="row">

    <div class="col-lg-6 col-md-6  mb-3">
        <label class="label mb-2 " for="name"> إسم ولى الأمر </label>
        <input type="text"  name="name" value="" class="form-control" data-validation="required">
    </div>





    <div class="col-lg-6 col-md-6  mb-3">
        <label class="label mb-2 " for="phone"> الهاتف </label>
        <input type="text" name="phone"  value="" class="form-control" data-validation="required">
    </div>


</div>


<div class="row mt-2 mb-2 p-3 text-center">
    <div class="col-12">
        <span id="AddAccounts" attr-value="hidden" class="btn btn-light-success">
            أسماء الأولاد
            <i  class="fad fa-plus" id="icon-add">

            </i>
        </span>


    </div>
</div>

<div  id="education_fields" class="my-4 accountDiv" style="display: none"></div>
<div class="row accountDiv" >

    <div class="col-sm-10">
        <div class="mb-3">
            <input data-validation="required" type="text" class="form-control SonToSum" id="bank_name" name="son_name[]" placeholder="الإسم">
        </div>
    </div>
    <div class="col-sm-2">
        <div class="mb-3">
            <button  class="btn rounded-pill addingHere px-4 btn-light-success text-success font-weight-medium waves-effect waves-light" type="button">
                <i class="fad fa-plus feather-sm fill-white"></i>

            </button>

        </div>
    </div>
</div>

