<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$categoria = Painel::select('tb_admin.empreendimentos','id = ?',array($id));
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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>listar-empreendimentos">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Gerenciar Empreendimentos</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
			<h2 class="active-btn">Editar Empreendimento</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content" style="margin-top:40px;">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
	<h2>Editar Empreendimento</h2>


</div><!--box-content-->

