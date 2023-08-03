<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'father_name',
        'mother_name',
        'date_of_birth',
        'place_of_birth',
        'military',
        'full_name_en',
        'current_address',
        'address',
        'name_of_parent',
        'job_of_parent',
        'phone_of_parent',
        'phone_of_mother',
        'telephone_fix',
        'avg_mark',
        'certificate_year',
        'id_image',
        'certificate_image',
        'personal_image',
        'un_image',
        'user_id',
        'department_id',
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
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
