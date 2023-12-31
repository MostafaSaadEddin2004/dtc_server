<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    use HasImage;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'attachment',
        'attachment_type',
        'user_id',
        'department_id',
        'course_id',
        'post_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'department_id' => 'integer',
        'course_id' => 'integer',
        'post_type_id' => 'integer',
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function saves(): HasMany
    {
        return $this->hasMany(Save::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    protected function department(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->section,
        );
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function postType(): BelongsTo
    {
        return $this->belongsTo(PostType::class);
    }
}
