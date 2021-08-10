<form action="{{route('customers.store')}}" method="post" id="Form">
    @csrf


    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            إضافة عميل جديد
        </button>
    </div>

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
            <button id="AddAccounts" attr-value="hidden" class="btn btn-light-success">
                 أسماء الأولاد
                <i  class="fad fa-plus" id="icon-add">

                </i>
            </button>
            <input id="is_there_bank_account" type="hidden" value="no" name="is_there_son">


        </div>
    </div>
    <div id="education_fields" class="my-4 accountDiv" style="display: none"></div>
    <div class="row accountDiv" style="display: none">

        <div class="col-sm-10">
            <div class="mb-3">
                <input data-validation="required" type="text" class="form-control" id="bank_name" name="son_name[]" placeholder="الإسم">
            </div>
        </div>
        <div class="col-sm-2">
            <div class="mb-3">
                <button onclick="education_fields();" class="btn rounded-pill px-4 btn-light-success text-success font-weight-medium waves-effect waves-light" type="button">
                    <i class="fad fa-plus feather-sm fill-white"></i>

                </button>

            </div>
        </div>
    </div>

</form>
