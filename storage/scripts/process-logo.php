<?php

// Crop ikon dari full logo, buang background, simpan variasi ukuran.
$src = imagecreatefrompng('public/keehub.png');
$w = imagesx($src);
$h = imagesy($src);

$isBackground = function ($rgb) {
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;

    return $r > 225 && $g > 225 && $b > 225 && abs($r - $b) < 12 && abs($r - $g) < 12;
};

$minX = $w; $minY = $h; $maxX = 0; $maxY = 0;
$rowCounts = [];
$step = 4;
for ($y = 0; $y < $h; $y += $step) {
    $rowCounts[$y] = 0;
    for ($x = 0; $x < $w; $x += $step) {
        if (! $isBackground(imagecolorat($src, $x, $y))) {
            $minX = min($minX, $x); $maxX = max($maxX, $x);
            $minY = min($minY, $y); $maxY = max($maxY, $y);
            $rowCounts[$y]++;
        }
    }
}

// Deteksi gap horizontal terbesar di paruh bawah area konten (pemisah ikon vs teks)
$contentH = $maxY - $minY;
$gapStart = null; $gapEnd = null; $bestGap = 0; $curStart = null;
foreach ($rowCounts as $y => $count) {
    if ($y < $minY + $contentH * 0.35 || $y > $maxY) continue;
    if ($count === 0) {
        $curStart ??= $y;
    } else {
        if ($curStart !== null && ($y - $curStart) > $bestGap) {
            $bestGap = $y - $curStart;
            $gapStart = $curStart;
            $gapEnd = $y;
        }
        $curStart = null;
    }
}

if ($gapStart !== null && $bestGap > 8) {
    $iconTop = $minY;
    $iconBottom = $gapStart - 2;
} else {
    $iconTop = $minY;
    $iconBottom = (int) ($minY + $contentH * 0.60);
}

// Batas kiri/kanan khusus baris ikon
$iconLeft = $w; $iconRight = 0;
for ($y = $iconTop; $y <= $iconBottom; $y += $step) {
    for ($x = $minX; $x <= $maxX; $x += $step) {
        if (! $isBackground(imagecolorat($src, $x, $y))) {
            $iconLeft = min($iconLeft, $x); $iconRight = max($iconRight, $x);
        }
    }
}

$iconW = $iconRight - $iconLeft;
$iconH = $iconBottom - $iconTop;
$size = max($iconW, $iconH);
$cx = $iconLeft + (int) ($iconW / 2);
$cy = $iconTop + (int) ($iconH / 2);
$cropX = max(0, $cx - (int) ($size / 2));
$cropY = max(0, $cy - (int) ($size / 2));
$size = min($size, $w - $cropX, $h - $cropY);

echo "icon: {$iconLeft},{$iconTop} → {$iconRight},{$iconBottom} (gap at {$gapStart})\n";

// Master kerja 512px — flood fill jauh lebih ringan
$master = 512;
$icon = imagecreatetruecolor($master, $master);
imagealphablending($icon, false);
imagesavealpha($icon, true);
imagefill($icon, 0, 0, imagecolorallocatealpha($icon, 0, 0, 0, 127));
imagecopyresampled($icon, $src, 0, 0, $cropX, $cropY, $master, $master, $size, $size);
imagedestroy($src);

$pw = $master;
$ph = $master;
$alphaMap = [];
$queue = new SplStack;

for ($x = 0; $x < $pw; $x++) {
    $queue->push([$x, 0]); $queue->push([$x, $ph - 1]);
}
for ($y = 0; $y < $ph; $y++) {
    $queue->push([0, $y]); $queue->push([$pw - 1, $y]);
}

while (! $queue->isEmpty()) {
    [$x, $y] = $queue->pop();
    if ($x < 0 || $y < 0 || $x >= $pw || $y >= $ph) continue;
    $key = $y * $pw + $x;
    if (isset($alphaMap[$key])) continue;

    $rgb = imagecolorat($icon, $x, $y);
    $r = ($rgb >> 16) & 0xFF; $g = ($rgb >> 8) & 0xFF; $b = $rgb & 0xFF;

    if ($r > 228 && $g > 228 && $b > 228 && abs($r - $b) < 14 && abs($r - $g) < 14) {
        $alphaMap[$key] = true;
        $queue->push([$x + 1, $y]); $queue->push([$x - 1, $y]);
        $queue->push([$x, $y + 1]); $queue->push([$x, $y - 1]);
    }
}

echo 'transparent px: '.count($alphaMap)."\n";

imagealphablending($icon, true);
foreach ($alphaMap as $key => $void) {
    $x = $key % $pw;
    $y = (int) ($key / $pw);
    $edge = false;
    foreach ([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$dx, $dy]) {
        $nx = $x + $dx; $ny = $y + $dy;
        if ($nx < 0 || $ny < 0 || $nx >= $pw || $ny >= $ph) continue;
        if (! isset($alphaMap[$ny * $pw + $nx])) { $edge = true; break; }
    }
    $c = imagecolorat($icon, $x, $y);
    $newColor = imagecolorallocatealpha($icon, ($c >> 16) & 0xFF, ($c >> 8) & 0xFF, $c & 0xFF, $edge ? 40 : 127);
    imagesetpixel($icon, $x, $y, $newColor);
}

imagealphablending($icon, false);
$targets = [
    'public/logo.png' => 512,
    'public/logo-192.png' => 192,
    'public/logo-96.png' => 96,
    'public/favicon-32.png' => 32,
];

foreach ($targets as $path => $target) {
    if ($target === $master) {
        imagepng($icon, $path, 6);
    } else {
        $out = imagecreatetruecolor($target, $target);
        imagealphablending($out, false);
        imagesavealpha($out, true);
        imagefill($out, 0, 0, imagecolorallocatealpha($out, 0, 0, 0, 127));
        imagecopyresampled($out, $icon, 0, 0, 0, 0, $target, $target, $pw, $ph);
        imagepng($out, $path, 6);
        imagedestroy($out);
    }
    echo "saved: {$path} ({$target}x{$target})\n";
}

echo "done\n";
