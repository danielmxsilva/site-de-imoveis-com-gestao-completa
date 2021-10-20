$(function(){
	$('[name=cpf]').mask('999.999.999-99');
	$('[name=cnpj]').mask('99.99.999/9999-9');

	$('[name=tipo_cliente]').change(function(){
		var val = $(this).val();
		if(val == 'fisico'){
			$('.cpf-input').show();
			$('.cnpj-input').hide();
		}else{
			$('.cpf-input').hide();
			$('.cnpj-input').show();
		}
	})

})