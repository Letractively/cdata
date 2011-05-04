<?php
/*
 * Created on 20-8-2007
 *
 */


class User extends Controller {
	
	
	// user object model vars
	var $user_search_model = array();
	var $user_data_model = array();	
	var $user_form_model = array();		
	var $user_view_model = array();
	var $user_list_model = array();
		
	var $permission_object = "app";	
	
	
	function User()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		
		// view model
		$this->user_view_model = array(
		"fields" => array(
    		"user_name" => array(
    			"type" => "text",
    			"label" => "Username",    		
    			),    	
    		"name" => array(
    			"type" => "text",
    			"label" => "Firstname",    			
    			),
    		"lastname" => array(
    			"type" => "text",
    			"label" => "Lastname",    		
    			),    		
    		"email" => array(
    			"type" => "text",
    			"label" => "Email",    			
    			),
    		"centre" => array(
    			"type" => "select",
    			"label" => "Centre",    			
    			),
    		"usergroup" => array(
    			"type" => "select",
    			"label" => "Group"   			
    			),
    		"profile" => array(
    			"type" => "html",
    			"label" => "Profile",    		
    			),
    		"role_id" => array(
    			"type" => "select",
    			"label" => "Role"   			
    			),
    		"active" => array(
    			"type" => "select",
    			"label" => "Active",    			
    			),
    		"lastlogin" => array(
    			"type" => "datetime",
    			"label" => "Last Login",    			
    			)
    		),
    	"view" => array(
    	)
		);
		
