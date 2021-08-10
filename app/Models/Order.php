<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function scopeFilterByDate($query , $from , $to)
    {
        if ($from != null && $to !=null){
            $query->whereDate('created_at','>=',$from)
                ->whereDate('created_at','<=',$to);
        } elseif ($from != null && $to ==null){
            $query->whereDate('created_at','>=',$from);
        } elseif ($from == null && $to !=null){
            $query->whereDate('created_at','<=',$to);
        } else{
            $query->WhereNotNull('id');
        }
    }//end scope

    public function scopeFilterByMoney($query , $from_money , $to_money)
    {
        if ($from_money != null && $to_money !=null){
            $query->where('total_cost','>=',$from_money)
                ->where('total_cost','<=',$to_money);
        } elseif ($from_money != null && $to_money ==null){
            $query->where('total_cost','>=',$from_money);
        } elseif ($from_money == null && $to_money !=null){
            $query->where('total_cost','<=',$to_money);
        } else{
            $query->WhereNotNull('id');
        }
    }//end scope


    public function scopeFilterByClientId($query , $client_id)
    {
        if ($client_id != 0){
            $query->where('customer_id',$client_id);
        } else{
            $query->WhereNotNull('id');
        }
    }

    public function scopeFilterByCode($query , $code)
    {
        if ($code !=null){
            $query->Where('id',$code);
        } else{
            $query->WhereNotNull('id');
        }
    }

    public function scopeFilterByUserId($query , $user_id)
    {
        if ($user_id != 0){
            $query->where('created_by',$user_id);
        } else{
            $query->WhereNotNull('id');
        }
    }





    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }


    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


    public function add_ons()
    {
        return $this->belongsToMany(AddOn::class,'order_add_ons','order_id','add_on_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}//end class
