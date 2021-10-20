
<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Cadastrar Empreendimento</h2>

	<?php
		if(isset($_POST['acao_cadastrar'])){
			$nome = $_POST['nome'];
			$tipo = $_POST['tipo'];
			$imagem = $_FILES['imagem'];

			if($nome == ''){
				Painel::alert("erro","O nome não pode ser vazio!");
				echo '<br>';
			}

			if($_FILES['imagem']['name'] == ''){
				Painel::alert("erro","A imagem precisa ser selecionada!");
			}else{
				if(!(Painel::imagemValida($imagem))){
					Painel::alert("erro","A imagem não é valida por favor Selecione imagens do tipo PNG,JPG ou JPEG");
				}else{
					$idImagem = Painel::uploadFile($imagem);
					$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.empreendimentos` VALUES(null,?,?,?,?)");
					$sql->execute(array($nome,$tipo,$idImagem,0));
					$lastId = Mysql::conectar()->lastInsertId();
					$sql = Mysql::conectar()->exec("UPDATE `tb_admin.empreendimentos` SET order_id = $lastId  WHERE id = $lastId");
					Painel::alert("sucesso","O cadastro do empreendimento foi feito com sucesso!");
				}
			}
		}
	?>
	
	<div class="form-editar cadastro-depoimentos">
		<form method="POST" enctype="multipart/form-data">

			<div class="group-depoimento">
				<span>Nome:</span>
				<input type="text" name="nome">
			</div><!--from-group-->

			<div class="group-depoimento">
				<span>Tipo:</span>
				<select name="tipo">
					<option value="residencial">Residêncial</option>
					<option value="comercial">Comercial</option>
				</select>
			</div><!--from-group-->

			<div class="form-group">
				<span>Imagem:</span>
				<input style="width: calc(100% - 120px)" type="file" name="imagem" id="input-img" value="<?php echo $_SESSION['img'];?>">
				<label style="left: 110px;" for="input-img" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->

			<div class="group-depoimento">
				<input <?php permissaoInput(1,'acao_cadastrar','Cadastrar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->

