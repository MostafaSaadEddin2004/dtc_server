<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasImage
{
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => asset('storage/' . $value),
        );
    }

    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => asset('storage/' . $value),
        );
    }
}