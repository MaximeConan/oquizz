<?= view('admin.layout.admin_header'); ?>

<form action="" method="POST">

    <div class="row">

        <!-- affichage données principale a saisir -->
        <div class="col-sm-6">
            <div class="form-group">
                <label for="title"> Titre </label>
                <input type="text" value="<?= $currentQuiz->title ?>" class="form-control" id="quizTitle" name="quizTitle" placeholder="titre">
            </div>

            <div class="form-group">
                <label for="description"> Description </label>
                <input type="text" value="<?= $currentQuiz->description ?>" class="form-control" id="quizDescription" name="quizDescription" placeholder="description">
            </div>
        </div>
   

        <div class="col-sm-6">
          
            <div class="form-group">
                <label for="title">  Auteur </label>

                <select type="text" id="userId" name="userId" placeholder="userId">
                    <?php foreach($authors as $author): ?>
                        <option value="<?= $author->id ?>">
                            <?= $author->firstname . ' ' . $author->lastname  ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="form-inline">

            <!--  GESTION DES TAGS -->
            <div class="form-group">

                <p> Tags associés : </p>
                
                <div id="quizTagList">
                    <?php foreach($tags as $tag): ?>

                        <span class="badge badge-info ml-3 mb-1">
                            <?= $tag->name ?>
                        </span>

                        <i data-id="<?= $tag->id ?>" class="fas fa-times delete-tag" ></i>
                    <?php endforeach; ?>
                </div>

                <span title="add new tag" class="add-tag badge badge-success ml-3 mb-1">
                    <i class="fas fa-plus" ></i>
                </span>
            </div>
            
                <div class="form-group">
                    <select class="form-control d-none" name="availableTag" id="availableTag">
                        <?php foreach($availableTags as $tag): ?>

                            <option value="<?= $tag->id ?>">
                                <?= $tag->name ?>
                            </option>

                        <?php endforeach; ?>
                        
                    </select>          
                </div>

                <div class="form-group">
                    <span class="ml-1 fas fa-check d-none validate-tag" title="valider l'ajout"></span>
                </div>
            <div>
            
        </div>

    </div>
    <div class="row">

        <?php foreach($questions as $question): ?>

            <div class="col-sm-3 border p-0 mr-3 mb-3">
                 
                     <!-- liste levels + titre -->
                    <div class="p-3 background-grey">

                        <div class="form-group">

                            <!-- pour obtenir dynamiquement les info coté php : concatenation de l'id question + name -->
                            <select class="form-control" id="questionLevel-<?= $question->id ?>" name="questionLevel-<?= $question->id ?>">

                                <?php foreach($levelList as $levelId => $levelName):
                               
                                    $selected = '';

                                    if($levelId == $question->levels_id){
                                        $selected = 'selected';
                                    }
                                ?>

                                    <option value="<?= $levelId ?>" <?= $selected ?>>
                                        <?= $levelName ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" value="<?= $question->question ?>" class="form-control" id="questionLabel-<?= $question->id ?>" name="questionLabel-<?= $question->id ?>">
                        </div>
                    </div>

                    <div class="p-3 question-answer-block">

                            <?php 

                            $i = 1; 

                            foreach($questionAnswerList[$question->id] as $answer ): 

                                //css de la bonne reponse selectionné
                                $selectedGoodAnswerClass = '';
                                $checked = '';

                                if($question->answers_id == $answer->id){
                                    $selectedGoodAnswerClass = 'text-success';
                                    $checked = 'checked';

                                }
                            ?>

                                <div class="form-check">

                                    <input class="form-check-input" type="radio" name="questionGoodAnswer-<?= $question->id ?>" id="questionGoodAnswer-<?= $question->id ?>" value="<?= $answer->id ?>"  <?= $checked ?> />
                                    
                                    <i data-id="<?= $answer->id ?>" class="fas fa-edit edit-answer <?= $selectedGoodAnswerClass ?>" ></i>
                                    
                                    <!-- class label-answer génré dynamiquement pour l'edition coté js -->

                                    <label class="form-check-label <?= $selectedGoodAnswerClass ?> label-answer-<?= $answer->id ?>" for="questionGoodAnswer-<?= $question->id ?>">
                                        <?= $answer->description ?> 
                                    </label>

                                    <!-- input hidden pour edition du label question -->
                                    
                                    <input type="text" value="<?= $answer->description ?>" class="d-none update-answer-input-<?= $answer->id ?>">

                                    <i data-id="<?= $answer->id ?>" class="fas fa-check d-none update-answer-<?= $answer->id ?> validate-answer" ></i>
                                    
                                </div>

                            <?php

                            $i += 1;
                            endforeach; 

                            ?>
                          
                       
                    </div>

                    <div class="p-3 background-grey question-answer-block"> 

                        <div class="form-group">
                            <label for="questionAnecdote-<?= $question->id ?>">Anecdote</label>
                            
                            <textarea class="form-control" id="questionAnecdote-<?= $question->id ?>" name="questionAnecdote-<?= $question->id ?>" rows="5"><?= $question->anecdote ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="questionWiki-<?= $question->id ?>">https://fr.wikipedia.org/wiki/</label>
                            <input type="text" value="<?= $question->wiki ?>" class="form-control" id="questionWiki-<?= $question->id ?>" name="questionWiki-<?= $question->id ?>">
                        </div>
                    </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="row mt-3">
            <input type="hidden" name="quizId" id="quizId" value="<?= $currentQuiz->id ?>">
            <input type="submit" class="btn btn-primary background-blue btn-lg btn-block" value="Editer"/>
    </div>
  
</form>

<?= view('layout.footer'); ?>
                    