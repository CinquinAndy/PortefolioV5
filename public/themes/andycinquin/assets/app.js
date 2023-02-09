/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _shaders_vertexShader_glsl__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./shaders/vertexShader.glsl */ "./resources/js/shaders/vertexShader.glsl");
/* harmony import */ var _shaders_vertexShader_glsl__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_shaders_vertexShader_glsl__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _shaders_fragmentShader_glsl__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./shaders/fragmentShader.glsl */ "./resources/js/shaders/fragmentShader.glsl");
/* harmony import */ var _shaders_fragmentShader_glsl__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_shaders_fragmentShader_glsl__WEBPACK_IMPORTED_MODULE_1__);
function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, "prototype", { writable: false }); return Constructor; }



var scrollable = document.querySelector('.scrollable');
var current = 0;
var target = 0;
var ease = 0.075; // Linear inetepolation used for smooth scrolling and image offset uniform adjustment

function lerp(start, end, t) {
  return start * (1 - t) + end * t;
} // init function triggered on page load to set the body height to enable scrolling and EffectCanvas initialised


function init() {
  document.body.style.height = "".concat(scrollable.getBoundingClientRect().height, "px");
} // translate the scrollable div using the lerp function for the smooth scrolling effect.


function smoothScroll() {
  target = window.scrollY;
  current = lerp(current, target, ease);
  scrollable.style.transform = "translate3d(0,".concat(-current, "px, 0)");
}

var EffectCanvas = /*#__PURE__*/function () {
  function EffectCanvas() {
    _classCallCheck(this, EffectCanvas);

    this.container = document.querySelector('main');
    this.images = _toConsumableArray(document.querySelectorAll('.images-three'));
    this.meshItems = []; // Used to store all meshes we will be creating.

    this.setupCamera();
    this.createMeshItems();
    this.render();
  } // Getter function used to get screen dimensions used for the camera and mesh materials


  _createClass(EffectCanvas, [{
    key: "viewport",
    get: function get() {
      var width = window.innerWidth;
      var height = window.innerHeight;
      var aspectRatio = width / height;
      return {
        width: width,
        height: height,
        aspectRatio: aspectRatio
      };
    }
  }, {
    key: "setupCamera",
    value: function setupCamera() {
      window.addEventListener('resize', this.onWindowResize.bind(this), false); // Create new scene

      this.scene = new THREE.Scene(); // Initialize perspective camera

      var perspective = 1000;
      var fov = 180 * (2 * Math.atan(window.innerHeight / 2 / perspective)) / Math.PI; // see fov image for a picture breakdown of this fov setting.

      this.camera = new THREE.PerspectiveCamera(fov, this.viewport.aspectRatio, 1, 1000);
      this.camera.position.set(0, 0, perspective); // set the camera position on the z axis.

      this.renderer = new THREE.WebGL1Renderer({
        antialias: true,
        alpha: true
      });
      this.renderer.setSize(this.viewport.width, this.viewport.height); // uses the getter viewport function above to set size of canvas / renderer

      this.renderer.setPixelRatio(window.devicePixelRatio); // Import to ensure image textures do not appear blurred.

      this.container.appendChild(this.renderer.domElement); // append the canvas to the main element
    }
  }, {
    key: "onWindowResize",
    value: function onWindowResize() {
      init();
      this.camera.aspect = this.viewport.aspectRatio; // readjust the aspect ratio.

      this.camera.updateProjectionMatrix(); // Used to recalulate projectin dimensions.

      this.renderer.setSize(this.viewport.width, this.viewport.height);
    }
  }, {
    key: "createMeshItems",
    value: function createMeshItems() {
      var _this = this;

      // Loop thorugh all images and create new MeshItem instances. Push these instances to the meshItems array.
      this.images.forEach(function (image) {
        var meshItem = new MeshItem(image, _this.scene);

        _this.meshItems.push(meshItem);
      });
    } // Animate smoothscroll and meshes. Repeatedly called using requestanimationdrame

  }, {
    key: "render",
    value: function render() {
      smoothScroll();

      for (var i = 0; i < this.meshItems.length; i++) {
        this.meshItems[i].render();
      }

      this.renderer.render(this.scene, this.camera);
      requestAnimationFrame(this.render.bind(this));
    }
  }]);

  return EffectCanvas;
}();

