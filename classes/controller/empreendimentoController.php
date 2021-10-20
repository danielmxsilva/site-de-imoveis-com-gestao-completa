<?php

	namespace controller;

	class empreendimentoController
	{

		public function index($par){
			\views\mainView::setParam($par);
			\views\mainView::render('empreendimentos.php');
		}

	}


?>