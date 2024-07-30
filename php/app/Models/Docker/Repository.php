<?php

declare(strict_types=1);

namespace App\Models\Docker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
