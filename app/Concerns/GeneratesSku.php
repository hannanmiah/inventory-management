<?php

namespace App\Concerns;


use Illuminate\Support\Str;

trait GeneratesSku
{
    public static function bootGeneratesSku(): void
    {
        static::creating(function ($model) {
            if (blank($model->sku)) {
                $model->sku = static::generateUniqueSku();
            }
        });
    }

    public static function generateUniqueSku(): string
    {
        return str(Str::random(8))->append(dechex(time()))->upper();
    }
}