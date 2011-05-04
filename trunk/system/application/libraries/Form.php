<?php
/**
 * Form
 *
 * An open source library for CodeIgniter application development framework for PHP 4.3.2 or newer and MySql Database
 * Help with HTML Form and CRUD database operation
 *
 * @package        cdata
 * @author        Luigi Clemente
 * @license        http://www.fsf.org/licensing/licenses/lgpl.txt LGPL
 * @version        0.1
 * @filesource
 */



class Form {
    
    var $data_model = array();
    var $list_model = array();
    var $form_model = array();
    var $view_model = array();
    var $search_model = array();
    var $list_data = array();
    var $form_data = array();
    var $form_error = array();
    var $search_data = array();
    var $search_error = array();    
    var $multivalue_separator = " | ";
    var $multivalue_view_separator = ", ";
    var $db;
    var $config = array(
        "form_required_char" => "*",
        "jscript_folder_url" => "",
        "image_folder_url" => "",
        "use_global_db" => "true",
        "use_class_db" => "false",
        "db_host" => "localhost",
        "db_name" => "",
        "db_user" => "",
        "db_password" => "",
        "multivalue_separator" => "|",
        "multivalue_view_separator" => ", ",
        "allowPhp" => true
    );
    
    var $pagination = array(
        "base_url"            => '', // The page we are linking to
        "total_rows"          => '', // Total number of items (database results)
        "per_page"          => 10, // Max number of items you want shown per page
        "num_links"          => 5,  // Number of "digit" links to show before/after the currently viewed page
        "cur_page"          => 0,  // The current page being viewed
        "first_link"          => '&lsaquo; First',
        "next_link"          => '&gt;',
        "prev_link"          => '&lt;',
        "last_link"          => 'Last &rsaquo;',
        "uri_segment"          => 3,
        "full_tag_open"          => '',
        "full_tag_close"          => '',
        "first_tag_open"          => '',
        "first_tag_close"          => '&nbsp;',
        "last_tag_open"          => '&nbsp;',
        "last_tag_close"          => '',
        "cur_tag_open"          => '&nbsp;<b>',
        "cur_tag_close"          => '</b>',
        "next_tag_open"          => '&nbsp;',
        "next_tag_close"          => '&nbsp;',
        "prev_tag_open"          => '&nbsp;',
        "prev_tag_close"          => '',
        "num_tag_open"          => '&nbsp;',
        "num_tag_close"          => ''
        );
    
    
    function Form() {
        $this->db_connect();
        /*
        session_start();
        */
        $CI =& get_instance();
        $CI->load->library('cdata_user');
        $this->config["js"] = $CI->config->item("js_path");
        $this->config["image_folder_url"] = $CI->config->item("images");
        $this->config["allowPhp"] = $CI->config->item("allow_php");
    }
    
    
    // connect to mysql db
    function db_connect(){
        if($this->config["use_global_db"] == "true"){
            return;
        }
        if($this->config["use_class_db"] == "true"){
            $db = mysql_connect($this->config["db_host"], $this->config["db_user"],$this->config["db_password"]) or 
            die ("CDATA Form Class unable to connect to database: ".mysql_error());
            mysql_select_db($this->config["db_name"],$db);
            $this->db = $db;
        }
    }
    
    
    /**
     * Generate the html page with the list of records
     *
     * @access public
     * @return  string
    */
    function generate_list(){        
        $data = array();
        if(
            $this->utils_element("delete", $this->list_model['grid']['op']) OR 
            $this->utils_element("edit", $this->list_model['grid']['op']) OR 
            $this->utils_element("view", $this->list_model['grid']['op'])
        ) {
            $data["opcol"] = "true";
        }
        foreach ($this->list_model['fields'] as $key => $value) {
            //set the width of the column
            $data["fields"][$key]["width"] = $this->utils_element("lenght", $value) > "" ? ' style="width:'.$this->utils_element("lenght", $value).'" ' : "";    
        }
        $data["rows"] = array();
        foreach ($this->list_data as $key => $row) {
            if($this->utils_element("edit", $this->list_model['grid']['op'])){
                $data["rows"][$key]["editurl"] = str_replace(
                $this->list_model['grid']['op']['id'],
                $row[$this->list_model['grid']['op']['id']],
                $this->list_model['grid']['op']['edit']['link']);
                $data["rows"][$key]["editonclick"] = str_replace(
                $this->list_model['grid']['op']['id'],
                $row[$this->list_model['grid']['op']['id']],
                $this->utils_element("onclick", $this->list_model['grid']['op']['edit']));
            }
            if($this->utils_element("view", $this->list_model['grid']['op'])){             
                $data["rows"][$key]["viewurl"] = str_replace(
                $this->list_model['grid']['op']['id'],
                $row[$this->list_model['grid']['op']['id']],
                $this->list_model['grid']['op']['view']['link']);
                $data["rows"][$key]["viewonclick"] = str_replace(
                $this->list_model['grid']['op']['id'],
                $row[$this->list_model['grid']['op']['id']],
                $this->utils_element("onclick", $this->list_model['grid']['op']['view']));
            }
            if($this->utils_element("delete", $this->list_model['grid']['op'])){                
                $data["rows"][$key]["deleteurl"] = str_replace(
                $this->list_model['grid']['op']['id'],
                $row[$this->list_model['grid']['op']['id']],
                $this->list_model['grid']['op']['delete']['link']);
                $data["rows"][$key]["deleteonclick"] = str_replace(
                $this->list_model['grid']['op']['id'],
                $row[$this->list_model['grid']['op']['id']],
                $this->utils_element("onclick", $this->list_model['grid']['op']['delete']));
            }
            if($this->utils_element("target",$this->list_model['grid'])){                
                $data["rows"][$key]["target"] = $this->list_model['grid']['target'];
            }
            foreach ($this->list_model["fields"] as $field => $prop) {
                //for each field in list
                $data["rows"][$key][$field] = $this->format_data_view($this->utils_element($field,$row), $prop["type"], $field);                                           
            }
            $data["rows"][$key]["id"] = $row[$this->list_model['grid']['op']['id']];
            
        }
        $data["fields"] = $this->list_model["fields"];
        $theme = isset($this->list_model["grid"]["theme"]) ? $this->list_model["grid"]["theme"] : "default";
        $page = $this->theme_list($data, $theme);

        return $page;
    }
    
    function utils_striptail($string, $len = 0){
        
        return substr($string, 0, strlen($string) - $len);
    }
    
