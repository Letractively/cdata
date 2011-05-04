<?php
/*
 * Created on 20-8-2007
 *
 */


class Field extends Controller {
	
	
	// user object model vars
	var $search_model = array();
	var $data_model = array();	
	var $form_model = array();		
	var $view_model = array();
	var $list_model = array();
	var $object = "field";	
	var $permission_object = "db";
		
	
	
	function Field()
	{	
		parent::Controller();
		$this->load->library("form");
		$this->load->library("cdata_user");
		$this->load->library("layout");
		$this->load->library("relation");
		
		// data model
		$this->data_model = array(
		'fields' => array(
			"cdform_id" => array(
    			"type" => "integer"
    			),
    		"sort" => array(
    			"type" => "integer"
    			),
    		"model_name" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
			"model_type" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
			"view_label" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"view_inlist" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
            "view_type" => array(
                "type" => "text",
                "serialized" => "true"
                ),
    		"form_type" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_unit" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_label" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_tab" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_required" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_min" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_max" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_size" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_editor" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_rows" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_cols" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_help" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_multiple" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_interface" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_interface_align" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_null" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_source_type" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_source_query_table" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"form_select_source_query_id" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"form_select_source_query_label" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"form_select_source_query_sortby" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"form_select_source_query_order" => array(
    			"type" => "text",
    			"serialized" => "true"
    		),
    		"form_select_source_lookupid" => array(
    			"type" => "text",
    			"serialized" => "true"
    			),
    		"form_select_source_codes" => array(
    			"type" => "text",
    			"serialized" => "true"
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
    		"model_name" => array(
    			"type" => "text",
    			"label" => "Model name",
    			"tab" => "model"
    			),
    		"sort" => array(
    			"type" => "integer",
    			"label" => "Sort",
    			"tab" => "model"
    			),
			"model_type" => array(
    			"type" => "select",
    			"label" => "Model type",
    			"tab" => "model"
    			),
			"view_label" => array(
    			"type" => "text",
    			"label" => "Label",
    			"tab" => "view"
    			),
    		"view_type" => array(
    			"type" => "select",
    			"label" => "Type",
    			"tab" => "view"
    			),
            "view_inlist" => array(
                "type" => "select",
                "label" => "Show column in form list",
                "tab" => "view"
                ),
    		"form_label" => array(
    			"type" => "text",
    			"label" => "Label",
    			"tab" => "form"
    			),
    		"form_type" => array(
    			"type" => "select",
    			"label" => "Type",
    			"tab" => "form"
    			),   
    		"form_required" => array(
    			"type" => "select",
    			"label" => "Required",
    			"tab" => "form"
    			), 		
    		"form_unit" => array(
    			"type" => "text",
    			"label" => "Unit of measurement",
    			"tab" => "form"
    			),
    		"form_tab" => array(
    			"type" => "select",
    			"label" => "Tab",
    			"tab" => "form"
    			),    		
    		"form_min" => array(
    			"type" => "text",
    			"label" => "Min value",
    			"tab" => "form"
    			),
    		"form_max" => array(
    			"type" => "text",
    			"label" => "Max value",
    			"tab" => "form"
    			),
    		"form_size" => array(
    			"type" => "select",
    			"label" => "Required",
    			"tab" => "form"
    			),
    		"form_editor" => array(
    			"type" => "select",
    			"label" => "HTML Editor",
    			"tab" => "form"
    			),
    		"form_rows" => array(
    			"type" => "integer",
    			"label" => "Rows",
    			"tab" => "form"
    			),
    		"form_cols" => array(
    			"type" => "integer",
    			"label" => "Columns",
    			"tab" => "form"
    			),
    		"form_help" => array(
    			"type" => "text",
    			"label" => "Help",
    			"tab" => "form"
    			),
    		"form_select_interface" => array(
    			"type" => "select",
    			"label" => "Select Interface",
    			"tab" => "lookup"
    			),
    		"form_select_multiple" => array(
    			"type" => "select",
    			"label" => "Multiple values",
    			"tab" => "lookup"
    			),
    		
    		"form_select_interface_align" => array(
    			"type" => "select",
    			"label" => "Alignment",
    			"tab" => "lookup"
    			),
    		"form_select_null" => array(
    			"type" => "select",
    			"label" => "Select null value",
    			"tab" => "lookup"
    			),
    		"form_select_source_type" => array(
    			"type" => "select",
    			"label" => "Select Source Type",
    			"tab" => "lookup"
    			),
    		"form_select_source_query_table" => array(
    			"type" => "text",
    			"label" => "Query Table",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_id" => array(
    			"type" => "text",
    			"label" => "Query ID field",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_label" => array(
    			"type" => "text",
    			"label" => "Query Label field",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_sortby" => array(
    			"type" => "text",
    			"label" => "Query Sortby field",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_order" => array(
    			"type" => "text",
    			"label" => "Query Order field",
    			"tab" => "lookup"
    		),
    		"form_select_source_lookupid" => array(
    			"type" => "select",
    			"label" => "Lookup Table",
    			"tab" => "lookup"
    			),
    			"code" => array(
    			"type" => "insertion",
    			"label" => "Codes",
    			"tab" => "lookup",
    			"content" => '
<form>
Code:<input type="text" id="id" name="id" value="" /> Label:<input type="text" id="label" name="label" value="" />
<input type="button" value="Add" name="add" onclick="code.add()" />
</form>
<div id="listDiv">
<table id="list"  border="1" width="200px">
</table>
<input type="button" value="Save Changes" name="add" onclick="code.save()" />
</div>
				'
    		  ),
    		/*"form_select_source_codes" => array(
    			"type" => "text",
    			"label" => "Codes",
    			"tab" => "lookup"
    			)
*/
    		),
    	"view" => array(
    		"theme" => "default",
    		"tab" => array(
				"model" => "Model",
				"view" => "View",
				"form" => "Form",
				"lookup" => "Lookup",
				)    	
    		)
		);
		
		// form model
        $this->form_model = array(
		"fields" => array(
			"cdform_id" => array(
    			"type" => "hidden"
    			),    		
    		"model_name" => array(
    			"type" => "text",
    			"label" => "Name",
    			"tab" => "model",
    			"required" => "true"
    			),
    		"sort" => array(
    			"type" => "integer",
    			"label" => "Sort",
    			"tab" => "model",
    			"required" => "true"
    			),
			"model_type" => array(
    			"type" => "select",
    			"label" => "Model type",
    			"tab" => "model",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array("null" => "Only label", "text" => "Text", "integer" =>"Integer", "float" => "Float", "date" => "Date")
    				)
    				
    			  )
    			),
			"view_label" => array(
    			"type" => "text",
    			"label" => "Label",
    			"tab" => "view",
    			"required" => "true"
    			),
    		"view_type" => array(
    			"type" => "select",
    			"label" => "Type",
    			"tab" => "view",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(    						
    						"text" => "Text", 
    						"textarea" => "Textarea", 
    						"html" => "Html", 
    						"integer" => "Integer", 
    						"float" => "Float", 
    						"date" => "Date", 
    						"checkbox" => "Single Checkbox", 
    						"select" =>"Select",
    						"label" => "Label" )
    				)
    				)
    			),
            "view_inlist" => array(
                "type" => "select",
                "label" => "List column",
                "tab" => "view",
                "select" => array(
                    "multiple" => "false",
                    "null_value" => "true",
                    "interface" => "list", 
                    "source" => array(
                        "type" => "array",
                        "options" => array(
                            "false" => "No", 
                            "true" => "Yes")
                    )
                    )
                ),
    		"form_label" => array(
    			"type" => "text",
    			"label" => "Label",
    			"tab" => "form",
    			"required" => "true"
    			),
    			
    		"form_type" => array(
    			"type" => "select",
    			"label" => "Type",
    			"tab" => "form",
    			"required" => "true",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "false",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(    						
    						"text" => "Text", 
    						"textarea" => "Textarea", 
    						"integer" => "Integer", 
    						"float" => "Float", 
    						"date" => "Date", 
    						"select" =>"Select",
                            "checkbox" => "Single Checkbox", 
    						"label" => "Label")
    				)
    				)
    			),
    		
    		"form_unit" => array(
    			"type" => "text",
    			"label" => "Unit of measurement",
    			"tab" => "form"
    			),
    		"form_tab" => array(
    			"type" => "select",
    			"label" => "Tab",
    			"tab" => "form"
    			),
    		"form_required" => array(
    			"type" => "select",
    			"label" => "Required",
    			"tab" => "form",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"false" => "No", 
    						"true" => "Yes")
    				)
    				)
    			),
    		"form_min" => array(
    			"type" => "integer",
    			"label" => "Min value",
    			"tab" => "form"
    			),
    		"form_max" => array(
    			"type" => "integer",
    			"label" => "Max value",
    			"tab" => "form"
    			),
    		"form_size" => array(
    			"type" => "integer",
    			"label" => "Input size",
    			"tab" => "form"
    			),
    		"form_editor" => array(
    			"type" => "select",
    			"label" => "HTML Editor",
    			"tab" => "form",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"false" => "No", 
    						"true" => "Yes")
    				)
    				)
    			),    		
    		"form_rows" => array(
    			"type" => "integer",
    			"label" => "Rows",
    			"tab" => "form"
    			),
    		"form_cols" => array(
    			"type" => "integer",
    			"label" => "Columns",
    			"tab" => "form"
    			),
    		"form_help" => array(
    			"type" => "textarea",
    			"label" => "Help",
    			"tab" => "form",
    			"cols" => "40",
    			"rows" => "5"
    			),
    		"form_select_interface" => array(
    			"type" => "select",
    			"label" => "Select Interface",
    			"tab" => "lookup",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"list" => "Dropdown", 
    						"checkbox" => "Checkbox",
    						"radio" => "Radio"
    						)
    				)
    				)
    			),
    		"form_select_multiple" => array(
    			"type" => "select",
    			"label" => "Multiple values",
    			"tab" => "lookup",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"false" => "No", 
    						"true" => "Yes")
    				)
    				)
    			),
    		
    		"form_select_interface_align" => array(
    			"type" => "select",
    			"label" => "Alignment",
    			"tab" => "lookup",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"orizontal" => "Orizontal", 
    						"vertical" => "Vertical"
    						)
    				)
    				)
    			),
    		"form_select_null" => array(
    			"type" => "select",
    			"label" => "Select null value",
    			"tab" => "lookup",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"false" => "No", 
    						"true" => "Yes")
    				)
    				)
    			),
    		"form_select_source_type" => array(
    			"type" => "select",
    			"label" => "Select Source Type",
    			"tab" => "lookup",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "array",
    					"options" => array(
    						"array" => "Code List", 
    						"lookup" => "Lookup Table",
    						"query" => "Query")
    				)
    			)
    		),
    		"form_select_source_query_table" => array(
    			"type" => "text",
    			"label" => "Query Table",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_id" => array(
    			"type" => "text",
    			"label" => "Query ID field",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_label" => array(
    			"type" => "text",
    			"label" => "Query Label field",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_sortby" => array(
    			"type" => "text",
    			"label" => "Query Sortby field",
    			"tab" => "lookup"
    		),
    		"form_select_source_query_order" => array(
    			"type" => "text",
    			"label" => "Query Order field",
    			"tab" => "lookup"
    		),
    		"form_select_source_lookupid" => array(
    			"type" => "select",
    			"label" => "Lookup Table",
    			"tab" => "lookup",
    			"select" => array(
    				"multiple" => "false",
    				"null_value" => "true",
    				"interface" => "list", 
    				"source" => array(
    					"type" => "query",
    					"table" =>"lookuptable",
    					"id" => "lookuptable_id",
    					"label" => "name",
    					"sortby" => "name",
    					"order" => "ASC"
    				)
    			)
    		  ),
    		  "code" => array(
    			"type" => "insertion",
    			"label" => "Codes",
    			"tab" => "lookup",
    			"content" => '
<form>
Code:<input type="text" id="id" name="id" value="" /> Label:<input type="text" id="label" name="label" value="" />
<input type="button" value="Add" name="add" onclick="code.add()" />
</form>
<div id="listDiv">
<table id="list"  border="1" width="200px">
</table>
<input type="button" value="Save Changes" name="add" onclick="code.save()" />
</div>
				'
    		  ),
    		  "form_select_source_codes" => array(
    			"type" => "hidden"
    			)
    		),
    	"form" => array(
    		"name" => "{$this->object}",
    		"method" => "post",
    		"action" => "",    		
			"theme" => "default",
			"tab" => array(
				"model" => "Model",
				"view" => "View",
				"form" => "Form",
				"lookup" => "Lookup"
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
			"sort" => array(
    			"header" => "Sort",
    			"type" => "text"
    			),
			"model_name" => array(
    			"header" => "Name",
    			"type" => "text"
    			),
    		"view_label" => array(
    			"header" => "Label",
    			"type" => "text"
    			)
    		),
    	"grid" => array(
    		"op" => array(    			
    			"edit" => array(
    				"link" => "#",
    				"onclick" => "myedit(field_id);return false;"
    			),
    			"delete" => array(
    				"link" => "#",
    				"onclick" => "mydelete(field_id);"
    			),
    			"id" => $this->object."_id"
    		),
    		"filter" => array(    			
    			"maxrows" => "all",
    			"ajaxmaxrows" => "10",
    			"default_sort" => "ORDER BY fdate DESC"
    		),
    		"table" => $this->object,
    		"base_url" => site_url($this->object."/xlist"),
    		"theme" => "default",
    		"target" => ""
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
	
	function xgrid($cdformid){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->list_model["filter"]["where"] = "cdform_id = $cdformid";
		$this->form->list_model["filter"]["orderby"] = "sort ASC";
		$data['grid'] = $this->form->generate_grid();
		
		$this->layout->main = $this->load->view($this->object."/xgrid",$data,true);	
		$this->layout->render_page("iframe");
		
	}
	
	function xlist($pclass = "", $pid = ""){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$page = 1;
		$this->form->list_model["filter"]["pclass"] = $pclass;
		$this->form->list_model["filter"]["pid"] = $pid;
		$data['search'] = $this->form->generate_search($page);
		$data['grid'] = $this->form->generate_grid($page);
		$this->layout->main = $this->load->view($this->object."/xgrid", $data, true);	
		$this->layout->render_page("iframe");
		
	}
	
	
	function create($cdformid = null){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
        $this->form->form_data["cdform_id"] = $cdformid;
        $this->form->form_model["form"]["cancelUrl"] = site_url($this->object."/create/$cdformid");
        $this->loadTabList($cdformid);
		if (isset($_REQUEST['cdform_id'])) {
			$this->form->form_data = $_REQUEST;
			if ($this->form->form_check()){		
                $id = $this->form->add_data();
                redirect($this->object."/create/".$cdformid);  
			}
		} 
		$data["cdformid"] = $cdformid;
		$this->layout->main = $this->load->view($this->object."/create",$data,true);	
		$this->layout->render_page("iframe");	
	}

	
	
	function xsearch(){		
		print $this->form->generate_search();
		
	}
	
	function complete_model($cdform){
		
		$qf = "SELECT * FROM cdform WHERE cdform_id = $cdform";
		$fr = mysql_query($qf);
		$f = mysql_fetch_assoc($fr);
		$fs = unserialize($f["data"]);
		
		$s = "\$dm = array(".$fs["data_model"].");".
		"\$vm = array(".$fs["view_model"].");".
		"\$fm = array(".$fs["form_model"].");".
		"\$tabm = array(".$fs["tab"].");";
		//print($s); exit;
		eval($s);
        while (list($key, $value) = each($dm)) {
          $element =& $dm[$key];
          $element["serialized"]= "true";
        }
		$this->form->data_model["fields"]= array_merge($this->form->data_model["fields"], $dm);
		$this->form->view_model["fields"]= array_merge($this->form->view_model["fields"], $vm);
		$this->form->form_model["fields"]= array_merge($this->form->form_model["fields"], $fm);
		if(!empty($tabm)){
    		$this->form->form_model["form"]["tab"]= $tabm;
    		$this->form->view_model["view"]["tab"]= $tabm;
		}
		if(!empty($fs["theme_view"]) AND $fs["use_theme_view"]>""){
    		$this->form->view_model["view"]["theme"]= $fs["theme_view"];
		}
		if(!empty($fs["theme_form"]) AND $fs["use_theme_form"]>""){
			
			$pclass = "<?php print \$data['pclass_input'];?>\n";
			$pid = "<?php print \$data['pid_input'];?>\n";
			$cid = "<?php print \$data['cdform_id_input'];?>\n";
			$t = $pclass.$pid.$cid.$fs["theme_form"];
    		$this->form->form_model["form"]["theme"]= $t;
		}
	}
	
	function read_cdform($id){
		$q = "SELECT cdform_id FROM pform WHERE pform_id = $id";
		$r = mysql_fetch_assoc(mysql_query($q));
		return $r["cdform_id"];
	}
	
	
	function edit($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");	
		$this->form->read_data($id);			
		$cid = $this->form->form_data["cdform_id"];
		$this->loadTabList($cid);
		$this->form->form_model["form"]["cancelUrl"] = site_url($this->object."/create/$cid");
		if (isset($_REQUEST['cdform_id'])) {
			$this->form->form_data = $_REQUEST;
			if ($this->form->form_check()){		
                $id = $this->form->save_data($id);
                redirect($this->object."/create/".$cid);  
			}
		} 
		$data["id"] = $id;
		$this->layout->main = $this->load->view($this->object."/edit",$data,true);	
		$this->layout->render_page("iframe");
	}

	
	function delete($id){
		
		$this->cdata_user->check_permission($this->permission_object, "admin");
		$this->form->delete_data($id);
		//redirect($this->object."/xgrid");
        print "Field Deleted";
	}
	
	function loadTabList($id){
		$q = "SELECT data FROM cdform WHERE cdform_id = $id";
		$r = mysql_fetch_assoc(mysql_query($q));
		$d = unserialize($r["data"]);
		$tab = $d["tab"];
		$m = '$s = array('."\n".
    				'"multiple" => "false",'."\n".
    				'"null_value" => "true",'."\n".
    				'"interface" => "list",'."\n".
    				'"source" => array('."\n".
    					'"type" => "array",'."\n".
    					'"options" => array('.$tab.')));';
    	eval($m);
    	$this->form->form_model["fields"]["form_tab"]["select"] = $s;
	}
}


?>