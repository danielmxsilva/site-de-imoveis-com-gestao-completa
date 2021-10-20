<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$noticia_editar = Painel::select('tb_site.noticias','id = ?',array($id));
	}else{
		Painel::alert('erro','Você Precisa Passar o ID!');
		die();
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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-noticias">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Gerenciar Noticias</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
			<h2 class="active-btn">Editar Noticias</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php include('pages/listar-noticias.php')?>

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Editar Noticias</h2>
	<?php
		if(isset($_POST['acao_editar'])){
			$titulo = $_POST['titulo'];
			$conteudo = $_POST['conteudo'];
			$categoria = $_POST['categoria_id'];
			$imagem_atual = $_POST['imagem_atual'];
			$imagem = $_FILES['imagem'];

			$verificar = Mysql::conectar()->prepare("SELECT `id` FROM `tb_site.noticias` WHERE titulo = ? AND categoria_id = ? AND id != ?");
			$verificar->execute(array($titulo,$categoria,$id));
			if($verificar->rowCount() == 0){
				
			if($imagem['name'] != ''){
				if(Painel::imagemValida($imagem)){
					$slug = Painel::generateSlug($_POST['titulo']);
					Painel::deleteFile($imagem_atual);
					$imagem = Painel::uploadFile($imagem);
					$arr = ['titulo'=>$titulo,'categoria_id'=>$categoria,'data'=>date('Y-m-d'),'nome_tabela'=>'tb_site.noticias','conteudo'=>$conteudo,'capa'=>$imagem,'slug'=>$slug,'id'=>$id];
					Painel::update($arr);
					Painel::alert('sucesso','Notícia Editada Com Sucesso!');
					$noticia_editar = Painel::select('tb_site.noticias','id = ?',array($id));
					Painel::redirect(INCLUDE_PATH_PAINEL.'editar-noticias?id='.$id);
				}else{
					Painel::alert('erro','O formato da imagem não é valida');
					}
				}else{
					$slug = Painel::generateSlug($_POST['titulo']);
					$imagem = $imagem_atual;
					$arr = ['titulo'=>$titulo,'categoria_id'=>$categoria,'data'=>date('Y-m-d'),'nome_tabela'=>'tb_site.noticias','conteudo'=>$conteudo,'capa'=>$imagem,'slug'=>$slug,'id'=>$id];
					Painel::update($arr);
					Painel::alert('sucesso','Notícia Editada Com Sucesso!');
					$noticia_editar = Painel::select('tb_site.noticias','id = ?',array($id));
					Painel::redirect(INCLUDE_PATH_PAINEL.'editar-noticias?id='.$id);
				}
			}else{
				Painel::alert('erro','Já existe uma notícia com este nome!');
			}
		}
	?>
	<div class="form-editar">
		<form method="POST" enctype="multipart/form-data">
			<div class="group-depoimento">
				<span>Categoria:</span>
				<select name="categoria_id" required>
					<?php
 						$categoria = Painel::selectAll('tb_site.categorias');
 						foreach($categoria as $key => $value){
					?>
					<option <?php if($value['id'] == $noticia_editar['categoria_id'] ) echo 'selected'?> value="<?php echo $value['id']?>"><?php echo $value['nome']?></option>
					<?php } ?>
				</select>
			</div><!--from-group-->
			<div class="form-group cadastrar-categoria">
				<span>Titulo:</span>
				<input type="text" name="titulo" required value="<?php echo $noticia_editar['titulo']?>">
			</div><!--from-group-->
			<div class="form-group cadastrar-categoria">
				<span>Capa:</span>
				<img style="max-width: 70px; vertical-align: middle;" src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $noticia_editar['capa']?>"/>
				<input style="width: calc(100% - 180px)" type="file" name="imagem" id="input-img" value="">
				<input type="hidden" name="imagem_atual" value="<?php echo $noticia_editar['capa'];?>">
				<label style="left: 142px;" for="input-img" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea cadastrar-categoria">
				<span style="vertical-align: top;">Conteúdo:</span>
				<textarea class="tinymce" name="conteudo" required><?php echo $noticia_editar['conteudo'] ?></textarea>
			</div><!--from-group-->
			
			<div class="form-group">
				
				<input <?php permissaoInput(1,'acao_editar','Editar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->