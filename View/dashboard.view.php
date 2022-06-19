<script src="/API/amCharts/index.js"></script>
<script src="/API/amCharts/xy.js"></script>
<script src="/API/amCharts/themes/Animated.js"></script>
<script src="/SASS/JS/statistics.js"></script>

<script type='text/javascript'>
	<?php
	$php_array = $this->data['users'];
	$js_array = json_encode($php_array);
	echo "let javascript_array = ". $js_array . ";\n";
	?>
	window.addEventListener("load", loadUserByCreation(javascript_array));
</script>

<div class="statistics">
	
	<div class="odd">
		<div id="userCreationChartDiv"></div>
	</div>
	
	<div class="even">
		
		<div class="medium"></div>
		<div class="small"></div>
		
	</div>
	
</div>