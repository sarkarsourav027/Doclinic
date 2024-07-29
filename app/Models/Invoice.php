<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'invoice_date', 'clinical_test_amount', 'invoice_amount', 'payment_mode', 'is_gst_bill', 'gst_percentage', 'invoice_file'];

    protected $casts = [
        'is_gst_bill' => 'boolean',
    ];

    /*public function clinicalTests(): BelongsToMany
    {
        return $this->belongsToMany(ClinicalTest::class, 'clinical_test_invoice', 'invoice_id', 'clinical_test_id')
            ->withPivot('clinical_test_amount');
    }*/

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('invoice_number', 'like', '%' . $search . '%');
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
