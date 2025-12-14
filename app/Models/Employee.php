<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    protected $fillable = [
        'employee_number',
        'partner_id',
        'site_id',
        'department_id',
        'tenure_id',
        'shift_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'nationality',
        'national_id_number',
        'nssf_number',
        'tin_number',
        'marital_status',
        'next_of_kin_name',
        'next_of_kin_relationship',
        'next_of_kin_phone',
        'next_of_kin_address',
        'address',
        'district',
        'area_lc1',
        'bank_name',
        'bank_branch',
        'bank_account_name',
        'bank_account_number',
        'daily_wage',
        'management_fee',
        'active',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'daily_wage' => 'decimal:2',
        'management_fee' => 'decimal:2',
        'active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($employee) {
            if (!$employee->employee_number) {
                $employee->employee_number = self::generateEmployeeNumber($employee->partner_id);
            }
        });
    }

    /**
     * Generate employee number in format: C001E0001
     * Partner code (without dash) + E + sequential number per partner
     */
    private static function generateEmployeeNumber($partnerId): string
    {
        $partner = Partner::find($partnerId);
        if (!$partner) {
            return 'E' . str_pad(self::count() + 1, 4, '0', STR_PAD_LEFT);
        }

        // Get partner code without dash (C-001 -> C001)
        $partnerCode = str_replace('-', '', $partner->partner_code);

        // Get next sequence for this partner
        $lastEmployee = self::where('partner_id', $partnerId)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastEmployee && preg_match('/E(\d+)$/', $lastEmployee->employee_number, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }

        return $partnerCode . 'E' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function tenure(): BelongsTo
    {
        return $this->belongsTo(Tenure::class);
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
