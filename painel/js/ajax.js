$(function(){
	$('.ajax').ajaxForm({
		dataType: 'json',
		beforeSend:function(){
			$('.ajax').animate({'opacity':'0.5'});
			$('.ajax').find('input[type=submit]').attr('disabled','true');
		},
		success: function(data){
			$('.ajax').animate({'opacity':'1'});
			$('.ajax').find('input[type=submit]').removeAttr('disabled');
			$('.box-alert').remove();
			if(data.sucesso){
				$('.ajax').prepend('<div class="box-alert sucesso-box">'+data.mensagem+'</div>');
				if($('.ajax').attr('atualizar') == undefined)
					$('.ajax')[0].reset();
			}else{
				$('.ajax').prepend('<div class="box-alert erro-box"><b>'+data.mensagem+'</div>');
			}
			console.log(data);
		}
	})

	$('.delete-cliente').click(function(e){
		e.preventDefault();
		var item_id = $(this).attr('item_id');
		var el = $(this).parent().parent().parent();
		$.ajax({
			url:include_path+'/ajax/forms.php',
			data:{id:item_id,tipo_acao:'deletar_cliente'},
			method:'post'
		}).done(function(){
			el.fadeOut();
		})

	})
	
}) 