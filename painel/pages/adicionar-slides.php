
<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Adicionar Slides</h2>
		<?php
		if(isset($_POST['acao_adicionar'])){
			$nome = $_POST['nome'];
			$imagem = $_FILES['imagem_adicionar'];
	
			if($nome == ''){
				Painel::alert('erro','Adicione um nome para continuar');
			}else{
				if(Painel::imagemValida($imagem) == true){
					$imagem = Painel::uploadFile($imagem);
					$arr = ['nome'=>$nome,'nome_tabela'=>'tb_site.slides','slide'=>$imagem,'order_id'=>'0'];
					Painel::insert($arr);
					Painel::alert('sucesso','Slide Adicionado Com Sucesso!');
					Painel::redirect(INCLUDE_PATH_PAINEL.'gerenciar-slides');
				}else{
					Painel::alert('erro','O formato da Imagem Não é Valida');
				}

			}
		}
	?>

	<div class="form-editar">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<span>Nome:</span>
				<input type="text" name="nome" required>
			</div><!--from-group-->
			<div class="form-group">
				<span>Imagen:</span>
				<input type="file" name="imagem_adicionar" id="input-img-adicionar">
				<label for="input-img-adicionar" name="imagem_adicionar"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="form-group">
				
				<input <?php permissaoInput(1,'acao_adicionar','Adicionar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
