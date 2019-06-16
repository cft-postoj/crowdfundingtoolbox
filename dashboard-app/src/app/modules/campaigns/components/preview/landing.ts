//track when user interact with widget and picked some value

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

//send correct email to backend
export function trackEmailOnChange(el) {
    //TODO get from  env
    const apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API
    if (el.checkValidity()) {
        let xhttp = new XMLHttpRequest();
        var data = JSON.stringify(
            {
                'show_id': el.closest('[id^=cr0wdFundingToolbox]').dataset.show_id,
                'email': el.value,
                'email_valid': el.checkValidity()
            }
        );
        xhttp.open('POST', apiUrl + 'tracking/insertEmail', true);
        xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.send(data);
    }
}

export function setActiveButtonMonthly(chosenButton, focusInput: false, track: boolean = true) {
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

export function setActiveButtonOneTime(chosenButton, focusInput: false, track: boolean = true) {
    //TODO get from  env
    const apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API

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

    if (track) {
        trackInsertValue(chosenButton, 'one-time', apiUrl);
    }
}

export function validateForm(el) {
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

export function handleSubmit(el, event) {
    event.preventDefault();
    var apiUrl = 'http://127.0.0.1:8001/api/portal/';
    var monetizationEl = el.closest('.cft--monetization--container');
    //get not hidden wrapper (to determine what is selected - monthly or one time payment
    var currentActiveWrapper;
    var allWrapper = monetizationEl.getElementsByClassName('cft--monatization--donation-button-wrapper');
    for (var i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf('cft--monatization--hidden') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    var frequency = 'unknown. Maybe error. Please check class names of elements that are used in monetization component';
    //is monthly support?
    if (currentActiveWrapper.className.indexOf('cft--monatization--only-monthly') > -1) {
        frequency = 'monthly'
    }
    if (currentActiveWrapper.className.indexOf('cft--monatization--only-one-time') > -1) {
        frequency = 'one-time'
    }

    //
    var selectedValue;
    if (frequency === 'monthly') {
        selectedValue = monetizationEl.querySelector('.cft--monatization--donation-button--monthly.active input').value
    }
    if (frequency === 'one-time') {
        selectedValue = monetizationEl.querySelector('.cft--monatization--donation-button--one-time.active input').value
    }
    if (validateForm(el)) {
        var formData = new FormData(el);
        var data = JSON.stringify(
            {
                'show_id': el.closest('[id^=cr0wdFundingToolbox]').dataset.show_id,
                'email': el.querySelector('#cft--monatization--form--donate--email').value,
                'email_valid': el.querySelector('#cft--monatization--form--donate--email').checkValidity(),
                'terms': el.querySelector('#cft--monatization--form--donate--terms').checked,
                'frequency': frequency,
                'donation_value': selectedValue
            }
        );
        let xhr = new XMLHttpRequest();
        xhr.open('POST', apiUrl + 'donation/initialize', true);
        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.responseType = 'json';
        xhr.send(data);
    } else {
        var formData = new FormData(el);
        var data = JSON.stringify(
            {
                'show_id': el.closest('[id^=cr0wdFundingToolbox]').dataset.show_id,
                'email': el.querySelector('#cft--monatization--form--donate--email').value,
                'email_valid': el.querySelector('#cft--monatization--form--donate--email').checkValidity(),
                'terms': el.querySelector('#cft--monatization--form--donate--terms').checked,
                'frequency': frequency,
                'donation_value': selectedValue
            }
        );
        let xhr = new XMLHttpRequest();
        xhr.open('POST', apiUrl + 'tracking/initialize-donation-invalid', true);
        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.responseType = 'json';
        xhr.send(data);
    }
    return false;

}

//change view status to show oneTimePayment
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


    //for lite monetization
    var oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time');
    var monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly');
    if (oneTimeButton) oneTimeButton.className += ' active';
    if (monthlyButton) monthlyButton.className = monthlyButton.className.replace(/ active/g, '');

}


//change view status to show monthlyPayment
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

    //for lite monetization
    var oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time')
    var monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly')
    if (oneTimeButton) monthlyButton.className += ' active';
    if (monthlyButton) oneTimeButton.className = oneTimeButton.className.replace(/ active/g, '');

}