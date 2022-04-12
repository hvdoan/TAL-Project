<section class="ctn">
	<h1>Paliers de donation</h1>
	
	<div class="ctn ctn-add">
		<button id="add" class="btn btn-add" onclick="openForm()" type="button" name="button">Nouveau</button>
		<button id="delete" class="btn btn-delete" onclick="deleteDonationTier()" type="button" name="button">Supprimer</button>
	</div>
	
	<table id="donationTierTable" class="stripe hover cell-border">
		<thead>
			<tr>
				<th><input type="checkbox" onclick="checkAll(this)"></th>
				<th>Id</th>
				<th>Nom</th>
				<th>Description</th>
				<th>Prix</th>
				<th></th>
			</tr>
		</thead>
		
		<tbody id="donationTierList"></tbody>
	</table>
</section>

<div id="ctnDonationTierForm"></div>

<script src="../CSS/dist/crudDonationTier.js"></script>
