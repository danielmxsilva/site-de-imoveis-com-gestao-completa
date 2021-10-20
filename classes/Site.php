<?php

	class Site
	{
		public static function updateUsuarioOnline(){
			if(isset($_SESSION['online'])){
				$token = $_SESSION['online'];
				$horarioAtual = date('Y-m-d H:i:s');
				$check = Mysql::conectar()->prepare("SELECT `id` FROM `tb_admin.online` WHERE token = ?");
				$check->execute(array($token));
				if($check->rowCount() == 1){
					$token = $_SESSION['online'];
					$horarioacao = date('Y-m-d H:i:s');
					$sql = Mysql::conectar()->prepare("UPDATE `tb_admin.online` SET ultima_acao = ? WHERE token = ?");
					$sql->execute(array($horarioacao,$token));
				}else{
					$ip = $_SERVER['REMOTE_ADDR'];
					$ultima_acao = date('Y-m-d H:i:s');
					$token = $_SESSION['online'];
					$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.online` VALUES(null,?,?,?)");
					$sql->execute(array($ip,$ultima_acao,$token));
				}
			}else{
				$_SESSION['online'] = uniqid();
			}
		}

		public static function contador(){
			if(!isset($_COOKIE['visita'])){
				setcookie('visita',true,time() + (60*60*24*30));
				$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.visitas` VALUES(null,?,?)");
				$sql->execute(array($_SERVER['REMOTE_ADDR'],date('Y-m-d')));
			}
		}
	}

?>