<script src="/API/amCharts/index.js"></script>
<script src="/API/amCharts/xy.js"></script>
<script src="/API/amCharts/themes/Animated.js"></script>
<script src="/SASS/JS/statistics.js"></script>

<script type='text/javascript'>
	<?php
	echo "let users = ". json_encode($this->data['users']) . ";\n";
	echo "let ratings = ". json_encode($this->data['ratings']) . ";\n";
	echo "let averageRatings = ". json_encode($this->data['averageRatings']) . ";\n";
	?>
	// console.log(ratings);
	window.addEventListener("load", loadUserByCreation(users));
	window.addEventListener("load", loadAvis(ratings, averageRatings));
</script>

<div class="keyData">
    <div class="keyDataChild">
        <div class="label">Utilisateurs inscrits</div>
        <div class="keyDataChildPercent <?php if ($this->data['percentUsers'] > 0) echo 'positif'; else echo 'neutre'; ?>"> + <?php echo $this->data['percentUsers'] ?>% en 7 jours</div>
        <div class="keyDataChildValue"><?php echo count($this->data['users']) ?></div>
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
    <pre><?php print_r($this->data['users']) ?></pre>
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
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
		<div id="logsLogin" class="small">
            <h3>Logs connexions</h3>
            <table>
                <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($this->data['logList'] as $log) : ?>
                    <tr>
                        <td><?php echo $log['firstname'] . " "; echo $log['lastname'] ?></td>
                        <td><?php echo date('d/m/Y - h:i',$log['time']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
		
	</div>
	
	<div class="odd">
		<div id="avisChartdiv"></div>
	</div>
	
</div>