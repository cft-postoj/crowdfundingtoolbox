import {formSerialize, getJsonFirstProp, isUserLoggedIn} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";
import * as myAccountTexts from "./json/myAccount";

document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('cft--myaccount') !== null)
        if (isUserLoggedIn() === false) {
            location.href = '/';
        }
    fetchMyAccountTemplate();

    setTimeout(() => {
        myAccountButton();
    }, 2000);

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
                document.getElementById('cft-myAccount-body-section').innerHTML = html
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