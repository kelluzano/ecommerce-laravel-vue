<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Processing extends Model
{
    // use HasFactory;
    protected $fillable = ['client_name', 'client_address', 'amount', 'order_details', 'user_id'];
}
