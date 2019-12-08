<?php 
	session_start();
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
  <h1>Restration</h1>
  <form action ="" method="post">
    <p>mail:<input type="text" name="mail"></p>
    <p>login:<input type="text" name="login"></p>
    <p>password:<input type="password" name="password"></p>
    <p><input type="submit"></p>
  </form>
</body>
</html>

<?php
	if (isset($_POST['mail'])){
		$mail = $_POST["mail"];
		$login = $_POST["login"];
		$password = $_POST["password"];

		$host='localhost'; // имя хоста (уточняется у провайдера)
		$database='homework'; // имя базы данных, которую вы должны создать
		$user='root'; // заданное вами имя пользователя, либо определенное провайдером
		$table='sem11';//название таблицы
		$pswd='gavl228_A'; // заданный вами пароль
		
		$link = mysqli_connect($host, $user, $pswd, $database) or die("Ошибка " . mysqli_error($link));// подключаемся к серверу

		$mail_valid = preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $mail) && preg_match("/(?:[a-zA-Z0-9])/i", $mail);
		
		$password_valid = preg_match('/[A-Za-z0-9]/', $password) && strlen($password) > 8;
		$login_valid = preg_match('/[A-Za-z_]/', $login) && strlen($login) > 6;

		if (!$mail_valid && !$password_valid && !$login_valid)
		{
			echo "something wrong";
			exit();
		}

		$query = "SELECT * FROM $table WHERE mail='$mail'";//формируем запрос
		$res = mysqli_query($link ,$query);//задаем вопрос
		
		if ($res){
			$row = mysqli_fetch_array($res);//вытаскиваем данные из запроса
			if ($row['mail']=="$mail" or $row['login']=="$login"){
				echo "This account is already exist";
			} else {
				$query = "INSERT INTO $table (name, mail, password) VALUES ('$login','$mail','$password')";
				$result = mysqli_query($link ,$query);
				if ($res){
					$_SESSION['username'] = $login;
					header("Location: list.php");
				}	
			}
		}
	}
?>