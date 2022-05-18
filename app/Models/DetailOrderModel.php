<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrderModel extends Model
{
    protected $table = 'detail_order';
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'qty'];
}
