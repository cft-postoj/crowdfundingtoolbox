import {toggleClassLists, addClassLists, removeClassLists, removeFormData} from "./helpers";

export function successAlert(text) {
    console.log('this')
    let element = document.querySelector('.cft--alert');
    element.innerText = text;
    let classes = ['success', 'active'];
    let removeClassses = classes.toString();
    removeClassses += ',error';
    toggleClassLists(classes, removeClassses, element);
    document.querySelector('.cft--alert').onclick = () => {
        toggleClassLists(classes, element);
    };
    removeFormData('form');
}

export function errorAlert(text) {
    console.log('this2')
    let element = document.querySelector('.cft--alert');
    element.innerText = text;
    let classes = ['error', 'active'];
    let removeClassses = classes.toString();
    removeClassses += ',success';
    toggleClassLists(classes, removeClassses, element);
    document.querySelector('.cft--alert').onclick = () => {
        toggleClassLists(classes, element);
    };
}
