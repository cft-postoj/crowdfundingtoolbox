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

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  IteratorPrototype[iteratorSymbol] = function () {
    return this;
  };

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = Gp.constructor = GeneratorFunctionPrototype;
  GeneratorFunctionPrototype.constructor = GeneratorFunction;
  GeneratorFunctionPrototype[toStringTagSymbol] =
    GeneratorFunction.displayName = "GeneratorFunction";

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      prototype[method] = function(arg) {
        return this._invoke(method, arg);
      };
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      if (!(toStringTagSymbol in genFun)) {
        genFun[toStringTagSymbol] = "GeneratorFunction";
      }
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return Promise.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return Promise.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new Promise(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  AsyncIterator.prototype[asyncIteratorSymbol] = function () {
    return this;
  };
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList) {
    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList)
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  Gp[toStringTagSymbol] = "Generator";

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  Gp[iteratorSymbol] = function() {
    return this;
  };

  Gp.toString = function() {
    return "[object Generator]";
  };

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : undefined
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  Function("r", "regeneratorRuntime = r")(runtime);
}


/***/ }),

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
/* harmony import */ var _crowdFundingMyAccount__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./crowdFundingMyAccount */ "./resources/js/crowdFundingMyAccount.js");



 // import './crowdFundingSetPassword';
// import './crowdFundingMyAccount';

/***/ }),

/***/ "./resources/js/constants/url.js":
/*!***************************************!*\
  !*** ./resources/js/constants/url.js ***!
  \***************************************/
/*! exports provided: apiUrl, viewsUrl, portalUrl */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "apiUrl", function() { return apiUrl; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "viewsUrl", function() { return viewsUrl; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "portalUrl", function() { return portalUrl; });
var apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API

var viewsUrl = 'http://127.0.0.1:8001/portal/';
var portalUrl = 'http://www.postoj.local:8000';

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
/* harmony import */ var _json_myAccount__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./json/myAccount */ "./resources/js/json/myAccount.json");
var _json_myAccount__WEBPACK_IMPORTED_MODULE_2___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./json/myAccount */ "./resources/js/json/myAccount.json", 1);
/* harmony import */ var _json_login__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./json/login */ "./resources/js/json/login.json");
var _json_login__WEBPACK_IMPORTED_MODULE_3___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./json/login */ "./resources/js/json/login.json", 1);
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./alert */ "./resources/js/alert.js");
//const apiUrl = 'https://crowdfunding.ondas.me/api/portal/';

var apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API



document.addEventListener('DOMContentLoaded', function () {
  fetchLoginTemplate();
});

function loginAction() {
  var form = document.querySelector('form[name="cft-login"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = {
      'email': document.querySelector('form[name="cft-login"] input[name="cft-email"]').value,
      'password': document.querySelector('form[name="cft-login"] input[name="cft-password"]').value
    };
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'login', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      if (xhttp.response.error) {
        switch (xhttp.response.type) {
          case 'email':
            Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["errorShowing"])('form[name="cft-login"] span.cft-email', 'form[name="cft-login"] input[name="cft-email"]', _json_login__WEBPACK_IMPORTED_MODULE_3__["incorrectEmail"]);
            break;

          case 'password':
            Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["errorShowing"])('form[name="cft-login"] span.cft-password', 'form[name="cft-login"] input[name="cft-password"]', _json_login__WEBPACK_IMPORTED_MODULE_3__["incorrectPassword"]);
            break;
        }
      }

      if (xhttp.response.token) {
        localStorage.setItem('cft_usertoken', xhttp.response.token);
        showMyAccount();
      }
    };

    xhttp.send(JSON.stringify(data));
  }); // code below is required for submitting

  var submitButton = document.querySelector('form[name="cft-login"] button[type="submit"]');
  submitButton.addEventListener('click', function (clickEvent) {
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

function forgotPasswordAction() {
  var form = document.querySelector('form[name="cft-forgottenPassword"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = {
      email: document.querySelector('form[name="cft-forgottenPassword"] input[name="cft-email"]').value
    };
    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'forgotten-password', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      // if there is some error
      if (xhttp.response.error) {
        Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["errorShowing"])('form[name="cft-forgottenPassword"] span.cft-email', 'form[name="cft-forgottenPassword"] input[name="cft-email"]', _json_login__WEBPACK_IMPORTED_MODULE_3__["incorrectEmail"]);
      } else {
        Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["successShowing"])('form[name="cft-forgottenPassword"] span.cft-email', 'form[name="cft-forgottenPassword"] input[name="cft-email"]', _json_login__WEBPACK_IMPORTED_MODULE_3__["successResetPassword"]);
        Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["resetFormInputs"])('form[name="cft-forgottenPassword"]');
      }
    };

    xhttp.send(JSON.stringify(data));
  }); // code below is required for submitting

  var submitButton = document.querySelector('form[name="cft-forgottenPassword"] button[type="submit"]');
  submitButton.addEventListener('click', function (clickEvent) {
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

function showMyAccount() {
  var button = document.getElementById('cft--loginButton');
  var loginDropdown = document.querySelector('.cft--loginDropdown');
  loginDropdown.classList.remove('active');
  button.innerHTML = _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["myAccountButton"];

  button.onclick = function () {
    if (location.href.indexOf(_json_myAccount__WEBPACK_IMPORTED_MODULE_2__["myAccountUrl"]) === -1) location.href = _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["myAccountUrl"];
  };
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
  var button = document.getElementById('cft--loginButton');

  if (Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["isUserLoggedIn"])() !== false) {
    button.innerHTML = _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["myAccountButton"];

    button.onclick = function () {
      if (location.href.indexOf(_json_myAccount__WEBPACK_IMPORTED_MODULE_2__["myAccountUrl"]) === -1) location.href = _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["myAccountUrl"];
    };
  } else {
    button.onclick = function (e) {
      e.preventDefault(); // TOGGLE LOGIN DROPDOWN

      document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.toggle('active');

      if (document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.contains('active')) {
        document.querySelector('body').onclick = function (e) {
          if (e.target.nodeName !== 'A') {
            e.preventDefault();
            if (e.target.classList.value.indexOf('cft--') === -1 && e.target.classList.value !== '' && e.target.nodeName !== 'INPUT' && e.target.nodeName !== 'SPAN') document.querySelector('#cft--loginButton + .cft--loginDropdown').classList.remove('active');
          }
        };
      }

      loginAction();
      showForgottenPassword();
    };
  }
}

function showForgottenPassword() {
  var button = document.getElementById('cft--forgottenPassword');
  var forgottenPasswordForm = document.querySelector('form[name="cft-forgottenPassword"]');
  var loginForm = document.querySelector('form[name="cft-login"]');
  button.addEventListener('click', function (e) {
    e.preventDefault();
    loginForm.style.display = 'none';
    Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["fadeIn"])(forgottenPasswordForm, 500);
  });
  forgotPasswordAction();
  showLogin();
}

