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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>cadastrar-empreendimento">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Cadastrar Empreendimento</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
			<h2 class="active-btn">Visualizar Empreendimentos</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
	<h2>Empreendimentos Cadastrados</h2>

	<div class="busca">
		<h2>Realizar uma busca</h2>
		<form method="post">
			<input type="text" name="busca" placeholder="Procure por nome">
			<input type="submit" name="acao" value="Buscar">
		</form>
	</div><!--busca-->
	<br>
	<?php

		if(isset($_GET['deletar'])){
			$id = (int)$_GET['deletar'];
			$imagens = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` WHERE id = $id");
			$imagens->execute();
			$imagens = $imagens->fetch()['imagem'];

			@unlink(BASE_DIR_PAINEL.'/uploads/'.$imagens);

			$sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.empreendimentos` WHERE id = $id");
			Painel::alert("sucesso","Empreendimento deletado com sucesso!");
		}

		echo '<br>';
		
	?>

	<div class="box-wraper ajax-ui">

		<?php
			$query = "";
			if(isset($_POST['acao']) && $_POST['acao'] == 'Buscar'){
				$busca = $_POST['busca'];
				$query = "WHERE nome LIKE '%$busca%'";
			}
			
			if(isset($_POST['acao']) && $_POST['acao'] == 'Ver todos'){
				$query = "";
			}
			if($query == ""){
				$query2 = "";
			}else{
				$query2 = "";
			}
			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` $query $query2 ORDER BY order_id ASC");
			$sql->execute();
			$produto = $sql->fetchAll();
			if($query != ''){
				echo '<div class="cliente-result">Foram encontrados <b>'.count($produto).'</b> resultado(s)</div><br><form method="post"><div class="busca"><input type="submit" name="acao" value="Ver todos"></form></div>';
			}

			foreach($produto as $key => $value){
				$imagemSingle = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` WHERE id = ?");
				$imagemSingle->execute(array($value['id']));
				$imagemSingle = $imagemSingle->fetch()['imagem'];
		?>

		<div id="item-<?php echo $value['id']?>" class="box-single-wraper">

			<div class="box-single">

				<div class="box-topo">

					<img style="width: 100%;height: 170px;border-radius: unset;" src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $imagemSingle?>">
	
				</div><!--box-topo-->

				<div class="box-corpo">
					<p><b>Nome:</b> <?php echo $value['nome']?></p>
					<p><b>Tipo:</b> <?php echo $value['tipo']?></p>
				</div><!--box-corpo-->

				<div class="box-btn">

					<a href="<?php echo INCLUDE_PATH_PAINEL?>editar-empreendimento?id=<?php echo $value['id']?>"><img src="img/editar-depoimento-verde.png">Editar
					</a>

					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   class="" href="<?php echo INCLUDE_PATH_PAINEL?>listar-empreendimentos?deletar=<?php echo $value['id']?>"
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


