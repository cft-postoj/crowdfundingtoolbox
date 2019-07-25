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
            'show_id': chosenButton.closest('[id^=cr0wdfundingToolbox]').dataset.showId
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
                'show_id': el.closest('[id^=cr0wdfundingToolbox]').dataset.showId,
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
    var apiPublicUrl = getEnvs().apiPublicUrl + '/portal/'; // TEST API
    var target;
    var landingDocument = document;
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
    console.log(landingDocument, landingDocument.getElementById('cft--monatization--membership-checkbox--monthly')
        , chosenButton.getElementsByTagName('input')[0].value, target)
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
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/'; // TEST API

    var target;
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
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
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
        selectedValue = monetizationEl.querySelector('.cft--monatization--donation-button--monthly.active input').value;
    }
    if (frequency === 'one-time') {
        selectedValue = monetizationEl.querySelector('.cft--monatization--donation-button--one-time.active input').value;
    }
    if (validateForm(el)) {
        let formData = new FormData(el);
        let data = JSON.stringify(
            {
                'show_id': el.closest('[id^=cr0wdfundingToolbox]').dataset.showId,
                'email': el.querySelector('#cft--monatization--form--donate--email').value,
                'email_valid': el.querySelector('#cft--monatization--form--donate--email').checkValidity(),
                'terms': el.querySelector('#cft--monatization--form--donate--terms').checked,
                'frequency': frequency,
                'amount': selectedValue
            }
        );

        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                showSecondStep(monetizationEl, xhr.response.variable_symbol, xhr.response.bank_account, xhr.response.bankButtons,
                    selectedValue, frequency, xhr.response.qrCode, xhr.response.user_token, xhr.response.donation_id);

            }
        }
        xhr.open('POST', apiPublicUrl + 'donation/initialize', true);
        xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
        xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhr.responseType = 'json';
        xhr.send(data);
    } else {
        var formData = new FormData(el);
        const data = JSON.stringify(
            {
                'show_id': el.closest('[id^=cr0wdfundingToolbox]').dataset.showId,
                'email': el.querySelector('#cft--monatization--form--donate--email').value,
                'email_valid': el.querySelector('#cft--monatization--form--donate--email').checkValidity(),
                'terms': el.querySelector('#cft--monatization--form--donate--terms').checked,
                'frequency': frequency,
                'amount': selectedValue
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

export function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency,
                               payBySquareBlob, userToken, donationId) {

    monetizationEl.dataset.donationId = donationId;
    monetizationEl.querySelector('.cft--monetization--container-step-2 .payment-iban').innerHTML = bankAccount;
    monetizationEl.querySelector('.cft--monetization--container-step-2 .payment-vs').innerHTML = variableSymbol;
    monetizationEl.querySelector('.cft--monetization--container-step-2 .payment-amount').innerHTML = value + ' € ' + frequency;

    monetizationEl.querySelector('.cft--monetization--container-step-3 .payment-iban').innerHTML = bankAccount;
    monetizationEl.querySelector('.cft--monetization--container-step-3 .payment-vs').innerHTML = variableSymbol;
    monetizationEl.querySelector('.cft--monetization--container-step-3 .payment-amount').innerHTML = value + ' € ' + frequency;

    var paymentOptions = monetizationEl.querySelector('.payment-options')
    if (frequency === 'one-time') {
        paymentOptions.className = paymentOptions.className.replace(/ cft--monatization--hidden/g, '');
    } else {
        paymentOptions.className += ' cft--monatization--hidden';
    }

    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);


    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector('.qr__wrapper .pay-by-square__wrapper');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem('cft_usertoken', userToken);
    }
}

export function setBankButton(element) {
    let bankButtonWrapper = element.closest('.bank-button__wrapper');
    let bankButtons = bankButtonWrapper.getElementsByClassName('bank-button') as any;
    for (let bankButton of bankButtons) {
        bankButton.className = bankButton.className.replace(/ active/g, '');
    }
    element.className += ' active';

    //change href of anchor.
    var anchor = element.closest('.cft--monetization--container-step-2').querySelector('.cft--button--redirect');
    anchor.href = element.dataset.bankLink != null ? element.dataset.bankLink : element.querySelector(':checked').dataset.bankLink;
}

