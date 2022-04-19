

/*************************************************************************
 *                              NEW ARTICLE
 *************************************************************************/

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
                    para.textContent = "Le fichier " + curFiles[i].name + " n'est pas dans un format valide.";
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
 *                            MODIFY ARTICLE
 *************************************************************************/

// Affichage du menu
function displayMenuArticle(id) {
    let menuArticle = document.querySelector('#menu-article-' + id);
    menuArticle.classList.toggle("hide");

    // TODO: Ajouter un event pour fermer le menu lors d'un clic hors du menu
}

// Modification de l'article
function modifyArticle(id) {
    let articleText = document.querySelector('#article-' + id);
    let articleEdit = document.querySelector('#article-edit-' + id);
    let buttonsArticleEdit = document.querySelector("#buttons-article-edit-" + id);
    
    articleEdit.value = articleText.textContent;
    articleText.classList.toggle("hide");
    articleEdit.classList.toggle("hide");
    buttonsArticleEdit.classList.toggle("hide");
    articleEdit.focus();
}


/*************************************************************************
 *                              IMAGE MODAL
 *************************************************************************/

// On récupère les éléments de la modal
let modal = document.querySelector('.modal');

// Ajout d'un event si on clic en dehors de la modal
window.addEventListener('click', function(e) {
    if (e.target == modal) {
        modal.style.display = 'none';
        modal.removeChild(modal.lastChild);
    }
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
 *                             ADMINISTRATION
 *************************************************************************/

setTimeout(() => {
    // On cache l'info box après 5s
    let infoBoxAdmin = document.querySelector("#info-box-admin");
    if (infoBoxAdmin) {
        infoBoxAdmin.style.display = 'none';
    }
}, 5000);

