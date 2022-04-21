<script src="../SASS/JS/crudUserManagement.js"></script>

<section class="ctn">
	
	<h1>Utilisateurs</h1>
	<div class="ctn ctn-delete">
		<button id="delete" class="btn btn-delete" onclick="deleteUser()" type="button" name="button">Supprimer</button>
	</div>
	
	<table id="userManagementTable" class="stripe hover cell-border">
		<thead>
			<tr>
				<th></th>
				<th>Identifiants</th>
				<th>Utilisateurs</th>
				<th>Emails</th>
				<th>Rôles</th>
				<th></th>
			</tr>
		</thead>
		<tbody id="userList">
		</tbody>
	</table>
</section>

<div id="ctnUserForm"></div>