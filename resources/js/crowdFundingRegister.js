import {errorShowing, formSerialize, getCookie, getJsonFirstProp, portalUrl} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as registerTexts from "./json/register";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('cft--register') !== null)
        fetchRegisterTemplate();
});

function fetchRegisterTemplate() {
    let url = viewsUrl + 'register';
    console.log(url)
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--register').innerHTML = html,
                    showPassword(),
                    register()
            }
        );
}

function showPassword() {
    document.querySelector('input#cft-password + img').onclick = (e) => {
        if (document.querySelector('input#cft-password').getAttribute('type') === 'password') {
            document.querySelector('input#cft-password').setAttribute('type', 'text');
        } else {
            document.querySelector('input#cft-password').setAttribute('type', 'password');
        }
    };
}

function register() {
    const form = document.querySelector('form[name="cft-register"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const data = {
            'email': document.querySelector('form[name="cft-register"] input[name="cft-email"]').value,
            'password': document.querySelector('form[name="cft-register"] input[name="cft-password"]').value,
            'agreeMailing': document.querySelector('form[name="cft-register"] input[name="cft-mailing"]').checked,
            'agreePersonalData': document.querySelector('form[name="cft-register"] input[name="cft-agree"]').checked,
            'user_cookie': getCookie("cr0wdFundingToolbox-user_cookie")
    };
        if (!data.agreePersonalData) {
            return errorShowing('form[name="cft-register"] span.cft-agree',
                'form[name="cft-register"] input[name="cft-agree"]',
                registerTexts.agreeConfirm);
        }
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'register', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            // if there is some error
            if (xhttp.response.error !== undefined) {
                switch (xhttp.response.error.type) {
                    case 'email-registered':
                        errorShowing('form[name="cft-register"] span.cft-email',
                            'form[name="cft-register"] input[name="cft-email"]',
                            registerTexts.emailExists);
                        break;
                    case 'email':
                        errorShowing('form[name="cft-register"] span.cft-email',
                            'form[name="cft-register"] input[name="cft-email"]',
                            registerTexts.emailIncorrect);
                        break;
                    default:
                        if (xhttp.response.password !== undefined) {
                            errorShowing('form[name="cft-register"] span.cft-password',
                                'form[name="cft-register"] input[name="cft-password"]',
                                registerTexts.passwordIncorrect);
                            break;
                        }
                        errorShowing('form[name="cft-register"] span.cft-agree',
                            'form[name="cft-register"] button[type="submit"]',
                            registerTexts.undefinedError);
                        break;
                }
            } else {
                document.querySelectorAll('form[name="cft-register"] input').forEach((e) => {
                    e.value = '';
                    e.checked = false;
                });
                document.querySelector('form[name="cft-register"] span.cft-register').classList.add('active');
                document.querySelector('form[name="cft-register"] span.cft-register').innerHTML = registerTexts.registerSuccess;
                setTimeout(async () => {
                    // redirect counter
                    for (let i = 5; i >= 0; i--) {
                            document.querySelector('form[name="cft-register"] span.cft-register #cft-seconds').innerHTML = i;
                            if (i === 0) {
                                window.location.href = portalUrl;
                            }
                            await sleep(1000);

                    }
                }, 500);
            }
        };
        return xhttp.send(JSON.stringify(data));
    });

    // code below is required for submitting
    const submitButton = document.querySelector('form[name="cft-register"] button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        clickEvent.preventDefault();
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    });
}




function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}