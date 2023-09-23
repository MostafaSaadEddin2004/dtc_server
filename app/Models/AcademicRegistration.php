<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'father_name',
        'mother_name',
        'date_of_birth',
        'place_of_birth',
        'military',
        'current_address',
        'address',
        'name_of_parent',
        'job_of_parent',
        'phone_of_parent',
        'phone_of_mother',
        'avg_mark',
        'certificate_year',
        'id_image',
        'certificate_image',
        'personal_image',
        'un_image',
        'user_id',
        'department_id',
        'accepted',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_of_birth' => 'date',
        'user_id' => 'integer',
        'department_id' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }
}
