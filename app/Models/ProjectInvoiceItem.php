<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectInvoiceItem extends Model
{
    protected $fillable = [
        'project_invoice_id',
        'item_name',
        'description',
        'quantity',
        'unit',
        'price',
        'total',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'integer',
            'total' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function projectInvoice(): BelongsTo
    {
        return $this->belongsTo(ProjectInvoice::class);
    }
}
