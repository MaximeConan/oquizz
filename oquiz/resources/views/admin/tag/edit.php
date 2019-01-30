<?= view('admin.layout.admin_header'); ?>

<h2> Modifier un tag </h2>

<?= view('admin.tag._form_edit_add', ['tag' => $tag]); ?>

<?= view('layout.footer'); ?>