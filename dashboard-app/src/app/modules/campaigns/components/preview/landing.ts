import {environment} from '../../../../../environments/environment';

export function getEnvs() {
    return {
        apiPublicUrl: 'apiPublicUrlValue'
    };
}

// track when user interact with widget and picked some value
export function trackInsertValue(chosenButton, frequency, apiUrl: string) {
    let xhttp = new XMLHttpRequest();
    const data = JSON.stringify(
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

// send correct email to backend
export function trackEmailOnChange(el) {
    // TODO: get from  env
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/'; // TEST API
    if (el.checkValidity()) {
        let xhttp = new XMLHttpRequest();
        const data = JSON.stringify(
            {
                'show_id': el.closest('[id^=cr0wdFundingToolbox]').dataset.show_id,
                'email': el.value,
                'email_valid': el.checkValidity()
            }
        );
        xhttp.open('POST', apiPublicUrl + 'tracking/insertEmail', true);
        xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.send(data);
    }
}

export function setActiveButtonMonthly(chosenButton, focusInput: false, track: boolean = true) {
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/'; // TEST API
    let target;
    let landingDocument = document;
    // to work inside iframe
    if (document.getElementById('crowdWidgetContent-preview')) {
        const iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    const header = landingDocument.getElementById('cft-monetization__container');
    const btns = header.getElementsByClassName('cft--monatization--donation-button--monthly');
    for (let i = 0; i < btns.length; i++) {
        if (btns[i].classList.contains('active')) {
            btns[i].className = btns[i].className.replace(' active', '');
        }
        if (btns[i].childNodes[0] === chosenButton) {
            btns[i].className += ' active';
        }
    }
    if (focusInput) {
        const inputs = chosenButton.getElementsByTagName('input') as HTMLElement[];
        if (inputs.length) {
            inputs[0].focus();
        }
    }
    let checkbox = landingDocument.getElementById('cft--monatization--membership-checkbox--monthly');
    if (chosenButton.getElementsByTagName('input')[0].value >= target) {
        checkbox.className += ' active';
    } else {
        checkbox.className = checkbox.className.replace(/ active/g, '');
    }

    if (track) {
        trackInsertValue(chosenButton, 'monthly', apiPublicUrl);
    }

}

export function setActiveButtonOneTime(chosenButton, focusInput: false, track: boolean = true) {
    const apiPublicUrl = environment.apiUrl + '/portal/'; // TEST API

    let target;
    let landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        const iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    const header = landingDocument.getElementById('cft-monetization__container');
    let btns = header.getElementsByClassName('cft--monatization--donation-button--one-time');
    for (let i = 0; i < btns.length; i++) {
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
    let checkbox = landingDocument.getElementById('cft--monatization--membership-checkbox--one-time');
    if (chosenButton.getElementsByTagName('input')[0].value >= target) {
        checkbox.className += ' active';
    } else {
        checkbox.className = checkbox.className.replace(/ active/g, '');
    }

    if (track) {
        trackInsertValue(chosenButton, 'one-time', apiPublicUrl);
    }
}

export function validateForm(el) {
    let validInput = false;
    let landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        const iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
        landingDocument = iframe.contentWindow.document;
    }
    const form = landingDocument.getElementById('cft--monatization--form--donate').className += ' submitted';
    validInput = (landingDocument.getElementById('cft--monatization--form--donate--email') as HTMLSelectElement).checkValidity()
        && (landingDocument.getElementById('cft--monatization--form--donate--terms') as HTMLSelectElement).checkValidity();
    return validInput;
}

export function handleSubmit(el, event) {
    event.preventDefault();
    const apiPublicUrl = environment.apiUrl + '/portal/';
    let monetizationEl = el.closest('.cft--monetization--container');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment
    let currentActiveWrapper;
    let allWrapper = monetizationEl.getElementsByClassName('cft--monatization--donation-button-wrapper');
    for (let i = 0; i < allWrapper.length; i++) {
        if (allWrapper[i].className.indexOf('cft--monatization--hidden') === -1) {
            currentActiveWrapper = allWrapper[i];
        }
    }
    let frequency = 'unknown. Maybe error. Please check class names of elements that are used in monetization component';
    // is monthly support?
    if (currentActiveWrapper.className.indexOf('cft--monatization--only-monthly') > -1) {
        frequency = 'monthly';
    }
    if (currentActiveWrapper.className.indexOf('cft--monatization--only-one-time') > -1) {
        frequency = 'one-time';
    }
    let selectedValue;
    if (frequency === 'monthly') {
        selectedValue = monetizationEl.querySelector('.cft--monatization--donation-button--monthly.active input').value
    }
    if (frequency === 'one-time') {
        selectedValue = monetizationEl.querySelector('.cft--monatization--donation-button--one-time.active input').value
    }
    if (validateForm(el)) {
        let formData = new FormData(el);
        let data = JSON.stringify(
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
        xhr.open('POST', apiPublicUrl + 'donation/initialize', true);
        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.responseType = 'json';
        xhr.send(data);
    } else {
        var formData = new FormData(el);
        const data = JSON.stringify(
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
        xhr.open('POST', apiPublicUrl + 'tracking/initialize-donation-invalid', true);
        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.responseType = 'json';
        xhr.send(data);
    }
    return false;

}

// change view status to show oneTimePayment
export function oneTimePayment() {
    let landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        const iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement
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


    // for lite monetization
    let oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time');
    let monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly');
    if (oneTimeButton) {
        oneTimeButton.className += ' active';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, '');
    }

}


// change view status to show monthlyPayment
export function monthlyPayment() {
    let landingDocument = document;
    if (document.getElementById('crowdWidgetContent-preview')) {
        const iframe = document.getElementById('crowdWidgetContent-preview')  as HTMLIFrameElement;
        landingDocument = iframe.contentWindow.document;
    }
    let monthlyElements = landingDocument.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = landingDocument.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let monthly of monthlyElements) {
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, '');
    }
    for (let oneTime of oneTimeElements) {
        oneTime.className += ' cft--monatization--hidden';
    }

    // for lite monetization
    let oneTimeButton = landingDocument.getElementById('cft--monatization--donation--one-time');
    let monthlyButton = landingDocument.getElementById('cft--monatization--donation--monthly');
    if (oneTimeButton) {
        monthlyButton.className += ' active';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, '');
    }
}
