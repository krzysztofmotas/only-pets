<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostAttachment extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_id',
        'file_name',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts_attachments';

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
