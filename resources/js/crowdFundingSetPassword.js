//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
import {findGetParameter, formSerialize, getJsonFirstProp} from "./helpers";
import {errorAlert} from "./alert";

const apiUrl = 'http://localhost/crowdfundingToolbox/public/api/portal/'; // TEST API
const viewsUrl = 'http://localhost/crowdfundingToolbox/public/portal/';

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.href.indexOf('?setPassword=') > -1) {
        isUserExist();
    }
});

function isUserExist() {
    let data = {
        'token': findGetParameter('setPassword')
    };
    let xhttp = new XMLHttpRequest();
    xhttp.open('POST', apiUrl + 'has-user-generated-token', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';
    xhttp.onload = () => {
        if (xhttp.response.isUserExists) {
            return showSetPasswordTemplate();
        }
    }
    xhttp.send(JSON.stringify(data));
}

function showSetPasswordTemplate() {
    let url = viewsUrl + 'set-generated-password';
    console.log('view')
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--login').innerHTML = html;
                document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
                document.querySelector('.cftLogin--cftLoginWrapper').onclick = function (e) {
                    e.preventDefault();
                    if (e.target.className === 'cftLogin--cftLoginWrapper active')
                        document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
                    document.querySelector('input[name="token"]').value = findGetParameter('setPassword');
                    resetPasswordAction();
                };

            }
        );
}

function resetPasswordAction() {
    const form = document.querySelector('form[name="cftLogin--changePassword--form"]');
    let submitButton = document.querySelector('form[name="cftLogin--changePassword--form"] button[type="submit"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        console.log('submitted');
        let data = JSON.stringify(formSerialize(form));
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'change-password', true);
        xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onerror = () => {
            console.log('error')
        };
        xhttp.onsuccess = () => {
            console.log('success')
        }
        // xhttp.onload = () => {
        //     if (xhttp.response.error) {
        //         errorAlert(getJsonFirstProp(xhttp.response.error));
        //         submitButton.innerText = 'Submit';
        //         submitButton.disabled = '';
        //     }
        //     xhttp.onreadystatechange = () => {
        //         if (xhttp.readyState === 4) {
        //             if (xhttp.status === 200) {
        //                 console.log(xhttp.response)
        //                 localStorage.setItem('cft_usertoken', xhttp.response.token);
        //             } else {
        //                 console.log('failed');
        //             }
        //         }
        //     }
        // };

        xhttp.send(data);
    }, false);

    // code below is required for submitting
    submitButton.addEventListener('click', (clickEvent) => {
        clickEvent.preventDefault();
        let domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}
