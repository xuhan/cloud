<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="shortcut icon" type="image/ico" href="http://www.sprymedia.co.uk/media/images/favicon.ico" />
        
        <title>DataTables example</title>
        <style type="text/css" title="currentStyle">
            @import "/release-datatables/media/css/demo_page.css";
            @import "/release-datatables/media/css/demo_table.css";
        </style>
        <script type="text/javascript" language="javascript" src="/release-datatables/media/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="/release-datatables/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            var oCache = {
                iCacheLower: -1
            };
            
            function fnSetKey( aoData, sKey, mValue )
            {
                for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
                {
                    if ( aoData[i].name == sKey )
                    {
                        aoData[i].value = mValue;
                    }
                }
            }
            
            function fnGetKey( aoData, sKey )
            {
                for ( var i=0, iLen=aoData.length ; i<iLen ; i++ )
                {
                    if ( aoData[i].name == sKey )
                    {
                        return aoData[i].value;
                    }
                }
                return null;
            }
            
            function fnDataTablesPipeline ( sSource, aoData, fnCallback ) {
                var iPipe = 5; /* Ajust the pipe size */
                
                var bNeedServer = false;
                var sEcho = fnGetKey(aoData, "sEcho");
                var iRequestStart = fnGetKey(aoData, "iDisplayStart");
                var iRequestLength = fnGetKey(aoData, "iDisplayLength");
                var iRequestEnd = iRequestStart + iRequestLength;
                oCache.iDisplayStart = iRequestStart;
                
                /* outside pipeline? */
                if ( oCache.iCacheLower < 0 || iRequestStart < oCache.iCacheLower || iRequestEnd > oCache.iCacheUpper )
                {
                    bNeedServer = true;
                }
                
                /* sorting etc changed? */
                if ( oCache.lastRequest && !bNeedServer )
                {
                    for( var i=0, iLen=aoData.length ; i<iLen ; i++ )
                    {
                        if ( aoData[i].name != "iDisplayStart" && aoData[i].name != "iDisplayLength" && aoData[i].name != "sEcho" )
                        {
                            if ( aoData[i].value != oCache.lastRequest[i].value )
                            {
                                bNeedServer = true;
                                break;
                            }
                        }
                    }
                }
                
                /* Store the request for checking next time around */
                oCache.lastRequest = aoData.slice();
                
                if ( bNeedServer )
                {
                    if ( iRequestStart < oCache.iCacheLower )
                    {
                        iRequestStart = iRequestStart - (iRequestLength*(iPipe-1));
                        if ( iRequestStart < 0 )
                        {
                            iRequestStart = 0;
                        }
                    }
                    
                    oCache.iCacheLower = iRequestStart;
                    oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
                    oCache.iDisplayLength = fnGetKey( aoData, "iDisplayLength" );
                    fnSetKey( aoData, "iDisplayStart", iRequestStart );
                    fnSetKey( aoData, "iDisplayLength", iRequestLength*iPipe );
                    
                    $.getJSON( sSource, aoData, function (json) { 
                        /* Callback processing */
                        oCache.lastJson = jQuery.extend(true, {}, json);
                        
                        if ( oCache.iCacheLower != oCache.iDisplayStart )
                        {
                            json.aaData.splice( 0, oCache.iDisplayStart-oCache.iCacheLower );
                        }
                        json.aaData.splice( oCache.iDisplayLength, json.aaData.length );
                        
                        fnCallback(json)
                    } );
                }
                else
                {
                    json = jQuery.extend(true, {}, oCache.lastJson);
                    json.sEcho = sEcho; /* Update the echo for each response */
                    json.aaData.splice( 0, iRequestStart-oCache.iCacheLower );
                    json.aaData.splice( iRequestLength, json.aaData.length );
                    fnCallback(json);
                    return;
                }
            }
            
            $(document).ready(function() {
                $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "../examples_support/server_processing.php",
                    "fnServerData": fnDataTablesPipeline
                } );
            } );
        </script>
    </head>
    <body id="dt_example">
        <div id="container">
            <div class="full_width big">
                <i>DataTables</i> server-side processing with pipelining example
            </div>
            
            <h1>Preamble</h1>
            <p>When using server-side processing with DataTables, it can be quite intensive on your server having an Ajax call every time the user performs some kind of interaction - you can effectively DDOS your server with your own application!</p>
            <p>This example shows how you might over-come this by modifying the request set to the server to retrieve more information than is actually required for a single page's display. This means that the user can page multiple times (5 times the display size is the default) before a request must be made of the server. Paging is typically the most common interaction performed with a DataTable, so this can be most beneficial to your server's resource usage. Of course the pipeline must be cleared for interactions other than paging (sorting, filtering etc), but that's the trade off that can be made (sending extra information is cheep - while another XHR is expensive).</p>
            
            <h1>Live example</h1>
            <div id="dynamic">
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
    <thead>
        <tr>
            <th width="20%">Rendering engine</th>
            <th width="25%">Browser</th>
            <th width="25%">Platform(s)</th>
            <th width="15%">Engine version</th>
            <th width="15%">CSS grade</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5" class="dataTables_empty">Loading data from server</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Rendering engine</th>
            <th>Browser</th>
            <th>Platform(s)</th>
            <th>Engine version</th>
            <th>CSS grade</th>
        </tr>
    </tfoot>
