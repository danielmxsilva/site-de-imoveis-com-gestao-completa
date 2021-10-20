<?php
	$config = Painel::select('tb_site.config',false);
?>
<div class="wraper-titulo">
	<div class="titulo-content">
		<img style="position:relative;top:5px;" src="<?php echo INCLUDE_PATH_PAINEL?>img/config.png">
		<h2>Configuração Geral</h2>
	</div><!--titulo-content-->
	<div class="breadcrump">
	<a href="<?php echo INCLUDE_PATH_PAINEL?>index.php">
		<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/home.png">
		<h2>Home</h2>
	</a>
		<span>/</span>
		<img src="<?php echo INCLUDE_PATH_PAINEL?>img/config.png">
		<h2 class="active-btn">Configuração Geral</h2>
	</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php permissaoPagina(1)?>

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-depoimento-gray.png">
	<h2>Editar Site</h2>

	<?php
			/*
			$imagem_autor_novo = $_FILES['imagem_autor_novo'];
			$imagem_autor_atual = $_POST['imagem_autor_atual'];
			$imagem_especial_novo1 = $_FILES['imagem_especial_novo1'];
			$imagem_especial_atual1 = $_POST['imagem_especial_atual1'];
			$titulo_especial1 = $_POST['titulo_especial1'];
			$descricao_especial1 = $_POST['descricao_especial1'];
			$imagem_especial_novo2 = $_FILES['imagem_especial_novo2'];
			$imagem_especial_atual2 = $_POST['imagem_especial_atual2'];
			$titulo_especial2 = $_POST['titulo_especial2'];
			$descricao_especial2 = $_POST['descricao_especial2'];
			$imagem_especial_novo3 = $_FILES['imagem_especial_novo3'];
			$imagem_especial_atual3 = $_POST['imagem_especial_atual3'];
			$titulo_especial3 = $_POST['titulo_especial3'];
			$descricao_especial3 = $_POST['descricao_especial3'];
			$nome_tabela = $_POST['nome_tabela'];

			$titulo = $_POST['titulo'];
			$nome_autor = $_POST['nome_autor'];
			$descricao_autor = $_POST['descricao_autor'];
			$img_autor
			$img_especial1
			$titulo_especial1
			$descricao_especial1
			$img_especial2
			$titulo_especial2
			$descricao_especial2
			$img_especial3
			$titulo_especial3
			$descricao_especial3
			*/
		if(isset($_POST['acao_editar'])){
			if(Painel::updateConfig($_POST)){;
				Painel::alert('sucesso','Site Atualizado com sucesso!');
				Painel::redirect(INCLUDE_PATH_PAINEL.'configuracao-geral');
			}else{
				Painel::alert('Campos Vazios não são permitidos!');
			}
		}
	
	?>

	<div class="form-editar cadastro-depoimentos">
		<form method="POST" enctype="multipart/form-data">
			<div class="group-depoimento group-textarea">
				<span>Titulo:</span>
				<input type="text" name="titulo" value="<?php echo $config['titulo']?>">
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span>Nome Autor:</span>
				<input type="text" name="nome_autor" value="<?php echo $config['nome_autor']?>">
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Descrição Autor:</span>
				<textarea name="descricao_autor"><?php echo $config['descricao_autor']?></textarea>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea form-group">
				<span>Foto Autor:</span>
				<input type="hidden" name="imagem_autor_atual" value="<?php echo $config['img_autor']?>">
				<input style="width: calc(100% - 190px)" type="file" name="img_autor" id="input-img" value="<?php echo $config['img_autor'];?>">
				<label class="config-geral-label" style="left: 108px;top: -45px;" for="input-img" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea form-group">
				<span>Img Especialid..:</span>
				<input type="hidden" name="imagem_especial_atual1" value="<?php echo $config['img_especial1']?>">
				<input style="width: calc(100% - 190px)" type="file" name="img_especial1" id="input-img-espec1" value="<?php echo $config['img_especial2'];?>">
				<label class="config-geral-label" style="left: 108px;top: -45px;" for="input-img-espec1" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Titulo Especialid..:</span>
				<input type="text" name="titulo_especial1" value="<?php echo $config['titulo_especial1']?>">
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Descrição Especialid..:</span>
				<textarea name="descricao_especial1"><?php echo $config['descricao_especial1']?></textarea>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea form-group">
				<span>Img Especialid..:</span>
				<input type="hidden" name="imagem_especial_atual2" value="<?php echo $config['img_especial2']?>">
				<input style="width: calc(100% - 190px)" type="file" name="img_especial2" id="input-img-espec2" value="<?php echo $config['img_especial2'];?>">
				<label class="config-geral-label" style="left: 108px;top: -45px;" for="input-img-espec2" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Titulo Especialid..:</span>
				<input type="text" name="titulo_especial2" value="<?php echo $config['titulo_especial2']?>">
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Descrição Especialid..:</span>
				<textarea name="descricao_especial2"><?php echo $config['descricao_especial2']?></textarea>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea form-group">
				<span>Img Especialid..:</span>
				<input type="hidden" name="imagem_especial_atual3" value="<?php echo $config['img_especial3']?>">
				<input style="width: calc(100% - 190px)" type="file" name="img_especial3" id="input-img-espec3" value="<?php echo $config['img_especial3'];?>">
				<label class="config-geral-label" style="left: 108px;top: -45px;" for="input-img-espec3" name="imagem"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Titulo Especialid..:</span>
				<input type="text" name="titulo_especial3" value="<?php echo $config['titulo_especial3']?>">
			</div><!--from-group-->
			<div class="group-depoimento group-textarea">
				<span style="vertical-align:top;">Descrição Especialid..:</span>
				<textarea name="descricao_especial3"><?php echo $config['descricao_especial3']?></textarea>
			</div><!--from-group-->
			<div class="group-depoimento">
				<input type="hidden" name="nome_tabela" value="tb_site.config">
				<input <?php permissaoInput(1,'acao_editar','Editar') ?> />
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->