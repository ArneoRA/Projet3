$(document).ready(function($){ // Des que le document est ready (chargé, on execute la fonction)

    $('.reply').click(function(e){ // Des qu'on click sur le bouton avec la class reply on execute la fonction
        e.preventDefault(); // On court-circuite l'evenement
        // ====================== On stocke les élèments dans des variables ========================== //
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

    $('.spamc').click(function(e){
        e.preventDefault();

        console.log('je suis dans spamc');
        // ====================== On stocke les élèments dans des variables ========================== //
        var Vthis = $(this); // on stocke l'élement que nous avons cliqué
        var idcom = Vthis.data('id'); // On stocke la valeur de l'identifiant du commentaire 'data-id)
        var valspam = Vthis.data('sp'); // On stocke la valeur du champ spam (data-sp)
        var epid = Vthis.data('ep'); // On Stocke la valeur de l'episode (data-ep)
        console.log('Identifiant de l\'episode : '+ epid);
        console.log('Identifiant du commentaire : ' + idcom);
        console.log ('La valeur SPAM est : ' + valspam);
        var newValSpam = valspam + 1;
        console.log('La valeur à enregistrer sera donc : ' + newValSpam);
        // ====================== Traitement par requete AJAX =========================== //
        ajaxGet("http://projet3/api/comment/" + idcom + "/spam", function (reponse){
            var messageElt = document.createElement("p");
            messageElt.textContent = "Le commentaire a bien été signalé";
            document.getElementById("info").appendChild(messageElt);
            // On ajoute la classe succes pour la mise en forme de l'affichage
            document.getElementById("info").className = "alert ";
            document.getElementById("info").className += "alert-success";
            // On recharge la page
            setTimeout("location.reload();", 2000);
        });



    })

    ////////////////////// Exécute un appel AJAX GET /////////////////////////////////////
    function ajaxGet(url, callback) {
        var req = new XMLHttpRequest();
        req.open("GET", url);
        req.addEventListener("load", function () {
            if (req.status >= 200 && req.status < 400) {
                // Appelle la fonction callback en lui passant la réponse de la requête
                callback(req.responseText);
            } else {
                console.error(req.status + " " + req.statusText + " " + url);
            }
        });
        req.addEventListener("error", function () {
            console.error("Erreur réseau avec l'URL " + url);
        });
        req.send(null);
    }

});



