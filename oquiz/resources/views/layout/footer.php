
        </main>

        <script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

        

        <!-- recuperation dynamique des routes pour les appel sajax car non possible directement dans le js -->

        <script>

            var editAnswerUrl = "<?= route('admin_answer_edit'); ?>";
            var addTagToQuizUrl = "<?= route('admin_quiz_add_tag'); ?>";
            var deleteTagToQuizUrl = "<?= route('admin_quiz_delete_tag'); ?>";

        </script>

        <!-- JS pour edit equestion -->

        <script src="<?= url('js/app.js'); ?>">
        </script>
    </body>
</html>