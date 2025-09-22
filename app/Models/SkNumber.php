<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkNumber extends Model
{
    use HasFactory;
    
    protected $fillable = ['sk_number', 'date', 'is_verified'];

}
