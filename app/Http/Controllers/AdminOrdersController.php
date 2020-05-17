<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;

class AdminOrdersController extends CBController
{

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
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
		$this->table = "orders";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Cliente - Nome", "name" => "clients_id", "join" => "clients,name"];
		$this->col[] = ["label" => "Cliente - CPF", "name" => "clients_id", "join" => "clients,cpf", "callback_php" => 'Callback::cpf($row->clients_cpf)'];
		$this->col[] = ["label" => "Tipo de Pagamento", "name" => "payment"];
		$this->col[] = ["label" => "Situação", "name" => "situation"];
		$this->col[] = ["label" => "Total R$", "name" => "total", "callback_php" => 'Callback::number($row->total,2)'];
		$this->col[] = ["label" => "Serviço", "name" => "services_id", "join" => "services,name"];
		$this->col[] = ["label" => "Criado", "name" => "created_at", "callback_php" => 'Callback::date($row->created_at)'];
		$this->col[] = ["label" => "Alterado", "name" => "updated_at", "callback_php" => 'Callback::date($row->created_at)'];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Serviço', 'name' => 'services_id', 'type' => 'select', 'validation' => 'exists:services,id', 'width' => 'col-sm-10', 'datatable' => 'services,name', 'datatable_format' => 'id,\' - \', name'];
		$this->form[] = ['label' => 'Preço do serviço R$', 'name' => 'price_services', 'type' => 'text', 'validation' => 'numeric|min:0.01|max:999999', 'width' => 'col-sm-10', 'disabled' => true];
		$this->form[] = ['label' => 'Cliente', 'name' => 'clients_id', 'type' => 'select2', 'validation' => 'required|exists:clients,id', 'width' => 'col-sm-10', 'datatable' => 'clients,name', 'datatable_format' => 'name,\' - \',cpf', 'datatable_ajax' => 'true'];




		$columns = [];
		$columns[] = ['label' => 'Produtos', 'name' => 'products_id', 'type' => 'datamodal', 'datamodal_table' => 'products', 'datamodal_columns' => 'name,category,price,barcode', 'datamodal_select_to' => 'price:price', 'datamodal_columns_alias' => 'Nome, Categoria, Preço R$, Cód. de Barra', 'datamodal_where' => '', 'datamodal_size' => 'large', 'required' => true];
		$columns[] = ['label' => 'Preço R$', 'name' => 'price', 'type' => 'text', 'readonly' => true, 'disabled' => true];
		$columns[] = ['label' => 'Quantidade', 'name' => 'amount', 'type' => 'text', 'required' => true];
		$columns[] = [
			'label' => 'Sub Total R$', 'name' => 'subtotal', 'type' => 'number',
			'formula' => "[amount] * [price]", "readonly" => true, 'disabled' => true
		];

		$this->form[] = ['label' => 'Produtos', 'name' => 'orders_details', 'type' => 'child', 'columns' => $columns, 'table' => 'orders_details', 'foreign_key' => 'orders_id'];

		$this->form[] = ['label' => 'Total dos Itens R$', 'name' => 'total_items', 'type' => 'text', 'validation' => 'numeric|max:999999', 'width' => 'col-sm-10', 'readonly' => true];

		$this->form[] = ['label' => 'Total R$', 'name' => 'total', 'type' => 'text', 'validation' => 'numeric|min:0.01|max:999999', 'width' => 'col-sm-10', 'readonly' => true];


		$this->form[] = ['label' => 'Tipo de Pagamento', 'name' => 'payment', 'type' => 'radio', 'validation' => 'required|string|max:45', 'width' => 'col-sm-10', 'dataenum' => 'Cartão de Crédito;Boleto Bancário;Débito Automático;Dinheiro;Cheques'];
		$this->form[] = ['label' => 'Situação', 'name' => 'situation', 'type' => 'radio', 'validation' => 'required|string|max:45', 'width' => 'col-sm-10', 'dataenum' => 'Concretizado;Aberto;Cancelado'];
		$this->form[] = ['label' => 'Observação', 'name' => 'observation',			'type' => 'textarea', 'validation' => 'string|min:5|max:8000', 'width' => 'col-sm-10'];



		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ['label'=>'Serviço','name'=>'services_id','type'=>'select2','validation'=>'exists:services,id','width'=>'col-sm-10','datatable'=>'services,id','datatable_format'=>'id,\' - \', name'];
		//$this->form[] = ['label'=>'Cliente','name'=>'clients_id','type'=>'select2','validation'=>'required|exists:clients,id','width'=>'col-sm-10','datatable'=>'clients,id','datatable_format'=>'name,\' - \',cpf','datatable_ajax'=>'true'];
		//$this->form[] = ['label'=>'Tipo de Pagamento','name'=>'payment','type'=>'radio','validation'=>'required|string|max:45','width'=>'col-sm-10','dataenum'=>'Cartão de Crédito;Boleto Bancário;Débito Automático;Pagamentos Digitais;Dinheiro;Cheques'];
		//$this->form[] = ['label'=>'Situação','name'=>'situation','type'=>'radio','validation'=>'required|string|max:45','width'=>'col-sm-10'];
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
		$this->table_row_color = array(
			['condition'=>"[situation] == 'Concretizado'", "color" => "success"],
			['condition'=>"[situation] == 'Cancelado'", "color" => "danger"]
		);


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
$("#services_id").click(function(){
	if($(this).val() == "")
		$("#price_services").attr("disabled","disabled");
	else
		$("#price_services").removeAttr("disabled").focus();
});



setInterval(function(){
	var total = 0;
	var servico = parseFloat($("#price_services").val());

	if(isNaN(servico))
		servico = 0;

	$("#table-produtos  tbody .subtotal").each(function(){
		var subtotais = parseFloat($(this).text());
		total += subtotais;
	});

	$("#total_items").val(total);
	$("#total").val(total + servico);


}, 500);

$("#produtosamount").mask("9999");

				var price = $("input[name=price_services]");
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
