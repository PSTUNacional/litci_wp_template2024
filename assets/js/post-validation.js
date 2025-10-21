let goodPracticesList = {};
let isSubmitting = false;

function publishButtonExists() {
    const publishButton = document.querySelector('.editor-post-publish-button');
    
    if (publishButton) {
        newButton = publishButton.cloneNode(true);
        publishButton.parentNode.insertBefore(newButton, publishButton.nextElementSibling);
        publishButton.style.display = "none";
        publishButton.id = "originalSubmitButton"
        newButton.addEventListener('click', function (event) {
            event.preventDefault();  // Previne a ação de publicação
            goodPracticesValidation();
        });
    } else {
        setTimeout(publishButtonExists, 1000);  // Se o botão não for encontrado, tenta novamente
    }
}

document.addEventListener('DOMContentLoaded', function () {
    publishButtonExists();  // Garantindo que a função só será chamada após o carregamento completo
});

async function goodPracticesValidation() {
    let goodPracticesByPass = true;
    const validations = [
        validateLinks(),
        validateHeadings(),
        validateTags()
    ];
    goodPracticesByPass = validations.every((status) => status === true);

    let headerHtml = `<div id="good-practices-header"><h2>${postValidationMessages.modal.title}</h2><p>${postValidationMessages.modal.description}</p></div>
    `;
    let contentHtml = `
        <div id="good-practices-list">
            <div class="item">
                <h3>${statusIcon(goodPracticesList.links.status)}${goodPracticesList.links.title}</h3>
                <p>${goodPracticesList.links.text}</p>
            </div>
            <div class="item">
                <h3>${statusIcon(goodPracticesList.headings.status)}${goodPracticesList.headings.title}</h3>
                <p>${goodPracticesList.headings.text}</p>
            </div>
            <div class="item">
                <h3>${statusIcon(goodPracticesList.tags.status)}${goodPracticesList.tags.title}</h3>
                <p>${goodPracticesList.tags.text}</p>
            </div>
        </div>
    `;

    if(goodPracticesByPass !== true)
    {
        Swal.fire({
            title: headerHtml,
            html: contentHtml,
            showCloseButton: true,
            showDenyButton: true,
            focusConfirm: false,
            confirmButtonText: `<i class="fa fa-thumbs-up"></i> ${postValidationMessages.modal.confirm}`,
            confirmButtonAriaLabel: "Thumbs up, great!",
            denyButtonText: `
                <i class="fa fa-thumbs-down"></i> ${postValidationMessages.modal.deny}`,
            denyButtonAriaLabel: "Thumbs down"
        }).then((result) => {
            if(result.isDenied) {
                validate_political_author();
            }
        });
    } else {
        validate_political_author();
    }
}

function validateLinks() {
    const links = document.querySelector('.editor-styles-wrapper').querySelectorAll('a');
    evaluate = {};
    if (links.length > 0) {
        evaluate.status = true;
        evaluate.title = postValidationMessages.links.success.title;
        evaluate.text = postValidationMessages.links.success.text;
    } else {
        evaluate.status = false;
        evaluate.title = postValidationMessages.links.error.title;
        evaluate.text = postValidationMessages.links.error.text;
    }

    goodPracticesList.links = evaluate
    return evaluate.status
}

function validateHeadings(){
    const headings = document.querySelector('.editor-styles-wrapper').querySelectorAll('h2, h3, h4, h5, h6');
    evaluate = {};
    if (headings.length > 0) {
        evaluate.status = true;
        evaluate.title = postValidationMessages.headings.success.title;
        evaluate.text = postValidationMessages.headings.success.text;
    } else {
        evaluate.status = false;
        evaluate.title = postValidationMessages.headings.error.title;
        evaluate.text = postValidationMessages.headings.error.text;
    }

    goodPracticesList.headings = evaluate
    return evaluate.status
}

function validateTags(){
        const tagsWrapper = document.querySelector('.components-form-token-field__input-container'); 
        const tags = document.querySelectorAll('.components-form-token-field__token');
        const wpCoreTags = wp.data.select('core/editor').getEditedPostAttribute('tags');
        let evaluate = {};
        
        if ((tags && tags.length > 0) || wpCoreTags.length > 0) {
            evaluate.status = true;
            evaluate.title = postValidationMessages.tags.success.title;
            evaluate.text = postValidationMessages.tags.success.text;
        } else {
            evaluate.status = false;
            evaluate.title = postValidationMessages.tags.error.title;
            evaluate.text = postValidationMessages.tags.error.text;
        }
    
        goodPracticesList.tags = evaluate
        return evaluate.status
    }

function validate_political_author() {
    const politicalAuthorField = document.querySelector('#political_author');
    const politicalAuthor = wp.data.select('core/editor').getEditedPostAttribute('meta')['litci_post_political_author'];

        
    if (!politicalAuthor || politicalAuthor.trim() === '') {
        Swal.fire({
            icon: "error",
            title: postValidationMessages.politicalAuthor.title,
            text: postValidationMessages.politicalAuthor.text,
        }).then((result) => {
            if (result.isConfirmed) {
                wp.data.dispatch('core/edit-post').openGeneralSidebar('edit-post/document');

            }
        });
        return false
    } else {
        submitPost()
    }
}

function statusIcon(field) {
    return field === true
        ? '<i class="fa fa-check-circle" style="color:#090"></i>'
        : '<i class="fa fa-times-circle" style="color:#c00"></i>';
}

function submitPost() {
    if (isSubmitting) return;
    isSubmitting = true;

    const publishButton = document.getElementById('originalSubmitButton');
    if (publishButton) {
        publishButton.click();
    }
}