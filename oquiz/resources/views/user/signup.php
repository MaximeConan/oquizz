<?= view('layout.header'); ?>

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
  
<!-- // FORM LOGIN 6.4.1 ajouts champs firstname lastname -->
  <div class="form-group">
    <label for="lastname">Nom</label>
    <input type="lastname" class="form-control" id="lastname" name="lastname" aria-describedby="lastnameHelp" placeholder="Enter lastname">
  </div>

  <div class="form-group">
    <label for="firstname">Prenom</label>
    <input type="firstname" class="form-control" id="firstname" name="firstname" aria-describedby="firstnameHelp" placeholder="Enter firstname">
  </div>

  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
  </div>

  <!-- 6.4.2 input passwordConfirm  -->

  <div class="form-group">
    <label for="passwordConfirm">Confirm Password</label>
    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Password confirm">
  </div>

  <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<?= view('layout.footer'); ?>