    function utils_generate_select($options, $name){
        $r = "<select name =\"$name\" id=\"$name\">";
        foreach($options as $key => $label){
            $r .= "<option value=\"$key\">$label</option>";
        }
        $r .= "</select>";
        return $r;
    }
    
    
    /*
     * theming function
     * 
     * $data array
     * 
     * "opcol" = true/ false add a column for edit/view controls
     * "fields" => array of fields name (key) and properties (value) array
     *            "width" = css instruction
     *             "header" = field header
     */
    function theme_list($data, $theme = "default"){        
        $page = "";
        $randid = rand(1, 30000);
        if ($theme == "default"){
            // use yui datatable
            $table = "<div id=\"markup-$randid\">\n";
            $table .= "<table id=\"$randid\">";
            $theader = "<thead>";
            $yuiColDefs = "";
            $yuiFields = "";
            if($data["opcol"] == "true") {
                $theader .= "<th>&nbsp;</th>";
                $yuiColDefs .= "{key:\"op\",label:\"\", sortable:false},";                
                $yuiFields .= "{key:\"op\"},";
            }
            foreach ($data["fields"] as $key => $prop) {
                //set the width of the column
                $type =""; $pars = "";
                switch ($this->utils_element("type",$prop)) {
                
                    case "datetime": $type = "date";
                    //$pars = "parser:YAHOO.util.DataSource.parseDate";
                    break;
                    
                    case "date": $type = "date";
                    //$pars = "parser:YAHOO.util.DataSource.parseDate";
                    break;
                    
                    case "integer": $type = "number";
                    break;
                    
                    case "float": 
                        $type = "number";
                    break;
                    default:
                        $type = "string";
                    
                }
                $theader .= "<th {".$this->utils_element("width",$prop)."}>".$this->utils_element("header",$prop)."</th>";
                $yuiColDefs .= "{key:\"$key\",label:\"".$this->utils_element("header",$prop)."\", sortable:true, type:\"$type\"},";
                $yuiFields .= "{key:\"$key\"},";    
            }
            $yuiColDefs = $this->utils_striptail($yuiColDefs, 1);
            $yuiFields = $this->utils_striptail($yuiFields, 1);
            $yuimaxrows = isset($this->list_model["grid"]["filter"]["yuimaxrows"]) ? $this->list_model["grid"]["filter"]["yuimaxrows"] : 10;
            $table .= $theader."</thead>\n<tbody>";;
            foreach ($data["rows"] as $row) {
                //for each row
                $trow = "<tr>";
                if($data["opcol"] == "true") {
                    // edit view link
                    $edit = ""; $view = ""; $delete = "";
                    if($this->utils_element("editurl", $row)){
                        $edit = '<a target="'.$this->utils_element("target",$row).'" href="'.$row["editurl"].'" onclick="'.$row["editonclick"].'">Edit</a>';}
                    if($this->utils_element("viewurl", $row)){
                        $view = '<a target="'.$this->utils_element("target",$row).'" href="'.$row["viewurl"].'" onclick="'.$row["viewonclick"].'">View</a>';}
                    if($this->utils_element("deleteurl", $row)){
                        $delete = '<a target="'.$this->utils_element("target",$row).'" href="'.$row["deleteurl"].'" onclick="'.$row["deleteonclick"].'">Delete</a>';}
                    $trow = "<td id=\"op\">$edit $view $delete</td>";
                }
                foreach ($data["fields"] as $key => $prop) {
                    $trow .= "<td>".$row[$key]."</td>\n";                            
                }
                $table .= $trow."</tr>\n";
            }
            $table .= "</tbody></table>";
            $table .= "</div>\n";            
            $js ="
<!--<afterbody>-->
<script type=\"text/javascript\">
var yuilist = {
    init: function() {
        var myColumnDefs = [
            $yuiColDefs
        ];

        this.myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get(\"$randid\"));
        this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
        this.myDataSource.responseSchema = {
            fields: [
            $yuiFields
            ]
        };
        var oConfigs = {
                        paginated:true,
                        paginator: {
                            rowsPerPage: $yuimaxrows,
                            dropdownOptions: [10,25,50,100,500]
                        }
                };

        this.myDataTable = new YAHOO.widget.DataTable(\"markup-$randid\", myColumnDefs, this.myDataSource,
                oConfigs);
        }
};

YAHOO.util.Event.addListener(window, \"load\", yuilist.init());

</script>
<!--</afterbody>-->
";
            $page = $table.$js;
        } else {
            // evaluating custom template
            ob_start();
               // start an output buffer
            eval(" ?>".$theme."<?php ");
               // echo some output that will be stored in the buffer
            $page = ob_get_contents();
               // store buffer content in a variable
            ob_end_clean();            
        }

        return $page;
    }
    // end generate_list
    
    
    function generate_grid($page =1){
        $theme = "";
        if(isset($_POST["check"])){$page = 1;}// problem when new search in page>1        
        $filter = $this->generate_filter();
        $pagination = $this->list_prepare($page, $filter);
        $list = $this->generate_list($theme);
        $page = $list."<p>$pagination</p>";
        return $page;
        
    }
    
    function list_prepare($page = 1, $filter){
        
        $where = $filter['where'];
        $sort = $filter['orderby'];
        $grid = $this->utils_element("grid", $this->list_model);
        $maxperpage = (int)$grid['filter']['maxrows'] > 0 ? $grid['filter']['maxrows'] : "all";
        if ( $maxperpage == "all" ) {
            $limit = "";
            $q = "SELECT * FROM ".$grid["table"]." $where";
            $r = mysql_query($q);            
            $totrows = mysql_num_rows($r);            
        } else {
            $q = "SELECT * FROM ".$this->list_model["grid"]["table"]." $where";
            $r = mysql_query($q);    
            $totrows = mysql_num_rows($r);
            if ( !($sort > "") ){$sort = $this->list_model['grid']['filter']['default_sort'];}        
            if ($page == null){
                $limit = "";
            } else {            
                $lastpage = ceil($totrows/$maxperpage);
                $limit = " LIMIT ".($page-1)*$maxperpage.", $maxperpage";
            }
        }
        
        // main query
        $q = $q . " $sort $limit";
        $r = mysql_query($q);

        $this->list_data = array();
        $anyserialized = false;
        foreach($this->list_model["fields"] as $key => $prop){
            if($this->utils_element("serialized", $this->utils_element($key,$this->data_model["fields"])) == "true"){$anyserialized = true; break;}
        }
        if ($anyserialized){
            while ($row = mysql_fetch_array($r))
            {            
                $this->list_data[] = $this->row_to_array($row);
            }
        } else {
             while ($row = mysql_fetch_array($r))
            {            
                $this->list_data[] = $row;
            }
        }
        $config = array();
        $config['base_url'] = $this->list_model["grid"]["base_url"];
        $config['total_rows'] = $totrows;
        $config['per_page'] = $maxperpage;
        $config['cur_page'] = $page;
        if ( $maxperpage == "all" ) {
            return "";
        } else {
            return $this->pagination($config);         
        }
    }
    
    function generate_filter(){
        $where = "";
        $orderby = "";
        
        if (isset($_POST['check'])) {
            $this->search_data = $_POST;    
            if ($this->search_check()){     
                $where = $this->generate_search_where();
                $orderby = $this->generate_search_orderby();
                $search_data = serialize($this->search_data);
                $filter = array(
                    "where" => $where, 
                    "orderby" => $orderby, 
                    "search_data" => $search_data
                );
            }
        } else {
            if(isset($this->list_model["filter"]["pclass"]) AND isset($this->list_model["filter"]["pid"])){
                $where = " WHERE pclass = '".$this->list_model["filter"]["pclass"]."' AND pid = '".$this->list_model["filter"]["pid"]."' ";         
            }
            if(isset($this->list_model["filter"]["where"])){
                if($where > ""){$a=" AND ";}else{$a=" WHERE ";}
                $where .= $a.$this->list_model["filter"]["where"]." ";     
            }
            if(isset($this->list_model["filter"]["orderby"])){
                $orderby = " ORDER BY ".$this->list_model["filter"]["orderby"]." ";         
            } elseif (isset($this->list_model["grid"]["filter"]["default_sort"])){
                $orderby = " ".$this->list_model["grid"]["filter"]["default_sort"]." "; 
            }
            $filter = array(
            "where" => $where, 
            "orderby" => $orderby,
            "search_data" => ""
            );
        }
        return $filter;
    }
    
    function generate_search(){
        return $this->search();        
    }
    
    
    
    
    // generate search form
    function search(){                
        
        $this->search_data = $_POST;
        $method = 'post';
        $action = '';
        $name = isset($this->search_model['form']['name']) ? $this->search_model['form']['name'] : 'search';
        $page = "";        
        $page .= "<form action=\"$action\" method=\"$method\" id=\"$name\" name=\"$name\" >\n";
        $page .= "<input type=\"hidden\" name=\"check\" value=\"submit\" />\n";
        $table = "<table class=\"cdata_form_table\" >\n";
        $trow = "";
        foreach ($this->search_model["fields"] as $key => $prop) {
            //for each field in the model
            $trow .= "<tr><td class=\"cdata_form_table_label\" >".$prop["label"]."</td><td class=\"cdata_form_table_input\">"; //label
            switch ($prop['type']) {
                case "text":
                    $size = isset($value['size']) ? ' size="'.$value['size'].'" ' : "";
                    $val = isset($this->search_data[$key]) ? $this->search_data[$key] : "";                    
                    $trow .= "<input type=\"text\" name=\"$key\" value=\"$val\" $size />";
                break;
                case "select":
                    $size = isset($value['size']) ? ' size="'.$value['size'].'" ' : "";
                    $val = isset($this->search_data[$key]) ? $this->search_data[$key] : "";                    
                    $trow .= "<input type=\"text\" name=\"$key\" value=\"$val\" $size />";
                break;
            }
            $err = isset($this->form_error[$key]) ? $this->form_error[$key] : "";
            $trow .= "$err</td></tr>\n";            
        }
        // orderby input field
        if (isset($this->search_model["orderby"])){
            $trow .= "<tr><td class=\"cdata_form_table_label\">Order by</td><td  class=\"cdata_form_table_input\">"; //label
            foreach ($this->search_model["orderby"] as $key => $prop){
                $trow .= "<select name=\"".$key."\" />";
                $selected = null;
                $selected[$this->utils_element($key, $this->search_data)] = " selected=\"selected\" "; 
                $trow .= "<option value=\"\" ></option>\n";
                foreach ($prop["options"] as $opkey => $oplabel) 
                {
                    $trow .= "<option value=\"{$opkey}\" ".$this->utils_element($opkey, $selected).">{$oplabel}</option>\n";    
                }        
                $trow .= "\t</select>";
                // sort
                $trow .= "<select name=\"".$key."_sort\" />";
                $selected_sort = null;
                $selected_sort[$this->utils_element($key."_sort", $this->search_data)] = " selected=\"selected\" ";
                $trow .= "<option value=\"\" ></option>\n";
                $trow .= "<option value=\"asc\" ".$this->utils_element("asc", $selected_sort).">ASC</option>\n";
                $trow .= "<option value=\"desc\" ".$this->utils_element("desc", $selected_sort).">DESC</option>\n";
                $trow .= "\t</select>";
            }
        }
        $table .= $trow;
        $table .= "<tr><td colspan=\"2\">&nbsp;</td></tr><tr><td colspan=\"2\"><input type=\"submit\" value=\"Search\" name=\"mysubmit\" /> 
        <input type=\"button\" value=\"Reset\" name=\"myreset\" onClick=\"javascript: resetForm('$name');\" /></td></tr>\n";
        $table .= "</table>\n";
        $page .= $table."</form>\n";
        return $page;
    }
    
    function search_check(){
        $ok = true;
        $err = array();
        foreach ($this->search_model['fields'] as $key => $prop) {
            //for each field in the model
            $value = isset($this->search_data[$key]) ? $this->search_data[$key] : "";
        }
        if (!empty($err)){$ok = false;}
        $this->search_error = $err;
        return $ok;
    }
    
    function generate_search_where(){
        $where = "";
        
        foreach ($this->search_model['fields'] as $key => $prop) {
            //for each field in the model
            $value = isset($this->search_data[$key]) ? $this->search_data[$key] : "";
            $wt = "";
            if ($value>"") {                
                if ($prop['type'] == 'text') {
                    $fields = explode(",", $prop['field']);
                    if (count($fields)>1){
                        $wt = "CONCAT(";
                          foreach($fields as $col){
                            $wt .= $col.",";  
                        }
                        $wt = substr($wt,0, strlen($wt)-1).")";
                    } else {
                        $wt = $fields[0];
                    }
                    $wt .= " LIKE '%".$value."%' ";                   
                }      
            }
            if ($wt > ""){ $where .= $wt." AND ";}           
        }
        if (isset($this->list_model["filter"]["pclass"])){
            $where .= "pclass = '".$this->list_model["filter"]["pclass"]."' AND pid = '".$this->list_model["filter"]["pid"]."' AND "; 
        }
        if($where>""){$where = " WHERE ".substr($where,0, strlen($where)-5);}
        return $where;
    }
    
    // generate orderby string
    function generate_search_orderby(){
        $orderby = "";
        if(!isset($this->search_model["orderby"])){return "";}
        foreach ($this->search_model["orderby"] as $key => $prop) {
            //for each field in the model
            $field = isset($this->search_data[$key]) ? $this->search_data[$key] : "";
            if ($field > ""){
                $wt = "$field";
                $sort = isset($this->search_data[$key."_sort"]) ? $this->search_data[$key."_sort"] : "asc";
                $wt .= " $sort";
                $orderby .= $wt.", ";
            }          
        }
        if($orderby >""){$orderby = " ORDER BY ".substr($orderby,0, strlen($orderby)-2);}
        return $orderby;
    }
    
    
    function pagination($params){
        // !! function based on Pagination class in CodeIgniter Framework !!
        
        if (count($params) > 0)
        {
            foreach ($params as $key => $val)
            {
                if (isset($this->pagination[$key]))
                {
                    $this->pagination[$key] = $val;
                }
            }        
        }
        
        // If our item count or per-page total is zero there is no need to continue.
        if ($this->pagination["total_rows"] == 0 OR $this->pagination["per_page"] == 0)
        {
           return '';
        }

        // Calculate the total number of pages
        $num_pages = ceil($this->pagination["total_rows"] / $this->pagination["per_page"]);

        // Is there only one page? Hm... nothing more to do here then.
        if ($num_pages == 1)
        {
            return '';
        }

        // Determine the current page number if config is not set
        /*
        if (!empty($this->cur_page)){
            $CI =& get_instance();    
            if ($CI->uri->segment($this->uri_segment) != 0)
            {
                $this->cur_page = $CI->uri->segment($this->uri_segment);
                
                // Prep the current page - no funny business!
                $this->cur_page = (int) $this->cur_page;
            }
        }*/
                
        if ( !is_numeric($this->pagination["cur_page"]))
        {
            $this->pagination["cur_page"] = 1;
        }
        
        // Is the page number beyond the result range?
        // If so we show the last page
        if ($this->pagination["cur_page"] > $this->pagination["total_rows"])
        {
            $this->pagination["cur_page"] = ($num_pages - 1) * $this->pagination["per_page"];
        }
        
        $uri_page_number = $this->pagination["cur_page"];
        $this->pagination["cur_page"] = floor(($this->pagination["cur_page"]/$this->pagination["per_page"]) + 1);

        // Calculate the start and end numbers. These determine
        // which number to start and end the digit links with
        $start = (($this->pagination["cur_page"] - $this->pagination["num_links"]) > 0) ? $this->pagination["cur_page"] - ($this->pagination["num_links"] - 1) : 1;
        $end   = (($this->pagination["cur_page"] + $this->pagination["num_links"]) < $num_pages) ? $this->pagination["cur_page"] + $this->pagination["num_links"] : $num_pages;

        // Add a trailing slash to the base URL if needed
        $this->base_url = rtrim($this->pagination["base_url"], '/') .'/';

          // And here we go...
        $output = '';

        // Render the "First" link
        if  ($this->pagination["cur_page"] > $this->pagination["num_links"])
        {
            $output .= $this->pagination["first_tag_open"].'<a href="'.$this->pagination["base_url"].'">'.$this->pagination["first_link"].'</a>'.$this->pagination["first_tag_close"];
        }

        // Render the "previous" link
        if  (($this->pagination["cur_page"] - $this->pagination["num_links"]) >= 0)
        {
            $i = $uri_page_number - $this->pagination["per_page"];
            if ($i == 0) $i = '';
            $output .= $this->pagination["prev_tag_open"].'<a href="'.$this->pagination["base_url"].$i.'">'.$this->pagination["prev_link"].'</a>'.$this->pagination["prev_tag_close"];
        }

        // Write the digit links
        for ($loop = $start-1; $loop <= $end; $loop++)
        {
            $i = ($loop * $this->pagination["per_page"]) - $this->pagination["per_page"];
            if ($i >= 0)
            {
                if ($this->pagination["cur_page"] == $loop)
                {
                    $output .= $this->pagination["cur_tag_open"].$loop.$this->pagination["cur_tag_close"]; // Current page
                }
                else
                {
                    $n = ($i == 0) ? '' : $i;
                    $output .= $this->pagination["num_tag_open"].'<a href="'.$this->pagination["base_url"].$n.'">'.$loop.'</a>'.$this->pagination["num_tag_close"];
                }
            }
        }
        // Render the "next" link
        if ($this->pagination["cur_page"] < $num_pages)
        {
            $output .= $this->pagination["next_tag_open"].'<a href="'.$this->pagination["base_url"].($this->pagination["cur_page"] * $this->pagination["per_page"]).'">'.$this->pagination["next_link"].'</a>'.$this->pagination["next_tag_close"];
        }

        // Render the "Last" link
        if (($this->pagination["cur_page"] + $this->pagination["num_links"]) < $num_pages)
        {
            $i = (($num_pages * $this->pagination["per_page"]) - $this->pagination["per_page"]);
            $output .= $this->pagination["last_tag_open"].'<a href="'.$this->pagination["base_url"].$i.'">'.$this->pagination["last_link"].'</a>'.$this->pagination["last_tag_close"];
        }

        // Kill double slashes.  Note: Sometimes we can end up with a double slash
        // in the penultimate link so we'll kill all double slashes.
        $output = preg_replace("#([^:])//+#", "\\1/", $output);

        // Add the wrapper HTML if exists
        $output = $this->pagination["full_tag_open"].$output.$this->pagination["full_tag_close"];
        
        return $output;        
        
    }
    
    
    // format data to be visualized in a form
    function format_data_form($value, $type = "text"){
        if(!isset($value)){return "";}
        if($value == ""){return "";}
        $r = "";
        // normal visualisation
        switch ($type) {
            case "text":
                $r = htmlentities(stripslashes($value));
            break;
            case "textarea":
                $r = htmlentities(stripslashes($value));
            break;
            case "html":
                $r = htmlentities(stripslashes($value));
            break;
            case "datetime":
                if(isset($_POST["submit"])){
                    $r = $value;
                } else {
                    //first load from database
                    $r = $this->utils_mysqldatetime_to_text($value);
                }
            break;
            case "date":
                if(isset($_POST["submit"])){
                    $r = $value;
                } else {
                    //first load from database
                    $r = $this->utils_mysqldate_to_text($value);
                }
            break;
            default:
                $r = $value;
            break;
        }
        return $r;
    }
    
    
    function create(){
        
        if (isset($_REQUEST['submit'])) {
            $this->form_data = $_REQUEST;
            
            if ($this->form_check()){                
                // save data
                $id = $this->add_data();
                print mysql_error();
                return $id;
            }
        }
        return false;
    }
    
    function edit($id){
        
        if (isset($_REQUEST['submit'])) {
            $this->form_data = $_REQUEST;
            
            if ($this->form_check()){                
                // save data
                $sql = $this->save_data($id);
                return true;
            } 
        } else {
            $this->read_data($id);            
        }
        return false;
    }
    
    /**
     * Generate html code for the editing form
     *
     * @access public
     * @return  string
    */
    function generate_form(){                
        
        $page = "";
        $elements = "";
        $table = "";
        $delete = "";
        
        if (empty($this->form_data)){
            $this->form_data = $_REQUEST;
        }
        $mform = $this->utils_element("form", $this->form_model);
        $method = $this->utils_element("method",$mform, "post");
        $action = $this->utils_element("action", $mform, "");
        $name = $this->utils_element("name", $mform, "form1");
        $multipart = $this->utils_element("upload", $mform) == "true" ? "enctype=\"multipart/form-data\"" : "";        
        
        // adding editor
        foreach ($this->utils_element("fields", $this->form_model) as $key => $prop) {
            if($this->utils_element("editor", $prop) == "true" AND $this->utils_element("type", $prop) == "textarea"){$elements .= $key.",";}         
        }
        if($elements>""){$elements = $this->utils_striptail($elements,1);}
        $page .= "<script language=\"javaScript\" type=\"text/javascript\" >\n".
        "tinyMCE.init({
             theme : \"advanced\",
             /*width: \"100%\", adapt to textarea width*/
             mode: \"exact\",
             elements : \"$elements\"
        });
        </script>\n";
        
        $form_err = isset($this->form_error["form"]) ? "<b style=\"color:red;\">".$this->form_error["form"]."</b><br/><br/>\n" : "";
        if ($this->form_model["form"]["locking"] == "true"){
            $page .= "
            
            
            <h4><span style=\"color: red\">This form has been locked by you for 15 minutes starting from</span></h4>
            <h4><script language=\"javascript\">
ourDate = new Date();
document.write(\"Time and date at your computer's location is: \"
+ ourDate.toLocaleString()
+ \".<br/>\");
</script></h4>
            <p>Please <b>submit</b> the form within 15 minutes or press <b>cancel</b> 
            to release the lock. <b>Do not use the browser back button or close the page without releasing the form</b>.</p>";
        }
        $page .= "<form action=\"$action\" method=\"$method\" name=\"$name\" id=\"$name\" $multipart class=\"cdata_form\">\n";
        $page .= $form_err;
        $data = array();
        $date_fields = array();
        
        foreach ($this->form_model["fields"] as $key => $prop) {
            //for each field in the model    
                    
            // ERROR MESSAGE         
            $data[$key."_error"] = isset($this->form_error[$key]) ? $this->form_error[$key] : "";
            if (isset($this->form_error[$key])){
                $data[$key."_error_popup"] = " <a href=\"\" onclick=\"return false\" 
                onmouseover=\"return escape('".htmlentities($this->form_error[$key])."')\">
                <img style=\"vertical-align: middle;\" src=\"".$this->config["image_folder_url"]."error-icon.jpg\"/></a> ";
            } else {
                $data[$key."_error_popup"] = "";
            }
            if ($this->utils_element("help", $prop) > ""){
                $data[$key."_help"] = 
                "<a href=\"\" onclick=\"return false\" onmouseover=\"return escape('".htmlentities($prop["help"])."')\">
                <img style=\"vertical-align: middle;\" src=\"".$this->config["image_folder_url"]."qms.png\"/></a> ";
            } else {
                $data[$key."_help"] = "";
            }
            if ($this->utils_element("unit", $prop) > ""){
                $data[$key."_unit"] = " [".$prop["unit"]."]";
            }else {
                $data[$key."_unit"] = "";
            }
            
            // LABEL
            $data[$key."_label"] = $this->utils_element("label",$prop); 
            
            $size = "";  
            $dval= $this->utils_element($key, $this->form_data);
            $val = ""; 
            $data[$key."_required"] = $this->utils_element("required",$prop) == "true" ? $this->config["form_required_char"] : "";    
            switch ($prop['type']) {            
                case "text":
                    $size = isset($prop['length']) ? ' size="'.$prop['length'].'" ' : "";
                    $val = $this->format_data_form($dval, "text");                  
                    $data[$key."_input"] =  "<input type=\"text\"  id=\"$key\" name=\"$key\" value=\"$val\" $size />";
                break;
                case "label":                
                    $data[$key."_input"] =  "";
                break;
                case "hidden":                
                    $data[$key."_input"] =  "<input type=\"hidden\"  id=\"$key\" name=\"$key\" value=\"".htmlspecialchars($dval)."\" />";
                break;
                case "integer":
                    $size = isset($prop['length']) ? ' size="'.$prop['length'].'" ' : "";
                    $val = $this->format_data_form($dval, "integer");                  
                    $data[$key."_input"] =  "<input type=\"text\"  id=\"$key\" name=\"$key\" value=\"$val\" $size />";
                break;
                case "float":
                    $size = isset($prop['length']) ? ' size="'.$prop['length'].'" ' : "";
                    $val = $this->format_data_form($dval, "float");                  
                    $data[$key."_input"] =  "<input type=\"text\"  id=\"$key\" name=\"$key\" value=\"$val\" $size />";
                break;
                case "datetime":
                    $size = isset($prop['length']) ? ' size="'.$prop['length'].'" ' : "";
                    $val = $this->format_data_form($dval, "datetime", $key);                  
                    $data[$key."_input"] =  "<input type=\"text\"  id=\"$key\" name=\"$key\" value=\"$val\" $size />";
                break;
                case "date":
                    $size = isset($prop['length']) ? ' size="'.$prop['length'].'" ' : "";
                    $val = $this->format_data_form($dval, "date", $key);                  
                    $data[$key."_input"] =  "<input type=\"text\" id=\"$key\" name=\"$key\" value=\"$val\" $size />";
                    $date_fields[] = $key;
                break;
                case "textarea":
                    if($this->utils_element("cols", $prop) == ""){$prop["cols"] = 50;}
                    if($this->utils_element("rows", $prop) == ""){$prop["rows"] = 15;}  
                    $width = isset($prop['cols']) ? $prop['cols']*10 : 500;
                    $rows = isset($prop['rows']) ? ' rows="'.$prop['rows'].'" ' : ' rows="15" ';
                    $cols = isset($prop['cols']) ? ' cols="'.$prop['cols'].'" ' : ' cols="60" ';
                    $val = $this->format_data_form($dval, "text", $key); 
                    if ($val == ""){$val = $this->utils_element("default", $prop);}                
                    $data[$key."_input"] = "<textarea style=\"width: {$width}px\" name=\"$key\" id=\"$key\" $rows $cols >$val</textarea>";
                break;
                case "password":
                    $size = isset($prop['length']) ? ' size="'.$prop['length'].'" ' : "";
                    $val = $this->format_data_form($dval, "text", $key);   
                    $data[$key."_input"] = "<input type=\"password\"  id=\"$key\" name=\"$key\" value=\"$val\" $size />";
                break;
                case "upload":
                    $data[$key."_input"] = "<input type=\"file\" name=\"$key\" id=\"$key\" size=\"50\">";
                break;
                case "select":
                    $val = isset($dval) ? $dval : "";
                    $values = $this->multival_to_array($val);
                    
                    // select control
                    $if = $prop["select"]["interface"] > "" ? $prop["select"]["interface"] : "list";
                    if($if == "list"){
                        $selected = array(); 
                        if($values > ""){         
                            foreach($values as $val)
                            {
                                $selected[trim($val)] = "selected=\"selected\"";    
                            }
                        }
                        if ($prop["select"]["multiple"] == "true") 
                        {
                            $square = "[]"; 
                            $hmultiple = "multiple=\"multiple\"";
                            if(isset($prop["select"]["size"])){
                                $size = " size=\"".$prop["select"]["size"]."\" ";
                            }
                        } else {
                            $square = ""; 
                            $hmultiple = "";
                        }
                        $t = "<select name=\"{$key}$square\"  id=\"$key\" $hmultiple $size>\n";
                        if($this->utils_element("null_value",$prop["select"]) == "true"){
                            $t .= "<option value=\"\" ></option>\n";
                        }
                        $options = $this->select_option_array($key);
                        foreach ($options as $opkey => $oplabel) 
                        {
                            $t .= "<option value=\"{$opkey}\" ".$this->utils_element($opkey,$selected).">{$oplabel}</option>\n";    
                        }        
                        $t .= "\t</select>";
                    }
                    if($if == "checkbox"){
                        $selected = array(); 
                        if($values > ""){         
                            foreach($values as $val)
                            {
                                $selected[trim($val)] = "checked=\"checked\"";    
                            }
                        }
                        $options = $this->select_option_array($key);
                        $align = isset($prop["select"]["align"]) ? $prop["select"]["align"] : "orizontal";
                        if($align == "vertical"){$nl = "<br/>";} else {$nl = "&nbsp;";}    
                        $t = "";   
                        if($this->utils_element("nul_value",$prop["select"]) == "true"){
                            $t .= "<input type=\"checkbox\"  name=\"{$key}[]\" value=\"\" /> Null $nl\n";    
                        }              
                        foreach ($options as $opkey => $oplabel) 
                        {
                            $t .= "<input type=\"checkbox\"  name=\"{$key}[]\" value=\"$opkey\" ".$this->utils_element($opkey,$selected)."/> $oplabel $nl\n";    
                        }                            
                    }
                    if($if == "radio"){
                        $selected = array();
                        if($values > ""){        
                            foreach($values as $val)
                            {
                                $selected[trim($val)] = "checked=\"checked\"";    
                            }
                        }
                        $options = $this->select_option_array($key);
                        $align = isset($prop["select"]["align"]) ? $prop["select"]["align"] : "orizontal";
                        if($align == "vertical"){$nl = "<br/>";} else {$nl = "&nbsp;";}     
                        $t = ""; 
                        if($prop["select"]["null_value"] == "true"){
                            $t .= "<input type=\"radio\"  name=\"{$key}[]\" value=\"\" /> Null $nl\n";    
                        }                
                        foreach ($options as $opkey => $oplabel) 
                        {
                            $t .= "<input type=\"radio\"  name=\"{$key}[]\" value=\"$opkey\" ".$this->utils_element($opkey, $selected)."/>$oplabel $nl\n";    
                        }                            
                    }
                    $data[$key."_input"] = $t;
                break;
                case "checkbox":
                    $checked = $dval > "" ? "checked = \"checked\"" : "";                    
                    $data[$key."_input"] =  "<input type=\"checkbox\"  id=\"$key\" value=\"$key\" name=\"$key\" $checked />\n";
                break;
                case "insertion":
                    $data[$key."_input"] = $prop["content"];
                break;
            }                        
        }
        // buttons
        $table .= "<br/></br>";
        $cancel = isset($this->form_model["form"]["cancelUrl"]) ? 
        "location.href = '".$this->form_model["form"]["cancelUrl"]."';" :
        "";

        if (!isset($this->form_model["form"]["submit_buttons"]) OR $this->form_model["form"]["submit_buttons"] == false){
            $table .= "<input type=\"submit\" onClick=\"document.getElementById('$name').submit();\" id=\"submit\" value=\"Submit\" name=\"submit\" /> 
            <input type=\"reset\" value=\"Cancel\" name=\"cancel\" onClick=\"$cancel\"/>\n";
        }
        
        $theme = isset($this->form_model["form"]["theme"]) ? $this->form_model["form"]["theme"] : "default";
        // CALL THEMING FUNC *******
        $form = $this->theme_form($data, $theme);
        
        $page .= $form.$table."</form>\n";
        // end form
        /*
        if(isset($this->form_model['form']['delete'])) {
                // delete link
                $delete = str_replace(
                $this->form_model['form']['delete']['id'],
                $this->form_data[$this->form_model['form']['delete']['id']],
                $this->form_model['form']['delete']['link']);  
                $delete = '<a href="'.$delete.'" onClick="return(checkOkDelete());">Delete</a>';
            }
        $page .= "<p>".$delete."</p>";
        */
        
        //date picker code
        $idlist = "";
        if(!empty($date_fields)){
            $idlist = "";
            foreach($date_fields as $id){
                $idlist .= "'".$id."' ,";
            }
            $idlist = substr($idlist, 0, strlen($idlist)-2);
        }
        $page .= "<div id=\"cal1Container\"></div>\n
            <style type=\"text/css\" media=\"screen\">
                    #cal1Container {
                        position: absolute;
                        display: none;
                    }
                    p, #cal1Container {
                        margin: 1em;
                    }                  
                    #cal1Container {
                        z-index: 500;
                    }
                    .dp-highlighter {
                        z-index: 1;
                    }
            </style>

            <script type=\"text/javascript\">
            var cal1;
            var over_cal = false;
            var cur_field = '';
            function init() {
                cal1 = new YAHOO.widget.Calendar(\"cal1\",\"cal1Container\");
                cal1.selectEvent.subscribe(getDate, cal1, true);
                cal1.renderEvent.subscribe(setupListeners, cal1, true);
                YAHOO.util.Event.addListener([$idlist], 'focus', showCal);
                YAHOO.util.Event.addListener([$idlist], 'blur', hideCal);
                cal1.render();
                //dp.SyntaxHighlighter.HighlightAll('code'); 
            }
            
            function setupListeners() {
                YAHOO.util.Event.addListener('cal1Container', 'mouseover', overCal);
                YAHOO.util.Event.addListener('cal1Container', 'mouseout', outCal);
            }
            
            function getDate() {
                    var calDate = this.getSelectedDates()[0];
                    calDate = calDate.getDate() + '/' + (calDate.getMonth() + 1)  + '/' + calDate.getFullYear();
                    cur_field.value = calDate;
                    over_cal = false;
                    hideCal();
            }
            
            function showCal(ev) {
                var tar = YAHOO.util.Event.getTarget(ev);
                cur_field = tar;
                var xy = YAHOO.util.Dom.getXY(tar);
                //var date = YAHOO.util.Dom.get(tar).value;
                var date = null;
                if (date) {
                    cal1.cfg.setProperty('selected', date);
                    cal1.cfg.setProperty('pagedate', new Date(date), true);
                    cal1.render();
                } else {
                    cal1.cfg.setProperty('selected', '');
                    cal1.cfg.setProperty('pagedate', new Date(), true);
                    cal1.render();
                }
                YAHOO.util.Dom.setStyle('cal1Container', 'display', 'block');
                xy[1] = xy[1] + 20;
                YAHOO.util.Dom.setXY('cal1Container', xy);
            }
            
            function hideCal() {
                if (!over_cal) {
                    YAHOO.util.Dom.setStyle('cal1Container', 'display', 'none');
                }
            }
            
            function overCal() {
                over_cal = true;
            }
            
            function outCal() {
                over_cal = false;
            }
            
            YAHOO.util.Event.addListener(window, 'load', init);
            </script>            
                ";
        return $page;
    }
    // end generate_form
    
    
    function theme_form($data, $theme = "default"){                
        
        $page = ""; // output
        $rid = rand(1, 9000); //rand id for tab div
        // first the hidden fields
        foreach ($this->form_model["fields"] as $key => $prop) {
            if($prop["type"] == "hidden"){
            $page .= $data[$key."_input"]."\n";                            
            }
        }
        // no user theme
        if ($theme == "default"){            
            
            // fields that don't have a tab property
            // notab fields
            $tabpage = "<table class=\"cdata_form_table\">\n";
            $anytab = false; //check if there is any fields without tab
            foreach ($this->form_model["fields"] as $key => $prop) {
                if( $prop["type"] == "hidden"){continue;} //already there 
                if( !isset($prop["tab"]) OR $prop["tab"] == ""){
                    // LABEL + INPUT
                    $required_char = $this->utils_element("required",$prop) == "true" ? $this->config["form_required_char"] : "";
                    $tabpage .= "<tr><td class=\"cdata_form_table_label\">".
                    $this->utils_element($key."_label",$data)." ".$this->utils_element($key."_unit",$data).
                    " {$this->utils_element($key."_required",$data)}</td>
                    <td class=\"cdata_form_table_input\">".
                    $this->utils_element($key."_input",$data)." ".$this->utils_element($key."_error_popup",$data)."</td></tr>\n";     
                    $anytab = true;
                }        
            }
            $tabpage .= "</table>\n";
            $tabpage .= "<br/><br/>";
            if ($anytab){ $page .= $tabpage;}//we add notab table
            
            $tab = isset($this->form_model["form"]["tab"]) ? $this->form_model["form"]["tab"] : "";
            // form tabs
            if($tab > ""){
                // tab navigation
                $page .= "
                <div id=\"$rid\" class=\"yui-navset\">
                    <ul class=\"yui-nav\">\n";
                $k = 0;
                foreach ( $tab as $key => $label ){
                    $sel ="";
                    if($k == 0){$sel = " class=\"selected\" "; $k++;}
                    $page .= "<li $sel><a href=\"#$key-tab\"><em>$label</em></a></li>";               
                }
                $page .= "</ul>";
                // tab content
                $page .= "<div class=\"yui-content\">\n";
                foreach ( $tab as $tkey => $tlabel ){
                    $page .= "<div id=\"$tkey-tab\">\n";
                    $page .= "<table class=\"cdata_form_table\">\n";
                    // field rows
                    foreach ($this->form_model["fields"] as $key => $prop) {
                        
                        if( $prop["type"] == "hidden"){continue;}
                        // if the field is in this tab
                        if( $this->utils_element("tab",$prop) == $tkey ){
                            $page .= "<tr><td class=\"cdata_form_table_label\">".
                            $data[$key."_label"].$this->utils_element($key."_unit",$data).
                            "{$this->utils_element($key."_required",$data)}".$this->utils_element($key."_help",$data)."</td>
                            <td class=\"cdata_form_table_input\">".$data[$key."_input"]." ".
                            $this->utils_element($key."_error_popup",$data)."</td></tr>\n";
                        }        
                    }
                    $page .= "</table>\n";
                    $page .= "</div>\n";    
                    //end tab             
                }
                $page .= "</div>\n</div>";    
                //initialise the yui tab                            
                $page .= "<script>
                            (function() {
                                var tabView = new YAHOO.widget.TabView('$rid');                                                    
                            })();
                          </script>";                
            }             
                    
        } else {            
            // evaluating custom template
            ob_start();
               // start an output buffer
            eval(" ?>".$theme."<?php ");
               // echo some output that will be stored in the buffer
            $page = ob_get_contents();
               // store buffer content in a variable
            ob_end_clean();            
        }

        return $page;
    }
    // end generate_form
    

    
    function select_option_array($field){
        $source = $this->form_model["fields"][$field]["select"]["source"];
        if ($source["type"] == "query"){
            $q = "SELECT * FROM ".$source["table"]." ORDER BY ".$source["sortby"]." ".$source["order"];
            $r = mysql_query($q);
            $arr = array();
            while ($row = mysql_fetch_array($r)){
                $arr[$row[$source["id"]]] = $row[$source["label"]];        
            }            
            return $arr;
        }
        if ($source["type"] == "array"){
            return $source["options"];
        }
        if ($source["type"] == "lookup"){
            $q = "SELECT * FROM lookupcode WHERE lookuptable_id = ".$source["lookup_id"].
            " ORDER BY level ASC";
            $r = mysql_query($q);
            $arr = array();
            while ($row = mysql_fetch_array($r)){
                $arr[$row["code"]] = $row["label"];        
            }            
            return $arr;
        }
        
        
    }
    
    function multival_to_array($val){
        if($val == ""){return "";}
        if(is_array($val)){return $val;}
        return explode($this->config["multivalue_separator"], $val);
        
    }
    
    
    // check form values based on rules in form_model
    function form_check(){
        $ok = true;
        $err = array();
        if (empty($this->form_data)){
            $this->form_data = $_POST;
        }
        foreach ($this->form_data as $key => $value){            
            if(is_string($this->form_data[$key])){
                 $form_data[$key] = trim($value);
            }
        }
        foreach ($this->form_model['fields'] as $key => $prop) {
            //for each field in the model
            $value = isset($this->form_data[$key]) ? $this->form_data[$key] : "";
            $err[$key] = "";
            if ($prop["type"] == "upload"){
                if($prop["required"] == "true" AND !($_FILES[$key]['size'] > 0)){                    
                    $err[$key] .= "Required field/";
                }
                if ($err[$key] == ""){unset($err[$key]);}                
                continue;
            }
            if (isset($prop['required']) and  $prop['required'] == "true" and $value == "")
            {
                    $err[$key] .= "Required field/";                
            }
            elseif ($value > "")
            {
                if (isset($prop['regmatch'])) 
                {
                    $regex = "/".$prop['regmatch']."/";
                    if (!preg_match($regex, $value))
                    {
                        $err[$key] .= "Wrong format/";
                    }
                }
                if ($prop["type"] == "date") 
                {
                    if (!preg_match('/^([1-9]|0[1-9]|[12][0-9]|3[01])[-\/]([1-9]|0[1-9]|1[012])[-\/](19[0-9][0-9]|20[0-9][0-9])$/', $value))
                    {
                        $err[$key] .= "Wrong date format, must be dd[-/]mm[-/]yyyy (1900-2099)<br/>";
                    }
                }
                if ($prop["type"] == "datetime") 
                {
                    if (!preg_match('/^([1-9]|0[1-9]|[12][0-9]|3[01])\D([1-9]|0[1-9]|1[012])\D(19[0-9][0-9]|20[0-9][0-9])\s(([0-9])|([0-1][0-9])|([2][0-3])):(([0-9])|([0-5][0-9])):(([0-9])|([0-5][0-9]))$/', $value))
                    {
                        $err[$key] .= "Wrong datetime format, must be dd-mm-yyyy hh:mm:ss (1900-2099)<br/>";
                    }
                }
                if ($prop["type"] == "integer") 
                {
                    if (!preg_match('/^[-]?[0-9]+$/', $value))
                    {
                        $err[$key] .= " Wrong integer format ";
                    } else {
                        if($this->utils_element("min",$prop)>""){
                            if((int)$value < (int)$prop["min"]){
                                $err[$key] .= " Min value is {$prop["min"]} ";
                            }
                        }
                        if($this->utils_element("max",$prop)>""){
                            if((int)$value > (int)$prop["max"]){
                                $err[$key] .= " Max value is {$prop["max"]} ";
                            }
                        }
                    }
                    
                }
                if ($prop["type"] == "float") 
                {
                    if (!preg_match('/^[-]?[0-9]*[.]?[0-9]+$/', $value))
                    {
                        $err[$key] .= " Wrong float format ";
                    } else {
                        if($prop["min"]>""){
                            if((float)$value < (float)$prop["min"]){
                                $err[$key] .= " Min value is {$prop["min"]} ";
                            }
                        }
                        if($prop["max"]>""){
                            if((float)$value > (float)$prop["max"]){
                                $err[$key] .= " Max value is {$prop["max"]} ";
                            }
                        }
                    }
                }
            }    
            if ($err[$key] == ""){unset($err[$key]);}        
        }
        if (!empty($err)){$ok = false;}
        $this->form_error = $err;
        return $ok;
    }
    
    function add_data(){
        $q = $this->form_add_sql();
        mysql_query($q);        
        return mysql_insert_id();
    }
    
    function save_data($id){
        $q = $this->form_edit_sql($id);
        mysql_query($q);
        return mysql_error();
    }
    
    
    // unserialize column and uppend to array of data
    function row_to_array($row){
        $sercol = $this->utils_element("serialized_column", $this->data_model["table"]);
        if ($sercol > ""){
            $serdata = $this->utils_element($sercol, $row);
            if (is_string($serdata)){$ser = unserialize($serdata);}                    
            if (!empty($ser)){
                $row = array_merge($row, $ser);
            }
        }
        return $row;        
    }
    
    function read_data($id){
        
        $q = "SELECT * FROM ".$this->data_model["table"]["name"]." WHERE ".$this->data_model["table"]["id"]." = $id";
        $r = mysql_query($q);
        $row = mysql_fetch_assoc($r);    
        $this->form_data = $this->row_to_array($row);
    
    }
    
    
    function read_row($row){
    
       $this->form_data = $this->row_to_array($row); 
        
    }
    
    
    function debug_print($s){
        print_r($s);
        exit;
    }
    
    function delete_data($id){
        $q = "DELETE FROM ".$this->data_model["table"]["name"]." WHERE ".$this->data_model["table"]["id"]." = $id";
        mysql_query($q);
        return mysql_error();
    }
    
    
    function form_add_sql(){
        $ok = true;
        $sql = "INSERT INTO ".$this->data_model['table']['name']." SET ";        
        $sql .= $this->prepare_sql_set();    
        return $sql;        
    }
    
    
    function form_edit_sql($id){
        $ok = true;
        $sql = "UPDATE ".$this->data_model['table']['name']." SET ";        
        $sql .= $this->prepare_sql_set($id);        
        $sql .= " WHERE ".$this->data_model['table']['id']." = $id";
        return $sql;
        
    }
    
    
    function prepare_sql_set($id = 0){
        
        $ser = array();
        $sql = "";
        foreach ($this->data_model["fields"] as $key => $prop) {
            // field is not
            //for each field in the model           
            $value = isset($this->form_data[$key]) ? $this->form_data[$key] : null;
            if (!is_null($value)){
                if(is_array($value)){
                    $vs = "";
                    foreach ($value as $v){
                        $vs .= $v.$this->config["multivalue_separator"];
                    }
                    $value = substr($vs, 0, strlen($vs) - strlen($this->config["multivalue_separator"]));
                }
                if ($this->utils_element("serialized", $prop) == "true"){
                    if($prop["type"] == "date"){
                        // reverse the date
                        $value = $this->utils_date_to_sql($value);
                        //delete apostrophe
                        $value = substr($value, 1, strlen($value)-2);
                    }
                    if(get_magic_quotes_gpc()){
                        $ser[$key] = stripslashes($value);
                    } else {
                        $ser[$key] = $value;
                    }
                } else {
                    $sql .= "$key = ".$this->format_data_save($value, $prop["type"]).", ";
                }
            }    
        }
        if (!empty($ser)){
            $serdata = mysql_escape_string(serialize($ser));
            $sql .=  $this->data_model["table"]["serialized_column"]." = '".$serdata."', ";
        }
        $sql = substr($sql, 0 , strlen($sql) -2);
        
        return $sql;
        
    }
    
    function format_data_save($value, $type){
        switch ($type){
                    case 'text':                        
                        $sql = "'".mysql_escape_string($value)."'";
                    break;
                    case 'integer':
                        if($value > ''){
                            $sql = $value;
                        } else {
                            $sql = "NULL";
                        }
                    break;
                    case 'float':
                        if($value > ''){
                            $sql = $value;
                        } else {
                            $sql = "NULL";
                        }
                    break;
                    case 'datetime':
                        if($value > ''){
                            $sql = $this->utils_datetime_to_sql($value);
                        } else {
                            $sql = "NULL";
                        }
                    break;
                    case 'date':
                        if($value > ''){
                            $sql = $this->utils_date_to_sql($value);
                        } else {
                            $sql = "NULL";
                        }
                    break;
                    case 'blob':
                        $sql = "'".$value."'";
                    break;
                }        
        return $sql;    
    }
    
    
    
