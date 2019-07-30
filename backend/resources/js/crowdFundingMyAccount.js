import {
    hideElementAfterTimeout,
    isUserLoggedIn
} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as myAccountTexts from "./json/myAccount";
import {accountInit} from "./my-account/account";
import {previewInit} from "./my-account/preview";
import {donationsInit} from "./my-account/donations";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('cft--myaccount') !== null) {
        document.querySelector('footer').style.margin = 0;
        if (location.href.indexOf('?generatedResetToken') > -1) {
            let generatedToken = location.href.split('?generatedResetToken=')[1];
            if (generatedToken.indexOf('&loggedIn') > -1) {
                generatedToken = generatedToken.split('&loggedIn')[0];
            }
            isValidGeneratedToken(generatedToken);
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


function fetchMyAccountTemplate(message) {
    const url = viewsUrl + 'my-account';
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--myaccount').innerHTML = html;
                    myAccountButton();
                    getSection(message);
                    changeMyAccountView();
            }
        );
}

function myAccountButton() {
    const button = document.getElementById('cft--loginButton');
    button.innerHTML = myAccountTexts.myAccountButton;
    button.onclick = () => {
        if (location.href.indexOf(myAccountTexts.myAccountUrl) === -1)
            location.href = myAccountTexts.myAccountUrl;
    }
    if (button != null)
        button.classList.add('active');
}

function getSection(message) {
    let splitter = location.href.split('#')[1];
    if (splitter !== undefined) {
        if (splitter.indexOf('?') > -1) {
            splitter = splitter.split('?')[0];
        }
    }
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
            sectionContent('account', message);
            break;
        default:
            sectionContent('preview');
            break;
    }
}

function sectionContent(section, message) {
    const url = viewsUrl + 'my-account/' + section;
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft-myAccount-body-section').innerHTML = html;
                if (section === 'account') {
                    accountInit(message)
                } else if (section === 'preview') {
                    previewInit();
                } else if (section === 'donation') {
                    donationsInit();
                }
                showSubmenu();
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

function showSubmenu() {
    const element = document.querySelectorAll('.cft--showSubMenu');
    element.forEach((el) => {
       el.addEventListener('click', (e) => {
         setTimeout(() => {
             getSection();
         }, 100);
       });
    });
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
        if (xhttp.response != null) {
            localStorage.setItem('cft_usertoken', xhttp.response.token);
            fetchMyAccountTemplate('resetPassword');
        } else {
            showMyAccountNotValidView();
        }
    };
    xhttp.send(JSON.stringify(data));
}

function showMyAccountNotValidView() {
    // Bad request view
    const url = viewsUrl + 'my-account/bad-request';
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--myaccount').innerHTML = html
            }
        );
}

export function addAlertMessage(message, elements) {
    const alertElement = document.querySelector('#cft--myAccount .cft--alert');
    alertElement.classList.add('active');
    alertElement.classList.remove('error');
    alertElement.classList.remove('success');
    let resultText = '';
    switch (message) {
        case 'resetPassword':
            resultText = myAccountTexts.resetYourPasswordAlert;
            document.querySelector('input[name="cft-password"]').classList.add('error');
            break;
        case 'endRegister':
            resultText = myAccountTexts.endRegister;
            alertElement.classList.add('error');
            break;
        case 'successUpdateAccountDetails':
            resultText = myAccountTexts.successUpdate;
            alertElement.classList.add('success');
            hideElementAfterTimeout(alertElement, 5000);
            break;
        case 'errorUpdateAccountDetails':
            resultText = myAccountTexts.errorUpdate;
            alertElement.classList.add('error');
            break;
        default:
            alertElement.classList.remove('active');
            break;
    }
    alertElement.innerHTML = resultText;
    if (elements !== [] && elements !== undefined) {
        elements.map((e) => {
            document.querySelector(e).classList.add('error');
            document.querySelector(e).addEventListener('keyup', () => {
                document.querySelector(e).classList.remove('error');
                removeAlertMessage();
            });
        });
    }
    removeAlertMessage();
}

export function removeAlertMessage() {
    const alertElement = document.querySelector('#cft--myAccount .cft--alert');
    let hasInputErrorClass = false;
    document.querySelectorAll('#cft--myAccount input').forEach((input) => {
        if (input.classList.contains('error')) {
            hasInputErrorClass = true;
        }
    });
    if (!hasInputErrorClass && !alertElement.classList.contains('success')) {
        alertElement.classList.remove('active');
    }
}