<?php
	if(isset($_GET['id'])){
		$id = (int)$_GET['id'];
		$cliente_editar = Painel::select('tb_admin.clientes','id = ?',array($id));
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
		<a href="<?php echo INCLUDE_PATH_PAINEL?>gerenciar-clientes">
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
			<h2>Gerenciar Clientes</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
			<h2 class="active-btn">Editar Cliente</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Editar Cliente</h2>

	<div class="form-editar">
		<form class="ajax" atualizar method="POST" action="<?php echo INCLUDE_PATH_PAINEL?>ajax/forms.php" enctype="multipart/form-data">
			<div class="form-group">
				<span>Nome:</span>
				<input type="text" name="nome" required value="<?php echo $cliente_editar['nome']?>">
			</div><!--from-group-->
			<div class="form-group">
				<span>E-mail:</span>
				<input type="text" name="email" required value="<?php echo $cliente_editar['email']?>">
			</div><!--from-group-->
			<div class="form-group">
				<span>Tipo:</span>
				<select name="tipo_cliente">
					<option <?php if($cliente_editar['tipo'] == 'fisico') echo 'selected';?> value="fisico">Fisico</option>
					<option <?php if($cliente_editar['tipo'] == 'juridico') echo 'selected';?> value="juridico">Juridico</option>
				</select>
			</div><!--from-group-->
			<?php
				if($cliente_editar['tipo'] == 'fisico'){
			?>
			<div class="form-group cpf-input">
				<span>CPF:</span>
				<input type="text" name="cpf" required value="<?php echo $cliente_editar['cpf_cnpj']?>">
			</div><!--from-group-->
			<div style="display:none;" class="form-group cnpj-input">
				<span>CNPJ:</span>
				<input type="text" name="cnpj" required value="<?php echo $cliente_editar['cpf_cnpj']?>">
			</div><!--from-group-->
			<?php }else{?>
			<div style="display:none;" class="form-group cpf-input">
				<span>CPF:</span>
				<input type="text" name="cpf" required value="<?php echo $cliente_editar['cpf_cnpj']?>">
			</div><!--from-group-->
			<div style="display:block;" class="form-group cnpj-input">
				<span>CNPJ:</span>
				<input type="text" name="cnpj" required value="<?php echo $cliente_editar['cpf_cnpj']?>">
			</div><!--from-group-->
			<?php }?>

			<div class="form-group">
				<span>Imagen:</span>
				<?php
				if($cliente_editar['foto'] == ''){
				?>
				<img style="width: 50px; height: 50px;border-radius: 50%; vertical-align: middle;" src="<?php echo INCLUDE_PATH_PAINEL?>img/icone-user.png"/>
				<?php }else{?>
				<img style="width: 50px; height: 50px;border-radius: 50%; vertical-align: middle;" src="<?php echo INCLUDE_PATH_PAINEL?>uploads/<?php echo $cliente_editar['foto']?>"/>
				<?php }?>
				<input style="width: calc(100% - 120px)" type="file" name="imagem_adicionar" id="input-img" value="">
				<input type="hidden" name="imagem_original" value="<?php echo $cliente_editar['foto'];?>">
				<label style="left: 125px;" for="input-img" name="imagem_adicionar"><img src="<?php echo INCLUDE_PATH_PAINEL?>img/enviar-img.png"></label>
			</div><!--from-group-->
			<div class="form-group">
				<input type="hidden" name="tipo_acao" value="editar_cliente">
				<input type="hidden" name="id" value="<?php echo $id?>">
				<input <?php permissaoInput(1,'acao_editar','Atualizar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Adicionar Pagamento</h2>

	<?php
		if(isset($_POST['acao_inserir'])){
			$cliente_id = $id;
			$nome = strtolower($_POST['nome']);
			$valor = $_POST['valor'];
			$parcela = $_POST['parcelas'];
			$vencimentoOriginal = $_POST['vencimento'];
			$intervalo = $_POST['intervalo'];
			$status = 0;

			if($vencimentoOriginal < date('Y-m-d')){
				Painel::alert("erro",'Não é possivel adicionar um pagamento com data negativa!');	
			}else{
				if($intervalo == null){
				$intervalo = 0;
					for($i = 0; $i < $parcela; $i++){
						$vencimento = strtotime($vencimentoOriginal) + (($i * $intervalo) *(60*60*24));
						$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.financeiro` VALUES(null,?,?,?,?,?,?)");
						$sql->execute(array($cliente_id,$nome,$valor,date('Y-m-d',$vencimento),$intervalo,$status));		
					}
				}else{
					for($i = 0; $i < $parcela; $i++){
						$vencimento = strtotime($vencimentoOriginal) + (($i * $intervalo) *(60*60*24));
						$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.financeiro` VALUES(null,?,?,?,?,?,?)");
						$sql->execute(array($cliente_id,$nome,$valor,date('Y-m-d',$vencimento),$intervalo,$status));		
					}
				}
				

				Painel::alert("sucesso",'Pagamento Adicionado com Sucesso!');
			}

		}

	?>

	<div class="form-editar">
		<form method="POST">
			<div class="form-group">
				<span>Nome:</span>
				<input type="text" name="nome" required value="">
			</div><!--from-group-->
			<div class="form-group">
				<span>Valor:</span>
				<input type="text" name="valor" required value="">
			</div><!--from-group-->
			<div class="form-group">
				<span>Parcela:</span>
				<input type="text" name="parcelas" required value="">
			</div><!--from-group-->
			<div class="form-group">
				<span>Venc.:</span>
				<input type="text" name="vencimento" required>
			</div><!--from-group-->
			<div class="form-group">
				<span>Intervalo:</span>
				<input type="text" name="intervalo" value="">
			</div><!--from-group-->
			<div class="form-group">
				<input <?php permissaoInput(1,'acao_inserir','Inserir')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->

<?php include("listar-financeiro.php")?>

<?php include("listar-concluidos.php")?>