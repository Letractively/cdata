<h2>Patient Folder</h2>

    <div id="main" class="yui-navset">
        <ul class="yui-nav">
                <li class="selected"><a href="#view"><em>Main</em></a></li>
                <li><a href="#diary"><em>Diary</em></a></li>
        </ul>
        <div class="yui-content">
            <div id="view">
                <p>
                <?php echo $this->form->generate_view();?>
                </p>
                <p>
                <?php echo anchor("patient/edit/".$id,"Edit"); ?>
                </p>  
            </div>
            <div id="diary">
                  TODO
            </div>
        </div>
    </div>
<script>
    (function() {
        var maintab = new YAHOO.widget.TabView('main');
    })();
</script>
    
       
  <br/>
  <br/>
  
  
  <div id="folder">
      <div id="foldertab" class="yui-navset">
            <ul class="yui-nav">
                <li class="selected"><a href="#form"><em>Forms</em></a></li>
                <li><a href="#file"><em>Files</em></a></li>
                <li><a href="#forum"><em>Forum</em></a></li>
            </ul>            
            <div class="yui-content">
        
<div id="form">
<p>

 

<div id="search"></div>
<script type="text/javascript">
var ajform = {
        init: function() {
           // Grab the elements we'll need.                                                                                                                                      
           ajform.form = document.getElementById('user_search');
           ajform.results_div = document.getElementById('list');              
           
           // Hijack the form.                                                                                                                                                   
           YAHOO.util.Event.addListener(ajform.form, 'submit', ajform.submit_func);
        },
                
        submit_func: function(e) {
           YAHOO.util.Event.preventDefault(e);      
           YAHOO.util.Connect.setForm(ajform.form);
           
           //Temporarily disable the form.                                                                                                                                       
           for(var i=0; i < ajform.form.elements.length; i++) {
              ajform.form.elements[i].disabled = true;
           }
           var cObj = YAHOO.util.Connect.asyncRequest('POST', '<?php print  site_url('user/test');?>', ajform.ajax_callback);
        },
        
        ajax_callback: {
            success: function(o) {
                document.getElementById('list').innerHTML =  o.responseText;
               // This turns the JSON string into a JavaScript object.                                                                                                                                                         
              for(var i=0; i < ajform.form.elements.length; i++) {
                 ajform.form.elements[i].disabled = false;
              };
              test();
            },
            
            failure: function(o) { // In this example, we shouldn't ever go down this path.
             alert('An error has occurred');
            }
            
        }
}


var ajview = {
        init: function() {                 
        },
                
        view: function(url) {           
            var cObj2 = YAHOO.util.Connect.asyncRequest('GET', url, ajview.ajax_callback);    
            oViewPanel.show();      
        },
        
        ajax_callback: {
            success: function(o) {
                document.getElementById('form_view').innerHTML =  o.responseText;                            
            },            
            failure: function(o) { // In this example, we shouldn't ever go down this path.
             alert('An error has occurred');
            }
            
        }
}

</script>




<div id="list"></div>





<style type="text/css">
#panel1 .bd {

    height: 300px;

}
.yui-panel-container .yui-resizepanel .bd {

    overflow: auto;
    background-color: #fff;

}
.yui-panel-container.hide-scrollbars .yui-resizepanel .bd {

    overflow: hidden;

}
.yui-panel-container.show-scrollbars .yui-resizepanel .bd {

    overflow: auto;

}       
.yui-panel-container.show-scrollbars .underlay {

    overflow: visible;

}
.yui-resizepanel .resizehandle { 

     position: absolute; 
     width: 10px; 
     height: 10px; 
     right: 0;
     bottom: 0; 
     margin: 0; 
     padding: 0; 
     z-index: 1; 
     background: url(assets/img/corner_resize.gif) left bottom no-repeat;
     cursor: se-resize;

 }
</style>
<div id="view_panel">
    <div class="hd">Form view</div>
    <div id="form_view" class="bd">
    </div>
</div>
             
<script type="text/javascript">
// BEGIN RESIZEPANEL SUBCLASS //


YAHOO.widget.ResizePanel = function(el, userConfig) {

    if (arguments.length > 0) {

        YAHOO.widget.ResizePanel.superclass.constructor.call(this, el, userConfig);

    }

}

YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE = "yui-resizepanel";

YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE = "resizehandle";

