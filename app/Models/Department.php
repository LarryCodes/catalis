<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'partner_id',
        'name',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
