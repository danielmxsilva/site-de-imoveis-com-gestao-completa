
<div class="box-content">
	<img src="<?php echo INCLUDE_PATH_PAINEL;?>img/lapis.png">
	<h2>Adicionar Serviços</h2>
	<?php
		if(isset($_POST['acao_adicionar'])){
			//$_POST['date'] = date('d/m/Y',strtotime(date('Y-m-d')));
			if(Painel::insert($_POST)){
				Painel::alert('sucesso','Serviço Adicionado Com Sucesso!');
				Painel::redirect(INCLUDE_PATH_PAINEL.'gerenciar-servico');
			}else{
				Painel::alert('erro','Campos Vazios Não São Permitidos!');
			}
		}
	?>
	<div class="form-editar cadastro-depoimentos">
		<form method="POST" enctype="multipart/form-data">
			<div class="group-depoimento group-textarea">
				<span style="vertical-align: top;">Serviço:</span>
				<textarea name="serviço" required></textarea>
			</div><!--from-group-->
			<div class="group-depoimento">
				<input type="hidden" name="order_id" value="0">
				<input type="hidden" name="nome_tabela" value="tb_site.servico">
				<input <?php permissaoInput(1,'acao_adicionar','Adicionar')?>>
			
			</div><!--from-group-->
		</form>
	</div><!--form-editar-->

</div><!--box-content-->
<script src="<?php echo INCLUDE_PATH?>js/jquery.js"></script>
<script>
	$(function(){
		$('input[name=date]').mask('99/99/9999');
	})
</script>