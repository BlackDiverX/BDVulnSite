<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Вход — BD VulnSite</title>
	</head>
	<body>
		<!-- Оформление -->
		<div class=login>
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
			//Если логин и пароль переданы, то пробуем войти
			if (isset($_POST['username']) || isset($_POST['password'])) {
				//Назначаем переменные
				$username = $_POST['username'];
				$password = $_POST['password'];
				//Подключаемся к базе данных
				$mysqli = new mysqli($connect[0], $connect[1], $connect[2], $connect[3]);
				//Делаем запрос, где выбираем поля в которых есть одновременно и имя пользователя и пароль
				$result = $mysqli->query("SELECT * FROM users where name='$username' and password='$password'");
				//Если запрос выполнился и есть строки — выводим приветствие
				if ($result && mysqli_num_rows($result) > 0) {
					$row = $result->fetch_assoc();
					echo "Добро пожаловать,".$row['name'];
				}
				//Иначе выводим ошибку
				else {
					echo "Пользователь не найден или неправильный пароль";
					if (isset($_POST['username']) && strpos($_POST['username'], "'") !== false) {
						echo "<br><small>Debug: SQL error near input. flag{3rr0r_m3ss4g3s_4r3_fr33_1nt3l}</small>";
					}
				}
				//Освобождаем память (только если запрос выполнился)
				if ($result) {
					$result->free();
				}
				$mysqli->close();
			}
			//Если логин и пароль не передавались, то отображаем форму входа
			else {
				echo "<h2>Вход в панель администратора</h2>";
				echo "<form method=post action=login.php>";
				echo "<p><b>Имя пользователя:</b></p>";
				echo "<input type=text name=username size=100>";
				echo "<p><b>Пароль:</b></p>";
				echo "<input type=password name=password size=100>";
				echo "<p><input type=submit value=Вход></p>";
				echo "</form>";
			}
			?>
		</div>
	</body>
</html>