<?php
	include("config.php");
?>

<style type="text/css">
	.box-content{
		width: 900px;
		margin: 0 auto;
		border: 1px solid gray;
	}
	.header{
		background-color: gray;
		color: white;
	}
	tr td,tr th{
		padding: 5px;
		border: 1px solid gray;
	}
	thead th{
		font-size: 18px;
	}
</style>

<div class="box-content">
	<div class="header">
		<?php $nome = (isset($_GET['pagamentos']) && $_GET['pagamentos'] == 'concluidos') ? 'Concluidos' : 'Pendentes';?>
		<h2>Pagamentos <?php echo $nome?></h2>
	</div><!--header-->

	<div class="table-wraper">
		<table style="width:900px;text-align: left;border-collapse: collapse;">
			<tr class="titulo-tabela">
				<th>Nome do Pagamento</th>
				<th>Cliente</th>
				<th>Valor</th>
				<th>Vencimento</th>
			</tr>
			<?php
				if($nome == 'Pendentes')
					$nome = 0;
				else
					$nome = 1;
				$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.financeiro` WHERE status = $nome ORDER BY vencimento ASC");
				$sql->execute();
				$pendentes = $sql->fetchAll();

				foreach ($pendentes as $key => $value) {
				$clienteNome = MySql::conectar()->prepare("SELECT `nome` FROM `tb_admin.clientes` WHERE id = $value[cliente_id]");
				$clienteNome->execute();
				$clienteNome = $clienteNome->fetch()['nome'];
			?>
			<tr>
				<td><?php echo $value['nome']; ?></td>
				<td><?php echo $clienteNome; ?></td>
				<td><?php echo $value['valor']; ?></td>
				<td><?php echo date('d/m/Y',strtotime($value['vencimento'])); ?></td>
			</tr>

			<?php } ?>
			
			

		</table>
	</div><!--table-wraper-->

</div><!--box-content-->