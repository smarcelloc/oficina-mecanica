<?php 

namespace App\Http\Controllers;


use CRUDBooster;
use DB;
use Request;
use Session;
use Validator;


class AdminCmsUsersController extends CBController {


	public function cbInit() {
		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "name";
		$this->limit = "20";
		$this->table               = 'cms_users';
		$this->primary_key         = 'id';
		$this->title_field         = "name";
		$this->button_action_style = 'button_icon';	
		$this->button_import 	   = true;	
		$this->button_export 	   = true;	
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_bulk_action = true;
		$this->button_detail = true;
		# END CONFIGURATION DO NOT REMOVE THIS LINE
	
		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = array();
		$this->col[] = array("label"=>"Nome","name"=>"name");
		$this->col[] = array("label"=>"E-mail","name"=>"email");
		$this->col[] = ["label" => "CPF", "name" => "cpf", "callback_php" => 'Callback::cpf($row->cpf)'];
		//$this->col[] = ["label"=>"Telefone","name"=>"phone","callback_php"=>'Callback::phone($row->phone)'];
		$this->col[] = ["label" => "CEP", "name" => "cep", "callback_php" => 'Callback::cep($row->cep)'];
		$this->col[] = ["label" => "Endereço", "name" => "address"];
		//$this->col[] = ["label"=>"Número","name"=>"address_number","callback_php"=>'Callback::number($row->address_number)'];
		//$this->col[] = ["label"=>"Complemento","name"=>"complement"];
		$this->col[] = ["label" => "Cidade", "name" => "city"];
		$this->col[] = ["label" => "Estado", "name" => "state", "width" => "80"];
		$this->col[] = array("label"=>"Privilégio","name"=>"id_cms_privileges","join"=>"cms_privileges,name");
		$this->col[] = array("label"=>"Foto","name"=>"photo","image"=>1);
		$this->col[] = ["label"=>"Criado","name"=>"created_at","callback_php"=>'Callback::date($row->created_at)'];	
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = array(); 		
		$this->form[] = array("label"=>"Nome","name"=>"name",'required'=>true,'validation'=>'required|names|min:3|max:190');
		$this->form[] = array("label"=>"E-mail","name"=>"email",'type'=>'email','validation'=>'required|email|max:190|unique:cms_users,email,'.CRUDBooster::getCurrentId());
		$this->form[] = ['label' => 'CPF', 'name' => 'cpf', 'type' => 'text', 'validation' => 'cpf|unique:cms_users,cpf', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Telefone', 'name' => 'phone', 'type' => 'text', 'validation' => 'min:10|max:11', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'CEP', 'name' => 'cep', 'type' => 'text', 'validation' => 'string|size:8', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Endereço', 'name' => 'address', 'type' => 'text', 'validation' => 'string|min:1|max:190', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Nº de Endereço', 'name' => 'address_number', 'type' => 'text', 'validation' => 'string|min:1|max:9', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Complemento', 'name' => 'complement', 'type' => 'text', 'validation' => 'string|min:1|max:80', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Cidade', 'name' => 'city', 'type' => 'text', 'validation' => 'string|min:1|max:190', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Estado', 'name' => 'state', 'type' => 'select', 'validation' => 'alpha|size:2', 'width' => 'col-sm-10', 'dataenum' => 'AC;AL;AP;AM;BA;CE;DF;ES;GO;MA;MT;MS;MG;PA;PB;PR;PE;PI;RJ;RN;RS;RO;RR;SC;SP;SE;TO'];		
		$this->form[] = array("label"=>"Foto","name"=>"photo","type"=>"upload","help"=>"Resolução recomendável é 200x200px",'validation'=>'image|max:1000','resize_width'=>90,'resize_height'=>90);				
		$this->form[] = array("label"=>"Privilégio","name"=>"id_cms_privileges","type"=>"select","datatable"=>"cms_privileges,name", 'validation'=>'required|exists:cms_privileges,id');				
		$this->form[] = array("label"=>"Senha","name"=>"password","type"=>"password", "validation" => "password|min:8|max:20","help"=>"Por favor, deixe em branco se não mudar.");
		# END FORM DO NOT REMOVE THIS LINE

		$this->script_js = "
$('input[name=cpf]').mask('000.000.000-00');
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
});

			";
				
	}

	public function getProfile() {			

		$this->button_addmore = FALSE;
		$this->button_cancel  = FALSE;
		$this->button_show    = FALSE;			
		$this->button_add     = FALSE;
		$this->button_delete  = FALSE;	
		$this->hide_form 	  = ['id_cms_privileges'];

		$data['page_title'] = trans("crudbooster.label_button_profile");
		$data['row']        = CRUDBooster::first('cms_users',CRUDBooster::myId());		
		$this->cbView('crudbooster::default.form',$data);	
					
	}
	public function hook_before_edit(&$postdata,$id) { 
		unset($postdata['password_confirmation']);
	}
	public function hook_before_add(&$postdata) {      
	    unset($postdata['password_confirmation']);
	}
	
	
}
