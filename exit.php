<?php
	session_start();
	if(session_destroy())
	{
		// Redirecting To Home Page
		header("Location: signin.php");
		exit;
	}
?>