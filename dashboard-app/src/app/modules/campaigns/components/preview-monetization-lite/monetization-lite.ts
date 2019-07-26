export function getEnvs() {
    return {
        apiPublicUrl: 'apiPublicUrlValue'
    };
}

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


export function oneTimePayment(element) {
    var monetizationCont = element.closest('.cft--monetization--container');
    let monthlyElements = monetizationCont.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = monetizationCont.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let oneTime of oneTimeElements) {
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, '');
    }
    for (let monthly of monthlyElements) {
        monthly.className += ' cft--monatization--hidden'
    }

    var monthlyDonationButton = monetizationCont.querySelector('.cft--monatization--donation--monthly');
    var oneTimeDonationButton = monetizationCont.querySelector('.cft--monatization--donation--one-time');

    monthlyDonationButton.className = monthlyDonationButton.className.replace(/ active/g, '');
    oneTimeDonationButton.className += ' active';

}

export function monthlyPayment(element) {
    var monetizationCont = element.closest('.cft--monetization--container');
    let monthlyElements = monetizationCont.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = monetizationCont.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let oneTime of oneTimeElements) {
        oneTime.className += ' cft--monatization--hidden';
    }

    for (let monthly of monthlyElements) {
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, '');
    }
    var monthlyDonationButton = monetizationCont.querySelector('.cft--monatization--donation--monthly');
    var oneTimeDonationButton = monetizationCont.querySelector('.cft--monatization--donation--one-time');

    oneTimeDonationButton.className = oneTimeDonationButton.className.replace(/ active/g, '');
    monthlyDonationButton.className += ' active';

}

export function changePaymentOptions(element) {
    var monetizationCont = element.closest('.cft--monetization--container');
    var paymentOptionArray = monetizationCont.getElementsByClassName('payment-option');

    for (var i = 0; i < paymentOptionArray.length; i++) {
        paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/ active/g, '');
    }
    element.className += ' active';

    var paymentOptionsShowActive = monetizationCont.querySelectorAll(`.payment-option__show[data-id='${element.dataset.id}']`);
    for (var i = 0; i < paymentOptionsShowActive.length; i++) {
        paymentOptionsShowActive[i].className = paymentOptionsShowActive[i].className.replace(/ cft--monatization--hidden/g, '');
    }

    var paymentOptionsShowNotActive = monetizationCont.querySelectorAll(`.payment-option__show:not([data-id='${element.dataset.id}'])`);
    for (var i = 0; i < paymentOptionsShowNotActive.length; i++) {
        paymentOptionsShowNotActive[i].className += ' cft--monatization--hidden';
    }

}

//create DOM's of ban buttons using data from backend
export function createBankButtons(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector('.bank-button__wrapper');
    bankButtonsWrapper.innerHTML = '';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
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

export function handleSubmit(el, event) {
    event.preventDefault();
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
    let monetizationEl = el.closest('.cft--monetization--container');
    // get not hidden wrapper (to determine what is selected - monthly or one time payment)
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


export function showSecondStep(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency,
                               payBySquareBlob, userToken, donationId) {

    monetizationEl.dataset.donationId = donationId;
    var ibanStep2 = monetizationEl.querySelector('.cft--monetization--container-step-2 .payment-iban');
    var vsStep2 = monetizationEl.querySelector('.cft--monetization--container-step-2 .payment-vs');
    var amountStep2 = monetizationEl.querySelector('.cft--monetization--container-step-2 .payment-amount');
    ibanStep2 ? ibanStep2.innerHTML = bankAccount : '';
    vsStep2 ? vsStep2.innerHTML = variableSymbol : '';
    amountStep2 ? amountStep2.innerHTML = value : '';

    var ibanStep3 = monetizationEl.querySelector('.cft--monetization--container-step-3 .payment-iban');
    var vsStep3 = monetizationEl.querySelector('.cft--monetization--container-step-3 .payment-vs');
    var amountStep3 = monetizationEl.querySelector('.cft--monetization--container-step-3 .payment-amount');
    ibanStep3 ? ibanStep3.innerHTML = bankAccount : '';
    vsStep3 ? vsStep3.innerHTML = variableSymbol : '';
    amountStep3 ? amountStep3.innerHTML = value : '';

    createBankButtons(monetizationEl, bankButtons);
    step(monetizationEl, true);


    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelectorAll('.qr__wrapper .pay-by-square__wrapper');
    for (var i = 0; i < payBySquareWrapper.length; i++) {
        payBySquareWrapper[i].innerHTML = payBySquareBlob;
    }
    if (userToken != null) {
        localStorage.setItem('cft_usertoken', userToken);
    }
}


export function step(element, increase) {
    var monetizationCont = element.closest('.cft--monetization--container');
    var firstStep = monetizationCont.querySelector('.cft--monetization--container-step-1');
    var secondStep = monetizationCont.querySelector('.cft--monetization--container-step-2');
    var thirdStep = monetizationCont.querySelector('.cft--monetization--container-step-3');

    // move from step 1 to step 2
    if (firstStep.className.indexOf('cft--monatization--hidden') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + ' cft--monatization--hidden';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, '');
    } else
    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf('cft--monatization--hidden') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, '');
        secondStep.className = secondStep.className + ' cft--monatization--hidden';
    } else

    // move from step 2 to step 3
    if (secondStep.className.indexOf('cft--monatization--hidden') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + ' cft--monatization--hidden';
        thirdStep.className = thirdStep.className.replace(/ cft--monatization--hidden/g, '');
    } else
    // move from step 3 back to step 2
    if (thirdStep.className.indexOf('cft--monatization--hidden') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + ' cft--monatization--hidden';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, '');
        // update header
    }
}

export function validateForm(el) {
    let validInput = false;
    let monetizationCont = el.closest('.cft--monetization--container');
    el.className += ' submitted';
    validInput = (monetizationCont.querySelector('#cft--monatization--form--donate--email') as HTMLSelectElement).checkValidity()
        && (monetizationCont.querySelector('#cft--monatization--form--donate--terms') as HTMLSelectElement).checkValidity();
    return validInput;
}

export function donationInProgress(element) {
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
    let xhr = new XMLHttpRequest();
    var monetizationCont = element.closest('.cft--monetization--container');
    const data = JSON.stringify(
        {
            'donation_id': monetizationCont.dataset.donationId,
            'payment_method_id': monetizationCont.querySelector('.payment-option').dataset.id
        }
    );
    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            step(element, true);
        }
    }
    xhr.open('POST', apiPublicUrl + 'donation/waiting-for-payment', true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.responseType = 'json';
    xhr.send(data);

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
