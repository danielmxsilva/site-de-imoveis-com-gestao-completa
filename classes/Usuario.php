<?php

	class Usuario
	{
		public function atualizarUsuario($user,$password,$imagem,$nome){
			$sql = Mysql::conectar()->prepare("UPDATE `tb_admin.usuario` SET user = ?, password = ?, img = ?,nome = ? WHERE user = ?");
			if($sql->execute(array($user,$password,$imagem,$nome,$_SESSION['user']))){
				return true;
			}else{
				return false;
			}
		}

		public function adicionarUsuario($user,$password,$imagem,$nome,$cargo){
			$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.usuario` VALUES(null,?,?,?,?,?)");
			if($sql->execute(array($user,$password,$imagem,$nome,$cargo))){
				return true;
			}else{
				return false;
			}
		}
	}

?>