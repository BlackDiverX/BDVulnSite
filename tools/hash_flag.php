<?php
// tools/hash_flag.php
// CLI-утилита для генерации HMAC-хеша флага.
// Запуск: FLAG_SECRET=... php tools/hash_flag.php "flag{...}"

if (PHP_SAPI !== 'cli') {
    die('Только CLI');
}

if ($argc < 2) {
    die("Использование: FLAG_SECRET=... php hash_flag.php \"flag{...}\"\n");
}

$secret = getenv('FLAG_SECRET');
if (!$secret) {
    die("Не задан FLAG_SECRET\n");
}

echo hash_hmac('sha256', $argv[1], $secret) . "\n";