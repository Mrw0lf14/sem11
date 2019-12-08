<?php
	session_start();
	if(session_destroy())//если удачно ломаетя сессия 
	{
		header("Location: signin.php");//переход на вход
		exit;
	}
?>