</table>
            </div>
            <div class="spacer"></div>
            
            
            <h1>Initialisation code</h1>
            <pre>var oCache = {
    iCacheLower: -1
};

function fnSetKey( aoData, sKey, mValue )
{
    for ( var i=0, iLen=aoData.length ; i&lt;iLen ; i++ )
    {
        if ( aoData[i].name == sKey )
        {
            aoData[i].value = mValue;
        }
    }
}

function fnGetKey( aoData, sKey )
{
    for ( var i=0, iLen=aoData.length ; i&lt;iLen ; i++ )
    {
        if ( aoData[i].name == sKey )
        {
            return aoData[i].value;
        }
    }
    return null;
}

function fnDataTablesPipeline ( sSource, aoData, fnCallback ) {
    var iPipe = 5; /* Ajust the pipe size */
    
    var bNeedServer = false;
    var sEcho = fnGetKey(aoData, "sEcho");
    var iRequestStart = fnGetKey(aoData, "iDisplayStart");
    var iRequestLength = fnGetKey(aoData, "iDisplayLength");
    var iRequestEnd = iRequestStart + iRequestLength;
    oCache.iDisplayStart = iRequestStart;
    
    /* outside pipeline? */
    if ( oCache.iCacheLower &lt; 0 || iRequestStart &lt; oCache.iCacheLower || iRequestEnd &gt; oCache.iCacheUpper )
    {
        bNeedServer = true;
    }
    
    /* sorting etc changed? */
    if ( oCache.lastRequest &amp;&amp; !bNeedServer )
    {
        for( var i=0, iLen=aoData.length ; i&lt;iLen ; i++ )
        {
            if ( aoData[i].name != "iDisplayStart" &amp;&amp; aoData[i].name != "iDisplayLength" &amp;&amp; aoData[i].name != "sEcho" )
            {
                if ( aoData[i].value != oCache.lastRequest[i].value )
                {
                    bNeedServer = true;
                    break;
                }
            }
        }
    }
    
    /* Store the request for checking next time around */
    oCache.lastRequest = aoData.slice();
    
    if ( bNeedServer )
    {
        if ( iRequestStart &lt; oCache.iCacheLower )
        {
            iRequestStart = iRequestStart - (iRequestLength*(iPipe-1));
            if ( iRequestStart &lt; 0 )
            {
                iRequestStart = 0;
            }
        }
        
        oCache.iCacheLower = iRequestStart;
        oCache.iCacheUpper = iRequestStart + (iRequestLength * iPipe);
        oCache.iDisplayLength = fnGetKey( aoData, "iDisplayLength" );
        fnSetKey( aoData, "iDisplayStart", iRequestStart );
        fnSetKey( aoData, "iDisplayLength", iRequestLength*iPipe );
        
        $.getJSON( sSource, aoData, function (json) { 
            /* Callback processing */
            oCache.lastJson = jQuery.extend(true, {}, json);
            
            if ( oCache.iCacheLower != oCache.iDisplayStart )
            {
                json.aaData.splice( 0, oCache.iDisplayStart-oCache.iCacheLower );
            }
            json.aaData.splice( oCache.iDisplayLength, json.aaData.length );
            
            fnCallback(json)
        } );
    }
    else
    {
        json = jQuery.extend(true, {}, oCache.lastJson);
        json.sEcho = sEcho; /* Update the echo for each response */
        json.aaData.splice( 0, iRequestStart-oCache.iCacheLower );
        json.aaData.splice( iRequestLength, json.aaData.length );
        fnCallback(json);
        return;
    }
}

