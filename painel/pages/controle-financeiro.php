
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
			<h2>Gerenciar Pagamentos</h2>
		</a>
			<span>/</span>
			<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
			<h2 class="active-btn">Visualizando Pagamentos</h2>
		</div><!--breadcrump-->
</div><!--wraper-titulo-->

<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
	<h2>Pagamentos Pendentes</h2>

	<div class="busca">
		<h2>Realizar uma busca</h2>
		<form method="post">
			<input type="text" name="busca_pagamentos" placeholder="nome do pagamento">
			<input type="submit" name="acao_buscar" value="Buscar">
		</form>
	</div><!--busca-->

	<div class="gerar-pdf">
		<a target="_blank" href="<?php echo INCLUDE_PATH?>gerar-pdf.php?pagamentos=pendentes">Gerar PDF</a>
	</div><!--gerar-pdf-->


	<?php
		if(isset($_GET['pago'])){
			$sql = Mysql::conectar()->prepare("UPDATE `tb_admin.financeiro` SET status = 1 WHERE id = ?");	
			if($sql->execute(array($_GET['pago']))){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE id = ?");
				$sql->execute(array($_GET['pago']));
				$data = $sql->fetch()['nome'];
				Painel::alert("sucesso","O pagamento de $data foi quitado com sucesso!");
			}else{
				Painel::alert("erro","Ocorreu algum erro!");
			}
		}



		if(isset($_GET['email'])){
			$parcela_id = (int)$_GET['parcela'];
			$cliente_id = (int)$_GET['email'];

			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE id = $parcela_id");
			$sql->execute();
			$infoFinanceiro = $sql->fetch();

			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.clientes` WHERE id = $cliente_id");
			$sql->execute();
			$infoCliente = $sql->fetch();

			$novaData = date('d/m/Y',strtotime($infoFinanceiro['vencimento']));

			$corpoEmail = "Olá $infoCliente[nome], você está com um saldo pendente de $infoFinanceiro[valor] com o vencimento para $novaData. Entre em contato conosco para quitar sua parcela!";

			$email = new Email('vps.dankicode.com','teste@dankicode.com','123456','Guilherme');
			$email->addAddress($infoCliente['email'],$infoCliente['nome']);

			$email->formatarEmail(array('assunto'=>'Cobrança','corpo'=>$corpoEmail));
			$email->sendEmail();

			/*
				Código de exemplo, não tenho uma classe Email para instanciar.
			*/

			if(isset($_COOKIE['cliente_'.$cliente_id])){
				Painel::alert("erro",'Já foi enviado um e-mail cobrando este cliente por favor aguarde mais um pouco');
			}else{
				Painel::alert("sucesso",'email enviado!');
				setcookie('cliente_'.$cliente_id,true,time()+30,'/');
			}
		}

	?>

	<div class="table-wraper">
		<table>
			<thead class="titulo-tabela">
				<th>Nome do Pagamento</th>
				<th>Cliente</th>
				<th>Valor</th>
				<th>Vencimento</th>
				<th>Enviar E-mail</th>
				<th>Marcar como Pago</th>
			</thead>

			
			<?php

			if($_GET['url'] == 'controle-financeiro'){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 ORDER BY vencimento ASC");
			}
				

			if(isset($_POST['acao_buscar'])){
				$busca = $_POST['busca_pagamentos'];
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE nome LIKE '%$busca%' ORDER BY vencimento ASC");
			}
				$sql->execute();
				$pendentes = $sql->fetchAll();
				foreach($pendentes as $key => $value) {
					$nomeCliente = Mysql::conectar()->prepare("SELECT `nome`,`id` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
					$nomeCliente->execute();
					$info = $nomeCliente->fetch();
					$nomeCliente = $info['nome'];
					$idCliente = $info['id'];
					$style = "";
					$singleStyle = 'style="background-color:#e1dddd;"';
				if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
					$style = 'style="background-color:#bf360c;color:white;font-weight:bold;"';
					$singleStyle = "";
				}
			?>
			<tbody <?php echo $style;?>>		
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $nomeCliente; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
				<td class="tb-editar" <?php echo $singleStyle;?>>
					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   href="<?php echo INCLUDE_PATH_PAINEL?>controle-financeiro?email=<?php echo $idCliente?>&parcela=<?php echo $value['id']?>"
						  <?php }else{ ?> 
						  	actionBtn="negado" href="#"
						  <?php } ?>
						 ><img src="img/enviar-img.png"></a>
				</td>
				<td class="tb-excluir">
					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   href="<?php echo INCLUDE_PATH_PAINEL?>controle-financeiro?id=<?php echo $value['id']?>&pago=<?php echo $value['id']?>"
						  <?php }else{ ?> 
						  	actionBtn="negado" href="#"
						  <?php } ?>
						 >
					<img src='img/editar-depoimento-verde.png'></a>
				</td>
			</tbody>
			<?php }?>	
			

		</table>
	</div><!--table-wraper-->

</div><!--box-content-->

<?php include("listar-concluidos.php")?>