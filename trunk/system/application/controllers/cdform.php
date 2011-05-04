<?php
/*
 * Created on 20-8-2007
 *
 */


class Cdform extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "cdform";	
	var $permission_object = "db";
		
	
	
	function Cdform()
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
    			),
    		"codename" => array(
    			"type" => "text"
    			),
    		"version" => array(
    			"type" => "integer"
    			),
    		"teaser" => array(
    			"type" => "text"
    			),
    		"scope" => array(
        			"type" => "text",
        			"serialized" => "true"
        		),
    		"database_list" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"note" => array(
    			"type" => "text"
    			),    		
    		"data_model" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"view_model" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_model" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
            "list_model" => array(
                "type" => "text",
                "serialized" => "true"
                ),
    		"tab" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"tab_secret" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"use_theme_view" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"theme_view" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"use_theme_form" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"theme_form" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"created" => array(
    			"type" => "datetime"
    			)
    		),
        	'table' => array(
    		'name' => "{$this->object}",
    		'id' => $this->object.'_id',
    		"serialized_column" => "data")
		);
		
		// view model
		$this->view_model = array(
		"fields" => array(
			"codename" => array(
    			"type" => "text",
    			"label" => "Codename",
    			"tab" => "info"
    			),
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"tab" => "info"
    			),
    		"version" => array(
    			"type" => "text",
    			"label" => "Version",
    			"tab" => "info"
    			),
    		"teaser" => array(
    			"type" => "html",
    			"label" => "Description",
    			"tab" => "info"
    			),
    		"scope" => array(
    			"type" => "select",
    			"label" => "Scope",
    			"tab" => "info"
    			),    		
    		"database_list" => array(
    			"type" => "select",
    			"label" => "Select DB",
    			"tab" => "info"
    			),
    		"note" => array(
    			"type" => "html",
    			"label" => "Note",
    			"tab" => "info"
    			),     		
    		"use_theme_view" => array(
    			"type" => "checkbox",
    			"label" => "Use my View",
    			"tab" => "theme"
    			),
    		"theme_view" => array(
    			"type" => "textarea",
    			"label" => "View theme",
    			"tab" => "theme"
    			),
    		"use_theme_form" => array(
    			"type" => "checkbox",
    			"label" => "Use my Form",
    			"tab" => "theme"
    			),
    		"theme_form" => array(
    			"type" => "textarea",
    			"label" => "Form theme",
    			"tab" => "theme"
    			),
    		"created" => array(
    			"type" => "datetime",
    			"label" => "Created",
    			"tab" => "info"
    			)
    		),
    	"view" => array(
    		"theme" => "default",
    		"tab" => array(
				"info" => "Info"
				)
    		)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
			"form_submit" => array(
    			"type" => "hidden",
    			"value" => "true"
    			),
			"codename" => array(
    			"type" => "text",
    			"label" => "Codename",
    			"length" => "50",
    			"required" => "true",
    			"tab" => "info",
    			"help" => "A short name to identify the form template"
    			), 
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"length" => "50",
    			"required" => "true",
    			"tab" => "info"
    			),  
    		"version" => array(
    			"type" => "integer",
    			"label" => "Version",
    			"length" => "10",
    			"required" => "true",
    			"tab" => "info"
    			),
    		"teaser" => array(
    			"type" => "textarea",
    			"label" => "Description",
    			"rows" => "6",
    			"cols" => "50",
    			"required" => "false",
    			"editor" => "true",
    			"tab" => "info"
    			),  
    		"scope" => array(
    			"type" => "select",
    			"label" => "Scope",
    			"required" => "true",
    			"tab" => "info",
    			"select" => array(
    				"multiple" => "false",
    				"interface" => "list",
    				"source" => array(
    					"type" => "array",
    					"options" => array("0" => "All applications", "1" =>"DB only", "2" =>"Selected DB"
    					)
    				)
    			)
    		),    		
    		"database_list" => array(
    			"type" => "select",
    			"label" => "Or Select DB",
    			"required" => "false",
    			"tab" => "info",
    			"select" => array(
    				"multiple" => "true",
    				"interface" => "checkbox",
    				"align" => "orizontal",
    				"source" => array(
    					"type" => "query",
    					"table" =>"db",
    					"id" => "db_id",
    					"label" => "name",
    					"sortby" => "name",
    					"order" => "ASC"
    					)
    				)
    			),
    		"note" => array(
    			"type" => "textarea",
    			"label" => "Note",
    			"rows" => "20",
    			"cols" => "50",
    			"required" => "false",
    			"editor" => "true",
    			"default" =>"",
    			"tab" => "info" 
    			),  
       		"data_model" => array(
    			"type" => "hidden"
    			),
    		"view_model" => array(
    			"type" => "hidden"
    			),
    		"form_model" => array(
    			"type" => "hidden"
    			),
            "list_model" => array(
                "type" => "hidden"
                ),
    		"tab_secret" => array(
    			"type" => "hidden",
    			"tab" => "model" 
    			),
   			"code" => array(
    			"type" => "insertion",
    			"label" => "Tabs",
    			"tab" => "model",
    			"content" => '
Code:<input type="text" id="id" name="id" value="" /> Label:<input type="text" id="label" name="label" value="" />
<input type="button" value="Add" name="add" onclick="code.add()" />
<div id="listDiv">
<table id="list"  border="0" width="200px">
</table>
<input type="button" value="Save Changes" name="add" onclick="code.save()" />
</div>
				'
    		  ),  	
    		"use_theme_view" => array(
    			"type" => "checkbox",
    			"label" => "Use my View",
    			"tab" => "theme"
    			), 
    		"theme_view" => array(
    			"type" => "textarea",
    			"rows" => "20",
    			"cols" => "60",
    			"label" => "View theme",
    			"tab" => "theme"
    			),
    		"use_theme_form" => array(
    			"type" => "checkbox",
    			"label" => "Use my Form",
    			"tab" => "theme"
    			),
    		"theme_form" => array(
    			"type" => "textarea",
    			"rows" => "20",
    			"cols" => "60",
    			"label" => "Form theme",
    			"tab" => "theme"
    			),   		 		    		
    		),
    	"form" => array(
    		"name" => "{$this->object}",
    		"method" => "post",
    		"action" => "",    	
			"theme" => "default",
			"tab" => array(
				"info" => "Info",
				"model" => "Structure",
				"theme" => "Themes"
				)
			
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
        	"fields" => array(
        		"title" => array(
        			"label" => "Search",
        			"type" => "text",
        			"op" => "like",
        			"field" => "name, teaser, note"
        			),
        		),
        	'form' => array(
        		'name' => $this->object.'_search'
        		)
    	);
		
		// 
		$this->list_model = array(
		"fields" => array(
    		"name" => array(
    			"header" => "Name",
    			"type" => "text"
    			),
    		"version" => array(
    			"header" => "Version",
    			"type" => "text"
    			),  
    		"scope" => array(
    			"type" => "select",
    			"header" => "Scope"
    			),    		
    		"database_list" => array(
    			"header" => "DB List",
    			"type" => "select"
    			),       		
    		"created" => array(
    			"header" => "Created",
    			"type" => "datetime"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			    			
    			"view" => array(
    				"link" => site_url("{$this->object}/view/{$this->object}_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"ajaxmaxrows" => "10",
    			"default_sort" => "ORDER BY name ASC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xgrid"),
    		"theme" => "default"
    		)
		);
		
		$theme_form = "default";
		
		
		// create Form class models
		$this->form->list_model = $this->list_model;
		$this->form->search_model = $this->search_model;
		$this->form->data_model = $this->data_model;
		$this->form->form_model = $this->form_model;
		$this->form->view_model = $this->view_model;
		
		//$this->form->form_model["form"]["theme"] = $theme_form;
		
	}
	
	// default page
	function index()
	{			
		redirect ($this->object."/xgrid");
	}
	
	function create_table($id){
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->read_data($id);
		$cf = $this->form->form_data["codename"];
		if($this->table_exist($cf["codename"])){
			$data["message"] = "Table $name is already present";
		} else {
			$data["message"] = "Table $name is not present";
		}
		$data["content"] = $this->load->view("cdform/create_table",$data,true);
		$this->template_print($data);
	}
	
	
	function duplicateFields($oldid, $newid){
		
		$q = "SELECT * FROM field WHERE cdform_id = $oldid";
		$res = mysql_query($q);
		while($r = mysql_fetch_assoc($res)){
			$s = "INSERT INTO field SET ".
				 "cdform_id = $newid, sort = {$r["sort"]}, data = '{$r["data"]}'";
		    mysql_query($s);				
		}
	}
	
	
	function create_nv($id){

		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;					
			if ($this->form->form_check()){				
				// save data
                $this->form->form_data['created'] = date("d-m-Y H:i:s"); 
                $newid = $this->form->add_data();
                //duplicate fields
                $this->duplicateFields($id, $newid);
                redirect("{$this->object}/view/$newid");
			}
		} else {
			//load data
            $this ->form->read_data($id);     
            $this->form->form_data["version"] += 1;                 
		}
		
		$this->layout->main = $this->load->view($this->object."/create",$data,true);	
		$this->layout->render_page();
	}
	
	function duplicate($id){

		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;					
			if ($this->form->form_check()){				
				// save data
                $this->form->form_data['created'] = date("d-m-Y H:i:s"); 
                $newid = $this->form->add_data();
                //duplicate fields
                $this->duplicateFields($id, $newid);
                redirect("{$this->object}/view/$newid");
			}
		} else {
			//load data
            $this ->form->read_data($id);  
            $this->form->form_data["version"] = 1;
            $this->form->form_data["codename"] = "";                      
		}
		
		$this->layout->main = $this->load->view($this->object."/create",$data,true);	
		$this->layout->render_page();
	}
	
	function table_exist($name){
		$res = mysql_query("show table status like '$name'")
        or die(mysql_error());
        return mysql_num_rows($res) == 1;
	}
	
	function xgrid($page = 1){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$data['search'] = $this->form->generate_search($page);;
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);	
		$this->layout->render_page();
		
	}
	
	
	function create(){
        
		$this->cdata_user->check_permission($this->permission_object, "admin");
		if (isset($_REQUEST['submit'])) {
			$this->form->form_data = $_REQUEST;
			
			if ($this->form->form_check()){
				$this->form->form_data['created'] = date("d-m-Y H:i:s");
				$this->form->form_data['tab'] = $this->generateTabs($this->form->form_data['tab_secret']);
				// save data
                $id = $this->form->add_data();
                redirect("{$this->object}/view/$id");
			}
		}
		
		$this->layout->main = $this->load->view($this->object."/create",null,true);	
		$this->layout->render_page();
	}
	
	function generate($id){
        
		$this->cdata_user->check_permission($this->permission_object, "admin");
		
		$q = "SELECT * FROM field WHERE cdform_id = $id order by sort ASC";
		$res = mysql_query($q);
		$dm = "";
		$vm = "";
		$fm = "";		
        $lm = "";
        
		while($f = mysql_fetch_assoc($res)){
			//generate data model
            $s = unserialize($f["data"]);
            $f = array_merge($f,$s);
            $dm .= 
            '"'.$f["model_name"].'" => array('."\n".
    			'"type" => "'.element("model_type",$f).'"'."\n".
    			'),'."\n";
    		$vm .= 
    		'"'.$f["model_name"].'" => array('."\n".
            '"type" => "'.$f["view_type"].'",'."\n".
            '"label" => "'.addslashes($f["view_label"]).'",'."\n".
            '"tab" => "'.$f["form_tab"].'"'."\n".
            '),'."\n";
            $fm .= 
    		'"'.$f["model_name"].'" => array('."\n".
            '"type" => "'.$f["form_type"].'",'."\n".
            '"label" => "'.addslashes($f["form_label"]).'",'."\n".
            '"tab" => "'.$f["form_tab"].'",'."\n".
            '"required" => "'.$f["form_required"].'",'."\n".
            '"length" => "'.$f["form_size"].'",'."\n".
            '"editor" => "'.$f["form_editor"].'",'."\n".
            '"rows" => "'.$f["form_rows"].'",'."\n".
            '"cols" => "'.$f["form_cols"].'",'."\n".
            '"unit" => "'.$f["form_unit"].'",'."\n".
            '"min" => "'.$f["form_min"].'",'."\n".
            '"max" => "'.$f["form_max"].'",'."\n".
            '"help" => "'.addslashes(addslashes($f["form_help"])).'",'."\n";
            if ($f["view_inlist"] == "true"){           
                $lm .= 
                '"'.$f["model_name"].'" => array('."\n".
                    '"header" => "'.addslashes($f["view_label"]).'",'."\n".
                    '"type" => "'.element("view_type",$f).'"'."\n".
                    '),'."\n";
            }
            $list = "";
            if ($f["form_type"] == "select"){
            	if ($f["form_select_source_type"] == "array"){
            		$l = $f["form_select_source_codes"];
            		$lc = explode("#", $l);
            		array_pop($lc);
            		$list = '"options" => array('."\n";
            		foreach($lc as $val){
            			list($k, $v) = explode("|",$val);
            			$list .= '"'.$k.'" => "'.$v.'",'."\n";
            		}
            		$list = $this->form->utils_striptail($list, 2);
            		$list .= ')'."\n";
            	}
            	$fm .= 
            	'"select" => array('."\n".
    				'"multiple" => "'.$f["form_select_multiple"].'",'."\n".
    				'"null_value" => "'.$f["form_select_null"].'",'."\n".
    				'"interface" => "'.$f["form_select_interface"].'",'."\n".
    				'"align" => "'.$f["form_select_interface_align"].'",'."\n".
    				'"source" => array('."\n".
    					'"type" => "'.$f["form_select_source_type"].'",'."\n".
    					'"lookup_id" => "'.$f["form_select_source_lookupid"].'",'."\n".
    					'"table" => "'.$f["form_select_source_query_table"].'",'."\n".
    					'"id" => "'.$f["form_select_source_query_id"].'",'."\n".
    					'"label" => "'.$f["form_select_source_query_label"].'",'."\n".
    					'"sortby" => "'.$f["form_select_source_query_sortby"].'",'."\n".
    					'"order" => "'.$f["form_select_source_query_order"].'",'."\n".
    				$list.
    				')'."\n".
    			')'."\n";
            }
            
            $fm .= '),'."\n";
		}
		$this->form->read_data($id);
		$this->form->form_data["data_model"] = $dm;
		$this->form->form_data["view_model"] = $vm;
		$this->form->form_data["form_model"] = $fm;
        $this->form->form_data["list_model"] = $this->form->utils_striptail($lm, 2);
        $this->form->list_model["fields"] = $lm;
		unset($this->form->data_model["fields"]["created"]);
		$this->form->save_data($id);
		print("Model Updated");
	}
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->form_model["form"]["cancelUrl"] = site_url($this->object."/view/$id");
		if (isset($_REQUEST['form_submit'])) {
			$this->form->form_data = $_REQUEST;		
			if ($this->form->form_check()){
				$this->form->form_data['tab'] = $this->generateTabs($this->form->form_data['tab_secret']);
				// save data
                $sql = $this->form->save_data($id);
                redirect("{$this->object}/view/$id");
			}
		} else {
			$this->form->read_data($id);  		
		}
		$this->layout->main = $this->load->view($this->object."/edit",null,true);	
		$this->layout->render_page();
	}
	
	function generateTabs($tab){
		
		$lc = explode("#", $tab);
		array_pop($lc);
		$list = "";
		foreach($lc as $val){
			list($k, $v) = explode("|",$val);
			$list .= '"'.$k.'" => "'.$v.'", ';
		}
		$list = $this->form->utils_striptail($list, 2);
		return $list;
	}
	
	function view($id){

		$this->cdata_user->check_permission($this->permission_object, "view");
		$this->form->read_data($id);
		$data["id"] = $id;
		$this->layout->main = $this->load->view($this->object."/view",$data,true);	
		$this->layout->render_page();
	}
	
	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->delete_data($id);
		$q = "DELETE FROM field WHERE cdform_id = $id";
    	mysql_query($q);
		redirect($this->object."/xgrid");
	}
	
}


?>