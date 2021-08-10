@php
    $routing = \App\Models\DynamicSlider::where('id',7)->first();

@endphp
@if ($routing)
    <li class="breadcrumb-item active">
        <a href="{{route('routingBasics.show',$routing->id)}}">{{$routing->ar_title}}</a>
    </li>
@endif
