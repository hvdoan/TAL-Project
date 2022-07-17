<section class="ctn">
	<h1>Messages</h1>
	
	<div class="ctn ctn-add">
		<button id="add" class="btnBack btnBack-add" onclick="openMessageForm()" type="button" name="button">Nouveau</button>
		<button id="delete" class="btnBack btnBack-delete" onclick="deleteMessage()" type="button" name="button">Supprimer</button>
	</div>
	
	<table id="messageManagementTable" class="stripe hover cell-border">
		<thead>
			<tr>
				<th><input type="checkbox" onclick="checkAll(this)"></th>
				<th>Id</th>
				<th>Auteur</th>
				<th>Forum relié</th>
				<th>Id message parent</th>
				<th>Contenu</th>
				<th>Date de création</th>
				<th>Date de mise à jour</th>
				<th></th>
			</tr>
		</thead>
		
		<tbody id="messageList"></tbody>
	</table>
</section>

<div id="ctnMessageForm"></div>

<script type="text/javascript">
	/**************************************************
	 * EVENT LISTENER
	 ***************************************************/
	$("#messageList").ready(displayMessage);
</script>
