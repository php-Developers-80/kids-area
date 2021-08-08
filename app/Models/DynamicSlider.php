<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicSlider extends Model
{
    protected $guarded = [];

    public function sub_dynamic_slider()
    {
        return $this->hasMany(DynamicSlider::class,'parent_id')
            ->orderBy('order_number','asc');
    }

    public function parent_dynamic_slider()
    {
        return $this->belongsTo(DynamicSlider::class,'parent_id');
    }
}//end class
