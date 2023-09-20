<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\HasRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name_en',
        'last_name_en',
        'first_name_ar',
        'last_name_ar',
        'email',
        'phone',
        'password',
        'role_id',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'registeration',
        'is_admin',
        'name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all of the noteCategories for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function noteCategories(): HasMany
    {
        return $this->hasMany(NoteCategory::class);
    }
    public function editMarks(): HasMany
    {
        return $this->hasMany(EditMark::class);
    }

    /**
     * Get all of the notes for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes(): HasManyThrough
    {
        return $this->hasManyThrough(Note::class, NoteCategory::class);
    }

    /**
     * Get all of the courses for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function registeration(): HasOne
    {
        return $this->hasOne(AcademicRegistration::class);
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

    protected function department(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->teacher?->department ?? $this->registeration?->department,
        );
    }

    protected function section(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->teacher?->department->section ?? $this->registeration?->department->section,
        );
    }

    public function firebaseTokens()
    {
        return $this->hasMany(UserFirebaseToken::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }


    protected function savedPosts(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->saves()->with('post')->get()->pluck('post')->flatten(),
        );
    }
}
