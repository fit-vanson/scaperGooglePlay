<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveTemp extends Model
{
    use HasFactory;
    protected $table= 'tbl_save_temp';
    protected $guarded=[];
}
