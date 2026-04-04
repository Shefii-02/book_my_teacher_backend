<?php

namespace App\Models\ChatModule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model
{
  use SoftDeletes;
  protected $connection = 'mysql2';
  protected $table = 'users';
}
