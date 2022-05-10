<section class="ctn">
	<h1>Catégories</h1>
	
	<div class="ctn ctn-add">
		<button id="add" class="btn btn-add" onclick="openForm()" type="button" name="button">Nouveau</button>
		<button id="delete" class="btn btn-delete" onclick="deleteTag()" type="button" name="button">Supprimer</button>
	</div>
	
	<table id="tagTable" class="stripe hover cell-border">
		<thead>
			<tr>
				<th><input type="checkbox" onclick="checkAll(this)"></th>
				<th>Id</th>
				<th>Nom</th>
				<th>Description</th>
				<th></th>
			</tr>
		</thead>
		
		<tbody id="tagList"></tbody>
	</table>
</section>

<div id="ctnTagForm"></div>

<script src="../CSS/dist/crudTag.js"></script>