function showLogin() {
  var button = document.getElementById('cft--showLogin');
  var forgottenPasswordForm = document.querySelector('form[name="cft-forgottenPassword"]');
  var loginForm = document.querySelector('form[name="cft-login"]');
  button.addEventListener('click', function (e) {
    e.preventDefault();
    forgottenPasswordForm.style.display = 'none';
    Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["fadeIn"])(loginForm, 500);
  });
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
/* harmony import */ var _constants_url__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./constants/url */ "./resources/js/constants/url.js");
/* harmony import */ var _json_myAccount__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./json/myAccount */ "./resources/js/json/myAccount.json");
var _json_myAccount__WEBPACK_IMPORTED_MODULE_2___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./json/myAccount */ "./resources/js/json/myAccount.json", 1);
/* harmony import */ var _json_countryPhone__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./json/countryPhone */ "./resources/js/json/countryPhone.json");
var _json_countryPhone__WEBPACK_IMPORTED_MODULE_3___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./json/countryPhone */ "./resources/js/json/countryPhone.json", 1);
/* harmony import */ var _json_countries__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./json/countries */ "./resources/js/json/countries.json");
var _json_countries__WEBPACK_IMPORTED_MODULE_4___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./json/countries */ "./resources/js/json/countries.json", 1);
/* harmony import */ var _alert__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./alert */ "./resources/js/alert.js");






document.addEventListener('DOMContentLoaded', function () {
  if (document.getElementById('cft--myaccount') !== null) {
    document.querySelector('footer').style.margin = 0;

    if (location.href.indexOf('?generatedResetToken') > -1) {
      isValidGeneratedToken(location.href.split('?generatedResetToken=')[1]);
    } else {
      if (Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["isUserLoggedIn"])() === false) {
        location.href = '/';
      } else {
        fetchMyAccountTemplate();
        setTimeout(function () {
          myAccountButton();
        }, 2000);
      }
    }
  }
});

function fetchMyAccountTemplate(message) {
  var url = _constants_url__WEBPACK_IMPORTED_MODULE_1__["viewsUrl"] + 'my-account';
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--myaccount').innerHTML = html, getSection(message), changeMyAccountView();
  });
}

function myAccountButton() {
  var button = document.getElementById('cft--loginButton');
  if (button != null) button.classList.add('active');
}

function getSection(message) {
  var splitter = location.href.split('#')[1];

  if (splitter.indexOf('?') > -1) {
    splitter = splitter.split('?')[0];
  }

  console.log(splitter);
  changeActiveMenu(splitter);

  switch (splitter) {
    case _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["newsletterSlug"]:
      sectionContent('newsletter');
      break;

    case _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["savedArticlesSlug"]:
      sectionContent('saved-articles');
      break;

    case _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["donationSlug"]:
      sectionContent('donation');
      break;

    case _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["ordersSlug"]:
      sectionContent('orders');
      break;

    case _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["accountSlug"]:
      sectionContent('account', message);
      break;

    default:
      sectionContent('preview');
      break;
  }
}

function sectionContent(section, message) {
  var url = _constants_url__WEBPACK_IMPORTED_MODULE_1__["viewsUrl"] + 'my-account/' + section;
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft-myAccount-body-section').innerHTML = html;

    if (section === 'account') {
      getCountryPhones(), getUserData(), getCountries(), logout(), addAlertMessage(message);
    }
  });
}

function changeActiveMenu(splitter) {
  var menuSlug = '#' + splitter;

  if (splitter == null || splitter == '') {
    menuSlug = '#';
  }

  document.querySelectorAll('.cft--myAccount--sidebar a').forEach(function (e) {
    e.parentElement.classList.remove('active');
  });
  document.querySelector('.cft--myAccount--sidebar a[href="' + menuSlug + '"]').parentElement.classList.add('active');
}

function changeMyAccountView() {
  document.querySelectorAll('.cft--myAccount--sidebar a').forEach(function (el) {
    el.addEventListener('click', function (e) {
      setTimeout(function () {
        getSection();
      }, 100);
    });
  });
}

function getCountryPhones() {
  var countryPhoneSelect = document.querySelector('select[name="cft-countryNumber"]');

  if (countryPhoneSelect !== null && _json_countryPhone__WEBPACK_IMPORTED_MODULE_3__ !== null) {
    Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["showCountryPhones"])(_json_countryPhone__WEBPACK_IMPORTED_MODULE_3__).forEach(function (option) {
      var el = document.createElement('option');
      el.value = option.split('(')[1].split(')')[0];
      el.text = option;

      if (option.indexOf('SK (+421') > -1) {
        el.selected = true;
      }

      countryPhoneSelect.appendChild(el);
    });
  }
}

