<?php 
	session_start();
	if ($_SESSION['username']!='admin'){//тут может быть только админ, остальных возвратить на лист
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
	
	if($_POST['type']){//если тип не пустой

		$host='localhost'; // имя хоста (уточняется у провайдера)
		$database='homework'; // имя базы данных, которую вы должны создать
		$user='root'; // заданное вами имя пользователя, либо определенное провайдером
		$table='things';//название таблицы
		$pswd='gavl228_A'; // заданный вами пароль

		$link = mysqli_connect($host, $user, $pswd, $database) or die("Ошибка " . mysqli_error($link));// подключаемся к серверу
		$uploaddir = '/var/www/html/uploads/';// путь, куда сохранить картинку, тут он абсолютный для системы, начинается с корневой папки
		$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);// соединяем путь и имя загруженного файла
		$filetosave = '/uploads/'. basename($_FILES['userfile']['name']);// на сайте абсолютный путь начинается с папки хтмл, то есть она считается корневой
		//echo "$uploadfile <br>";

		if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {// если файл переместили
    		echo "Файл корректен и был успешно загружен.\n";
    		$type = $_POST['type'];
			$name = $_POST['name'];
			$discription = $_POST['discription'];
			$owner = $_POST['owner'];
			$price = $_POST['price'];
			$query = "INSERT INTO $table(type,name,dicription,owner,price,pict) VALUES('$type','$name','$discription','$owner','$price','$filetosave')";//сохраняем данные в бд
			$res = mysqli_query($link ,$query);//задаем вопрос
			echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";// вывод об ошибке
		}		
	}
?>