<form action="" method="POST">

    <div class="form-inline">

        <div class="form-group">

            <input type="text" class="form-control" id="tagName" name="tagName" placeholder="Nom du tag" value="<?= (isset($tag))? $tag->name: '' ?>">

            <input type="hidden" class="form-control" id="tagId" name="tagId" value="<?= (isset($tag))? $tag->id: '' ?>">

            <input type="submit" class="btn btn-success" value="Enregistrer"/>
        </div>

    </div>

</form>