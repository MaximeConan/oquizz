<?= view('layout.header'); ?>
<div class="row">
    <p>

        Filtres disponibles :

        <?php foreach($tagsToFilter as $tag):?>

            <!--
            Note : comme  je suis obligée de boucler sur l'intégralité de mes tags 
            et que je ne souhaite qu'en colorer un seul. la creation d'un tableau en amont n'est pas nécessaire (cf coloration badge level quizz)
            -->

            <?php 

                $badgeClass = '';

                //si l'id du filtre en cours est identique à celui selectionné ==> couleur différente
                if($selectedTagId == $tag->id){
                    $badgeClass = 'badge-warning';
                } else {
                    $badgeClass = 'badge-secondary';
                }

            ?>

            <a href="<?= route('quiz_listByTag', ['tagId' => $tag->id])?> " class="badge <?= $badgeClass ?> mr-3 mb-3">
                <?= $tag->name ?>
            </a>


        <?php endforeach; ?>
    
    </p>
</div>

<div class="row">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Sujet</th>
            </tr>
        </thead>
        <tbody>
            
            <!-- Affichage des quiz pour le tag concerné -->
            <?php foreach($quizTagList as $value):

                $quiz = $value['quiz'];
                $tags = $value['tags'];
            ?>
                <tr>   
                    <td>
                    
                        <a href="<?= route('quiz_show', ['quizId' => $quiz->id]); ?>">
                            <?= $quiz->title ?>
                        </a>
                    
                    </td>
                    <td>
                        <!-- Affichage de la liste de tag pour le quiz en cours -->
                        <?php foreach($tags as $tag):?>

                            <a href="<?= route('quiz_listByTag', ['tagId' => $tag->id])?> " class="badge badge-info mr-3 mb-3">
                                <?= $tag->name ?>
                            </a>

                           
                        <?php endforeach; ?>
                    </td>
                </tr> 
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout.footer'); ?>