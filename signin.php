<?php 
	session_start();//проверка на вход, если уже авторизован, то перенаправляем на контент
	if (isset($_SESSION['username'])){
		header("Location: list.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>registr</title>
</head>
<body>
	<h1>Login</h1>
    <form action ="" method="post">
    	<p>login:<input type="text" name="name"></p>
    	<p>password:<input type="password" name="password"></p>
    	<p><input type="submit"></p>
  	</form>
</body>
</html>
<?php
	
	$username = $_POST['name'];
	$pass = $_POST['password'];

	$host='localhost'; // имя хоста (уточняется у провайдера)
	$database='homework'; // имя базы данных, которую вы должны создать
	$user='root'; // заданное вами имя пользователя, либо определенное провайдером
	$table='sem11';//название таблицы
	$pswd='gavl228_A'; // заданный вами пароль

	$link = mysqli_connect($host, $user, $pswd, $database) or die("Ошибка " . mysqli_error($link));// подключаемся к серверу

	if (isset($_POST['name']) )//если имя утановлено, потому что во время загрузки страницы пхп тоже обрабатывается
	{
		$query = "SELECT * FROM $table WHERE name ='$username'";//создаем запрос
		$res = mysqli_query($link ,$query);//выполняем запрос

		if ($res){
			$row = mysqli_fetch_array($res);//вытаскиваем данные из запроса
			if ($row['name']=="$username" && $row['password']=="$pass"){
				$_SESSION['username'] = $username;
				header("Location: list.php");
			}
			else{
				echo "Wrong password or name";
			}
		}
	}
?>