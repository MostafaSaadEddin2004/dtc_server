<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'registration_start_at',
        'registration_end_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'registration_start_at' => 'date',
    ];


    protected function isOpen(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->registration_start_at <= now() && $this->registration_end_at >= now(),
        );
    }

    /**
     * Get all of the registerations for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registerations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }


    protected function likes(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->post?->likes()->count(),
        );
    }

    /**
     * The students that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students(): HasMany
    {
        return $this->hasMany(CourseStudent::class);
    }


    /**
     * Get all of the registerations for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function post(): HasOne
    {
        return $this->hasOne(Post::class);
    }
}
