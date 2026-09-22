<?php

namespace App\Services;

use App\Models\Product;

class PowerCalculatorService
{
    private const DEFAULT_MOTHERBOARD_WATT = 50;

    private const DEFAULT_RAM_WATT = 5;

    private const DEFAULT_STORAGE_WATT = 5;

    private const FAN_WATT = 5;

    private const DEFAULT_FAN_COUNT = 3;

    private const SAFETY_MARGIN = 0.3;

    public static function estimate(array $products): array
    {
        $breakdown = [];
        $total = 0;

        $cpu = $products['cpu'] ?? null;
        if ($cpu instanceof Product) {
            $watt = $cpu->specNumeric('tdp_watt') ?? $cpu->specNumeric('tdp') ?? 65;
            $breakdown['cpu'] = (int) $watt;
            $total += $watt;
        }

        $gpu = $products['gpu'] ?? null;
        if ($gpu instanceof Product) {
            $watt = $gpu->specNumeric('power_consumption_watt') ?? $gpu->specNumeric('tdp_watt') ?? 150;
            $breakdown['gpu'] = (int) $watt;
            $total += $watt;
        }

        if ($products['motherboard'] ?? null) {
            $breakdown['motherboard'] = self::DEFAULT_MOTHERBOARD_WATT;
            $total += self::DEFAULT_MOTHERBOARD_WATT;
        }

        $ram = $products['ram'] ?? null;
        if ($ram instanceof Product) {
            $watt = $ram->specNumeric('power_watt') ?? self::DEFAULT_RAM_WATT;
            $breakdown['ram'] = (int) $watt;
            $total += $watt;
        }

        if ($products['storage'] ?? null) {
            $breakdown['storage'] = self::DEFAULT_STORAGE_WATT;
            $total += self::DEFAULT_STORAGE_WATT;
        }

        if ($products['cooler'] ?? null) {
            $breakdown['fans'] = self::FAN_WATT * self::DEFAULT_FAN_COUNT;
            $total += $breakdown['fans'];
        }

        return [
            'breakdown' => $breakdown,
            'total' => (int) ceil($total),
        ];
    }

    public static function recommendedPsu(array $products): int
    {
        $estimate = self::estimate($products);
        $recommended = $estimate['total'] * (1 + self::SAFETY_MARGIN);

        return self::standardWattage((int) ceil($recommended));
    }

    private static function standardWattage(int $watt): int
    {
        $standards = [300, 400, 450, 500, 550, 600, 650, 750, 850, 1000, 1200, 1500];

        foreach ($standards as $standard) {
            if ($watt <= $standard) {
                return $standard;
            }
        }

        return ceil($watt / 100) * 100;
    }
}
