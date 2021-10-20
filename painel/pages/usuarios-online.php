<?php
	$usuariosOnline = Painel::listarUsuariosOnline();
?>
<div class="wraper-titulo">
		<div class="titulo-content">
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/usuarios-online.png">
			<h2>Usuarios Online</h2>
		</div><!--titulo-content-->
		<div class="breadcrump">
		<a href="<?php echo INCLUDE_PATH_PAINEL?>index.php">
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/home.png">
			<h2>Home</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/usuarios-online.png">
			<h2 class="active-btn">Usuarios Online</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-usuarios-online">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/usuarios-online.png">
	<h2>Usuários Online</h2>
	<div class="tabela-usuarios">
		<div class="titulo-tabela">
			<div class="titulo-parte w50">
				<h3>IP</h3>
			</div><!--titulo-parte-->
			<div class="titulo-parte w50">
				<h3>Última Ação</h3>
			</div><!--titulo-parte-->
			<div class="clear"></div>
		</div><!--titulo-tabela-->
		<hr>
		<?php
			foreach($usuariosOnline as $key => $value){
		?>
		<div class="conteudo-tabela">
			<div class="w50">
				<span><?php echo $value['ip']?></span>
			</div><!--w50-->
			<div class="w50">
				<span><?php echo date('d/m/Y H:i:s',strtotime($value['ultima_acao']))?></span>
			</div><!--w50-->
			<div class="clear"></div>
		</div><!--conteudo-tabela-->
		<?php } ?>
	</div><!--tabela-usuarios-->

	<div class="clear"></div>
</div><!--box-usuarios-online-->
