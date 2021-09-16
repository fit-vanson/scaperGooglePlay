<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyWords extends Model
{
    use HasFactory;
    protected $table = 'tbl_keywords';
    protected $guarded = [];
}
