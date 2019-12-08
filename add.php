<?php 
	session_start();
	if ($_SESSION['username']!='admin'){
		header("Location: list.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>list</title>
</head>
<body>
	<header>
		<a href="exit.php">exit</a>_______
		<a href="list.php">list</a>
		<hr>
	</header>
	<article>
		<h3>Ваш продукт</h3>
		<form enctype="multipart/form-data" action="" method="post">
			<p>Тип продукта<input type="text" name="type"></p>
			<p>Название <input type="text" name="name"></p>
			<p>Описание <input type="text" name="discription"></p>
			<p>Производитель <input type="text" name="owner"></p>
			<p>Цена <input type="number" name="price"></p>
			<p>Фотография <input type="file" name="userfile"></p>
			<p><button type="submit">отправить</button></p>
		</form>
	</article>
	<footer>
		<hr>
		<h3>IU4-12</h3>
	</footer>
</body>
</html>
<?php
	
	if($_POST['type']){

		$host='localhost'; // имя хоста (уточняется у провайдера)
		$database='homework'; // имя базы данных, которую вы должны создать
		$user='root'; // заданное вами имя пользователя, либо определенное провайдером
		$table='things';//название таблицы
		$pswd='gavl228_A'; // заданный вами пароль

		$link = mysqli_connect($host, $user, $pswd, $database) or die("Ошибка " . mysqli_error($link));// подключаемся к серверу
		$uploaddir = '/var/www/html/uploads/';
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
		$typef = basename($_FILES['userfile']['type']);
		$filetosave = '/uploads/'. basename($_FILES['userfile']['name']);
		echo "$uploadfile <br>";

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    		echo "Файл корректен и был успешно загружен.\n";
    		$type = $_POST['type'];
			$name = $_POST['name'];
			$discription = $_POST['discription'];
			$owner = $_POST['owner'];
			$price = $_POST['price'];
			$query = "INSERT INTO $table(type,name,dicription,owner,price,pict) VALUES('$type','$name','$discription','$owner','$price','$filetosave')";
			$res = mysqli_query($link ,$query);//задаем вопрос
			echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
		}		
	}
?>