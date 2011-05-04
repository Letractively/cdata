<?php
/*
 * Created on 20-8-2007
 *
 */


class Permission extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "permission";	
	var $permission_object = "app";
		
	
	
	function Permission()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		
		// data model
		$this->data_model = array(
		'fields' => array(
    		"name" => array(
    			"type" => "text"
    			)
    		),
    	'table' => array(
    		'name' => 'security_permission',
    		'id' => 'permission_id')
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Permission",    		
    			)
    		),
    	"view" => array(
    	)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
    		"name" => array(
    			"type" => "text",
    			"label" => "Permission",
    			"lenght" => "50",
    			"required" => "true"
    			)    		    		
    		),
    	"form" => array(
    		"name" => "permission",
    		"method" => "post",
    		"action" => "",
    		"delete" => array(
				"link" => site_url("permission/delete/permission_id"),
				"id" => "permission_id"
			)
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
		);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Permission",
    			"lenght" => "30em",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array(
    			"add" => array(
    				"link" => "permission/create"
    			),
    			"edit" => array(
    				"link" => site_url("permission/edit/permission_id")
    			),
    			"view" => array(
    				"link" => site_url("permission/view/permission_id")
    			),
    			"id" => "permission_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "20",
    			"default_sort" => "ORDER BY name ASC"
    		),
    		"table" => "security_permission",
    		"base_url" => site_url("permission/xgrid")
    	)
		);
		
		// create Form class models
		$this->form->list_model = $this->list_model;
		$this->form->search_model = $this->search_model;
		$this->form->data_model = $this->data_model;
		$this->form->form_model = $this->form_model;
		$this->form->view_model = $this->view_model;
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$data['search'] = "";
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function create(){
        
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if ($this->form->create()){
			redirect($this->object."/xgrid");
		}
		
		$this->layout->main = $this->load->view($this->object."/create",$data,true);		
		$this->layout->render_page();
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if ($this->form->edit($id)){
			redirect($this->object."/xgrid");
		}
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);		
		$this->layout->render_page();
	}
	
	
	function setting(){		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$p = "";
		$head = "";
		
		//roles
		$qr = "SELECT * FROM security_role WHERE role_id <> 1";
		$rs = mysql_query($qr);
		// applications
		$csel = array();
		$new = "";
		
		if (isset($_POST["submit"])){
			foreach($_POST as $key => $value){
				$new .= $key."<>";	
			} 
			$up = "UPDATE security_permission_value SET value = '$new' WHERE permission_id = 1";
			mysql_query($up);
			$head = "<h3>Permissions Saved</h3>";
			foreach($_POST as $key => $value){
				$csel[$key] = "checked=\"true\"";	
			} 	
		}else{
			//load data
			$qp = "SELECT value FROM security_permission_value WHERE permission_id =1";
			$pm = mysql_fetch_object(mysql_query($qp));
			$res = explode("<>", $pm->value);
			foreach($res as $key => $value){
				if($value > ""){
				$csel[$value] =  "checked=\"true\"";	
				}
			}			
		}
		
		$p .= $head;
		$p .= "<form action=\"\" method=\"post\">";
		
		$qo = "SELECT * FROM security_object";
		$qos = mysql_query($qo);
		while ($o = mysql_fetch_object($qos)){
			$p .= "<h2>".$o->name."</h2>";						
			
			$p .= "<table>";
			//header
			$p .= "<tr><th width=\"100px\" style=\"text-align: center\">Action</th>";
			mysql_data_seek($rs, 0);
			while($r = mysql_fetch_assoc($rs)){
				$p .= "<th style=\"text-align: center; padding: 5px;\">".$r["name"]."</th>";	
			}
			$p .= "<th style=\"text-align: center; padding: 5px;\">not registered</th>";
			$p .= "</tr>";
			
			$qa = "SELECT * FROM security_object_action WHERE security_object_id = ".$o->security_object_id;
			$as = mysql_query($qa);
			while ($a = mysql_fetch_object($as)) {
				$p .= "<tr><td>".$a->action_name."</td>";
				mysql_data_seek($rs, 0);
				while($r = mysql_fetch_assoc($rs)){
					$id = $o->class_id."_".$a->action_id."_".$r["role_id"];
					$p .= "<td style=\"text-align: center;\">
					<input type=\"checkbox\" ".element($id, $csel)." name=\"$id\" />
					</td>";	
				}
				$id = $o->class_id."_".$a->action_id."_0";
				$p .= "<td style=\"text-align: center;\">
					<input type=\"checkbox\" ".element($id, $csel)." name=\"$id\" />
					</td>";
				$p .= "</tr>";
			}
			$p .= "</table>";
		}
		$p .= "<br/><input type=\"submit\" name=\"submit\" value=\"Submit form\" />";
		$p .= "</form>";
		
		
		
		$this->layout->main = $p;		
		$this->layout->render_page();
	}

	
	function view($id){
        
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->read_data($id);
		$data["id"] = $id;
		$this->layout->main = $this->load->view($this->object."/view",$data,true);		
		$this->layout->render_page();
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->delete_data($id);
		redirect($this->object."/xgrid");
	}
	
}


?>