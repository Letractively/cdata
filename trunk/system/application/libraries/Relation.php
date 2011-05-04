<?php


class Relation {
	
	var $model = array();
	var $object_table = array();
	var $form;
    var $fprefix = "cf"; //column name prefix to avoid sql reserved word errors
	
	function Relation(){
		
		$this->object_table = array(			
			"db" => array(
				"name" => "Database",
				"table" => "db",
				"id" => "db_id",
				"pathName" => "name"
				),
			"patient" => array(
				"name" => "Patient",
				"table" => "patient",
				"id" => "patient_id",
				"pathName" => "code"
				),
			"pform" => array(
				"name" => "Form",
				"table" => "pform",
				"id" => "pform_id",
				"pathName" => "title"
				),
			"file" => array(
				"name" => "File",
				"table" => "file",
				"id" => "file_id",
				"pathName" => "name"
				),
			"page" => array(
				"name" => "Page",
				"table" => "page",
				"id" => "page_id",
				"pathName" => "title"
				),
			"link" => array(
				"name" => "Link",
				"table" => "link",
				"id" => "link_id",
				"pathName" => "title"
				),
			"project" => array(
				"name" => "Project",
				"table" => "project",
				"id" => "project_id",
				"pathName" => "title"
				),
			"todo" => array(
				"name" => "Todo",
				"table" => "todo",
				"id" => "todo_id",
				"pathName" => "title"
				),
			"folder" => array(
				"name" => "Folder",
				"table" => "folder",
				"id" => "folder_id",
				"pathName" => "name"
				),
			"event" => array(
				"name" => "Event",
				"table" => "event",
				"id" => "event_id",
				"pathName" => "title"
				)
		);
		
		$this->model = array(
			"root" => array(
				"db" => array(
					"card" => "many"
					),
				"project" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),
				"page" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),	
				"file" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)						
				),
			"db" => array(
				"patient" => array(
					"card" => "many"
					),	
				"project" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),	
				"file" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),	
				"page" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)					
				),	
			"patient" => array(	
                "pform" => array(
                    "card" => "many"
                    ),    
				"folder" => array(
					"card" => "many"
					),							
				"project" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),					
				"file" => array(
					"card" => "many"
					),
				"page" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),	
				"event" => array(
					"card" => "many"
					)		
				),
			"pform" => array(
				"pform" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),
				"page" => array(
					"card" => "many"
					),	
				"event" => array(
					"card" => "many"
					)			
				),
			"file" => array(
				"folder" => array(
					"card" => "many"
					),	
				"page" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)					
				),
			"page" => array(
				"page" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)			
				),
			"link" => array(
				"page" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)			
				),
			"project" => array(
				"db" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"page" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)							
				),
			"folder" => array(
                "folder" => array(
                    "card" => "many"
                    ),		
                "pform" => array(
                    "card" => "many"
                    ),
				"project" => array(
					"card" => "many"
					),					
				"page" => array(
					"card" => "many"
					),
				"todo" => array(
					"card" => "many"
					),
				"link" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)
				),
			"todo" => array(
				"todo" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),	
				"page" => array(
					"card" => "many"
					),				
				"link" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)
				),
			"event" => array(
				"todo" => array(
					"card" => "many"
					),
				"folder" => array(
					"card" => "many"
					),	
				"page" => array(
					"card" => "many"
					),				
				"link" => array(
					"card" => "many"
					),
				"file" => array(
					"card" => "many"
					),
				"event" => array(
					"card" => "many"
					)
				)
		);
		
		$CI =& get_instance();
        $CI->load->library('form');
        $this->form =& $CI->form;
        $CI->load->library('cdata_user');
        $this->user =& $CI->cdata_user;        
        $this->config =& $CI->config;
        $this->rootClass = "root";
	}
	
	function get_child_class_array($objclass){
		$r = array();		
		foreach($this->model[$objclass] as $key => $prop){
			$id = $key;
			$label = $this->object_table[$key]["name"];
			$r[$id] = $label; 
		}
		return $r;
	}
	
	function get_child_class_select($objclass, $name = "child_select"){
		$c = $this->get_child_class_array($objclass);
		$r = $this->form->utils_generate_select($c, $name);
		$tabs = "";
					
		return $r;
	}
	
	
	function getChildCount($pclass, $pid, $class){
		
		$table = $this->object_table[$class]["table"];
		$q = "SELECT COUNT(*) AS tot FROM $table WHERE pclass = '$pclass' AND pid = $pid";
		$res = mysql_fetch_assoc(mysql_query($q));
		return  $res["tot"];		
	}
	
	// return print version html code for child nodes navigation interface        
	function getChildInterface($oclass = "root", $id = "0"){
        
		$c = $this->get_child_class_array($oclass);
		//$select = $this->form->utils_generate_select($c, $name);
		$tabs = "";
		$k = 1;
		foreach($c as $class => $label){
			$sel = "";
			$tot = $this->getChildCount($oclass, $id, $class);
			if($k == 1){$sel = " class=\"selected\" "; $k++;}
			$tabs .= "<li $sel><a href=\"#$class\"><em>$label [$tot]</em></a></li>";		
		}
		$iframes = "";
		$childUrlBase = site_url("");
		$CI =& get_instance();
		
		foreach($c as $class => $label){	
			$CI->load->model($class."model");
			$list = $CI->{$class."model"}->grid($oclass, $id);
            
            // call custom interface
            if (method_exists($CI->{$class."model"},"childInterface")){
                $list =   $CI->{$class."model"}->childInterface($oclass, $id);
                $iframes .= "
                <div id=\"$class\">
                    <p>
                        $list
                    </p>               
                </div>";
            }   
            else  { 
            $iframes .= "
				<div id=\"$class\">
					<p><input type=\"button\" value=\"Add\" 
						onClick=\"location.href = '{$childUrlBase}/{$class}/xcreate/{$oclass}/{$id}';\"/>
					</p>
					<p>
						$list
					</p>               
	            </div>";	
            }
		}
					
		$if = "
                <div id=\"childTab\" class=\"yui-navset\">
                        <ul class=\"yui-nav\">
                			$tabs                
                        </ul>
                        <div class=\"yui-content\">
                            $iframes                                 
                        </div>
                </div>
                <script>
                (function() {
                        var childTab = new YAHOO.widget.TabView('childTab');
                    })();
                </script> 
                ";	
         return $if;
          
	}
	
    
    // return print version html code for child nodes navigation interface
    function getChildInterface_print($oclass = "root", $id = "0"){
        $c = $this->get_child_class_array($oclass);
        $page = "";
        $CI =& get_instance(); 
        foreach($c as $class => $label){
            $sel = "";
            $tot = $this->getChildCount($oclass, $id, $class);
            if ($tot > 0){
                $page .= "<h3>$label [$tot]</h3>";
                $CI->load->model($class."model");
                $list = $CI->{$class."model"}->grid_print($oclass, $id);
                $page .= $list;
            }
        }        
        return $page;        
    }
    
    
	function get_classid($class){
		return $this->object_table[$class]["id"];
	}
	
	function get_class($classid){
		foreach($this->object_table as $key => $prop){
			if($prop["id"] == $classid){
				return $key;
				break;
			}
		}
	}
	
	function add_data($pclass, $pid, $cclass, $cid){
		if($pclass > ""){
			$pclassid = $this->get_classid($pclass);
		} else {
			$pclassid = 0;
		}
		if($cclass > ""){
			$cclassid = $this->get_classid($cclass);
		} else {
			$cclassid = 0;
		}
		if(!isset($pid)){
			$pid = 0;
		}
		$q = "INSERT INTO relationship SET 
			pclassid = $pclassid,
			pid = $pid,
			cclassid = $cclassid,
			cid = $cid
			";
		mysql_query($q);	
	}
	
	// return an array with all parent nodes until root
	function getBreadcrumb($class = "root", $id = "0"){
		if($class == "root"){
			return "> <a href=\"".site_url("root/xview/0")."\">Root</a>";
		}
		list($pclass, $pid, $name) = $this->getParentNode($class,$id);
		$p = " > <a href=\"#\">$name</a>";
		$class = $pclass; $id = $pid;		
		while ($class <> $this->rootClass){
			list($pclass, $pid, $name) = $this->getParentNode($class,$id);		
			$p = " > <a href=\"".site_url("$class/xview/$id")."\">$name</a>" . $p;
			$class = $pclass; $id = $pid;			 
		} 
		$p = "> <a href=\"".site_url("root/xview/0")."\">Root</a>" . $p;	
		return $p;
	}
    
    
    // return a string with path
    function getPath($class = "root", $id = "0"){
        if($class == "root"){
            return "";
        }
        list($pclass, $pid, $name) = $this->getParentNode($class,$id);
        $p = "";
        $class = $pclass; $id = $pid;        
        while ($class <> $this->rootClass){
            list($pclass, $pid, $name) = $this->getParentNode($class,$id);        
            $p = "($class-$id)" . $p;
            $class = $pclass; $id = $pid;             
        }     
        return $p;
    }
	
    
    // return an array with all parent nodes until root in print mode
    function getBreadcrumb_print($class = "root", $id = "0"){
        if($class == "root"){
            return "> <a href=\"root_xview_0.html\">Root</a>";
        }
        list($pclass, $pid, $name) = $this->getParentNode($class,$id);
        $p = " > <a href=\"#\">$name</a>";
        $class = $pclass; $id = $pid;        
        while ($class <> $this->rootClass){
            list($pclass, $pid, $name) = $this->getParentNode($class,$id);        
            $p = " > <a href=\"".$class.'_xview_'.$id.'.html'."\">$name</a>" . $p;
            $class = $pclass; $id = $pid;             
        } 
        $p = "> <a href=\"root_xview_0.html\">Root</a>" . $p;    
        return $p;
    }
    
    	
	function getParentNode($class, $id){
		if(!$class > "" or !$id > ""){
			return array("root", 0, "Root");
		} 
		$title = $this->object_table[$class]["pathName"];
		$q = "SELECT pclass, pid, $title FROM {$this->object_table[$class]["table"]} 
		WHERE {$this->object_table[$class]["id"]} = $id";
		$r = mysql_fetch_array(mysql_query($q));
		return array($r["pclass"], $r["pid"], stripslashes($r[$title])); 
	}
	
	function getFirstParent($sClass, $sId, $pClassF){
		list($pclass, $pid, $title) = $this->getParentNode($sClass, $sId);
		if ($sClass == $pClassF){ // the first parent is itself
			return array($sClass, $sId, $title);
		}
		while ($pclass <> "root"){
			if($pclass == $pClassF){
				return array($pclass, $pid, $title);
			}
			list($pclass, $pid, $title) = $this->getParentNode($pclass, $pid);
		}
		return false;
	}
	
    
    /* 
        return an array with subnodes navigation interface and breadcrumb
    */
	function getViewData($class = "root" , $id = "0"){
		$r = array();
		$r["id"] = $id;
		$r["class"] = $class;
		$r["breadcrumb"] = $this->getBreadcrumb($class, $id);
		$r["childInterface"] = $this->getChildInterface($class, $id);
		return $r;
	}
    
    
    function getViewData_print($class = "root" , $id = "0"){
        $r = array();
        $r["id"] = $id;
        $r["class"] = $class;
        $r["breadcrumb"] = $this->getBreadcrumb_print($class, $id);
        $r["childInterface"] = $this->getChildInterface_print($class, $id);
        return $r;
    }
	
    
	function bookmark($pclass = "root", $pid = "0"){
				
		$user_id = $this->user->get_user_id();
		//checking if it exist already
		$q = "SELECT bookmark_id FROM bookmark WHERE pclass='$pclass' AND pid=$pid AND user_id = $user_id";
		$res = mysql_query($q);
		if (mysql_num_rows($res)>0){print "Bookmark already present!"; exit;}
		// adding bookmark
        list($cl, $id, $name) = $this->getParentNode($pclass,$pid);
        $title = mysql_real_escape_string( "<a href=\"javascript: ajax.open('$pclass','$pid')\">$name</a>");
        $date = $this->form->utils_datetime_to_sql(date("d-m-Y H:i:s"));
        $type = $this->object_table[$pclass]["name"];
        $q = "INSERT INTO bookmark SET 
		pclass = '$pclass',
		pid = $pid,
		user_id = $user_id,
		title = '$title',
		type = '$type',
		created = $date
		";
        if( mysql_query($q)) {
        	print "Bookmark added!";
        } else {
        	print "Error saving data $q";        
        }
	}
	
	
	function delete($class, $id){
        
        if($this->config->item("disable_deletion") == true){
            redirect ("cpage/page/deldisabled");  
        }
		foreach ($this->object_table as $key => $prop) {
			$tid = $prop["id"];
			$tname = $prop["table"];
			$tclass = $key;
			$q = "SELECT $tid FROM $tname WHERE pclass = '$class' AND pid = $id";
			$res = mysql_query($q);
			while($r = mysql_fetch_assoc($res)){
				$this->delete($tclass, $r[$tid]);
			}		
		}
		// delete bookmark
		$q = "DELETE FROM bookmark WHERE pclass = '$class' AND pid = $id";
		mysql_query($q);	
		/*
		$fid = $this->object_table[$class]["id"];
		$tn =  $this->object_table[$class]["table"];
		$q = "DELETE FROM $tn WHERE $fid = $id";
		*/
		//unlink file
		if($class == "file"){
			unlink($this->config->item("fileDir").$id);	
		}
		mysql_query($q);	
		// delete subscription
		$q = "DELETE FROM subscription WHERE pclass = '$class' AND pid = $id";
		mysql_query($q);	
		$fid = $this->object_table[$class]["id"];
		$tn =  $this->object_table[$class]["table"];
		$q = "DELETE FROM $tn WHERE $fid = $id";
		//unlink file
		if($class == "file"){
			@unlink($this->config->item("fileDir").$id);	
		}
		mysql_query($q);			
	}
	
    
	function log($type = null, $class=null, $id=0, $action=null, $user=0, $message=null){
		$date =  $this->form->utils_datetime_to_sql(date("d-m-Y H:i:s"));	
		$q = "INSERT INTO log SET type = '$type', class = '$class', id = $id, 
		action = '$action', user_id = $user, message = '$message', created = $date";
		mysql_query($q);
		// notify users
		if($action == "add" OR $action == "edit"){
			$users = $this->subscriptionUsers($class, $id);
			$txtclass = $this->object_table[$class]["name"];
			$smessage  = "<b>Subscription notification</b><br/><br/>";
			$smessage .= "<b>Operation</b>:$action<br/>";
			$smessage .= "<b>Content</b>:$txtclass<br/>";
			$smessage .= "<b>Title</b>:$message<br/>";
			$smessage .= "<b><a href=\"".site_url("$class/xview/$id")."\">Link</a></b><br/>";
			$this->notifyUsers($users, "Subscription Notification",$smessage );
		}	
        
        //release lock
        if ($action == "edit"){
        
            $this->releaseLock($class, $id);
        
        }	
	}
	
	
	function subscriptionUsers($class, $id){
		
		$CI =& get_instance();
		$CI->load->model('subscriptionmodel');
        $this->subscription =& $CI->subscriptionmodel;
        //notify this node subscriptions
        $users = array();
        $users = $this->subscription->usersNode($class, $id);		
		while ($class <> $this->rootClass){
			list($pclass, $pid, $name) = $this->getParentNode($class,$id);		
			$users = array_merge($users, $this->subscription->usersNode($pclass, $pid, "1"));
			$class = $pclass; $id = $pid;			 
		} 
		return $users;       
		
	}
	
	
	function notifyUsers($users, $subject, $message){
		
		if (sizeof($users)==0){
			return;
		}
		$CI =& get_instance();
		$config['mailtype'] = 'html';
		$CI->load->library('email');	
		$CI->email->initialize($config);	
		$fromEmail = $CI->config->item("app_email");
		$fromName = $CI->config->item("app_email_name");		
		$CI->email->subject($CI->config->item("cdata_website_name").": $subject");
		$CI->email->message($message);
		$CI->email->from($fromEmail, $fromName);
		foreach($users as $userid){
			$email = $this->user->get_user_email($userid);
			$CI->email->to($email);
			$CI->email->send();		
		}
			
	}
	
	function nodeExist($class, $id){

		$fid = $this->object_table[$class]["id"];
		$tn =  $this->object_table[$class]["table"];
		$q = "SELECT $fid FROM $tn WHERE $fid = $id";
		$rs = mysql_query($q);
		if (mysql_num_rows($rs)>0){
			return true;
		} else {
			return false;
		}
				
	}
	
	
	function changeParent($class, $id, $pclass, $pid){

		$fid = $this->object_table[$class]["id"];
		$tn =  $this->object_table[$class]["table"];
		$q = "UPDATE $tn SET pclass = '$pclass', pid = $pid WHERE $fid = $id";
		$rs = mysql_query($q);
				
	}
    
    
    function updateDataTable(){
        
        $CI =& get_instance();
        $CI->load->model('patientmodel');
        $pm =& $CI->patientmodel;
        
        
        // patient table
        // load cdform data
        $qd = "DROP TABLE IF EXISTS data_patient";
        mysql_query($qd);
        
        //complete patient table
        $cols = "";
        foreach($pm->myform->form_model["fields"] as $key => $prop){
            $type = "";
            $name = preg_replace("/[^a-z\d]/i", "", $key);
            switch ($prop["type"]) {
                case "integer": $type = "INT";
                break;
                case "float": $type = "DOUBLE";
                break;
                case "text": $type = "TEXT";
                break;
                case "datetime": $type = "DATETIME";
                break;
                case "date": $type = "DATE";
                break;   
                case "select": $type = "TEXT";
                break; 
                default : $type = "TEXT";
            }
            $cols .= $name." ".$type." NULL, ";                       
        }
        
        $qc = "CREATE TABLE data_patient (
            id INT NOT NULL AUTO_INCREMENT,
            path VARCHAR(200) NULL, 
            patient_id INT,
            $cols 
            PRIMARY KEY (id)
            )";
        mysql_query($qc);
        $error .= mysql_error();
        
        
        //add data
        $qpf = "SELECT * from patient";      
        $pfs = mysql_query($qpf);
        while ($pf = mysql_fetch_assoc($pfs)){

            $pm->myform->read_data($pf["patient_id"]);  
            $update = "INSERT INTO data_patient SET "; 
            $update .= "pclass = '".$pm->myform->form_data["pclass"]."', ";
            $update .= "pid = ".$pm->myform->form_data["pid"].", ";
            $update .= "path = '".$this->getPath("patient", $pf["patient_id"])."', ";
            $update .= "patient_id = '".$pm->myform->form_data["patient_id"]."', ";
            foreach($pm->myform->view_model["fields"] as $key => $prop){
                $name = preg_replace("/[^a-z\d]/i", "", $key);
                $value = $pm->myform->form_data[$key];
                $type = $prop["type"]; 
                $sqlv = "";
                switch ($type){
                    case 'integer':
                        if($value > ''){
                            $sqlv = $value;
                        } else {
                            $sqlv = "NULL";
                        }
                    break;
                    case 'float':
                        if($value > ''){
                            $sqlv = $value;
                        } else {
                            $sqlv = "NULL";
                        }
                    break;
                    case 'datetime':
                        if($value > ''){
                            $sqlv = "'".$value."'";
                        } else {
                            $sqlv = "NULL";
                        }
                    break;
                    case 'date':
                        if($value > ''){
                            $sqlv = "'".$value."'";
                        } else {
                            $sqlv = "NULL";
                        }
                    break;
                    case 'blob':
                        $sqlv = "'".$value."'";
                    break;  
                    case 'select':
                            if($value > ''){
                                $sqlv = "'".$pm->myform->format_data_view($value,$type,$key)."'";
                            } else {
                                $sqlv = "NULL";
                            }
                        break;
                    default: $sqlv = "'".mysql_escape_string($value)."'";
                }                      
                $update .= $name." = ".$sqlv.", ";                     
            }
            $update = substr($update, 0 , strlen($update) -2);
            mysql_query($update);
        }
        $error .= mysql_error();
            
            
        //select cdform
        $qcdform = "SELECT cdform_id, name, version, teaser FROM cdform";
        $cdforms = mysql_query($qcdform);
        $CI->load->model('pformmodel');
        $pfm =& $CI->pformmodel;
        
        while ($cdf = mysql_fetch_assoc($cdforms)){ 
            
            $pfm->complete_model($cdf["cdform_id"]);
            $vtype=array();
            // table column name could be different than keys
            foreach ($pfm->myform->view_model["fields"] as $key => $prop){
                $vtype[preg_replace("/[^a-z\d]/i", "", $key)] = $prop["type"];
            }
            // load cdform data
            $qd = "DROP TABLE IF EXISTS data_cdform_".$cdf['cdform_id'];
            mysql_query($qd);
            
            //complete tables
            $cols = "";
            
            foreach($pfm->myform->form_model["fields"] as $key => $prop){
                $type = "";
                $name = preg_replace("/[^a-z\d]/i", "", $key);
                $name = $this->fprefix.$name;
                switch ($prop["type"]) {
                    case "integer": $type = "INT";
                    break;
                    case "float": $type = "DOUBLE";
                    break;
                    case "text": $type = "TEXT";
                    break;
                    case "datetime": $type = "DATETIME";
                    break;
                    case "date": $type = "DATE";
                    break;    
                    case "select": $type = "TEXT";
                    break; 
                    default : $type = "TEXT";
                }
                $cols .= $name." ".$type." NULL, ";                       
            }
            //print $cdf["name"]."<br>".$cols."<br>"."<br>"."<br>";
            $qc = "CREATE TABLE data_cdform_".$cdf['cdform_id']." (
                id INT NOT NULL AUTO_INCREMENT,
                ".$this->fprefix."cdform_id INT NULL,
                path VARCHAR(200) NULL, 
                $cols 
                PRIMARY KEY (id)
                )";
            mysql_query($qc);
            $error .= mysql_error();

            //insert data
            
            //add data
            $qpf = "SELECT pform_id from pform WHERE cdform_id = ".$cdf["cdform_id"];      
            $pfs = mysql_query($qpf);
            while ($pf = mysql_fetch_assoc($pfs)){
                $pfm->myform->read_data($pf["pform_id"]);  
                $update = "INSERT INTO data_cdform_".$cdf["cdform_id"]." SET "; 
                $update .= $this->fprefix."pclass = '".$pfm->myform->form_data["pclass"]."', ";
                $update .= $this->fprefix."pid = ".$pfm->myform->form_data["pid"].", ";
                $update .= $this->fprefix."cdform_id = '".$cdf["cdform_id"]."', ";
                $update .= "path = '".$this->getPath("pform", $pf["pform_id"])."', ";
                foreach($pfm->myform->view_model["fields"] as $key => $prop){
                    $name = preg_replace("/[^a-z\d]/i", "", $key);
                    $name = $this->fprefix.$name;
                    $value = $pfm->myform->form_data[$key];
                    $type = $prop["type"]; 
                    $sqlv = "";
                    switch ($type){
                        case 'integer':
                            if($value > ''){
                                $sqlv = $value;
                            } else {
                                $sqlv = "NULL";
                            }
                        break;
                        case 'float':
                            if($value > ''){
                                $sqlv = $value;
                            } else {
                                $sqlv = "NULL";
                            }
                        break;
                        case 'datetime':
                            if($value > ''){
                                $sqlv = "'".$value."'";
                            } else {
                                $sqlv = "NULL";
                            }
                        break;
                        case 'date':
                            if($value > ''){
                                $sqlv = $this->dateSql($value);
                            } else {
                                $sqlv = "NULL";
                            }
                        break;
                        case 'select':
                            if($value > ''){
                                $sqlv = "'".$pfm->myform->format_data_view($value,$type,$key)."'";
                            } else {
                                $sqlv = "NULL";
                            }
                        break;
                        case 'blob':
                            $sqlv = "'".$value."'";
                        break;  
                        default: $sqlv = "'".mysql_escape_string($value)."'";
                    }                      
                    $update .= $name." = ".$sqlv.", ";                     
                }
                $update = substr($update, 0 , strlen($update) -2);
                mysql_query($update);
            }
            $error .= mysql_error();
        }
        return $error;

    }
    
    
    
    
    
    function dateSql($date){
    
        if (ereg("[0-9]{1,2}[-/][0-9]{1,2}[-/][0-9]{4}",$date)){
            $date = $this->form->utils_date_to_sql($date);
            return $date;
        } else {
            return "'".$date."'";
        }
    }
    
    function exportXml($class, $id) {
    
    
    $this->updateDataTable();
    
    $CI =& get_instance();
    $CI->load->model('pformmodel');
    $CI->load->model('patientmodel');
    
    $pfm =& $CI->pformmodel;
    $pm =& $CI->patientmodel;
        
    $where = "";
    if($class == "db"){
        $where = "WHERE path LIKE '%(db-$id)%'";
    }
    
    if($class == "patient"){
        $where = "WHERE patient_id = $id";
    }
    $DB_TBLName = "data_patient";                
    $sql = "Select * from $DB_TBLName $where";
    $result = @mysql_query($sql)
        or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

    $file_type = "vnd.ms-excel";
    $file_ending = "xml";


    //header info for browser: determines file type ('.doc' or '.xls')
    header("Content-Type: application/$file_type");
    header("Content-Disposition: attachment; filename=cdata-export.$file_ending");
    header("Pragma: no-cache");
    header("Expires: 0");

    //start of printing column names as names of MySQL fields
    $colnames = "<Row>\n";
    for ($i = 0; $i < mysql_num_fields($result); $i++)
    {
        $colnames .= '<Cell><Data ss:Type="String">'.mysql_field_name($result,$i).'</Data></Cell>'."\n";
    }
    $colnames .= "</Row>\n";
    //end of printing column names

    //start while loop to get data
    $data = "";
    $type=array();
    // table column name could be different than keys
    foreach ($pm->myform->view_model["fields"] as $key => $prop){
        $type[$this->fprefix.preg_replace("/[^a-z\d]/i", "", $key)] = $prop["type"];
    }
    while($row = mysql_fetch_row($result))
    {
        $data .= "<Row>\n";
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
            //$meta = mysql_fetch_field($result, $j);
            //$t = $type[preg_replace("/[^a-z\d]/i", "", $meta->name)];
            $data .= '<Cell><Data ss:Type="String">'.
            htmlentities($row[$j]).'</Data></Cell>'."\n";
        }
        $data .= "</Row>\n";
    }
    
    //select cdform
    $qcdform = "SELECT cdform_id, name FROM cdform";
    $cdforms = mysql_query($qcdform);
    
    $wsh = "";
    // for each cdform
    if($class == "patient"){
        $where = "WHERE path LIKE '%(patient-$id)%'";
    }
    while ($cdf = mysql_fetch_assoc($cdforms)){
        
        $qpf = "Select * from data_cdform_".$cdf["cdform_id"]." $where";
        $pfs = mysql_query($qpf);
        if(mysql_num_rows($pfs) == 0){
            continue;
        }
        
        $wsh .= '<Worksheet ss:Name="'.$cdf["name"].'">
          <Table x:FullColumns="1"
           x:FullRows="1" ss:DefaultRowHeight="15">';
        // load model
        $pfm->complete_model($cdf["cdform_id"]);
        $type=array();
        // table column name could be different than keys
        foreach ($pfm->myform->view_model["fields"] as $key => $prop){
            $type[$this->fprefix.preg_replace("/[^a-z\d]/i", "", $key)] = $prop["type"];
        }
        
        
        
        //start of printing column names as names of MySQL fields
        $wsh .= "<Row>\n";
        for ($i = 0; $i < mysql_num_fields($pfs); $i++)
        {
            $wsh .= '<Cell><Data ss:Type="String">'.mysql_field_name($pfs,$i).'</Data></Cell>'."\n";
        }
        $wsh .= "</Row>\n";
        
        //start while loop to get data
        while($row = mysql_fetch_row($pfs))
        {
            $wsh .= "<Row>\n";
            for($j=0; $j<mysql_num_fields($pfs);$j++)
            {
                //$meta = mysql_fetch_field($pfs, $j);
                //$t = $type[preg_replace("/[^a-z\d]/i", "", $meta->name)];
                $wsh .= '<Cell><Data ss:Type="String">'.htmlentities($row[$j]).'</Data></Cell>'."\n";
            }
            $wsh .= "</Row>\n";
        }
        $wsh .= "</Table></Worksheet>";
    }
            
    
    $tplt = '<?xml version="1.0"?>
    <?mso-application progid="Excel.Sheet"?>
    <Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
     xmlns:o="urn:schemas-microsoft-com:office:office"
     xmlns:x="urn:schemas-microsoft-com:office:excel"
     xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
     xmlns:html="http://www.w3.org/TR/REC-html40">
     <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
      <Author>clemente</Author>
      <LastAuthor>clemente</LastAuthor>
      <Created>2008-10-27T14:16:27Z</Created>
      <Version>12.00</Version>
     </DocumentProperties>
     <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
      <WindowHeight>9945</WindowHeight>
      <WindowWidth>21015</WindowWidth>
      <WindowTopX>360</WindowTopX>
      <WindowTopY>135</WindowTopY>
      <ProtectStructure>False</ProtectStructure>
      <ProtectWindows>False</ProtectWindows>
     </ExcelWorkbook>
     <Styles>
      <Style ss:ID="Default" ss:Name="Normal">
       <Alignment ss:Vertical="Bottom"/>
       <Borders/>
       <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
       <Interior/>
       <NumberFormat/>
       <Protection/>
      </Style>
     </Styles>
     <Worksheet ss:Name="Patient">
      <Table x:FullColumns="1"
       x:FullRows="1" ss:DefaultRowHeight="15">
       '.$colnames.$data.'
      </Table>
     </Worksheet>
     '.$wsh.'
    </Workbook>';
    
    print $tplt;
    exit;
    
    }
    
    
    
    function releaseLock($class, $id){
        
        $q = "DELETE FROM locking WHERE class = '$class' and id = $id";
        $rs = mysql_query($q);
        
    }
	
}
// end class

?>