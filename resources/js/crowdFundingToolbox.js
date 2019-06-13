document.addEventListener('DOMContentLoaded', function () {
    //let apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
    let apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API
    let sidebarPlaceholder = document.getElementById('cr0wdFundingToolbox-sidebar');
    let fixedPlaceholder = document.getElementById('cr0wdFundingToolbox-fixed');
    let leaderboardPlaceholder = document.getElementById('cr0wdFundingToolbox-leaderboard');

    //get widgets for users and track, that user has been on specific page
    data = JSON.stringify(
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
                setCookie('cr0wdFundingToolbox-user_cookie',xhttp.response['user_cookie']);
                for (let i = 0; i < xhttp.response['widgets'].length; i++) {
                    let el = xhttp.response['widgets'][i];
                    console.log(el);
                    switch (el.widget_type.method) {
                        case 'sidebar':
                            var scriptElement = document.createElement('script');
                            var inlineScript = document.createTextNode(parseScriptFromResponse(el.response[cr0wdGetDeviceType()]));
                            scriptElement.appendChild(inlineScript);
                            if (sidebarPlaceholder != null) {
                                sidebarPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()];
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

    clickedDom = event.path[0];
    cftPlaceholders = document.querySelectorAll('[id^=cr0wdFundingToolbox]');
    cftPlaceholders.forEach(node => {
        node.addEventListener('click', function ($event) {

            localStorage.getItem('cr0wdFundingToolbox');
            clickedDom = event.path[0];
            let xhttp = new XMLHttpRequest();
            data = JSON.stringify(
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

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var expires = "expires=Fri, 31 Dec 9999 23:59:59 GMT";
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function parseScriptFromResponse(response) {
    scripts = response;
    indexStart = response.indexOf('id="scripts">');
    indexStart = scripts.indexOf('>', indexStart);
    indexStart = scripts.indexOf('>', indexStart + 1);
    indexEnd = response.indexOf('</script>');
    scripts = scripts.substr(indexStart + 1, indexEnd - indexStart - 1);
    return scripts;
}