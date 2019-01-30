<?= view('layout.header'); ?>


<div class="row">
    
    <ul class="list-group">

        <li class="list-group-item">
            Nom : <?= $currentUser->lastname ?> 
        </li>

        <li class="list-group-item">
            Prenom: <?= $currentUser->firstname ?> 
        </li>

        <li class="list-group-item">
            Email : <?= $currentUser->email ?> 
        </li>

    </ul>

</div>

<?= view('layout.footer'); ?>