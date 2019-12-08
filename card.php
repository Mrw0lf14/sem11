<?php
	session_start();
 	if($_SESSION['username'] == 'admin') {
 		$isadmin = true;
 	}
 	$id = $_GET['id'];// в юрл из файла лист мы берем, что нужно показать
 	$host = 'localhost'; // имя хоста (уточняется у провайдера)
	$database = 'homework'; // имя базы данных, которую вы должны создать
	$user = 'root'; // заданное вами имя пользователя, либо определенное провайдером
	$table = 'things';//название таблицы
	$pswd = 'gavl228_A'; // заданный вами пароль
	$link = mysqli_connect($host, $user, $pswd, $database) or die("Ошибка " . mysqli_error($link));// подключаемся к серверу
	$table2 = 'comments';//название таблицы, где сохранены коментарии

	$query = "SELECT * FROM $table WHERE id=$id";
	$res = mysqli_query($link ,$query);
	
	$row = mysqli_fetch_array($res);//вытащить данные из запроса
	//первый столбец айди, по нему мы нашли наш товар
	$thing_type = $row[1];// второй столбец
	$thing_name = $row[2];//третий
	$thing_discr = $row[3];//четвертый
	$thing_owner = $row[4];//...
	$thing_price = $row[5];
	$thing_pict = $row[6];
	$thing_likes = $row[7];
	$thing_nlike = $row[8];
	echo "$thing_likes<br>";
	echo "$thing_nlike<br>";
	//следующий запрос нужен для коментариев 
	$query = "SELECT * FROM $table2 WHERE id=$id";//*
	$res = mysqli_query($link ,$query);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>карточка продукта</title>
	<?php 
		if($isadmin){
			echo '<style type="text/css"> input {visibility:  visible;}</style>';
		}
		else {
			echo '<style type="text/css"> input {visibility:  hidden;}</style>';
		}
	?>
	<style type="text/css">
		.likes {
			visibility:  visible;
		}
	</style>
</head>
<body>
	<header>
		<a href="exit.php">exit</a>_______
		<a href="list.php">list</a>
		<hr>
	</header>
	<article>
		<h4>Product</h4>
		<?php echo "<img src='$thing_pict'>"; ?>
		<form action="" method="post">
			<p>Тип продукта: <?php echo "$thing_type";?> <input type="text" name="type"> </p>
			<p>Название: <?php echo "$thing_name";?> <input type="text" name="name"></p>
			<p>Описание: <?php echo "$thing_discr";?> <input type="text" name="discription"></p>
			<p>Производитель: <?php echo "$thing_owner";?><input type="text" name="owner"></p>
			<p>Цена: <?php echo "$thing_price";?><input type="number" name="price"></p>
			<?php if (!$isadmin) {echo "<p>Оценка:<input class='likes' type='number' name='likes' min='0' max='5'></p>";} ?>
			<p><input class="likes" type="submit"></p>
			<input class="likes" type="text" name="comtext">
		</form>
	</article>
	<div>
		<?php  
			//вытащили из *
			while ($row = mysqli_fetch_row($res)) {
				$comtext = $row[1];
				$comname = $row[2];
				echo "<hr><h3>$comname</h3><p>$comtext</p>";
			}
		?>
	</div>
	<footer>
		<hr>
		<h3>IU4-12</h3>
	</footer>
</body>
</html>
<?php
	if (isset($_POST['type'])) {//если админ поправил данные
    	$type = $_POST['type'];
		$name = $_POST['name'];
		$discription = $_POST['discription'];
		$owner = $_POST['owner'];
		$price = $_POST['price'];
		
		$likes = $_POST['likes'] + $thing_likes;
		$nlike = $thing_nlike+1;

		$query = "UPDATE $table SET type = '$type', name = '$name', dicription = '$discription', owner = '$owner', price= '$price', likes = $likes, nlike = $nlike WHERE id = $id";//обновляем данные
		$res = mysqli_query($link ,$query);//задаем вопрос
		//echo mysqli_errno($link) . ": " . mysqli_error($link) . "\n";
		header( "refresh:1;");// обновляем страницу, чтобы увидеть изменения
	}

	if (isset($_POST['likes'])){// если пользователь поставил оценку
		$likes = $_POST['likes'] + $thing_likes;
		$nlike = $thing_nlike+1;
		$query = "UPDATE $table SET likes = $likes, nlike = $nlike WHERE id = $id";//запишем ее в столбец с числом баллов и оценок, чтобы удобнее было считать среднее арифметическое
		$res = mysqli_query($link ,$query);
	}

	if(isset($_POST['comtext'])){//если оставлен коментарий мы его сохраним
		$comname = $_SESSION['username'];
		$comtext = $_POST['comtext'];
		echo "$comtext";
		$query = "INSERT INTO $table2 VALUES($id, '$comtext', '$comname')";
		$res = mysqli_query($link ,$query);
	}
?>