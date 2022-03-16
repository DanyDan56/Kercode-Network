

/*************************************************************************
 *                              NEW ARTICLE
 *************************************************************************/
let newArticleEdit = document.querySelector('#new-article-edit');

// Quand l'utlisateur focus le textarea pour écrire un nouvel article
// On l'agrandi à 4 ligne
newArticleEdit.addEventListener('focusin', function() {
    // Si l'utilisateur commence un nouvel article
    if(newArticleEdit.value == newArticleEdit.defaultValue) {
        newArticleEdit.rows = 4;
    }
});

// Quand le textarea perd le focus,
// On vérifie si il y a du contenu dedans,
// Si aucun contenu n'est détecté, on remet sa taille par défaut
newArticleEdit.addEventListener('focusout', function() {
    // Si le textarea est vide, on le remet à sa hauteur initiale
    if(newArticleEdit.value == newArticleEdit.defaultValue) {
        newArticleEdit.rows = 1;
    }
});