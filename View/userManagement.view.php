<script>
	$(document).ready(function (){
		$('#userManagementTable').DataTable();
	});
</script>

<?php

//var_dump($data["usersList"]);
//$this->includePartial("form", $user->getRegisterForm());

?>

<section class="ctn">
	
	<table id="userManagementTable" class="stripe hover">
		<thead>
			<tr>
				<th><input type="checkbox" name="identifiant"></th>
				<th>Identifiant</th>
				<th>Utilisateur</th>
				<th>Email</th>
				<th>Rôle</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				
				<td><input type="checkbox" name="identifiant"></td>
				<td>6</td>
				<td>DOAN Hoai-Viet Luc</td>
				<td>luc@gmail.com</td>
				<td>Administrateur</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="identifiant"></td>
				<td>7</td>
				<td>HERVE Théo</td>
				<td>theo@gmail.com</td>
				<td>Administrateur</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="identifiant"></td>
				<td>8</td>
				<td>HARDY Alexandre</td>
				<td>alexandre@gmail.com</td>
				<td>Administrateur</td>
			</tr>
		</tbody>
	</table>

</section>
<!--<section class="ctn">-->
<!--	<h1>Utilisateurs</h1>-->
<!--	-->
<!--	<div class="ctn-search">-->
<!--		<input class="searchBar" type="text" name="search" placeholder="Rechercher">-->
<!--		<button class="btn btn-delete">Supprimer</button>-->
<!--	</div>-->
<!--	-->
<!--	<div class="table">-->
<!--		<div class="thead">-->
<!--			<div class="tr">-->
<!--				<input class="th" type="checkbox" name="identifiant">-->
<!--				<span class="th">Identifiant</span>-->
<!--				<span class="th">Utilisateur</span>-->
<!--				<span class="th">Email</span>-->
<!--				<span class="th">Rôle</span>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="tbody">-->
<!--			<div class="tr uneven">-->
<!--				<input class="td" type="checkbox" name="identifiant">-->
<!--				<span class="td">6</span>-->
<!--				<span class="td">DOAN Hoai-Viet Luc</span>-->
<!--				<span class="td">luc@gmail.com</span>-->
<!--				<span class="td">Administrateur</span>-->
<!--			</div>-->
<!--			<div class="tr even">-->
<!--				<input class="td" type="checkbox" name="identifiant">-->
<!--				<span class="td">7</span>-->
<!--				<span class="td">HERVE Théo</span>-->
<!--				<span class="td">theo@gmail.com</span>-->
<!--				<span class="td">Administrateur</span>-->
<!--			</div>-->
<!--			<div class="tr uneven">-->
<!--				<input class="td" type="checkbox" name="identifiant">-->
<!--				<span class="td">8</span>-->
<!--				<span class="td">HARDY Alexandre</span>-->
<!--				<span class="td">alexandre@gmail.com</span>-->
<!--				<span class="td">Administrateur</span>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</section>-->