<?php echo $this->form->generate_form();?>

<script type="text/javascript" language="Javascript">

var formSubmit = {
   
   updateList: function(e){
        var mylist = window.parent.document.getElementById("fieldList");
        mylist.src = mylist.src;
   }
    
};
YAHOO.util.Event.addListener(window, 'load', formSubmit.updateList);

var code = {
    
   init: function() {
     var list = document.getElementById("list");
     var secret = document.getElementById("form_select_source_codes");
     var l = secret.value;
     var t1 = new Array();
     t1 = l.split('#');
     var len = t1.length -1;
     for (var i = 0; i < len; i++)
        {
          var t2 = new Array();
          t2 = t1[i].split('|');
          var newrow = list.insertRow(-1);
            var c0 = newrow.insertCell(0);
            var c1 = newrow.insertCell(1);
            var c2 = newrow.insertCell(2);
            c0.innerHTML = '<input type="text" value="' + t2[0] + '"/>';
            c1.innerHTML = '<input type="text" value="' + t2[1] + '"/>';
            c2.innerHTML = '<a href="#" onclick="code.del(this)">Del</a>' ;
        }
   },
   
   del: function(r)
   {
      var i=r.parentNode.parentNode.rowIndex;
      document.getElementById('list').deleteRow(i);
      this.refreshSecret();
   },
   
   add: function(e) {
        var id = document.getElementById("id");
        var label = document.getElementById("label");
        var secret = document.getElementById("form_select_source_codes");
        var list = document.getElementById("list");
        var newrow = list.insertRow(-1);
        var c0 = newrow.insertCell(0);
        var c1 = newrow.insertCell(1);
        var c2 = newrow.insertCell(2);
        c0.innerHTML = '<input type="text" value="' + id.value + '"/>';
        c1.innerHTML = '<input type="text" value="' + label.value + '"/>';
        c2.innerHTML = '<a href="#" onclick="code.del(this)">Del</a>' ;
        secret.value += id.value + "|" + label.value + "#";
        id.value = "";
        label.value = "";
    },
    
    save: function(){
        this.refreshSecret();
    },
    
    refreshSecret: function(){
        var list = document.getElementById("list");
        var secret = document.getElementById("form_select_source_codes");
        secret.value = "";
        for (var i = 0; i < list.rows.length; i++)
        {
          var r = list.rows[i];
          var id = r.cells[0].childNodes[0];
          var label = r.cells[1].childNodes[0];
          secret.value += id.value + "|" + label.value + "#";
        }
    }
    
};
YAHOO.util.Event.addListener(window, 'load', code.init());
</script>