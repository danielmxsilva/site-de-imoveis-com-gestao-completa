

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Cadastrar Categoria</h2>
		<?php
		if(isset($_POST['acao_adicionar'])){
			$verificar = Mysql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE nome = ?");
			$verificar->execute(array($_POST['nome']));
			if($verificar->rowCount() == 1){
				Painel::alert('erro','Já existe uma categoria com este nome!');
				die();
			}else{
				$slug = Painel::generateSlug($_POST['nome']);
				$arr = ['nome'=>$_POST['nome'],'slug'=>$slug,'nome_tabela'=>'tb_site.categorias','order_id'=>'0'];
				Painel::insert($arr);
				Painel::alert('sucesso','Categoria cadastrada Com Sucesso!');
				Painel::redirect(INCLUDE_PATH_PAINEL.'gerenciar-categorias');

			}
		}
	?>

	<div class="form-editar">
		<form method="POST" enctype="multipart/form-data">
			<div class="form-group cadastrar-group">
				<span class="span-categoria">Nome da Categoria:</span>
				<input class="input-categoria" type="text" name="nome" required>
			</div><!--from-group-->
			<div class="form-group cadastrar-group">
				
				<input <?php permissaoInput(1,'acao_adicionar','Cadastrar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
