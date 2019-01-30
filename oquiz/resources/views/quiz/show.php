<?= view('layout.header'); ?>

            <div class="row">
                <h2>
                    <!-- QUIZ 6.2.5 - Quiz data -->
                    <?= $currentQuiz->title ?> 

                    <!-- QUIZ 6.2.5 - Nombre de question par formulaire -->
                    <span class="badge badge-pill badge-secondary">
                        <?= count($questions) ?>  questions
                    </span>
                </h2>
            </div>

            <div class="row">
                <h4> 
                    <!-- QUIZ 6.2.5 - Quiz data -->
                    <?= $currentQuiz->description ?> 
                </h4>
            </div>

            <div class="row">
                <!-- QUIZ 6.2.6 - User data (author) -->
                <p>
                    <?= $author->firstname . ' ' . $author->lastname ?> 
                </p>
            </div>

            <div class="row">
                <!--  AFFICHAGE SUR UN QUIZ -->
                <?php foreach($tags as $tag): ?>

                    <a href="<?= route('quiz_listByTag', ['tagId' => $tag->id])?> " class="badge badge-info mr-3 mb-3">
                        <?= $tag->name ?>
                    </a>

                <?php endforeach; ?>
            </div>
   
          

            <!-- si l'utilisateur est connecté -> formulaire de jeux sinon liste -->

            <?php if($isConnected): ?>

                <?= view('quiz._formAnswer', [
                        'currentQuiz' => $currentQuiz,
                        'questions' => $questions,
                        'questionAnswerList' => $questionAnswerList,
                        'levelList' => $levelList,
                        'tag' => $tag,
                        'quizResult' => $quizResult
                ]); ?>

            <?php else: ?>

                <?= view('quiz._listAnswer', [
                        'currentQuiz' => $currentQuiz,
                        'questions' => $questions,
                        'questionAnswerList' => $questionAnswerList,
                        'levelList' => $levelList,
                        'tag' => $tag,
                ]); ?>

            <?php endif; ?>

            

<?= view('layout.footer'); ?>