$(document).ready(function() {
    $('#example').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "../examples_support/server_processing.php",
        "fnServerData": fnDataTablesPipeline
    } );
} );</pre>
            
            
            
            <h1>Other examples</h1>
            <h2>Basic initialisation</h2>
            <ul>
                <li><a href="../basic_init/zero_config.html">Zero configuration</a></li>
                <li><a href="../basic_init/filter_only.html">Feature enablement</a></li>
                <li><a href="../basic_init/table_sorting.html">Sorting data</a></li>
                <li><a href="../basic_init/multi_col_sort.html">Multi-column sorting</a></li>
                <li><a href="../basic_init/multiple_tables.html">Multiple tables</a></li>
                <li><a href="../basic_init/hidden_columns.html">Hidden columns</a></li>
                <li><a href="../basic_init/dom.html">DOM positioning</a></li>
                <li><a href="../basic_init/state_save.html">State saving</a></li>
                <li><a href="../basic_init/alt_pagination.html">Alternative pagination styles</a></li>
                <li><a href="../basic_init/language.html">Change language information (internationalisation)</a></li>
                <li><a href="../basic_init/themes.html">ThemeRoller themes (Smoothness)</a></li>
            </ul>
            
            <h2>Advanced initialisation</h2>
            <ul>
                <li><a href="../advanced_init/events_pre_init.html">Events (pre initialisation)</a></li>
                <li><a href="../advanced_init/events_post_init.html">Events (post initialisation)</a></li>
                <li><a href="../advanced_init/column_render.html">Column rendering</a></li>
                <li><a href="../advanced_init/html_sort.html">Sorting without HTML tags</a></li>
                <li><a href="../advanced_init/dom_multiple_elements.html">Multiple table controls (sDom)</a></li>
                <li><a href="../advanced_init/dom_toolbar.html">Custom toolbar (element) around table</a></li>
                <li><a href="../advanced_init/sorting_control.html">Set sorting controls</a></li>
                <li><a href="../advanced_init/complex_header.html">Column grouping through col/row spans</a></li>
                <li><a href="../advanced_init/row_grouping.html">Row grouping</a></li>
                <li><a href="../advanced_init/row_callback.html">Row callback</a></li>
                <li><a href="../advanced_init/footer_callback.html">Footer callback</a></li>
                <li><a href="../advanced_init/language_file.html">Change language information from a file (internationalisation)</a></li>
            </ul>
            
            <h2>Data sources</h2>
            <ul>
                <li><a href="../data_sources/dom.html">DOM</a></li>
                <li><a href="../data_sources/js_array.html">Javascript array</a></li>
                <li><a href="../data_sources/ajax.html">Ajax source</a></li>
                <li><a href="../data_sources/server_side.html">Server side processing</a></li>
            </ul>
            
            <h2>Server-side processing</h2>
            <ul>
                <li><a href="../server_side/server_side.html">Obtain server-side data</a></li>
                <li><a href="../server_side/custom_vars.html">Add extra HTTP variables</a></li>
                <li><a href="../server_side/post.html">Use HTTP POST</a></li>
                <li><a href="../server_side/column_ordering.html">Custom column ordering (in callback data)</a></li>
                <li><a href="../server_side/pipeline.html">Pipelining data (reduce Ajax calls for paging)</a></li>
                <li><a href="../server_side/row_details.html">Show and hide details about a particular record</a></li>
                <li><a href="../server_side/select_rows.html">User selectable rows (multiple rows)</a></li>
            </ul>
            
            <h2>API</h2>
            <ul>
                <li><a href="../api/add_row.html">Dynamically add a new row</a></li>
                <li><a href="../api/multi_filter.html">Individual column filtering</a></li>
                <li><a href="../api/highlight.html">Highlight rows and columns</a></li>
                <li><a href="../api/row_details.html">Show and hide details about a particular record</a></li>
                <li><a href="../api/select_row.html">User selectable rows (multiple rows)</a></li>
                <li><a href="../api/select_single_row.html">User selectable rows (single row) and delete rows</a></li>
                <li><a href="../api/editable.html">Editable rows (with jEditable)</a></li>
                <li><a href="../api/form.html">Submit form with elements in table</a></li>
                <li><a href="../api/counter_column.html">Index column (static number column)</a></li>
                <li><a href="../api/show_hide.html">Show and hide columns dynamically</a></li>
                <li><a href="../api/regex.html">Regular expression filtering</a></li>
            </ul>
            
            <h2>Plug-ins</h2>
            <ul>
                <li><a href="../plug-ins/plugin_api.html">Add custom API functions</a></li>
                <li><a href="../plug-ins/sorting_plugin.html">Sorting and type detection</a></li>
                <li><a href="../plug-ins/paging_plugin.html">Custom pagination controls</a></li>
                <li><a href="../plug-ins/range_filtering.html">Range filtering / custom filtering</a></li>
                <li><a href="../plug-ins/dom_sort.html">Live DOM sorting</a></li>
            </ul>
            
            
            <p>Please refer to the <a href="http://www.datatables.net/"><i>DataTables</i> documentation</a> for full information about its API properties and methods.</p>
            
            
            <div id="footer" style="text-align:center;">
                <span style="font-size:10px;">DataTables &copy; Allan Jardine 2008-2010</span>
            </div>
        </div>
    </body>
</html>