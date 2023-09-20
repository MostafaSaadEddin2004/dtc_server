<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    /**
     * Get all of the registerations for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registerations(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
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
