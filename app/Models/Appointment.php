<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['doctor_id', 'patient_id', 'appointment_date'];
    protected $casts = [
        'appointment_date' => 'date:Y-md'
    ];

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->orWhereHas('doctor', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('patient', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function clinicalTests(): BelongsToMany
    {
        return $this->belongsToMany(ClinicalTest::class)->withTimestamps();
    }
}
