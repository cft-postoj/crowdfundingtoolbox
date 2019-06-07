/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/alert.js":
/*!*******************************!*\
  !*** ./resources/js/alert.js ***!
  \*******************************/
/*! exports provided: successAlert, errorAlert */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "successAlert", function() { return successAlert; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "errorAlert", function() { return errorAlert; });
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");

function successAlert(text) {
  console.log('this');
  var element = document.querySelector('.cft--alert');
  element.innerText = text;
  var classes = ['success', 'active'];
  var removeClassses = classes.toString();
  removeClassses += ',error';
  Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["toggleClassLists"])(classes, removeClassses, element);

  document.querySelector('.cft--alert').onclick = function () {
    Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["toggleClassLists"])(classes, element);
  };

  Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["removeFormData"])('form');
}
function errorAlert(text) {
  console.log('this2');
  var element = document.querySelector('.cft--alert');
  element.innerText = text;
  var classes = ['error', 'active'];
  var removeClassses = classes.toString();
  removeClassses += ',success';
  Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["toggleClassLists"])(classes, removeClassses, element);

  document.querySelector('.cft--alert').onclick = function () {
    Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["toggleClassLists"])(classes, element);
  };
}

/***/ }),

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _crowdFundingToolbox__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./crowdFundingToolbox */ "./resources/js/crowdFundingToolbox.js");
/* harmony import */ var _crowdFundingLogin__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./crowdFundingLogin */ "./resources/js/crowdFundingLogin.js");
/* harmony import */ var _crowdFundingRegister__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./crowdFundingRegister */ "./resources/js/crowdFundingRegister.js");


 // import './crowdFundingSetPassword';
// import './crowdFundingMyAccount';

/***/ }),

/***/ "./resources/js/constants/url.js":
/*!***************************************!*\
  !*** ./resources/js/constants/url.js ***!
  \***************************************/
/*! exports provided: apiUrl, viewsUrl */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "apiUrl", function() { return apiUrl; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "viewsUrl", function() { return viewsUrl; });
var apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API

var viewsUrl = 'http://127.0.0.1:8001/portal/';

/***/ }),

/***/ "./resources/js/crowdFundingLogin.js":
/*!*******************************************!*\
  !*** ./resources/js/crowdFundingLogin.js ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");
/* harmony import */ var _constants_url__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./constants/url */ "./resources/js/constants/url.js");
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./alert */ "./resources/js/alert.js");
//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';



document.addEventListener('DOMContentLoaded', function () {
  fetchLoginTemplate();
});

function loginAction() {
  var form = document.querySelector('form[name="cftLogin--login--form"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = JSON.stringify(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["formSerialize"])(form));
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'login', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      if (xhttp.response.token) {
        localStorage.setItem('cft_usertoken', xhttp.response.token);
        showMyAccount();
      }
    };

    xhttp.send(data);
  }); // code below is required for submitting

  var submitButton = document.querySelector('form[name="cftLogin--login--form"] button[type="submit"]');
  submitButton.addEventListener('click', function (clickEvent) {
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

function registerAction() {
  var form = document.querySelector('form[name="cftLogin--register--form"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = JSON.stringify(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["formSerialize"])(form));
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'register', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      // if there is some error
      if (xhttp.response.error) {
        Object(_alert__WEBPACK_IMPORTED_MODULE_2__["errorAlert"])(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["getJsonFirstProp"])(xhttp.response.error));
      } else {
        Object(_alert__WEBPACK_IMPORTED_MODULE_2__["successAlert"])(xhttp.response.message);
      }
    };

    xhttp.send(data);
  }); // code below is required for submitting

  var submitButton = document.querySelector('form[name="cftLogin--register--form"] button[type="submit"]');
  submitButton.addEventListener('click', function (clickEvent) {
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

function forgotPasswordAction() {
  var form = document.querySelector('form[name="cftLogin--forgotPassword--form"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = JSON.stringify(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["formSerialize"])(form));
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'forgotPassword', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      // if there is some error
      if (xhttp.response.error) {
        Object(_alert__WEBPACK_IMPORTED_MODULE_2__["errorAlert"])(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["getJsonFirstProp"])(xhttp.response.error));
      } else {
        if (xhttp.status === 200) {
          Object(_alert__WEBPACK_IMPORTED_MODULE_2__["successAlert"])(xhttp.response.message);
        } else {
          Object(_alert__WEBPACK_IMPORTED_MODULE_2__["errorAlert"])(xhttp.response.message);
        }
      }
    };

    xhttp.send(data);
  }); // code below is required for submitting

  var submitButton = document.querySelector('form[name="cftLogin--forgotPassword--form"] button[type="submit"]');
  submitButton.addEventListener('click', function (clickEvent) {
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

function showMyAccount() {
  document.getElementById('cft--loginButton').style.display = 'none';
  setTimeout(function () {
    document.getElementById('cft--myAccountButton').style.display = 'block';
    document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
  }, 500);
}

function fetchLoginTemplate() {
  var url = _constants_url__WEBPACK_IMPORTED_MODULE_1__["viewsUrl"] + 'login';
  console.log(url);
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--login').innerHTML = html;
    loginFunctions();
  });
}

