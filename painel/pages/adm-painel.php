<div class="wraper-titulo">
				<div class="titulo-content">
					<img src="<?php echo INCLUDE_PATH_PAINEL?>img/icon-adm.png">
					<h2>Administrar Painel</h2>
				</div><!--titulo-content-->
				<div class="breadcrump">
				<a href="<?php echo INCLUDE_PATH_PAINEL?>index.php">
					<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/home.png">
					<h2>Home</h2>
				</a>
					<span>/</span>
					<img src="<?php echo INCLUDE_PATH_PAINEL?>img/icon-adm.png">
					<h2 class="active-btn">Administrar Painel</h2>
				</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php permissaoPagina(1)?>

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Editar Usuário</h2>
	<?php
		if(isset($_POST['acao_editar'])){
			$user = $_POST['user'];
			$nome = $_POST['nome'];
			$password = $_POST['password'];
			$imagem_atual = $_POST['imagem_atual'];
			$imagem = $_FILES['imagem'];
			$usuario = new Usuario();

			if($imagem['name'] != ''){
				if(Painel::imagemValida($imagem)){
					Painel::deleteFile($imagem_atual);
					$imagem = Painel::uploadFile($imagem);
					if($usuario->atualizarUsuario($user,$password,$imagem,$nome)){
						$_SESSION['img'] = $imagem;
						$_SESSION['nome'] = $nome;
						Painel::alert('sucesso','Usuario Atualizado com Sucesso!');
					}else{
						Painel::alert('erro','Campos Vazios Não São Permitidos!');
					}
				}else{
					Painel::alert('erro','O formato da imagem não é valida');
				}
			}else{
				$imagem = $imagem_atual;
				if($usuario->atualizarUsuario($user,$password,$imagem,$nome)){
					$_SESSION['nome'] = $nome;
					Painel::alert('sucesso','Usuario Atualizado com Sucesso!');
				}else{
					Painel::alert('erro','Campos Vazios Não São Permitidos!');
				}
			}
		}
	?>
	<div class="form-editar">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<span>Login:</span>
				<input type="text" name="user" required value="<?php echo $_SESSION['user']?>">
			</div><!--from-group-->
			<div class="form-group">
				<span>Nome:</span>
				<input type="text" name="nome" required value="<?php echo $_SESSION['nome']?>">
			</div><!--from-group-->
			<div class="form-group">
				<span>Senha:</span>
				<input type="text" name="password" required value="<?php echo $_SESSION['password']?>">
			</div><!--from-group-->
			<div class="form-group">
				<span>Imagen:</span>
				<input type="file" name="imagem" id="input-img" value="<?php echo $_SESSION['img'];?>">
				<input type="hidden" name="imagem_atual" value="<?php echo $_SESSION['img'];?>">
				<label for="input-img" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="form-group">
				
				<input <?php permissaoInput(1,'acao_editar','Editar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-usuario.png">
	<h2>Adicionar Usuário</h2>

	<?php
		if(isset($_POST['acao_adicionar'])){
			$user = $_POST['user'];
			$nome = $_POST['nome'];
			$password = $_POST['password'];
			$imagem_default = $_POST['imagem_default'];
			$imagem = $_FILES['imagem_adicionar'];
			$cargo = $_POST['cargo'];
			$usuario = new Usuario();

			if($user == ''){
				Painel::alert('erro','Adicione um Login para continuar');
			}else if($nome == ''){
				Painel::alert('erro','Adicione um Nome pra continuar');
			}else if($password == ''){
				Painel::alert('erro','Adicione uma Senha para continuar');
			}else if($cargo == ''){
				Painel::alert('erro','Adicione um Cargo para continuar');
			}else if($cargo >= $_SESSION['cargo']){
				Painel::alert('erro','Você precisa adicionar um cargo melhor que o seu');
			}

			if($imagem['name'] != ''){
				if(Painel::userExists($user)){
					Painel::alert('erro','O Login já existe, adicione outro!');
				}else if(Painel::imagemValida($imagem) == true){
					$imagem = Painel::uploadFile($imagem);
					if($usuario->adicionarUsuario($user,$password,$imagem,$nome,$cargo)){
						Painel::alert('sucesso','Usuario Adicionado Com Sucesso!');
					}else{
						Painel::alert('erro','Ocorreu algum erro!');
					}
				}else{
					Painel::alert('erro','O formato da Imagem Não é Valida');
				}

			}else{
				$imagem = $imagem_default;
				if(Painel::userExists($user)){
					Painel::alert('erro','o Login já existe, adicione outro!');
				}else{
					if($usuario->adicionarUsuario($user,$password,$imagem,$nome,$cargo)){
						Painel::alert('sucesso','Usuario Adicionado Com sucesso!');
					}else{
						Painel::alert('erro','Campos Vazios Não São Permitidos!');
					}
				}
			}
		}
	?>

	<div class="form-editar">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<span>Login:</span>
				<input type="text" name="user" value="" required>
			</div><!--from-group-->
			<div class="form-group">
				<span>Nome:</span>
				<input type="text" name="nome" value="" required>
			</div><!--from-group-->
			<div class="form-group">
				<span>Senha:</span>
				<input type="text" name="password" value="">
			</div><!--from-group-->
			<div class="form-group">
				<span>Cargo:</span>
				<select name="cargo" required>
					<option disabled selected value="">Selecione</option>
					<?php 
					foreach(Painel::$cargos as $key => $value){

						if($key < $_SESSION['cargo']) 
							echo '<option value="'.$key.'">'.$value.'</option>';
						
					}?>
				</select>
			</div><!--form-group-->
			<div class="form-group">
				<span>Imagen:</span>
				<input type="hidden" name="imagem_default" value=" ">
				<input type="file" name="imagem_adicionar" id="input-img-adicionar">
				<label for="input-img-adicionar" name="imagem_adicionar"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="form-group">
				
				<input <?php permissaoInput(1,'acao_adicionar','Adicionar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