function getCountries() {
  var countrySelect = document.querySelector('select[name="cft-country"]');

  if (countrySelect !== null) {
    _json_countries__WEBPACK_IMPORTED_MODULE_4__["map"](function (c) {
      var el = document.createElement('option');
      el.value = c.name;
      el.text = c.name;

      if (c.code === 'SK') {
        el.selected = true;
      }

      countrySelect.appendChild(el);
    });
  }
}

function logout() {
  var logoutButton = document.getElementById('cft--logout');
  logoutButton.addEventListener('click', function (e) {
    e.preventDefault();
    var header = [];

    if (Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["getRequest"])(_constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'logout', Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["setTokenHeader"])(header)).status === 'logout') {
      location.href = '/';
    }
  });
}

function getUserData() {
  var actualHeader = [];
  console.log(Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["getRequest"])(_constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'user-details', Object(_helpers__WEBPACK_IMPORTED_MODULE_0__["setTokenHeader"])(actualHeader)));
}

function isValidGeneratedToken(token) {
  var data = {
    generatedToken: token
  };
  var xhttp = new XMLHttpRequest();
  xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_1__["apiUrl"] + 'has-user-generated-token', true);
  xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
  xhttp.responseType = 'json';

  xhttp.onload = function () {
    if (xhttp.response != null) {
      localStorage.setItem('cft_usertoken', xhttp.response.token);
      fetchMyAccountTemplate('resetPassword');
    } else {
      showMyAccountNotValidView();
    }
  };

  xhttp.send(JSON.stringify(data));
}

function showMyAccountNotValidView() {
  // Bad request view
  var url = _constants_url__WEBPACK_IMPORTED_MODULE_1__["viewsUrl"] + 'my-account/bad-request';
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--myaccount').innerHTML = html;
  });
}

function addAlertMessage(message) {
  var alertElement = document.querySelector('#cft--myAccount .cft--alert');
  alertElement.classList.add('active');
  var resultText = '';

  switch (message) {
    case 'resetPassword':
      resultText = _json_myAccount__WEBPACK_IMPORTED_MODULE_2__["resetYourPasswordAlert"];
      break;
  }

  alertElement.innerHTML = resultText;
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
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./helpers */ "./resources/js/helpers.js");
/* harmony import */ var _constants_url__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./constants/url */ "./resources/js/constants/url.js");
/* harmony import */ var _json_register__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./json/register */ "./resources/js/json/register.json");
var _json_register__WEBPACK_IMPORTED_MODULE_3___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./json/register */ "./resources/js/json/register.json", 1);


function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }





document.addEventListener('DOMContentLoaded', function () {
  if (document.getElementById('cft--register') !== null) fetchRegisterTemplate();
});

function fetchRegisterTemplate() {
  var url = _constants_url__WEBPACK_IMPORTED_MODULE_2__["viewsUrl"] + 'register';
  console.log(url);
  fetch(url).then(function (response) {
    return response.text();
  }).then(function (html) {
    document.getElementById('cft--register').innerHTML = html, showPassword(), register();
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

function register() {
  var form = document.querySelector('form[name="cft-register"]');
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var data = {
      'email': document.querySelector('form[name="cft-register"] input[name="cft-email"]').value,
      'password': document.querySelector('form[name="cft-register"] input[name="cft-password"]').value,
      'agreeMailing': document.querySelector('form[name="cft-register"] input[name="cft-mailing"]').checked,
      'agreePersonalData': document.querySelector('form[name="cft-register"] input[name="cft-agree"]').checked
    };

    if (!data.agreePersonalData) {
      return Object(_helpers__WEBPACK_IMPORTED_MODULE_1__["errorShowing"])('form[name="cft-register"] span.cft-agree', 'form[name="cft-register"] input[name="cft-agree"]', _json_register__WEBPACK_IMPORTED_MODULE_3__["agreeConfirm"]);
    }

    var xhttp = new XMLHttpRequest();
    xhttp.open('POST', _constants_url__WEBPACK_IMPORTED_MODULE_2__["apiUrl"] + 'register', true);
    xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
    xhttp.responseType = 'json';

    xhttp.onload = function () {
      // if there is some error
      if (xhttp.response.error !== undefined) {
        switch (xhttp.response.error.type) {
          case 'email-registered':
            Object(_helpers__WEBPACK_IMPORTED_MODULE_1__["errorShowing"])('form[name="cft-register"] span.cft-email', 'form[name="cft-register"] input[name="cft-email"]', _json_register__WEBPACK_IMPORTED_MODULE_3__["emailExists"]);
            break;

          case 'email':
            Object(_helpers__WEBPACK_IMPORTED_MODULE_1__["errorShowing"])('form[name="cft-register"] span.cft-email', 'form[name="cft-register"] input[name="cft-email"]', _json_register__WEBPACK_IMPORTED_MODULE_3__["emailIncorrect"]);
            break;

          default:
            if (xhttp.response.password !== undefined) {
              Object(_helpers__WEBPACK_IMPORTED_MODULE_1__["errorShowing"])('form[name="cft-register"] span.cft-password', 'form[name="cft-register"] input[name="cft-password"]', _json_register__WEBPACK_IMPORTED_MODULE_3__["passwordIncorrect"]);
              break;
            }

            Object(_helpers__WEBPACK_IMPORTED_MODULE_1__["errorShowing"])('form[name="cft-register"] span.cft-agree', 'form[name="cft-register"] button[type="submit"]', _json_register__WEBPACK_IMPORTED_MODULE_3__["undefinedError"]);
            break;
        }
      } else {
        document.querySelectorAll('form[name="cft-register"] input').forEach(function (e) {
          e.value = '';
          e.checked = false;
        });
        document.querySelector('form[name="cft-register"] span.cft-register').classList.add('active');
        document.querySelector('form[name="cft-register"] span.cft-register').innerHTML = _json_register__WEBPACK_IMPORTED_MODULE_3__["registerSuccess"];
        setTimeout(
        /*#__PURE__*/
        _asyncToGenerator(
        /*#__PURE__*/
        _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
          var i;
          return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
            while (1) {
              switch (_context.prev = _context.next) {
                case 0:
                  i = 5;

                case 1:
                  if (!(i >= 0)) {
                    _context.next = 9;
                    break;
                  }

                  document.querySelector('form[name="cft-register"] span.cft-register #cft-seconds').innerHTML = i;

                  if (i === 0) {
                    window.location.href = _constants_url__WEBPACK_IMPORTED_MODULE_2__["default"];
                  }

                  _context.next = 6;
                  return sleep(1000);

                case 6:
                  i--;
                  _context.next = 1;
                  break;

                case 9:
                case "end":
                  return _context.stop();
              }
            }
          }, _callee);
        })), 500);
      }
    };

    return xhttp.send(JSON.stringify(data));
  }); // code below is required for submitting

  var submitButton = document.querySelector('form[name="cft-register"] button[type="submit"]');
  submitButton.addEventListener('click', function (clickEvent) {
    clickEvent.preventDefault();
    var domEvent = document.createEvent('Event');
    domEvent.initEvent('submit', false, true);
    clickEvent.target.closest('form').dispatchEvent(domEvent);
  });
}

