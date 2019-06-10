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
    for(let key in jsonObj) {
        if(jsonObj.hasOwnProperty(key)) {
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

export const portalUrl = 'http://www.postoj.local:8000';
