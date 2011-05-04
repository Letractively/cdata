<?php
  
class Report {
    
    function Report() {
    
        $CI =& get_instance();
        $this->CI =& $CI;
    }
    
    
    function lineChart($model) {
    
        $id = rand(1, 999999);
        
        if ($model["query"] > ""){
            $res = mysql_query($model["query"]);
            $data = array();
            while ($r = mysql_fetch_assoc($res)) {
                $data[] = $r;
            }
            $model["data"] = $data;
        } 
        $data = "";
        foreach ($model["data"] as $r) {
            $data .= '{ '.$model["x_name"].': "'.$r[$model["x_name"]].'", '.$model["y_name"].': '.$r[$model["y_name"]].'},'."\n";
        }
        
        $chart = "<h3>".$model["title"]."</h3>";
        $chart .='
        <style type="text/css">
            #chart'.$id.'
            {
                width: '.$model["chart_width"].'px;
                height: '.$model["chart_height"].'px;
            }

            .chart_title
            {
                display: block;
                font-size: 1.2em;
                font-weight: bold;
                margin-bottom: 0.4em;
            }
        </style>';
        
        $chart .= '
<div id="chart'.$id.'"><embed type="application/x-shockwave-flash" src="'.$this->CI->config->item("yui").'build/charts/assets/charts.swf" style="" id="yuigen'.$id.'" name="yuigen'.$id.'" bgcolor="#ffffff" quality="high" allowscriptaccess="always" flashvars="allowedDomain=developer.yahoo.com&amp;elementID=yuigen0&amp;eventHandler=YAHOO.widget.FlashAdapter.eventHandler" width="100%" height="100%"></div>

<script type="text/javascript">
    YAHOO.namespace ("cdata"); 
    YAHOO.widget.Chart.SWFURL = "'.$this->CI->config->item("yui").'build/charts/assets/charts.swf";
    
//--- data

    YAHOO.cdata.chart'.$id.' = 
    [
        '.$data.'
    ];

    var myDataSource'.$id.' = new YAHOO.util.DataSource( YAHOO.cdata.chart'.$id.' );
    myDataSource'.$id.'.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource'.$id.'.responseSchema =
    {
        fields: [ "'.$model["x_name"].'", "'.$model["y_name"].'" ]
    };

//--- chart

    var seriesDef = 
    [
        { displayName: "'.$model["y_label"].'", yField: "'.$model["y_name"].'" }
    ];

    YAHOO.cdata.formatCurrencyAxisLabel = function( value )
    {
        return YAHOO.util.Number.format( value,
        {
            prefix: "",
            thousandsSeparator: ",",
            decimalPlaces: 2
        });
    }

    YAHOO.cdata.getDataTipText = function( item, index, series )
    {
        var toolTipText = series.displayName + " for " + item.'.$model["x_name"].';
        toolTipText += "\n" + YAHOO.cdata.formatCurrencyAxisLabel( item[series.yField] );
        return toolTipText;
    }

    var currencyAxis = new YAHOO.widget.NumericAxis();
    currencyAxis.labelFunction = YAHOO.cdata.formatCurrencyAxisLabel;

    var mychart'.$id.' = new YAHOO.widget.LineChart( "chart'.$id.'", myDataSource'.$id.',
    {
        series: seriesDef,
        xField: "'.$model["x_name"].'",
        yAxis: currencyAxis,
        dataTipFunction: YAHOO.cdata.getDataTipText,
        //only needed for flash player express install
        expressInstall: "assets/expressinstall.swf"
    });

</script>

';
        return $chart;
    
    }
    
    
    
