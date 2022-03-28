<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModel extends Model
{
    protected $table = 'customer';
    public $timestamps = false;

    protected $fillable = ['name', 'address', 'telp', 'username', 'password'];
    /* protected $hidden = ['']; 
    $fillable = untuk mengisi data, $hidden = untuk menyembunyikan data*/
}
