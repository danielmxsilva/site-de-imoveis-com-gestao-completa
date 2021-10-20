<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$servico_editar = Painel::select('tb_site.servico','id = ?',array($id));
	}else{
		Painel::alert('erro','Você Precisa Passar o ID!');
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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-depoimentos">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Gerenciar Serviços</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
			<h2 class="active-btn">Editar Serviços</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php include('pages/listar-servicos.php')?>

	<div class="box-content" style="margin-top:40px;">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
	<h2>Editar Depoimentos</h2>

	<?php
		if(isset($_POST['acao_editar'])){
			if(Painel::update($_POST)){
				Painel::alert('sucesso','Depoimento Atualizado Com Sucesso!');
				Painel::redirect(INCLUDE_PATH_PAINEL.'editar-servico?id='.$id);
			}else{
				Painel::alert('erro','Campos Vazios não sao Permitidos!');
			}
		}
	?>

	<div class="form-editar cadastro-depoimentos">
		<form method="POST" enctype="multipart/form-data">
			<div class="group-depoimento group-textarea">
				<span style="vertical-align: top;">Serviço:</span>
				<textarea name="servicos" required><?php echo $servico_editar['servicos'] ?></textarea>
			</div><!--from-group-->
			<div class="group-depoimento">
				<input type="hidden" name="id" value="<?php echo $servico_editar['id'] ?>">
				<input type="hidden" name="nome_tabela" value="tb_site.servico">
				<input <?php permissaoInput(1,'acao_editar','Editar') ?> />
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
<script src="<?php echo INCLUDE_PATH?>js/jquery.js"></script>
