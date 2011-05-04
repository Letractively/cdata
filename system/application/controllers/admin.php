<?php
/*
 * Created on 20-8-2007
 *
 */


class Admin extends Controller {

	
	function Admin()
	{	
		
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
				
	}
	
	// default page
	function index()
	{			
		//redirect ($this->object."/xgrid");
	}
	
	
	function move($class, $id){
		
		$this->cdata_user->check_permission("app", "admin");
		// form model
        $mf = array(
		"fields" => array(
			"class" => array(
    			"type" => "hidden"
    			), 
    		"id" => array(
    			"type" => "hidden"
    			), 
    		"pclass" => array(
    			"type" => "select",
    			"label" => "Parent object",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list",
    				"source" => array(
    					"type" => "array",
    					"options" => array("folder" => "Folder", "patient"=>"Patient", "pform" =>"Form", "db" =>"Database", "file" =>"File",
    					"project"=>"Project", "page"=>"Page", "todo"=>"Todo", "link"=>"Link", "event"=>"Event")
    					)
    				)
    			),
    		"pid" => array(
    			"type" => "integer",
    			"label" => "Parent ID",
    			"required" => "true"
    			) 		    		
    		),
    	"form" => array(
    		"name" => "move_object",
    		"method" => "post",
    		"action" => "",    		
			"theme" => "default"
    		)
		);
		$this->form->form_data["class"] = $class;
		$this->form->form_data["id"] = $id;		
		$this->form->form_model = $mf;
		$this->form->form_model["form"]["cancelUrl"] = site_url("$class/xview/$id");
		
		if(isset($_POST["submit"])){
			$this->form->form_data = $_POST;
			if ($this->form->form_check()){			
				if ($this->relation->nodeExist($_POST["pclass"], $_POST["pid"]) == true){
					$this->relation->changeParent($class, $id, $_POST["pclass"], $_POST["pid"]);
					redirect("$class/xview/$id");
				} else {
					$this->form->form_error["form"] = "Parent object not found!";
				}
			}
		}
		
		$this->layout->main = "<h3>Move object</h3>".$this->form->generate_form();
		$this->layout->render_page();
		
	}
    
    
    function createDataTable(){
    
        $r = $this->relation->updateDataTable();
        if ($r > "") {
            $res = "<h3>An error occurred</h3> $r <p><a href=\"".site_url("admin/main")."\">Back</a></p>";}
        else {
            $res = "<h3>Tables updated</h3><p><a href=\"".site_url("admin/main")."\">Back</a></p>";
        }
        $this->layout->main = $res;
        $this->layout->render_page();
    }
    
    function exportXml($class, $id){
    
        $r = $this->relation->exportXml($class, $id);
    }
    
    
    function main(){
        
        $this->layout->main = "
        <h1>System administration</h1>
        <p><input type=\"button\" value=\"Update\" 
        onClick=\"location.href = '".site_url("admin/createDataTable")."'\"/> Update Data Tables for export and reporting</p>
        ";
        $this->layout->render_page();
    
    }
    
    function unlock($class, $id){
        
        $this->cdata_user->check_permission("app", "admin");
        $this->relation->log("0", $class, $id, "unlock", $this->cdata_user->get_user_id(), "Patient Form unlock");    
        $this->cdata_user->releaseLock($class, $id);
        redirect ("$class/xview/$id");
    
    }
	
	
}


?>