<?php

namespace App\Models\ChatModule;

use Illuminate\Database\Eloquent\Model;


class Conversation extends Model
{
  protected $connection = 'mysql2';
  protected $table = 'conversations';

  protected $fillable = [
    'type',
    'name',
    'avatar_url',
    'created_by',
    'created_at',
    'course_id'
  ];

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


public function members()
{
    return $this->belongsToMany(
        User::class,
        'conversation_members',
        'conversation_id', // pivot -> conversation_id
        'user_id',         // pivot -> user_id
        'id',              // conversations.id
        'user_id'          // users.user_id ✅ (IMPORTANT)
    )->withTimestamps();
}
}
