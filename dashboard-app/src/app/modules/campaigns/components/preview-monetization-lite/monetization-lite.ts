export function setActiveButtonMonthly(chosenButton, focusInput: false) {
    var target;
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById('cft-monetization__container');
    var btns = header.getElementsByClassName('cft--monatization--donation-button--monthly');
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
}

export function setActiveButtonOneTime(chosenButton, focusInput: false) {
    var target;
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    var header = landingDocument.getElementById('cft-monetization__container');
    var btns = header.getElementsByClassName('cft--monatization--donation-button--one-time');
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
        && (landingDocument.getElementById('cft--monatization--form--donate--terms') as HTMLSelectElement).checkValidity();

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
    for (let oneTime of oneTimeElements) {
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, '');
    }
    for (let monthly of monthlyElements) {
        monthly.className += ' cft--monatization--hidden'
    }
    var oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time')
    var monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly')
    oneTimeButton.className += ' active';
    monthlyButton.className = monthlyButton.className.replace(/ active/g, '');


}

export function monthlyPayment() {
    var landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        let iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    let monthlyElements = landingDocument.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = landingDocument.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let oneTime of oneTimeElements) {
        oneTime.className += ' cft--monatization--hidden'
    }

    for (let monthly of monthlyElements) {
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, '');
    }

    var oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time')
    var monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly')
    monthlyButton.className += ' active';
    oneTimeButton.className = oneTimeButton.className.replace( / active/g, '');


}

