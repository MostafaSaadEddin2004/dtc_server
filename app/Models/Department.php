<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'certificate_type_id',
        'section_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'certificate_type_id' => 'integer',
        'section_id' => 'integer',
    ];

    public function departmentMarks(): HasMany
    {
        return $this->hasMany(DepartmentMark::class);
    }

    public function academicRegistrations(): HasMany
    {
        return $this->hasMany(AcademicRegistration::class);
    }

    public function certificateType(): BelongsTo
    {
        return $this->belongsTo(CertificateType::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }
}
