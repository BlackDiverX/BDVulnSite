<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<!-- Оформление --!>
		<div class=comments>
			<div class=header>
				<img src=logo.png>Быть уязвимыми - наша профессия
			</div>
			<hr>
			<div class=menu>
				<a href=login.php>Вход</a> 
				<a href=comments.php>Отзывы</a> 
				<a href=monitor.php?page=ps>Система мониторинга</a>
			</div>
			<hr>
			<!-- Начало кода с уязвимостями --!>
		<?php
			if (!empty($_GET['page'])) {
				$page = $_GET['page'];
				//Выводим название страницы, взятое из файла
				echo "<h2>".file_get_contents('text/'.$page)."</h2>";
				echo "<form action=monitor.php>";
				echo "<b>Поиск процесса по имени:</b>";
				echo "<input type=hidden name=page value=ps>";
				echo "<input type=text name=type size=20>";
				echo "<input type=submit value=Найти>";
				echo "</form>";
				//Выводим список процессов, попадающих под фильтр
				if (!empty($_GET['type'])) {
					$command = "ps aux | grep ".$_GET['type'];
				}
				//Если параметр не задан, то выводим список всех процессов
				else {
					$command = "ps aux";
				}
				//Выполнение команды на сервере
				exec($command,$arr);
				//Построчно выводим результат, добавляя HTML теги
				echo('<code>');
				foreach ($arr as $tmp) {
					echo($tmp.'<br>');
				}
				echo('</code>');
			}
		?>
		</div>
	</body>
</html>