function sleep(ms) {
  return new Promise(function (resolve) {
    return setTimeout(resolve, ms);
  });
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

function getWidgets(apiUrl) {
  var sidebarPlaceholder = document.getElementById('cr0wdFundingToolbox-sidebar');
  var fixedPlaceholder = document.getElementById('cr0wdFundingToolbox-fixed');
  var leaderboardPlaceholder = document.getElementById('cr0wdFundingToolbox-leaderboard'); //get widgets for users and track, that user has been on specific page

  data = JSON.stringify({
    'article_title': document.querySelector('title').innerText,
    'user_cookie': getCookie("cr0wdFundingToolbox-user_cookie"),
    'user_id': localStorage.getItem('cft_usertoken')
  });
  var xhttp = new XMLHttpRequest();
  xhttp.responseType = 'json';

  xhttp.onreadystatechange = function () {
    if (xhttp.readyState === XMLHttpRequest.DONE) {
      if (xhttp.response != null) {
        setCookie('cr0wdFundingToolbox-user_cookie', xhttp.response['user_cookie']);

        for (var i = 0; i < xhttp.response['widgets'].length; i++) {
          var el = xhttp.response['widgets'][i];
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

  xhttp.open('POST', apiUrl + 'widgets');
  xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
  xhttp.send(data);
}

function registerClick(apiUrl) {
  clickedDom = event.path[0];
  cftPlaceholders = document.querySelectorAll('[id^=cr0wdFundingToolbox]');
  cftPlaceholders.forEach(function (node) {
    node.addEventListener('click', function ($event) {
      localStorage.getItem('cr0wdFundingToolbox');
      clickedDom = event.path[0];
      var xhttp = new XMLHttpRequest();
      data = JSON.stringify({
        'node_id': clickedDom.id,
        'node_class': clickedDom.className,
        'show_id': node.closest('[id^=cr0wdFundingToolbox]').dataset.show_id
      });
      xhttp.open('POST', apiUrl + 'tracking/click', true);
      xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
      xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
      xhttp.responseType = 'json';
      xhttp.send(data);
    });
  });
}

function registerInsertValue(apiUrl) {
  cftPlaceholders = document.querySelectorAll('[class=cft--monatization--donation-button]');
  cftPlaceholders.forEach(function (node) {
    node.addEventListener('click', function ($event) {
      clickedDom = event.path[0];
      var xhttp = new XMLHttpRequest();
      data = JSON.stringify({
        'node_id': clickedDom.id,
        'node_class': clickedDom.className,
        'show_id': node.closest('[id^=cr0wdFundingToolbox]').dataset.show_id
      });
      xhttp.open('POST', apiUrl + 'tracking/click', true);
      xhttp.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('cft_usertoken'));
      xhttp.setRequestHeader('Content-type', 'application/json; charset=utf-8');
      xhttp.responseType = 'json';
      xhttp.send(data);
    });
  });
}

document.addEventListener('DOMContentLoaded', function () {
  //let apiUrl = 'https://crowdfunding.ondas.me/api/portal/';
  var apiUrl = 'http://127.0.0.1:8001/api/portal/'; // TEST API

  getWidgets(apiUrl);
  registerClick(apiUrl);
  registerInsertValue(apiUrl);
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

function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');

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

/***/ }),

/***/ "./resources/js/helpers.js":
/*!*********************************!*\
  !*** ./resources/js/helpers.js ***!
  \*********************************/
/*! exports provided: toggleClassLists, addClassLists, removeClassLists, getJsonFirstProp, removeFormData, findGetParameter, formSerialize, isUserLoggedIn, showCountryPhones, getRequest, setTokenHeader, errorShowing, successShowing, resetFormInputs, fadeIn */
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
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isUserLoggedIn", function() { return isUserLoggedIn; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "showCountryPhones", function() { return showCountryPhones; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getRequest", function() { return getRequest; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setTokenHeader", function() { return setTokenHeader; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "errorShowing", function() { return errorShowing; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "successShowing", function() { return successShowing; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resetFormInputs", function() { return resetFormInputs; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "fadeIn", function() { return fadeIn; });
/* harmony import */ var _constants_url__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./constants/url */ "./resources/js/constants/url.js");

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
function isUserLoggedIn() {
  var token = localStorage.getItem('cft_usertoken');

  if (token !== null) {
    var header = [];
    console.log(getRequest(_constants_url__WEBPACK_IMPORTED_MODULE_0__["apiUrl"] + 'is-user-logged-in', setTokenHeader(header)).isLoggedIn);

    if (getRequest(_constants_url__WEBPACK_IMPORTED_MODULE_0__["apiUrl"] + 'is-user-logged-in', setTokenHeader(header)).isLoggedIn === true) {
      return true;
    }

    return false;
  } else {
    return false;
  }
}
function showCountryPhones(obj) {
  var result = [];

  for (var p in obj) {
    if (obj.hasOwnProperty(p)) {
      var number = obj[p].indexOf('+') > -1 ? obj[p] : '+' + obj[p];
      result.push(p + ' (' + number + ')');
    }
  }

  return result;
}
function getRequest(url, header) {
  var xhttp = new XMLHttpRequest();
  xhttp.open('GET', url, false);

  if (header !== null) {
    header.map(function (h) {
      xhttp.setRequestHeader(h.name, h.value);
    });
  }

  xhttp.send(null);
  return JSON.parse(xhttp.response);
}
function setTokenHeader(actualHeader) {
  var token = localStorage.getItem('cft_usertoken');
  var header = {
    name: 'Authorization',
    value: 'Bearer ' + token
  };
  actualHeader.push(header);
  return actualHeader;
}
function errorShowing(selector, element, errorText) {
  document.querySelector(selector).classList.add('active');
  document.querySelector(selector).classList.add('error');
  document.querySelector(element).classList.add('error');
  document.querySelector(selector).innerHTML = errorText;
  document.querySelector(element).addEventListener('change', function (e) {
    document.querySelector(selector).classList.remove('active');
    document.querySelector(selector).classList.remove('error');
    document.querySelector(element).classList.remove('error');
  });
}
function successShowing(selector, element, successText) {
  document.querySelector(selector).classList.add('active');
  document.querySelector(selector).classList.add('success');
  document.querySelector(element).classList.add('success');
  document.querySelector(selector).innerHTML = successText;
  document.querySelector(element).addEventListener('change', function (e) {
    document.querySelector(selector).classList.remove('active');
    document.querySelector(selector).classList.remove('success');
    document.querySelector(element).classList.remove('success');
  });
}
function resetFormInputs(form) {
  document.querySelectorAll(form + ' input').forEach(function (s) {
    s.value = '';
  });
}
function fadeIn(el, time) {
  el.style.opacity = 0;
  el.style.display = 'block';
  var last = +new Date();

  var tick = function tick() {
    el.style.opacity = +el.style.opacity + (new Date() - last) / time;
    last = +new Date();

    if (+el.style.opacity < 1) {
      window.requestAnimationFrame && requestAnimationFrame(tick) || setTimeout(tick, 16);
    }
  };

  tick();
}

/***/ }),

/***/ "./resources/js/json/countries.json":
/*!******************************************!*\
  !*** ./resources/js/json/countries.json ***!
  \******************************************/
/*! exports provided: 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164, 165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225, 226, 227, 228, 229, 230, 231, 232, 233, 234, 235, 236, 237, 238, 239, 240, 241, 242, default */
/***/ (function(module) {

module.exports = [{"name":"Afghanistan","code":"AF"},{"name":"Åland Islands","code":"AX"},{"name":"Albania","code":"AL"},{"name":"Algeria","code":"DZ"},{"name":"American Samoa","code":"AS"},{"name":"AndorrA","code":"AD"},{"name":"Angola","code":"AO"},{"name":"Anguilla","code":"AI"},{"name":"Antarctica","code":"AQ"},{"name":"Antigua and Barbuda","code":"AG"},{"name":"Argentina","code":"AR"},{"name":"Armenia","code":"AM"},{"name":"Aruba","code":"AW"},{"name":"Australia","code":"AU"},{"name":"Austria","code":"AT"},{"name":"Azerbaijan","code":"AZ"},{"name":"Bahamas","code":"BS"},{"name":"Bahrain","code":"BH"},{"name":"Bangladesh","code":"BD"},{"name":"Barbados","code":"BB"},{"name":"Belarus","code":"BY"},{"name":"Belgium","code":"BE"},{"name":"Belize","code":"BZ"},{"name":"Benin","code":"BJ"},{"name":"Bermuda","code":"BM"},{"name":"Bhutan","code":"BT"},{"name":"Bolivia","code":"BO"},{"name":"Bosnia and Herzegovina","code":"BA"},{"name":"Botswana","code":"BW"},{"name":"Bouvet Island","code":"BV"},{"name":"Brazil","code":"BR"},{"name":"British Indian Ocean Territory","code":"IO"},{"name":"Brunei Darussalam","code":"BN"},{"name":"Bulgaria","code":"BG"},{"name":"Burkina Faso","code":"BF"},{"name":"Burundi","code":"BI"},{"name":"Cambodia","code":"KH"},{"name":"Cameroon","code":"CM"},{"name":"Canada","code":"CA"},{"name":"Cape Verde","code":"CV"},{"name":"Cayman Islands","code":"KY"},{"name":"Central African Republic","code":"CF"},{"name":"Chad","code":"TD"},{"name":"Chile","code":"CL"},{"name":"China","code":"CN"},{"name":"Christmas Island","code":"CX"},{"name":"Cocos (Keeling) Islands","code":"CC"},{"name":"Colombia","code":"CO"},{"name":"Comoros","code":"KM"},{"name":"Congo","code":"CG"},{"name":"Congo, The Democratic Republic of the","code":"CD"},{"name":"Cook Islands","code":"CK"},{"name":"Costa Rica","code":"CR"},{"name":"Cote D\"Ivoire","code":"CI"},{"name":"Croatia","code":"HR"},{"name":"Cuba","code":"CU"},{"name":"Cyprus","code":"CY"},{"name":"Czech Republic","code":"CZ"},{"name":"Denmark","code":"DK"},{"name":"Djibouti","code":"DJ"},{"name":"Dominica","code":"DM"},{"name":"Dominican Republic","code":"DO"},{"name":"Ecuador","code":"EC"},{"name":"Egypt","code":"EG"},{"name":"El Salvador","code":"SV"},{"name":"Equatorial Guinea","code":"GQ"},{"name":"Eritrea","code":"ER"},{"name":"Estonia","code":"EE"},{"name":"Ethiopia","code":"ET"},{"name":"Falkland Islands (Malvinas)","code":"FK"},{"name":"Faroe Islands","code":"FO"},{"name":"Fiji","code":"FJ"},{"name":"Finland","code":"FI"},{"name":"France","code":"FR"},{"name":"French Guiana","code":"GF"},{"name":"French Polynesia","code":"PF"},{"name":"French Southern Territories","code":"TF"},{"name":"Gabon","code":"GA"},{"name":"Gambia","code":"GM"},{"name":"Georgia","code":"GE"},{"name":"Germany","code":"DE"},{"name":"Ghana","code":"GH"},{"name":"Gibraltar","code":"GI"},{"name":"Greece","code":"GR"},{"name":"Greenland","code":"GL"},{"name":"Grenada","code":"GD"},{"name":"Guadeloupe","code":"GP"},{"name":"Guam","code":"GU"},{"name":"Guatemala","code":"GT"},{"name":"Guernsey","code":"GG"},{"name":"Guinea","code":"GN"},{"name":"Guinea-Bissau","code":"GW"},{"name":"Guyana","code":"GY"},{"name":"Haiti","code":"HT"},{"name":"Heard Island and Mcdonald Islands","code":"HM"},{"name":"Holy See (Vatican City State)","code":"VA"},{"name":"Honduras","code":"HN"},{"name":"Hong Kong","code":"HK"},{"name":"Hungary","code":"HU"},{"name":"Iceland","code":"IS"},{"name":"India","code":"IN"},{"name":"Indonesia","code":"ID"},{"name":"Iran, Islamic Republic Of","code":"IR"},{"name":"Iraq","code":"IQ"},{"name":"Ireland","code":"IE"},{"name":"Isle of Man","code":"IM"},{"name":"Israel","code":"IL"},{"name":"Italy","code":"IT"},{"name":"Jamaica","code":"JM"},{"name":"Japan","code":"JP"},{"name":"Jersey","code":"JE"},{"name":"Jordan","code":"JO"},{"name":"Kazakhstan","code":"KZ"},{"name":"Kenya","code":"KE"},{"name":"Kiribati","code":"KI"},{"name":"Korea, Democratic People\"S Republic of","code":"KP"},{"name":"Korea, Republic of","code":"KR"},{"name":"Kuwait","code":"KW"},{"name":"Kyrgyzstan","code":"KG"},{"name":"Lao People\"S Democratic Republic","code":"LA"},{"name":"Latvia","code":"LV"},{"name":"Lebanon","code":"LB"},{"name":"Lesotho","code":"LS"},{"name":"Liberia","code":"LR"},{"name":"Libyan Arab Jamahiriya","code":"LY"},{"name":"Liechtenstein","code":"LI"},{"name":"Lithuania","code":"LT"},{"name":"Luxembourg","code":"LU"},{"name":"Macao","code":"MO"},{"name":"Macedonia, The Former Yugoslav Republic of","code":"MK"},{"name":"Madagascar","code":"MG"},{"name":"Malawi","code":"MW"},{"name":"Malaysia","code":"MY"},{"name":"Maldives","code":"MV"},{"name":"Mali","code":"ML"},{"name":"Malta","code":"MT"},{"name":"Marshall Islands","code":"MH"},{"name":"Martinique","code":"MQ"},{"name":"Mauritania","code":"MR"},{"name":"Mauritius","code":"MU"},{"name":"Mayotte","code":"YT"},{"name":"Mexico","code":"MX"},{"name":"Micronesia, Federated States of","code":"FM"},{"name":"Moldova, Republic of","code":"MD"},{"name":"Monaco","code":"MC"},{"name":"Mongolia","code":"MN"},{"name":"Montserrat","code":"MS"},{"name":"Morocco","code":"MA"},{"name":"Mozambique","code":"MZ"},{"name":"Myanmar","code":"MM"},{"name":"Namibia","code":"NA"},{"name":"Nauru","code":"NR"},{"name":"Nepal","code":"NP"},{"name":"Netherlands","code":"NL"},{"name":"Netherlands Antilles","code":"AN"},{"name":"New Caledonia","code":"NC"},{"name":"New Zealand","code":"NZ"},{"name":"Nicaragua","code":"NI"},{"name":"Niger","code":"NE"},{"name":"Nigeria","code":"NG"},{"name":"Niue","code":"NU"},{"name":"Norfolk Island","code":"NF"},{"name":"Northern Mariana Islands","code":"MP"},{"name":"Norway","code":"NO"},{"name":"Oman","code":"OM"},{"name":"Pakistan","code":"PK"},{"name":"Palau","code":"PW"},{"name":"Palestinian Territory, Occupied","code":"PS"},{"name":"Panama","code":"PA"},{"name":"Papua New Guinea","code":"PG"},{"name":"Paraguay","code":"PY"},{"name":"Peru","code":"PE"},{"name":"Philippines","code":"PH"},{"name":"Pitcairn","code":"PN"},{"name":"Poland","code":"PL"},{"name":"Portugal","code":"PT"},{"name":"Puerto Rico","code":"PR"},{"name":"Qatar","code":"QA"},{"name":"Reunion","code":"RE"},{"name":"Romania","code":"RO"},{"name":"Russian Federation","code":"RU"},{"name":"RWANDA","code":"RW"},{"name":"Saint Helena","code":"SH"},{"name":"Saint Kitts and Nevis","code":"KN"},{"name":"Saint Lucia","code":"LC"},{"name":"Saint Pierre and Miquelon","code":"PM"},{"name":"Saint Vincent and the Grenadines","code":"VC"},{"name":"Samoa","code":"WS"},{"name":"San Marino","code":"SM"},{"name":"Sao Tome and Principe","code":"ST"},{"name":"Saudi Arabia","code":"SA"},{"name":"Senegal","code":"SN"},{"name":"Serbia and Montenegro","code":"CS"},{"name":"Seychelles","code":"SC"},{"name":"Sierra Leone","code":"SL"},{"name":"Singapore","code":"SG"},{"name":"Slovensko","code":"SK"},{"name":"Slovenia","code":"SI"},{"name":"Solomon Islands","code":"SB"},{"name":"Somalia","code":"SO"},{"name":"South Africa","code":"ZA"},{"name":"South Georgia and the South Sandwich Islands","code":"GS"},{"name":"Spain","code":"ES"},{"name":"Sri Lanka","code":"LK"},{"name":"Sudan","code":"SD"},{"name":"Suriname","code":"SR"},{"name":"Svalbard and Jan Mayen","code":"SJ"},{"name":"Swaziland","code":"SZ"},{"name":"Sweden","code":"SE"},{"name":"Switzerland","code":"CH"},{"name":"Syrian Arab Republic","code":"SY"},{"name":"Taiwan, Province of China","code":"TW"},{"name":"Tajikistan","code":"TJ"},{"name":"Tanzania, United Republic of","code":"TZ"},{"name":"Thailand","code":"TH"},{"name":"Timor-Leste","code":"TL"},{"name":"Togo","code":"TG"},{"name":"Tokelau","code":"TK"},{"name":"Tonga","code":"TO"},{"name":"Trinidad and Tobago","code":"TT"},{"name":"Tunisia","code":"TN"},{"name":"Turkey","code":"TR"},{"name":"Turkmenistan","code":"TM"},{"name":"Turks and Caicos Islands","code":"TC"},{"name":"Tuvalu","code":"TV"},{"name":"Uganda","code":"UG"},{"name":"Ukraine","code":"UA"},{"name":"United Arab Emirates","code":"AE"},{"name":"United Kingdom","code":"GB"},{"name":"United States","code":"US"},{"name":"United States Minor Outlying Islands","code":"UM"},{"name":"Uruguay","code":"UY"},{"name":"Uzbekistan","code":"UZ"},{"name":"Vanuatu","code":"VU"},{"name":"Venezuela","code":"VE"},{"name":"Viet Nam","code":"VN"},{"name":"Virgin Islands, British","code":"VG"},{"name":"Virgin Islands, U.S.","code":"VI"},{"name":"Wallis and Futuna","code":"WF"},{"name":"Western Sahara","code":"EH"},{"name":"Yemen","code":"YE"},{"name":"Zambia","code":"ZM"},{"name":"Zimbabwe","code":"ZW"}];

/***/ }),

/***/ "./resources/js/json/countryPhone.json":
/*!*********************************************!*\
  !*** ./resources/js/json/countryPhone.json ***!
  \*********************************************/
/*! exports provided: BD, BE, BF, BG, BA, BB, WF, BL, BM, BN, BO, BH, BI, BJ, BT, JM, BV, BW, WS, BQ, BR, BS, JE, BY, BZ, RU, RW, RS, TL, RE, TM, TJ, RO, TK, GW, GU, GT, GS, GR, GQ, GP, JP, GY, GG, GF, GE, GD, GB, GA, SV, GN, GM, GL, GI, GH, OM, TN, JO, HR, HT, HU, HK, HN, HM, VE, PR, PS, PW, PT, SJ, PY, IQ, PA, PF, PG, PE, PK, PH, PN, PL, PM, ZM, EH, EE, EG, ZA, EC, IT, VN, SB, ET, SO, ZW, SA, ES, ER, ME, MD, MG, MF, MA, MC, UZ, MM, ML, MO, MN, MH, MK, MU, MT, MW, MV, MQ, MP, MS, MR, IM, UG, TZ, MY, MX, IL, FR, IO, SH, FI, FJ, FK, FM, FO, NI, NL, NO, NA, VU, NC, NE, NF, NG, NZ, NP, NR, NU, CK, XK, CI, CH, CO, CN, CM, CL, CC, CA, CG, CF, CD, CZ, CY, CX, CR, CW, CV, CU, SZ, SY, SX, KG, KE, SS, SR, KI, KH, KN, KM, ST, SK, KR, SI, KP, KW, SN, SM, SL, SC, KZ, KY, SG, SE, SD, DO, DM, DJ, DK, VG, DE, YE, DZ, US, UY, YT, UM, LB, LC, LA, TV, TW, TT, TR, LK, LI, LV, TO, LT, LU, LR, LS, TH, TF, TG, TD, TC, LY, VA, VC, AE, AD, AG, AF, AI, VI, IS, IR, AM, AL, AO, AQ, AS, AR, AU, AT, AW, IN, AX, AZ, IE, ID, UA, QA, MZ, default */
/***/ (function(module) {

module.exports = {"BD":"880","BE":"32","BF":"226","BG":"359","BA":"387","BB":"+1-246","WF":"681","BL":"590","BM":"+1-441","BN":"673","BO":"591","BH":"973","BI":"257","BJ":"229","BT":"975","JM":"+1-876","BV":"","BW":"267","WS":"685","BQ":"599","BR":"55","BS":"+1-242","JE":"+44-1534","BY":"375","BZ":"501","RU":"7","RW":"250","RS":"381","TL":"670","RE":"262","TM":"993","TJ":"992","RO":"40","TK":"690","GW":"245","GU":"+1-671","GT":"502","GS":"","GR":"30","GQ":"240","GP":"590","JP":"81","GY":"592","GG":"+44-1481","GF":"594","GE":"995","GD":"+1-473","GB":"44","GA":"241","SV":"503","GN":"224","GM":"220","GL":"299","GI":"350","GH":"233","OM":"968","TN":"216","JO":"962","HR":"385","HT":"509","HU":"36","HK":"852","HN":"504","HM":" ","VE":"58","PR":"+1-787 and 1-939","PS":"970","PW":"680","PT":"351","SJ":"47","PY":"595","IQ":"964","PA":"507","PF":"689","PG":"675","PE":"51","PK":"92","PH":"63","PN":"870","PL":"48","PM":"508","ZM":"260","EH":"212","EE":"372","EG":"20","ZA":"27","EC":"593","IT":"39","VN":"84","SB":"677","ET":"251","SO":"252","ZW":"263","SA":"966","ES":"34","ER":"291","ME":"382","MD":"373","MG":"261","MF":"590","MA":"212","MC":"377","UZ":"998","MM":"95","ML":"223","MO":"853","MN":"976","MH":"692","MK":"389","MU":"230","MT":"356","MW":"265","MV":"960","MQ":"596","MP":"+1-670","MS":"+1-664","MR":"222","IM":"+44-1624","UG":"256","TZ":"255","MY":"60","MX":"52","IL":"972","FR":"33","IO":"246","SH":"290","FI":"358","FJ":"679","FK":"500","FM":"691","FO":"298","NI":"505","NL":"31","NO":"47","NA":"264","VU":"678","NC":"687","NE":"227","NF":"672","NG":"234","NZ":"64","NP":"977","NR":"674","NU":"683","CK":"682","XK":"","CI":"225","CH":"41","CO":"57","CN":"86","CM":"237","CL":"56","CC":"61","CA":"1","CG":"242","CF":"236","CD":"243","CZ":"420","CY":"357","CX":"61","CR":"506","CW":"599","CV":"238","CU":"53","SZ":"268","SY":"963","SX":"599","KG":"996","KE":"254","SS":"211","SR":"597","KI":"686","KH":"855","KN":"+1-869","KM":"269","ST":"239","SK":"421","KR":"82","SI":"386","KP":"850","KW":"965","SN":"221","SM":"378","SL":"232","SC":"248","KZ":"7","KY":"+1-345","SG":"65","SE":"46","SD":"249","DO":"+1-809 and 1-829","DM":"+1-767","DJ":"253","DK":"45","VG":"+1-284","DE":"49","YE":"967","DZ":"213","US":"1","UY":"598","YT":"262","UM":"1","LB":"961","LC":"+1-758","LA":"856","TV":"688","TW":"886","TT":"+1-868","TR":"90","LK":"94","LI":"423","LV":"371","TO":"676","LT":"370","LU":"352","LR":"231","LS":"266","TH":"66","TF":"","TG":"228","TD":"235","TC":"+1-649","LY":"218","VA":"379","VC":"+1-784","AE":"971","AD":"376","AG":"+1-268","AF":"93","AI":"+1-264","VI":"+1-340","IS":"354","IR":"98","AM":"374","AL":"355","AO":"244","AQ":"","AS":"+1-684","AR":"54","AU":"61","AT":"43","AW":"297","IN":"91","AX":"+358-18","AZ":"994","IE":"353","ID":"62","UA":"380","QA":"974","MZ":"258"};

/***/ }),

/***/ "./resources/js/json/login.json":
/*!**************************************!*\
  !*** ./resources/js/json/login.json ***!
  \**************************************/
/*! exports provided: incorrectEmail, incorrectPassword, successResetPassword, default */
/***/ (function(module) {

module.exports = {"incorrectEmail":"Nesprávny e-mail. Nemáte ešte registráciu?<br/><a href='http://registracia.postoj.local:8000'>Registrujte sa</a>","incorrectPassword":"Nesprávne heslo.","successResetPassword":"Link s možnosťou zmeniť heslo bol zaslaný na Vašu e-mailovú adresu."};

/***/ }),

/***/ "./resources/js/json/myAccount.json":
/*!******************************************!*\
  !*** ./resources/js/json/myAccount.json ***!
  \******************************************/
/*! exports provided: myAccountButton, myAccountUrl, previewSlug, newsletterSlug, savedArticlesSlug, donationSlug, ordersSlug, accountSlug, resetYourPasswordAlert, default */
/***/ (function(module) {

module.exports = {"myAccountButton":"Môj účet","myAccountUrl":"/moj-ucet","previewSlug":"prehlad","newsletterSlug":"newsletter","savedArticlesSlug":"ulozene-clanky","donationSlug":"vasa-podpora","ordersSlug":"objednavky","accountSlug":"ucet","resetYourPasswordAlert":"Prosím, resetujte si svoje heslo."};

/***/ }),

/***/ "./resources/js/json/register.json":
/*!*****************************************!*\
  !*** ./resources/js/json/register.json ***!
  \*****************************************/
/*! exports provided: emailExists, emailIncorrect, passwordIncorrect, agreeConfirm, undefinedError, registerSuccess, default */
/***/ (function(module) {

module.exports = {"emailExists":"Zadaný email existuje, prosím <a href='/'>Prihláste sa</a>.","emailIncorrect":"Prosím, zadajte e-mail v správnom tvare.","passwordIncorrect":"Heslo musí obsahovať aspoň 6 znakov.","agreeConfirm":"Pre pokračovanie musíte súhlasiť so spracovaním osobných údajov.","undefinedError":"Počas registrácie nastala neočakávaná chyba. Skúste znova alebo kontaktujte administrátora.","registerSuccess":"Registrácia prebehla úspešne. Na Vašu emailovú adresu bola zaslaná rekapitulácia registrácie.<br />O <span id='cft-seconds'>5</span> sekúnd prebehne presmerovanie na hlavnú stránku, kde sa môžete prihlásiť."};

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

__webpack_require__(/*! C:\xampp\htdocs\crowdfundingToolbox\resources\js\app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! C:\xampp\htdocs\crowdfundingToolbox\resources\sass\app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });