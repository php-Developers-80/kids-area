{{--------------------------- basic form -------------------------------}}
<div class="row">

    <div class="col-lg-6 col-md-6  mb-3">
        <label class="label mb-2 " for="name"> اسم ولى الأمر </label>
        <input  type="text"  name="name" value="{{$client->name}}" class="form-control" data-validation="required">
    </div>


    <div class="col-lg-6 col-md-6  mb-3">
        <label class="label mb-2 " for="phone"> الهاتف </label>
        <input type="text" name="phone"  value="{{$client->phone}}" class="form-control" data-validation="required">
    </div>


</div>
{{------------------------  is_there_son accounts ---------------------------------}}
<div class="row mt-2 mb-2 p-3 text-center">
    <div class="col-12">
        <span id="addChild" class="btn rounded-pill px-4 btn-light-success text-success font-weight-medium waves-effect waves-light" type="button">
            <i class="fad fa-plus feather-sm fill-white"></i>
            أضف أسماء الأولاد
        </span>
    </div>
</div>

<div id="education_fields" class="my-4 accountDiv"></div>

@foreach ($client->sons as $son )

    @php
        $room = rand(1111,9999)."-".$son->id;
    @endphp
    <div class="removeclass{{$room}}">
        <div class="row">
            <div class="col-sm-10">
                <div class="mb-3">
                    <input  data-validation="required" value="{{$son->name}}" type="text" class="form-control SonToSum"  name="son_name_old[]" placeholder="الإسم">
                    <input  data-validation="required" value="{{$son->id}}" type="hidden" class="form-control"  name="son_name_id_old[]" placeholder="الإسم">
                </div>
            </div>

            <div class="col-sm-2">
                <div class="form-group">
                    <button class="btn btn-danger removeDiv" type="button" attr-value="{{$room}}">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endforeach()
