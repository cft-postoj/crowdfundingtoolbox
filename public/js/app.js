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
/* harmony import */ var _crowdFundingLogin__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_crowdFundingLogin__WEBPACK_IMPORTED_MODULE_1__);



/***/ }),

/***/ "./resources/js/crowdFundingLogin.js":
/*!*******************************************!*\
  !*** ./resources/js/crowdFundingLogin.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('cft--loginButton').onclick = function (e) {
    e.preventDefault();
    document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');

    document.querySelector('.cftLogin--cftLoginWrapper').onclick = function (e) {
      e.preventDefault();
      if (e.target.className === 'cftLogin--cftLoginWrapper active') document.querySelector('.cftLogin--cftLoginWrapper').classList.toggle('active');
    }; // SHOW REGISTER


    document.querySelector('.cftLogin--cftLoginWrapper--content--login .cftLogin--cftLoginWrapper--content--button').onclick = function (e) {
      e.preventDefault();
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
});

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

__webpack_require__(/*! D:\PROJECTS\xampp2\htdocs\POSTOJ - CFT\crowdfundingToolbox\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! D:\PROJECTS\xampp2\htdocs\POSTOJ - CFT\crowdfundingToolbox\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });