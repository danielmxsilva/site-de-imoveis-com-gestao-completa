<?php
	if(isset($_GET['loggout'])){
		Painel::loggout();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Painel</title>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/default/zebra_datepicker.min.css" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH_PAINEL;?>css/style.css" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH_PAINEL?>css/jquery-ui.min.css" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH_PAINEL;?>img/icone-painel.png" type="image-x/png" rel="shortcut icon">
	<script src="https://cdn.tiny.cloud/1/4rtcsu1dd5h9dkf6r4vb5vb9df9ke21mllpfl0wbir3dufjl/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>

	<base base="<?php echo INCLUDE_PATH_PAINEL;?>"/>

	<header>
			<div class="icone-menu"></div>
			<div class="nome-painel-procurar">
				<div class="nome-painel">
					<h1><span class="color-blue">ADMIN</span> <?php echo NOME_EMPRESA?></h1>
				</div><!--nome-painel-->
				<div class="procurar">
					<input type="text" name="procurar" placeholder="procurar">
				</div>
			</div><!--nome-painel-procurar-->
			<div class="perfil-menu">
				<div class="msg">
					<div class="alerta-notificacao">1</div>
					<div class="submenu-msg">
						<div class="titulo-msg">
							<h2>Você tem <span>1</span> Nova mensagem!</h2>
						</div><!--titulo-msg-->
						<p>Administrador
							<hr>
							<span>Seja Bem vindo ao painel</span>
						</p>
					
					</div><!--submenu-msg-->
				</div><!--msg-->
				<div class="notificacao">
					<div class="alerta-notificacao">3</div>
					<div class="submenu-notif">

						<div class="titulo-msg">
							<h2>Você tem <span>3</span> Novas notificação!</h2>
						</div><!--titulo-msg-->

						<p>Texto adicionado na página principal</p>
						<hr>
						<p>Texto adicionado na página principal</p>
						<hr>
						<p>Texto adicionado na página principal</p>
						<hr>
					</div><!--submenu-msg-->
				</div><!--notificacao-->
				<div class="perfil">
					<?php 
						if($_SESSION['img'] == ' '){
					?>
						<div class="icone-perfil">
							<img src="<?php echo INCLUDE_PATH_PAINEL?>img/icone-user.png">
						</div><!--icone-perfil-->
					<?php }else{ ?>
						<div class="icone-perfil">
							<img src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $_SESSION['img']?>">
						</div><!--icone-perfil-->
					<?php } ?>
					<div class="nome-perfil">
						<span><?php echo $_SESSION['nome']?></span>
						<span><?php echo pegaCargo($_SESSION['cargo'])?></span>
					</div><!--nome-perfil-->
					
					<div class="seta-baixo">
						<img src="<?php echo INCLUDE_PATH_PAINEL?>img/seta-baixo.png">
					</div><!--seta-baixo-->

					<div class="sub-menu-perfil">
						<ul>
							<li><img src="<?php echo INCLUDE_PATH_PAINEL?>img/config.png"><a href="<?php echo INCLUDE_PATH_PAINEL?>configuracao-geral">Configuração Geral</a></li>
							<li><img src="<?php echo INCLUDE_PATH_PAINEL?>img/icon-adm.png"><a href="<?php echo INCLUDE_PATH_PAINEL?>adm-painel">ADM Painel</a></li>
							<li><img src="<?php echo INCLUDE_PATH_PAINEL?>img/logout.png"><a href="<?php echo INCLUDE_PATH_PAINEL?>?loggout">Sair</a></li>
						</ul>
					</div><!--sub-menu-perfil-->
				</div><!--perfil-->
			</div>
			<div class="clear"></div>
	</header>

<div class="wraper-body">

	<aside>
		<div class="cadastro-aside">
			<h2>Gestão do Site</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-depoimentos">Gerenciar Depoimentos</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-servico">Gerenciar Serviços</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-slides">Gerenciar Slides</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>configuracao-geral">Gerenciar Site</a>
		</div><!--cadastro-aside-->
		<div class="gestao-aside">
			<h2 class="gestao-adm">Administração do Painel</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>adm-painel">Gerenciar Usuário</a>
		</div>
		<div class="gestao-aside">
			<h2 class="gestao-adm">Gestão de Notícias</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-categorias">Gerenciar Categoria</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-noticias">Gerenciar Notícias</a>
		</div>
		<div class="gestao-aside">
			<h2 class="gestao-adm">Gestão de Clientes</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>cadastrar-clientes">Cadastrar Clientes</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-clientes">Gerenciar Clientes</a>
		</div>
		<div class="gestao-aside">
			<h2 class="gestao-adm">Controle Financeiro</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>controle-financeiro">Controle Financeiro</a>
		</div>
		<div class="gestao-aside">
			<h2 class="gestao-adm">Controle de Estoque</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>cadastrar-produto">Cadastrar Produto</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>visualizar-produtos">Visualizar Produtos</a>
		</div>
		<div class="gestao-aside">
			<h2 class="gestao-adm">Gestão de Imoveis</h2>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>cadastrar-empreendimento">Cadastrar Empreendimento</a>
			<a href="<?php echo INCLUDE_PATH_PAINEL?>listar-empreendimentos">Listar Empreendimentos</a>
		</div>
	</aside>

	<div class="wraper-content">
		<div class="content">
			
			<?php Painel::carregarPagina();?>

		</div><!--content-->
		
	</div><!--content-->

</div><!--wraper-body-->

	<script src="<?php echo INCLUDE_PATH?>js/jquery.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/jquery-ui.min.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/ui-ux.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/fade-menu.js"></script>
	<script src="<?php echo INCLUDE_PATH?>js/jquery.mask.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/jquery.maskMoney.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/zebra_datepicker.min.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/controleFinanceiro.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/jquery.ajaxform.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/helperMask.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/ajax.js"></script>
	<script src="<?php echo INCLUDE_PATH_PAINEL?>js/constants.js"></script>
	<script>
		$(function(){
			$('input[name=data]').mask('99/99/9999');
		})
	</script>
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
    <!--
    	função de inserção dinamica de script na página, via url
    <?php //Painel::loadJs(array('clientes.js'),'gerenciar-clientes');?>

  	-->	

</body>
</html>