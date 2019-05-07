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
/* harmony import */ var _crowdFundingToolbox__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_crowdFundingToolbox__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _crowdFundingLogin__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./crowdFundingLogin */ "./resources/js/crowdFundingLogin.js");
/* harmony import */ var _crowdFundingSetPassword__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./crowdFundingSetPassword */ "./resources/js/crowdFundingSetPassword.js");
/* harmony import */ var _crowdFundingMyAccount__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./crowdFundingMyAccount */ "./resources/js/crowdFundingMyAccount.js");





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
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./alert */ "./resources/js/alert.js");
//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';

var apiUrl = 'http://localhost/crowdfundingToolbox/public/api/portal/'; // TEST API

var viewsUrl = 'http://localhost/crowdfundingToolbox/public/portal/';

document.addEventListener('DOMContentLoaded', function () {
  fetchLoginTemplate();
});

function loginAction() {
  var form = document.querySelector('form[name="cftLogin--login--form"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = JSON.stringify(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["formSerialize"])(form));
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', apiUrl + 'login', true);
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
    xhttp.open('POST', apiUrl + 'register', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      // if there is some error
      if (xhttp.response.error) {
        Object(_alert__WEBPACK_IMPORTED_MODULE_1__["errorAlert"])(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["getJsonFirstProp"])(xhttp.response.error));
      } else {
        Object(_alert__WEBPACK_IMPORTED_MODULE_1__["successAlert"])(xhttp.response.message);
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
    xhttp.open('POST', apiUrl + 'forgotPassword', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      // if there is some error
      if (xhttp.response.error) {
        Object(_alert__WEBPACK_IMPORTED_MODULE_1__["errorAlert"])(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["getJsonFirstProp"])(xhttp.response.error));
      } else {
        if (xhttp.status === 200) {
          Object(_alert__WEBPACK_IMPORTED_MODULE_1__["successAlert"])(xhttp.response.message);
        } else {
          Object(_alert__WEBPACK_IMPORTED_MODULE_1__["errorAlert"])(xhttp.response.message);
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
  var url = viewsUrl + 'login';
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--login').innerHTML = html;
    loginFunctions();
  });
}

function loginFunctions() {
  document.getElementById('cft--loginButton').onclick = function (e) {
    e.preventDefault();
    loginAction();
    document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');

    document.querySelector('.cftLogin--cftLoginWrapper').onclick = function (e) {
      e.preventDefault();
      if (e.target.className === 'cftLogin--cftLoginWrapper active') document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
    }; // SHOW REGISTER


    document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
      e.preventDefault();
      registerAction();
      document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'none';
      document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'block';
    }; // SHOW LOGIN


    document.querySelector('.cftLogin--cftLoginWrapper--content--register .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
      e.preventDefault();
      document.querySelector('.cftLogin--cftLoginWrapper--content--register').style.display = 'none';
      document.querySelector('.cftLogin--cftLoginWrapper--content--login').style.display = 'block';
    }; // SHOW FORGOT PASSWORD


    document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button.forgotPassword').onclick = function (e) {
      e.preventDefault();
      forgotPasswordAction();
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
}

/***/ }),

/***/ "./resources/js/crowdFundingMyAccount.js":
/*!***********************************************!*\
  !*** ./resources/js/crowdFundingMyAccount.js ***!
  \***********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./alert */ "./resources/js/alert.js");

var apiUrl = 'http://localhost/crowdfundingToolbox/public/api/portal/'; // TEST API

var viewsUrl = 'http://localhost/crowdfundingToolbox/public/portal/';

document.addEventListener('DOMContentLoaded', function () {
  // TODO if user is logged in and has valid token
  fetchMyAccountTemplate();
});

function fetchMyAccountTemplate() {
  var url = viewsUrl + 'my-account-content';
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--myAccountContent').innerHTML = html;
    showProfileActions();
  });
}

