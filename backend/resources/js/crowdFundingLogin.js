//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
import {errorShowing, successShowing, isUserLoggedIn, fadeIn, resetFormInputs, getCookie} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as myAccountTexts from './json/myAccount';
import * as loginTexts from './json/login';


import {successAlert, errorAlert} from "./alert";

document.addEventListener('DOMContentLoaded', function () {
    fetchLoginTemplate();
});


function loginAction() {
    const form = document.querySelector('form[name="cft-login"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = {
            'email': document.querySelector('form[name="cft-login"] input[name="cft-email"]').value,
            'password': document.querySelector('form[name="cft-login"] input[name="cft-password"]').value,
            'user_cookie' : getCookie("cr0wdfundingToolbox-user_cookie")
        };
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'login', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            if (xhttp.response.error) {
                switch (xhttp.response.type) {
                    case 'email':
                        errorShowing('form[name="cft-login"] span.cft-email',
                            'form[name="cft-login"] input[name="cft-email"]',
                            loginTexts.incorrectEmail);
                        break;

                    case 'password':
                        errorShowing('form[name="cft-login"] span.cft-password',
                            'form[name="cft-login"] input[name="cft-password"]',
                            loginTexts.incorrectPassword);
                        break;
                }
            }
            if (xhttp.response.token) {
                localStorage.setItem('cft_usertoken', xhttp.response.token);
                showMyAccount();
            }
        }
        xhttp.send(JSON.stringify(data));
    });

    // code below is required for submitting
    const submitButton = document.querySelector('form[name="cft-login"] button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}

function forgotPasswordAction() {
    const form = document.querySelector('form[name="cft-forgottenPassword"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = {
            email: document.querySelector('form[name="cft-forgottenPassword"] input[name="cft-email"]').value
        };
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'forgotten-password', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            // if there is some error
            if (xhttp.response.error) {
                errorShowing('form[name="cft-forgottenPassword"] span.cft-email',
                    'form[name="cft-forgottenPassword"] input[name="cft-email"]',
                    loginTexts.incorrectEmail);
            } else {
                successShowing('form[name="cft-forgottenPassword"] span.cft-email',
                    'form[name="cft-forgottenPassword"] input[name="cft-email"]',
                    loginTexts.successResetPassword);
                resetFormInputs('form[name="cft-forgottenPassword"]');
            }
        };
        xhttp.send(JSON.stringify(data));
    });

    // code below is required for submitting
    const submitButton = document.querySelector('form[name="cft-forgottenPassword"] button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}

function showMyAccount() {
    const button = document.getElementById('cft--loginButton');
    const loginDropdown = document.querySelector('.cft--loginDropdown');
    loginDropdown.classList.remove('active');
    button.innerHTML = myAccountTexts.myAccountButton;
    button.onclick = () => {
        if (location.href.indexOf(myAccountTexts.myAccountUrl) === -1)
            location.href = myAccountTexts.myAccountUrl;
    }
}

function fetchLoginTemplate() {
    let url = viewsUrl + 'login';
    console.log(url)
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--login').innerHTML = html
                loginFunctions();
            }
        );
}

function loginFunctions() {
    const button = document.getElementById('cft--loginButton');
    if (isUserLoggedIn() !== false) {
        button.innerHTML = myAccountTexts.myAccountButton;
        button.onclick = () => {
            if (location.href.indexOf(myAccountTexts.myAccountUrl) === -1)
                location.href = myAccountTexts.myAccountUrl;
        }
    } else {
        button.onclick = (e) => {
            e.preventDefault();

            // TOGGLE LOGIN DROPDOWN
            document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.toggle('active');
            if (document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.contains('active')) {
                document.querySelector('body').onclick = (e) => {
                    if (e.target.nodeName !== 'A') {
                        e.preventDefault();
                        if (e.target.classList.value.indexOf('cft--') === -1
                            && e.target.classList.value !== ''
                            && e.target.nodeName !== 'INPUT'
                            && e.target.nodeName !== 'SPAN')
                            document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.remove('active');
                    }

                }
            }

            loginAction();
            showForgottenPassword();
        };
    }

}

function showForgottenPassword() {
    const button = document.getElementById('cft--forgottenPassword');
    const forgottenPasswordForm = document.querySelector('form[name="cft-forgottenPassword"]');
    const loginForm = document.querySelector('form[name="cft-login"]');
    button.addEventListener('click', (e) => {
        e.preventDefault();
        loginForm.style.display = 'none';
        fadeIn(forgottenPasswordForm, 500);
    });
    forgotPasswordAction();
    showLogin();
}

function showLogin() {
    const button = document.getElementById('cft--showLogin');
    const forgottenPasswordForm = document.querySelector('form[name="cft-forgottenPassword"]');
    const loginForm = document.querySelector('form[name="cft-login"]');
    button.addEventListener('click', (e) => {
        e.preventDefault();
        forgottenPasswordForm.style.display = 'none';
        fadeIn(loginForm, 500);
    });
}



