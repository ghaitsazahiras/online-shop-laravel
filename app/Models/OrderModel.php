<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    public $timestamps = false;

    protected $fillable = ['adm_id', 'cust_id', 'date'];
}
