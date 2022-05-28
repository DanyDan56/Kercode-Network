

/*************************************************************************
/**                              NEW ARTICLE
/*************************************************************************/

/************************** TEXTE ARTICLE *************************/

// On récupère le textarea
let newArticleEdit = document.querySelector('#new-article-edit');

// Quand l'utlisateur focus le textarea pour écrire un nouvel article
// On l'agrandi à 4 ligne
if (newArticleEdit) {
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
};

/************************** SELECTION IMAGES *************************/

// On récupère le bouton de sélection des images et la div .preview
let articleImage = document.querySelector("#image-article");
let previewImage = document.querySelector(".image-preview");

if (articleImage) {
    // On rend invisible. On préfère opacity = 0 que display = hidden pour l'accessibilité
    articleImage.style.opacity = 0;

    // Ajout du gestionnaire d'évènement au bouton de sélection d'images
    articleImage.addEventListener('change', function() {
        // On vide le contenu de la div
        while (previewImage.firstChild) {
            previewImage.removeChild(previewImage.firstChild);
        }

        // On récupère les informations des images sélectionnées
        let curFiles = articleImage.files;

        // Si des images sont sélectionnées
        if (curFiles.length > 0) {
            let list = document.createElement('ul');
            previewImage.appendChild(list);

            // On parcours toutes les images
            for (let i = 0; i < curFiles.length; i++) {
                console.log(curFiles);
                let listItem = document.createElement('li');

                // Si l'image est du bon type
                if (validFileType(curFiles[i])) {
                    let image = document.createElement('img');
                    image.src = window.URL.createObjectURL(curFiles[i]);
                    listItem.appendChild(image);
                } else {
                    let para = document.createElement('p');
                    para.textContent = `Le fichier ${curFiles[i].name} n'est pas dans un format valide.`;
                    listItem.appendChild(para);
                }

                list.appendChild(listItem);
            }
        }
    });
};

let fileTypes = [
    'image/jpeg',
    'image/jpg',
    'image/png'
];

function validFileType(file) {
    for (let i = 0; i < fileTypes.length; i++) {
        if (file.type === fileTypes[i]) {
            return true
        }
    }

    return false;
}


/*************************************************************************
/**                            MODIFY ARTICLE
/*************************************************************************/

let articlesOptions = document.querySelectorAll('.article-options');
articlesOptions.forEach(articleOpt => {
    let id = articleOpt.dataset.id;
    let menuModify = document.querySelector(`#menu-article-${id}`).firstElementChild;
    let cancelEdit = document.querySelector(`#buttons-article-edit-${id}`).lastElementChild;
    articleOpt.addEventListener('click', () => {displayMenuArticle(id)});
    menuModify.addEventListener('click', () => {modifyArticle(id)});
    cancelEdit.addEventListener('click', () => {modifyArticle(id)});
});

// Affichage du menu
function displayMenuArticle(id) {
    let menuArticle = document.querySelector(`#menu-article-${id}`);
    menuArticle.classList.toggle("hide");

    // TODO: Ajouter un event pour fermer le menu lors d'un clic hors du menu
}

// Modification de l'article
function modifyArticle(id) {
    let articleText = document.querySelector(`#article-${id}`);
    let articleEdit = document.querySelector(`#article-edit-${id}`);
    let buttonsArticleEdit = document.querySelector(`#buttons-article-edit-${id}`);
    
    articleEdit.value = articleText.textContent;
    articleText.classList.toggle("hide");
    articleEdit.classList.toggle("hide");
    buttonsArticleEdit.classList.toggle("hide");
    articleEdit.focus();
}


/*************************************************************************
/**                              IMAGE MODAL
/*************************************************************************/

// On récupère les éléments de la modal
let modal = document.querySelector('.modal');

// Ajout d'un event si on clic en dehors de la modal
window.addEventListener('click', function(e) {
    if (e.target == modal) {
        modal.style.display = 'none';
        modal.removeChild(modal.lastChild);
    }
});

// On ajoute un event sur le click pour toutes les images
let modalables = document.querySelectorAll('.modalable');
modalables.forEach(modalable => {
    modalable.addEventListener('click', (modalable) => {displayImage(modalable.target.dataset.path)});
});

// On affiche l'image désirée
function displayImage(path) {
    let image = document.createElement('img');
    image.src = path;
    image.classList = 'modal-image';
    
    modal.appendChild(image);
    modal.style.display = "block";
}

/*************************************************************************
/**                              COMMENTS
/*************************************************************************/

/************************** NEW COMMENT *************************/

// On focus le textarea si l'utilisateur clique sur le bouton commenter
let btnComments = document.querySelectorAll('.btn-comment');
btnComments.forEach(btnComment => {
    btnComment.addEventListener('click', (e) => {
        let areaComment = document.querySelector(`#new-comment-edit-${e.target.dataset.articleid}`);
        
        // On focus le textarea
        areaComment.focus();
    });
});

