var app = {

    init: function() {
        $('.edit-answer').on('click', app.editAnswer);
        $('.validate-answer').on('click', app.updateAnswer);
        $('.add-tag').on('click', app.displayTagList);
        $('.validate-tag').on('click', app.addTagToQuiz);
        $('.delete-tag').on('click', app.deleteTagToQuiz);
    },

    //rend visible la zone de saisie + bouton validation
    editAnswer: function() {
        var answerId = $(this).data('id');

        $('.label-answer-'+ answerId ).toggleClass('d-none');
        $('.update-answer-input-'+ answerId ).toggleClass('d-none');
        $('.update-answer-'+ answerId ).toggleClass('d-none');
    },

    //met a jour le contenu de la reponse
    updateAnswer: function() {

        //recupere l'id DB de la reponse a modifier
        var answerId = $(this).data('id');

        //recupere le texte modifié a remplacer en DB
        var answerText = $('.update-answer-input-'+ answerId).val();

        xhr = $.ajax(
            editAnswerUrl,
            {
                method: 'POST',
                data: {
                    'answerId' : answerId,
                    'answerNewValue' : answerText
                }
            }

        ).done(function(data) {

            // On récupère les données reçues  (data) via le controller AnswerController
            var answerId = data.values.answerId;
            var answerText = data.values.answerText;

            //on update les champs concerné
            $('.label-answer-'+ answerId ).text(answerText);
            $('.update-answer-input-'+ answerId ).val(answerText);

            //on retablit les classes d'origine avec la nouvelle valeur en DB (input caché + label visible)
            $('.label-answer-'+ answerId ).toggleClass('d-none');
            $('.update-answer-input-'+ answerId ).toggleClass('d-none');
            $('.update-answer-'+ answerId ).toggleClass('d-none');

        });
    },

    displayTagList : function() {
        $('#availableTag' ).toggleClass('d-none');
        $('.validate-tag').toggleClass('d-none');
    },

    addTagToQuiz : function() {

         var quizId = $("#quizId").val();
         var tagId = $("#availableTag").val();

         xhr = $.ajax(
            addTagToQuizUrl,
             {
                 method: 'POST',
                 data: {
                     'quizId' : quizId,
                     'tagId' : tagId
                 }
             }
 
         ).done(function(data) {
 
            // On récupère les données reçues  (data) via le controller QuizController
            var availableTagForQuiz = data.values.availableTagForQuiz;
            var tagList = data.values.tagList;
            
            app.refreshTagDisplay(availableTagForQuiz, tagList);  

            $('#availableTag' ).toggleClass('d-none');
            $('.validate-tag').toggleClass('d-none');
 
         })
    },

    deleteTagToQuiz : function(event) {
        
        var quizId = $("#quizId").val();
        var tagId = $(this).data('id');

        console.log(tagId);
        xhr = $.ajax(
           deleteTagToQuizUrl,
            {
                method: 'POST',
                data: {
                    'quizId' : quizId,
                    'tagId' : tagId
                }
            }

        ).done(function(data) {
            
           // On récupère les données reçues  (data) via le controller QuizController

           var availableTagForQuiz = data.values.availableTagForQuiz;
           var tagList = data.values.tagList;
           
           app.refreshTagDisplay(availableTagForQuiz, tagList);     
        })
   },

   // factorisation pour addTag + deleteTag
   refreshTagDisplay: function(availableTagForQuiz, tagList) {

        //on supprime toutes les options actuelles

        $('#availableTag').children('option:not(:first)').remove();

        //on reconstruit les options du select a mettre a jour

        $(availableTagForQuiz).each(function(index) {

            //on ajoute les nouvelles options
            $('#availableTag' ).append('<option value="' + $(this)[0].id + '">' + $(this)[0].name + '</option>');
        });

        // on vide les affichés tags existants

        $('#quizTagList').html('');

        $(tagList).each(function(id) {

            //on ajoute les tags associés mis a jour
            var html = '<span class="badge badge-info ml-3 mb-1">' + $(this)[0].name + '</span>';
                html += ' <i data-id="'+ $(this)[0].id +'" class="fas fa-times delete-tag"></i>';

            $(html).appendTo('#quizTagList');
        });

        //je rapplique mon event delete sur mes nouveau element génénéré apres le call ajax
        $('.delete-tag').on('click', app.deleteTagToQuiz);
   }

};

$(app.init);