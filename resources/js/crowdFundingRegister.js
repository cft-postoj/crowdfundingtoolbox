import {formSerialize, getJsonFirstProp} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";

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
                    showPassword()
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
