<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'file',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts_attachments';
}
