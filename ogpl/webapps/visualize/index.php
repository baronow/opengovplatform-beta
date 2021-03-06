<?php 
  global $viz_path;
  
  $nid = $_GET['nid']; 
  $inst = $_GET['inst'];
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">	
	<title>Visualization Engine | Data.gov.in </title>
	<link href="<?php print $viz_path;?>lib/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="<?php print $viz_path;?>lib/colorpicker/css/colorpicker.css" rel="stylesheet">
	<link href="<?php print $viz_path;?>lib/dataviz/css/style.css" rel="stylesheet">
	<link href="<?php print $viz_path;?>lib/graphicons/graphicons.css" rel="stylesheet">
	<link href="<?php print $viz_path;?>lib/select2/select2.css" rel="stylesheet">
	<link href="<?php print $viz_path;?>lib/dataviz/css/view_style.css" rel="stylesheet">
	<link href="<?php print $viz_path;?>css/style.css" rel="stylesheet">
  <style type="text/css">
    /* set title font properties */
    .infowindow .window .top .right .user .titlebar .title { font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14pt; }
    /* set content font properties */
    .infowindow .window .top .right .user .content { font-style:italic;font-weight:bold; font-size:10pt; }
    .record-count {display: inline-block; padding: 5px 10px;}
    #s2id_instance-dropdown{float: left;}
    #instance-dropdown {width: auto; max-width: 450px;}
    #instance-dropdown-label{ margin-top: 5px; margin-right: 2px;  font-size: 20px;} 
  </style>
  <script type="text/javascript" src="<?php print $viz_path;?>lib/misc/misc.js"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>lib/jquery/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>js/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>lib/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>lib/colorpicker/js/bootstrap-colorpicker.js"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>lib/select2/select2.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyDrq5xE0v4wqyElRaIHzr9xUql8OQpFWAQ&region=IN&sensor=false"></script>	
	<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>lib/dataviz/init.js"></script>
	<script type="text/javascript" src="<?php print $viz_path;?>lib/dataviz/query_builder.js"></script>
	<script type="text/javascript">
	  DataViz.setView('#data_viz_views');
	  DataViz.setVizPath('<?php print $viz_path;?>');
	  google.setOnLoadCallback(DataViz.drawVisualization);
    google.load('visualization', '1', {packages: ['corechart', 'table', 'geomap', 'motionchart', 'charteditor']});
    
    function initialize() {
      var mapDiv = document.getElementById('data_viz_map');
      var map = new google.maps.Map(mapDiv, {
        center: new google.maps.LatLng(37.4419, -122.1419),
        zoom: 13,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      });
    }
    
    google.maps.event.addDomListener(window, 'load', initialize);
    
    $(function(){
    	DataViz.createInstanceList('<?php echo $nid; ?>');
    	DataViz.setDatasource('data_gov_in_source', '<?php echo $inst; ?>');
    	$("#info-desc-toggle").click(function(){
    		$("#info-desc-content").toggle();
      });
    });
  </script>
  <script type="text/javascript" src="<?php print $viz_path;?>js/script.js"></script>
