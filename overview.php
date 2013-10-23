<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_elSalvador/'.'routes.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_elSalvador/'.'header.php');
	require_once($aRoutes['paths']['config'].'bs_model.php');
	$oModel = new BSModel();

	$form = $_POST;
	if($form['rms_save_chart_settings'] == 'Save'){
	    $oModel = new BSModel();
	    $query_chart = "INSERT INTO grafico_rms(valor_minimo, valor_maximo)values(".$form['rms_min_chart'].", ".$form['rms_max_chart'].");";
	    $oModel->Select($query_chart);
	    $query_event = "INSERT INTO eventos_alarmas(tipo)values(7);";
	    $oModel->Select($query_event);
	    header("Location: overview.php?");  
	}
	
	$query_radios = "SELECT id,mac,identificador from radios where estado = 1 order by id asc;";
	$aRadios = $oModel->Select($query_radios);
	$aRms = array();
	$aParametros = array();
	foreach ($aRadios as $radios) {
		$query_rms = "SELECT valor from rms where radio_id = ".$radios['id']." order by id asc;";
		$rms = $oModel->Select($query_rms);
		$aRms[] = array('radio_id' => $radios['id'],
						'valor' => $rms[0]['valor'],
						'mac' => $radios['mac'],
						'identificador' => $radios['identificador']
					);
		$query_parametros = "SELECT * from parametros where radio_id = ".$radios['id'].";";
		$par = $oModel->Select($query_parametros);
		$aParametros[] = array('rms_max_normal' => $par[0]['rms_normal'],
							   'rms_semi_ropping' => ($par[0]['rms_normal'])*(1+$par[0]['rms_max_normal_porcentaje']/100),
							   'rms_ropping' => ($par[0]['rms_normal'])*(1+$par[0]['rms_ropping_porcentaje']/100)
							);
	}
	$count_radios = count($aRms);
	$query_limite_gauge = "SELECT * from grafico_rms order by id desc limit 1;";
	$aLimiteGauge = $oModel->Select($query_limite_gauge);
	if(empty($aLimiteGauge)){
	  $aLimiteGauge= array();
	  $aLimiteGauge[0]['valor_minimo'] = 0;
	  $aLimiteGauge[0]['valor_maximo'] = 1023;
	}
	$gauge_minimo = $aLimiteGauge[0]['valor_minimo'];
	$gauge_maximo = $aLimiteGauge[0]['valor_maximo'];

?>

<div class="container container-body contenedor">
	<h2>Overview</h2>
	<?php if(count($aRms) == 0){ ?>
		<div id="overview_empty" class="alert alert-warning">
	    	There is not radios connected
	  	</div>
	<?php } ?>
	<div class="overview-group">
		<div id="gauge1" class="gauge"></div>
		<div id="msg1" class="overview-msg calibrate">Calibrando</div>
    	<div id="link-status1" class="link-status">
    		<a href="status.php?radio_id=<?=$aRms[0]['radio_id']?>&n_radio=1">Show live status</a>
    	</div>
    	<div id="gauge2" class="gauge"></div>
		<div id="msg2" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status2" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[1]['radio_id']?>&n_radio=2">Show live status</a>
	    </div>
	    <div id="gauge3" class="gauge"></div>
		<div id="msg3" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status3" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[2]['radio_id']?>&n_radio=3">Show live status</a>
	    </div>	
	</div>
	<div class="overview-group">
		<div id="gauge4" class="gauge"></div>
		<div id="msg4" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status4" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[3]['radio_id']?>&n_radio=4">Show live status</a>
	    </div>
		<div id="gauge5" class="gauge"></div>
		<div id="msg5" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status5" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[4]['radio_id']?>&n_radio=5">Show live status</a>
	    </div>
		<div id="gauge6" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status6" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[5]['radio_id']?>&n_radio=6">Show live status</a>
	    </div>
	</div>
	
	<div class="overview-group">
		<div id="gauge7" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status7" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[6]['radio_id']?>&n_radio=7">Show live status</a>
	    </div>
	    <div id="gauge8" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status8" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[7]['radio_id']?>&n_radio=8">Show live status</a>
	    </div>
	    <div id="gauge9" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status9" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[8]['radio_id']?>&n_radio=9">Show live status</a>
	    </div>
	</div>

	<div class="overview-group">
		<div id="gauge10" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status10" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[9]['radio_id']?>&n_radio=10">Show live status</a>
	    </div>
	    <div id="gauge11" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status11" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[10]['radio_id']?>&n_radio=11">Show live status</a>
	    </div>
	    <div id="gauge12" class="gauge"></div>
		<div id="msg6" class="overview-msg calibrate">Calibrando</div>
		<div id="link-status12" class="link-status">
	    	<a href="status.php?radio_id=<?=$aRms[11]['radio_id']?>&n_radio=12">Show live status</a>
	    </div>
	</div>
	
    
    

    <div id="help-overview" class="help">
		<br /> <br /> 
		<strong>
			S<br /> C<br />A<br />L<br />E
		</strong>	    
	</div>
	<div id="wrapper-help-overview">
		<div id="container-help-overview">
			<div class="span3 form-chart">
	            <h4>Gauge configuration</h4>
	            <div id="value_gauge_conf">Enter a value between 0 to 200</div>
	            <form  id="rms_set_chart" method="post" name="rms_set_chart" action="overview.php" enctype="multipart/form-data">
	              <div class="controls controls-row">
	                <label class="span1" for="rms_min_chart">Min value</label>
	                <label class="span1 offset2" for="rms_max_chart">Max value</label>
	              </div>
	              <div class="controls controls-row">
	                <input type="text" class="span1" name="rms_min_chart" id="rms_min_chart" value="<?=$aFormGauge[0]['valor_minimo']?>">
	                <input type="text" class="span1 offset2" name="rms_max_chart" id="rms_max_chart" value="<?=$aFormGauge[0]['valor_maximo']?>">
	              </div> 
	              <input type="submit" value="Save" name="rms_save_chart_settings" class="btn btn-primary save_chart_settings" id="rms_save_gauge_settings">
	            </form>
          	</div> 
		</div>	
	</div>
