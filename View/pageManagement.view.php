<style>
    th
    {
        text-align: left;
        padding: 8px 10px !important;
    }
</style>

<section class="ctn">
    <h1>Page</h1>

    <div class="ctn ctn-add">
        <button class="btnBack btnBack-add" onclick="location.href='/page-creation'">Nouveau</button>
        <button id="delete" class="btnBack btnBack-delete" onclick="deletePage()" type="button" name="button">Supprimer</button>
    </div>

    <table id="pageTable" class="stripe hover cell-border">
        <thead>
        <tr>
            <th></th>
            <th>Modifié par</th>
            <th>URI</th>
            <th>Description</th>
            <th>Dernière modification</th>
            <th>Action</th>
        </tr>
        </thead>

        <tbody id="pageList">
        </tbody>
    </table>
</section>

<script type="text/javascript">
    /**************************************************
     * EVENT LISTENER
     ***************************************************/
    $("#pageList").ready(displayPage);
</script>
