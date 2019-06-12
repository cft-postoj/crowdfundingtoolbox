//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
import {formSerialize, getJsonFirstProp, isUserLoggedIn} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as myAccountTexts from './json/myAccount';

import {successAlert, errorAlert} from "./alert";

document.addEventListener('DOMContentLoaded', function () {
    fetchLoginTemplate();
});


function loginAction() {
    const form = document.querySelector('form[name="cftLogin--login--form"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = JSON.stringify(formSerialize(form));
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'login', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            if (xhttp.response.token) {
                localStorage.setItem('cft_usertoken', xhttp.response.token);
                showMyAccount();
            }
        }
        xhttp.send(data);
    });

    // code below is required for submitting
    const submitButton = document.querySelector('form[name="cftLogin--login--form"] button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}

function registerAction() {
    const form = document.querySelector('form[name="cftLogin--register--form"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = JSON.stringify(formSerialize(form));
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'register', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            // if there is some error
            if (xhttp.response.error) {
                errorAlert(getJsonFirstProp(xhttp.response.error));
            } else {
                successAlert(xhttp.response.message);
            }
        };
        xhttp.send(data);
    });

    // code below is required for submitting
    const submitButton = document.querySelector('form[name="cftLogin--register--form"] button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}

function forgotPasswordAction() {
    const form = document.querySelector('form[name="cftLogin--forgotPassword--form"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = JSON.stringify(formSerialize(form));
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'forgotPassword', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            // if there is some error
            if (xhttp.response.error) {
                errorAlert(getJsonFirstProp(xhttp.response.error));
            } else {
                if (xhttp.status === 200) {
                    successAlert(xhttp.response.message);
                } else {
                    errorAlert(xhttp.response.message);
                }
            }
        };
        xhttp.send(data);
    });

    // code below is required for submitting
    const submitButton = document.querySelector('form[name="cftLogin--forgotPassword--form"] button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}

function showMyAccount() {
    document.getElementById('cft--loginButton').style.display = 'none';
    setTimeout(() => {
        document.getElementById('cft--myAccountButton').style.display = 'block';
        document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
    }, 500);
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
        };
    }

}



