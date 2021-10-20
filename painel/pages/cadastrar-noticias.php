
<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Adicionar Noticia</h2>
	<?php
		if(isset($_POST['acao_adicionar'])){
			$categoria_id = $_POST['categoria_id'];
			$titulo = $_POST['titulo'];
			$conteudo = $_POST['conteudo'];
			$capa = $_FILES['capa'];

			if($titulo == '' || $conteudo == '' || $categoria_id == ''){
				Painel::alert('erro','Campos vazios não são permitidos!');
			}else if($capa['tmp_name'] == ''){
				Painel::alert('erro','A imagem de capa precisa ser selecionada.');
			}else{
				if(Painel::imagemValida($capa)){
					$verifica = Mysql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE titulo = ? AND categoria_id = ?");
					$verifica->execute(array($titulo,$categoria_id));
					if($verifica->rowCount() == 0){
						$capa = Painel::uploadFile($capa);
						$slug = Painel::generateSlug($titulo);
						$arr = ['categoria_id'=>$categoria_id,'data'=>date('Y-m-d'),'titulo'=>$titulo,'conteudo'=>$conteudo,'capa'=>$capa,'slug'=>$slug,'order_id'=>'0','nome_tabela'=>'tb_site.noticias'];
						if(Painel::insert($arr)){
							Painel::alert('sucesso','O cadastro da noticia foi realizado com sucesso!');
							Painel::redirect(INCLUDE_PATH_PAINEL.'gerenciar-noticias');
						}

					}else{
						Painel::alert('erro','Já existe uma notícia com esse nome!');
					}
				}else{
					Painel::alert('erro','Selecione uma imagem válida!');
				}
			}
		}
	?>
	<div class="form-editar cadastro-depoimentos">
		<form method="POST" enctype="multipart/form-data">
			<div class="group-depoimento">
				<span>Categoria:</span>
				<select name="categoria_id" required>
					<?php
 						$categoria = Painel::selectAll('tb_site.categorias');
 						foreach($categoria as $key => $value){
					?>
					<option <?php if($value['id'] == @$_POST['categoria_id']) echo 'selected'?> value="<?php echo $value['id']?>"><?php echo $value['nome']?></option>
					<?php } ?>
				</select>
			</div><!--from-group-->
			<div class="group-depoimento">
				<span>Titulo:</span>
				<input type="text" name="titulo" value="<?php echo recoverPost('titulo')?>">
			</div><!--from-group-->
			<div class="form-group">
				<span>Capa:</span>
				<input style="width: calc(100% - 120px)" type="file" name="capa" id="input-img" value="<?php echo $_SESSION['img'];?>">
				<label style="left: 110px;" for="input-img" name="capa"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align: top;">Conteudo:</span>
				<textarea  name="conteudo" required><?php echo recoverPost('conteudo')?></textarea>
			</div><!--from-group-->
			
			<div class="group-depoimento">
				<input type="hidden" name="order_id" value="0">
				<input type="hidden" name="nome_tabela" value="tb_site.depoimentos">
				<input <?php permissaoInput(1,'acao_adicionar','Adicionar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
<script>
	tinymce.init({
      selector: '.tinymce',
	 // menubar: 'insert',
      plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker image',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter pageembed permanentpen table image',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
      height: 400,
   });
</script>