    function pieChart($model) {
    
        $id = rand(1, 999999);
        
        if ($model["query"] > ""){
            $res = mysql_query($model["query"]);
            $data = array();
            while ($r = mysql_fetch_assoc($res)) {
                $data[] = $r;
            }
            $model["data"] = $data;
        } 
        $data = "";
        foreach ($model["data"] as $r) {
            $data .= '{ '.$model["cat_name"].': "'.$r[$model["cat_name"]].'", '.$model["count_name"].': '.$r[$model["count_name"]].'},'."\n";
        }
        
        $chart = "<h3>".$model["title"]."</h3>";
        $chart .='
        <style type="text/css">
            #chart'.$id.'
            {
                width: '.$model["chart_width"].'px;
                height: '.$model["chart_height"].'px;
            }

            .chart_title
            {
                display: block;
                font-size: 1.2em;
                font-weight: bold;
                margin-bottom: 0.4em;
            }
        </style>';
        
        $chart .= '
<div id="chart'.$id.'"><embed type="application/x-shockwave-flash" src="'.$this->CI->config->item("yui").'build/charts/assets/charts.swf" style="" id="yuigen'.$id.'" name="yuigen'.$id.'" bgcolor="#ffffff" quality="high" allowscriptaccess="always" flashvars="allowedDomain=developer.yahoo.com&amp;elementID=yuigen0&amp;eventHandler=YAHOO.widget.FlashAdapter.eventHandler" width="100%" height="100%"></div>

<script type="text/javascript">
    YAHOO.namespace ("cdata"); 
    YAHOO.widget.Chart.SWFURL = "'.$this->CI->config->item("yui").'build/charts/assets/charts.swf";
    
//--- data

    YAHOO.cdata.chart'.$id.' = 
    [
        '.$data.'
    ];
    
    var myDataSource'.$id.' = new YAHOO.util.DataSource( YAHOO.cdata.chart'.$id.' );
    myDataSource'.$id.'.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource'.$id.'.responseSchema = { fields: [ "'.$model["cat_name"].'", "'.$model["count_name"].'" ] };


//--- chart

    var seriesDef = 
    [
        { displayName: "'.$model["count_label"].'", yField: "'.$model["count_name"].'" }
    ];

    YAHOO.cdata.formatCurrencyAxisLabel = function( value )
    {
        return YAHOO.util.Number.format( value,
        {
            prefix: "",
            thousandsSeparator: ",",
            decimalPlaces: 2
        });
    }

    YAHOO.cdata.getDataTipText = function( item, index, series )
    {
        var toolTipText = series.displayName + " for " + item.'.$model["cat_name"].';
        toolTipText += "\n" + YAHOO.cdata.formatCurrencyAxisLabel( item[series.yField] );
        return toolTipText;
    }

    var currencyAxis = new YAHOO.widget.NumericAxis();
    currencyAxis.labelFunction = YAHOO.cdata.formatCurrencyAxisLabel;

    var mychart'.$id.' = new YAHOO.widget.PieChart( "chart'.$id.'", myDataSource'.$id.',
    {
        dataField: "'.$model["count_name"].'",
        categoryField: "'.$model["cat_name"].'",
        style:
        {
            padding: 20,
            legend:
            {
                display: "right",
                padding: 10,
                spacing: 5,
                font:
                {
                    family: "Arial",
                    size: 13
                }
            }
        },

        //only needed for flash player express install
        expressInstall: "assets/expressinstall.swf"
    });

</script>

';
        return $chart."<br/>";
    
    }
    
    
    
