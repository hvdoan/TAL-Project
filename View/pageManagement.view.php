<style>
    th
    {
        text-align: left;
        padding: 8px 10px !important;
    }
</style>

<section class="ctn">
    <h1>Page</h1>

    <div class="ctn ctn-search">
        <input class="searchBar" type="text" placeholder="Recherche">
        <button id="delete" class="btn btn-delete" onclick="deleteRole()" type="button" name="button">Supprimer</button>
    </div>

    <table id="pageTable">
        <thead>
        <tr>
            <th><input type="checkbox"></th>
            <th>Utilisateur</th>
            <th>URI</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody id="pageList">
        </tbody>
    </table>
</section>

<script src="../CSS/dist/crudPage.js"></script>
<script>
    $(document).ready( function ()
    {
        $('#pageTable').DataTable();
    } );
</script>