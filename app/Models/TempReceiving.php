<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempReceiving extends Model
{
    use HasFactory;

    protected $fillable = [
      'sys_id',
      'serial_number',
      'user_id',
      'status',
      'delete',
    ];
}
