import {formSerialize, getJsonFirstProp} from "./helpers";
import {apiUrl, viewsUrl} from "./constants/url";

import {successAlert, errorAlert} from "./alert";

document.addEventListener('DOMContentLoaded', function () {
    // TODO if user is logged in and has valid token
    fetchMyAccountTemplate();
});

function fetchMyAccountTemplate() {
    let url = viewsUrl + 'my-account-content';
    fetch(url)
        .then(response => response.text())
        .then(
            html => {
                document.getElementById('cft--myAccountContent').innerHTML = html
                showProfileActions();
            }
        )
}

function showProfileActions() {
    let allSections= document.querySelectorAll('.cft--myAccount--body--section');

    let showCftNewslettersSection = document.getElementById('showCftNewslettersSection');
    let showCftSavedArticlesSection = document.getElementById('showCftSavedArticlesSection');
    let showCftDonationSection = document.getElementById('showCftDonationSection');
    let showCftMyProfileSection = document.getElementById('showCftMyProfileSection');
    let showCftMyOrdersSection = document.getElementById('showCftMyOrdersSection');
    let bodyIntro = document.querySelector('.cft--myAccount--body--intro');

    let newslettersContent = document.getElementById('cft--myAccount--newsletters');
    let savedArticlesContent = document.getElementById('cft--myAccount--savedArticles');
    let donationContent = document.getElementById('cft--myAccount--donation');
    let myProfileContent = document.getElementById('cft--myAccount--myProfile');
    let myOrdersContent = document.getElementById('cft--myAccount--myOrders');

    showCftNewslettersSection.onclick = (clickEvent) => {
        clickEvent.preventDefault();
        showHelper(newslettersContent);
    };
    showCftSavedArticlesSection.onclick = (clickEvent) => {
       clickEvent.preventDefault();
       showHelper(savedArticlesContent);
    };
    showCftDonationSection.onclick = (clickEvent) => {
       clickEvent.preventDefault();
       showHelper(donationContent);
    };
    showCftMyProfileSection.onclick = (clickEvent) => {
        clickEvent.preventDefault();
        showHelper(myProfileContent);
    };
    showCftMyOrdersSection.onclick = (clickEvent) => {
        clickEvent.preventDefault();
        showHelper(myOrdersContent);
    };

    function showHelper(content) {
        bodyIntro.style.display = 'none';
        allSections.forEach((s, key) => {
            s.classList.remove('active');
        });
        if (!content.classList.contains('active')) {
            content.classList.add('active');
        }
    }
}


