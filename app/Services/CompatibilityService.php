<?php

namespace App\Services;

use App\Models\CompatibilityRule;
use App\Models\PcBuild;

class CompatibilityService
{
    public const COMPATIBLE = 'compatible';

    public const WARNING = 'warning';

    public const INCOMPATIBLE = 'incompatible';

    private static ?array $rules = null;

    public static function check(array $selectedProducts): array
    {
        $results = [];

        foreach (self::pairChecks() as $pair) {
            $result = $pair($selectedProducts);
            if ($result !== null) {
                $results[] = $result;
            }
        }

        $psuResult = self::checkPowerNeeds($selectedProducts);
        if ($psuResult !== null) {
            $results[] = $psuResult;
        }

        $overall = self::overall($results);

        return [
            'overall' => $overall,
            'checks' => $results,
        ];
    }

    public static function checkBuild(PcBuild $build): array
    {
        $build->load('items.product.specs');

        $selected = [];
        foreach ($build->items as $item) {
            if ($item->product) {
                $selected[$item->slot] = $item->product;
            }
        }

        return self::check($selected);
    }

    private static function overall(array $results): string
    {
        if (collect($results)->contains(fn ($r) => $r['status'] === self::INCOMPATIBLE)) {
            return self::INCOMPATIBLE;
        }

        if (collect($results)->contains(fn ($r) => $r['status'] === self::WARNING)) {
            return self::WARNING;
        }

        return self::COMPATIBLE;
    }

    private static function pairChecks(): array
    {
        return [
            'cpu_motherboard_socket' => fn ($p) => self::checkCpuMotherboard($p),
            'ram_motherboard_generation' => fn ($p) => self::checkRamMotherboard($p),
            'ram_motherboard_capacity' => fn ($p) => self::checkRamCapacity($p),
            'motherboard_case_formfactor' => fn ($p) => self::checkCaseFormFactor($p),
            'gpu_case_length' => fn ($p) => self::checkGpuLength($p),
            'cooler_case_height' => fn ($p) => self::checkCoolerHeight($p),
        ];
    }

    private static function checkCpuMotherboard(array $p): ?array
    {
        $cpu = $p['cpu'] ?? null;
        $mb = $p['motherboard'] ?? null;
        if (! $cpu || ! $mb) {
            return null;
        }

        $cpuSocket = $cpu->specValue('socket');
        $mbSocket = $mb->specValue('socket');

        if (! $cpuSocket || ! $mbSocket) {
            return self::result('cpu_motherboard_socket', 'CPU ↔ Motherboard (Socket)', self::WARNING, 'Data socket tidak lengkap pada salah satu komponen.');
        }

        if (strcasecmp($cpuSocket, $mbSocket) === 0) {
            return self::result('cpu_motherboard_socket', 'CPU ↔ Motherboard (Socket)', self::COMPATIBLE, "Socket match: {$cpuSocket}.");
        }

        return self::result('cpu_motherboard_socket', 'CPU ↔ Motherboard (Socket)', self::INCOMPATIBLE, "Socket CPU {$cpuSocket} tidak cocok dengan motherboard {$mbSocket}.");
    }

    private static function checkRamMotherboard(array $p): ?array
    {
        $ram = $p['ram'] ?? null;
        $mb = $p['motherboard'] ?? null;
        if (! $ram || ! $mb) {
            return null;
        }

        $ramGen = $ram->specValue('generation');
        $mbRamType = $mb->specValue('ram_type');

        if (! $ramGen || ! $mbRamType) {
            return self::result('ram_motherboard_generation', 'RAM ↔ Motherboard (DDR Generation)', self::WARNING, 'Data tipe RAM tidak lengkap.');
        }

        if (strcasecmp($ramGen, $mbRamType) === 0) {
            return self::result('ram_motherboard_generation', 'RAM ↔ Motherboard (DDR Generation)', self::COMPATIBLE, "Tipe RAM match: {$ramGen}.");
        }

        return self::result('ram_motherboard_generation', 'RAM ↔ Motherboard (DDR Generation)', self::INCOMPATIBLE, "RAM {$ramGen} tidak cocok dengan motherboard yang mendukung {$mbRamType}.");
    }

    private static function checkRamCapacity(array $p): ?array
    {
        $ram = $p['ram'] ?? null;
        $mb = $p['motherboard'] ?? null;
        if (! $ram || ! $mb) {
            return null;
        }

        $ramCapacity = $ram->specNumeric('capacity_gb');
        $mbMax = $mb->specNumeric('max_ram_gb');

        if (! $ramCapacity || ! $mbMax) {
            return null;
        }

        if ($ramCapacity <= $mbMax) {
            return self::result('ram_motherboard_capacity', 'RAM ↔ Motherboard (Kapasitas)', self::COMPATIBLE, "Kapasitas RAM {$ramCapacity}GB dalam batas maksimum {$mbMax}GB.");
        }

        return self::result('ram_motherboard_capacity', 'RAM ↔ Motherboard (Kapasitas)', self::INCOMPATIBLE, "Kapasitas RAM {$ramCapacity}GB melebihi maksimum motherboard {$mbMax}GB.");
    }

