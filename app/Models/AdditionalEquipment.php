<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalEquipment extends Model
{
    use HasFactory, SoftDeletes;
    public $guarded = [];
}