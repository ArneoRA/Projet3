$(document).ready(function($){ // Des que le document est ready (chargé, on execute la fonction)

    $('.reply').click(function(e){ // Des qu'on click sur les boutons avec la class reply on execute la fonction
        e.preventDefault(); // On court-circuite l'evenement
        // On stocke les élèments nécessaires dans des variables
        console.log('Je suis activé');
        var $form = $('#comment'); // on stock le formulaire dont l'id est "comment_contenu"
        var Vthis = $(this); // on stocke l'élement que nous avons cliqué
        var parent_id = Vthis.data('id'); // On stocke la valeur du parentid
        var $comment = $('#comment-' + parent_id); // On stocke le commentaire correspondant au parent_id
        var commParentId = document.getElementById('comment_parentid'); // On stock le champ Parent_id du formulaire
        var commNiveau = Vthis.data('niv'); // On stock le champ Niveau du formulaire
        var test = commParentId.value;
        console.log($form);
        console.log(Vthis);
        console.log(parent_id);
        console.log($comment);
        console.log(test);
        console.log(commNiveau);
        console.log(commNiveau + 1);

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

    // // Appel de la fonction valider
    valider();

});


function valider(){

        console.log('je passe ici');
        // Déclaration des variables
        var $tForm = $('#eForm'); // On stocke le formulaire
        console.log ('Contenu de la variable $tForm : ' + $tForm);
        var titrEpi = document.getElementById('episode_titre'); //$('#episode_titre');
        console.log (titrEpi);
        var test1 = titrEpi.value;
        console.log('la valeur du titre est : ' + test1);
        var contEpi = tinyMCE.get('episode_contenu').getContent(); //$('#mceu_25');
        // console.log ('Contenu de la varaible contEpi : ' + contEpi);

        // Traitement
        if (!test1 || !contEpi) {
            console.log ('Le titre est vide : ' + test1);
            console.log ('Le contenu est vide aussi : ' + contEpi);

        } else{
            console.log ('Le titre est devenu : ' + test1);
            console.log ('Le contenu est devenu : ' + contEpi);
        }

        //     // Nous affichons le message suivant
        //     console.log('je passe dans le test');
        //     swal({
        //         title: "Veuillez Saisir un titre et un contenu à votre episode",
        //         text: "",
        //         type: "warning",
        //         confirmButtonText: "Ok"
        //     });
        //     return false;
        //     }
        //     else {
        //         // Sinon, le formulaire est envoyé pour enregistrement
                return false;
        //     }
    }
