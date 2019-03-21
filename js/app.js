var config = {
    apiKey: "AIzaSyCwJeXqFUieJ-JyFQuZ5D5lBpNpLZ0xIAQ",
    authDomain: "angel-85bc3.firebaseapp.com",
    databaseURL: "https://angel-85bc3.firebaseio.com",
    projectId: "angel-85bc3",
    storageBucket: "angel-85bc3.appspot.com",
    messagingSenderId: "690028329105"
};
firebase.initializeApp(config);




var app = angular.module("foodbird", ["firebase"]);

app.controller("MainController", function($scope, $http, $firebaseAuth) {
    var auth = $firebaseAuth();

    $scope.user = null;

    


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
            
            $http.post("api/register.php", postData)
            .then(function(response) {
                if (response.data.success === true) {
                    console.log("User Created Successfully !!!");
                }
            });
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

});
