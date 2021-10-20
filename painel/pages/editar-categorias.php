<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$categoria = Painel::select('tb_site.categorias','id = ?',array($id));
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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-categorias">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Gerenciar Catagoria</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
			<h2 class="active-btn">Editar Categoria</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php include('pages/listar-categorias.php')?>

	<div class="box-content" style="margin-top:40px;">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
	<h2>Editar Categoria</h2>

	<?php
		if(isset($_POST['acao_editar'])){
			$slug = Painel::generateSlug($_POST['nome']);
			$arr = array_merge($_POST,array('slug'=>$slug));
			$verificar = Mysql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE nome = ? AND id != ?");
			$verificar->execute(array($_POST['nome'],$id));
			if($verificar->rowCount() == 1){
				Painel::alert('erro','Já existe uma categoria com este nome!');
			}else{
				if(Painel::update($arr)){
					Painel::alert('sucesso','Categoria Atualizada Com Sucesso!');
					$categoria = Painel::select('tb_site.categorias','id = ?',array($id));
				}else{
					Painel::alert('erro','Campos Vazios não sao Permitidos!');
				}
			}
		}
	?>

	<div class="form-editar cadastro-depoimentos">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group cadastrar-group">
				<span class="span-categoria">Nome da Categoria:</span>
				<input class="input-categoria" type="text" name="nome" required value="<?php echo $categoria['nome']?>">
			</div><!--from-group-->
			<div class="group-depoimento">
				<input type="hidden" name="id" value="<?php echo $categoria['id'] ?>">
				<input type="hidden" name="nome_tabela" value="tb_site.categorias">
				<input <?php permissaoInput(1,'acao_editar','Editar') ?> />
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
<script src="<?php echo INCLUDE_PATH?>js/jquery.js"></script>
