<style>
    th
    {
        text-align: left;
        padding: 8px 10px !important;
    }
</style>

<h1>Role</h1>

<div class="ctn ctn-search">
	<input class="searchBar" type="text" placeholder="Recherche">
	<button class="btn btn-delete" type="button" name="button">Supprimer</button>
</div>

<table id="roleList">
    <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>Role</th>
            <th>Description</th>
            <th> </th>
        </tr>
    </thead>

    <tbody>
			<?php foreach ($this->data["roleList"] as $role) :?>
                <tr>
                    <td><input type="checkbox"></td>
                    <td><?= $role["name"] ?></td>
                    <td><?= $role["description"] ?></td>
                    <td><button>Editer</button></td>
                </tr>
			<?php endforeach;?>
    </tbody>
</table>

<script>
    $(document).ready( function ()
    {
        $('#roleList').DataTable();
    } );
</script>
