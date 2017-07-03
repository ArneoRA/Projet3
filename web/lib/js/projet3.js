$(document).ready(function($){ // Des que le document est ready (chargé, on execute la fonction)

    $('.reply').click(function(e){ // Des qu'on click sur le bouton avec la class reply on execute la fonction
        e.preventDefault(); // On court-circuite l'evenement
        // ====================== On stocke les élèments dans des variables ========================== //
        // console.log('Je suis activé');
        var $form = $('#comment'); // on stock le formulaire dont l'id est "comment_contenu"
        var Vthis = $(this); // on stocke l'élement que nous avons cliqué
        var parent_id = Vthis.data('id'); // On stocke la valeur du parentid
        var $comment = $('#comment-' + parent_id); // On stocke le commentaire correspondant au parent_id
        var commParentId = document.getElementById('comment_parentid'); // On stock le champ Parent_id du formulaire
        var commNiveau = Vthis.data('niv'); // On stock le champ Niveau du formulaire
        var test = commParentId.value;
        // console.log($form);
        // console.log(Vthis);
        // console.log(parent_id);
        // console.log($comment);
        // console.log(test);
        // console.log(commNiveau);
        // console.log(commNiveau + 1);

        // ====================== Traitement =========================== //
        // On modifie le titre du formulaire pour que le H3 corresponde à une réponse
        $form.find('h4').text('Répondre à ce commentaire');
        // On change la valeur de notre champs caché comment_parentid afin qu'il prenne la bonne valeur
        $('#comment_parentid').val(parent_id);
        // On change la valeur de notre champs caché comment_niveau afin qu'il prenne la bonne valeur
        $('#comment_niveau').val(commNiveau);
        // On insere notre formulaire APRES (after) notre commentaire
        $comment.after($form);
    });

    $('.spamc').click(function(e){
        e.preventDefault();

        console.log('je suis dans spamc');
        // ====================== On stocke les élèments dans des variables ========================== //
        var Vthis = $(this); // on stocke l'élement que nous avons cliqué
        var idcom = Vthis.data('id'); // On stocke la valeur de l'identifiant du commentaire 'data-id)
        console.log('Identifiant du commentaire : ' + idcom);

        // ====================== Traitement par requete AJAX =========================== //
        // En utilisant la fonction Ajax de JQUERY au lieu de la fonction du cours
        $.ajax({
            url : 'http://projet3/api/comment/' + idcom + '/spam',
            type : 'GET',
            dataType : 'html',
            success : function(code_html, statut){
                // On affiche la zone qui est masqué par le CSS
                $("#info").show();
                // On ajoute le message d'alerte dans la zone info
                $('<p>', {
                    text: 'Le commentaire a bien été signalé'
                }).appendTo("#info");
                // On le supprime apres 4 secondes
                $("#info").fadeOut(4000, function(){
                    $("#info").empty();
                });
            },
            error : function(resultat, statut, erreur){
                alert('Il y a eu un souci : ' + resultat + ' dont l\'erreur est : '+ erreur)
            }
        });

    })

});
