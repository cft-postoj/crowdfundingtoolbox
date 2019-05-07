export function setActiveButton(chosenButton, focusInput:false) {
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
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += ' active';
        }
    }
    if (focusInput) {
        let inputs = chosenButton.getElementsByTagName('input') as HTMLElement[];
        if (inputs.length) {
            inputs[0].focus();
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
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    let monthlyElements = landingDocument.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = landingDocument.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let oneTime of oneTimeElements){
        oneTime.className= oneTime.className.replace(/ cft--monatization--hidden/g, '');
    }
    for (let monthly of monthlyElements){
        monthly.className +=' cft--monatization--hidden'
    }
}

export function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    let monthlyElements = landingDocument.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = landingDocument.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let oneTime of oneTimeElements){
        oneTime.className +=' cft--monatization--hidden'
    }

    for (let monthly of monthlyElements){
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, '');
    }
}

