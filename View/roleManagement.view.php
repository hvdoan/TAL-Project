<style>
    th
    {
        text-align: left;
        padding: 8px 10px !important;
    }

    #ctnRoleForm
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1001;
        background: rgba(0, 0, 0, .6);
    }

    #ctnRoleForm > form
    {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<section class="ctn">
    <h1>Role</h1>

    <div class="ctn ctn-search">
        <input class="searchBar" type="text" placeholder="Recherche">
        <button id="add" class="btn btn-add" onclick="openForm()" type="button" name="button">Nouveau</button>
        <button id="delete" class="btn btn-delete" onclick="deleteRole()" type="button" name="button">Supprimer</button>
    </div>

    <table id="roleTable">
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

<script src="../CSS/dist/crudRole.js"></script>
