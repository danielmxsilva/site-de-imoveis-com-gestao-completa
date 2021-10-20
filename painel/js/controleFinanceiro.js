$(document).ready(function(){
	$('[name=parcelas],[name=intervalo]').mask('99');
	$('[name=valor]').maskMoney({
         prefix: "R$:",
         decimal: ",",
         thousands: "."
     });

    //$.datepicker.setDefaults($.datepicker.regional['pt-BR']);

	$('[name=vencimento]').Zebra_DatePicker({
		locale: 'pt-br'
	});

})
