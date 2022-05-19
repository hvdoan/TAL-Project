<section class="ctn">
    <h1>Forums</h1>

    <div class="ctn ctn-add">
        <button id="add" class="btn btn-add" onclick="openForumForm()" type="button" name="button">Nouveau</button>
        <button id="delete" class="btn btn-delete" onclick="deleteForum()" type="button" name="button">Supprimer</button>
    </div>

    <table id="forumManagementTable" class="stripe hover cell-border">
        <thead>
	        <tr>
	            <th><input type="checkbox" onclick="checkAll(this)"></th>
	            <th>Id</th>
	            <th>Titre</th>
	            <th>Contenu</th>
	            <th>Catégorie</th>
	            <th>Auteur</th>
	            <th>Date de création</th>
	            <th>Date de mise à jour</th>
	            <th></th>
	        </tr>
        </thead>

        <tbody id="forumList"></tbody>
    </table>
</section>

<div id="ctnForumForm"></div>

<script type="text/javascript">
	/**************************************************
	 * EVENT LISTENER
	 ***************************************************/
	$("#forumList").ready(displayForum);
</script>
