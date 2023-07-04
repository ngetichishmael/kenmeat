<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $guarded = [];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function response()
    {
        return $this->hasMany(Response::class);
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    // use HasFactory;

    // protected $fillable=[
    //     'body',
    //     'sender_id',
    //     'receiver_id',
    //     'conversation_id',
    //     'read_at',
    //     'receiver_deleted_at',
    //     'sender_deleted_at',
    // ];


    // protected $dates=['read_at','receiver_deleted_at','sender_deleted_at'];


    // /* relationship */

    // public function conversation()
    // {
    //     return $this->belongsTo(Conversation::class);
    // }


    // public function isRead():bool
    // {

    //      return $this->read_at != null;
    // }
}