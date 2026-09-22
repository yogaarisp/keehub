<?php

namespace App\Services;

use App\Models\CodeCounter;
use Illuminate\Support\Facades\DB;

class CodeGenerator
{
    /**
     * Generate kode unik secara atomik menggunakan tabel counter.
     *
     * Format: {prefix}-{tanggal}-{nomor 3 digit}.
     * Aman terhadap race condition karena nomor di-lock per hari.
     */
    public static function next(string $prefix, string $dateKey = 'Ymd'): string
    {
        $today = now()->format($dateKey);
        $counterKey = strtoupper($prefix).':'.$today;

        return DB::transaction(function () use ($counterKey, $prefix, $today) {
            $counter = CodeCounter::where('key', $counterKey)
                ->lockForUpdate()
                ->first();

            if (! $counter) {
                $counter = CodeCounter::create(['key' => $counterKey, 'last_number' => 0]);
            }

            $nextNumber = $counter->last_number + 1;

            $counter->update(['last_number' => $nextNumber]);

            return sprintf('%s-%s-%03d', strtoupper($prefix), $today, $nextNumber);
        });
    }
}
