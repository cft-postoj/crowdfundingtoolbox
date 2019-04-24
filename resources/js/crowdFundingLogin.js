document.addEventListener('DOMContentLoaded', function () {
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
});


//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
const apiUrl = 'http://localhost/POSTOJ%20-%20CFT/crowdfundingToolbox/public/api/portal/'; // TEST API

function loginAction() {
    const form = document.querySelector('form[name="cftLogin--login--form"]');
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        let data = JSON.stringify(formSerialize(form));
        let xhttp = new XMLHttpRequest();
        xhttp.open('POST', apiUrl + 'login', true);
        xhttp.setRequestHeader('Content-type','application/json; charset=utf-8');
        xhttp.responseType = 'json';
        xhttp.onload = () => {
            console.log(xhttp.response);
        }
        xhttp.send(data);
    });

    // code below is required for submitting
    const submitButton = document.querySelector('button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}


function formSerialize(formElement) {
    const values = {};
    const inputs = formElement.elements;

    for (let i = 0; i < inputs.length; i++) {
        values[inputs[i].name] = inputs[i].value;
    }
    return values;
}
