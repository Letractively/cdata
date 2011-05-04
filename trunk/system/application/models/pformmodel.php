<?php

class Pformmodel extends Model{
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "pform";	
	var $print = false;
	
	function pformmodel(){
		
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
			"cdform_id" => array(
    			"type" => "integer"
    			),
			"title" => array(
    			"type" => "text"
    			),
    		"teaser" => array(
    			"type" => "text"
    			),
    		"fdate" => array(
    			"type" => "date"
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
    		"title" => array(
    			"type" => "text",
    			"label" => "Title"
    			),
    		"teaser" => array(
    			"type" => "text",
    			"label" => "Description"
    			),
    		"fdate" => array(
    			"type" => "date",
    			"label" => "Date"
    			)
    		),
    	"view" => array(
    		"theme" => "default"    	
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
			"cdform_id" => array(
    			"type" => "hidden"
    			),    	
			"title" => array(
    			"type" => "text",
    			"label" => "Title",
    			"required" => "true"
    			),
    		"teaser" => array(
    			"type" => "text",
    			"label" => "Description"
    			),
    		"fdate" => array(
    			"type" => "date",
    			"label" => "Date",
    			"required" => "true"
    			)
    		),
    	"form" => array(
            "locking" => "true",
    		"name" => "{$this->object}",
    		"method" => "post",
    		"action" => "",    		
			"theme" => "default"			
    		)
		);
		
		
		
		// search form model
        $this->search_model = array(
        	"fields" => array(
        		"title" => array(
        			"label" => "Search",
        			"type" => "text",
        			"op" => "like",
        			"field" => "title, teaser"
        			),
        		),
        	'form' => array(
        		'name' => $this->object.'_search'
        		)
    	);
		
