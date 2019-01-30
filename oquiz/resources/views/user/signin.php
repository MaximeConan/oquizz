<?= view('layout.header'); ?>

<!-- // FORM LOGIN 6.3.9 - Affichage des erreurs -->
 <?php if (!empty($errorList)) : ?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    <?php foreach ($errorList as $currentError) : ?>
        <?= $currentError ?><br>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="POST">

  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>

<!-- // FORM LOGIN 6.4.1 ajout link signup -->
<br>
<a href="<?= route('user_signup'); ?>"> Pas encore de compte ? Inscrivez vous ! </a>

<?= view('layout.footer'); ?>