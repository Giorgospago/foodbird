var config = {
    apiKey: "AIzaSyCwJeXqFUieJ-JyFQuZ5D5lBpNpLZ0xIAQ",
    authDomain: "angel-85bc3.firebaseapp.com",
    databaseURL: "https://angel-85bc3.firebaseio.com",
    projectId: "angel-85bc3",
    storageBucket: "angel-85bc3.appspot.com",
    messagingSenderId: "690028329105"
};
firebase.initializeApp(config);

var app = angular.module("foodbird", ["firebase", "ngRoute", "ngSanitize", "oitozero.ngSweetAlert", 'ngMap']);

app.config(function($routeProvider, $locationProvider) {
    $locationProvider.html5Mode(true);

    $routeProvider
    .when("/", {
        templateUrl : "views/home.html"
    })
    .when("/order/:addressId", {
        templateUrl : "views/order.html"
    })
    .when("/order/:addressId/store/:storeId", {
        templateUrl : "views/store.html"
    })
    .otherwise({
        templateUrl : "views/404.html"
    });
});

app.controller("MainController", function($scope, $http, $firebaseAuth, SweetAlert, NgMap, $routeParams) {
    var auth = $firebaseAuth();

    $scope.selectedAddress = "";
    $scope.user = null;
    $scope.form = {
        name: "",
        email: "",
        password: "",
        gender: "male"
    };

    $scope.resetForm = function() {
        $scope.form = {
            name: "",
            email: "",
            password: "",
            gender: "male"
        };
    };
    


    $scope.googleLogin = function(){
        auth.$signInWithPopup("google")
        .then(function(fu) {
            var postData = {
                id: fu.user.uid,
                name: fu.additionalUserInfo.profile.name,
                photo: fu.additionalUserInfo.profile.picture,
                email: fu.additionalUserInfo.profile.email,
                gender: fu.additionalUserInfo.profile.gender,
                provider: fu.additionalUserInfo.providerId
            };
            
            $scope.registerApi(postData);
        });
    };

    $scope.emailPasswordLogin = function() {
        auth.$signInWithEmailAndPassword($scope.form.email, $scope.form.password)
        .then(function(firebaseUser) {
            $scope.resetForm();
        })
        .catch(function(error) {
            SweetAlert.swal({
                title: "Δεν υπάρχει χρήστης με αυτό το email",
                text: "Θέλετε να κάνετε εγγραφή ?",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Όχι, ευχαριστώ !",
                confirmButtonColor: "#2ecc71",
                confirmButtonText: "Ναι θέλω !!!",
                closeOnConfirm: true
            }, function() {
                $("#signupModal").modal('show');
            });
        });
    };

    $scope.createUser = function() {
        auth.$createUserWithEmailAndPassword($scope.form.email, $scope.form.password)
        .then(function(firebaseUser) {
            $scope.registerApi({
                id: firebaseUser.user.uid,
                name: $scope.form.name,
                gender: $scope.form.gender,
                provider: "emailPassword",
                photo: "",
                email: $scope.form.email
            });

            $scope.resetForm();
        })
        .catch(function(error) {
            console.error(error);
        });
    };


    auth.$onAuthStateChanged(function(firebaseUser) {
        if (firebaseUser) {
            $http.get("api/getUser.php?id=" + firebaseUser.uid)
            .then(function(response) {
                if (response.data.success === true) {
                    $scope.user = response.data.user;

                    if ($scope.user.addresses.length > 0) {
                        $scope.selectedAddress = $scope.user.addresses[0].id;
                    }
                } else {
                    $scope.user = null;
                }
            });
        } else {
            $scope.user = null;
        }
    });

    $scope.logOut = function() {
        SweetAlert.swal({
            title: "Are you sure ?",
            text: "",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Όχι, ευχαριστώ !",
            confirmButtonColor: "#2ecc71",
            confirmButtonText: "Ναι θέλω !!!",
            closeOnConfirm: true
        }, function() {

            auth.$signOut();

        });
    };

    $scope.registerApi = function(postData) {
        $http.post("api/register.php", postData)
            .then(function(response) {
                if (response.data.success === true) {
                    SweetAlert.swal("Ο χρήστης δημιουργήθηκε με επιτυχία!", "", "success");
                    $(".modal").modal('hide');
                }
            });
    };

    $scope.coordinates = {
        lat: null,
        lng: null
    };


    $scope.types = "['establishment']";
    $scope.placeChanged = function() {
        $scope.place = this.getPlace();
    };
    NgMap.getMap().then(function(map) {
        $scope.map = map;
    });




    $scope.addNewAddress = function() {
        $("#addAddressModal").modal('show');

        navigator.geolocation.getCurrentPosition(function(pos) {
            $scope.coordinates.lat = pos.coords.latitude;
            $scope.coordinates.lng = pos.coords.longitude;
            $scope.map.setCenter($scope.coordinates);

            $scope.$apply();
        });
    };

    $scope.saveNewAddress = function() {
        $scope.newAddress["user_id"] = $scope.user.id;
        $http.post("api/add_new_address.php", $scope.newAddress)
            .then(function(response) {
                if (response.data.success === true) {
                    SweetAlert.swal("Ο διεύθυνση δημιουργήθηκε με επιτυχία!", "", "success");
                    $(".modal").modal('hide');
                }
            });
    };

    $scope.newAddress = {};
    $scope.checkNewAddressForm = function() {
        if (!$scope.newAddress.street) return true;
        if (!$scope.newAddress.number) return true;
        if (!$scope.newAddress.postal_code) return true;

        if (!$scope.newAddress.floor_type){
            return true;
        } else if ($scope.newAddress.floor_type == 2) {
            if (!$scope.newAddress.floor_num) return true;
            if (!$scope.newAddress.floor_name) return true;
        }
     
        if (!$scope.newAddress.country) return true;
        if (!$scope.newAddress.city) return true;
        if (!$scope.newAddress.alias) return true;

        return false;
    };


    $scope.selected_filters = {};
    $scope.filters = [];
    $scope.stores = [];
    $scope.currentAddress = {};
    $scope.storeLoader = false;
    $scope.getNearbyStores = function() {
        $scope.filters = [];
        $scope.stores = [];
        $scope.currentAddress = {};
        $scope.storeLoader = true;

        $http.post("api/get_nearby_stores.php", {addressId: $routeParams.addressId})
        .then(function(response){
            $scope.filters = response.data.filters;
            $scope.stores = response.data.stores;
            $scope.currentAddress = response.data.address;
            $scope.storeLoader = false;
        })
        .catch(function() {
            $scope.storeLoader = false;
        });
    };

    $scope.setFilter = function(id) {
        if($scope.selected_filters[id]) {
            delete $scope.selected_filters[id];
        } else {
            $scope.selected_filters[id] = true;
        }
    };

    $scope.checkFilters = function(store) {
        var selectedFilters = Object.keys($scope.selected_filters);
        if(selectedFilters.length === 0) {
            return true;
        }
        
        for(filter of selectedFilters) {
            filter = parseInt(filter);
            if (store.filters.includes(filter)) {
                return true;
            }
        }

        return false;
    };


    $scope.menuLoader = false;
    $scope.getStoreMenu = function() {
        $scope.menuLoader = true;

        $http.post("api/get_store_menu.php", {
            addressId: $routeParams.addressId,
            storeId: $routeParams.storeId
        })
        .then(function(response){
            console.log(response.data);
            $scope.menuLoader = false;
        })
        .catch(function() {
            $scope.menuLoader = false;
        });
    };


});
