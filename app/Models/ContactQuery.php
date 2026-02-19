<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read', // Deprecated, use status
        'status',
    ];

    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETE = 'complete';
    public function replies()
    {
        return $this->hasMany(ContactQueryReply::class);
    }
}