// format a string to be visualized in a web page
    function format_data_view($value, $type, $key = null){
        if($type == "checkbox" and ($value == "" or !isset($value))){return "No";}        
        if(!isset($value)){return "";}        
        if($value == ""){return "";}
        $r = "";
        switch ($type) {
            case "text":
                $r = htmlentities(stripslashes($value));
            break;
            case "textarea":
                $r = nl2br(htmlentities($value));
            break;
            case "html":
                $r = stripslashes($value);
                if (!$this->config["allowPhp"]){ // strip php
                    $phpcode= array("<?php", "<?", "?>");
                    $r = str_replace($phpcode, "", $r);
                }
            break;
            case "datetime":
                $r = $this->utils_mysqldatetime_to_text($value);
            break;
            case "date":
                $r = $this->utils_mysqldate_to_text($value);
            break;
            case "integer":
                $r = $value;
            break;
            case "float":
                $r = $value;
            break;
            case "checkbox":
                if($value > ""){
                    $r = "Yes";
                }
            break;
            case "select":      
                    $options = $this->select_option_array($key);
                    $va = $this->multival_to_array($value);
                    $v = "";
                    if(is_array($va)){
                        foreach($va as $c){
                            $v .= ($this->utils_element($c, $options)).$this->config["multivalue_view_separator"];
                        }
                    } else {
                        $v = $options[$val];
                    }
                    $r = htmlentities(substr($v, 0, strlen($v) - strlen($this->config["multivalue_view_separator"])));
            break;            
            default:
                $r = $value;
            break;
        }
        return $r;
    }
    
    function generate_view(){                
        if(empty($this->form_data)){return "<h3>Object not found</h3>";}
        $data = array();
        $theme = isset($this->view_model["view"]["theme"]) ? $this->view_model["view"]["theme"] : "default";        
        foreach ($this->view_model["fields"] as $key => $prop) {
            //for each field in the model
            if($this->utils_element("unit",$this->utils_element($key,$this->form_model["fields"]))>""){$data[$key."_unit"] = " [".$this->form_model["fields"][$key]["unit"]."]"; }
            $data[$key."_label"] = $prop["label"];
            $val = $this->utils_element($key, $this->form_data);            
            $data[$key] = $this->format_data_view($val, $prop["type"], $key);        
        }
        $page = $this->theme_view($data, $theme);
        return $page;
    }
    
    
    function theme_view($data, $theme){                
        
        $page = "";
        $rid = 339;
        
        // print view
        
        if ($theme == "print"){
        
            $page .= "<table>\n";
            foreach ($this->view_model["fields"] as $key => $prop) {
                $trow = "<tr><td class=\"label\">".$data[$key."_label"].
                "</td><td>"; //label
                $trow .= $data[$key].$this->utils_element($key."_unit",$data);
                $trow .= "</td></tr>\n";
                $page .= $trow;          
            }
            $page .= "</table>\n";
            return $page;
        } 
        
        // default view
        
        if ($theme == "default"){
            // notab fields
            $tabpage = "<table class=\"cdata_view_table\">\n";
            $anytab = false; //check if there is any fields without tab
            foreach ($this->view_model["fields"] as $key => $prop) {
                if( !isset($prop["tab"]) OR $prop["tab"] == ""){
                    $tabpage .= "<tr><td class=\"cdata_view_table_label\">".$data[$key."_label"].
                    "</td><td class=\"cdata_view_table_value\">"; //label
                    $tabpage .= $data[$key];
                    if($data[$key]>""){$tabpage .= $this->utils_element($key."_unit",$data);}   
                    $tabpage .= "</td></tr>\n";    
                    $anytab = true;
                }        
            }
            $tabpage .= "</table>\n";
            $tabpage .= "<br/><br/>";
            if ($anytab){ $page .= $tabpage;}//we add notab table
            
            $tab = isset($this->view_model["view"]["tab"]) ? $this->view_model["view"]["tab"] : "";
            if($tab > ""){
                $page .= "
                <div id=\"$rid\" class=\"yui-navset\">
                    <ul class=\"yui-nav\">\n";
                $k = 0;
                foreach ( $tab as $key => $label ){
                    $sel ="";
                    if($k == 0){$sel = " class=\"selected\" "; $k++;}
                    $page .= "<li $sel><a href=\"#$key\"><em>$label</em></a></li>";               
                }
                $page .= "</ul>";
                $page .= "<div class=\"yui-content\">\n";
                foreach ( $tab as $tkey => $tlabel ){
                    $page .= "<div id=\"$tkey\">\n";
                    $page .= "<table class=\"cdata_view_table\">\n";
                    foreach ($this->view_model["fields"] as $key => $prop) {
                        if( $this->utils_element("tab", $prop) == $tkey ){
                            $trow = "<tr><td class=\"cdata_view_table_label\">".$data[$key."_label"].
                            "</td><td class=\"cdata_view_table_value\">"; //label
                            $trow .= $data[$key].$this->utils_element($key."_unit",$data);
                            $trow .= "</td></tr>\n";
                            $page .= $trow;        
                        }        
                    }
                    $page .= "</table>\n";
                    $page .= "</div>\n";                
                }
                $page .= "</div>\n</div>";                                
                $page .= "<script>
                            (function() {
                                var tabView = new YAHOO.widget.TabView('$rid');                                                        
                            })();
                            </script>";                
            }            
        } else {
            // evaluating custom template
            if (!$this->config["allowPhp"]){ // strip php
                    $phpcode= array("<?php", "<?", "?>");
                    $theme = str_replace($phpcode, "", $theme);
                }
            ob_start();
               // start an output buffer
            eval(" ?>".$theme."<?php ");
               // echo some output that will be stored in the buffer
            $page = ob_get_contents();
               // store buffer content in a variable
            ob_end_clean();            
        }
        return $page;
    }
    // end generate_view
    
    function utils_date_to_sql($mydate)
    {
        if ($mydate > '') {
            list($day, $month, $year) = split("[ /.-]", $mydate);
            $year2 = $year;
            if ($year<=35){$year2 = '20'.$year;}
            if ($year=="0000"){$year2 = '0000';}
            if ($year<100 and $year>35){$year2 = '19'.$year;}
            return ("'".$year2."-".$month."-".$day."'");
        }
        else {return "NULL";}
    }
    
    function utils_datetime_to_sql($mydatetime)
    {
        list($mydate, $mytime) = split(" ", $mydatetime);    
        if ($mydate > '') {
            list($day, $month, $year) = split("[ /.-]", $mydate);
            $year2 = $year;
            if ($year<=35){$year2 = '20'.$year;}
            if ($year=="0000"){$year2 = '0000';}
            if ($year<100 and $year>35){$year2 = '19'.$year;}
            return ("'".$year2."-".$month."-".$day." $mytime'");
        }
        else {return "NULL";}
    }
    
    function utils_mysqldatetime_to_text($datetime){
        list($date, $hour) = split (" ", $datetime);
        list($year, $month, $day) = split("[ /.-]", $date);
        return ($day."-".$month."-".$year." $hour");
    }
    
    function utils_mysqldate_to_text($date){
        list($year, $month, $day) = split("[ /.-]", $date);
        if(strlen($day) == 4){//date comes from serialized field, not sql
            list($day, $month, $year) = split("[ /.-]", $date);
        }
        return ($day."-".$month."-".$year);
    }    
    
    
    function utils_element($item, $array, $default = FALSE)
    {
        if ( ! isset($array[$item]) OR $array[$item] == "")
        {
            return $default;
        }

        return $array[$item];
    }    
    
    /*****
    * This function calculates the difference between two dates in years, months, days, hours, minutes & seconds
    * The first two arguments are the two dates between which the difference will be calculated
    * The third argument is an optional one and allows for different outputs. By default the output will be a string but
    *    default (not set): output will be a string
    *    'assoc_array'    : output will be an associative array
                  -> ("year"=>x, "month"=>x, "day"=>x, "hour"=>x, "minute"=>x, "second"=>x)
          'array'        : output will a normal array
                  -> (0=>x, 1=>x, 2=>x, 3=>x, 4=>x, 5=>x);
                  => 0==year, 1==month, etc.
    *
    */
        function utils_dateDifference($start, $end, $output="string")
    {
         // converting the dates to seconds
        $startSeconds    = strtotime($start);
        $endSeconds    = strtotime($end);
    
         // if conversion was succesfull
        if ($startSeconds && $endSeconds)
        {
             // switching start and end date if start date is bigger
             // and converting them to 1 standard format for this function, so we know what we're dealing with
            if ($startSeconds > $endSeconds)
            {
                $startDate = date("Y-m-d H:i:s", $endSeconds);
                $endDate = date("Y-m-d H:i:s", $startSeconds);
            }
            else
            {
                $startDate = date("Y-m-d H:i:s", $startSeconds);
                $endDate = date("Y-m-d H:i:s", $endSeconds);
            }
    
             // exploding everything into seperate variabels
            list($startDateDate, $startDateTime) = explode(" ", $startDate);
            list($endDateDate, $endDateTime) = explode(" ", $endDate);
    
            list($startYear, $startMonth, $startDay) = explode("-", $startDateDate);
            list($endYear, $endMonth, $endDay) = explode("-", $endDateDate);
    
            list($startHour, $startMinute, $startSecond) = explode(":", $startDateTime);
            list($endHour, $endMinute, $endSecond) = explode(":", $endDateTime);
    
             // now we can start calculating
             // difference in seconds
            $secondDiff    = $endSecond - $startSecond;
            if ($startSecond > $endSecond)
            {
                 // if the difference is negative, we add 60 seconds and increase the starting minute
                $secondDiff += 60;
                $startMinute++;
            }
            $minuteDiff    = $endMinute - $startMinute;
            if ($startMinute > $endMinute)
            {
                $minuteDiff += 60;
                $startHour++;
            }
            $hourDiff    = $endHour - $startHour;
            if ($startHour > $endHour)
            {
                $hourDiff += 24;
                $startDay++;
            }
    
             // days in starting month
            if ($endMonth > $startMonth || $endYear > $startYear)
            {
                if ($startDay > $endDay)
                {
                     // amount of days this month has
                    $daysThisMonth = date("t", mktime($startMonth, $startDay, $startYear));
                     // difference in days to the next month
                    $dayDiff    = ($daysThisMonth - $startDay) + $endDay;
                     // compensating for the months
                    $startMonth++;
                }
                else
                    $dayDiff = $endDay - $startDay;
            }
            else
            {
                $dayDiff = $endDay - $startDay;
            }
            $monthDiff    = $endMonth - $startMonth;
            if ($startMonth > $endMonth)
            {
                $monthDiff += 12;
                $startYear++;
            }
            $yearDiff    = $endYear - $startYear;
    
    
             // we know all the differences, so we're outputting that
            if ($output == "string")
            {
                if ($yearDiff > 0)
                    return $yearDiff." year, ".$monthDiff." months, ".$dayDiff." days and ".$hourDiff." hours, ".$minuteDiff." minutes, ".$secondDiff." seconds";
                elseif ($monthDiff > 0)
                    return $monthDiff." months, ".$dayDiff." days and ".$hourDiff." hours, ".$minuteDiff." minutes, ".$secondDiff." seconds";
                elseif ($dayDiff > 0)
                    return $dayDiff." days and ".$hourDiff." hours, ".$minuteDiff." minutes, ".$secondDiff." seconds";
                elseif ($hourDiff > 0)
                    return $hourDiff." hours, ".$minuteDiff." minutes, ".$secondDiff." seconds";
                elseif ($minuteDiff > 0)
                    return $minuteDiff." minutes, ".$secondDiff." seconds";
                elseif ($secondDiff > 0)
                    return $secondDiff." seconds";
                else
                    return "There is no difference!";
            }
            elseif ($output == "assoc_array")
            {
                return array("year"=>$yearDiff, "month"=>$monthDiff, "day"=>$dayDiff, "hour"=>$hourDiff, "minute"=>$minuteDiff, "second"=>$secondDiff);
            }
            else
            {
                return array($yearDiff, $monthDiff, $dayDiff, $hourDiff, $minuteDiff, $secondDiff); 
            }
        }
        else
        {
            return False;
        }
    }
    
}


// end class

?>