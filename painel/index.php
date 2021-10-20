<?php

	include('../config.php');

	ob_start();

	if(Painel::logado() == false){
		include('login.php');
	}else{
		include('main.php');
	}

	ob_end_flush();

?>