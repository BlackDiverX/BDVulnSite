<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Отзывы — BD VulnSite</title>
	</head>
	<body>
		<!-- Оформление -->
		<div class=comments>
			<div class=header>
				<img src=logo.png>Быть уязвимыми - наша профессия
			</div>
			<hr>
			<div class=menu>
				<a href=login.php>Вход</a> 
				<a href=comments.php>Отзывы</a> 
				<a href=monitor.php?page=ps>Система мониторинга</a>
				<a href=checklist.php>Чеклист</a>
			</div>
			<hr>
		<!-- Начало кода с уязвимостями -->
		<?php
			require_once("config.php");
			$str1=base64_decode($str1);
			$connect=array();
   			 $array=explode(';',$str1);
   			 foreach($array as $string){
        			list($key,$value)=explode(':',$string);
					array_push($connect,$value);
  			  	}
					
			//Форма поиска комментариев
			echo "<h2>Отзывы о нашей компании</h2>";
			//Выводим форму поиска
			echo "<form action=comments.php>";
			echo "<b>Найти отзыв пользователя:</b>";
			echo "<input type=text name=search size=20>";
			echo "<input type=submit value=Поиск>";
			echo "</form>";
			//Подключаемся к базе данных
			$mysqli = new mysqli($connect[0], $connect[1], $connect[2], $connect[3]);
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
				if (strpos($search, '<script>') !== false) {
    				echo " <!-- flag{<script>alert('xss')</script>} -->";
				}
				$result = $mysqli->query("select name,text from comments where name='$search'");
			}
			//Если поискового запроса не было, то выводим все комментарии
			else {
				$result = $mysqli->query("SELECT name,text FROM comments");
			}
				echo "<table>";
				echo "<th>Имя</th>";
				echo "<th>Отзыв</th>";
				//Цикл вывода комментариев (только если запрос выполнился)
				if ($result) {
					while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
						$text = $row[1];
						if (strtoupper(trim($row[0])) === 'CTF') {
							$text .= " <script>alert('flag{st0r3d_xss_1s_just_p3rs1st3nt}')</script>";
						}
						echo "<tr>";
						echo "<td width=20%>".$row[0]."</td>";
						echo "<td width=80%>".$text."</td>";
						echo "</tr>";
					}
				} else {
					echo "<tr><td colspan=2>Ошибка выполнения запроса</td></tr>";
				}
			//Закрываем таблицу
			echo "</table>";
			echo "<hr>";
			echo "<p><b>Добавить отзыв</b></p>";
			//Выводим форму добавления комментариев
			echo "<form action=comments.php method=post>";
			echo "\n<!-- CSRF: форма не защищена токеном. Флаг: flag{csrf_1s_l1k3_tru5t_1ssu3s} -->\n";
			echo "<p>Имя:</p>";
			echo "<input type=text name=name size=20>";
			echo "<p>Отзыв:</p>";
			echo "<textarea rows=10 name=comment></textarea><br>";
			echo "<input type=submit value=Отправить>";
			echo "</form>";
			//Освобождаем память (только если запрос выполнился)
			if ($result) {
				$result->free();
			}
			$mysqli->close();
		?>
		</div>
	</body>
</html>