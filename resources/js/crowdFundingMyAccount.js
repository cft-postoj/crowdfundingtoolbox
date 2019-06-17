import {
    formSerialize,
    getJsonFirstProp,
    getRequest,
    isUserLoggedIn,
    setTokenHeader,
    showCountryPhones
} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as myAccountTexts from "./json/myAccount";
import * as countryPhones from './json/countryPhone';
import * as countries from './json/countries';
import {errorAlert, successAlert} from "./alert";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('cft--myaccount') !== null) {
        if (location.href.indexOf('?generatedResetToken') > -1) {
            isValidGeneratedToken(location.href.split('?generatedResetToken')[1]);
        } else {
            if (isUserLoggedIn() === false) {
                location.href = '/';
            } else {
                fetchMyAccountTemplate();

                setTimeout(() => {
                    myAccountButton();
                }, 2000);
            }
        }

    }
});


function fetchMyAccountTemplate() {
    const url = viewsUrl + 'my-account';
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--myaccount').innerHTML = html,
                    getSection(),
                    changeMyAccountView()
            }
        );
}

function myAccountButton() {
    const button = document.getElementById('cft--loginButton');
    if (button != null)
        button.classList.add('active');
}

function getSection() {
    const splitter = location.href.split('#')[1];
    console.log(splitter)
    changeActiveMenu(splitter);
    switch (splitter) {
        case myAccountTexts.newsletterSlug:
            sectionContent('newsletter');
            break;
        case myAccountTexts.savedArticlesSlug:
            sectionContent('saved-articles');
            break;
        case myAccountTexts.donationSlug:
            sectionContent('donation');
            break;
        case myAccountTexts.ordersSlug:
            sectionContent('orders');
            break;
        case myAccountTexts.accountSlug:
            sectionContent('account');
            break;
        default:
            sectionContent('preview');
            break;
    }
}

function sectionContent(section) {
    const url = viewsUrl + 'my-account/' + section;
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft-myAccount-body-section').innerHTML = html;
                if (section === 'account') {
                    getCountryPhones(),
                        getUserData(),
                        getCountries(),
                        logout()
                }
            }
        );
}

function changeActiveMenu(splitter) {
    let menuSlug = '#' + splitter;
    if (splitter == null || splitter == '') {
        menuSlug = '#';
    }
    document.querySelectorAll('.cft--myAccount--sidebar a').forEach((e) => {
        e.parentElement.classList.remove('active');
    });
    document.querySelector('.cft--myAccount--sidebar a[href="' + menuSlug + '"]').parentElement.classList.add('active');
}


function changeMyAccountView() {
    document.querySelectorAll('.cft--myAccount--sidebar a').forEach((el) => {
        el.addEventListener('click', (e) => {
            setTimeout(() => {
                getSection();
            }, 100);
        })
    });
}

function getCountryPhones() {
    const countryPhoneSelect = document.querySelector('select[name="cft-countryNumber"]');
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
        JSON.parse(countries).map((c) => {
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
    console.log(getRequest(apiUrl + 'user-details', setTokenHeader(actualHeader)));
}

function isValidGeneratedToken(token) {
    let data = {
        generatedToken: token
    };
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', apiUrl + 'has-user-generated-token', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';
    xhttp.onload = () => {
        console.log(xhttp.response)

        alert('Dopyt pre generovany token...');

        /*
        TODO: ADD ALERT NOTIFICATION FOR THIS USER IN MY ACCOUNT VIEW .. to change password
         */
    };
    xhttp.send(JSON.stringify(data));
}