    function columnChart($model) {
    
        $id = rand(1, 999999);
        
        if ($model["query"] > ""){
            $res = mysql_query($model["query"]);
            $data = array();
            while ($r = mysql_fetch_assoc($res)) {
                $data[] = $r;
            }
            $model["data"] = $data;
        } 
        $data = "";
        foreach ($model["data"] as $r) {
            $data .= '{ '.$model["cat_name"].': "'.$r[$model["cat_name"]].'", '.$model["count_name"].': '.$r[$model["count_name"]].'},'."\n";
        }
        
        $chart = "<h3>".$model["title"]."</h3>";
        $chart .='
        <style type="text/css">
            #chart'.$id.'
            {
                width: '.$model["chart_width"].'px;
                height: '.$model["chart_height"].'px;
            }

            .chart_title
            {
                display: block;
                font-size: 1.2em;
                font-weight: bold;
                margin-bottom: 0.4em;
            }
        </style>';
        
        $chart .= '
<div id="chart'.$id.'"><embed type="application/x-shockwave-flash" src="'.$this->CI->config->item("yui").'build/charts/assets/charts.swf" style="" id="yuigen'.$id.'" name="yuigen'.$id.'" bgcolor="#ffffff" quality="high" allowscriptaccess="always" flashvars="allowedDomain=developer.yahoo.com&amp;elementID=yuigen0&amp;eventHandler=YAHOO.widget.FlashAdapter.eventHandler" width="100%" height="100%"></div>

<script type="text/javascript">
    YAHOO.namespace ("cdata"); 
    YAHOO.widget.Chart.SWFURL = "'.$this->CI->config->item("yui").'build/charts/assets/charts.swf";
    
//--- data

    YAHOO.cdata.chart'.$id.' = 
    [
        '.$data.'
    ];
    
    var myDataSource'.$id.' = new YAHOO.util.DataSource( YAHOO.cdata.chart'.$id.' );
    myDataSource'.$id.'.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource'.$id.'.responseSchema = { fields: [ "'.$model["cat_name"].'", "'.$model["count_name"].'" ] };


//--- chart

    var seriesDef = 
    [
        { 
            displayName: "'.$model["count_label"].'", yField: "'.$model["count_name"].'"
        }
    ];

    YAHOO.cdata.formatCurrencyAxisLabel = function( value )
    {
        return YAHOO.util.Number.format( value,
        {
            prefix: "",
            thousandsSeparator: ",",
            decimalPlaces: 2
        });
    }

    YAHOO.cdata.getDataTipText = function( item, index, series )
    {
        var toolTipText = series.displayName + " for " + item.'.$model["cat_name"].';
        toolTipText += "\n" + YAHOO.cdata.formatCurrencyAxisLabel( item[series.yField] );
        return toolTipText;
    }

    var currencyAxis = new YAHOO.widget.NumericAxis();
    currencyAxis.labelFunction = YAHOO.cdata.formatCurrencyAxisLabel;

    var mychart'.$id.' = new YAHOO.widget.ColumnChart( "chart'.$id.'", myDataSource'.$id.',
    {
        series: seriesDef,
        xField: "'.$model["cat_name"].'",
        style:
        {
            padding: 20,
            legend:
            {
                display: "right",
                padding: 10,
                spacing: 5,
                font:
                {
                    family: "Arial",
                    size: 13
                }
            }
        },

        //only needed for flash player express install
        expressInstall: "assets/expressinstall.swf"
    });

</script>

';
        return $chart."<br/>";
    
    }
    
    
    
    
    function table($model) {
    
        $id = rand(1, 999999);
        
        if ($model["query"] > ""){
            $res = mysql_query($model["query"]);
            $data = array();
            while ($r = mysql_fetch_assoc($res)) {
                $data[] = $r;
            }
            $model["data"] = $data;
        } 
        $data = "";
        $cols ="";
        $rf ="";
        foreach ($model["data"] as $r) {
            $data .= "{";
            for ($j=0;$j<sizeof($model["cols"]);$j++) {
                $data .= $model["cols"][$j].': "'.addslashes(str_replace(array("\r\n", "\n", "\r"), "<br>", $r[$model["cols"][$j]])).'", ';
            }
            $data .= "},"."\n";
        }
        
        for ($j=0;$j<sizeof($model["cols"]);$j++) {
            $cols .= '{ key: "'.$model["cols"][$j].'", label: "'.$model["cols_label"][$j].'", sortable: true, resizeable: true },';
            $rf .= '"'.$model["cols"][$j].'", ';
        }
        
        $chart = "<h3>".$model["title"]."</h3>";
        $chart .='
        <style type="text/css">

         .yui-dt-table {width: '.$model["chart_width"].'px;}

    
        </style>';

        
        $chart .= '
        <div id="datatable'.$id.'"></div>

<script type="text/javascript">
    YAHOO.namespace ("cdata"); 

    //manipulating the DOM causes problems in ie, so create after window fires "load"
    YAHOO.util.Event.addListener(window, "load", function()
    { 
    
//--- data

    YAHOO.cdata.chart'.$id.' = 
    [
        '.$data.'
    ];
    
    var myDataSource'.$id.' = new YAHOO.util.DataSource( YAHOO.cdata.chart'.$id.' );
    myDataSource'.$id.'.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    myDataSource'.$id.'.responseSchema = { fields: [ '.$rf.' ] };


//--- chart

    var seriesDef = 
    [
        { displayName: "'.$model["count_label"].'", yField: "'.$model["count_name"].'" }
    ];

    var columns =
        [
            '.$cols.'
        ];
        var mytable'.$id.' = new YAHOO.widget.DataTable( "datatable'.$id.'", columns, myDataSource'.$id.');

    });

</script>

';
        return $chart."<br/>";
    
    }
    
    

}
    
?>
