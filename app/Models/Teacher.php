<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate',
        'specialty',
        'birth_date',
        'current_location',
        'permanent_location',
        'nationality',
        'department_id',
    ];

    protected $casts = [
        'id' => 'integer',
        'birth_date' => 'date',
        'department_id' => 'integer',
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->first_name_en,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
