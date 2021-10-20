$(document).ready(function(){


	cliqueMenu();
	cliqueSubmenu();

	var windowSize = $(window)[0].innerWidth;

	function cliqueMenu(){
		$('.icone-menu').click(function(){
			if($('aside').is(':visible')){
				$('aside').hide();
				$('.content').css('margin-left','0');
			}else{
				$('aside').show();
				$('.content').css('margin-left','200px');
			}
		})
	}

	if(windowSize <= 800){
		$('aside').hide();
		$('.content').css('margin-left','0');
	}

	function cliqueSubmenu(){
		$('.perfil').click(function(e){
			e.stopPropagation();
			if($('.sub-menu-perfil').is(':visible')){
				$('.sub-menu-perfil').slideUp();
			}else{
				$('.sub-menu-perfil').slideDown();
				$('.submenu-msg').slideUp();
				$('.submenu-notif').slideUp();
			}
		})
		$('.msg').click(function(e){
			e.stopPropagation();
			$(this).find('.alerta-notificacao').hide();
			if($('.submenu-msg').is(':visible')){
				$('.submenu-msg').slideUp();
			}else{
				$('.submenu-msg').slideDown();
				$('.sub-menu-perfil').slideUp();
				$('.submenu-notif').slideUp();
			}
		})
		$('.notificacao').click(function(e){
			e.stopPropagation();
			$(this).find('.alerta-notificacao').hide();
			if($('.submenu-notif').is(':visible')){
				$('.submenu-notif').slideUp();
			}else{
				$('.submenu-notif').slideDown();
				$('.submenu-msg').slideUp();
				$('.sub-menu-perfil').slideUp();
			}
		})

		$('body').click(function(e){
			e.stopPropagation();
			$('.sub-menu-perfil').slideUp();
			$('.submenu-msg').slideUp();
			$('.submenu-notif').slideUp();
		})
	}

	$('[actionBtn=delete]').click(function(){
		var txt;
		var r = confirm("Deseja deletar?");
		if(r == true){
			return true;
		}else{
			return false;
		}
	});

	$('[actionBtn=negado]').click(function(){
		var txt;
		var r = confirm("Você não tem permissão pra executar está ação!");
		if(r == true){
			return true;
		}else{
			return false;
		}
	});

	

})