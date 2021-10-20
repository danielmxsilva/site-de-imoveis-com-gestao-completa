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
					<h2 class="active-btn">Cadastrar Produto</h2>
				</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php permissaoPagina(1)?>

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-usuario.png">
	<h2>Cadastrar Produto</h2>
	<?php

	if(isset($_POST['acao_adicionar'])){
		$nome = $_POST['nome'];
		$descricao = $_POST['descricao'];
		$largura = $_POST['largura'];
		$altura = $_POST['altura'];
		$comprimento = $_POST['comprimento'];
		$quantidade = $_POST['quantidade'];
		$peso = $_POST['peso'];

		$imagens = array();
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
			$sucesso = false;
			Painel::alert('erro','A imagem precisa ser selecionada!');
		}

		if($sucesso){

			for($i = 0; $i < $amountFiles; $i++) { 
				$imagemAtual = ['tmp_name'=>$_FILES['imagem']['tmp_name'][$i],
				'name'=>$_FILES['imagem']['name'][$i]];
				$imagens[] = Painel::uploadFile($imagemAtual);
			}

			$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.estoque_produtos` VALUES(null,?,?,?,?,?,?,?)");
			$sql->execute(array($nome,$descricao,$largura,$altura,$comprimento,$quantidade,$peso));
			$lastId = Mysql::conectar()->lastInsertId();
			foreach($imagens as $key => $value){
				$sql = Mysql::conectar()->exec("INSERT INTO `tb_admin.estoque_imagens` VALUES(null,$lastId,'$value')");
			}

			Painel::alert('sucesso','Produto adicionado com sucesso!');
		}
	}

	?>
	<div class="form-editar">
		<form method="POST" enctype="multipart/form-data">

			<div class="form-group form-produto">
				<span class="block-span">Nome:</span>
				<input style="width:100%;" type="text" name="nome" value="" >
			</div><!--from-group-->

			<div class="form-group form-produto">
				<span class="block-span">Descrição:</span>
				<textarea style="width:100%;" type="text" name="descricao"></textarea>
			</div><!--from-group-->

			<div class="form-group form-produto">
				<span class="block-span">Largura:</span>
				<span id="printLarg"></span>
				<input name="largura" style="width:100%;" type="range" value="50" step="10" min="10" max="100" id="Larg">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Altura:</span>
				<span id="printAlt"></span>
				<input name="altura" style="width:100%;" type="range" value="50" step="10" min="10" max="100" id="Alt">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Comprimento:</span>
				<span id="printCom"></span>
				<input name="comprimento" style="width:100%;" type="range" value="50" step="10" min="10" max="100" id="Com">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Peso:</span>
				<span id="printPes"></span>
				<input name="peso" style="width:100%;" type="range" value="50" step="10" min="10" max="100" id="Pes">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Quantidade:</span>
				<input name="quantidade" style="width:100%;" type="number" value="50" step="10" min="10" max="100">
			</div><!--form-group-->

			<div class="form-group form-produto">
				<span class="block-span">Imagen:</span>
				<input multiple type="file" name="imagem[]" id="input-img-adicionar">
				<label style="width: 150px; left: 0;" for="input-img-adicionar" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->

			<div class="form-group">
				<input type="hidden" name="tipo_acao" value="cadastrar_cliente">
				<input <?php permissaoInput(1,'acao_adicionar','Cadastrar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->


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