var MeshItem = /*#__PURE__*/function () {
  // Pass in the scene as we will be adding meshes to this scene.
  function MeshItem(element, scene) {
    _classCallCheck(this, MeshItem);

    this.element = element;
    this.scene = scene;
    this.offset = new THREE.Vector2(0, 0); // Positions of mesh on screen. Will be updated below.

    this.sizes = new THREE.Vector2(0, 0); //Size of mesh on screen. Will be updated below.

    this.createMesh();
  }

  _createClass(MeshItem, [{
    key: "getDimensions",
    value: function getDimensions() {
      var _this$element$getBoun = this.element.getBoundingClientRect(),
          width = _this$element$getBoun.width,
          height = _this$element$getBoun.height,
          top = _this$element$getBoun.top,
          left = _this$element$getBoun.left;

      this.sizes.set(width, height);
      this.offset.set(left - window.innerWidth / 2 + width / 2, -top + window.innerHeight / 2 - height / 2);
    }
  }, {
    key: "createMesh",
    value: function createMesh() {
      this.geometry = new THREE.PlaneBufferGeometry(1, 1, 100, 100);
      this.imageTexture = new THREE.TextureLoader().load(this.element.src);
      this.uniforms = {
        uTexture: {
          //texture data
          value: this.imageTexture
        },
        uOffset: {
          //distortion strength
          value: new THREE.Vector2(0.0, 0.0)
        },
        uAlpha: {
          //opacity
          value: 1.
        }
      };
      this.material = new THREE.ShaderMaterial({
        uniforms: this.uniforms,
        vertexShader: (_shaders_vertexShader_glsl__WEBPACK_IMPORTED_MODULE_0___default()),
        fragmentShader: (_shaders_fragmentShader_glsl__WEBPACK_IMPORTED_MODULE_1___default()),
        transparent: true,
        // wireframe: true,
        side: THREE.DoubleSide
      });
      this.mesh = new THREE.Mesh(this.geometry, this.material);
      this.getDimensions(); // set offsetand sizes for placement on the scene

      this.mesh.position.set(this.offset.x, this.offset.y, 0);
      this.mesh.scale.set(this.sizes.x, this.sizes.y, 1);
      this.scene.add(this.mesh);
    }
  }, {
    key: "render",
    value: function render() {
      // this function is repeatidly called for each instance in the aboce
      this.getDimensions();
      this.mesh.position.set(this.offset.x, this.offset.y, 0);
      this.mesh.scale.set(this.sizes.x, this.sizes.y, 1);
      this.uniforms.uOffset.value.set(this.offset.x * 0.1, -(target - current) * 0.0003);
    }
  }]);

  return MeshItem;
}();

function renderCall() {
  if (window.screen.width > 1440) {
    init();
    new EffectCanvas();
  }
}

window.addEventListener('resize', function () {
  renderCall();
});
renderCall();

/***/ }),

/***/ "./resources/js/shaders/fragmentShader.glsl":
/*!**************************************************!*\
  !*** ./resources/js/shaders/fragmentShader.glsl ***!
  \**************************************************/
/***/ (function(module) {

module.exports = "uniform sampler2D uTexture;\nuniform float uAlpha;\nuniform vec2 uOffset;\nvarying vec2 vUv;\nvec3 rgbShift(sampler2D textureImage, vec2 uv, vec2 offset) {\n\tfloat r = texture2D(textureImage, uv + offset).r;\n\tvec2 gb = texture2D(textureImage, uv).gb;\n\treturn vec3(r, gb);\n}\nvoid main() {\n\tvec3 color = rgbShift(uTexture, vUv, uOffset);\n\tgl_FragColor = vec4(color, uAlpha);\n}\n"

/***/ }),

/***/ "./resources/js/shaders/vertexShader.glsl":
/*!************************************************!*\
  !*** ./resources/js/shaders/vertexShader.glsl ***!
  \************************************************/
/***/ (function(module) {

module.exports = "uniform sampler2D uTexture;\nuniform vec2 uOffset;\nvarying vec2 vUv;\n#define M_PI 3.1415926535897932384626433832795\nvec3 deformationCurve(vec3 position, vec2 uv, vec2 offset) {\n\tposition.x = position.x + (sin(uv.y * M_PI) * offset.x);\n\tposition.y = position.y + (sin(uv.x * M_PI) * offset.y);\n\treturn position;\n}\nvoid main() {\n\tvUv = uv;\n\tvec3 newPosition = deformationCurve(position, uv, uOffset);\n\tgl_Position = (projectionMatrix * modelViewMatrix) * vec4(newPosition, 1.0);\n}\n"

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/app": 0,
/******/ 			"app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunk"] = self["webpackChunk"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["app"], function() { return __webpack_require__("./resources/js/app.js"); })
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["app"], function() { return __webpack_require__("./resources/sass/app.scss"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;