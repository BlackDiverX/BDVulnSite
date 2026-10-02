<?php
// checklist.php
session_start();

$flags = require('flags.php');

$tasks = [
    'sqli_auth' => [
        'title' => 'Обход аутентификации',
        'hint'  => 'Говорят, панель администратора можно открыть без пароля. Проверьте форму входа.',
    ],
    'sqli_union' => [
        'title' => 'Утечка через поиск',
        'hint'  => 'Поиск отзывов доверяет вводу слишком сильно. Возможно, из базы можно достать больше, чем отзывы.',
    ],
    'xss_reflected' => [
        'title' => 'Отражённый ввод',
        'hint'  => 'Некоторые параметры возвращаются на страницу без обработки.',
    ],
    'xss_stored' => [
        'title' => 'Сохранённый ввод',
        'hint'  => 'То, что вы сохраняете, видят и другие. Иногда это опасно.',
    ],
    'cmd_injection' => [
        'title' => 'Выполнение на сервере',
        'hint'  => 'Страница мониторинга умеет запускать процессы. А что ещё она умеет?',
    ],
    'lfi' => [
        'title' => 'Чтение файлов',
        'hint'  => 'Страница мониторинга читает файлы. Не только те, что вы ожидаете.',
    ],
    'csrf' => [
        'title' => 'Действие от чужого имени',
        'hint'  => 'Форма добавления отзыва не проверяет, кто её отправил. Загляните в исходник страницы.',
    ],
    'data_disclosure' => [
        'title' => 'Лишняя информация',
        'hint'  => 'Некоторые ошибки рассказывают больше, чем должны.',
    ],
];

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['task_id']) && isset($_POST['flag'])) {
    $taskId = $_POST['task_id'];
    $flag = trim($_POST['flag']);

    if (!isset($flags[$taskId])) {
        $message = 'Неизвестное задание.';
        $messageType = 'error';
    } else {
        $secret = getenv('FLAG_SECRET') ?: 'bdvulnsite-ctf-secret-2026';
        $expected = $flags[$taskId];
        $given = hash_hmac('sha256', $flag, $secret);
        if (hash_equals($expected, $given)) {
            $_SESSION['solved'][$taskId] = true;
            $message = 'Верно! Уязвимость отмечена как пройденная.';
            $messageType = 'success';
        } else {
            $message = 'Неверный флаг.';
            $messageType = 'error';
        }
    }
}

$solved = $_SESSION['solved'] ?? [];
$total = count($tasks);
$done = count(array_intersect_key($solved, $tasks));
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Чеклист уязвимостей — BD VulnSite</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="comments">
    <div class="header">
        <img src="logo.png" alt="logo">Чеклист уязвимостей
    </div>
    <hr>
    <div class="menu">
        <a href="index.html">Главная</a>
        <a href="login.php">Вход</a>
        <a href="comments.php">Отзывы</a>
        <a href="monitor.php?page=ps">Мониторинг</a>
    </div>
    <hr>

    <p>Прогресс: <b><?= $done ?> / <?= $total ?></b></p>

    <?php if ($message): ?>
        <p class="<?= $messageType === 'success' ? 'flag-success' : 'flag-error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>

    <?php foreach ($tasks as $id => $task): ?>
        <?php $isSolved = !empty($solved[$id]); ?>
        <div class="task <?= $isSolved ? 'task-solved' : '' ?>">
            <h3>
                <?= $isSolved ? '[x]' : '[ ]' ?>
                <?= htmlspecialchars($task['title']) ?>
            </h3>
            <p><b>Подсказка:</b> <?= htmlspecialchars($task['hint']) ?></p>

            <?php if ($isSolved): ?>
                <p class="flag-success">Уязвимость пройдена.</p>
            <?php else: ?>
                <form method="post" action="checklist.php">
                    <input type="hidden" name="task_id" value="<?= htmlspecialchars($id) ?>">
                    <input type="text" name="flag" placeholder="flag{...}" size="50">
                    <input type="submit" value="Проверить">
                </form>
            <?php endif; ?>
        </div>
        <hr>
    <?php endforeach; ?>
</div>
</body>
</html>