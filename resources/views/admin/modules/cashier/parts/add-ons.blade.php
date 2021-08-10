@if (count($addOns))
    <div class="table-responsive mt-3">
        <table class="table v-middle no-wrap mb-0" style=" overflow-y:scroll;height:200px;  display:block;">
            <thead>
            <tr>
                <th class="border-0" >الكود</th>
                <th class="border-0">الاسم</th>
                <th class="border-0">السعر</th>
                <th class="border-0">التحكم</th>
            </tr>
            </thead>
            <tbody>
            @foreach($addOns as $addOn)
                <tr>
                    <td><span>{{$addOn->id}}</span></td>
                    <td>{{$addOn->title}}</td>
                    <td>{{$addOn->price}}</td>
                    <td><input type="checkbox" att_price="{{$addOn->price}}" value="{{$addOn->id}}" name="add_ons[]" class="add_ons"></td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>
@else
    <div class="col-md-12 mt-5  text-center " >

        <i class="fad fa-shopping-cart" style="font-size: 50px;
    color: #d83141;"></i>
        <h4 class="text-center mt-5" style="background: white;
    color: #949494;
    padding: 15px 0;">    لا يوجد إضافات    </h4>
    </div>
@endif
