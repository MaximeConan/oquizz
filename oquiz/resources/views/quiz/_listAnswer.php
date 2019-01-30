        
<!-- QUIZ 6.2.7 - Question data -->
<div class="row">
    <?php foreach($questions as $question): ?>
        <!-- Note: pour eviter les modulo sur l'ajout d'une div class="row" offset & co - rajouter mr-3 mb-3 pour la gestiond des espacements entre questions-->
        <div class="col-sm-3 border p-0 mr-3 mb-3">

            <!-- QUIZ 6.2.9 - Level data -->
            <?php
                $levelName = $levelList[$question->levels_id];

                //comme 3 classe différente = switch

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
                
                <div class="p-3 background-grey">
                    <?= $question->question ?> 
                </div>

                <div class="p-3 question-answer-block">


                    <!--  QUIZ 6.2.7 & QUIZ 6.2.8 - affichage propositions -->
                    
                    <ul>
                        <?php 

                        $i = 1; //optionnel (affichage)

                        foreach($questionAnswerList[$question->id] as $answer ): 

                        ?>
                            <li>
                                <?= $i ?>. <?= $answer->description ?> 
                            </li>

                        <?php

                        $i += 1;
                        endforeach; 

                        ?>

                    </ul> 
                </div>
        </div>
    <?php endforeach; ?>
</div>
