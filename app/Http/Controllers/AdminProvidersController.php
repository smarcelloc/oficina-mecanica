<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class AdminProvidersController extends CBController
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
			$this->table = "providers";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Nome","name"=>"name"];
			$this->col[] = ["label"=>"CNPJ","name"=>"cnpj","callback_php"=>'Callback::cnpj($row->cnpj)'];
			//$this->col[] = ["label"=>"Telefone","name"=>"phone","callback_php"=>'Callback::phone($row->phone)'];
			$this->col[] = ["label"=>"CEP","name"=>"cep","callback_php"=>'Callback::cep($row->cep)'];
			$this->col[] = ["label"=>"Endereço","name"=>"address"];
			//$this->col[] = ["label"=>"Número","name"=>"address_number","callback_php"=>'Callback::number($row->address_number)'];
			//$this->col[] = ["label"=>"Complemento","name"=>"complement"];
			$this->col[] = ["label"=>"Cidade","name"=>"city"];
			$this->col[] = ["label"=>"Estado","name"=>"state","width"=>"80"];
			$this->col[] = ["label"=>"Criado","name"=>"created_at","callback_php"=>'Callback::date($row->created_at)'];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Nome', 'name' => 'name', 'type' => 'text', 'validation' => 'required|names|min:3|max:190', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'CNPJ', 'name' => 'cnpj', 'type' => 'text', 'validation' => 'required|cnpj|unique:providers,cnpj', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Telefone', 'name' => 'phone', 'type' => 'text', 'validation' => 'min:10|max:11', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'CEP', 'name' => 'cep', 'type' => 'text', 'validation' => 'string|size:8', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Endereço', 'name' => 'address', 'type' => 'text', 'validation' => 'string|min:1|max:190', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Nº do Endereço', 'name' => 'address_number', 'type' => 'text', 'validation' => 'string|min:1|max:9', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Complemento', 'name' => 'complement', 'type' => 'text', 'validation' => 'string|min:1|max:80', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Cidade', 'name' => 'city', 'type' => 'text', 'validation' => 'string|min:1|max:190', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Estado', 'name' => 'state', 'type' => 'select', 'validation' => 'alpha|size:2', 'width' => 'col-sm-10', 'dataenum' => 'AC;AL;AP;AM;BA;CE;DF;ES;GO;MA;MT;MS;MG;PA;PB;PR;PE;PI;RJ;RN;RS;RO;RR;SC;SP;SE;TO'];
		$this->form[] = ['label'=>'URL Site','name'=>'url_site','type'=>'text','validation'=>'url|max:190','width'=>'col-sm-10','placeholder'=>'http://'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ['label'=>'Nome','name'=>'name','type'=>'text','validation'=>'required|alpha_spaces|min:3|max:190','width'=>'col-sm-10','placeholder'=>'Você pode digitar somente letras'];
		//$this->form[] = ['label'=>'CNPJ','name'=>'cnpj','type'=>'text','validation'=>'required|cnpj','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Telefone','name'=>'phone','type'=>'number','validation'=>'required|min:10|max:11','width'=>'col-sm-10','placeholder'=>'Você pode digitar somente números'];
		//$this->form[] = ['label'=>'CEP','name'=>'cep','type'=>'text','validation'=>'string|size:8','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Endereço','name'=>'address','type'=>'text','validation'=>'string|min:1|max:190','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Nº do Endereço','name'=>'address_number','type'=>'text','validation'=>'string|min:1|max:9','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Complemento','name'=>'complement','type'=>'text','validation'=>'string|min:1|max:80','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Cidade','name'=>'city','type'=>'text','validation'=>'string|min:1|max:190','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Estado','name'=>'state','type'=>'select','validation'=>'alpha|size:2','width'=>'col-sm-10','dataenum'=>'AC;AL;AP;AM;BA;CE;DF;ES;GO;MA;MT;MS;MG;PA;PB;PR;PE;PI;RJ;RN;RS;RO;RR;SC;SP;SE;TO'];
		# OLD END FORM

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
		$this->script_js = "
			$('input[name=cnpj]').mask('00.000.000/0000-00');
			$('input[name=cep]').mask('00000-000');
			$('input[name=phone]').mask('(00) 0000-00009');
			$('input[name=address_number]').mask('000.000.000', {reverse:true});
			
			
			//Quando o campo cep perde o foco.
			$('input[name=cep]').blur(function () {
				var cep = $(this).val().replace(/\D/g, '');
			
				if (cep != '' && /^[0-9]{8}$/.test(cep)) {
			
					//Consulta o webservice viacep.com.br/
					$.getJSON('https://viacep.com.br/ws/' + cep + '/json/?callback=?', function (dados) {
			
						if (!('erro' in dados)) {
							$('input[name=address]').val(dados.logradouro);
							$('input[name=city]').val(dados.localidade);
							$('input[name=complement]').val(dados.complemento);
							$('select[name=state]').val(dados.uf).trigger('change');
							$('input[name=address_number]').focus();
						}
						else {
							alert('CEP não encontrado...');
						}
					});
				}
			});";


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