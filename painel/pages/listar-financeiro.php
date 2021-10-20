
<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
	<h2>Pagamentos Pendentes</h2>

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
	?>

	<div class="busca">
		<h2>Realizar uma busca</h2>
		<form method="post">
			<input type="text" name="busca" placeholder="nome do pagamento ou valor">
			<input type="submit" name="acao_buscar" value="Buscar">
		</form>
	</div><!--busca-->

	<div class="gerar-pdf">
		<a target="_blank" href="<?php echo INCLUDE_PATH?>gerar-pdf.php?pagamentos=concluidos">Gerar PDF</a>
	</div><!--gerar-pdf-->

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
			@$urlId = (int)$_GET['id'];
			if(isset($urlId)){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE cliente_id = $urlId AND status = 0 ORDER BY vencimento ASC");
			}

			if($_GET['url'] == 'controle-financeiro'){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 ORDER BY vencimento ASC");
			}

			/*
			if(isset($_POST['acao_buscar'])){
				$busca = $_POST['busca'];
				$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 0 AND nome LIKE '%$busca%' OR valor LIKE '%$busca%'");
			}*/
				$sql->execute();
				$pendentes = $sql->fetchAll();
				foreach($pendentes as $key => $value) {
					$nomeCliente = Mysql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
					$nomeCliente->execute();
					$nomeCliente = $nomeCliente->fetch()['nome'];
					$style = "";
				if(strtotime(date('Y-m-d')) >= strtotime($value['vencimento'])){
					$style = 'style="background-color:#bf360c;color:white;font-weight:bold;"';
				}
			?>
			<tbody <?php echo $style;?>>		
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $nomeCliente; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
				<td class="tb-editar">
					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   href=""
						  <?php }else{ ?> 
						  	actionBtn="negado" href="#"
						  <?php } ?>
						 ><img src="img/editar-depoimento-verde.png"></a>
				</td>
				<td class="tb-excluir">
					<a <?php
							if($_SESSION['cargo'] >= 1){
						  ?>
						   href="<?php echo INCLUDE_PATH_PAINEL?>editar-clientes?id=<?php echo $id?>&pago=<?php echo $value['id']?>"
						  <?php }else{ ?> 
						  	actionBtn="negado" href="#"
						  <?php } ?>
						 >
					<img src='img/excluir-depoimento-red.png'></a>
				</td>
			</tbody>
			<?php }?>	
			

		</table>
	</div><!--table-wraper-->
</div><!--box-content-->
