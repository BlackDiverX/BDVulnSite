<?php
// flags.php
// Хеши флагов. Оригиналы восстановить без FLAG_SECRET невозможно.
// Для смены секрета — поменяй FLAG_SECRET в .env и пересчитай хеши
// командой: FLAG_SECRET=... php tools/hash_flag.php "flag{...}"

$secret = getenv('FLAG_SECRET') ?: 'bdvulnsite-ctf-secret-2026';

return [
    'sqli_auth'       => hash_hmac('sha256', 'flag{sql_1nj3ct10n_1s_st1ll_al1v3_1n_2026}', $secret),
    'sqli_union'      => hash_hmac('sha256', 'flag{un10n_s3l3ct_g0_brrrr}', $secret),
    'xss_reflected'   => hash_hmac('sha256', "flag{<script>alert('xss')</script>}", $secret),
    'xss_stored'      => hash_hmac('sha256', 'flag{st0r3d_xss_1s_just_p3rs1st3nt}', $secret),
    'cmd_injection'   => hash_hmac('sha256', 'flag{;cat_/etc/passwd}', $secret),
    'lfi'             => hash_hmac('sha256', 'flag{../../../../etc/passwd}', $secret),
    'csrf'            => hash_hmac('sha256', 'flag{csrf_1s_l1k3_tru5t_1ssu3s}', $secret),
    'data_disclosure' => hash_hmac('sha256', 'flag{3rr0r_m3ss4g3s_4r3_fr33_1nt3l}', $secret),
];