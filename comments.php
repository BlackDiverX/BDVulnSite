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
			require_once("config.php");
			//Форма поиска комментариев
			echo "<h2>Отзывы о нашей компании</h2>";
			//Выводим форму поиска
			echo "<form action=comments.php>";
			echo "<b>Найти отзыв пользователя:</b>";
			echo "<input type=text name=search size=20>";
			echo "<input type=submit value=Поиск>";
			echo "</form>";
			//Подключаемся к базе данных
			$mysqli = new mysqli($db_server, $db_user, $db_password, $db_db);
			//Если из формы отправки комментария получены данные, то делаем запись в БД
			if (!empty($_POST["name"]) && !empty($_POST["comment"])){
				$name = $_POST["name"];
				$comment = $_POST["comment"];
				$result_post=$mysqli->query("insert into comments values (null,'$name','$comment')");
			}
			//Если из формы поиска получены данные, то фильтруем комментарии по имени пользователя
			if (isset($_GET["search"])) {
				$search=$_GET["search"];
				echo "Вы искали отзывы пользователя ".$search;
				$result = $mysqli->query("select name,text from comments where name='$search'");
			}
			//Если поискового запроса не было, то выводим все комментарии
			else {
				$result = $mysqli->query("SELECT name,text FROM comments");
			}
				echo "<table>";
				echo "<th>Имя</th>";
				echo "<th>Отзыв</th>";
				//Цикл вывода комментариев
				while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {

					echo "<tr>";
					echo "<td width=20%>".$row[0]."</td>";
					echo "<td width=80%>".$row[1]."</td>";
					echo "</tr>";

				}
			//Закрываем таблицу
			echo "</table>";
			echo "<hr>";
			echo "<p><b>Добавить отзыв</b></p>";
			//Выводим форму добавления комментариев
			echo "<form action=comments.php method=post>";
			echo "<p>Имя:</p>";
			echo "<input type=text name=name size=20>";
			echo "<p>Отзыв:</p>";
			echo "<textarea rows=10 name=comment></textarea><br>";
			echo "<input type=submit value=Отправить>";
			echo "</form>";
			//Освобождаем память
			$result->free();
			$mysqli->close();
		?>
		</div>
	</body>
</html>