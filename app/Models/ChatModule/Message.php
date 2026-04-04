<?php

namespace App\Models\ChatModule;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{

  // use SoftDeletes;
  protected $connection = 'mysql2';
  protected $table = 'messages';

  public function reads()
  {
    return $this->hasMany(MessageRead::class, 'message_id');
  }
}
