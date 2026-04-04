<?php

namespace App\Models\ChatModule;

use Illuminate\Database\Eloquent\Model;


class Conversation extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'conversations';


  public function messages()
  {
    return $this->hasMany(Message::class, 'conversation_id');
  }

  public function users()
  {
    return $this->belongsToMany(User::class, 'conversation_members', 'conversation_id', 'user_id');
  }

  public function lastMessage()
  {
    return $this->hasOne(Message::class, 'conversation_id')->latestOfMany();
  }
}
