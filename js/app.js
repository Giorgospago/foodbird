var config = {
    apiKey: "AIzaSyCwJeXqFUieJ-JyFQuZ5D5lBpNpLZ0xIAQ",
    authDomain: "angel-85bc3.firebaseapp.com",
    databaseURL: "https://angel-85bc3.firebaseio.com",
    projectId: "angel-85bc3",
    storageBucket: "angel-85bc3.appspot.com",
    messagingSenderId: "690028329105"
};
firebase.initializeApp(config);




var app = angular.module("foodbird", ["firebase", "ngRoute", "ngSanitize", "oitozero.ngSweetAlert"]);

app.controller("MainController", function($scope, $http, $firebaseAuth, SweetAlert) {
    var auth = $firebaseAuth();

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
                } else {
                    $scope.user = null;
                }
            });
        } else {
            $scope.user = null;
        }
    });

    $scope.logOut = function() {
        auth.$signOut();
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

});
