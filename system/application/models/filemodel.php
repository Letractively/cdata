<?php

class Filemodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "file";	
	
	
	function filemodel(){
		
		parent::Model();	

		$this->load->library("form");
		$this->myform = new Form();
		$this->load->library("cdata_user");
		$this->load->library("relation");
		
		// data model
		$this->data_model = array(
		'fields' => array(
			"pclass" => array(
    			"type" => "text"
    			),
    		"pid" => array(
    			"type" => "integer"
    			),
    		"name" => array(
    			"type" => "text"
    			),
    		"note" => array(
    			"type" => "text"
    			),
    		"type" => array(
    			"type" => "text"
    			),
    		"size" => array(
    			"type" => "integer"
    			),
    		"filename" => array(
    			"type" => "text"
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
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"tab" => "tmain"
    			),
    		"type" => array(
    			"type" => "text",
    			"label" => "Type",
    			"tab" => "tmain"
    			),
    		"size" => array(
    			"type" => "text",
    			"label" => "Size",
    			"tab" => "tmain"
    			),
    		"filename" => array(
    			"type" => "text",
    			"label" => "File name",
    			"tab" => "tmain"
    			),
    		"note" => array(
    			"type" => "html",
    			"label" => "Note",
    			"tab" => "tnote"
    			),
    		"file" => array(
    			"type" => "html",
    			"label" => "Download",
    			"tab" => "tmain"
    			),    		
    		"created" => array(
    			"type" => "datetime",
    			"label" => "Created",
    			"tab" => "tmain"
    			)
    		),
    	"view" => array(
    		"theme" => "default",
    		"tab" => array(
				"tmain" => "Main",
				"tnote" => "Note"
				)
    	)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
			"pclass" => array(
    			"type" => "hidden"
    			), 
    		"pid" => array(
    			"type" => "hidden"
    			), 
    		"name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"length" => "60",
    			"required" => "true",
    			"tab" => "tmain"
    			),  
    		"note" => array(
    			"type" => "textarea",
    			"label" => "Note",
    			"rows" => "15",
    			"cols" => "60",
    			"editor" => "true",
    			"required" => "false",
    			"tab" => "tnote"
    			), 
    		"file" => array(
    			"type" => "upload",
    			"label" => "File to upload",
    			"tab" => "tmain"
    			), 		 		    		
    		),
    	"form" => array(
            "locking" => "true",
    		"name" => "{$this->object}",
    		"method" => "post",
    		"action" => "",
    		"upload" => "true",    	
			"theme" => "default",
			"tab" => array(
				"tmain" => "Main",
				"tnote" => "Note"
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
        			"field" => "name, note, type"
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
    		"type" => array(
    			"header" => "Type",
    			"type" => "text"
    			),
    		"size" => array(
    			"header" => "Size",
    			"type" => "integer"
    			),
    		"created" => array(
    			"header" => "Created",
    			"type" => "datetime"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			   			
    			"view" => array(
    				"link" => site_url("{$this->object}/xview/file_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"default_sort" => "ORDER BY created DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xgrid"),
    		"theme" => "default",
    		"target" => "_parent"
    	)
		);
		
		
		// create Form class models
		$this->myform->list_model = $this->list_model;
		$this->myform->search_model = $this->search_model;
		$this->myform->data_model = $this->data_model;
		$this->myform->form_model = $this->form_model;
		$this->myform->view_model = $this->view_model;
		
		//$this->form->form_model["form"]["theme"] = $theme_form;
		
	}	

	function grid($pclass = "", $pid = "", $page = 1){
		
		if ($pclass > ""){
			$this->myform->list_model["filter"]["pclass"] = $pclass;
			$this->myform->list_model["filter"]["pid"] = $pid;
		}
        
		return $this->myform->generate_grid($page);			
	
	}
    
    function grid_print($pclass = "", $pid = "", $page = 1){
        
        if ($pclass > ""){
            $this->myform->list_model["filter"]["pclass"] = $pclass;
            $this->myform->list_model["filter"]["pid"] = $pid;
        }
        $this->myform->list_model["grid"]["op"]["view"]["link"] = "file_xview_file_id.html";    
        return $this->myform->generate_grid($page);            
    
    }
	
	
	function view($id){
        
		$data["id"] = $id;
		$data["class"] = $this->object;
		$q = "SELECT name, size, type, filename, created, data, note FROM file WHERE file_id = $id";
		$row = mysql_fetch_assoc(mysql_query($q));
        $this->myform->form_data = $this->myform->row_to_array($row);
        $link = "<a href=\"".site_url("file/download/$id")."\">View in the browser</a> :: <a href=\"".site_url("file/download/$id/attachment")."\">Download</a>";
        $this->myform->form_data["file"] = $link;
		return $this->myform->generate_view();
		
	}
    
    function view_print($id){
        
        $data["id"] = $id;
        $data["class"] = $this->object;
        $q = "SELECT name, size, type, filename, created, data, note FROM file WHERE file_id = $id";
        $row = mysql_fetch_assoc(mysql_query($q));
        $this->myform->form_data = $this->myform->row_to_array($row);
        $ext = substr(strrchr($this->myform->form_data["filename"], '.'), 1);
        $link = "<a href=\"file_$id.$ext\">View in the browser</a>";
        $this->myform->form_data["file"] = $link;
        return $this->myform->generate_view();
        
    }
    
    
    function title($id = null){
        
        $col = "name";
        if (!isset($this->myform->form_data[$col])){
            $this->myform->read_data($id);  
        }
        return $this->myform->form_data[$col];
        
    }
	
	
	function download($id, $disposition = "inline"){
        
        $query = "SELECT filename, type, size " .
                 "FROM file WHERE file_id = $id";
        $result = mysql_query($query) or die('Error, query failed');
        list($name, $type, $size) = mysql_fetch_array($result);
        $filename = $this->config->item("fileDir").$id;
        header("Content-length: $size");
        header("Content-type: $type");
        header("Content-Disposition: $disposition; filename=$name");
        readfile($filename);
        exit;    	
        	
	}
	
	
	function delete($id){

		list($pclass, $pid, $title) = $this->relation->getParentNode($this->object, $id);
		$this->relation->delete($this->object, $id);
		$this->relation->log("0", $this->object, $id, "del", $this->cdata_user->get_user_id(), $title);		
		redirect("$pclass/xview/$pid");
		
	}
	
	
	function search($page){
		return $this->myform->generate_search($page);	
	}
	
	
	function create($pclass = "root", $pid = 0){
		
		$this->myform->form_model["form"]["cancelUrl"] = site_url($pclass."/xview/$pid");
		$this->myform->form_model["fields"]["file"]["required"] = "true";
        $this->myform->form_data["pclass"] = $pclass;
        $this->myform->form_data["pid"] = $pid;
		if (isset($_REQUEST['submit'])) {
			$this->myform->form_data = $_REQUEST;
			
			if ($this->myform->form_check()){
                $fileName = $this->cleanFileName($_FILES['file']['name']);
                $tmpName  = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileType = $_FILES['file']['type'];
                                
                $this->myform->form_data['created'] = date("d-m-Y H:i:s");
                $this->myform->form_data['type'] = $fileType;
                $this->myform->form_data['size'] = $fileSize;
                $this->myform->form_data['filename'] = $fileName; 
				// save data
                $id = $this->myform->add_data();  
                $this->relation->log("0", $this->object, $id, "add", $this->cdata_user->get_user_id(), $this->myform->form_data["name"]);
                if($id > 0) {
                	//move file 
                    $fdir = $this->config->item("fileDir");                    
                    $fname = $fdir.$id;
                    move_uploaded_file($tmpName, $fname);          
                }
                redirect("file/xview/$id");  
			}
		}
		$this->myform->form_model["form"]["locking"] = "false"; 
		return $this->myform->generate_form();
		
	}
	
	
	function edit($id){
		
		$this->myform->form_model["form"]["cancelUrl"] = site_url("admin/unlock/".$this->object."/$id");
		$this->myform->form_model["fields"]["file"]["required"] = "false";
		if (isset($_REQUEST['submit'])) {
			$this->myform->form_data = $_REQUEST;
			
			if ($this->myform->form_check()){
				if($_FILES['file']['size'] > 0){
					$fileName = $_FILES['file']['name'];
                    $tmpName  = $_FILES['file']['tmp_name'];
                    $fileSize = $_FILES['file']['size'];
                    $fileType = $_FILES['file']['type'];
                    //move file
                    $fdir = $this->config->item("fileDir"); 
                    unlink($fdir.$id);                                      
                    $fname = $fdir.$id;                    
                    move_uploaded_file($tmpName, $fname);  
                    $this->myform->form_data['type'] = $fileType;
                    $this->myform->form_data['size'] = $fileSize;
                    $this->myform->form_data['filename'] = $fileName; 
				} 
                unset($this->myform->data_model["fields"]["created"]);     
				// save data
                $this->myform->save_data($id);
                $this->relation->log("0", $this->object, $id, "edit", $this->cdata_user->get_user_id(), $this->myform->form_data["name"]);
                redirect("file/xview/$id");
			}
		} else {
			$this->myform->read_data($id);
		}
		return $this->myform->generate_form();
		
	}
	
	
	
	function getFileExtension($filename){
		$array = explode(".", $fileName);
        $nr    = count($array);
        return $array[$nr-1];
	}
	
	
	function cleanFileName($fname){
		$replace="_";
		$pattern="/([[:alnum:]_\.-]*)/";
		return str_replace(str_split(preg_replace($pattern,$replace,$fname)),$replace,$fname);
	}


}


?>