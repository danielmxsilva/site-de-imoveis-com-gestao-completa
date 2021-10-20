<?php
	if(isset($_COOKIE['lembrar'])){
		$user = $_COOKIE['user'];
		$password = $_COOKIE['password'];
		$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.usuario` WHERE user = ? AND password = ?");
		$sql->execute(array($user,$password));
		if($sql->rowCount() == 1){
			$info = $sql->fetch();
			$_SESSION['user'] = $user;
			$_SESSION['password'] = $password;
			$_SESSION['cargo'] = $info['cargo'];
			$_SESSION['img'] = $info['img'];
			$_SESSION['nome'] = $info['nome'];
			header('Location: '.INCLUDE_PATH_PAINEL);
			die();
		}
	}

?>
<!DOCTYPE html>
<html class="fundo-login">
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<link href="<?php echo INCLUDE_PATH_PAINEL;?>css/style.css" rel="stylesheet">
</head>
<body class="img-fundo-login">

	<div class="body-login">
		<img src="<?php echo INCLUDE_PATH_PAINEL?>img/cadeado.png">
		<?php
			if(isset($_POST['login'])){
				$header = false;
				$user = $_POST['user'];
				$password = $_POST['password'];
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.usuario` WHERE user = ? AND password = ?");
				$sql->execute(array($user,$password));
				if($sql->rowCount() == 1){
					$info = $sql->fetch();
					$_SESSION['login'] = true;
					$_SESSION['user'] = $user;
					$_SESSION['password'] = $password;
					$_SESSION['cargo'] = $info['cargo'];
					$_SESSION['img'] = $info['img'];
					$_SESSION['nome'] = $info['nome'];
					if(isset($_POST['lembrar_senha'])){
						setcookie('lembrar',true,time() + (60*60*24),'/');
						setcookie('user',$user,time() + (60*60*24),'/');
						setcookie('password',$password,time() + (60*60*24),'/');
					}
					header('Location: '.INCLUDE_PATH_PAINEL);
					die();
				}else{
					echo '<div class="erro-box">Login ou Senha invalida!</div>';
				}
			}
		?>
		<form method="POST">
			<div class="wraper-input">
				<img src="<?php echo INCLUDE_PATH_PAINEL?>img/icone-user.png">
				<input type="text" name="user" placeholder="Login" value="<?php
				if(isset($_COOKIE['user'])){
					echo $_COOKIE['user'];
				}else{
					echo '';
				}
				?>">
			</div><!--wraper-input-->
			<div class="wraper-input">
				<img src="<?php echo INCLUDE_PATH_PAINEL?>img/password.png">
				<input type="password" name="password" placeholder="Senha" value="<?php
				if(isset($_COOKIE['password'])){
					echo $_COOKIE['password'];
				}else{
					echo '';
				}
			?>">
			</div><!--wraper-input-->
			<div class="wraper-check">
				<input type="checkbox" name="lembrar_senha" value="lembrar_senha"><span>Lembrar-me</span>
			</div><!--wraper-check-->
			<input type="submit" name="login" value="Login">
		</form>
	</div>

</body>
</html>