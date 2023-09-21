<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasImage
{


    protected function attachment(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => asset('storage/' . $value),
        );
    }
}
