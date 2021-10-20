<?php

	class Painel
	{

		public static function loadJs($files,$page){
			$url = explode('/',@$_GET['url'])[0];
			if($page == $url){
				foreach($files as $key => $value) {
					echo '<script src="'.INCLUDE_PATH_PAINEL.'js/'.$value.'"></script>';
				}
			}
		}

		public static function logado(){
			return isset($_SESSION['login']) ? true : false;
		}

		public static function loggout(){
			session_destroy();
			setcookie('lembrar',true,time() - 1,'/');
			header('Location: '.INCLUDE_PATH_PAINEL);
		}

		public static $cargos = [
			'0' => 'Visitante',
			'1' => 'SubAdministrador',
			'2' => 'Administrador'
		];

		public static function generateSlug($str){
			$str = mb_strtolower($str);
			$str = preg_replace('/(â|á|ã)/', 'a', $str);
			$str = preg_replace('/(ê|é)/', 'e', $str);
			$str = preg_replace('/(í|Í|Ì|ì)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó|ô|õ)/', 'o', $str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
			$str = preg_replace('/( )/', '-', $str);
			$str = preg_replace('/(ç)/', 'c', $str);
			$str = preg_replace('/(-[-]{1,})/', '-', $str);
			$str = preg_replace('/(,)/', '-', $str);
			$str = preg_replace('/(\"|\'|\`|)/', '', $str);
			$str = strtolower($str);
			return $str;
		}

		public static function degenerateSlug($str){
			$str = preg_replace('/-/', ' ', $str);
			$str = ucfirst($str);
			return $str;
		}

		public static function carregarPagina(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}else{
					header('Location: '.INCLUDE_PATH_PAINEL);
					die();
				}
			}else{
				include('pages/home.php');
			}
		}

		public static function listarUsuariosOnline(){
			self::limparUsuariosOnline();
			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function limparUsuariosOnline(){
			$date = date('Y-m-d H:i:s');
			$sql = Mysql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$date' - INTERVAL 1 MINUTE");
		}

		public static function alert($tipo,$mensagem){
			if($tipo == 'sucesso'){
				echo '<div class="sucesso-box">'.$mensagem.'</div>';
			}else if($tipo == 'erro'){
				echo '<div class="erro-box">'.$mensagem.'</div>';
			}else if($tipo == 'atencao'){
				echo '<div class="atencao-box">'.$mensagem.'</div>';
			}
		}

		public static function imagemValida($imagem){
			if($imagem['type'] == 'image/png' || 
				$imagem['type'] == 'image/jpg' ||
			    $imagem['type'] == 'image/jpeg'){
				$tamanho = intval($imagem['size']/1024);
			    if($tamanho < 7000){
			    	return true;
			    }else{
			    	return false;
			    }
			}else{
				return false;
			}
		}

		public static function deleteFile($file){
			@unlink('uploads/'.$file);
		}

		public static function uploadFile($file){
			$formatoArquivo = explode('.',$file['name']);
			$imagemNome = uniqid().'.'.$formatoArquivo[count($formatoArquivo) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploads/'.$imagemNome)){
				return $imagemNome;
			}else{
				return false;
			}
		}

		public static function userExists($user){
			$sql = Mysql::conectar()->prepare("SELECT * FROM `tb_admin.usuario` WHERE user = ?");
			$sql->execute(array($user));
			if($sql->rowCount()){
				return true;
			}else{
				return false;
			}
		}

		public static function redirect($url){
			echo '<script>location.href="'.$url.'"</script>';
			die();
		}

		public static function selectAll($tabela,$start = null,$end = null){
			if($start == null && $end == null){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
			}else{
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
			}
			$sql->execute();
			return $sql->fetchAll();
		}

		public static function select($tabela,$query = '',$arr = ''){
			if($query != false){
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = Mysql::conectar()->prepare("SELECT * FROM `$tabela`");
				$sql->execute();
			}
			return $sql->fetch();
		}

		public static function insert($arr){
			$certo = true;
			$nome_tabela = $arr['nome_tabela'];
			$query = "INSERT INTO `$nome_tabela` VALUES(null";
			foreach($arr as $key => $value){
				$nome = $key;
				$valor = $value;
				if($nome == 'acao_adicionar' || $nome == 'nome_tabela')
					continue;
				if($value == ' '){
					$certo = false;
					break;
				}
				$query.=",?";
				$parametros[] = $value;
			}

			$query.=");";

			if($certo == true){
				$sql = Mysql::conectar()->prepare($query);
				$sql->execute($parametros);
				$lastId = Mysql::conectar()->lastInsertId();
				$sql = Mysql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $lastId");
				$sql->execute(array($lastId));
			}
			return $certo;
		}

		public static function update($arr,$single = false){
			$certo = true;
			$first = false;
			$nome_tabela = $arr['nome_tabela'];
			$query = "UPDATE `$nome_tabela` SET ";
			foreach($arr as $key => $value){
				$nome = $key;
				$valor = $value;
				if($nome == 'acao_editar' || $nome == 'nome_tabela' || $nome == 'id')
					continue;
				if($value == ' '){
					$certo = false;
					break;
				}
				if($first == false){
					$first = true;
					$query.="$nome=?";
				}else{
					$query.=",$nome=?";
				}
				$parametros[] = $value;
			}

			//$query.=" WHERE id = ? ";

			if($certo == true){
				if($single == false){
					$parametros[] = $arr['id'];
					$sql = Mysql::conectar()->prepare($query.' WHERE id=?');
					$sql->execute($parametros);
				}else{
					$sql = Mysql::conectar()->prepare($query);
					$sql->execute($parametros);
				}
			}
			return $certo;
		}

		public static function deletar($tabela,$id = false){
			if($id == false){
				$sql = Mysql::conectar()->prepare("DELETE FROM `$tabela`");
			}else{
				$sql = Mysql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
			}
			$sql->execute();
		}

		public static function orderItem($tabela,$orderType,$idItem){
			if($orderType == 'up'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $order_id ORDER BY order_id DESC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}else if($orderType == 'down'){
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$order_id = $infoItemAtual['order_id'];
				$itemBefore = Mysql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $order_id ORDER BY order_id ASC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0)
					return;
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}
		}

		public static function updateConfig($arr){
			$certo = true;
			$first = false;
			$nome_tabela = $arr['nome_tabela'];
			$query = "UPDATE `$nome_tabela` SET ";
			foreach($arr as $key => $value){
				$nome = $key;
				$valor = $value;
				if($nome == 'acao_editar' || $nome == 'nome_tabela' || $nome == 'id' || $nome == 'imagem_autor_atual' || $nome == 'imagem_especial_atual1' || $nome == 'imagem_especial_atual2' || $nome == 'imagem_especial_atual3')
					continue;
				if($value == ' '){
					$certo = false;
					break;
				}
				if($first == false){
					$first = true;
					$query.="$nome=?";
				}else{
					$query.=",$nome=?";
				}
				$parametros[] = $value;
			}

			//$query.=" WHERE id = ? ";

			if($certo == true){
				$sql = Mysql::conectar()->prepare($query);
				$sql->execute($parametros);
			}
			return $certo;
		}

	}

?>