//create DOM's of ban buttons using data from backend
export function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector('.bank-button__wrapper');
    bankButtonsWrapper.innerHTML = '';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if(bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML('beforeEnd',
                `<div class="bank-button__container"> 
                        <div class="bank-button" data-bank-link="${bankButtonsData[i].redirect_link}" onclick="parent.setBankButton(this)">
                            <span>${bankButtonsData[i].title}</span>
                        </div> 
                  </div>`);
        } else {
            bankButtonsWrapper.insertAdjacentHTML('beforeEnd',
                `<div class="bank-button__container"> 
                        <div class="bank-button" data-bank-link="${bankButtonsData[i].redirect_link}" onclick="parent.setBankButton(this)">
                            <img src="${bankButtonsData[i].image.url}" alt="${bankButtonsData[i].title}">
                        </div> 
                  </div>`);
        }
    }
    //create from 6th and later bank button select's option
    if (bankButtonsData.length > 5) {
        var options =
            `<div class="bank-button__container">
                <div class="bank-button bank-button__select" onclick="parent.setBankButton(this)">
                    <select name="bank">
                        <option disabled="" selected="">Other bank</option>`;

        for (var i = 5; i < bankButtonsData.length; i++) {
            options += `<option data-bank-link="${bankButtonsData[i].redirect_link}">${bankButtonsData[i].title}</option>`
        }
        options += `
                    </select>
                </div>
            </div>`;
        bankButtonsWrapper.insertAdjacentHTML('beforeEnd', options);
    }
}

export function showThirdPage(element, response) {
    step(element, true);
}

export function donationInProgress(element) {
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
    let xhr = new XMLHttpRequest();
    const data = JSON.stringify(
        {
            'donation_id': element.closest('.cft--monetization--container').dataset.donationId,
            'payment_method_id': element.closest('.payment-option').dataset.id
        }
    );
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            showThirdPage(element, xhr.response);
        }
    }
    xhr.open('POST', apiPublicUrl + 'donation/waiting-for-payment', true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.responseType = 'json';
    xhr.send(data);

}

export function changePaymentOptions(element) {

    var monetizationStep = element.closest('.cft--monetization--container-step-2');
    var paymentOptionArray = monetizationStep.getElementsByClassName('payment-option');
    var selectedId = monetizationStep.querySelector('input[name="payment-option"]:checked').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += ' cft--monatization--hidden';
        } else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/ cft--monatization--hidden/g, '');
        }
    }
}

export function step(element, increase) {
    var monetizationCont = element.closest('.cft--monetization--container');

    var firstStep = monetizationCont.querySelector('.cft--monetization--container-step-1');
    var secondStep = monetizationCont.querySelector('.cft--monetization--container-step-2');
    var thirdStep = monetizationCont.querySelector('.cft--monetization--container-step-3');

    var headTitle = monetizationCont.querySelector('.head .title');
    var stepBack = monetizationCont.querySelector('.step-back');

    // move from step 1 to step 2
    if (firstStep.className.indexOf('cft--monatization--hidden') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + ' cft--monatization--hidden';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, '');
        // update header
        monetizationCont.querySelector('.head .title').innerHTML = 'Step 2 of 3';
        stepBack.className = 'step-back';

    } else

    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf('cft--monatization--hidden') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, '');
        secondStep.className = secondStep.className + ' cft--monatization--hidden';

        monetizationCont.querySelector('.head .title').innerHTML = 'Step 1 of 3';
        stepBack.className = 'step-back cft--monatization--hidden';
    } else

    // move from step 2 to step 3
    if (secondStep.className.indexOf('cft--monatization--hidden') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + ' cft--monatization--hidden';
        thirdStep.className = thirdStep.className.replace(/ cft--monatization--hidden/g, '');
        // update header
        monetizationCont.querySelector('.head .title').innerHTML = 'Step 3 of 3';
        stepBack.className = 'step-back';

    } else

    // move from step 3 back to step 2
    if (thirdStep.className.indexOf('cft--monatization--hidden') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + ' cft--monatization--hidden';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, '');
        // update header
        monetizationCont.querySelector('.head .title').innerHTML = 'Step 2 of 3';
    }

}

