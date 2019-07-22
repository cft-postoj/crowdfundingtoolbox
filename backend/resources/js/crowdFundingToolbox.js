import {
    setCookie, getCookie
} from "./helpers";
import {apiUrl} from './constants/url';

const sidebarPlaceholder = document.getElementById('cr0wdFundingToolbox-sidebar');
const fixedPlaceholder = document.getElementById('cr0wdFundingToolbox-fixed');
const leaderboardPlaceholder = document.getElementById('cr0wdFundingToolbox-leaderboard');
const popupPlaceholder = document.getElementById('cr0wdFundingToolbox-popup');
const lockedPlaceholder = document.getElementById('cr0wdfundingToolbox-locked');
const articlePlaceholder = document.getElementById('cr0wdfundingToolbox-article');
const customPlaceholder = document.getElementById('cr0wdfundingToolbox-custom');

function getWidgets(apiUrl) {

    //get widgets for users and track, that user has been on specific page
    let data = JSON.stringify(
        {
            'article_title': document.querySelector('title').innerText,
            'user_cookie': getCookie("cr0wdFundingToolbox-user_cookie"),
            'user_id': localStorage.getItem('cft_usertoken')
        }
    );

    let xhttp = new XMLHttpRequest();
    xhttp.responseType = 'json';
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === XMLHttpRequest.DONE) {
            if (xhttp.response != null) {
                if (!getCookie("cr0wdFundingToolbox-user_cookie")) {
                    console.log(xhttp.response)
                    setCookie('cr0wdFundingToolbox-user_cookie', xhttp.response.user_cookie);
                }
                for (let i = 0; i < xhttp.response['widgets'].length; i++) {
                    let el = xhttp.response['widgets'][i];
                    console.log(el);
                    switch (el.widget_type.method) {
                        case 'sidebar':
                            // TODO fix this -- error when not script included (not monetization widget)
                            let scriptElement = document.createElement('script');
                            let inlineScript = document.createTextNode(parseScriptFromResponse(el.response[cr0wdGetDeviceType()]));
                            scriptElement.appendChild(inlineScript);
                            if (sidebarPlaceholder != null) {
                                sidebarPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()];
                                console.log(cr0wdGetDeviceType());
                                console.log(el.response[cr0wdGetDeviceType()]);
                                sidebarPlaceholder.dataset.show_id = el.show_id;
                                sidebarPlaceholder.appendChild(scriptElement);
                            }
                            break;
                        case 'leaderboard':
                            (leaderboardPlaceholder != null) &&
                            (leaderboardPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            break;
                        case 'fixed':
                            (fixedPlaceholder != null) &&
                            (fixedPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            document.querySelector('.cr0wdWidgetContent--closeWidget').addEventListener('click', function () {
                                fixedPlaceholder.style.display = 'none';
                            });
                            break;
                        case 'popup':
                            if (isPopupEnableToVisit()) {
                                (popupPlaceholder != null) &&
                                (popupPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                                document.querySelector('.cr0wdWidgetContent--closeWidget').addEventListener('click', function () {
                                    popupPlaceholder.style.display = 'none';
                                });
                                setVisitingPopupTime();
                            }
                            break;
                        case 'locked':
                            (lockedPlaceholder != null) &&
                            (setLockedContentArticle(el.response[cr0wdGetDeviceType()]));
                            break;
                        case 'article':
                            (articlePlaceholder != null) &&
                            (articlePlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            break;
                        case 'custom':
                            (customPlaceholder != null) &&
                            (customPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
    };
    xhttp.open('POST', apiUrl + 'widgets');
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.send(data);
}


function setLockedContentArticle(widgetContent) {
    let countOfParagraphs = 0;
    lockedPlaceholder.parentNode.childNodes.forEach((item, key) => {
        if (item.nodeName === 'P') {
            countOfParagraphs++;
        }
    });
    if (countOfParagraphs > 1) {
        let countP = 0;
        let isDisabledContent = false;
        lockedPlaceholder.parentNode.childNodes.forEach((item, key) => {
            if (item.childNodes.length > 0) {
                countP++;
                if (countP >= Math.round(countOfParagraphs / 2)) { // hide content second half part of article content
                    item.classList.add('cr0wdfunding--locked--hideContent');
                } else if (countP + 1 === Math.round(countOfParagraphs / 2)) {
                    if (!isDisabledContent) {
                        item.style.position = 'relative';
                        const appendedChild = '<span id="cr0wdfunding--locked--gradient" style="position: absolute;width: 100%;height: 100%;top: 0;left: 0;background-image: linear-gradient(transparent, white);"></span>';
                        item.insertAdjacentHTML('beforeend', appendedChild);
                        isDisabledContent = true;
                    }
                }
            }
        });
        lockedPlaceholder.innerHTML = widgetContent;
        document.getElementById('btn-cr0wdfunding--continueReading').addEventListener('click', function () {
            lockedPlaceholder.parentNode.childNodes.forEach((item, key) => {
                if (item.classList !== undefined) {
                    if (item.classList.contains('cr0wdfunding--locked--hideContent')) { // hide content second half part of article content
                        item.classList.remove('cr0wdfunding--locked--hideContent');
                    }
                }
            });
            document.getElementById('cr0wdfunding--locked--gradient').style.display = 'none';
            lockedPlaceholder.style.display = 'none';
        });
    }
}

function setVisitingPopupTime() {
    const time = new Date().getTime() / 1000;
    return window.localStorage.setItem('cft-popup-time', time);
}

function isPopupEnableToVisit() {
    const actualTime = new Date().getTime() / 1000;
    const thirtyMinutes = 1800; // 30 min === 1800 sec
    const storedTime = window.localStorage.getItem('cft-popup-time');
    if (storedTime != null) {
        if (actualTime - (parseInt(storedTime, 10) + thirtyMinutes) <= 0) {
            return false;
        }
    }
    return true;
}

function registerClick(apiUrl) {
    let cftPlaceholders = document.querySelectorAll('[id^=cr0wdFundingToolbox]');
    cftPlaceholders.forEach(node => {
        node.addEventListener('click', function ($event) {
            let clickedDom = event.path[0];
            let xhttp = new XMLHttpRequest();
            let data = JSON.stringify(
                {
                    'node_id': clickedDom.id,
                    'node_class': clickedDom.className,
                    'show_id': node.closest('[id^=cr0wdFundingToolbox]').dataset.show_id
                }
            );
            xhttp.open('POST', apiUrl + 'tracking/click', true);
            xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
            xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            xhttp.responseType = 'json';
            xhttp.send(data);

        })
    });
}


function registerInsertValue(apiUrl) {
    let cftPlaceholders = document.querySelectorAll('[class=cft--monatization--donation-button]');
    cftPlaceholders.forEach(node => {
        node.addEventListener('click', function ($event) {

            let clickedDom = event.path[0];
            let xhttp = new XMLHttpRequest();
            let data = JSON.stringify(
                {
                    'node_id': clickedDom.id,
                    'node_class': clickedDom.className,
                    'show_id': node.closest('[id^=cr0wdFundingToolbox]').dataset.show_id
                }
            );

            xhttp.open('POST', apiUrl + 'tracking/click', true);
            xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
            xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
            xhttp.responseType = 'json';
            xhttp.send(data);

        })
    });
}

document.addEventListener('DOMContentLoaded', function () {
    //let apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
    getWidgets(apiUrl);
    registerClick(apiUrl);
    registerInsertValue(apiUrl);
});

function cr0wdGetDeviceType() {
    let device = '';
    if (window.innerWidth < 768) {
        device = 'mobile';
    } else if (window.innerWidth > 767 && window.innerWidth < 1200) {
        device = 'tablet';
    } else {
        device = 'desktop';
    }
    return device;
}

function parseScriptFromResponse(response) {
    let scripts = response;
    let indexStart = response.indexOf('id="scripts">');
    indexStart = scripts.indexOf('>', indexStart);
    indexStart = scripts.indexOf('>', indexStart + 1);
    let indexEnd = response.indexOf('</script>');
    scripts = scripts.substr(indexStart + 1, indexEnd - indexStart - 1);
    return scripts;
}