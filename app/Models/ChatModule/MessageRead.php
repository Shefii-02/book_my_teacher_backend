<?php

namespace App\Models\ChatModule;

use Illuminate\Database\Eloquent\Model;


class MessageRead extends Model
{
  public $timestamps = false;
  protected $connection = 'mysql2';
  protected $table = 'message_reads';

  protected $dates = ['read_at'];

  public function message()
  {
    return $this->belongsTo(Message::class, 'message_id');
  }
}
