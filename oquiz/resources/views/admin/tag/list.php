<?= view('admin.layout.admin_header'); ?>

<div class="row">
        <a href="<?= route('admin_tag_add'); ?>" class="btn btn-success mb-3">
            <i class="fas fa-plus"></i>
            Ajouter
        </a>
</div>
<div class="row">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            <!-- Affichage des quiz pour le tag concerné -->
            <?php foreach($tags as $tag):?>
                <tr>   
                    <td>

                        <?= $tag->name ?>
                    </td>
                    <td>
                        <a href="<?= route('admin_tag_edit', ['tagId' => $tag->id]); ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= route('admin_tag_delete', ['tagId' => $tag->id]); ?>">
                            <i class="fas fa-times text-danger"></i>
                        </a>
                    </td>
                </tr> 
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout.footer'); ?>