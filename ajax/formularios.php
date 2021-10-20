<?php
	include('../config.php');
	$data = array();
	$assunto = 'Nova mensagem do site!';
	$corpo = '';
	foreach ($_POST as $key => $value) {
		$corpo.=ucfirst($key).": ".$value;
		$corpo.="<hr>";
	}
	$info = array('assunto'=>$assunto,'corpo'=>$corpo);
	$mail = new \Email('mail.matheussfontes.com','matheussfontes@matheussfontes.com','matheus1234','Site DamixCode');
	$mail->enviarPara('matheussfontes@matheussfontes.com','contato');
	$mail->formatarEmail($info);
	if($mail->enviarEmail()){
		$data['sucesso'] = true;
		echo '<script>alert("sucesso")</script>';
	}else{
		$data['erro'] = true;
		echo '<script>alert("erro")</script>';
	}

	//$data['retorno'] = 'sucesso';

	die(json_encode($data));
?>