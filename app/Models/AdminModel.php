<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    public $timestamps = false;

    protected $fillable = ['adm_name', 'username', 'password', 'level'];
}
