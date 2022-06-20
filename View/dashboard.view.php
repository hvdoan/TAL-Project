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

<div class="keyData">
    <div class="keyDataChild">
        <div class="label">Utilisateurs inscrits</div>
        <div class="keyDataChildPercent <?php if ($this->data['percentUsers'] > 0) echo 'positif'; else echo 'neutre'; ?>"> + <?php echo $this->data['percentUsers'] ?>% en 7 jours</div>
        <div class="keyDataChildValue"><?php echo count($php_array) ?></div>
    </div>
    <div class="keyDataChild">
        <div class="label">Total visiteurs</div>
        <div class="keyDataChildPercent <?php if ($this->data['totalVisitor'] > 0) echo 'positif'; elseif($this->data['totalVisitor'] == 0) echo 'neutre'; else echo 'negatif'; ?>"><?php if ($this->data['totalVisitor'] >= 0) {echo '+ ';} else { echo '-';} echo $this->data['percentTotalUser'] ?>% en 7 jours</div>
        <div class="keyDataChildValue"><?php  print_r($this->data['totalVisitor']); ?></div>
    </div>
    <div class="keyDataChild">
        <div class="label">Total en ligne</div>
        <div class="keyDataChildPercent neutre"> + 0% en 7 jours</div>
        <div class="keyDataChildValue">0</div>
    </div>
    <div class="keyDataChild">
        <div class="label">Temps moyen de connexion</div>
        <div class="keyDataChildPercent neutre"> + 0% en 7 jours</div>
        <div class="keyDataChildValue">0</div>
    </div>
</div>
<!--<div class="keyData">
    <pre><?php print_r($php_array) ?></pre>
</div>-->
<div class="statistics">
	
	<div class="odd">
		<div id="userCreationChartDiv"></div>
	</div>
	
	<div class="even">
		
		<div id="userCreationChartDiv2"></div>
		<div class="small" style="height: 300px"></div>
		
	</div>
	
</div>