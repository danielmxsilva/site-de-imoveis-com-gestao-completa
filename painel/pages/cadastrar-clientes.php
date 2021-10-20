<div class="wraper-titulo">
				<div class="titulo-content">
					<img src="<?php echo INCLUDE_PATH_PAINEL?>img/icon-adm.png">
					<h2>Administrar Painel</h2>
				</div><!--titulo-content-->
				<div class="breadcrump">
				<a href="<?php echo INCLUDE_PATH_PAINEL?>index.php">
					<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/home.png">
					<h2>Home</h2>
				</a>
					<span>/</span>
					<img src="<?php echo INCLUDE_PATH_PAINEL?>img/icon-adm.png">
					<h2 class="active-btn">Cadastrar Clientes</h2>
				</div><!--breadcrump-->
</div><!--wraper-titulo-->

<?php permissaoPagina(1)?>

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/editar-usuario.png">
	<h2>Cadastrar Clientes</h2>

	<div class="form-editar">
		<form class="ajax" action="<?php echo INCLUDE_PATH_PAINEL?>ajax/forms.php" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<span>Nome:</span>
				<input type="text" name="nome" value="" >
			</div><!--from-group-->
			<div class="form-group">
				<span>E-mail:</span>
				<input type="text" name="email" value="" >
			</div><!--from-group-->
			<div class="form-group">
				<span>Tipo:</span>
				<select name="tipo_cliente" >
					<option value="fisico">Físico</option>
					<option value="juridico">Juridico</option>
				</select>
			</div><!--form-group-->

			<div ref="cpf" class="cpf-input form-group">
				<span>CPF:</span>
				<input type="text" name="cpf" value="">
			</div><!--from-group-->

			<div style="display:none;" ref="cnpj" class="cnpj-input form-group">
				<span>CNPJ:</span>
				<input type="text" name="cnpj" value="">
			</div><!--from-group-->

			<div class="form-group">
				<span>Imagen:</span>
				<input type="hidden" name="imagem_default" value=" ">
				<input type="file" name="imagem_adicionar" id="input-img-adicionar">
				<label for="input-img-adicionar" name="imagem_adicionar"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="form-group">
				<input type="hidden" name="tipo_acao" value="cadastrar_cliente">
				<input <?php permissaoInput(1,'acao_adicionar','Cadastrar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
