import {apiUrl, viewsUrl} from "./constants/url";

document.addEventListener('DOMContentLoaded', function () {
    let sidebarPlaceholder = document.getElementById('cr0wdFundingToolbox-sidebar');
    let fixedPlaceholder = document.getElementById('cr0wdFundingToolbox-fixed');
    let leaderboardPlaceholder = document.getElementById('cr0wdFundingToolbox-leaderboard');

    let xhttp = new XMLHttpRequest();
    xhttp.responseType = 'json';
    xhttp.onreadystatechange = function () {
        if (xhttp.readyState === XMLHttpRequest.DONE) {
            if (xhttp.response != null) {
                for (let i = 0; i < xhttp.response.length; i++) {
                    let el = xhttp.response[i];
                    console.log(el);
                    switch (el.widget_type.method) {
                        case 'sidebar':
                            (sidebarPlaceholder != null) &&
                            (sidebarPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            break;
                        case 'leaderboard':
                            (leaderboardPlaceholder != null) &&
                            (leaderboardPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            break;
                        case 'fixed':
                            (fixedPlaceholder != null) &&
                            (fixedPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
                            break;
                        default:
                            break;
                    }
                }
            }
        }
    }
    xhttp.open('GET', apiUrl + 'widgets');
    xhttp.send();
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
