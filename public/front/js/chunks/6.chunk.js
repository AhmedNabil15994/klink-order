(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[6],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=script&lang=js&":
/*!**************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      loading: false,
      ordeers: this.orders
    };
  },
  computed: {
    userId: function userId() {
      if (this.$auth.isAuth) {
        return 'user';
      } else {
        if (localStorage.getItem('tempid')) {
          return localStorage.getItem('tempid');
        } else {
          return 'new';
        }
      }
    }
  },
  mounted: function mounted() {
    this.$genF.svg();
  },
  props: ['orders'],
  watch: {
    'orders': function orders(newval) {
      var _this = this;

      this.loading = true;
      this.$nextTick(function () {
        _this.loading = false;
        _this.ordeers = _this.orders;

        _this.$nextTick(function () {
          if (_this.$refs.carsouel) {
            _this.$refs.carsouel.goSlide(newval.length - 1);

            _this.$genF.svg();
          }
        });
      });
    }
  },
  methods: {
    slideChange: function slideChange(e) {
      this.$emit('slide-change', e);
    },
    activateOrder: function activateOrder(slide) {
      this.$orders.setActiveOrder(slide.id);
      this.$emit('activateOrder', slide.id);
    },
    deleteOrder: function deleteOrder(order) {
      var _this2 = this;

      var vm = this;
      $('.deleteImage').tooltip('hide');
      Vue.orders.removeOrder(order).then(function (response) {
        // Vue.orders = response;
        $('.deleteImage').tooltip('hide');
        _this2.loading = true;
        _this2.ordeers = response;

        _this2.$nextTick(function () {
          $('.deleteImage').tooltip('hide');
          _this2.loading = false;
        });
      }); // this.$swal({
      //     type: 'question',
      //     title: '',
      //     text: trans('front.main.deleteConfirm'),
      //     showCancelButton: true,
      //     cancelButtonColor: '#d33',
      //     cancelButtonText: trans('front.main.cancel'),
      //     confirmButtonText: trans('front.main.deleteIt'),
      //     onOpen() {
      //         $('.swal2-icon.swal2-question').html('<img src="/images/question.svg"/>');
      //     }
      // }).then(result => {
      //     if (result.value === true) {
      //         this.$swal({
      //             text: trans('front.main.deleting'),
      //             onOpen() {
      //                 Vue.swal.showLoading();
      //             }
      //         })
      //     }
      // })
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      loading: false,
      ordeers: this.orders
    };
  },
  computed: {},
  props: {
    'orders': {
      required: true
    }
  },
  methods: {},
  created: function created() {},
  mounted: function mounted() {
    var _this = this;

    this.$nextTick(function () {
      _this.$genF.svg();
    });
  },
  watch: {
    'orders': function orders(newval) {
      var _this2 = this;

      this.loading = true;
      this.$nextTick(function () {
        _this2.loading = false;
        _this2.ordeers = _this2.orders;
        console.log(_this2.ordeers);

        _this2.$nextTick(function () {
          if (_this2.$refs.othercarsouel) {
            _this2.$genF.svg();

            _this2.$refs.othercarsouel.goSlide(newval.length - 1);
          }
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/mainPage.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/pages/mainPage.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_slick__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-slick */ "./node_modules/vue-slick/dist/slickCarousel.esm.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      slickOptions: {
        arrows: false,
        autoplay: true // Any other options that can be got from plugin documentation

      },
      fromFocused: false,
      toFocused: false,
      loading: false,
      activatedOrder: false,
      activatedOrderId: {},
      activatedOrderIndex: '',
      otherOrders: '',
      from: {
        adress: '',
        marker: {
          lat: 51.165691,
          lng: 10.451526
        },
        icon: 'images/home.svg'
      },
      to: {
        adress: '',
        marker: {
          lat: 51.165691,
          lng: 10.451526
        },
        icon: 'images/send.svg'
      },
      allOrders: this.$orders.getOrders(),
      isChecked: false,
      tempRouteResult: {}
    };
  },
  components: {
    'app-orders': __webpack_require__(/*! ./main/AppOrders.vue */ "./resources/assets/js/components/pages/main/AppOrders.vue"),
    'app-other-orders': __webpack_require__(/*! ./main/AppOtherOrders.vue */ "./resources/assets/js/components/pages/main/AppOtherOrders.vue"),
    Slick: vue_slick__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  mounted: function mounted() {
    var _this = this;

    $('#FromGeoAdress').focus(function () {
      _this.fromFocused = true;
    });
    $('#FromGeoAdress').blur(function () {
      _this.fromFocused = false;
    });
    $('#ToGeoAdress').focus(function () {
      _this.toFocused = true;
    });
    $('#ToGeoAdress').blur(function () {
      _this.toFocused = false;
    });
    this.$genF.svg();
    $('[data-toggle="tooltip"]').tooltip();
    $('.deleteImage').tooltip();
    $('.fullSize').tooltip();
    $('#FromGeoAdress').change(function () {
      _this.setFromPlace({});
    });
    $('#ToGeoAdress').change(function () {
      _this.setToPlace({});
    });
    this.getOrders();
  },
  computed: {
    isThereLocation: function isThereLocation() {
      if (window.navigator && window.navigator.geolocation) {
        return true;
      }

      return false;
    }
  },
  methods: {
    focused: function focused(type) {
      alert(type);
    },
    slideChange: function slideChange(e) {
      if (this.activatedOrder) {
        this.changeActiveOrder(this.allOrders[e].id);
      }
    },
    getOrders: function getOrders() {
      var _this2 = this;

      this.$http.get('/api/orders/other').then(function (response) {
        if (response.body && response.body[1] === 'adv') {
          if (!_this2.allOrders || _this2.allOrders.length === 0) {
            _this2.otherOrders = response.body[0];
          }
        } else if (response.body && response.body[1] === 'owner') {
          _this2.allOrders = _this2.allOrders.concat(response.body[0].map(function (e) {
            e.id = e.encrypted;
            return e;
          }));
        }
      });
    },
    isNumeric: function isNumeric(n) {
      return !isNaN(parseFloat(n)) && isFinite(n);
    },
    getLocationToFrom: function getLocationToFrom() {
      var _this3 = this;

      navigator.geolocation.getCurrentPosition(function (myposition) {
        _this3.from.marker = {
          lat: myposition.coords.latitude,
          lng: myposition.coords.longitude
        };
        var geocoder = new google.maps.Geocoder();
        var latlng = {
          lat: Number(myposition.coords.latitude),
          lng: Number(myposition.coords.longitude)
        };
        geocoder.geocode({
          'location': latlng
        }, function (results, status) {
          if (status === 'OK') {
            if (results[0]) {
              _this3.from.icon = '';
              $('#FromGeoAdress').val(results[0].formatted_address); // alert(results[1].formatted_address);

              _this3.from.adress = results[0].formatted_address;

              _this3.$nextTick(function () {
                _this3.from.icon = '/images/checked.svg';
              });

              if (_this3.activatedOrder) {
                _this3.ShowRoute();
              }
            } else {
              alert('No results found');
            }
          }
        });
      }, function (error) {
        _this3.$swal({
          title: error.message,
          text: error.message,
          type: "error",
          confirmButtonText: trans('front.main.ok'),
          onOpen: function onOpen() {
            $('.swal2-icon.swal2-error').html('');
            $('.swal2-icon.swal2-error').html('<img src="/images/warming.svg"/>');
          }
        });
      }, {
        maximumAge: 600000,
        timeout: 5000,
        enableHighAccuracy: true
      });
    },
    changeActiveOrder: function changeActiveOrder(id) {
      var _this4 = this;

      this.activatedOrder = true;
      this.$orders.getOrder(id).then(function (response) {
        _this4.activatedOrderId = response;
        $('#FromGeoAdress').val(_this4.activatedOrderId.from);
        $('#ToGeoAdress').val(_this4.activatedOrderId.to);
        _this4.from.adress = response.from;
        _this4.to.adress = response.to;
        _this4.from.marker = _this4.getMarker(response.from_map);
        _this4.to.marker = _this4.getMarker(response.to_map);
        var directionsService = new window.google.maps.DirectionsService();

        if (_this4.directionsDisplay) {
          _this4.directionsDisplay.setDirections({
            routes: []
          });

          _this4.directionsDisplay = null;
        }

        _this4.directionsDisplay = new window.google.maps.DirectionsRenderer({
          suppressMarkers: true
        });

        _this4.directionsDisplay.setMap(null);

        _this4.directionsDisplay.setMap(_this4.$refs.map.$mapObject);

        _this4.directionsDisplay.setDirections(response.orderRoute);
      });
    },
    getMarker: function getMarker(text) {
      return {
        lat: Number(text.split(',')[0]),
        lng: Number(text.split(',')[1])
      };
    },
    ShowRoute: function ShowRoute() {
      var _this5 = this;

      var directionsService = new window.google.maps.DirectionsService();

      if (this.directionsDisplay) {
        this.directionsDisplay.setDirections({
          routes: []
        });
        this.directionsDisplay = null;
      }

      this.directionsDisplay = new window.google.maps.DirectionsRenderer({
        suppressMarkers: true
      });
      this.directionsDisplay.setMap(null);
      this.directionsDisplay.setMap(this.$refs.map.$mapObject);
      var start = new window.google.maps.LatLng(this.from.marker.lat, this.from.marker.lng);
      var end = new window.google.maps.LatLng(this.to.marker.lat, this.to.marker.lng);
      var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode['DRIVING']
      };
      directionsService.route(request, function (result, status) {
        if (status == 'OK') {
          _this5.tempRouteResult = result;
          _this5.activatedOrderId.orderRoute = result;

          _this5.directionsDisplay.setDirections(result);

          var data = {
            from: _this5.from.adress,
            to: _this5.to.adress,
            from_map: _this5.from.marker.lat + ',' + _this5.from.marker.lng,
            to_map: _this5.to.marker.lat + ',' + _this5.to.marker.lng,
            orderRoute: _this5.tempRouteResult
          };

          if (!_this5.activatedOrderIndex || _this5.allOrders[_this5.activatedOrderIndex].id !== _this5.activatedOrderId.id) {
            _this5.allOrders.map(function (element, index) {
              if (element.id === _this5.activatedOrderId.id) {
                _this5.activatedOrderIndex = index;
              }
            });
          }

          for (var key in data) {
            _this5.allOrders[_this5.activatedOrderIndex][key] = data[key];
          }

          _this5.$orders.updateOrder(_this5.activatedOrderId.id, data);
        }
      });
    },
    check: function check(e) {
      var _this6 = this;

      this.loading = true;
      var data = {
        from: this.from.adress,
        to: this.to.adress,
        from_map: this.from.marker.lat + ',' + this.from.marker.lng,
        to_map: this.to.marker.lat + ',' + this.to.marker.lng,
        userId: this.$orders.OrdersUserId()
      };
      this.orderValidate(data).then(function (response) {
        _this6.gotto();
      }, function (error) {
        _this6.gotto(); // this.loading = false;

      });
      return true;
    },
    orderValidate: function orderValidate(NewOrder) {
      var result = false;

      if (NewOrder.from && NewOrder.to && NewOrder.from_map && NewOrder.to_map && NewOrder.from_map !== NewOrder.to_map) {
        result = true;
      }

      return new Promise(function (resolve, reject) {
        if (result) {
          // if (this.$orders.IsFound(NewOrder)) {
          //     return reject({
          //         title: trans('front.main.repeatedOrder'),
          //         text: trans('front.main.repeatedOrderText')
          //     })
          // }
          return resolve(result);
        } else {
          return reject({
            title: trans('front.main.wrongData'),
            text: trans('front.main.wrongDataMessage')
          });
        }
      });
    },
    validateFromPlace: function validateFromPlace() {
      var _this7 = this;

      if (this.from.marker.lat && this.from.marker.lng && this.from.adress && $('#FromGeoAdress').val()) {
        this.from.icon = '';
        this.$nextTick(function () {
          _this7.from.icon = '/images/checked.svg';
        });
      } else {
        this.from.icon = '';
        this.$nextTick(function () {
          _this7.from.icon = '/images/warning.svg';
        });
      }
    },
    validateToPlace: function validateToPlace() {
      var _this8 = this;

      if (this.to.marker.lat && this.to.marker.lng && this.to.adress && $('#ToGeoAdress').val()) {
        this.to.icon = '';
        this.$nextTick(function () {
          _this8.to.icon = '/images/checked.svg';
        });
      } else {
        this.to.icon = '';
        this.$nextTick(function () {
          _this8.to.icon = '/images/warning.svg';
        });
      }
    },
    validatePlace: function validatePlace(place) {
      if (!place || !place.address_components) {
        return false;
      }

      var HasStreetArray = place.address_components.some(function (component) {
        return component.types.indexOf('street_number') !== -1;
      });

      if (!HasStreetArray) {
        this.$snotify.warning(trans('front.main.placeError'), trans('front.main.placeErrorHead'), {
          timeout: 3500,
          // showProgressBar:false,
          pauseOnHover: true
        });
      }

      return HasStreetArray;
    },
    setFromPlace: function setFromPlace(place) {
      this.from.adress = place.formatted_address;

      if (!place.geometry || !this.validatePlace(place)) {
        this.from.marker = {
          lat: '',
          lng: ''
        };
        this.validateFromPlace();
        return '';
      } else {
        $('#ToGeoAdress').focus();
        this.from.marker = {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng()
        };
      }

      if (this.activatedOrder) {
        this.ShowRoute();
      } else if (this.from.adress && this.from.marker && this.to.marker && this.from.marker.lat && this.from.marker.lng && this.to.adress && this.to.marker.lng && this.to.marker.lat) {
        this.check();
      }

      this.validateFromPlace();
    },
    setToPlace: function setToPlace(place) {
      var _this9 = this;

      this.to.adress = place.formatted_address;

      if (!place.geometry || !this.validatePlace(place)) {
        this.to.marker = {
          lat: '',
          lng: ''
        };
        this.validateToPlace();
        return '';
      } else {
        $('#SubmitFormButton').focus();
        this.to.marker = {
          lat: place.geometry.location.lat(),
          lng: place.geometry.location.lng()
        };
      }

      this.validateToPlace();

      if (this.activatedOrder) {
        this.ShowRoute();
      } else if (this.from.adress && this.from.marker.lat && this.from.marker.lng && this.to.adress && this.to.marker.lng && this.to.marker.lat) {
        this.check();
      }

      this.$nextTick(function () {
        _this9.saveNewOrder();
      });
    },
    setFromPlaceViaMarker: function setFromPlaceViaMarker(event) {
      var _this10 = this;

      this.from.marker = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng()
      };
      var geocoder = new google.maps.Geocoder();
      var latlng = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng()
      };
      geocoder.geocode({
        'location': latlng
      }, function (results, status) {
        if (status === 'OK') {
          if (results[1]) {
            $('#FromGeoAdress').val(results[1].formatted_address); // alert(results[1].formatted_address);

            _this10.from.adress = results[1].formatted_address;

            if (_this10.activatedOrder) {
              _this10.ShowRoute();
            }
          } else {
            alert('No results found');
          }
        }
      });
    },
    setToPlaceViaMarker: function setToPlaceViaMarker(event) {
      var _this11 = this;

      this.to.marker = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng() // this.gotto()

      };
      var geocoder = new google.maps.Geocoder();
      var latlng = {
        lat: event.latLng.lat(),
        lng: event.latLng.lng()
      };
      geocoder.geocode({
        'location': latlng
      }, function (results, status) {
        if (status === 'OK') {
          if (results[1]) {
            $('#ToGeoAdress').val(results[1].formatted_address);
            _this11.to.adress = results[1].formatted_address;

            if (_this11.activatedOrder) {
              _this11.ShowRoute();
            } // alert(results[1].formatted_address);

          } else {
            alert('No results found');
          }
        }
      });
    },
    gotto: function gotto() {
      var _this12 = this;

      var save = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var directionsService = new window.google.maps.DirectionsService();

      if (this.directionsDisplay) {
        this.directionsDisplay.setDirections({
          routes: []
        });
        this.directionsDisplay = null;
      }

      this.directionsDisplay = new window.google.maps.DirectionsRenderer({
        suppressMarkers: true
      });
      this.directionsDisplay.setMap(null);
      this.directionsDisplay.setMap(this.$refs.map.$mapObject);
      var start = new window.google.maps.LatLng(this.from.marker.lat, this.from.marker.lng);
      var end = new window.google.maps.LatLng(this.to.marker.lat, this.to.marker.lng);
      var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode['DRIVING']
      };
      directionsService.route(request, function (result, status) {
        if (status == 'OK') {
          _this12.tempRouteResult = result;
          var data = {
            from: _this12.from.adress,
            to: _this12.to.adress,
            from_map: _this12.from.marker.lat + ',' + _this12.from.marker.lng,
            to_map: _this12.to.marker.lat + ',' + _this12.to.marker.lng,
            orderRoute: _this12.tempRouteResult
          };

          if (save === true) {
            _this12.$orders.NewOrder(data).then(function (response) {
              _this12.allOrders = response;
              _this12.isChecked = true;
              _this12.tempRouteResult = {}; // this.changeActiveOrder(response[response.length - 1].id);

              _this12.$nextTick(function () {
                _this12.loading = false;

                _this12.$router.push('/order/create_order/' + response[response.length - 1].id);
              });
            });
          }

          _this12.directionsDisplay.setDirections(result);

          _this12.loading = false;
        }
      });
    },
    saveNewOrder: function saveNewOrder() {
      var _this13 = this;

      this.loading = true;
      var data = {
        from: this.from.adress,
        to: this.to.adress,
        from_map: this.from.marker.lat + ',' + this.from.marker.lng,
        to_map: this.to.marker.lat + ',' + this.to.marker.lng,
        orderRoute: this.tempRouteResult
      };
      this.orderValidate(data).then(function (result) {
        _this13.gotto(true);
      }, function (error) {
        if (!_this13.from.marker || !_this13.from.adress || !_this13.from.marker.lat || !_this13.from.marker.lng) {
          _this13.from.icon = '';

          _this13.$nextTick(function () {
            _this13.from.icon = '/images/warning.svg';
          });
        }

        if (!_this13.to.marker || !_this13.to.adress || !_this13.to.marker.lat || !_this13.to.marker.lng) {
          _this13.to.icon = '';

          _this13.$nextTick(function () {
            _this13.to.icon = '/images/warning.svg';
          });
        }

        _this13.loading = false;
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=template&id=0386ae32&":
/*!******************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=template&id=0386ae32& ***!
  \******************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "fade" } }, [
    !_vm.loading
      ? _c(
          "div",
          { staticClass: "orders-small-wrapper" },
          [
            _c(
              "carousel-3d",
              {
                ref: "carsouel",
                attrs: { "controls-visible": true, height: 200, width: 300 },
                on: { "before-slide-change": _vm.slideChange }
              },
              _vm._l(_vm.ordeers, function(slide, i) {
                return _c("slide", { key: "slide" + i, attrs: { index: i } }, [
                  _c("div", { staticClass: "small-order" }, [
                    _c("img", {
                      staticClass: "deleteImage",
                      attrs: {
                        src: "/images/delete-order.svg",
                        title: _vm.trans("front.main.delete"),
                        alt: _vm.trans("front.main.delete")
                      },
                      on: {
                        click: function($event) {
                          return _vm.deleteOrder(slide)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("img", {
                      staticClass: "fullSize",
                      attrs: {
                        src: "/images/full-size.svg",
                        title: _vm.trans("front.main.fullSize"),
                        alt: _vm.trans("front.main.fullSize")
                      },
                      on: {
                        click: function($event) {
                          return _vm.activateOrder(slide)
                        }
                      }
                    }),
                    _vm._v(" "),
                    _c("div", { staticClass: "small-order-cell order-from" }, [
                      _c("img", {
                        staticClass: "svg",
                        attrs: {
                          src: "/images/home.svg",
                          alt: "From",
                          title: _vm.trans("front.main.from"),
                          "data-toggle": "tooltip"
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "small-order-cell-adress" }, [
                        _c("b", [_vm._v(_vm._s(_vm.trans("front.main.from")))]),
                        _c("span", [_vm._v(" : " + _vm._s(slide.from))])
                      ])
                    ]),
                    _vm._v(" "),
                    _c("div", { staticClass: "small-order-cell order-to" }, [
                      _c("img", {
                        staticClass: "svg",
                        attrs: {
                          src: "/images/send.svg",
                          alt: _vm.trans("front.main.to"),
                          title: _vm.trans("front.main.to"),
                          "data-toggle": "tooltip"
                        }
                      }),
                      _vm._v(" "),
                      _c("span", { staticClass: "small-order-cell-adress" }, [
                        _c("b", [_vm._v(_vm._s(_vm.trans("front.main.to")))]),
                        _c("span", [_vm._v(" : " + _vm._s(slide.to))])
                      ])
                    ]),
                    _vm._v(" "),
                    _c(
                      "div",
                      { staticClass: "small-order-cell completeIt" },
                      [
                        _c(
                          "router-link",
                          {
                            staticClass: "letsComplete btn",
                            attrs: {
                              tag: "button",
                              to: _vm.$auth.isAuth()
                                ? "/order/create_order/" + slide.id
                                : "/order/create_order/" + slide.id
                            }
                          },
                          [_vm._v(_vm._s(_vm.trans("front.main.letsComplete")))]
                        )
                      ],
                      1
                    ),
                    _vm._v(" "),
                    _c("img", {
                      staticClass: "warning-order",
                      attrs: { src: "/images/warning.svg", alt: "warning" }
                    })
                  ])
                ])
              }),
              1
            )
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=template&id=f269efd0&":
/*!***********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=template&id=f269efd0& ***!
  \***********************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("transition", { attrs: { name: "fade" } }, [
    !_vm.loading
      ? _c(
          "div",
          { staticClass: "orders-small-wrapper" },
          [
            _c(
              "carousel-3d",
              {
                ref: "othercarsouel",
                attrs: {
                  autoplay: true,
                  dir: "ltr",
                  "autoplay-timeout": 5000,
                  "controls-visible": true,
                  height: 200,
                  width: 300
                }
              },
              _vm._l(_vm.ordeers, function(slide, i) {
                return _c("slide", { key: "slide" + i, attrs: { index: i } }, [
                  _c("div", { staticClass: "small-order" }, [
                    _c("div", { staticClass: "advertise-order" }, [
                      _c("div", { staticClass: "advertise-row" }, [
                        _c("div", { staticClass: "advertise-address" }, [
                          _c(
                            "div",
                            { staticClass: "small-order-cell order-from" },
                            [
                              _c("img", {
                                staticClass: "svg",
                                attrs: {
                                  src: "/images/home.svg",
                                  alt: "From",
                                  title: _vm.trans("front.main.from"),
                                  "data-toggle": "tooltip"
                                }
                              }),
                              _vm._v(" "),
                              _c(
                                "span",
                                { staticClass: "small-order-cell-adress" },
                                [_c("span", [_vm._v(_vm._s(slide.from))])]
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "div",
                            { staticClass: "small-order-cell order-to" },
                            [
                              _c("img", {
                                staticClass: "svg",
                                attrs: {
                                  src: "/images/send.svg",
                                  alt: _vm.trans("front.main.to"),
                                  title: _vm.trans("front.main.to"),
                                  "data-toggle": "tooltip"
                                }
                              }),
                              _vm._v(" "),
                              _c(
                                "span",
                                { staticClass: "small-order-cell-adress" },
                                [_c("span", [_vm._v(_vm._s(slide.to))])]
                              )
                            ]
                          )
                        ]),
                        _vm._v(" "),
                        _c("div", { staticClass: "advertise-pricing" }, [
                          _c("img", {
                            attrs: {
                              src:
                                "/api/orders/images/icon?price=" +
                                slide.price +
                                "&distance=" +
                                slide.distance,
                              alt: ""
                            }
                          })
                        ])
                      ]),
                      _vm._v(" "),
                      _c("div", { staticClass: "advertise-row" }, [
                        slide.ship
                          ? _c(
                              "div",
                              { staticClass: "advertise-address shipping" },
                              [
                                _c("img", {
                                  attrs: {
                                    src: "/images/shippings/" + slide.ship.img,
                                    alt: slide.ship.title
                                  }
                                }),
                                _vm._v(" "),
                                _c("span", { staticStyle: { width: "100%" } }, [
                                  _vm._v(_vm._s(slide.ship.title))
                                ])
                              ]
                            )
                          : _vm._e(),
                        _vm._v(" "),
                        _c("div", { staticClass: "advertise-pricing" })
                      ])
                    ])
                  ])
                ])
              }),
              1
            )
          ],
          1
        )
      : _vm._e()
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/mainPage.vue?vue&type=template&id=0a49a3ac&":
/*!************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/pages/mainPage.vue?vue&type=template&id=0a49a3ac& ***!
  \************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "main-page-div" }, [
    _c(
      "div",
      { class: { "main-page-overlay": true, checked: false } },
      [
        _c(
          "form",
          {
            ref: "newOrderForm",
            staticClass: "main-page-form",
            attrs: { action: "#" },
            on: {
              submit: function($event) {
                $event.preventDefault()
                return _vm.saveNewOrder($event)
              }
            }
          },
          [
            _c(
              "div",
              { staticClass: "form-head" },
              [
                _c("h1", [_vm._v(_vm._s(_vm.trans("frontend.main.make")))]),
                _vm._v(" "),
                _c(
                  "slick",
                  {
                    ref: "slick",
                    staticClass: "text-slider",
                    attrs: { options: _vm.slickOptions }
                  },
                  [
                    _c("div", [_vm._v(_vm._s(_vm.trans("frontend.main.p1")))]),
                    _vm._v(" "),
                    _c("div", [_vm._v(_vm._s(_vm.trans("frontend.main.p2")))]),
                    _vm._v(" "),
                    _c("div", [_vm._v(_vm._s(_vm.trans("frontend.main.p3")))]),
                    _vm._v(" "),
                    _c("div", [_vm._v(_vm._s(_vm.trans("frontend.main.p4")))])
                  ]
                )
              ],
              1
            ),
            _vm._v(" "),
            _c("div", { staticClass: "form-container" }, [
              _c(
                "div",
                {
                  class: { "main-form-input": true, focused: _vm.fromFocused }
                },
                [
                  _c("div", { staticClass: "main-from-span" }, [
                    _vm.from.icon
                      ? _c("span", { staticClass: "icon" }, [
                          _c("img", {
                            staticClass: "svg",
                            attrs: {
                              src: _vm.from.icon,
                              alt: _vm.trans("from.main.from")
                            }
                          })
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("label", { attrs: { for: "FromGeoAdress" } }, [
                      _vm._v(_vm._s(_vm.trans("front.main.senderAdress")))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("gmap-autocomplete", {
                    ref: "fromAdress",
                    staticStyle: { "padding-right": "61.5px" },
                    attrs: {
                      placeholder: _vm.trans("front.main.addressPlaceHolder"),
                      id: "FromGeoAdress",
                      autofocus: ""
                    },
                    on: { place_changed: _vm.setFromPlace }
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "icons-wrapper" }, [
                    _c(
                      "span",
                      {
                        attrs: {
                          "data-placement": "right",
                          "data-toggle": "tooltip",
                          role: "button"
                        }
                      },
                      [
                        _c("label", { attrs: { for: "FromGeoAdress" } }, [
                          _c("img", {
                            staticClass: "right-image svg",
                            attrs: {
                              src: "/images/search.svg",
                              alt: _vm.trans("front.main.gpsusage")
                            }
                          })
                        ])
                      ]
                    ),
                    _vm._v(" "),
                    _c(
                      "span",
                      {
                        attrs: {
                          "data-placement": "right",
                          "data-toggle": "tooltip",
                          role: "button",
                          title: _vm.trans("front.main.gpsusage")
                        },
                        on: { click: _vm.getLocationToFrom }
                      },
                      [
                        _vm.isThereLocation
                          ? _c("img", {
                              staticClass: "right-image svg",
                              attrs: {
                                src: "/images/gps-fixed-indicator.svg",
                                alt: _vm.trans("front.main.gpsusage")
                              }
                            })
                          : _vm._e()
                      ]
                    )
                  ])
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                { class: { "main-form-input": true, focused: _vm.toFocused } },
                [
                  _c("div", { staticClass: "main-from-span" }, [
                    _vm.to.icon
                      ? _c("span", { staticClass: "icon" }, [
                          _c("img", {
                            staticClass: "svg",
                            attrs: {
                              src: _vm.to.icon,
                              alt: _vm.trans("from.main.to")
                            }
                          })
                        ])
                      : _vm._e(),
                    _vm._v(" "),
                    _c("label", { attrs: { for: "ToGeoAdress" } }, [
                      _vm._v(_vm._s(_vm.trans("front.main.receiverAdress")))
                    ])
                  ]),
                  _vm._v(" "),
                  _c("gmap-autocomplete", {
                    ref: "ToAdress",
                    staticStyle: { "padding-right": "30px" },
                    attrs: {
                      placeholder: _vm.trans("front.main.addressPlaceHolder"),
                      id: "ToGeoAdress"
                    },
                    on: { place_changed: _vm.setToPlace }
                  }),
                  _vm._v(" "),
                  _c("div", { staticClass: "icons-wrapper" }, [
                    _c(
                      "span",
                      {
                        attrs: {
                          "data-placement": "right",
                          "data-toggle": "tooltip",
                          role: "button"
                        }
                      },
                      [
                        _c("label", { attrs: { for: "ToGeoAdress" } }, [
                          _c("img", {
                            staticClass: "right-image svg",
                            attrs: {
                              src: "/images/search.svg",
                              alt: _vm.trans("front.main.gpsusage")
                            }
                          })
                        ])
                      ]
                    )
                  ])
                ],
                1
              )
            ])
          ]
        ),
        _vm._v(" "),
        _vm.allOrders && _vm.allOrders.length !== 0
          ? _c("app-orders", {
              attrs: { orders: _vm.allOrders },
              on: {
                "slide-change": _vm.slideChange,
                activateOrder: _vm.changeActiveOrder
              }
            })
          : _c("app-other-orders", { attrs: { orders: _vm.otherOrders } })
      ],
      1
    ),
    _vm._v(" "),
    _c(
      "div",
      { staticClass: "main-page-maps" },
      [
        _c(
          "gmap-map",
          {
            ref: "map",
            staticStyle: { width: "100%", height: "100%" },
            attrs: {
              center: { lat: 51.165691, lng: 10.451526 },
              zoom: 6,
              "map-type-id": "roadmap"
            }
          },
          [
            _vm.isNumeric(_vm.to.marker.lng) && _vm.isNumeric(_vm.to.marker.lat)
              ? _c("gmap-marker", {
                  attrs: {
                    "data-toggle": "tooltip",
                    icon: "/images/marker-to.svg",
                    position: _vm.to.marker,
                    title: "to",
                    animation: 2,
                    draggable: true
                  },
                  on: { dragend: _vm.setToPlaceViaMarker }
                })
              : _vm._e(),
            _vm._v(" "),
            _vm.isNumeric(_vm.from.marker.lng) &&
            _vm.isNumeric(_vm.from.marker.lat)
              ? _c("gmap-marker", {
                  attrs: {
                    "data-toggle": "tooltip",
                    icon: "/images/home-marker.svg",
                    position: _vm.from.marker,
                    title: "from",
                    animation: 2,
                    draggable: true
                  },
                  on: { dragend: _vm.setFromPlaceViaMarker }
                })
              : _vm._e()
          ],
          1
        )
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/assets/js/components/pages/main/AppOrders.vue":
/*!*****************************************************************!*\
  !*** ./resources/assets/js/components/pages/main/AppOrders.vue ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AppOrders_vue_vue_type_template_id_0386ae32___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AppOrders.vue?vue&type=template&id=0386ae32& */ "./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=template&id=0386ae32&");
/* harmony import */ var _AppOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AppOrders.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AppOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AppOrders_vue_vue_type_template_id_0386ae32___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AppOrders_vue_vue_type_template_id_0386ae32___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/pages/main/AppOrders.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=script&lang=js&":
/*!******************************************************************************************!*\
  !*** ./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./AppOrders.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=template&id=0386ae32&":
/*!************************************************************************************************!*\
  !*** ./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=template&id=0386ae32& ***!
  \************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOrders_vue_vue_type_template_id_0386ae32___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./AppOrders.vue?vue&type=template&id=0386ae32& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOrders.vue?vue&type=template&id=0386ae32&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOrders_vue_vue_type_template_id_0386ae32___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOrders_vue_vue_type_template_id_0386ae32___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/pages/main/AppOtherOrders.vue":
/*!**********************************************************************!*\
  !*** ./resources/assets/js/components/pages/main/AppOtherOrders.vue ***!
  \**********************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AppOtherOrders_vue_vue_type_template_id_f269efd0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AppOtherOrders.vue?vue&type=template&id=f269efd0& */ "./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=template&id=f269efd0&");
/* harmony import */ var _AppOtherOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AppOtherOrders.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AppOtherOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AppOtherOrders_vue_vue_type_template_id_f269efd0___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AppOtherOrders_vue_vue_type_template_id_f269efd0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/pages/main/AppOtherOrders.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************!*\
  !*** ./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOtherOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./AppOtherOrders.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOtherOrders_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=template&id=f269efd0&":
/*!*****************************************************************************************************!*\
  !*** ./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=template&id=f269efd0& ***!
  \*****************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOtherOrders_vue_vue_type_template_id_f269efd0___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../../node_modules/vue-loader/lib??vue-loader-options!./AppOtherOrders.vue?vue&type=template&id=f269efd0& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/main/AppOtherOrders.vue?vue&type=template&id=f269efd0&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOtherOrders_vue_vue_type_template_id_f269efd0___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AppOtherOrders_vue_vue_type_template_id_f269efd0___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/pages/mainPage.vue":
/*!***********************************************************!*\
  !*** ./resources/assets/js/components/pages/mainPage.vue ***!
  \***********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _mainPage_vue_vue_type_template_id_0a49a3ac___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./mainPage.vue?vue&type=template&id=0a49a3ac& */ "./resources/assets/js/components/pages/mainPage.vue?vue&type=template&id=0a49a3ac&");
/* harmony import */ var _mainPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./mainPage.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/pages/mainPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _mainPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _mainPage_vue_vue_type_template_id_0a49a3ac___WEBPACK_IMPORTED_MODULE_0__["render"],
  _mainPage_vue_vue_type_template_id_0a49a3ac___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/pages/mainPage.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/pages/mainPage.vue?vue&type=script&lang=js&":
/*!************************************************************************************!*\
  !*** ./resources/assets/js/components/pages/mainPage.vue?vue&type=script&lang=js& ***!
  \************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_mainPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./mainPage.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/mainPage.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_mainPage_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/assets/js/components/pages/mainPage.vue?vue&type=template&id=0a49a3ac&":
/*!******************************************************************************************!*\
  !*** ./resources/assets/js/components/pages/mainPage.vue?vue&type=template&id=0a49a3ac& ***!
  \******************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_mainPage_vue_vue_type_template_id_0a49a3ac___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./mainPage.vue?vue&type=template&id=0a49a3ac& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/pages/mainPage.vue?vue&type=template&id=0a49a3ac&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_mainPage_vue_vue_type_template_id_0a49a3ac___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_mainPage_vue_vue_type_template_id_0a49a3ac___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);