function loginFunctions() {
  document.getElementById('cft--loginButton').onclick = function (e) {
    e.preventDefault(); //loginAction();
    // TOGGLE LOGIN DROPDOWN

    document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.toggle('active');

    if (document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.contains('active')) {
      document.querySelector('body').onclick = function (e) {
        if (e.target.nodeName !== 'A') {
          e.preventDefault();
          if (e.target.classList.value.indexOf('cft--') === -1 && e.target.classList.value !== '' && e.target.nodeName !== 'INPUT' && e.target.nodeName !== 'SPAN') document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.remove('active');
        }
      };
    } // document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
    // document.querySelector('.cftLogin--cftLoginWrapper').onclick = function (e) {
    //     e.preventDefault();
    //     if (e.target.className === 'cftLogin--cftLoginWrapper active')
    //         document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
    // };
    // SHOW REGISTER
    // document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
    //     e.preventDefault();
    //     registerAction();
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
    // };
    // SHOW LOGIN
    // document.querySelector('.cftLogin--cftLoginWrapper--content--register .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
    //     e.preventDefault();
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
    // };
    // SHOW FORGOT PASSWORD
    // document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button.forgotPassword').onclick = function (e) {
    //     e.preventDefault();
    //     forgotPasswordAction();
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'block';
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword .cftLogin--cftLoginWrapper--content--button.login').onclick = function (e) {
    //         document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'none';
    //         document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
    //     };
    //     document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword .cftLogin--cftLoginWrapper--content--button.register').onclick = function (e) {
    //         document.querySelector('.cftLogin--cftLoginWrapper--content--forgotPassword').style.display = 'none';
    //         document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
    //     };
    // };

  };
}

/***/ }),

/***/ "./resources/js/crowdFundingRegister.js":
/*!**********************************************!*\
  !*** ./resources/js/crowdFundingRegister.js ***!
  \**********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");
/* harmony import */ var _constants_url__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./constants/url */ "./resources/js/constants/url.js");


document.addEventListener('DOMContentLoaded', function () {
  if (document.getElementById('cft--register') !== null) fetchRegisterTemplate();
});

function fetchRegisterTemplate() {
  var url = _constants_url__WEBPACK_IMPORTED_MODULE_1__["viewsUrl"] + 'register';
  console.log(url);
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--register').innerHTML = html, showPassword();
  });
}

function showPassword() {
  document.querySelector('input#cft-password + img').onclick = function (e) {
    if (document.querySelector('input#cft-password').getAttribute('type') === 'password') {
      document.querySelector('input#cft-password').setAttribute('type', 'text');
    } else {
      document.querySelector('input#cft-password').setAttribute('type', 'password');
    }
  };
}

/***/ }),