</div>

<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/cavex_elSalvador/'.'footer.php');

?>

<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>/modules/exporting.js"></script>
<script type="text/javascript" src="<? echo $aRoutes['paths']['js']?>highcharts-more.js"></script>

<script type="text/javascript">
	$('#help-overview').click(function(){
		if($("#help-overview").attr('class') == 'help'){
			$('#wrapper-help-overview').show();
			$("#container-help-overview").toggle("slide", {direction: "right"}, 500);	
			$(this).removeClass("help").addClass("close-container");
			$(this).html("<br /> <br /><strong> C <br />L <br />O <br />S <br />E </strong>");
		}else if($("#help-overview").attr('class') == 'close-container'){
			$(this).removeClass("close-container").addClass("help");
			$(this).html("<br /> <br /> <strong>S <br />C <br />A<br />L<br />E </strong>");
			$("#container-help-overview").toggle("slide", {direction: "right"}, 100);	
			$('#wrapper-help-overview').fadeOut("fast");
		}			
	});
	$("#rms_set_chart").validate({
		rules:{
			rms_min_chart:{
				required: true,
				min: 0,
				max: 200,
				number: true
			},
			rms_max_chart:{
				required: true,
				min: 0,
				max: 200,
				number: true
			}
		},
		invalidHandler: function(form){
				alert('Enter a value between 0 to 200'); // for demo
            	return false; // for demo
			},
	        highlight: function(element, errorClass, validClass) {
			    $(element).addClass(errorClass).removeClass(validClass);
			  },
			 unhighlight: function(element, errorClass, validClass) {
			    $(element).removeClass(errorClass).addClass(validClass);
			  },
			  errorPlacement: function(error, element) {      
        	}
	});
	<?php if($count_radios > 0){?>
		
		$(function () {
			  $('#link-status1').show();
		      $('#gauge1').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[0]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		        	min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            // min: <?=$gauge_minimo?>,
		            // max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[0]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[0]['rms_semi_ropping']?>,
		                to: <?=$aParametros[0]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[0]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[0]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

		              if(y_data == -1){
	              		if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-warning' || $("#msg1").attr('class') == 'overview-msg alert-error' || $("#msg1").attr('class') == 'overview-msg alert-success'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg1').hide();
              				$('#msg1').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[0]['rms_semi_ropping']?>){
		              	if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-warning' || $("#msg1").attr('class') == 'overview-msg alert-error' || $("#msg1").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg1').hide();
              				$('#msg1').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[0]['rms_semi_ropping']?> && y_data < <?=$aParametros[0]['rms_ropping']?>){
	              		if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-error' || $("#msg1").attr('class') == 'overview-msg alert-success' || $("#msg1").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg1').hide();
              				$('#msg1').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[0]['rms_ropping']?>){
	              		if($("#msg1").attr('class') == 'overview-msg calibrate'  || $("#msg1").attr('class') == 'overview-msg alert-warning' || $("#msg1").attr('class') == 'overview-msg alert-success' || $("#msg1").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg1").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg1').hide();
              				$('#msg1').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>	
	
	<?php if($count_radios > 1){?>
		$(function () {
			  $('#link-status2').show();
		      $('#gauge2').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[1]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		           plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[1]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[1]['rms_semi_ropping']?>,
		                to: <?=$aParametros[1]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[1]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[1]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;

		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }
		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              if(y_data == -1){
	              		if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-warning' || $("#msg2").attr('class') == 'overview-msg alert-error' || $("#msg2").attr('class') == 'overview-msg alert-success'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg2').hide();
              				$('#msg2').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[1]['rms_semi_ropping']?>){
		              	if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-warning' || $("#msg2").attr('class') == 'overview-msg alert-error' || $("#msg2").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg2').hide();
              				$('#msg2').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[1]['rms_semi_ropping']?> && y_data < <?=$aParametros[1]['rms_ropping']?>){
	              		if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-error' || $("#msg2").attr('class') == 'overview-msg alert-success' || $("#msg2").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg2').hide();
              				$('#msg2').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[1]['rms_ropping']?>){
	              		if($("#msg2").attr('class') == 'overview-msg calibrate'  || $("#msg2").attr('class') == 'overview-msg alert-warning' || $("#msg2").attr('class') == 'overview-msg alert-success' || $("#msg2").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg2").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg2').hide();
              				$('#msg2').text("Ropping").show();
              			}
		              }
		              newVal = inc;	              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>
	<?php if($count_radios > 2){?>
		$(function () {
			  $('#link-status3').show();
		      $('#gauge3').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[2]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[2]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[2]['rms_semi_ropping']?>,
		                to: <?=$aParametros[2]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[2]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[2]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg3").attr('class') == 'overview-msg calibrate'  || $("#msg3").attr('class') == 'overview-msg alert-warning' || $("#msg3").attr('class') == 'overview-msg alert-error' || $("#msg3").attr('class') == 'overview-msg alert-success'){
	              			$("#msg3").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg3').hide();
              				$('#msg3').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[2]['rms_semi_ropping']?>){
		              	if($("#msg3").attr('class') == 'overview-msg calibrate'  || $("#msg3").attr('class') == 'overview-msg alert-warning' || $("#msg3").attr('class') == 'overview-msg alert-error' || $("#msg3").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg3").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg3').hide();
              				$('#msg3').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[2]['rms_semi_ropping']?> && y_data < <?=$aParametros[2]['rms_ropping']?>){
	              		if($("#msg3").attr('class') == 'overview-msg calibrate'  || $("#msg3").attr('class') == 'overview-msg alert-error' || $("#msg3").attr('class') == 'overview-msg alert-success' || $("#msg3").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg3").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg3').hide();
              				$('#msg3').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[2]['rms_ropping']?>){
	              		if($("#msg3").attr('class') == 'overview-msg calibrate'  || $("#msg3").attr('class') == 'overview-msg alert-warning' || $("#msg3").attr('class') == 'overview-msg alert-success' || $("#msg3").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg3").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg3').hide();
              				$('#msg3').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 3){?>
		$(function () {
			  $('#link-status4').show();	
		      $('#gauge4').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[3]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[3]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[3]['rms_semi_ropping']?>,
		                to: <?=$aParametros[3]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[3]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[3]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

		              if(y_data == -1){
	              		if($("#msg4").attr('class') == 'overview-msg calibrate'  || $("#msg4").attr('class') == 'overview-msg alert-warning' || $("#msg4").attr('class') == 'overview-msg alert-error' || $("#msg4").attr('class') == 'overview-msg alert-success'){
	              			$("#msg4").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg4').hide();
              				$('#msg4').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[3]['rms_semi_ropping']?>){
		              	if($("#msg4").attr('class') == 'overview-msg calibrate'  || $("#msg4").attr('class') == 'overview-msg alert-warning' || $("#msg4").attr('class') == 'overview-msg alert-error' || $("#msg4").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg4").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg4').hide();
              				$('#msg4').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[3]['rms_semi_ropping']?> && y_data < <?=$aParametros[3]['rms_ropping']?>){
	              		if($("#msg4").attr('class') == 'overview-msg calibrate'  || $("#msg4").attr('class') == 'overview-msg alert-error' || $("#msg4").attr('class') == 'overview-msg alert-success' || $("#msg4").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg4").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg4').hide();
              				$('#msg4').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[3]['rms_ropping']?>){
	              		if($("#msg4").attr('class') == 'overview-msg calibrate'  || $("#msg4").attr('class') == 'overview-msg alert-warning' || $("#msg4").attr('class') == 'overview-msg alert-success' || $("#msg4").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg4").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg4').hide();
              				$('#msg4').text("Ropping").show();
              			}
		              }
	              	

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 4){?>
		$(function () {
			  $('#link-status5').show();
		      $('#gauge5').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[4]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[4]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[4]['rms_semi_ropping']?>,
		                to: <?=$aParametros[4]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[4]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[4]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;

		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

		              if(y_data == -1){
	              		if($("#msg5").attr('class') == 'overview-msg calibrate'  || $("#msg5").attr('class') == 'overview-msg alert-warning' || $("#msg5").attr('class') == 'overview-msg alert-error' || $("#msg5").attr('class') == 'overview-msg alert-success'){
	              			$("#msg5").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg5').hide();
              				$('#msg5').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[4]['rms_semi_ropping']?>){
		              	if($("#msg5").attr('class') == 'overview-msg calibrate'  || $("#msg5").attr('class') == 'overview-msg alert-warning' || $("#msg5").attr('class') == 'overview-msg alert-error' || $("#msg5").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg5").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg5').hide();
              				$('#msg5').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[4]['rms_semi_ropping']?> && y_data < <?=$aParametros[4]['rms_ropping']?>){
	              		if($("#msg5").attr('class') == 'overview-msg calibrate'  || $("#msg5").attr('class') == 'overview-msg alert-error' || $("#msg5").attr('class') == 'overview-msg alert-success' || $("#msg5").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg5").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg5').hide();
              				$('#msg5').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[4]['rms_ropping']?>){
	              		if($("#msg5").attr('class') == 'overview-msg calibrate'  || $("#msg5").attr('class') == 'overview-msg alert-warning' || $("#msg5").attr('class') == 'overview-msg alert-success' || $("#msg5").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg5").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg5').hide();
              				$('#msg5').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>

	<?php if($count_radios > 5){?>
		$(function () {
			  $('#link-status6').show();
		      $('#gauge6').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[5]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[5]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[5]['rms_semi_ropping']?>,
		                to: <?=$aParametros[5]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[5]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[5]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg6").attr('class') == 'overview-msg calibrate'  || $("#msg6").attr('class') == 'overview-msg alert-warning' || $("#msg6").attr('class') == 'overview-msg alert-error' || $("#msg6").attr('class') == 'overview-msg alert-success'){
	              			$("#msg6").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg6').hide();
              				$('#msg6').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[5]['rms_semi_ropping']?>){
		              	if($("#msg6").attr('class') == 'overview-msg calibrate'  || $("#msg6").attr('class') == 'overview-msg alert-warning' || $("#msg6").attr('class') == 'overview-msg alert-error' || $("#msg6").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg6").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg6').hide();
              				$('#msg6').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[5]['rms_semi_ropping']?> && y_data < <?=$aParametros[5]['rms_ropping']?>){
	              		if($("#msg6").attr('class') == 'overview-msg calibrate'  || $("#msg6").attr('class') == 'overview-msg alert-error' || $("#msg6").attr('class') == 'overview-msg alert-success' || $("#msg6").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg6").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg6').hide();
              				$('#msg6').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[5]['rms_ropping']?>){
	              		if($("#msg6").attr('class') == 'overview-msg calibrate'  || $("#msg6").attr('class') == 'overview-msg alert-warning' || $("#msg6").attr('class') == 'overview-msg alert-success' || $("#msg6").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg6").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg6').hide();
              				$('#msg6').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>
	<?php if($count_radios > 6){?>
		$(function () {
			  $('#link-status7').show();
		      $('#gauge7').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[6]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[6]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[6]['rms_semi_ropping']?>,
		                to: <?=$aParametros[6]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[6]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[6]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg7").attr('class') == 'overview-msg calibrate'  || $("#msg7").attr('class') == 'overview-msg alert-warning' || $("#msg7").attr('class') == 'overview-msg alert-error' || $("#msg7").attr('class') == 'overview-msg alert-success'){
	              			$("#msg7").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg7').hide();
              				$('#msg7').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[6]['rms_semi_ropping']?>){
		              	if($("#msg7").attr('class') == 'overview-msg calibrate'  || $("#msg7").attr('class') == 'overview-msg alert-warning' || $("#msg7").attr('class') == 'overview-msg alert-error' || $("#msg7").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg7").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg7').hide();
              				$('#msg7').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[6]['rms_semi_ropping']?> && y_data < <?=$aParametros[6]['rms_ropping']?>){
	              		if($("#msg7").attr('class') == 'overview-msg calibrate'  || $("#msg7").attr('class') == 'overview-msg alert-error' || $("#msg7").attr('class') == 'overview-msg alert-success' || $("#msg7").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg7").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg7').hide();
              				$('#msg7').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[6]['rms_ropping']?>){
	              		if($("#msg7").attr('class') == 'overview-msg calibrate'  || $("#msg7").attr('class') == 'overview-msg alert-warning' || $("#msg7").attr('class') == 'overview-msg alert-success' || $("#msg7").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg7").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg7').hide();
              				$('#msg7').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });

	<?php } ?>
	<?php if($count_radios > 7){?>
		$(function () {
			  $('#link-status8').show();
		      $('#gauge8').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[7]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[7]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[7]['rms_semi_ropping']?>,
		                to: <?=$aParametros[7]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[7]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[7]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg8").attr('class') == 'overview-msg calibrate'  || $("#msg8").attr('class') == 'overview-msg alert-warning' || $("#msg8").attr('class') == 'overview-msg alert-error' || $("#msg8").attr('class') == 'overview-msg alert-success'){
	              			$("#msg8").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg8').hide();
              				$('#msg8').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[7]['rms_semi_ropping']?>){
		              	if($("#msg8").attr('class') == 'overview-msg calibrate'  || $("#msg8").attr('class') == 'overview-msg alert-warning' || $("#msg8").attr('class') == 'overview-msg alert-error' || $("#msg8").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg8").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg8').hide();
              				$('#msg8').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[7]['rms_semi_ropping']?> && y_data < <?=$aParametros[7]['rms_ropping']?>){
	              		if($("#msg8").attr('class') == 'overview-msg calibrate'  || $("#msg8").attr('class') == 'overview-msg alert-error' || $("#msg8").attr('class') == 'overview-msg alert-success' || $("#msg8").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg8").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg8').hide();
              				$('#msg8').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[7]['rms_ropping']?>){
	              		if($("#msg8").attr('class') == 'overview-msg calibrate'  || $("#msg8").attr('class') == 'overview-msg alert-warning' || $("#msg8").attr('class') == 'overview-msg alert-success' || $("#msg8").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg8").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg8').hide();
              				$('#msg8').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>
	<?php if($count_radios > 8){?>
		$(function () {
			  $('#link-status9').show();
		      $('#gauge9').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[8]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[8]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[8]['rms_semi_ropping']?>,
		                to: <?=$aParametros[8]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[8]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[8]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg9").attr('class') == 'overview-msg calibrate'  || $("#msg9").attr('class') == 'overview-msg alert-warning' || $("#msg9").attr('class') == 'overview-msg alert-error' || $("#msg9").attr('class') == 'overview-msg alert-success'){
	              			$("#msg9").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg9').hide();
              				$('#msg9').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[8]['rms_semi_ropping']?>){
		              	if($("#msg9").attr('class') == 'overview-msg calibrate'  || $("#msg9").attr('class') == 'overview-msg alert-warning' || $("#msg9").attr('class') == 'overview-msg alert-error' || $("#msg9").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg9").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg9').hide();
              				$('#msg9').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[8]['rms_semi_ropping']?> && y_data < <?=$aParametros[8]['rms_ropping']?>){
	              		if($("#msg9").attr('class') == 'overview-msg calibrate'  || $("#msg9").attr('class') == 'overview-msg alert-error' || $("#msg9").attr('class') == 'overview-msg alert-success' || $("#msg9").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg9").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg9').hide();
              				$('#msg9').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[8]['rms_ropping']?>){
	              		if($("#msg9").attr('class') == 'overview-msg calibrate'  || $("#msg9").attr('class') == 'overview-msg alert-warning' || $("#msg9").attr('class') == 'overview-msg alert-success' || $("#msg9").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg9").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg9').hide();
              				$('#msg9').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>
	<?php if($count_radios > 9){?>
		$(function () {
			  $('#link-status10').show();
		      $('#gauge10').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[9]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[9]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[9]['rms_semi_ropping']?>,
		                to: <?=$aParametros[9]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[9]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[9]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg10").attr('class') == 'overview-msg calibrate'  || $("#msg10").attr('class') == 'overview-msg alert-warning' || $("#msg10").attr('class') == 'overview-msg alert-error' || $("#msg10").attr('class') == 'overview-msg alert-success'){
	              			$("#msg10").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg10').hide();
              				$('#msg10').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[9]['rms_semi_ropping']?>){
		              	if($("#msg10").attr('class') == 'overview-msg calibrate'  || $("#msg10").attr('class') == 'overview-msg alert-warning' || $("#msg10").attr('class') == 'overview-msg alert-error' || $("#msg10").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg10").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg10').hide();
              				$('#msg10').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[9]['rms_semi_ropping']?> && y_data < <?=$aParametros[9]['rms_ropping']?>){
	              		if($("#msg10").attr('class') == 'overview-msg calibrate'  || $("#msg10").attr('class') == 'overview-msg alert-error' || $("#msg10").attr('class') == 'overview-msg alert-success' || $("#msg10").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg10").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg10').hide();
              				$('#msg10').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[9]['rms_ropping']?>){
	              		if($("#msg10").attr('class') == 'overview-msg calibrate'  || $("#msg10").attr('class') == 'overview-msg alert-warning' || $("#msg10").attr('class') == 'overview-msg alert-success' || $("#msg10").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg10").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg10').hide();
              				$('#msg10').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>
	<?php if($count_radios > 10){?>
		$(function () {
			  $('#link-status11').show();
		      $('#gauge11').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[10]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[10]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[10]['rms_semi_ropping']?>,
		                to: <?=$aParametros[10]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[10]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[10]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg11").attr('class') == 'overview-msg calibrate'  || $("#msg11").attr('class') == 'overview-msg alert-warning' || $("#msg11").attr('class') == 'overview-msg alert-error' || $("#msg11").attr('class') == 'overview-msg alert-success'){
	              			$("#msg11").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg11').hide();
              				$('#msg11').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[10]['rms_semi_ropping']?>){
		              	if($("#msg11").attr('class') == 'overview-msg calibrate'  || $("#msg11").attr('class') == 'overview-msg alert-warning' || $("#msg11").attr('class') == 'overview-msg alert-error' || $("#msg11").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg11").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg11').hide();
              				$('#msg11').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[10]['rms_semi_ropping']?> && y_data < <?=$aParametros[10]['rms_ropping']?>){
	              		if($("#msg11").attr('class') == 'overview-msg calibrate'  || $("#msg11").attr('class') == 'overview-msg alert-error' || $("#msg11").attr('class') == 'overview-msg alert-success' || $("#msg11").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg11").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg11').hide();
              				$('#msg11').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[10]['rms_ropping']?>){
	              		if($("#msg11").attr('class') == 'overview-msg calibrate'  || $("#msg11").attr('class') == 'overview-msg alert-warning' || $("#msg11").attr('class') == 'overview-msg alert-success' || $("#msg11").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg11").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg11').hide();
              				$('#msg11').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>
	<?php if($count_radios > 11){?>
		$(function () {
			  $('#link-status12').show();
		      $('#gauge12').highcharts({
		    
		        chart: {
		            type: 'gauge',
		            plotBackgroundColor: null,
		            plotBackgroundImage: null,
		            plotBorderWidth: 0,
		            plotShadow: false
		        },
		        exporting:{
		          enabled: false
		        },
		        credits:{
		          enabled: false
		        },
		        title: {
		            text: '<?=$aRms[11]["identificador"]?>'
		        },
		        
		        pane: {
		            startAngle: -120,
		            endAngle: 120,
		            background: [{
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#FFF'],
		                        [1, '#333']
		                    ]
		                },
		                borderWidth: 0,
		                outerRadius: '109%'
		            }, {
		                backgroundColor: {
		                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		                    stops: [
		                        [0, '#333'],
		                        [1, '#FFF']
		                    ]
		                },
		                borderWidth: 1,
		                outerRadius: '107%'
		            }, {
		                // default background
		            }, {
		                backgroundColor: '#DDD',
		                borderWidth: 0,
		                outerRadius: '105%',
		                innerRadius: '103%'
		            }]
		        },
		           
		        // the value axis
		        yAxis: {
		            min: <?=$gauge_minimo?>,
		            max: <?=$gauge_maximo?>,
		            
		            minorTickInterval: 'auto',
		            minorTickWidth: 1,
		            minorTickLength: 10,
		            minorTickPosition: 'inside',
		            minorTickColor: '#666',
		    
		            tickPixelInterval: 30,
		            tickWidth: 2,
		            tickPosition: 'inside',
		            tickLength: 10,
		            tickColor: '#666',
		            labels: {
		                step: 2,
		                rotation: 'auto'
		            },
		            // title: {
		            //     text: 'km/h'
		            // },
		            plotBands: [{
		                from: <?=$gauge_minimo?>,
		                to: <?=$aParametros[11]['rms_semi_ropping']?>,
		                color: '#55BF3B' // green
		            }, 
		            {
		                from: <?=$aParametros[11]['rms_semi_ropping']?>,
		                to: <?=$aParametros[11]['rms_ropping']?>,
		                color: '#DDDF0D' // yellow
		            }, 
		            {
		                from: <?=$aParametros[11]['rms_ropping']?>,
		                to:  <?=$gauge_maximo?>,
		                color: '#DF5353' // red
		            }]        
		        },
		    
		        series: [{
		            // name: 'Speed',
		            data: [0],
		            // tooltip: {
		            //     valueSuffix: ' km/h'
		            // }
		        }]
		    
		    }, 
		    // Add some life
		    function (chart) {
		      if (!chart.renderer.forExport) {
		          setInterval(function () {
		              var json = $.ajax({
		               url: 'json_rms_value.php?radio_id=<?=$aRms[11]["radio_id"]?>', // make this url point to the data file
		               dataType: 'json',
		               async: false
		              }).responseText;
		              var dataJson = eval(json);
		              for (var i in dataJson){
		                
		                 y_data = dataJson[i].value;                         
		              }

	              	if(y_data == -1){
	              		if($("#msg12").attr('class') == 'overview-msg calibrate'  || $("#msg12").attr('class') == 'overview-msg alert-warning' || $("#msg12").attr('class') == 'overview-msg alert-error' || $("#msg12").attr('class') == 'overview-msg alert-success'){
	              			$("#msg12").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-error").addClass("alert-disconnected");	
	              			$('#msg12').hide();
              				$('#msg12').text("Disconnected").show();
              			}	
		              }else if(y_data >= <?=$gauge_minimo?> && y_data < <?=$aParametros[11]['rms_semi_ropping']?>){
		              	if($("#msg12").attr('class') == 'overview-msg calibrate'  || $("#msg12").attr('class') == 'overview-msg alert-warning' || $("#msg12").attr('class') == 'overview-msg alert-error' || $("#msg12").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg12").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-error").removeClass("alert-disconnected").addClass("alert-success");	
	              			$('#msg12').hide();
              				$('#msg12').text("Ideal").show();
              			}
		              }else if(y_data >= <?=$aParametros[11]['rms_semi_ropping']?> && y_data < <?=$aParametros[11]['rms_ropping']?>){
	              		if($("#msg12").attr('class') == 'overview-msg calibrate'  || $("#msg12").attr('class') == 'overview-msg alert-error' || $("#msg12").attr('class') == 'overview-msg alert-success' || $("#msg12").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg12").removeClass("calibrate").removeClass("alert-error").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-warning");	
	              			$('#msg12').hide();
              				$('#msg12').text("Semiropping").show();
              			}     		
		              }else if(y_data >= <?=$aParametros[11]['rms_ropping']?>){
	              		if($("#msg12").attr('class') == 'overview-msg calibrate'  || $("#msg12").attr('class') == 'overview-msg alert-warning' || $("#msg12").attr('class') == 'overview-msg alert-success' || $("#msg12").attr('class') == 'overview-msg alert-disconnected'){
	              			$("#msg12").removeClass("calibrate").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-disconnected").addClass("alert-error");	
	              			$('#msg12').hide();
              				$('#msg12').text("Ropping").show();
              			}
		              }

		              var point = chart.series[0].points[0],
		                  newVal,
		                  inc = y_data;
		              
		              newVal = inc;
		              
		              point.update(newVal);
		              
		          }, 1000);
		      }
		    });
		  });
	<?php } ?>
</script>