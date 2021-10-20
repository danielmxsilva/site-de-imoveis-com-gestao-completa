
<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/listar.png">
	<h2>Pagamentos Concluidos</h2>

	<div class="busca">
		<h2>Realizar uma busca</h2>
		<form method="post">
			<input type="text" name="busca" placeholder="nome do pagamento ou valor">
			<input type="submit" name="acao_buscar_todos" value="Buscar">
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
			</thead>

			
			<?php
			@$urlId = (int)$_GET['id'];
			if(isset($urlId)){
				$sqlListar = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE cliente_id = $urlId AND status = 1 ORDER BY vencimento ASC");
			}

			if($_GET['url'] == 'controle-financeiro'){
				$sqlListar = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = 1 ORDER BY vencimento ASC");
			}
			if(isset($_POST['acao_buscar_todos'])){
				$busca = $_POST['busca'];
				$sqlListar = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE nome LIKE '%$busca%' OR valor LIKE '%$busca%' ORDER BY vencimento ASC");
			}
				$sqlListar->execute();
				$pendentes = $sqlListar->fetchAll();
				foreach($pendentes as $key => $value) {
					$nomeCliente = Mysql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
					$nomeCliente->execute();
					$nomeCliente = $nomeCliente->fetch()['nome'];
			?>
			<tbody>		
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $nomeCliente; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
			</tbody>
			<?php }?>	
			

		</table>
	</div><!--table-wraper-->
</div><!--box-content-->
