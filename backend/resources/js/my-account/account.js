import * as countryPhones from "../json/countryPhone";
import {
    addSubmitFormHack, formSerialize,
    getRequest, hideElementAfterTimeout,
    makeOptionSelected,
    parseJwt, scrollToElement, setCheckboxValue,
    setTokenHeader,
    setValueIfNotNull,
    showCountryPhones
} from "../helpers";
import * as countries from "../json/countries";
import {apiUrl} from "../constants/url";
import {addAlertMessage} from "../crowdFundingMyAccount";

export function accountInit(message) {
    getCountryPhones(),
        addAlertMessage(message),
        getUserData(),
        logout(),
        getCountries()
}

function getCountryPhones() {
    const countryPhoneSelect = document.querySelector('select[name="cft-telephone-prefix"]');
    if (countryPhoneSelect !== null && countryPhones.default !== null) {
        showCountryPhones(countryPhones.default).forEach((option) => {
            let el = document.createElement('option');
            el.value = option.split('(')[1].split(')')[0];
            el.text = option;
            if (option.indexOf('SK (+421') > -1) {
                el.selected = true;
            }
            countryPhoneSelect.appendChild(el);
        })
    }
}

function getCountries() {
    const countrySelect = document.querySelector('select[name="cft-country"]');
    if (countrySelect !== null) {
        countries.default.map((c) => {
            let el = document.createElement('option');
            el.value = c.name;
            el.text = c.name;
            if (c.code === 'SK') {
                el.selected = true;
            }
            countrySelect.appendChild(el);
        })
    }
}

function logout() {
    const logoutButton = document.getElementById('cft--logout');
    logoutButton.addEventListener('click', (e) => {
        e.preventDefault();
        let header = [];
        if (getRequest(apiUrl + 'logout', setTokenHeader(header)).status === 'logout') {
            location.href = '/';
        }
    });
}

function getUserData() {
    let actualHeader = [];
    const jwtEmail = parseJwt().email;
    document.querySelector('input[name="cft-email"]').value = jwtEmail;
    document.querySelector('input[name="cft-password"]').value = '********';

    const userData = getRequest(apiUrl + 'user-details', setTokenHeader(actualHeader));
    if (userData !== null) {
        if (userData.user_details !== null) {
            setValueIfNotNull('input[name="cft-firstName"]', userData.user_details.first_name);
            setValueIfNotNull('input[name="cft-lastName"]', userData.user_details.last_name);
            setValueIfNotNull('input[name="cft-street"]', userData.user_details.street);
            setValueIfNotNull('input[name="cft-house-number"]', userData.user_details.house_number);
            makeOptionSelected('select[name="cft-telephone-prefix"]', userData.user_details.telephone_prefix);
            setValueIfNotNull('input[name="cft-telephone"]', userData.user_details.telephone);
            setValueIfNotNull('input[name="cft-city"]', userData.user_details.city);
            setValueIfNotNull('input[name="cft-zip"]', userData.user_details.zip);
            makeOptionSelected('select[name="cft-country"]', userData.user_details.country);
            setCheckboxValue('input[name="cft-deliveryAddressSame"]', userData.user_details.delivery_address_is_same);
        }
        setCheckboxValue('input[name="cft-mailing"]', userData.user_gdpr.agree_mail_sending);
        setCheckboxValue('input[name="cft-agree"]', userData.user_gdpr.agree_general_conditions);
        editAccountDetails();
    }

    // if some input is empty, show error
    let emptyElements = [];
    document.querySelectorAll('#cft--myaccount input').forEach((input) => {
        if (input.value === '') {
            emptyElements.push('input[name="' + input.name + '"]');
        }
    });
    if (emptyElements !== []) {
        addAlertMessage('endRegister', emptyElements)
    }
}

function editAccountDetails() {
    const formSelector = 'form[name="cft-myAccountDetails"]';
    const form = document.querySelector(formSelector);
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = {
            'cft-agree': document.querySelector(formSelector + ' input[name="cft-agree"]').checked,
            'cft-city': document.querySelector(formSelector + ' input[name="cft-city"]').value,
            'cft-country': document.querySelector(formSelector + ' select[name="cft-country"]').value,
            'cft-email': document.querySelector(formSelector + ' input[name="cft-email"]').value,
            'cft-firstName': document.querySelector(formSelector + ' input[name="cft-firstName"]').value,
            'cft-house-number': document.querySelector(formSelector + ' input[name="cft-house-number"]').value,
            'cft-lastName': document.querySelector(formSelector + ' input[name="cft-lastName"]').value,
            'cft-mailing': document.querySelector(formSelector + ' input[name="cft-mailing"]').checked,
            'cft-password': document.querySelector(formSelector + ' input[name="cft-password"]').value,
            'cft-street': document.querySelector(formSelector + ' input[name="cft-street"]').value,
            'cft-telephone': document.querySelector(formSelector + ' input[name="cft-telephone"]').value,
            'cft-telephone-prefix': document.querySelector(formSelector + ' select[name="cft-telephone-prefix"]').value,
            'cft-zip': document.querySelector(formSelector + ' input[name="cft-zip"]').value
        };
        let xhttp = new XMLHttpRequest();
        xhttp.open('PUT', apiUrl + 'update-user-details', true);
        let header = [];
        header.push({
            name: 'Content-type',
            value: 'application/json; charset=utf8'
        });
        header = setTokenHeader(header);

        header.map((h) => {
            xhttp.setRequestHeader(h.name, h.value);
        });

        xhttp.responseType = 'json';
        xhttp.onload = () => {
            if (xhttp.response.error) {
                addAlertMessage('errorUpdateAccountDetails', []);
            } else {
                console.log(xhttp.response)
                addAlertMessage('successUpdateAccountDetails', []);
            }
            scrollToElement(document.querySelector('body'), 0, 50);
        };
        xhttp.send(JSON.stringify(data));
    }, false);
}