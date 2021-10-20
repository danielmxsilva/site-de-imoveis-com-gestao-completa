<?php
	
	session_start();
	ob_start();

	date_default_timezone_set('America/Sao_Paulo');

	require('vendor/autoload.php');

	$autoload = function($class){
		include('classes/'.$class.'.php');
	};

	spl_autoload_register($autoload);

	define('BASE_DIR_PAINEL',__DIR__.'/painel');
	define('NOME_EMPRESA','DAMIX.CODE');
	define('INCLUDE_PATH','http://localhost/git/sistema-de-gestao-de-imoveis/');
	define('INCLUDE_PATH_PAINEL',INCLUDE_PATH.'painel/');
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','');
	define('DATABASE','projeto_01');

	function pegaCargo($cargo){
		return Painel::$cargos[$cargo];
	}

	function permissaoPagina($permissao){
		if($_SESSION['cargo'] >= $permissao){
			return;
		}else{
			include('pages/permissao-negada.php');
		}
	}

	function permissaoInput($permissao,$valor,$value){
		if($_SESSION['cargo'] >= $permissao){
			echo 'type="submit" name="'.$valor.'" value="'.$value.'"';
		}else{
			echo 'disabled name="permissao" value="Sem Permissao"';
		}
	}

	function recoverPost($post){
		if(isset($_POST[$post])){
			echo $_POST[$post];
		}
	}


?>