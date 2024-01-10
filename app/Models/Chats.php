<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_AI_resp',
        'attachment_type',
        'chat',
        'filepath'
    ];

    protected $hidden = [
        'note_id',
        'order',
        'user_id',
        'profile_id',
        'folder_id',   
    ];
}
