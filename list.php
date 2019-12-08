<?php
	session_start();
 	$host = 'localhost'; // имя хоста (уточняется у провайдера)
	$database = 'homework'; // имя базы данных, которую вы должны создать
	$user = 'root'; // заданное вами имя пользователя, либо определенное провайдером
	$table = 'things';//название таблицы
	$pswd = 'gavl228_A'; // заданный вами пароль
	$link = mysqli_connect($host, $user, $pswd, $database) or die("Ошибка " . mysqli_error($link));// подключаемся к серверу
	$order = $_GET['order'];
	$type = $_GET['type'];
	$owner = $_GET['owner'];
	echo "$type";
	if ($type != 'all'){
		$query = "SELECT * FROM $table WHERE type = '$type' AND owner = '$owner' ORDER BY $order";
	}
	else{
		$query = "SELECT * FROM $table";
		//$query = "SELECT * FROM $table";
	}
	
	$res = mysqli_query($link ,$query);	
	
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>list</title>
	<style type="text/css">
		.box{
			display: inline-block;
			width: 200px;
			height: 400px;
			border: 1px solid black;
		}
		.box img{
			width: 200px;
			height: 200px;
		}
	</style>
</head>
<body>
	<header>
		<a href="exit.php">exit</a>_______
		<a href="list.php">list</a>_______
		<a href="add.php">add</a>
		<form action="" method="get">
			<select name="type">
				<option> all</option>
				<option> type1</option>
				<option> type2</option>
				<option> type3</option>
			</select>
			<select name="owner">
				<option> owner1</option>
				<option> owner2</option>
				<option> owner3</option>
			</select>
			<select name="order">
				<option> price</option>
				<option> com</option>
			</select>
			<input type="submit" name="">
		</form>
		<hr>
	</header>

	<article>
		
		
			<?php while ($row = mysqli_fetch_row($res)) {
				$id = $row[0];
				$thing_type = $row[1];
				$thing_name = $row[2];
				$thing_discr = $row[3];
				$thing_owner = $row[4];
				$thing_price = $row[5];
				$thing_pict = $row[6];
				$thing_likes = $row[7];
				$thing_nlike = $row[8];
				$likes = $thing_likes / $thing_nlike;
				echo "
				<div class='box'>
				<a href='card.php?id=$id'><img src='$thing_pict'></a>
				<p>$thing_type</p>
				<p>$thing_name</p>
				<p>$thing_owner</p>
				<p>$thing_price</p>
				<p>$likes</p>
				</div>";	
			} ?>
			
		
	</article>

	<footer>
		<hr>
		<h3>IU4-12</h3>
	</footer>
</body>
</html>
