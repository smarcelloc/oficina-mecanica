<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class AdminProductsController extends CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "name";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = true;
		$this->button_export = true;
		$this->table = "products";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label"=>"Categoria","name"=>"category"];
		$this->col[] = ["label" => "Nome", "name" => "name"];
		$this->col[] = ["label" => "Preços R$", "name" => "price", "callback_php" => 'Callback::number($row->price,2)'];
		$this->col[] = ["label"=>"Código de barra","name"=>"barcode"];
		$this->col[] = ["label" => "Fornecedor -  Nome", "name" => "providers_id", "join" => "providers,name"];
		$this->col[] = ["label" => "Fornecedor - CNPJ", "name" => "providers_id", "join" => "providers,cnpj", "callback_php" => 'Callback::cnpj($row->providers_cnpj)'];
		$this->col[] = ["label" => "Criado", "name" => "created_at", "callback_php" => 'Callback::date($row->created_at)'];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Categoria', 'name' => 'category', 'type' => 'select2', 'validation' => 'required|min:1|max:190', 'width' => 'col-sm-10', 'dataenum' => 'Aro do farol;Grade dianteira;Para-barro do para-lama dianteiro;Acabamentos internos;Coifa da alavanca de câmbio;Manopla do câmbio;Quebra-sol;Tampão do porta-malas;Acessórios;Calha de chuva;Capa de carro;Protetor do cárter;Rack do teto transversal;Spoiler dianteiro;Spoiler lateral;Alimentação de combustível;Boia sensor de nivel tanque combustível;Tanque de combustível;Amortecedores;Amortecedor dianteiro;Amortecedor do porta-malas;Amortecedor traseiro;Borrachas de vedação;Borracha da porta;Canaleta;Elétrico;Chave de seta;Interruptor do vidro;Freio;Disco de freio;Pastilha do freio;Frisos;Friso lateral;Ignição;Cabo de vela;Vela de ignição;Iluminação;Farol;Farol de milha;Lanterna dianteira;Lanterna traseira;Latarias;Assoalho;Caixa externa;Capô dianteiro;Painel dianteiro;Para-lama dianteiro;Maçanetas, fechaduras etc;Fechadura da porta;Maçaneta externa da porta;Maçaneta interna da porta;Máquina de vidro;Para-choques;Grade do para-choque;Para-choque dianteiro;Para-choque traseiro;Ponteira do para-choque traseira;Retrovisores;Capa do retrovisor;Lente do retrovisor com base;Lente do retrovisor sem base;Retrovisor externo;Revestimentos;Revestimento de porta;Tapetes;Tapete de borracha;Vidros;Palheta do limpador do para-brisa'];
		$this->form[] = ['label' => 'Nome', 'name' => 'name', 'type' => 'text', 'validation' => 'required|string|min:3|max:190', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Preço R$', 'name' => 'price', 'type' => 'text', 'validation' => 'numeric|max:9999', 'width' => 'col-sm-10'];
		$this->form[] = ['label'=>'Código de Barra','name'=>'barcode','type'=>'text','validation'=>'min:1|max:20|unique:products,barcode','width'=>'col-sm-10'];
		$this->form[] = ['label'=>'Foto','name'=>'photo','type'=>'upload','validation'=>'image|max:3000','width'=>'col-sm-10','help'=>'Tipos de arquivo suportado: JPG, JPEG, PNG, GIF, BMP', 'resize_width'=>120,'resize_height'=>120];
		$this->form[] = ['label' => 'Fornecedor', 'name' => 'providers_id', 'type' => 'select2', 'validation' => 'exists:providers,id', 'width' => 'col-sm-10', 'datatable' => 'providers,name', 'datatable_format' => 'name,\'-\',cnpj', 'datatable_ajax' => 'true'];
		$this->form[] = ['label' => 'Descrição', 'name' => 'description', 'type' => 'wysiwyg', 'validation' => 'string|min:5|max:12000', 'width' => 'col-sm-10'];
		# END FORM DO NOT REMOVE THIS LINE

		/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
		$this->sub_module = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
		$this->addaction = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
		$this->button_selected = array();


		/* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
		$this->alert        = array();



		/* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
		$this->index_button = array();



		/* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
		$this->table_row_color = array();


		/*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
		$this->index_statistic = array();



		/*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
		$this->script_js = '
				var price = $("input[name=price]");
				var decimal = parseFloat(price.val()).toFixed(2);
				price.val(decimal);
				price.mask("9990.00", {reverse:true});
			';


		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
		$this->pre_index_html = null;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
		$this->post_index_html = null;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
		$this->load_js = array();



		/*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
		$this->style_css = NULL;



		/*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
		$this->load_css = array();
	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	public function actionButtonSelected($id_selected, $button_name)
	{
		//Your code here

	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	public function hook_query_index(&$query)
	{
		//Your code here

	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */
	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	public function hook_before_add(&$postdata)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	public function hook_after_add($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	public function hook_before_edit(&$postdata, $id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_edit($id)
	{
		//Your code here 

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_before_delete($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_delete($id)
	{
		//Your code here

	}



	//By the way, you can still create your own method in here... :) 


}
