<section class="ctn">
    <h1>Role</h1>

    <div class="ctn ctn-add">
        <button id="add" class="btn btn-add" onclick="openRoleForm()" type="button" name="button">Nouveau</button>
        <button id="delete" class="btn btn-delete" onclick="deleteRole()" type="button" name="button">Supprimer</button>
    </div>

    <table id="roleTable" class="stripe hover cell-border">
        <thead>
	        <tr>
	            <th><input type="checkbox" onclick="checkAll(this)"></th>
	            <th>Role</th>
	            <th>Description</th>
	            <th></th>
	        </tr>
        </thead>

        <tbody id="roleList"></tbody>
    </table>
</section>

<div id="ctnRoleForm"></div>

<script type="text/javascript">
    /**************************************************
     * EVENT LISTENER
     ***************************************************/
    $("#roleList").ready(displayRole);
</script>
