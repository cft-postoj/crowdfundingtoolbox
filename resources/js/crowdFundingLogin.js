//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
import {formSerialize, getJsonFirstProp} from "./helpers";

const apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API
const viewsUrl = 'http://localhost/crowdfundingToolbox/public/portal/';
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
    document.getElementById('cft--loginButton').onclick = (e) => {
        e.preventDefault();
        loginAction();
        document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
        document.querySelector('.cftLogin--cftLoginWrapper').onclick = function (e) {
            e.preventDefault();
            if (e.target.className === 'cftLogin--cftLoginWrapper active')
                document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
        };

        // SHOW REGISTER
        document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
            e.preventDefault();
            registerAction();
            document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
        };

        // SHOW LOGIN
        document.querySelector('.cftLogin--cftLoginWrapper--content--register .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
            e.preventDefault();
            document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
        };

        // SHOW FORGOT PASSWORD
        document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button.forgotPassword').onclick = function (e) {
            e.preventDefault();
            forgotPasswordAction();
            document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
            document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'block';
            document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword .cftLogin--cftLoginWrapper--content--button.login').onclick = function (e) {
                document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'none';
                document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
            };
            document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword .cftLogin--cftLoginWrapper--content--button.register').onclick = function (e) {
                document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'none';
                document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
            };
        };
    };
}



