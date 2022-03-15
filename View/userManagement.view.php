<script>
	$(document).ready(function (){
		$('#userManagementTable').DataTable();
	});
</script>
<script src="../CSS/dist/crudUserManagement.js"></script>

<section class="ctn">
	
	<h1>Utilisateurs</h1>
	<div class="ctn ctn-search">
		<button id="add" class="btn btn-add" onclick="openForm()" type="button" name="button">Nouveau</button>
		<button id="delete" class="btn btn-delete" onclick="deleteRole()" type="button" name="button">Supprimer</button>
	</div>
	
	<table id="userManagementTable" class="stripe hover">
		<thead>
			<tr>
				<th><input type="checkbox"></th>
				<th>Identifiants</th>
				<th>Utilisateurs</th>
				<th>Emails</th>
				<th>Rôles</th>
			</tr>
		</thead>
		<tbody>
			
			<?php foreach($this->data["usersList"] as $user):?>
				<tr>
					<td><input type="checkbox" name="identifiant"></td>
					<td><?=$user->getId()?></td>
					<td><?=$user->getFirstname() . " " . $user->getLastname()?></td>
					<td><?=$user->getEmail()?></td>
					<td><?=$user->getIdRole()?></td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</section>

<div id="ctnRoleForm"></div>