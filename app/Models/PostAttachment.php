<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'file_path',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'posts_attachments';

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
