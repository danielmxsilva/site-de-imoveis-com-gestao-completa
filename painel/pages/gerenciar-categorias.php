<?php
	if(isset($_GET['excluir'])){
		$idExcluir = intval($_GET['excluir']);
		Painel::deletar('tb_site.categorias',$idExcluir);
		$noticias = Mysql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE categoria_id = ?");
		$noticias->execute(array($idExcluir));
		$noticias = $noticias->fetchAll();
		foreach ($noticias as $key => $value){
			$imgDelete = $value['capa'];
			Painel::deleteFile($imgDelete);
		}
		$noticias = Mysql::conectar()->prepare("DELETE FROM `tb_site.noticias` WHERE categoria_id = ?");
		$noticias->execute(array($idExcluir));
		Painel::redirect(INCLUDE_PATH_PAINEL.'gerenciar-categorias');
	}else if(isset($_GET['order']) && isset($_GET['id'])){
		Painel::orderItem('tb_site.categorias',$_GET['order'],$_GET['id']);
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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-categorias">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Gerenciar Categorias</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
			<h2 class="active-btn">Adicionar Categorias</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php include('pages/listar-categorias.php')?>

<br>

<?php
	
	include('pages/cadastrar-categorias.php');

?>