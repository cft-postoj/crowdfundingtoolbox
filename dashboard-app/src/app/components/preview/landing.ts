export function setActiveButton(chosenButton) {
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById('cr0wdWidgetContent-landing');
    var btns = header.getElementsByClassName('cft--monatization--donation-button-container');
    for (var i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains('active')) {
            btns[i].className = btns[i].className.replace(' active', '');
        }
        if (btns[i] === chosenButton) {
            btns[i].className += " active";
        }
    }
    var checkbox = landingDocument.getElementById('cft--monatization--membership-checkbox');
    if (chosenButton.getElementsByTagName('input')[0].value >= 10) {
        checkbox.className += ' active';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, '');
    }
}

export function validateForm(this) {
    let validInput = false;
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    let form = landingDocument.getElementById('cft--monatization--form--donate').className += ' submitted';
    validInput = (landingDocument.getElementById('cft--monatization--form--donate--email') as HTMLSelectElement).checkValidity()
        && (landingDocument.getElementById('cft--monatization--form--donate--terms') as HTMLSelectElement).checkValidity() ;

    return validInput;
}

export function oneTimePayment() {

}