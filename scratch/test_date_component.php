<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

\Carbon\Carbon::setLocale('id');

$now = \Carbon\Carbon::now();
$dates = [
    '2 menit lalu' => $now->copy()->subMinutes(2),
    '1 jam lalu' => $now->copy()->subHours(1),
    '1 hari lalu' => $now->copy()->subDays(1),
    '2 minggu lalu' => $now->copy()->subWeeks(2),
    '3 bulan lalu' => $now->copy()->subMonths(3),
    '1 tahun lalu' => $now->copy()->subYears(1),
];

foreach ($dates as $label => $date) {
    $exactFull = $date->translatedFormat('d F Y H:i');
    $exactShort = $date->translatedFormat('d M Y');
    $diff = $date->diffForHumans();
    $diffInDays = abs((int) $date->diffInDays($now));
    $isBeyondDays = $diffInDays >= 7;

    echo "=== {$label} ===\n";
    echo "Diff string: {$diff}\n";
    echo "Is Beyond Days (>= 7 days): " . ($isBeyondDays ? 'YES' : 'NO') . "\n";
    echo "Rendered HTML:\n";
    echo '<span title="' . $exactFull . '" class="inline-flex items-center gap-1 cursor-pointer transition-opacity hover:opacity-100">' . "\n";
    echo '    <span>' . $diff . '</span>' . "\n";
    if ($isBeyondDays) {
        echo '    <span class="opacity-50 font-normal">(' . $exactShort . ')</span>' . "\n";
    }
    echo '</span>' . "\n\n";
}
