<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQueryReply extends Model
{
    protected $fillable = ['contact_query_id', 'user_id', 'message'];

    public function contactQuery()
    {
        return $this->belongsTo(ContactQuery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
