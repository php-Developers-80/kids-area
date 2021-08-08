<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    protected $guarded = [];

    //------------------- relations  -----------------------
    public function sons()
    {
        return $this->hasMany(Customer::class,'parent_id');
    }

}//end class