// On ajoute un event sur chaque textarea pour envoyer le formulaire si l'utilisateur appui sur la touche Enter
let areaComments = document.querySelectorAll('.comment-edit');
areaComments.forEach(areaComment => {
    areaComment.addEventListener('keypress', (e) => {
        switch (e.code) {
            case 'Shift':
                // TODO: Faire en sorte que si Shift est appuyé, on puisse aller à la ligne en appuyant sur Enter
                break;
            case 'Enter':
                e.preventDefault();
                document.querySelector(`#form-comment-${e.target.dataset.articleid}`).submit();
                break;
        }
    });
});

/************************** DISPLAY COMMENTS *************************/

// On affiche les commentaires cachés lors que l'on clique sur l'élément pour les afficher
let showComments = document.querySelectorAll('.show-comments');
showComments.forEach(showComment => {
    showComment.addEventListener('click', (e) => {
        comments = document.querySelectorAll(`.comment-${e.target.dataset.articleid}`);

        // On cache l'élément
        e.target.classList.add('hide');
        
        // On affiche les commentaires cachés
        comments.forEach(comment => {
            comment.classList.remove('hide');
            comment.classList.add('flex');
        });
    });
});

/************************** EDIT COMMENTS *************************/

let comments = document.querySelectorAll('.comments-content');
let currentCommentEdit = 0;

comments.forEach(comment => {
    // On affiche les actions au survol de la souris du commentaire
    comment.addEventListener('mouseenter', (e) => {
        commentId = e.target.parentNode.dataset.commentid;
        commentActions = document.querySelector(`#comment-actions-${commentId}`);
        commentActions.classList.remove('hide');

        // On ajoute un eventListener du clic souris sur le bouton d'édition
        commentActionEdit =document.querySelector(`#comment-action-edit-${commentId}`);
        if (commentActionEdit) {
            commentActionEdit = document.querySelector(`#comment-action-edit-${commentId}`);
            commentActionEdit.addEventListener('click', () => {
                // Si un commentaire est déjà en cours d'édition, on cache le formulaire
                if (currentCommentEdit) {
                    currentCommentContent = document.querySelector(`#comment-content-${currentCommentEdit}`);
                    currentCommentForm = document.querySelector(`#comment-form-edit-${currentCommentEdit}`);
                    currentCommentForm.classList.add('hide');
                    currentCommentContent.classList.remove('hide');
                }

                commentContent = document.querySelector(`#comment-content-${commentId}`);
                commentEditForm = document.querySelector(`#comment-form-edit-${commentId}`);
                commentEdit = commentEditForm.firstElementChild;
                currentCommentEdit = commentId;

                commentEdit.value = commentContent.textContent;
                commentContent.classList.add('hide');
                commentEditForm.classList.remove('hide');

                // On ajoute un eventListener pour valider l'édition du commentaire
                commentEdit.addEventListener('keypress', (e) => {
                    switch (e.code) {
                        case 'Shift':
                            // TODO: Faire en sorte que si Shift est appuyé, on puisse aller à la ligne en appuyant sur Enter
                            break;
                        case 'Enter':
                            e.preventDefault();
                            commentEditForm.submit();
                            break;
                    }
                });
            });
        }
    });

    // // On cache les actions si la souris n'est plus sur le commentaire 
    comment.addEventListener('mouseleave', (e) => {
        commentActions = document.querySelector(`#comment-actions-${e.target.parentNode.dataset.commentid}`);
        commentActions.classList.add('hide');
    });
});

/*************************************************************************
/**                                LIKES
/*************************************************************************/

 let btnLikes = document.querySelectorAll('.btn-like');
 btnLikes.forEach(btnLike => {
    btnLike.addEventListener('click', (e) => {
        document.querySelector(`#form-like-${e.target.dataset.articleid}`).submit();
    });
 });

/*************************************************************************
/**                             ADMINISTRATION
/*************************************************************************/

setTimeout(() => {
    // On cache l'info box après 5s
    let infoBoxAdmin = document.querySelector("#info-box-admin");
    if (infoBoxAdmin) {
        infoBoxAdmin.style.display = 'none';
    }
}, 5000);

let adminBurger = document.querySelector('.navbar-admin-burger');
let adminMenu = document.querySelector('.navbar-admin');

if (adminBurger) {
    adminBurger.addEventListener('click', () => toggleBurger());
}

function toggleBurger() {
    if (!adminMenu.classList.contains('slide-in') && !adminMenu.classList.contains('slide-out')) {
        adminMenu.classList.toggle('slide-in');
        adminBurger.classList.toggle('slide-in-burger');
    } else {
        adminMenu.classList.toggle('slide-in');
        adminMenu.classList.toggle('slide-out');
        adminBurger.classList.toggle('slide-in-burger');
        adminBurger.classList.toggle('slide-out-burger');
    }
}

window.addEventListener('resize', () => {
    if (window.innerWidth > 992) {
        if (adminMenu && adminBurger) {
            adminMenu.classList.remove('slide-in');
            adminMenu.classList.remove('slide-out');
            adminBurger.classList.remove('slide-in-burger');
            adminBurger.classList.remove('slide-out-burger');
        }
    }
});
