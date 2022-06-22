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
        <div class="keyDataChildValue"><?php  echo $this->data['totalVisitor']; ?></div>
    </div>
    <div class="keyDataChild">
        <div class="label">Total en ligne</div>
        <div class="keyDataChildPercent neutre">Statique</div>
        <div class="keyDataChildValue"><?php  echo $this->data['totalVisitorActually']; ?></div>
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
		
		<div id="lastMessage" class="medium">
            <h3>Derniers commentaires</h3>
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Message</th>
                        <th>Date de création</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->data['messageList'] as $message) : ?>
                    <tr>
                        <td><?php echo $message['firstname'] . " "; echo $message['lastname'] ?></td>
                        <td><?php echo $message['content'] ?></td>
                        <td><?php echo date('d/m/Y',strtotime($message['creationDate'])) ?></td>
                        <td><a class="suppression">Supprimer</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
		<div class="small"></div>
		
	</div>
	
</div>