<?php
	
	if(isset($_GET['falta']) == false){

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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>cadastrar-produto">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Cadastrar Produto</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
			<h2 class="active-btn">Visualizar Produtos</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
	<h2>Produtos no Estoque</h2>

	<div class="busca">
		<h2>Realizar uma busca</h2>
		<form method="post">
			<input type="text" name="busca" placeholder="Procure por nome ou descrição">
			<input type="submit" name="acao" value="Buscar">
		</form>
	</div><!--busca-->
	<br>
	<?php

		if(isset($_GET['deletar'])){
			$id = (int)$_GET['deletar'];
			$imagens = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
			$imagens->execute();
			$imagens = $imagens->fetchAll();
			foreach($imagens as $key => $value) {
				@unlink(BASE_DIR_PAINEL.'/uploads/'.$value['imagem']);
			}
			$sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.estoque_imagens` WHERE produto_id = $id");
			$sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.estoque_produtos` WHERE id = $id");
			Painel::alert("sucesso","Produto deletado com sucesso!");
		}

		if(isset($_POST['quantidade_atual'])){
			$produto_id = $_POST['id_produto'];
			$nome_produto = $_POST['nome_produto'];
			$quantidade = $_POST['quantidade'];
			if($quantidade < 0){
				Painel::alert("erro",'Não é permitido numeros negativos no estoque!');
			}else{
				$sql = Mysql::conectar()->exec("UPDATE `tb_admin.estoque_produtos` SET quantidade = $quantidade WHERE id = $produto_id");
				Painel::alert("sucesso","A quantidade de $nome_produto foi atualizada com sucesso!");
			}

			
		}

		echo '<br>';

		$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_produtos` WHERE quantidade = 0");
		$sql->execute();

		if($sql->rowCount() > 0){
			Painel::alert('atencao','atenção! existem produtos em falta no estoque <a href="'.INCLUDE_PATH_PAINEL.'visualizar-produtos?falta">Clique aqui</a> para visualizar');
		}

		
	?>

	<div class="box-wraper">

		<?php
			$query = "";
			if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar'){
				$busca = $_POST['busca'];
				$query = "WHERE (nome LIKE '%$busca%' OR descricao LIKE '%$busca%')";
			}
			
			if(isset($_POST['acao']) && $_POST['acao'] == 'Ver todos'){
				$query = "";
			}
			if($query == ""){
				$query2 = "WHERE quantidade > 0";
			}else{
				$query2 = " AND quantidade > 0";
			}
			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_produtos` $query $query2");
			$sql->execute();
			$produto = $sql->fetchAll();
			if($query != ''){
				echo '<div class="cliente-result">Foram encontrados <b>'.count($produto).'</b> resultado(s)</div><br><form method="post"><div class="busca"><input type="submit" name="acao" value="Ver todos"></form></div>';
			}

			foreach($produto as $key => $value){
				$imagemSingle = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ? LIMIT 1");
				$imagemSingle->execute(array($value['id']));
				$imagemSingle = @$imagemSingle->fetch()['imagem'];
		?>

		<div class="box-single-wraper">

			<div class="box-single" <?php if($value['quantidade'] == 0) echo 'style="box-shadow: 1px 1px 10px #c71f1f"'?>>

				<div class="box-topo">
					<?php
					if($imagemSingle == ''){
					?>
					<img style="width: 50%;height: 90px;border-radius: unset;" src="<?php echo INCLUDE_PATH_PAINEL?>img/editar-usuario.png">
					<?php }else{?>
					<img style="width: 50%;height: 90px;border-radius: unset;" src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $imagemSingle?>">
					<?php } ?>
				</div><!--box-topo-->

				<div class="box-corpo">
					<p><b>Nome:</b> <?php echo $value['nome']?></p>
					<p><b>Descrição:</b> <?php echo substr($value['descricao'],0,50)?>..</p>
					<p><b>Largura:</b> <?php echo $value['largura']?></p>
					<p><b>Altura:</b> <?php echo $value['altura']?></p>
					<p><b>Comprimento:</b> <?php echo $value['comprimento']?></p>
					<p><b>Peso:</b> <?php echo $value['peso']?></p>
					<form class="form-quantity" method="POST">
						<p><b>Quantidade Atual:</b> <input type="number" value="<?php echo $value['quantidade']?>" name="quantidade" max="999" min="0" step="1"></p>
						<input type="hidden" name="id_produto" value="<?php echo $value['id']?>">
						<input type="hidden" name="nome_produto" value="<?php echo $value['nome']?>">
						<input type="submit" name="quantidade_atual" value="Atualizar">
					</form>
				</div><!--box-corpo-->

				<div class="box-btn">

					<a href="<?php echo INCLUDE_PATH_PAINEL?>editar-produto?id=<?php echo $value['id']?>"><img src="img/editar-depoimento-verde.png">Editar
					</a>

					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   class="" href="<?php echo INCLUDE_PATH_PAINEL?>visualizar-produtos?deletar=<?php echo $value['id']?>"
						  <?php }else{ ?> 
						  	actionBtn="negado" href="#"
						  <?php } ?>
						  ><img src='img/excluir-depoimento-red.png'>Deletar
					</a>

				</div><!--box-btn-->

			</div><!--box-single-->

		</div><!--box-single-wraper-->

		<?php } ?>

		<div class="clear"></div><!--clear-->

	</div><!--box-wraper-->

