<?php


	include("../../config.php");

	$data['sucesso'] = true;
	$data['mensagem'] = "";

	if(Painel::logado() == false){
		die("Você não está logado!");
	}

	if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'cadastrar_cliente'){
		sleep(1);
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$tipo = $_POST['tipo_cliente'];
		$cpf = '';
		$cnpj = '';
		$imagem = '';

		if($tipo == 'fisico'){
			$cpf = $_POST['cpf'];
		}else if($tipo == 'juridico'){
			$cnpj = $_POST['cnpj'];
		}

		if($nome == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = "Erro: O Nome é obrigatório";
		}

		if($email == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = "Erro: O e-mail é obrigatório";
		}

		if(isset($_FILES['imagem_adicionar'])){
			if(Painel::imagemValida($_FILES['imagem_adicionar'])){
				$imagem = $_FILES['imagem_adicionar'];
			}else{
				$imagem = "";
				$data['sucesso'] = false;
				$data['mensagem'] = "Imagem inválida! Por favor use imagens PNG,JPG ou JPEG";
			}
			
		}

		if($data['sucesso']){
			if(is_array($imagem)){
				$imagem = Painel::uploadFile($imagem);
			}
			$sql = Mysql::conectar()->prepare("INSERT INTO `tb_admin.clientes` VALUES(null,?,?,?,?,?)");
			$dadoFinal = ($cpf == '') ? $cnpj : $cpf;
			$sql->execute(array($nome,$email,$tipo,$dadoFinal,$imagem));
			//Tudo certo, só cadastrar
			$data['mensagem'] = "O cliente foi cadastrado com sucesso!";
		}

	}else if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'editar_cliente'){
		sleep(1);
		$id = $_POST['id'];
		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$tipo = $_POST['tipo_cliente'];
		$cpf = '';
		$cnpj = '';
		$imagem = $_POST['imagem_original'];

		if($tipo == 'fisico'){
			$cpf = $_POST['cpf'];
		}else if($tipo == 'juridico'){
			$cnpj = $_POST['cnpj'];
		}

		if($nome == '' || $email == ''){
			$data['sucesso'] = false;
			$data['mensagem'] = "Campos vázios não são permitidos!";
		}

		if(isset($_FILES['imagem_adicionar'])){
			if(Painel::imagemValida($_FILES['imagem_adicionar'])){
				@unlink('../uploads/'.$imagem);
				$imagem = $_FILES['imagem_adicionar'];
			}else{
				$imagem = "";
				$data['sucesso'] = false;
				$data['mensagem'] = "Imagem inválida! Por favor use imagens PNG,JPG ou JPEG";
			}
			
		}

		if($data['sucesso']){
			if(is_array($imagem)){
				$imagem = Painel::uploadFile($imagem);
			}

			$sql = Mysql::conectar()->prepare("UPDATE `tb_admin.clientes` SET nome = ?,email = ?,tipo = ?, cpf_cnpj =?, foto = ? WHERE id = $id");
			$dadoFinal = ($cpf == '') ? $cnpj : $cpf;
			$sql->execute(array($nome,$email,$tipo,$dadoFinal,$imagem));

			$data['mensagem'] = "O cliente foi atualizado com sucesso!";

		}

	}else if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'deletar_cliente'){
		$id = $_POST['id'];

		$sql = Mysql::conectar()->prepare("SELECT foto FROM `tb_admin.clientes` WHERE id = $id");
		$sql->execute();
		$foto = $sql->fetch()['foto'];
		@unlink('../uploads/'.$foto);
		Mysql::conectar()->exec("DELETE FROM `tb_admin.clientes` WHERE id = $id");
		Mysql::conectar()->exec("DELETE FROM `tb_admin.financeiro` WHERE cliente_id = $id");
	}else if(isset($_POST['tipo_acao']) && $_POST['tipo_acao'] == 'ordenar_empreendimentos'){
		$ids = $_POST['item'];

		$i = 0;
		foreach($ids as $key => $value){
			$sql = Mysql::conectar()->exec("UPDATE `tb_admin.empreendimentos` SET order_id = $i WHERE id = $value");
			$i++;
		}


	}


	die(json_encode($data));

?>