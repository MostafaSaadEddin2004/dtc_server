<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        // 'certificate_type_id',
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


    protected function markOfThisYear(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->departmentMarks()->where('year', now()->year)->first()->mark,
        );
    }

    public function departmentMarks(): HasMany
    {
        return $this->hasMany(DepartmentMark::class);
    }

    public function academicRegistrations(): HasMany
    {
        return $this->hasMany(AcademicRegistration::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(Wish::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(AcademicStudent::class);
    }

    public function certificateType()
    {
        return $this->belongsToMany(CertificateType::class);
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
