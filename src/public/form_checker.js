/**
 * FORM CHECKER
 * Autheur : Etienne Caulier
 * Source : Mon Google Drive EDUGE
 * Fichier qui permet de vérifier automatiquement, correctement
 * et simplement les champs d'un formulaire html
 */

// Constantes
const ID_BUTTON_SUBMIT = 'submitForm'; // ID du bouton submit du form
const ID_FORM = ''; // Optionnel
const ID_INPUT_TO_VERIFY = [
    // Liste des IDs des inputs du formulaire à verifier
    'nom',
    'prenom',
    'dateNaissance'
];

/**
 * Envoie le message d'erreur approprié pour chaque champ
 * @param {string} id_input ID du champ
 * @return {string} Message d'erreur
 */
function getErrorMessage(id_input) {
    switch (id_input) {
        case 'name':
            return "Vous ne pouvez pas ne pas avoir de nom !";
        
        case 'password':
            return "Vous ne voulez pas avoir de mot de passe ?!";

        default:
            return "Ce champ est obligatoire !";
    }
}

// Au chargement de la page...
document.addEventListener('DOMContentLoaded', function () {
    // Verification des champs de formulaire pour ajouter une recette
    let btn_submitForm = document.getElementById(ID_BUTTON_SUBMIT);
    if (btn_submitForm) {
        btn_submitForm.addEventListener('click', function (event) {
            // Bloquer l'envoie du formulaire
            event.preventDefault();
            let allFieldsValid = true;

            // Verifier chaque champs
            ID_INPUT_TO_VERIFY.forEach(step => {
                let inputElement = document.getElementById(step);
                if (inputElement != null) {
                    if (!valueIsSet(inputElement.value)) {
                        addErrorMessage(getErrorMessage(step), inputElement);
                        allFieldsValid = false;
                    } else {
                        removeErrorMessage(inputElement);
                    }
                }
            });

            // Si tous les champs sont valides
            if (allFieldsValid) {
                let form = (ID_FORM != '')
                    ? document.getElementById(ID_FORM)
                    : document.querySelector('form');
                if (form) {
                    form.submit();
                }
            }
        });
    }
});

/**
 * Vérifie si une valeur est définie et non vide
 * @param {string} value Valeur à tester
 * @return {boolean} True si la valeur est définie, false sinon
 */
function valueIsSet(value) {
    return (
        value != null &&
        value.toString().trim() !== ''
    ) && (
            !value.toLowerCase().includes('Choisir un'.toLowerCase())
        );
}

/**
 * Affiche un message d'erreur sous un élément
 * @param {string} message Message d'erreur
 * @param {Element} inputElem Élement après lequel insérer le message d'erreur
 */
function addErrorMessage(message, inputElem) {
    if (!inputElem || !(inputElem instanceof Element)) {
        console.error("L'argument passé n'est pas un élément HTML valide.");
        return;
    }

    // Récupère ou crée un message d'erreur
    const errorId = `error-${inputElem.id}`;
    let errorMsg = document.getElementById(errorId);
    if (!errorMsg) {
        errorMsg = document.createElement('span');
        errorMsg.id = errorId;
        errorMsg.style.color = '#e91b1b';
        inputElem.parentElement.appendChild(errorMsg);
    }
    errorMsg.innerText = message;
}

/**
 * Supprime le message d'erreur s'il existe
 * @param {Element} elementBefore Élement avant lequel le message d'erreur est inséré
 */
function removeErrorMessage(elementBefore) {
    const errorId = `error-${elementBefore.id}`;
    let errorMsg = document.getElementById(errorId);
    if (errorMsg) {
        errorMsg.remove();
    }
}
