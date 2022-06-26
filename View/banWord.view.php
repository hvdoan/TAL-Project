<section class="ctn">
    <h1>Restriction Mots</h1>

    <div class="ctn ctn-add">
        <button id="add" class="btn btn-add" onclick="openMessageForm()" type="button" name="button">Nouveau</button>
        <button id="delete" class="btn btn-delete" onclick="deleteMessage()" type="button" name="button">Supprimer</button>
    </div>

    <table id="banWordTable" class="stripe hover cell-border">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="checkAll(this)"></th>
            <th>Id</th>
            <th>Mot</th>
            <th>Date de création</th>
            <th>Date de mise à jour</th>
            <th></th>
        </tr>
        </thead>

        <tbody id="banWordList"></tbody>
    </table>
</section>

<div id="ctnMessageForm"></div>

<script type="text/javascript">
    /**************************************************
     * EVENT LISTENER
     ***************************************************/
    $("#banWordList").ready(displayBanWord);
</script>