		// 
		$this->list_model = array(
		"fields" => array(
			"fdate" => array(
    			"header" => "Date",
    			"type" => "date"
    			),
    		"title" => array(
    			"header" => "Title",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			
    			"view" => array(
    				"link" => site_url("{$this->object}/xview/pform_id")
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"yuimaxrows" => "50",
    			"default_sort" => "ORDER BY fdate DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xlist"),
    		"theme" => "default",
    		"target" => "_parent"
    		)
		);
		
		$theme_form = "default";
		
		
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
        $this->myform->list_model["grid"]["op"]["view"]["link"] = "pform_xview_pform_id.html";
        return $this->myform->generate_grid($page);            
    
    }
    
    
	function view($id){
		
        $cf = $this->read_cdformId($id);
		$this->complete_model($cf);		
        if($this->print == true){
            $this->myform->view_model["view"]["theme"] = "print";
        }		
		$this->myform->read_data($id);
		return $this->myform->generate_view();	
		
	}
    
    
    function title($id = null){
        
        $col = "title";
        if (!isset($this->myform->form_data[$col])){
            $this->myform->read_data($id);  
        }
        return $this->myform->form_data[$col];
        
    }
	
	
	function edit($id){
		
		$this->myform->form_model["form"]["cancelUrl"] = site_url("admin/unlock/".$this->object."/$id");
		$cf = $this->read_cdformId($id);
		$this->complete_model($cf);
		if ($this->myform->edit($id)){
			$this->relation->log("0", $this->object, $id, "edit", $this->cdata_user->get_user_id(), $this->myform->form_data["title"]);
			redirect($this->object."/xview/$id");
		}
		return $this->myform->generate_form();

	}
	
	
	function read_cdformId($id){
		$q = "SELECT cdform_id FROM pform WHERE pform_id = $id";
		$r = mysql_fetch_assoc(mysql_query($q));
		return $r["cdform_id"];
	}
	
	
	function complete_model($cdform){
		
		$qf = "SELECT * FROM cdform WHERE cdform_id = $cdform";
		$fr = mysql_query($qf);
		$f = mysql_fetch_assoc($fr);
		$fs = unserialize($f["data"]);
		$s = "\$dm = array(".element("data_model", $fs).");".
		"\$vm = array(".element("view_model", $fs).");".
		"\$fm = array(".element("form_model", $fs).");".
        "\$lm = array(".element("list_model", $fs).");".
		"\$tabm = array(".$fs["tab"].");";
        
		eval($s);
        while (list($key, $value) = each($dm)) {
          $element =& $dm[$key];
          $element["serialized"]= "true";
        }
		$this->myform->data_model["fields"]= array_merge($this->data_model["fields"], $dm);
		$this->myform->view_model["fields"]= array_merge($this->view_model["fields"], $vm);
		$this->myform->form_model["fields"]= array_merge($this->form_model["fields"], $fm);
        $this->myform->list_model["fields"]= array_merge($this->list_model["fields"], $lm);
        //if($cdform == 13){print_r($this->myform->list_model["fields"]); exit;}
		if(!empty($tabm)){
    		$this->myform->form_model["form"]["tab"]= $tabm;
    		$this->myform->view_model["view"]["tab"]= $tabm;
		}
		if(!empty($fs["theme_view"]) AND element("use_theme_view", $fs) > ""){
    		$this->myform->view_model["view"]["theme"]= $fs["theme_view"];
		}
		if(!empty($fs["theme_form"]) AND element("use_theme_form", $fs) > ""){
			
			$pclass = "<?php print \$data['pclass_input'];?>\n";
			$pid = "<?php print \$data['pid_input'];?>\n";
			$cid = "<?php print \$data['cdform_id_input'];?>\n";
			$t = $pclass.$pid.$cid.$fs["theme_form"];
    		$this->myform->form_model["form"]["theme"]= $t;
		}
	}
	
	
	function fcreate($pclass = null, $pid = null, $cdform = null){
		
		$this->myform->form_model["form"]["cancelUrl"] = site_url("$pclass/xview/$pid");
        $this->myform->form_data["pclass"] = $pclass;
        $this->myform->form_data["pid"] = $pid;
        $this->myform->form_data["cdform_id"] = $cdform;
        
		$this->complete_model($cdform);
		if (isset($_REQUEST['submit'])) {
			$this->myform->form_data = $_REQUEST;
			if ($this->myform->form_check()){
				$this->myform->form_data['created'] = date("d-m-Y H:i:s");			
                $id = $this->myform->add_data();
                $this->relation->log("0", $this->object, $id, "add", $this->cdata_user->get_user_id(), $this->myform->form_data["title"]);
                redirect($this->object."/xview/".$id);  
			}
		} else {
			$cf = $this->read_cdformTitle($cdform);
			$this->myform->form_data["title"] = $cf;
		}
        $this->myform->form_model["form"]["locking"] = "false"; 
		return $this->myform->generate_form();
	}
	
	
	function read_cdformTitle($id){
		$q = "SELECT name FROM cdform WHERE cdform_id = $id";
		$r = mysql_fetch_assoc(mysql_query($q));
		return $r["name"];
	}
	
    
    function form_list($pclass = "root", $pid = 0){
    
        // TODO
        $q = "select * from folder where folder_id = $pid";
        $r = mysql_fetch_array(mysql_query($q));
        if ($r["name"] == "Clinical Course"){
            $a["13"] = "Clinical Course";   
            return $a;
        };
        if ($r["name"] == "Family Members"){
            $a["15"] = "Thalassemia Family Members";   
            return $a;
        };
        if ($r["name"] == "Evaluation"){
            $a["14"] = "Thalassemia Initial Evaluation";   
            return $a;
        };
         
        $q = "SELECT cdform_id, concat(name,' - V.', version) as label, data FROM cdform ORDER BY name ASC, version DESC";
        $res = mysql_query($q);
        
        $a = array();
        while ($r = mysql_fetch_array($res)){
            if($this->isAllowed($pclass, $pid, $r["data"])){
                $a[$r["cdform_id"]] = $r["label"];
            }
        }
        return $a;
    }
   
    
	// return form selection web form
	function create($pclass = "root", $pid = 0){
		
        $a = $this->form_list($pclass, $pid);
		$this->myform->form_data["pclass"] = $pclass;
		$this->myform->form_data["pid"] = $pid;
		$this->myform->form_model = array(
		"fields" => array(
			"pclass" => array(
    			"type" => "hidden"
    			), 
    		"pid" => array(
    			"type" => "hidden"
    			),
			"cdform_id" => array(
    			"type" => "select",
    			"label" => "Select form",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"size" => "10",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array()
    					)
    				)
    			)
    		),
    	"form" => array(
    		"name" => "{$this->object}_cdform",
    		"method" => "post",
    		"action" => "",    		
			"theme" => "default",
            "submit_buttons"	=> false	
    		)
		);		
		$this->myform->form_model["fields"]["cdform_id"]["select"]["source"]["options"] = $a;
        $this->myform->form_model["fields"]["cdform_id"]["select"]["source"]["options"] = $a; 
        $this->myform->form_model["form"]["theme"] = 
        '
        <input type="hidden" name="pclass" value="'.$pclass.'"/>
        <input type="hidden" name="pid" value="'.$pid.'"/> 
        <b>New form</b>&nbsp;<?php print  $data["cdform_id_input"]; ?><input type="submit" value="Add" />'
        ;
        $this->myform->form_model["form"]["action"] = site_url("pform/xfcreate/".$pclass."/".$pid); 
		
        $this->myform->form_model["form"]["locking"] = "false"; 		
		return $this->myform->generate_form();	
	}
	
	
	// check if a form is visible to the application and can be listed
	function isAllowed($class, $id, $data){
		$d = unserialize($data);
		$scope = $d["scope"];
		if ($scope == "0"){return true;}
		// return first db data
		$dbid = $this->relation->getFirstParent($class, $id, "db");
		// any db is ok
		if (($scope == "1") and $dbid <> false){return true;}
		//selected db
		if ($scope == "2" AND $dbid <> false){
			//check if db is in list
            list($class, $id, $title) = $dbid;
            if($d["database_list"] > ""){
            	$l = explode("|",$d["database_list"]);
            	if(in_array($id,$l)){
            		return true;
            	} else {
            		return false;
            	}
            	
            }
		}
	}
	
	
	function delete($id){
		
		list($pclass, $pid, $title) = $this->relation->getParentNode($this->object, $id);
		$this->relation->delete($this->object, $id);	
		$this->relation->log("0", $this->object, $id, "del", $this->cdata_user->get_user_id(), $title);	
		redirect("$pclass/xview/$pid");
		
	}
    
    
    function childInterface ($pclass, $pid){
           
        $add_form = $this->create($pclass, $pid);
        
        $q = "SELECT cdform.cdform_id, cdform.name , cdform.codename, cdform.taborder FROM cdform, pform WHERE 
        cdform.cdform_id = pform.cdform_id AND pclass ='$pclass' AND pid = $pid 
        GROUP BY cdform.cdform_id ORDER BY taborder DESC";
        $res = mysql_query($q);
        
        $tabs = "";
        $k = 1;
        while($r = mysql_fetch_assoc($res)){
            $sel = "";
            if($k == 1){$sel = " class=\"selected\" "; $k++;}
            $tabs .= "<li $sel><a href=\"#{$r["codename"]}\"><em>{$r["name"]}</em></a></li>";        
        }
        if ( mysql_numrows($res) > 0){
        mysql_data_seek($res,0);
        }
        
        $iframes = "";
        
        while($cdf = mysql_fetch_assoc($res)){   
        
            $this->complete_model($cdf["cdform_id"]); 
            $this->myform->list_model["filter"]["where"] = "cdform_id = ".$cdf["cdform_id"];
            $this->myform->list_model["filter"]["pclass"] = $pclass;
            $this->myform->list_model["filter"]["pid"] = $pid;
            $list = $this->myform->generate_grid();
            
            $iframes .= "
                <div id=\"{$cdf["codename"]}\">
                    <p>
                        $list
                    </p>               
                </div>";    
        }
                    
        $if = "
                <div id=\"childTab-cdf\" class=\"yui-navset\">
                        <ul class=\"yui-nav\">
                            $tabs                
                        </ul>
                        <div class=\"yui-content\">
                            $iframes                                 
                        </div>
                </div>
                <script>
                (function() {
                        var childTab = new YAHOO.widget.TabView('childTab-cdf');
                    })();
                </script> 
                ";    
        return $add_form.$if;
    }


}


?>