import {changePaymentOptionsColumn} from '../preview-monetization-column/monetization-column';

export function getEnvs() {
    return {
        apiPublicUrl: 'apiPublicUrlValue'
    };
}

// track when user interact with widget and picked some value
export function trackInsertValueClassic(chosenButton, frequency, apiUrl: string) {
    let xhttp = new XMLHttpRequest();
    let value = chosenButton.getElementsByTagName('input')[0].value;
    let monetizationCont = chosenButton.closest('.cft--monetization--container');
    if (value < 1) {
        monetizationCont.querySelector('.cft--min-support--error').classList.add('cft--min-support--error__active');
    } else {
        monetizationCont.querySelector('.cft--min-support--error').classList.remove('cft--min-support--error__active');
    }
    const data = JSON.stringify(
        {
            'value': value,
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
export function trackEmailOnChangeClassic(el) {
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
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

export function setActiveButtonMonthlyClassic(chosenButton, focusInput: false, track: boolean = true) {
    var apiPublicUrl = getEnvs().apiPublicUrl + '/portal/'; // TEST API
    var target;
    const header = chosenButton.closest('.cft--monetization--container');
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
    let checkbox = header.getElementsByClassName('cft--monatization--membership-checkbox--monthly')[0];
    if (chosenButton.getElementsByTagName('input')[0].value >= target) {
        checkbox.className += ' active';
    } else {
        checkbox.className = checkbox.className.replace(/ active/g, '');
    }

    if (track) {
        trackInsertValueClassic(chosenButton, 'monthly', apiPublicUrl);
    }

}

export function setActiveButtonOneTimeClassic(chosenButton, focusInput: false, track: boolean = true) {
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/'; // TEST API

    var target;
    const header = chosenButton.closest('.cft--monetization--container');
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
    let checkbox = header.getElementsByClassName('cft--monatization--membership-checkbox--one-time')[0];
    if (chosenButton.getElementsByTagName('input')[0].value >= target) {
        checkbox.className += ' active';
    } else {
        checkbox.className = checkbox.className.replace(/ active/g, '');
    }

    if (track) {
        trackInsertValueClassic(chosenButton, 'one-time', apiPublicUrl);
    }
}

export function validateFormClassic(el, selectedValue = null) {
    let validInput = false;
    let monetizationCont = el.closest('.cft--monetization--container');
    el.className += ' submitted';
    monetizationCont.classList.add('submitted');
    validInput = (monetizationCont.querySelector('[id*=cft--monatization--form--donate--email]') as HTMLSelectElement).checkValidity()
        && (monetizationCont.querySelector('[id*=cft--monatization--form--donate--terms]') as HTMLSelectElement).checkValidity()
        && (selectedValue == null || selectedValue >= 1);
    if (selectedValue !== null && selectedValue < 1) {
        monetizationCont.querySelector('.cft--min-support--error').classList.add('cft--min-support--error__active');
    } else {
        monetizationCont.querySelector('.cft--min-support--error').classList.remove('cft--min-support--error__active');
    }
    return validInput;
}

export function handleSubmitClassic(el, event) {
    event.preventDefault();
    let monetizationEl = el.closest('.cft--monetization--container');
    const widgetType = el.querySelector('input[type="hidden"][name="widget_type"]').value;

    // monetizationEl.querySelector('.crowdWidgetContent--widget--popupOverlay').style.display = 'block';
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
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
    if (validateFormClassic(el, selectedValue)) {
        monetizationEl.querySelector('.cft--monetization--container-step-1 button[type="submit"]').classList.add('cft--monatization--hidden');
        let formData = new FormData(el);
        let email = el.querySelector('[id*=cft--monatization--form--donate--email]').value;
        const url = new URL(window.location.href);
        let data = JSON.stringify(
            {
                'referral_widget_id': url.searchParams.get('referral_widget_id'),
                'referral_tracking_show_id': url.searchParams.get('referral_tracking_show_id'),
                'show_id': el.closest('[id^=cr0wdfundingToolbox]').dataset.showId,
                'email': email,
                'email_valid': el.querySelector('[id*=cft--monatization--form--donate--email]').checkValidity(),
                'terms': el.querySelector('[id*=cft--monatization--form--donate--terms]').checked,
                'frequency': frequency,
                'amount': selectedValue
            }
        );
        monetizationEl.querySelectorAll('.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value').forEach((elem) => {
            elem.innerHTML = selectedValue + ' €';
        });
        monetizationEl.querySelector('.cft__redirect-to-register').href += '&email=' + email;

        const xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (widgetType === 'leaderboard') {
                    if (document.querySelector('#cr0wdWidgetContent-leaderboard') !== null) {
                        const popupWidgetInDom = document.querySelector('#cr0wdfundingToolbox-popup') as any;
                        if (popupWidgetInDom !== null) {
                            if (document.querySelector('#cr0wdfundingToolbox-popup .cft--monetization--container-step-1') !== null) {
                                // if there is popup monetization widget
                                const leaderboardWidget = document.querySelector('#cr0wdWidgetContent-leaderboard') as any;
                                leaderboardWidget.style.display = 'none';
                                popupWidgetInDom.style.display = 'block';
                                monetizationEl = popupWidgetInDom.querySelector('.cft--monetization--container');
                                monetizationEl.querySelectorAll('.cft--ctaButton--cardPay .cft--ctaButton--cardPay--value')
                                    .forEach((elem) => {
                                    elem.innerHTML = selectedValue + ' €';
                                    monetizationEl.querySelector('input[name="choosedPaymentType"]').value = frequency;
                                    if (frequency === 'one-time') {
                                        oneTimePaymentClassic(monetizationEl);
                                    } else {
                                        monthlyPaymentClassic(monetizationEl);
                                    }
                                });
                            }
                        }
                    }
                }

                showSecondStepClassic(monetizationEl, xhr.response.variable_symbol, xhr.response.bank_account, xhr.response.bankButtons,
                    selectedValue, frequency, xhr.response.qrCode, xhr.response.cardPayURL, xhr.response.comfortPayURL,
                    xhr.response.user_token, xhr.response.donation_id);

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
                'email': el.querySelector('[id*=cft--monatization--form--donate--email]').value,
                'email_valid': el.querySelector('[id*=cft--monatization--form--donate--email]').checkValidity(),
                'terms': el.querySelector('[id*=cft--monatization--form--donate--terms]').checked,
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

// change view status to show oneTimePaymentClassic
export function oneTimePaymentClassic(el) {
    const monetizationEl = el.closest('.cft--monetization--container');
    const choosedPaymentTypes = monetizationEl.querySelectorAll('input[name="choosedPaymentType"]') as any;
    for (let i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = 'one-time';
    }
    let monthlyElements = monetizationEl.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = monetizationEl.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let oneTime of oneTimeElements) {
        oneTime.className = oneTime.className.replace(/ cft--monatization--hidden/g, '');
    }
    for (let monthly of monthlyElements) {
        monthly.className += ' cft--monatization--hidden';
    }


    // for lite monetization
    let oneTimeButton = monetizationEl.querySelector('#cft--monatization--donation--one-time');
    let monthlyButton = monetizationEl.querySelector('#cft--monatization--donation--monthly');
    if (oneTimeButton) {
        oneTimeButton.className += ' active';
    }
    if (monthlyButton) {
        monthlyButton.className = monthlyButton.className.replace(/ active/g, '');
    }

    // hide comfortpay logo
    monetizationEl.querySelector('.payment-option--cardPay--monthly').classList.add('cft--monatization--hidden');
    // show cardpay logo
    monetizationEl.querySelector('.payment-option--cardPay--oneTime').classList.remove('cft--monatization--hidden');
    // cardpay button text
    monetizationEl.querySelector('.cft--ctaButton--cardPay--monthly').classList.add('cft--monatization--hidden');
    monetizationEl.querySelector('.cft--ctaButton--cardPay--oneTime').classList.remove('cft--monatization--hidden');

    let value = monetizationEl.querySelector('.cft--monatization--donation-button--one-time.active input').value;
    let minDonation = monetizationEl.querySelector('.cft--min-support--error');
    if (value >= 1) {
        minDonation.classList.remove('cft--min-support--error__active');
    } else {
        minDonation.classList.add('cft--min-support--error__active');
    }

}


// change view status to show monthlyPaymentClassic
export function monthlyPaymentClassic(el) {

    let monetizationEl = el.closest('.cft--monetization--container');
    const choosedPaymentTypes = monetizationEl.querySelectorAll('input[name="choosedPaymentType"]') as any;
    for (let i = 0; i < choosedPaymentTypes.length; i++) {
        choosedPaymentTypes[i].value = 'monthly';
    }
    let monthlyElements = monetizationEl.getElementsByClassName('cft--monatization--only-monthly') as any;
    let oneTimeElements = monetizationEl.getElementsByClassName('cft--monatization--only-one-time') as any;
    for (let monthly of monthlyElements) {
        monthly.className = monthly.className.replace(/ cft--monatization--hidden/g, '');
    }
    for (let oneTime of oneTimeElements) {
        oneTime.className += ' cft--monatization--hidden';
    }

    // for lite monetization
    let oneTimeButton = monetizationEl.querySelector('#cft--monatization--donation--one-time');
    let monthlyButton = monetizationEl.querySelector('#cft--monatization--donation--monthly');
    if (oneTimeButton) {
        monthlyButton.className += ' active';
    }
    if (monthlyButton) {
        oneTimeButton.className = oneTimeButton.className.replace(/ active/g, '');
    }
    let value = monetizationEl.querySelector('.cft--monatization--donation-button--monthly.active input').value;
    let minDonation = monetizationEl.querySelector('.cft--min-support--error');
    if (value >= 1) {
        minDonation.classList.remove('cft--min-support--error__active');
    } else {
        minDonation.classList.add('cft--min-support--error__active');
    }
}

export function showSecondStepClassic(monetizationEl, variableSymbol, bankAccount, bankButtons, value, frequency,
                                      payBySquareBlob, cardPayURL, comfortPayURL, userToken, donationId) {
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


    // padding in bank account transfer after button
    monetizationEl.querySelector('.cft--button-container[data-id="1"]').style.paddingBottom = '20px';
    monetizationEl.querySelector('.cft--button-container[data-id="3"]').style.paddingBottom = '20px';

    monetizationEl.querySelector('.cft--monetization--container-step-3 .cft--button-container').style.paddingBottom = '20px';

    const paymentOptionButtonPBS = monetizationEl.querySelector('.payment-options__button__pbs');
    const cardPayButton = monetizationEl.querySelector('.cft--ctaButton--cardPay');
    if (paymentOptionButtonPBS !== null) {
        if (frequency === 'one-time') {
            paymentOptionButtonPBS.classList.remove('cft--monatization--hidden');
            cardPayButton.setAttribute('href', cardPayURL);
        } else {
            paymentOptionButtonPBS.classList.add('cft--monatization--hidden');
            cardPayButton.setAttribute('href', comfortPayURL);
        }
    }

    createBankButtonsClassic(monetizationEl, bankButtons);
    stepClassic(monetizationEl, true);


    //handle qr code
    var payBySquareWrapper = monetizationEl.querySelector('.qr__wrapper .pay-by-square__wrapper');
    payBySquareWrapper.innerHTML = payBySquareBlob;
    if (userToken != null) {
        localStorage.setItem('cft_usertoken', userToken);
    }
}

export function setBankButtonClassic(element) {
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
export function createBankButtonsClassic(monetizationEl, bankButtonsData) {
    var bankButtonsWrapper = monetizationEl.querySelector('.bank-button__wrapper');
    bankButtonsWrapper.style.marginBottom = '30px';
    bankButtonsWrapper.innerHTML = '';
    //max 5 buttons and then wrap them into select element as options
    for (var i = 0; i <= 4 && i < bankButtonsData.length; i++) {
        if (bankButtonsData[i].image == null) {
            bankButtonsWrapper.insertAdjacentHTML('beforeEnd',
                `<div class="bank-button__container"> 
                        <div class="bank-button" data-bank-link="${bankButtonsData[i].redirect_link}" onclick="parent.setBankButtonClassic(this)">
                            <span>${bankButtonsData[i].title}</span>
                        </div> 
                  </div>`);
        } else {
            bankButtonsWrapper.insertAdjacentHTML('beforeEnd',
                `<div class="bank-button__container"> 
                        <div class="bank-button" data-bank-link="${bankButtonsData[i].redirect_link}" onclick="parent.setBankButtonClassic(this)">
                            <img src="${bankButtonsData[i].image.url}" alt="${bankButtonsData[i].title}" style="max-height: 100%; max-width: 100%;">
                        </div> 
                  </div>`);
        }
    }
    //create from 6th and later bank button select's option
    if (bankButtonsData.length > 5) {
        var options =
            `<div class="bank-button__container">
                <div class="bank-button bank-button__select" onclick="parent.setBankButtonClassic(this)">
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


export function donationInProgressClassic(element) {
    const apiPublicUrl = getEnvs().apiPublicUrl + '/portal/';
    let xhr = new XMLHttpRequest();
    var monetizationCont = element.closest('.cft--monetization--container');
    const data = JSON.stringify(
        {
            'donation_id': monetizationCont.dataset.donationId,
            'payment_method_id': monetizationCont.querySelector('input[name*=payment-option]:checked').value
        }
    );

    const selectedId = monetizationCont.querySelector('input[name*=payment-option]:checked').value;
    if (selectedId === '2') {
        localStorage.setItem('cft--donation_via', 'cardpay');
    } else {
        localStorage.setItem('cft--donation_via', '');
    }

    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            stepClassic(element, true);
        }
    };
    xhr.open('POST', apiPublicUrl + 'donation/waiting-for-payment', true);
    xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
    xhr.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhr.responseType = 'json';
    xhr.send(data);

}

export function changePaymentOptionsClassic(element) {

    var monetizationStep = element.closest('.cft--monetization--container-step-2');
    var paymentOptionArray = monetizationStep.getElementsByClassName('payment-option');
    var selectedId = monetizationStep.querySelector('input[name*="payment-option"]:checked').value;
    for (var i = 0; i < paymentOptionArray.length; i++) {
        if (paymentOptionArray[i].dataset.id != selectedId) {
            paymentOptionArray[i].className += ' cft--monatization--hidden';
        } else {
            paymentOptionArray[i].className = paymentOptionArray[i].className.replace(/cft--monatization--hidden/g, '');
        }
    }
}

export function stepClassic(element, increase) {
    var monetizationCont = element.closest('.cft--monetization--container');

    var firstStep = monetizationCont.querySelector('.cft--monetization--container-step-1');
    var secondStep = monetizationCont.querySelector('.cft--monetization--container-step-2');
    var thirdStep = monetizationCont.querySelector('.cft--monetization--container-step-3');

    var headTitle = monetizationCont.querySelector('.head .title');
    var stepBack = monetizationCont.querySelector('.step-back');

    const actualStep = parseInt(monetizationCont.querySelector('.head .title span').textContent, 10);


    // move from step 1 to step 2
    if (firstStep.className.indexOf('cft--monatization--hidden') === -1 && increase) {
        // hide first step
        firstStep.className = firstStep.className + ' cft--monatization--hidden';
        secondStep.className = secondStep.className.replace(/ cft--monatization--hidden/g, '');
        // update header

        monetizationCont.querySelector('.head .title span').innerText = actualStep + 1;
        stepBack.className = 'step-back';

    } else

    // move from step 2 back to step 1
    // when moving from first step to second, show back arrow and chancge label
    if (secondStep.className.indexOf('cft--monatization--hidden') === -1 && !increase) {
        // show first step and hide second step
        firstStep.className = firstStep.className.replace(/ cft--monatization--hidden/g, '');
        secondStep.className = secondStep.className + ' cft--monatization--hidden';

        monetizationCont.querySelector('.head .title span').innerHTML = actualStep - 1;
        stepBack.className = 'step-back cft--monatization--hidden';
        monetizationCont.querySelector('.cft__cta__button').classList.remove('cft--monatization--hidden');
    } else

    // move from step 2 to step 3
    if (secondStep.className.indexOf('cft--monatization--hidden') === -1 && increase) {
        // hide second step
        secondStep.className = secondStep.className + ' cft--monatization--hidden';
        thirdStep.className = thirdStep.className.replace(/cft--monatization--hidden/g, '');
        // update header
        monetizationCont.querySelector('.head .title').innerHTML = actualStep + 1;
        stepBack.className = 'step-back';
        monetizationCont.querySelector('.head').classList.add('cft--monatization--hidden');
        if (localStorage.getItem('cft--donation_via') === 'cardpay') {
            monetizationCont.querySelectorAll('.payment-table').forEach((el, key) => {
                el.style.setProperty('display', 'none', 'important');
            });
        }
    } else

    // move from step 3 back to step 2
    if (thirdStep.className.indexOf('cft--monatization--hidden') === -1 && !increase) {
        // show second step and hide third step
        thirdStep.className = thirdStep.className + ' cft--monatization--hidden';
        secondStep.className = secondStep.className.replace(/cft--monatization--hidden/g, '');
        // update header
        monetizationCont.querySelector('.head .title').innerHTML = actualStep - 1;
    }

}

export function paymentCountryTypeClassic(element, type) {
    const monetizationCont = element.closest('.cft--monetization--container');
    const els = monetizationCont.getElementsByClassName('cft--monetization--bankTransfer') as HTMLCollectionOf<HTMLElement>;
    const choosedPaymentType = monetizationCont.querySelector('input[name="choosedPaymentType"]') as any;
    // const cardPayOptions = monetizationCont.getElementsByClassName('cr0wdWidgetContent-popup-cardPay') as any;
    // const bankTransferOptions = monetizationCont.getElementsByClassName('cr0wdWidgetContent-popup-transfer') as any;
    const cardPayOptions = monetizationCont.querySelectorAll('input[name="payment-option"][value="2"]') as any;
    const bankTransferOptions = monetizationCont.querySelectorAll('input[name="payment-option"][value="1"]') as any;
    const paymentOptions = monetizationCont.querySelector('.payment-options') as any;

    if (type === 'foreign' && choosedPaymentType.value === 'monthly') {
        for (let i = 0; i < els.length; i++) {
            els[i].classList.add('cft--monatization--hidden');
        }
        for (let i = 0; i < bankTransferOptions.length; i++) {
            bankTransferOptions[i].checked = false;
        }
        for (let i = 0; i < cardPayOptions.length; i++) {
            cardPayOptions[i].checked = true;
            changePaymentOptionsClassic(cardPayOptions[i]);
        }
        paymentOptions.style.display = 'none';
        monetizationCont.querySelector('.payment-option[data-id="1"]').classList.add('cft--monatization--hidden');
        monetizationCont.querySelector('.payment-option[data-id="2"]').classList.remove('cft--monatization--hidden');
        monetizationCont.querySelector('.cft--button-container[data-id="1"]').classList.add('cft--monatization--hidden');
        monetizationCont.querySelector('.cft--button-container[data-id="2"]').classList.remove('cft--monatization--hidden');
    } else {
        for (let i = 0; i < els.length; i++) {
            els[i].classList.remove('cft--monatization--hidden');
        }
        paymentOptions.style.display = 'flex';
        if (monetizationCont.querySelector('.payment-options__button input:checked').value === '2') {
            monetizationCont.querySelector('.payment-option[data-id="1"]').classList.add('cft--monatization--hidden');
            monetizationCont.querySelector('.payment-option[data-id="2"]').classList.remove('cft--monatization--hidden');
            monetizationCont.querySelector('.cft--button-container[data-id="1"]').classList.add('cft--monatization--hidden');
            monetizationCont.querySelector('.cft--button-container[data-id="2"]').classList.remove('cft--monatization--hidden');
        } else {
            monetizationCont.querySelector('.payment-option[data-id="1"]').classList.remove('cft--monatization--hidden');
            monetizationCont.querySelector('.payment-option[data-id="2"]').classList.add('cft--monatization--hidden');
            monetizationCont.querySelector('.cft--button-container[data-id="1"]').classList.remove('cft--monatization--hidden');
            monetizationCont.querySelector('.cft--button-container[data-id="2"]').classList.add('cft--monatization--hidden');
        }
    }
}