		// form model
        $this->user_form_model = array(
		"fields" => array(
    		"user_name" => array(
    			"type" => "text",
    			"label" => "Username",
    			"length" => "30",
    			"required" => "true"
    			),
    		"password" => array(
    			"label" => "Password",
    			"type" => "password",
    			"length" => "20",
    			"required" => "true"
    			),
    		"password_check" => array(
    			"label" => "Password(retype)",
    			"type" => "password",
    			"length" => "20",
    			"required" => "true"
    			),
    		"name" => array(
    			"label" => "Firstname",
    			"length" => "20",
    			"type" => "text",
    			"required" => "true"
    			),
    		"lastname" => array(
    			"type" => "text",
    			"label" => "Lastname",
    			"length" => "20",
    			"required" => "true"
    			),    		
    		"email" => array(
    			"type" => "text",
    			"label" => "Email",
    			"length" => "20",
    			"required" => "true"
    			),
    		"usergroup" => array(
    			"type" => "select",
    			"label" => "Group",
    			"length" => "",
    			"required" => "false",
    			"select" => array(
    				"multiple" => "true",
    				"null_value" => "false",
    				"interface" => "checkbox",
    				"source" => array(
    					"type" => "query",
    					"table" =>"usergroup",
    					"id" => "usergroup_id",
    					"label" => "name",
    					"sortby" => "name",
    					"order" => "ASC"
    					)
    				)
    			),
    		"role_id" => array(
    			"type" => "select",
    			"label" => "Role",
    			"length" => "",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"interface" => "list",
    				"source" => array(
    					"type" => "query",
    					"table" =>"security_role",
    					"id" => "role_id",
    					"label" => "name",
    					"sortby" => "role_id",
    					"order" => "ASC"
    					)
    				)
    			),
    		"centre" => array(
        			"type" => "select",
        			"label" => "Centre",
        			"select" => array(
        				"multiple" => "false",
        				"null_value" => "true",
        				"interface" => "list",
        				"source" => array(
        					"type" => "query",
        					"table" =>"centre",
        					"id" => "centre_id",
        					"label" => "name",
        					"sortby" => "name",
        					"order" => "ASC"
        				)
    				)
    			),
    		"profile" => array(
    			"type" => "textarea",
    			"label" => "Profile",
    			"editor" => "true",
    			"required" => "false",
    			"rows" => "30",
    			"cols" => "80",
    			),
    		"active" => array(
    			"type" => "select",
    			"label" => "Active",
    			"lenght" => "",
    			"required" => "true",
    			"default" => "y",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array("y" => "Yes", "n" =>"No")
    				)
    			)
    		)
    		),
    	"form" => array(
    		"name" => "user",
    		"method" => "post",
    		"action" => ""
    		)
		);
		
		// data model
		$this->user_data_model = array(
		'fields' => array(
    		"user_name" => array(
    			"type" => "text"
    			),
    		"password" => array(
    			"type" => "text"
    			),
    		"name" => array(
    			"type" => "text"
    			),
    		"lastname" => array(
    			"type" => "text"
    			),
    		"profile" => array(
    			"type" => "text"
    			),
    		"lastlogin" => array(
    			"type" => "datetime"
    			),
    		"email" => array(
    			"type" => "text"
    			),
    		"centre" => array(
    			"type" => "integer"
    			),
    		"usergroup" => array(
    			"type" => "text"
    			),
    		"role_id" => array(
    			"type" => "text"
    			),
    		"active" => array(
    			"type" => "text"
    			)	
    		),
    	'table' => array(
    		'name' => 'users',
    		'id' => 'user_id')
		);
		
		// search form model
        $this->user_search_model = array(
		"fields" => array(
    		"name" => array(
    			"label" => "Name",
    			"type" => "text",
    			"op" => "like",
    			"field" => "lastname, firstname, username"
    		)
    	),
    	"orderby" => array(
    		"order1" => array(
    			"options" => array(
    				"lastname" => "Lastname",
    				"name" => "Name",
    				"email" => "Email",
    				"centre" => "Centre"
    			)
    		)
    	),
    	'form' => array(
    		'name' => 'user_search'
    		)
		);
		
		// 
		$this->user_list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Firstname",
    			"lenght" => "",
    			"type" => "text"
    			),
    		"lastname" => array(
    			"header" => "Lastname",
    			"lenght" => "",
    			"type" => "text"
    			),
    		"email" => array(
    			"header" => "Email",
    			"lenght" => "",
    			"type" => "text"
    			),
    		"centre" => array(
    			"header" => "Centre",
    			"type" => "select"
    			),
    		"usergroup" => array(
    			"header" => "Group",
    			"type" => "select"
    			),
            "role_id" => array(
                "header" => "Role",
                "type" => "select"
                ),
    		"lastlogin" => array(
    			"header" => "Last login",
    			"lenght" => "",
    			"type" => "datetime"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			
    			"view" => array(
    				"link" => site_url("user/view/user_id")
    			),
    			"id" => "user_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"yuimaxrows" => "10",
    			"default_sort" => "ORDER BY user_name ASC"
    		),
    		"table" => "users",
    		"base_url" => site_url("user/xgrid")
    	)
		);
		
		// create Form class models
		$this->form->list_model = $this->user_list_model;
		$this->form->search_model = $this->user_search_model;
		$this->form->data_model = $this->user_data_model;
		$this->form->form_model = $this->user_form_model;
		$this->form->view_model = $this->user_view_model;
		$this->object = "user";
	}
	
	// default page
	function index()
	{			
		redirect ("user/xgrid");
	}
	
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "access");
		
		$data['search'] = $this->form->generate_search();
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view("user/xgrid",$data,true);		
		$this->layout->render_page();
		
	}
	
	
	function usersList($page = 1){
		$this->form->list_model["grid"]["op"]["view"]["link"] = site_url("user/pview/user_id");
		$this->cdata_user->check_permission("app", "access");
		return $this->form->generate_grid($page);	
		
	}
	
	
	function create(){
        
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;
			
			if ($this->form->form_check()){
				$this->form->form_data['password'] = md5($this->form->form_data['password']);
				// save data
                $sql = $this->form->add_data();
                redirect("user/xgrid");
			}
		}
		
		$this->layout->main = $this->load->view("user/create", null, true);	
		$this->layout->render_page();
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission("app", "user");
		$this->user_form_model['form']['cancelUrl'] = site_url("user/view/$id");
        $this->user_form_model['fields']['password']['label'] = 'New Password';
        $this->user_form_model['fields']['password']['required'] = 'false';
        $this->user_form_model['fields']['password_check']['required'] = 'false';        					
		$this->form->form_model = $this->user_form_model;
		
		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;
			$err = false;
			if ($this->form->form_check()){
				if(trim($this->form->form_data['password']) > ""){
					if ($this->form->form_data['password'] <> $this->form->form_data['password_check']){
						$this->form->form_error["form"] = "The two passwords are not the same";
						$err = true;
					} else {
						$this->form->form_data['password'] = md5($this->form->form_data['password']);
					}
				} else {
					unset($this->form->data_model["fields"]["password"]);
				}
				if ($err == false){
    				$sql = $this->form->save_data($id);
                    redirect("user/xgrid");
				}
			} 
		} else {
			$this->form->read_data($id);
    		$this->form->form_data['password'] = "";
		}
		$data["id"] = $id;
		$this->layout->main = $this->load->view("user/edit", null, true);	
		$this->layout->render_page();
	}
	
	
	function editown(){
		
		$this->cdata_user->check_permission($this->permission_object, "access");
		if(!$this->cdata_user->is_logged()){redirect("");}
		$id = $this->cdata_user->get_user_id();
        
		$this->user_form_model['form']['cancelUrl'] = site_url("user/home");
		//set new password field
		$this->user_form_model['fields']['password']['label'] = 'New Password';
        $this->user_form_model['fields']['password']['required'] = 'false';
        $this->user_form_model['fields']['password_check']['required'] = 'false';     
        unset($this->user_form_model['form']["delete"]);
        unset($this->user_form_model["fields"]["role_id"]);
        unset($this->user_form_model["fields"]["active"]);		
		
		$this->form->data_model = $this->user_data_model;
		$this->form->form_model = $this->user_form_model;
		
		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;
			$err = false;
			if ($this->form->form_check()){
				if(trim($this->form->form_data['password']) > ""){
					if ($this->form->form_data['password'] <> $this->form->form_data['password_check']){
						$this->form->form_error["form"] = "The two passwords are not the same";
						$err = true;
					} else {
						$this->form->form_data['password'] = md5($this->form->form_data['password']);
					}
				} else {
					unset($this->form->data_model["fields"]["password"]);
				}
				if ($err == false){
    				$sql = $this->form->save_data($id);
                    redirect("user/home");
				}                
			}
		} else {
			//load data
    		$this->form->read_data($id);
    		$this->form->form_data['password'] = "";
		}
		
		$this->layout->main = $this->load->view("user/editown", null, true);	
		$this->layout->render_page();
	}
	
	
	function view($id){
		
        $this->cdata_user->check_permission($this->permission_object, "access");				
		$this->form->read_data($id);
		$data["id"] = $id;
		
		$this->layout->main = $this->load->view("user/view", $data, true);	
		$this->layout->render_page();
	}
	
	
	//public view
	function pview($id){
		
		$this->cdata_user->check_permission("app", "access");	
		unset($this->form->view_model["fields"]["user_name"]);
		unset($this->form->view_model["fields"]["active"]);			
		$this->form->read_data($id);
		$this->layout->main = "<h2>User</h2>".$this->form->generate_view();
		$this->layout->render_page();
		
	}
	
	
	function login(){
		$model = array(
			"fields" => array(
				"username" => array(
					"label" => "Username",
					"type" => "text",
					"length" => "20",
					"required" => "true"
				),
				"password" => array(
					"label" => "Password",
					"type" => "password",
					"length" => "20",
					"required" => "true"
				)/*,
				"cookie" => array(
					"label" => "Keep me logged",
					"type" => "checkbox"
				)
				*/
			)
		);
		
		$this->form->form_model = $model;
		
		if (isset($_REQUEST['submit'])) {
			if ($this->form->form_check()){
				// check login
                if($this->cdata_user->trylogin($_REQUEST["username"], $_REQUEST["password"], isset($_REQUEST["cookie"]))) { 
				redirect("");
                } else {
                	$this->form->form_error["form"] = "Login error, try again";
                }
			}
		}

		$this->layout->main = $this->load->view("user/login", null, true);	
		$this->layout->render_page();				
	}
	
	
	
	function logout (){
		$this->cdata_user->logout();
		redirect("");
	}
	
	function delete($id){
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->delete_data($id);
		redirect("user/xgrid");
	}
	
	function home(){
		$this->cdata_user->check_permission($this->permission_object, "access");
		if(!$this->cdata_user->is_logged()){redirect("");}
        unset($this->user_view_model["fields"]["active"]);
        
		$id = $this->cdata_user->get_user_id();
		$this->form->read_data($id);
		$data["userView"] = $this->form->generate_view();
		
		$this->load->model("todomodel");
		$data["todoList"] = $this->todomodel->userlist($id);
		
		$this->load->model("bookmarkmodel");
		$data["bookmarkList"] = $this->bookmarkmodel->userlist($id);
		
		$this->load->model("subscriptionmodel");
		$data["subscriptionList"] = $this->subscriptionmodel->userlist($id);
		
		$this->load->model("eventmodel");
		$data["eventList"] = $this->eventmodel->userlist($id);
		
		$this->load->model("logmodel");
		$data["logList"] = $this->logmodel->userlist($id);
		
		$data["usersList"] = $this->usersList();
		
		$this->layout->main = $this->load->view("user/home", $data, true);	
		$this->layout->render_page();
		
	}
	
	function subscriptionList(){
		
		$user_id = $this->cdata_user->get_user_id();
		
			
	}
	
	function calendar($userid){
		$this->cdata_user->check_permission($this->permission_object, "access");
		$page = 1;
		$q= "
		(SELECT event_id as id, start as start, 'event' as class, 'Event' as type, title as title FROM event) 
		UNION  
		(SELECT todo_id as id, start as start, 'todo' as class, 'Todo' as type, title as title FROM todo WHERE assigned REGEXP '[[:<:]]".$userid."[[:>:]]')
		ORDER BY start DESC
		"; 
		
		$res = mysql_query($q);
		$l = "";
		while($r = mysql_fetch_assoc($res)){
			$l .= $r["id"]." ".$r["start"]." ".$r["title"]."<br/>"; 
		}
		$data['list'] = $l;

		$this->layout->main = $this->load->view($this->object."/calendar", $data, true);	
		$this->layout->render_page("iframe");		
	}
}


?>