YAHOO.extend(YAHOO.widget.ResizePanel, YAHOO.widget.Panel, {

    init: function(el, userConfig) {
    
        YAHOO.widget.ResizePanel.superclass.init.call(this, el);
    
        this.beforeInitEvent.fire(YAHOO.widget.ResizePanel);
        
        var Dom = YAHOO.util.Dom,
            Event = YAHOO.util.Event,
            oInnerElement = this.innerElement,
            oResizeHandle = document.createElement("DIV"),
            sResizeHandleId = this.id + "_resizehandle";
         
         oResizeHandle.id = sResizeHandleId;
         oResizeHandle.className = YAHOO.widget.ResizePanel.CSS_RESIZE_HANDLE;
    
        Dom.addClass(oInnerElement, YAHOO.widget.ResizePanel.CSS_PANEL_RESIZE);
    
        this.resizeHandle = oResizeHandle;
    
        function initResizeFunctionality() {
    
            var me = this,
                oHeader = this.header,
                oBody = this.body,
                oFooter = this.footer,
                nStartWidth,
                nStartHeight,
                aStartPos,
                nBodyBorderTopWidth,
                nBodyBorderBottomWidth,
                nBodyTopPadding,
                nBodyBottomPadding,
                nBodyOffset;
    
    
            oInnerElement.appendChild(oResizeHandle);
    
            this.ddResize = new YAHOO.util.DragDrop(sResizeHandleId, this.id);
    
            this.ddResize.setHandleElId(sResizeHandleId);
    
            this.ddResize.onMouseDown = function(e) {
    
                nStartWidth = oInnerElement.offsetWidth;
                nStartHeight = oInnerElement.offsetHeight;
    
                if (YAHOO.env.ua.ie && document.compatMode == "BackCompat") {
                
                    nBodyOffset = 0;
                
                }
                else {
    
                    nBodyBorderTopWidth = parseInt(Dom.getStyle(oBody, "borderTopWidth"), 10),
                    nBodyBorderBottomWidth = parseInt(Dom.getStyle(oBody, "borderBottomWidth"), 10),
                    nBodyTopPadding = parseInt(Dom.getStyle(oBody, "paddingTop"), 10),
                    nBodyBottomPadding = parseInt(Dom.getStyle(oBody, "paddingBottom"), 10),
                    
                    nBodyOffset = nBodyBorderTopWidth + nBodyBorderBottomWidth + nBodyTopPadding + nBodyBottomPadding;
                
                }
    
                me.cfg.setProperty("width", nStartWidth + "px");
    
                aStartPos = [Event.getPageX(e), Event.getPageY(e)];
    
            };
            
            this.ddResize.onDrag = function(e) {
    
                var aNewPos = [Event.getPageX(e), Event.getPageY(e)],
                
                    nOffsetX = aNewPos[0] - aStartPos[0],
                    nOffsetY = aNewPos[1] - aStartPos[1],
                    
                    nNewWidth = Math.max(nStartWidth + nOffsetX, 10),
                    nNewHeight = Math.max(nStartHeight + nOffsetY, 10),
                    
                    nBodyHeight = (nNewHeight - (oFooter.offsetHeight + oHeader.offsetHeight + nBodyOffset));
    
                me.cfg.setProperty("width", nNewWidth + "px");
    
                if (nBodyHeight < 0) {
    
                    nBodyHeight = 0;
    
                }
    
                oBody.style.height =  nBodyHeight + "px";
    
            };
        
        }
    
    
        function onBeforeShow() {
    
           initResizeFunctionality.call(this);
    
           this.unsubscribe("beforeShow", onBeforeShow);
    
        }
    
    
        function onBeforeRender() {
    
            if (!this.footer) {
    
                this.setFooter("");
    
            }
    
            if (this.cfg.getProperty("visible")) {
    
                initResizeFunctionality.call(this);
    
            }
            else {
    
                this.subscribe("beforeShow", onBeforeShow);
            
            }
            
            this.unsubscribe("beforeRender", onBeforeRender);
    
        }
    
    
        this.subscribe("beforeRender", onBeforeRender);
    
    
        if (userConfig) {
    
            this.cfg.applyConfig(userConfig, true);
    
        }
    
        this.initEvent.fire(YAHOO.widget.ResizePanel);
    
    },
    
    toString: function() {
    
        return "ResizePanel " + this.id;
    
    }

});

    var oViewPanel = new YAHOO.widget.ResizePanel("view_panel", { width: "400px", fixedcenter: true, constraintoviewport: true, visible: false } );
    oViewPanel.render();
                
                
// END RESIZEPANEL SUBCLASS //
</script>                   
                 
                 
                 
                 
                 
                 
                 
                 
                 
<script type="text/javascript">
  //<![CDATA[       
    var sUrl = "<?php print  site_url('user/test');?>";
    var searchUrl = "<?php print  site_url('user/stest');?>";    
    
    var callbackList = {
        success: function(o) {
            document.getElementById('list').innerHTML =  o.responseText;
            test();
        },
        failure: function(o) {
        alert("AJAX doesn’t work, enable Javascript"); //FAILURE
        }
    }
    var callbackSearch = {
        success: function(o) {
            document.getElementById('search').innerHTML =  o.responseText;
            test();
            ajform.init();
        },
        failure: function(o) {
        alert("AJAX doesn't work, enable Javascript"); //FAILURE
        }
    }
    var transaction = YAHOO.util.Connect.asyncRequest('GET', searchUrl, callbackSearch, null);
    var transaction = YAHOO.util.Connect.asyncRequest('GET', sUrl, callbackList, null);
  //]]>
</script>
<script type="text/javascript">
function test(){
        var myColumnDefs = [
            {key:"op",label:"", sortable:false},{key:"user_name",label:"Username", sortable:true},{key:"name",label:"Firstname", sortable:true},{key:"lastname",label:"Lastname", sortable:true},{key:"email",label:"Email", sortable:true},{key:"centre",label:"Centre", sortable:true},{key:"lastlogin",label:"Last login", sortable:true}
        ];

        this.myDataSource = new YAHOO.util.DataSource(YAHOO.util.Dom.get("500"));
        this.myDataSource.responseType = YAHOO.util.DataSource.TYPE_HTMLTABLE;
        this.myDataSource.responseSchema = {
            fields: [
            {key:"op"},{key:"user_name"},{key:"name"},{key:"lastname"},{key:"email"},{key:"centre"},{key:"lastlogin"}
            ]
        };
        var oConfigs = {
                        paginated:true,
                        paginator: {
                            rowsPerPage: 10,
                            dropdownOptions: [10,25,50,100,500]
                        }
                };

        this.myDataTable = new YAHOO.widget.DataTable("markup-500", myColumnDefs, this.myDataSource,
                oConfigs);
        };      
</script>

</p>
</div>


               
                <div id="file"><p>Tab Two Content</p></div>
                <div id="forum"><p>Tab Three Content</p></div>
            </div>
        </div>
    <script>
    (function() {
        var foldertab = new YAHOO.widget.TabView('foldertab');
    })();
    </script>
  
  </div>
  