</head>
<body>
  <div style="width: 98.7%;">
  	<div class="row-fluid data_viz_pad_lr_10 page-header">
  		<div class="span12">
        <h1>Data.gov.in Visualization Engine <small>come, explore, share ... </small></h1>
        <div class="clearfix"></div>
  		</div>
  		<div class="clearfix"></div>
  	</div>
  			  <?php 
  			  if($viz_path != '' ) {
            global $user; 
            global $base_url; 
            
            $_user_object = content_profile_load('role_request', $user->uid);
            if($_user_object) {
              if (!empty($_user_object->field_rr_first_name[0][value])) {
                $name = $_user_object->field_rr_first_name[0][value] . ' ' . $_user_object->field_rr_last_name[0][value] . ', ' .$_user_object->field_rr_designation[0][value]  ;
              }
              else if (function_exists('web_ldap_role_management_get_profile') ) {
                $name = web_ldap_role_management_get_profile('profile_first_name') . ' ' . web_ldap_role_management_get_profile('profile_last_name') .' , '. web_ldap_role_management_get_profile('profile_designation');
              }
              else {
               $name = $user->name;
              }
            } else {
                $name = $user->name;
            }
            
            if ($name != '') {
            ?>
            <div class="information row-fluid data_viz_pad_lr_10">
  			      <div class="span12">
                <div class="user-info-container">
                  <div class="welcome pull-left" >
                    Logged in as <?php print l($name,'user/'.$user->uid); ?><?php ?>
                  </div>
                  <div class="help pull-right">
                    <a href="<?php echo $base_url; ?>/logout" title="Log Out">Log Out</a>
                  </div>
                  <div class="clearfix"></div>
                </div>
               </div>
            </div>
            <?php 
            }            
          }
          ?>
  			
  </div>
	<div class="container-fluid">
    <div class="row-fluid data_viz_pad_lr_10">
  			<div class="span12 dataset-info">
          <?php
          if(function_exists('node_load') && $nid != '') {
            if($node = node_load($nid)) {
              ?>
               <h3><span class="graphicon-dataset"></span> <?php print $node->title;?><span id="info-desc-toggle" class="graphicon-circle-info"></span></h3>
               <p id="info-desc-content" class="muted" style="display: none;" ><?php print $node->field_ds_description[0]['value'];?></p>
              <?php 
            }
          } 
          ?>
  			</div>
  			
  		</div>
		<div class="row-fluid data_viz_pad_lr_10">
			<div class="span12">
			  <div id="data_viz_current_view_info" >
				  <h4><span class="graphicon-view"></span>  Complete View </h4>
        </div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row-fluid data_viz_pad_lr_10">
			<div class="span12">
			  <div id="data_component" class="btn-group pull-right" data-toggle="buttons-checkbox">
				<!-- 
			    <button type="button" title="Dashboard" class="btn dashboard">
						<span class="graphicon-dashboard"></span>
					</button>
					-->
          <button type="button" title="Grid" class="btn grid active">
						<span class="graphicon-grid"></span>
					</button>
				  <button type="button" title="Chart" class="btn chart">
						<span class="graphicon-chart"></span>
					</button>
				  <button type="button" title="Map" class="btn map">
						<span class="graphicon-map"></span>
					</button>
        </div>
        <div class="clearfix"></div>
        </div>
     </div>
     <div class="row-fluid data_viz_pad_lr_10">
      <div class="span6">
        <label id="instance-dropdown-label" class="pull-left" > <strong>Instance:</strong> </label><select id="instance-dropdown" class="pull-left" title="Choose Instance"></select>
        <div class="record-count pull-left"></div>
				<div class="clearfix"></div>
      </div>
			<div class="span6">
			  <div id="data_viz_sidebar_control" class="btn-group pull-right" data-toggle="buttons-radio" >
          <button class="btn data_viz_sidebar_control sidebar_view">View</button>
          <button class="btn data_viz_sidebar_control sidebar_fields">Fields</button>
          <button class="btn data_viz_sidebar_control sidebar_filter">Filter</button>
          <button class="btn data_viz_sidebar_control sidebar_groups">Groups</button>
          <button class="btn data_viz_sidebar_control sidebar_visualize_chart">Visualize Chart</button>
          <button class="btn data_viz_sidebar_control sidebar_map">Map</button>
          <button class="btn data_viz_sidebar_control sidebar_custom_query">Custom Query</button>
          <button class="btn data_viz_sidebar_control sidebar_about">About</button>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
    </div>
		<div class="row-fluid data_viz_pad_lr_10">
			<div class="span12">
			      
			</div>
			<div class="clearfix"></div>
    </div>
    <div class="row-fluid data_viz_pad_lr_10">
      <div id="data_viz_content" class="span9 well">
      	<!--Body content-->
      	<div id="data_viz_dashboard" style="height: 400px; display: none;"></div>
      	<div id="data_viz_grid" style="height: 400px; width:100%"><center><img src="<?php print $viz_path;?>images/loading.gif" /></center></div>
      	<div id="data_viz_chart" style="height: 400px; display: none;">    
        	<div class="alert alert-block">
      	    <button type="button" class="close" data-dismiss="alert">x</button>
      	    <h4>No Chart Available!</h4>
      	    Select the chart axis to generate your chart...
      	  </div>
        </div>
      	<div id="data_viz_geomap" style="display: none; "></div>
      	<div id="data_viz_map" style="height: 400px; display: none;"></div>
      	<div id="data_viz_arcgismap" style="display: none;"></div>
      	<div id="data_viz_timeline" style="display: none;"></div>
      </div>
		    <div id="data_viz_sidebar" class="span3">
		      <div class="row-fluid">
		        <div id="data_viz_hide_sidebar_content">
  	        <div id="data_viz_sidebar_content" >
		        <div id="data_viz_toggle_slide" class="span12">
    				<div class="" id="accordion2">
    				  <div id="data_viz_sidebar_content_view" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        View
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseOne" class="">
          				<div class="accordion-inner">
          					<div id="data_viz_views">
                      <div class="data_viz_viewer_header"><h5 class="pull-left"></h5></div>
                       <div class="data_viz_viewer_content row-fluid"></div>
                    </div>
          				</div>
          			</div>
          		</div>
          		<div id="data_viz_sidebar_content_fields" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        Fields
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseOne" class="">
          				<div class="accordion-inner">
          					<div id="data_control_pane"></div>
          				</div>
          			</div>
          		</div>
          		<div id="data_viz_sidebar_content_filter" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        Filter
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseTwo" class="">
          				<div class="accordion-inner">
          					<div id="data_viz_filter_form">
          						<form>
          							<select id="data_viz_and_or">
          								<option value="and">and</option>
          								<option value="or">or</option>
          							</select> <select id="data_viz_available_field"
          								class="data_viz_available_field"
          								onchange="DataViz._populat_operator(this.value)">
          								<option value="">Select Field</option>
          							</select> <select id="data_viz_operator">
          								<option value="">Select Operator</option>
          							</select> <input id="data_viz_filter_value" type="text" />
          							<div></div>
          							<button type="button" class="btn btn-info" onclick="DataViz.addFilter()">Add</button>
          						</form>
          					</div>
          					<div id="data_viz_filter">
          						<div class="row-fluid">
          							<div class="span12">
          								<H6>Applied Filter</H6>
          							</div>
          						</div>
          					</div>
          				</div>
          			</div>
          		</div>
          		
          		<div id="data_viz_sidebar_content_groups" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class=" dataviz-accordion "> 
          				  <div class="row-fluid">
                			<div class="span10 title">
                        Groups
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          				</div>
          			</div>
          			<div id="collapseThree" class="">
          				<div class="accordion-inner">
          					<div id="data_control_pane_group">
          						<select id="data_viz_available_groupby_data_field"
          							class="data_viz_available_field">
          							<option value="">Select Group</option>
          						</select>
          						<div></div>
          						<button type="button" class="btn  btn-info" onclick="DataViz.addGroup()">Add</button>
          						<div id="data_viz_group"></div>
          					</div>
          				</div>
          			</div>
          			<!--  -->
          			<div class="dataviz-accordion-content">
          				<div class=" dataviz-accordion "> 
          				  <div class="row-fluid">
                			<div class="span10 title">
                        Aggregation
                			</div>
                			<div class="span2 action">
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          				</div>
          			</div>
          			<div id="collapseThree-two" class="">
          				<div class="accordion-inner">
          					<div id="data_control_pane_group">
          						<select id="data_viz_available_aggregate_data_field"
          							class="data_viz_available_field">
          							<option value="">Select Field</option>
          						</select>
          						<select id="data_viz_aggregate_function_field" >
          							<option value="">Select Function</option>
          							<option value="avg">avg</option>
          							<option value="count">count</option>
          							<option value="max">max</option>
          							<option value="min">min</option>
          							<option value="sum">sum</option>          							
          						</select>
          						<div></div>
          						<button type="button" class="btn  btn-info" onclick="DataViz.addAggregate()">Add</button>
          						<div id="data_viz_aggregate_field"></div>
          					</div>
          				</div>
          			</div>
          		</div>
          		
          		<div id="data_viz_sidebar_content_visualize_chart" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        Visualize Chart
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseFour" class="">
          				<div class="accordion-inner">
          						<div id="data_control_pane_chart"></div>
          						<div id="data_chart_axis">
          								<select name="base" id="data_viz_available_chart_base_field"
          									class="data_viz_available_field span11"
          									onchange="DataViz.setBaseLabel(this.value)">
          									<option value="">Select Base Axis</option>
          								</select> <select id="data_viz_available_chart_data_field"
          									class="data_viz_available_field span11">
          									<option value="">Select Series</option>
          								</select>
          								<button type="button" class="btn btn-info"
          									onclick="DataViz.addSeries()">Add</button>
          								<button class="btn btn-info"
          									onclick="javascript:DataViz._open_chart_editor();">Manage
          									Chart</button>
          								<br /> <br />
          								<div class="clearfix"></div>
          								<div class="clearfix"></div>
          								<div class="clearfix"></div>
          								<div id="data_viz_added_series"></div>
          								<!-- <input type="submit" class="btn" value="Generate"></input> -->
          						</div>
          				</div>
          			</div>
          		</div>
          		<div id="data_viz_sidebar_content_map" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        MAP
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseFive" class="">
          				<div class="accordion-inner">
          					<div id="data_map">
          						<form>
          							<select name="base" id="data_viz_available_map_lat_field"
          								class="data_viz_available_field">
          								<option value="">Select Latitude</option>
          							</select> <select id="data_viz_available_map_lon_field"
          								class="data_viz_available_field">
          								<option value="">Select Longitude</option>
          							</select>
          							<button type="button" class="btn" onclick="DataViz.generateMap()">Generate</button>
          						</form>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div id="data_viz_sidebar_content_custom_query" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        Custom Query 
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseSix" class="">
          				<div class="accordion-inner">
          					<div id="data_control_pane_group">
          						<form>
          							<textarea id="data_viz_custom_query_value"></textarea>
          							<div></div>
          							<button type="button" class="btn btn-info"
          								onclick="DataViz.executeQuery()">Execute</button>
          							<div class="clearfix"></div>
          							<div></div>
          							<br/>
          							<div class="label label-inverse">
          								For query language help visit <br />
          								<a href="https://developers.google.com/chart/interactive/docs/querylanguage"
          									target="_blank">Query Language Reference</a>
          							</div>
          						</form>
          					</div>
          				</div>
          			</div>
          		</div>
          		<div id="data_viz_sidebar_content_about" class="data_viz_sidebar_content">
          			<div class="dataviz-accordion-content">
          				<div class="dataviz-accordion">
          					<div class="row-fluid">
                			<div class="span10 title">
                        About
                			</div>
                			<div class="span2 action">
                        <button class="btn btn-mini pull-right data_viz_hide_sidebar" type="button">&times;</button> 
                			</div>
                			<div class="clearfix"></div>
                    </div> 
          					</div>
          			</div>
          			<div id="collapseSeven" class="">
          				<div id="data_viz_sidebar_content_about_inner" class="accordion-inner">
          				<?php if($node) {?>
          				  <dl>
          				    <?php if($node->title) { ?><dt>Title</dt><dd><?php print $node->title;?></dd><?php } ?>
          				    <?php if($node->field_ds_description[0]['value']) { ?><dt>Description</dt><dd><?php print $node->field_ds_description[0]['value'];?></dd><?php } ?>
          				    <?php if($node->field_support_note[0]['value']) { ?><dt>Note</dt><dd><?php print $node->field_support_note[0]['value'];?></dd><?php } ?>
          				    <?php 
          				      $frontend_url = variable_get('frontend_url', '');
                        $url = $frontend_url . '/' . url('node/' . $node->nid);
                      ?>
          				    <?php if($url) { ?><dt>Link</dt><dd><a href="<?php print $url;?>" title="View Dataset" target="_blank">View Dataset</a></dd></dl><?php } ?> 
                  <?php } ?>
          				</div>
          			</div>
          		</div>
          	</div>
          </div>
				</div>
			</div>
	    </div>
    </div>
    </div>
  </div>
   
      <div id="data_viz_modal_view_edit" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
          <h3 id="myModalLabel">Edit View</h3>
        </div>
         <form id="data_viz_modal_view_edit_form" onSubmit="return DataViz.updateViewFormSubmit(this);">
          <div class="modal-body">
            <div>
              <label>Title:</label>
              <input name="title" type="text" class="view_title"  maxlength="255" />
            </div>
          </div>
          <div class="modal-footer">
            <input type="hidden" name="view_id" class="view_id"/>
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
      </div>
    
    
    <div id="data_viz_modal_view_add" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myAddModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
        <h3 id="myAddModalLabel">Add View</h3>
      </div>
      <form id="data_viz_modal_view_add_form" onSubmit="return DataViz.createViewFormSubmit(this);" >
        <div class="modal-body">
          <div><label>Title:</label><input name="title" type="text" maxlength="255" /></div>
        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
    
    <div id="data_viz_modal_message" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
        <h3 id="myMessageModalLabel"></h3>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
    </div>
    
</body>
</html>