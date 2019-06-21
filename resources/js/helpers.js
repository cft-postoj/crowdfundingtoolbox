import {apiUrl} from "./constants/url";

export function toggleClassLists(array, remove, el) {
    removeClassLists(remove, el);
    setTimeout(() => {
        array.forEach((item, index) => {
            el.classList.toggle(item);
        });
    }, 50);

}

export function addClassLists(array, el) {
    array.forEach((item, index) => {
        el.classList.add(item);
    });
}

export function removeClassLists(classes, el) {
    el.classList.remove(classes);
}

export function getJsonFirstProp(jsonObj) {
    let firstProp;
    for (let key in jsonObj) {
        if (jsonObj.hasOwnProperty(key)) {
            firstProp = jsonObj[key];
            break;
        }
    }
    return firstProp;
}

export function removeFormData(formElement) {
    document.querySelectorAll(formElement + ' input').forEach((el, index) => {
        el.value = '';
    });
    document.querySelectorAll(formElement + ' textarea').forEach((el, index) => {
        el.value = '';
    });
}

export function findGetParameter(parameterName) {
    let result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

export function formSerialize(formElement) {
    const values = {};
    const inputs = formElement.elements;

    for (let i = 0; i < inputs.length; i++) {
        values[inputs[i].name] = inputs[i].value;
    }
    return values;
}


export function isUserLoggedIn() {
    const token = getToken();
    if (token !== null) {
        let header = [];
        if (getRequest(apiUrl + 'is-user-logged-in', setTokenHeader(header))) {
            return true;
        }
        return false;
    } else {
        return false;
    }

}


export function showCountryPhones(obj) {
    let result = [];
    for (let p in obj) {
        if (obj.hasOwnProperty(p)) {
            let number = (obj[p].indexOf('+') > -1) ? obj[p] : '+' + obj[p];
            result.push(p + ' (' + number + ')');
        }
    }
    return result;
}


export function getRequest(url, header) {
    let xhttp = new XMLHttpRequest();
    xhttp.open('GET', url, false);
    if (header !== null) {
        header.map((h) => {
            xhttp.setRequestHeader(h.name, h.value);
        })
    }
    xhttp.send(null);
    return JSON.parse(xhttp.response);
}

export function setTokenHeader(actualHeader) {
    const token = localStorage.getItem('cft_usertoken');
    let header = {
        name: 'Authorization',
        value: 'Bearer ' + token
    }
    actualHeader.push(header);
    return actualHeader;
}

export function errorShowing(selector, element, errorText) {
    document.querySelector(selector).classList.add('active');
    document.querySelector(selector).classList.add('error');
    document.querySelector(element).classList.add('error');
    document.querySelector(selector).innerHTML = errorText;
    document.querySelector(element).addEventListener('change', (e) => {
        document.querySelector(selector).classList.remove('active');
        document.querySelector(selector).classList.remove('error');
        document.querySelector(element).classList.remove('error');
    });
}

export function successShowing(selector, element, successText) {
    document.querySelector(selector).classList.add('active');
    document.querySelector(selector).classList.add('success');
    document.querySelector(element).classList.add('success');
    document.querySelector(selector).innerHTML = successText;
    document.querySelector(element).addEventListener('change', (e) => {
        document.querySelector(selector).classList.remove('active');
        document.querySelector(selector).classList.remove('success');
        document.querySelector(element).classList.remove('success');
    });
}

export function resetFormInputs(form) {
    document.querySelectorAll(form + ' input').forEach((s) => {
        s.value = '';
    });
}

export function fadeIn(el, time) {
    el.style.opacity = 0;
    el.style.display = 'block';

    let last = +new Date();
    let tick = function () {
        el.style.opacity = +el.style.opacity + (new Date() - last) / time;
        last = +new Date();

        if (+el.style.opacity < 1) {
            (window.requestAnimationFrame && requestAnimationFrame(tick)) || setTimeout(tick, 16);
        }
    };

    tick();
}

export function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
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

export function setCookie(cname, cvalue, exdays) {
    let expires = "expires=Fri, 31 Dec 9999 23:59:59 GMT";
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

export function getToken() {
    return localStorage.getItem('cft_usertoken');
}

export function setToken(token) {
    // for async and sync call
    Promise.resolve()
        .then(() => {
            localStorage.removeItem('cft_usertoken');
            localStorage.setItem('cft_usertoken', token);
        });
}

export function parseJwt() {
    const token = getToken();
    let base64Url = token.split('.')[1];
    let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    let jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

export function makeOptionSelected(selectEl, value) {
    document.querySelectorAll(selectEl + ' option').forEach((el) => {
        if (el.value.indexOf('(' + value + ')') > -1) {
            el.selected = true;
        }
    })
}

export function setValueIfNotNull(element, value) {
    if (document.querySelector(element) !== null && value !== undefined) {
        return document.querySelector(element).value = value;
    }
    return null;
}

export function setCheckboxValue(element, checked) {
    if (document.querySelector(element) !== null && checked !== null) {
        return (checked) ? document.querySelector(element).checked = true : document.querySelector(element).checked = false;
    }
    return null;
}

export function scrollToElement(element, to, duration) {
    if (duration < 0) return;
    let difference = to - element.scrollTop;
    let perTick = difference / duration * 2;

    setTimeout(() => {
        element.scrollTop = element.scrollTop + perTick;
        scrollToElement(element, to, duration - 2);
    }, 10);
}

export function addSubmitFormHack(formSelector) {
    const submitButton = document.querySelector(formSelector + ' button[type="submit"]');
    submitButton.addEventListener('click', (clickEvent) => {
        const domEvent = document.createEvent('Event');
        domEvent.initEvent('submit', false, true);
        clickEvent.target.closest('form').dispatchEvent(domEvent);
    })
}

export function hideElementAfterTimeout(element, timeout) {
    setTimeout(() => {
        if (element.classList.contains('active')) {
            element.classList.remove('active');
        } else {
            element.style.display = 'none';
        }
    }, timeout);
}