function showProfileActions() {
  var allSections = document.querySelectorAll('.cft--myAccount--body--section');
  var showCftNewslettersSection = document.getElementById('showCftNewslettersSection');
  var showCftSavedArticlesSection = document.getElementById('showCftSavedArticlesSection');
  var showCftDonationSection = document.getElementById('showCftDonationSection');
  var showCftMyProfileSection = document.getElementById('showCftMyProfileSection');
  var showCftMyOrdersSection = document.getElementById('showCftMyOrdersSection');
  var bodyIntro = document.querySelector('.cft--myAccount--body--intro');
  var newslettersContent = document.getElementById('cft--myAccount--newsletters');
  var savedArticlesContent = document.getElementById('cft--myAccount--savedArticles');
  var donationContent = document.getElementById('cft--myAccount--donation');
  var myProfileContent = document.getElementById('cft--myAccount--myProfile');
  var myOrdersContent = document.getElementById('cft--myAccount--myOrders');

  showCftNewslettersSection.onclick = function (clickEvent) {
    clickEvent.preventDefault();
    showHelper(newslettersContent);
  };

  showCftSavedArticlesSection.onclick = function (clickEvent) {
    clickEvent.preventDefault();
    showHelper(savedArticlesContent);
  };

  showCftDonationSection.onclick = function (clickEvent) {
    clickEvent.preventDefault();
    showHelper(donationContent);
  };

  showCftMyProfileSection.onclick = function (clickEvent) {
    clickEvent.preventDefault();
    showHelper(myProfileContent);
  };

  showCftMyOrdersSection.onclick = function (clickEvent) {
    clickEvent.preventDefault();
    showHelper(myOrdersContent);
  };

  function showHelper(content) {
    bodyIntro.style.display = 'none';
    allSections.forEach(function (s, key) {
      s.classList.remove('active');
    });

    if (!content.classList.contains('active')) {
      content.classList.add('active');
    }
  }
}

/***/ }),

/***/ "./resources/js/crowdFundingSetPassword.js":
/*!*************************************************!*\
  !*** ./resources/js/crowdFundingSetPassword.js ***!
  \*************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./alert */ "./resources/js/alert.js");
//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';


var apiUrl = 'http://localhost/crowdfundingToolbox/public/api/portal/'; // TEST API

var viewsUrl = 'http://localhost/crowdfundingToolbox/public/portal/';
document.addEventListener('DOMContentLoaded', function () {
  if (window.location.href.indexOf('?setPassword=') > -1) {
    isUserExist();
  }
});

function isUserExist() {
  var data = {
    'token': Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["findGetParameter"])('setPassword')
  };
  var xhttp = new XMLHttpRequest();
  xhttp.open('POST', apiUrl + 'has-user-generated-token', true);
  xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
  xhttp.responseType = 'json';

  xhttp.onload = function () {
    if (xhttp.response.isUserExists) {
      return showSetPasswordTemplate();
    }
  };

  xhttp.send(JSON.stringify(data));
}

function showSetPasswordTemplate() {
  var url = viewsUrl + 'set-generated-password';
  console.log('view');
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--login').innerHTML = html;
    document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');

    document.querySelector('.cftLogin--cftLoginWrapper').onclick = function (e) {
      e.preventDefault();
      if (e.target.className === 'cftLogin--cftLoginWrapper active') document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
      document.querySelector('input[name="token"]').value = Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["findGetParameter"])('setPassword');
      resetPasswordAction();
    };
  });
}

function resetPasswordAction() {
  var form = document.querySelector('form[name="cftLogin--changePassword--form"]');
  var submitButton = document.querySelector('form[name="cftLogin--changePassword--form"] button[type="submit"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    console.log('submitted');
    var data = JSON.stringify(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["formSerialize"])(form));
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', apiUrl + 'change-password', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onerror = function () {
      console.log('error');
    };

    xhttp.onsuccess = function () {
      console.log('success');
    }; // xhttp.onload = () => {
    //     if (xhttp.response.error) {
    //         errorAlert(getJsonFirstProp(xhttp.response.error));
    //         submitButton.innerText = 'Submit';
    //         submitButton.disabled = '';
    //     }
    //     xhttp.onreadystatechange = () => {
    //         if (xhttp.readyState === 4) {
    //             if (xhttp.status === 200) {
    //                 console.log(xhttp.response)
    //                 localStorage.setItem('cft_usertoken', xhttp.response.token);
    //             } else {
    //                 console.log('failed');
    //             }
    //         }
    //     }
    // };


    xhttp.send(data);
  }, false); // code below is required for submitting

  submitButton.addEventListener('click', function (clickEvent) {
    clickEvent.preventDefault();
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

/***/ }),

/***/ "./resources/js/crowdFundingToolbox.js":
/*!*********************************************!*\
  !*** ./resources/js/crowdFundingToolbox.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function () {
  //let apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
  var apiUrl = 'http://127.0.0.1:8000/api/portal/'; // TEST API

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

  xhttp.open('GET', apiUrl + 'widgets');
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

__webpack_require__(/*! /opt/lampp/htdocs/crowdfundingToolbox/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /opt/lampp/htdocs/crowdfundingToolbox/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });