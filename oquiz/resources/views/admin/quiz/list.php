
<?= view('admin.layout.admin_header'); ?>

<div class="row">

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            
            <!-- Affichage des quiz pour le tag concerné -->
            <?php foreach($quizzes as $quiz):?>
                <tr>   
                    <td>
                    
                        <a href="<?= route('quiz_show', ['quizId' => $quiz->id]); ?>">
                            <?= $quiz->title ?>
                        </a>
                    
                    </td>
                    <td>
                        <a class="nav-link" href="<?= route('admin_quiz_edit', ['quizId' => $quiz->id]); ?>">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr> 
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout.footer'); ?>