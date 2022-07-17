<section class="ctn">
    <h1>Restriction Mots</h1>

    <div class="ctn ctn-add">
        <button id="add" class="btnBack btnBack-add" onclick="openBanWordForm()" type="button" name="button">Nouveau</button>
        <button id="delete" class="btnBack btnBack-delete" onclick="deleteBanWord()" type="button" name="button">Supprimer</button>
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

<div id="ctnBanWordForm"></div>

<script type="text/javascript">
    /**************************************************
     * EVENT LISTENER
     ***************************************************/
    $("#banWordList").ready(displayBanWord);
</script>
