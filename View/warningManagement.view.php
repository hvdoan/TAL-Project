<section class="ctn">
	<h1>Signalements</h1>
	
	<div class="ctn ctn-delete">
		<button id="delete" class="btnBack btnBack-delete" onclick="deleteWarning()" type="button" name="button">Supprimer</button>
	</div>
	
	<table id="warningManagementTable" class="stripe hover cell-border">
		<thead>
			<tr>
				<th><input type="checkbox" onclick="checkAll(this)"></th>
				<th>Id</th>
				<th>Auteur du signalement</th>
				<th>Id Message</th>
				<th>Statut</th>
				<th>Date de création</th>
				<th>Date de mise à jour</th>
				<th></th>
			</tr>
		</thead>
		
		<tbody id="warningList"></tbody>
	</table>
</section>

<div id="ctnWarningForm"></div>

<script type="text/javascript">
	/**************************************************
	 * EVENT LISTENER
	 ***************************************************/
	$("#warningList").ready(displayWarning);
</script>
