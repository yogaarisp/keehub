<?php

namespace App\Services;

use App\Models\Setting;

class WhatsAppService
{
    public static function number(): string
    {
        return preg_replace('/[^0-9]/', '', Setting::get('whatsapp_number', '')) ?: '';
    }

    public static function link(string $message): ?string
    {
        $number = self::number();
        if (! $number) {
            return null;
        }

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }

    public static function productInquiry(string $productName, ?string $productUrl = null): ?string
    {
        $message = "Halo KeeHub, saya ingin menanyakan produk {$productName}.";

        if ($productUrl) {
            $message .= "\n{$productUrl}";
        }

        return self::link($message);
    }

    public static function customBuildRequest(): ?string
    {
        return self::link('Halo KeeHub, saya ingin konsultasi custom build PC.');
    }

    public static function serviceRequest(): ?string
    {
        return self::link('Halo KeeHub, saya ingin request service PC.');
    }
}
