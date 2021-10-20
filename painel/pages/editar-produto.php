<?php
	
	$id = (int)$_GET['id'];

	$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_produtos` WHERE id = ?");
	$sql->execute(array($id));

	$infoProduto = $sql->fetch();

	$infoImagem = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
	$infoImagem->execute();
	$infoImagem = $infoImagem->fetchAll();

	if(isset($_GET['deletarImagem'])){
		$idImagem = $_GET['deletarImagem'];
		@unlink(BASE_DIR_PAINEL.'/uploads/'.$idImagem);
		$sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE imagem = '$idImagem'");
		Painel::alert("sucesso","Imagem deletada com sucesso!");
		$infoImagem = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
		$infoImagem->execute();
		$infoImagem = $infoImagem->fetchAll();
	}

?>
<div class="wraper-titulo">
		<div class="titulo-content">
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/notebook.png">
			<h2>Painel de Controle</h2>
		</div><!--titulo-content-->
		<div class="breadcrump">
		<a href="<?php echo INCLUDE_PATH_PAINEL?>index.php">
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/home.png">
			<h2>Home</h2>
		</a>
		<a href="<?php echo INCLUDE_PATH_PAINEL?>visualizar-produtos">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Visualizar-produtos</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
			<h2 class="active-btn">Editar Produto</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Editando Produto: <?php echo $infoProduto['nome']?></h2>

	<?php permissaoPagina(1); ?>

	<?php
		if(isset($_POST['tipo_acao'])){
			$nome = $_POST['nome'];
			$descricao = $_POST['descricao'];
			$largura = $_POST['largura'];
			$altura = $_POST['altura'];
			$comprimento = $_POST['comprimento'];
			$peso = $_POST['peso'];
			$quantidade = $_POST['quantidade'];

			$imagens = [];
			$amountFiles = count($_FILES['imagem']['name']);

			$sucesso = true;

			if($_FILES['imagem']['name'][0] != ''){

				for($i = 0; $i < $amountFiles; $i++){
					$imagemAtual = ['type'=>$_FILES['imagem']['type'][$i],
					'size'=>$_FILES['imagem']['size'][$i]];
					if(Painel::imagemValida($imagemAtual) == false){
						$sucesso = false;
						Painel::alert('erro','Alguma imagem não é válida, por favor selecione imagem no formato jpg,jpeg ou png');
						break;
					}
				}
		
			}else{
				//Não está subindo nenhuma imagen
			}

			if($sucesso){

				if($_FILES['imagem']['name'][0] != ''){
					for($i = 0; $i < $amountFiles; $i++) { 
						$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
						'name'=>$_FILES['imagem']['name'][$i]];
						$imagens[] = Painel::uploadFile($imagemAtual);
					}

					foreach($imagens as $key => $value){
						$sql = Mysql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES(null,$id,'$value')");
					}
				}

				$sql = Mysql::conectar()->prepare("UPDATE `tb_admin.estoque_produtos` SET nome = ?,descricao = ?,largura = ?, altura = ?,comprimento = ?, quantidade = ?, peso = ? WHERE id = $id");
				$sql->execute(array($nome,$descricao,$largura,$altura,$comprimento,$quantidade,$peso));

				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_produtos` WHERE id = ?");
				$sql->execute(array($id));

				$infoProduto = $sql->fetch();

				Painel::alert("sucesso","O produto foi editado com sucesso!");

				$infoImagem = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
				$infoImagem->execute();
				$infoImagem = $infoImagem->fetchAll();
			}
		}
	?>
	
	<div class="form-editar">

	<?php
		foreach ($infoImagem as $key => $value) {
	?>

	<div class="box-single-wraper">
		<div class="box-single" style="box-shadow: 1px 1px 10px #ccc;min-height: inherit;">
			<div class="box-topo">
				<img style="width: 50%;height: 90px;border-radius: unset;" src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $value['imagem']?>">
			</div><!--box-topo-->

			<div class="box-btn" style="margin-top:5px;">

				<a <?php
						if($_SESSION['cargo'] >= 1){
					  ?>
					   class="btn-delete" style="background-color: #FF7B52;" item_id="<?php echo $value['id']?>" href="<?php echo INCLUDE_PATH_PAINEL?>editar-produto?id=<?php echo $id?>&deletarImagem=<?php echo $value['imagem']?>"
					  <?php }else{ ?> 
					  	actionBtn="negado" style="background-color: #FF7B52;" href="#"
					  <?php } ?>
					  ><img src='img/excluir-depoimento-red.png'>Deletar
				</a>

			</div><!--box-btn-->
		</div><!--box-single-->
	</div><!--box-single-wraper-->

	<?php }?>

	<div class="clear"></div>

	</div><!--form-editar-->

	<div class="form-editar">

		
		<form method="POST" enctype="multipart/form-data">

			<div class="form-group form-produto">
				<span class="block-span">Nome:</span>
				<input style="width:100%;" type="text" name="nome" value="<?php echo $infoProduto['nome']?>" >
			</div><!--from-group-->

			<div class="form-group form-produto">
				<span class="block-span">Descrição:</span>
				<textarea style="width:100%;" type="text" name="descricao"><?php echo $infoProduto['descricao']?></textarea>
			</div><!--from-group-->

			<div class="form-group form-produto">
				<span class="block-span">Largura:</span>
				<span id="printLarg"></span>
				<input name="largura" style="width:100%;" type="range" value="<?php echo $infoProduto['largura']?>" step="10" min="10" max="100" id="Larg">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Altura:</span>
				<span id="printAlt"></span>
				<input name="altura" style="width:100%;" type="range" value="<?php echo $infoProduto['altura']?>" step="10" min="10" max="100" id="Alt">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Comprimento:</span>
				<span id="printCom"></span>
				<input name="comprimento" style="width:100%;" type="range" value="<?php echo $infoProduto['comprimento']?>" step="10" min="10" max="100" id="Com">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Peso:</span>
				<span id="printPes"></span>
				<input name="peso" style="width:100%;" type="range" value="<?php echo $infoProduto['peso']?>" step="10" min="10" max="100" id="Pes">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Quantidade:</span>
				<input name="quantidade" style="width:100%;" type="number" value="<?php echo $infoProduto['quantidade']?>" step="10">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Imagen:</span>
				<input multiple type="file" name="imagem[]" id="input-img-adicionar">
				<label style="width: 150px; left: 0;" for="input-img-adicionar" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->

			<div class="form-group">
				<input type="hidden" name="tipo_acao" value="cadastrar_cliente">
				<input <?php permissaoInput(1,'acao_adicionar','Editar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->


<script>
	var slider01 = document.getElementById("Larg");
	var output01 = document.getElementById("printLarg");
	output01.innerHTML = slider01.value;

	slider01.oninput = function() {
	  output01.innerHTML = this.value;
	};

	var slider02 = document.getElementById("Alt");
	var output02 = document.getElementById("printAlt");
	output02.innerHTML = slider02.value;

	slider02.oninput = function() {
	  output02.innerHTML = this.value;
	};

	var slider03 = document.getElementById("Com");
	var output03 = document.getElementById("printCom");
	output03.innerHTML = slider03.value;

	slider03.oninput = function() {
	  output03.innerHTML = this.value;
	};

	var slider04 = document.getElementById("Pes");
	var output04 = document.getElementById("printPes");
	output04.innerHTML = slider04.value;

	slider04.oninput = function() {
	  output04.innerHTML = this.value;
	};
</script>


</div><!--box-content-->