</div><!--box-content-->

<?php }else{?>

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
			<h2>Visualizar Produtos</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
			<h2 class="active-btn">Produtos em falta</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
	<h2>Produtos em Falta</h2>
	<br>
	<?php
		if(isset($_POST['quantidade_atual'])){
			$produto_id = $_POST['id_produto'];
			$nome_produto = $_POST['nome_produto'];
			$quantidade = $_POST['quantidade'];
			if($quantidade < 0){
				Painel::alert("erro",'Não é permitido numeros negativos no estoque!');
			}else{
				$sql = Mysql::conectar()->exec("UPDATE `tb_admin.estoque_produtos` SET quantidade = $quantidade WHERE id = $produto_id");
				Painel::alert("sucesso","A quantidade de $nome_produto foi atualizada com sucesso!");
			}

			
		}
	?>

	<div class="box-wraper">

		<?php

			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_produtos` WHERE quantidade = 0");
			$sql->execute();
			$produto = $sql->fetchAll();

			if(count($produto) > 0){
				Painel::alert("atencao","Todos os produtos listados abaixo estão em falta!");
			}else{
				Painel::alert("sucesso","Não existe produto em falta!");
			}

			//echo '<div class="cliente-result">Foram encontrados <b>'.count($produto).'</b> resultado(s)</div><br><form method="post"><div class="busca"><input type="submit" name="acao" value="Ver todos"></form></div>';


			foreach($produto as $key => $value){
				$imagemSingle = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.estoque_imagens` WHERE produto_id = ? LIMIT 1");
				$imagemSingle->execute(array($value['id']));
				$imagemSingle = @$imagemSingle->fetch()['imagem'];
		?>

		<div class="box-single-wraper">

			<div class="box-single" style="box-shadow: 1px 1px 10px #c71f1f">

				<div class="box-topo">
					<?php
					if($imagemSingle == ''){
					?>
					<img style="width: 50%;height: 90px;border-radius: unset;" src="<?php echo INCLUDE_PATH_PAINEL?>img/editar-usuario.png">
					<?php }else{?>
					<img style="width: 50%;height: 90px;border-radius: unset;" src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $imagemSingle?>">
					<?php } ?>
				</div><!--box-topo-->

				<div class="box-corpo">
					<p><b>Nome:</b> <?php echo $value['nome']?></p>
					<p><b>Descrição:</b> <?php echo substr($value['descricao'],0,50)?>..</p>
					<p><b>Largura:</b> <?php echo $value['largura']?></p>
					<p><b>Altura:</b> <?php echo $value['altura']?></p>
					<p><b>Comprimento:</b> <?php echo $value['comprimento']?></p>
					<p><b>Peso:</b> <?php echo $value['peso']?></p>
					<form class="form-quantity" method="POST">
						<p><b>Quantidade Atual:</b> <input type="number" value="<?php echo $value['quantidade']?>" name="quantidade" max="999" min="0" step="1"></p>
						<input type="hidden" name="id_produto" value="<?php echo $value['id']?>">
						<input type="hidden" name="nome_produto" value="<?php echo $value['nome']?>">
						<input type="submit" name="quantidade_atual" value="Atualizar">
					</form>
				</div><!--box-corpo-->

				<div class="box-btn">

					<a href="<?php echo INCLUDE_PATH_PAINEL?>editar-produto?id=<?php echo $value['id']?>"><img src="img/editar-depoimento-verde.png">Editar
					</a>

					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   class="btn-delete" item_id="<?php echo $value['id']?>" href="<?php echo INCLUDE_PATH_PAINEL?>visualizar-produtos?deletar=<?php echo $value['id']?>"
						  <?php }else{ ?> 
						  	actionBtn="negado" href="#"
						  <?php } ?>
						  ><img src='img/excluir-depoimento-red.png'>Deletar
					</a>

				</div><!--box-btn-->

			</div><!--box-single-->

		</div><!--box-single-wraper-->

		<?php } ?>

		<div class="clear"></div><!--clear-->

	</div><!--box-wraper-->

</div><!--box-content-->

<?php } ?>