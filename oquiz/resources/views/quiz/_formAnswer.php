
<!-- affichage du score -->
<?php if(isset($quizResult['byQuestion'])):  ?>

    <div class="row alert alert-info">

        <p>
            Votre score <?= $quizResult['total']; ?> / <?= count($quizResult['byQuestion']); ?> - 
            <a href="<?= route('quiz_show', ['quizId' => $currentQuiz->id]); ?>"> Rejouer ? </a>
        </p>
        
    </div>

<?php endif; ?>


<form action="" method="POST">
    <div class="row">
        <?php foreach($questions as $question): ?>

            <div class="col-sm-3 border p-0 mr-3 mb-3">

                <?php
                    $levelName = $levelList[$question->levels_id];

                    switch($levelName){
                        case 'Débutant':
                            $badgeClass = "badge-success";
                        break;
                        case 'Confirmé':
                            $badgeClass = "badge-warning";
                        break;
                        case 'Expert':
                            $badgeClass = "badge-danger";
                        break;
                        default:
                            $badgeClass = "badge-success";
                        ;
                    }
                ?>
                <span class="badge <?= $badgeClass ?>  float-right mt-2 mr-2"><?= $levelName ?></span>
                    
                    <!-- test de reponse à la question pour appliquer la bonne classe css -->
                    <?php

                        if(isset($quizResult['byQuestion'])){ // si formulaire envoyé

                            $resultClass = ($quizResult['byQuestion'][$question->id]) ? 'alert alert-success' : 'alert alert-danger';

                        } else {
                            $resultClass = 'background-grey';
                        }

                    ?>

                    <div class="p-3 <?= $resultClass ?>">
                        <?= $question->question ?> 
                    </div>

                    <div class="p-3 question-answer-block">

                            <?php 

                            $i = 1; 

                            foreach($questionAnswerList[$question->id] as $answer ): 

                            ?>
                            <!-- 
                            j'utilise pour chaque radioButton l'id de ma question afin de ne pouvoir repondre qu'a un seul choix proposé. 
                            Pour chaque choix j'attribue l'id de ma réponse afin de pouvoir verifier a terme dans ma db, si la colonne qui contient la bonne reponse (answers_id)
                            est bien celle envoyée. 
                            -->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="<?= $question->id ?>" id="<?= $question->id ?>" value="<?= $answer->id ?>" />
                                    <label class="form-check-label" for="<?= $question->id ?>">
                                        <?= $answer->description ?> 
                                    </label>
                                </div>

                            <?php

                            $i += 1;
                            endforeach; 

                            ?>
                          
                       
                    </div>
                    <!-- affichage block anecdocte -->
                    <?php if(isset($quizResult['byQuestion'])): ?>
                        <div class="p-3 background-grey question-answer-block"> 
                            <?= $question->anecdote ?> - 
                            <a href="https://fr.wikipedia.org/wiki/<?= $question->wiki ?>">Wikipedia</a>
                        </div>
                    <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Si le form n'a pas été encore envoyé => input submit sinon lien vers la page en cours (reset du score) -->
    <?php if(!isset($quizResult['byQuestion'])):  ?>

        <div class="row mt-3">
                <input type="submit" class="btn btn-primary background-blue btn-lg btn-block" value="Valider les réponses"/>
        </div>

    <?php else: ?>

        <div class="row mt-3">
            <a href="<?= route('quiz_show', ['quizId' => $currentQuiz->id]); ?>" class="btn btn-success btn-lg btn-block"> Rejouer </a>
        </div>

    <?php endif; ?>
  
</form>
                    