<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOptional extends Model
{
    use HasFactory;

    protected $table = 'order_optional';

    protected $fillable = ['order_id','optional_id'];
}
