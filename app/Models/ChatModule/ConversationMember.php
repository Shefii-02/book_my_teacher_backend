<?php

namespace App\Models\ChatModule;

use Illuminate\Database\Eloquent\Model;


class ConversationMember extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'conversation_members';

    public function messages()
  {
    return $this->hasMany(Message::class, 'conversation_id');
  }

  public function user()
  {
    return $this->hasOne(User::class, 'user_id','user_id');
  }

  public function users()
  {
    return $this->belongsToMany(User::class, 'conversation_members', 'conversation_id', 'user_id');
  }
}
