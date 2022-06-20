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

<style>
    .keyData {
        display: flex;
        padding: 10px;
        margin: 2%;
        background-color: white;
        border-radius: 10px;
        justify-content: space-evenly;
        align-items: center;
        height: 120px;
        box-shadow: rgb(99 99 99 / 20%) 0 2px 8px 0;
        font-family: "Jaldi", sans-serif;
    }

    .keyDataChild {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 2.5rem;
    }

    .label {
        font-size: 1.4rem;

    }

    .keyDataChildPercent {
        font-size: 1rem;
        font-weight: bold;
        color: white;
        padding: 0 10px;
        border-radius: 5px;
    }

    .keyDataChildValue {
        font-weight: bold;
    }

    .positif {
       background-color: green;
    }
    .negatif {
       background-color: darkred;
    }
    .neutre {
        background-color: #3F445F;
    }
</style>

<div class="keyData">
    <div class="keyDataChild">
        <div class="label">Utilisateurs inscrits</div>
        <div class="keyDataChildPercent positif"> + <?php echo $this->data['percentUsers'] ?>% en 7 jours</div>
        <div class="keyDataChildValue"><?php echo count($php_array) ?></div>
    </div>
    <div class="keyDataChild">
        <div class="label">Total visiteurs</div>
        <div class="keyDataChildPercent negatif"> - 2% en 7 jours</div>
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