//track
export function trackInsertValue(chosenButton, frequency, apiUrl: string) {
    let xhttp = new XMLHttpRequest();
    var data = JSON.stringify(
        {
            'value': chosenButton.getElementsByTagName('input')[0].value,
            'frequency': frequency,
            'show_id': chosenButton.closest('[id^=cr0wdFundingToolbox]').dataset.show_id
        }
    );
    xhttp.open('POST', apiUrl + 'tracking/insertValue', true);
    xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';
    xhttp.send(data);
}

export function setActiveButtonMonthly(chosenButton, focusInput:false, track:boolean=true ) {
   //TODO get from  env
    const apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API
    var target;
    var landingDocument = document;
    // to work inside iframe
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
    var checkbox = landingDocument.getElementById('cft--monatization--membership-checkbox--monthly');
    if (chosenButton.getElementsByTagName('input')[0].value >= target) {
        checkbox.className += ' active';
    }
    else {
        checkbox.className = checkbox.className.replace(/ active/g, '');
    }

    if (track) {
        trackInsertValue(chosenButton, 'monthly', apiUrl);
    }

}
export function setActiveButtonOneTime(chosenButton, focusInput:false, track: boolean = true) {
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
    var checkbox = landingDocument.getElementById('cft--monatization--membership-checkbox--one-time');
    if (chosenButton.getElementsByTagName('input')[0].value >= target) {
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
    for (let oneTime of oneTimeElements){
        oneTime.className +=' cft--monatization--hidden'
    }

    for (let monthly of monthlyElements){
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, '');
    }

    var oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time')
    var monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly')
    monthlyButton.className += ' active';
    oneTimeButton.className = oneTimeButton.className.replace( / active/g, '');
}