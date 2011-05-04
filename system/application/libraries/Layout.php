<?php

class Layout {

var $layout_view;
var $header_view;
var $main_view;
var $footer_view;
var $extract_js = false;
var $main = "";
var $js_footer = "";
var $js = "";
var $title = "";
var $footer = "Powered by CDATA - Funded by <a href=\"http://www.cure2children.org\">Cure2Children Foundation</a>";

// var $skin;

   // Class constructor
   function Layout() {

      // NOTE: I like the idea of getting this form a custom config file. See the skins
      // NOTE: ...example to get an idea of how to do it here.
      $this->layout_view   = 'template/default/layout';
      $this->layout_print   = 'template/default/layout_print';    
      $this->layout_view_iframe   = 'template/default/layout_iframe';
      $this->head_view   = 'template/default/head';
      $this->menu_view   = 'template/default/menu';
      $this->main_view     = 'template/default/main';
      $this->footer_view   = 'template/default/footer';

   }
   
    function render_page($layout = "") {
      
      $obj =& get_instance();
      $main_data     = array();
      $footer_data   = array();
      $menu_data 	 = array();
      
      $layout_components['js_footer'] =  "";  
      
      if ($this->isMSIE()){
			$this->extract_js = true;	
	  }
      if ($this->extract_js == true){
      	$code = $this->extract($this->main, "<!--<afterbody>-->", "<!--</afterbody>-->");
      	while ($code > ""){
      		$layout_components["js_footer"] .= $code;
      		$this->main = str_replace("<!--<afterbody>-->".$code."<!--</afterbody>-->", "", $this->main);
      		$code = $this->extract($this->main, "<!--<afterbody>-->", "<!--</afterbody>-->");
      	}
      }
      $data["title"] = $this->title;
      $layout_components["js"] = $this->js; 
      $layout_components['head'] = $obj->load->view($this->head_view, $data, true);
      $layout_components['menu'] = $obj->load->view($this->menu_view, $menu_data, true);
      $layout_components['contents'] = $this->main;
      $layout_components['footer'] =  $this->footer;  
         

      // ///////////////////////////////////////////////////////////////////////
      // Finally, send all the layout components to the layout
      // ///////////////////////////////////////////////////////////////////////
      
      // web view 
      if($layout == ""){
             $obj->load->view($this->layout_view, $layout_components); 
      } 
      
      // iframe view
      if($layout == "iframe"){
      		$obj->load->view($this->layout_view_iframe, $layout_components);
      } 
      
      // print view
      if($layout == "print"){
              $obj->load->view($this->layout_print, $layout_components);
      }
      
   }

	function extract($str, $start, $end){	
	
        $pos_start = strpos($str, $start);
        $pos_end = strpos($str, $end, ($pos_start + strlen($start)));
        if ( ($pos_start !== false) && ($pos_end !== false) )
        {
            $pos1 = $pos_start + strlen($start);
            $pos2 = $pos_end - $pos1;
            return substr($str, $pos1, $pos2); 
        }

	}

	function isMSIE(){
		
		if (strstr($_SERVER['HTTP_USER_AGENT'],"MSIE")){return true;}
		return false;
		
	}

}
?>