    private static function checkCaseFormFactor(array $p): ?array
    {
        $mb = $p['motherboard'] ?? null;
        $case = $p['case'] ?? null;
        if (! $mb || ! $case) {
            return null;
        }

        $mbForm = $mb->specValue('form_factor');
        $supported = $case->specValue('supported_form_factors');

        if (! $mbForm || ! $supported) {
            return null;
        }

        $supportedList = array_map('trim', preg_split('/[\/,]+/', strtolower($supported)));

        if (in_array(strtolower($mbForm), $supportedList, true)) {
            return self::result('motherboard_case_formfactor', 'Motherboard ↔ Casing (Form Factor)', self::COMPATIBLE, "Casing mendukung {$mbForm}.");
        }

        return self::result('motherboard_case_formfactor', 'Motherboard ↔ Casing (Form Factor)', self::INCOMPATIBLE, "Casing tidak mendukung form factor {$mbForm}. Didukung: {$supported}.");
    }

    private static function checkGpuLength(array $p): ?array
    {
        $gpu = $p['gpu'] ?? null;
        $case = $p['case'] ?? null;
        if (! $gpu || ! $case) {
            return null;
        }

        $gpuLength = $gpu->specNumeric('length_mm');
        $clearance = $case->specNumeric('gpu_clearance_mm');

        if (! $gpuLength || ! $clearance) {
            return null;
        }

        if ($gpuLength <= $clearance) {
            return self::result('gpu_case_length', 'GPU ↔ Casing (Panjang)', self::COMPATIBLE, "GPU {$gpuLength}mm cukup (clearance {$clearance}mm).");
        }

        return self::result('gpu_case_length', 'GPU ↔ Casing (Panjang)', self::INCOMPATIBLE, "Panjang GPU {$gpuLength}mm melebihi clearance casing {$clearance}mm.");
    }

    private static function checkCoolerHeight(array $p): ?array
    {
        $cooler = $p['cooler'] ?? null;
        $case = $p['case'] ?? null;
        if (! $cooler || ! $case) {
            return null;
        }

        $height = $cooler->specNumeric('height_mm');
        $clearance = $case->specNumeric('cooler_clearance_mm');

        if (! $height || ! $clearance) {
            return null;
        }

        if ($height <= $clearance) {
            return self::result('cooler_case_height', 'Cooler ↔ Casing (Tinggi)', self::COMPATIBLE, "Tinggi cooler {$height}mm cukup (clearance {$clearance}mm).");
        }

        return self::result('cooler_case_height', 'Cooler ↔ Casing (Tinggi)', self::INCOMPATIBLE, "Tinggi cooler {$height}mm melebihi clearance casing {$clearance}mm.");
    }

    private static function checkPowerNeeds(array $p): ?array
    {
        $psu = $p['psu'] ?? null;
        if (! $psu) {
            return null;
        }

        $estimate = PowerCalculatorService::estimate($p);
        $psuWatt = $psu->specNumeric('wattage') ?? $psu->specNumeric('watt');

        if (! $psuWatt) {
            return self::result('gpu_psu_wattage', 'PSU ↔ Kebutuhan Daya', self::WARNING, 'Data wattage PSU tidak tersedia.');
        }

        $recommended = PowerCalculatorService::recommendedPsu($p);

        if ($psuWatt >= $recommended) {
            return self::result('gpu_psu_wattage', 'PSU ↔ Kebutuhan Daya', self::COMPATIBLE, "PSU {$psuWatt}W memadai (rekomendasi {$recommended}W).");
        }

        if ($psuWatt >= $estimate['total']) {
            return self::result('gpu_psu_wattage', 'PSU ↔ Kebutuhan Daya', self::WARNING, "PSU {$psuWatt}W berada di batas minimum. Rekomendasi: {$recommended}W.");
        }

        return self::result('gpu_psu_wattage', 'PSU ↔ Kebutuhan Daya', self::INCOMPATIBLE, "PSU {$psuWatt}W tidak mencukupi. Estimasi kebutuhan sistem {$estimate['total']}W, rekomendasi {$recommended}W.");
    }

    private static function result(string $key, string $title, string $status, string $message): array
    {
        $rule = CompatibilityRule::query()->where('rule_key', $key)->where('is_active', true)->first();
        if ($rule && isset($rule->params['disabled']) && $rule->params['disabled']) {
            return [
                'key' => $key,
                'title' => $title,
                'status' => self::COMPATIBLE,
                'message' => 'Rule dinonaktifkan oleh admin.',
            ];
        }

        return [
            'key' => $key,
            'title' => $title,
            'status' => $status,
            'message' => $message,
        ];
    }
}
