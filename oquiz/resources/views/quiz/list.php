<?= view('layout.header'); ?>
<div class="row">
    <h2> Bienvenue sur O'Quiz </h2>
    <p>

    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.
    
    </p>
</div>

<div class="row">
    <!-- 6.1.2 HOME - affiche liste des quizz + tags -->
    <?php foreach($quizTagList as $value):

        $quiz = $value['quiz'];
        $tags = $value['tags'];
    ?>

        <div class="col-sm-4">
            <h3 class="text-blue">
                <a href="<?= route('quiz_show', ['quizId' => $quiz->id]); ?>">
                    <?= $quiz->title ?>
                </a>
            </h3>
            <h5>
                <?= $quiz->description ?>
            </h5>
            <p>
                <!-- 6.1.3 HOME - affichage du user associé a l'id author -->
                <?= $userList[$quiz->app_users_id] ?>
            </p>
            <p>
                 <!-- Affichage de la liste de tag pour le quiz en cours -->
                 <?php foreach($tags as $tag):?>

                    <a href="<?= route('quiz_listByTag', ['tagId' => $tag->id])?> " class="badge badge-info mr-3 mb-3">
                        <?= $tag->name ?>
                    </a>

                <?php endforeach; ?>
            </p>
        </div>

    <?php endforeach; ?>
</div>
<?= view('layout.footer'); ?>