<form action="{{route('tickets.update',$ticket->id)}}" method="post" id="Form">
    @csrf
    @method('PUT')
    <div class="row mt-2 mb-2 p-3 text-center">
        <button type="button" class="btn d-flex btn-light-success w-100 d-block text-info font-weight-medium">
            تعديل  تذكرة
        </button>
    </div>

    <div class="row">

        <div class="col-lg-6 col-sm-6 mb-6">
            <label class="label mb-2 "> قيمة التذكرة بالجنيه</label>
            <input type="text" name="price"  value="{{$ticket->price}}" class="form-control numbersOnly" data-validation="required">
        </div>


        <div class="col-lg-6 col-sm-6 mb-6">
            <label class="label mb-2 ">مدة التذكرة بالدقائق </label>
            <input type="number" min="1" name="minutes_count" value="{{$ticket->minutes_count}}" class="form-control" data-validation="required">
        </div>


    </div>

</form>
