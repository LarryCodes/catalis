<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Partner extends Model
{
    protected $fillable = [
        'partner_code',
        'company_name',
        'company_email',
        'company_phone',
        'company_address',
        'contact_person',
        'contact_person_title',
        'contact_email',
        'contact_phone',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($partner) {
            if (empty($partner->partner_code)) {
                $partner->partner_code = static::generateNextPartnerCode();
            }
        });
    }

    public static function generateNextPartnerCode()
    {
        $lastPartner = static::orderBy('id', 'desc')->first();
        
        if ($lastPartner && $lastPartner->partner_code) {
            // Extract number from format C-XXX
            if (preg_match('/C-(\d+)/', $lastPartner->partner_code, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            } else {
                $nextNumber = 1;
            }
        } else {
            $nextNumber = 1;
        }

        return 'C-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