/***/ "./resources/js/crowdFundingToolbox.js":
/*!*********************************************!*\
  !*** ./resources/js/crowdFundingToolbox.js ***!
  \*********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _constants_url__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants/url */ "./resources/js/constants/url.js");

document.addEventListener('DOMContentLoaded', function () {
  var sidebarPlaceholder = document.getElementById('cr0wdFundingToolbox-sidebar');
  var fixedPlaceholder = document.getElementById('cr0wdFundingToolbox-fixed');
  var leaderboardPlaceholder = document.getElementById('cr0wdFundingToolbox-leaderboard');
  var xhttp = new XMLHttpRequest();
  xhttp.responseType = 'json';

  xhttp.onreadystatechange = function () {
    if (xhttp.readyState === XMLHttpRequest.DONE) {
      if (xhttp.response != null) {
        for (var i = 0; i < xhttp.response.length; i++) {
          var el = xhttp.response[i];
          console.log(el);

          switch (el.widget_type.method) {
            case 'sidebar':
              sidebarPlaceholder != null && (sidebarPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
              break;

            case 'leaderboard':
              leaderboardPlaceholder != null && (leaderboardPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
              break;

            case 'fixed':
              fixedPlaceholder != null && (fixedPlaceholder.innerHTML = el.response[cr0wdGetDeviceType()]);
              break;

            default:
              break;
          }
        }
      }
    }
  };

  xhttp.open('GET', _constants_url__WEBPACK_IMPORTED_MODULE_0__["apiUrl"] + 'widgets');
  xhttp.send();
});

function cr0wdGetDeviceType() {
  var device = '';

  if (window.innerWidth < 768) {
    device = 'mobile';
  } else if (window.innerWidth > 767 && window.innerWidth < 1200) {
    device = 'tablet';
  } else {
    device = 'desktop';
  }

  return device;
}

/***/ }),

/***/ "./resources/js/helpers.js":
/*!*********************************!*\
  !*** ./resources/js/helpers.js ***!
  \*********************************/
/*! exports provided: toggleClassLists, addClassLists, removeClassLists, getJsonFirstProp, removeFormData, findGetParameter, formSerialize */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggleClassLists", function() { return toggleClassLists; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addClassLists", function() { return addClassLists; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "removeClassLists", function() { return removeClassLists; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getJsonFirstProp", function() { return getJsonFirstProp; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "removeFormData", function() { return removeFormData; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "findGetParameter", function() { return findGetParameter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "formSerialize", function() { return formSerialize; });
function toggleClassLists(array, remove, el) {
  removeClassLists(remove, el);
  setTimeout(function () {
    array.forEach(function (item, index) {
      el.classList.toggle(item);
    });
  }, 50);
}
function addClassLists(array, el) {
  array.forEach(function (item, index) {
    el.classList.add(item);
  });
}
function removeClassLists(classes, el) {
  el.classList.remove(classes);
}
function getJsonFirstProp(jsonObj) {
  var firstProp;

  for (var key in jsonObj) {
    if (jsonObj.hasOwnProperty(key)) {
      firstProp = jsonObj[key];
      break;
    }
  }

  return firstProp;
}
function removeFormData(formElement) {
  document.querySelectorAll(formElement + ' input').forEach(function (el, index) {
    el.value = '';
  });
  document.querySelectorAll(formElement + ' textarea').forEach(function (el, index) {
    el.value = '';
  });
}
function findGetParameter(parameterName) {
  var result = null,
      tmp = [];
  location.search.substr(1).split("&").forEach(function (item) {
    tmp = item.split("=");
    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
  });
  return result;
}
function formSerialize(formElement) {
  var values = {};
  var inputs = formElement.elements;

  for (var i = 0; i < inputs.length; i++) {
    values[inputs[i].name] = inputs[i].value;
  }

  return values;
}

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! D:\PROJECTS\LOCAL\htdocs\crowdfundingToolbox\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! D:\PROJECTS\LOCAL\htdocs\crowdfundingToolbox\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });