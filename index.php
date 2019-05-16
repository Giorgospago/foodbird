<!doctype html>
<html ng-app="foodbird">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<base href="<?=$_SERVER['REQUEST_URI']?>"/>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<link rel="stylesheet" href="css/sweet-alert.css">
		<link rel="stylesheet" href="css/style.css">

		<title>Food Bird</title>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.7/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.7/angular-sanitize.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.7/angular-route.min.js"></script>

	</head>
	<body ng-controller="MainController">
		<div class="navbar navbar-dark">
			<a href="" class="navbar-brand">Food Bird</a>

			<div class="float-right">

				<span ng-if="user">
					<button class="btn btn-sm btn-dark btn-block" ng-click="logOut()">
						Log out
					</button>
				</span>
			
			</div>
		</div>
		
		<ng-view></ng-view>

		<!-- Register Modal -->
		<div class="modal fade" id="signupModal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Εγγραφή νέου χρήστη</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

							<div class="form-group">
								<label for="signupName">Όνομα</label>
								<input type="text" ng-model="form.name" class="form-control" id="signupName">
							</div>
							<div class="form-group">
								<label for="signupGender">SEX</label>
								<select id="signupGender" class="form-control" ng-model="form.gender">
									<option Value="male">Άνδρας</option>
									<option Value="female">Γυναίκα</option>
									<option Value="other">Άλλο</option>
								</select>
							</div>
							<div class="form-group">
								<label for="signupEmail">Email</label>
								<input type="email" ng-model="form.email" class="form-control" id="signupEmail">
							</div>
							<div class="form-group">
								<label for="signupPassword">Κωδικός</label>
								<input type="password" ng-model="form.password" class="form-control">
							</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
						<button 
							type="button" 
							class="btn btn-primary" 
							ng-disabled="!form.name || !form.email || !form.password || !form.gender"
							ng-click="createUser()"
						>Εγγραφή</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Add new address Modal -->
		<div class="modal fade" id="addAddressModal" tabindex="-1" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Προσθήκη νέας διεύθυνσης</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
								<div class="row">
									<div class="col-6">
										<ng-map
											pan-control="true"
											map-type-control="true"
											map-type-control-options="{style:'DROPDOWN_MENU'}"
											zoom-control="false"
										>
											<marker position="[{{ coordinates.lat }}, {{ coordinates.lng }}]"></marker>
										</ng-map>
									</div>
									<div class="col-6">
										<div class="form-group">
											<label for="street">Street</label>
											<input type="text" ng-model="newAddress.street" class="form-control" id="street"/>
										</div>
										<div class="form-group">
											<label for="number">Number</label>
											<input type="text" ng-model="newAddress.number" class="form-control" id="number"/>
										</div>
										<div class="form-group">
											<label for="postal_code">postal_code</label>
											<input type="text" ng-model="newAddress.postal_code" class="form-control" id="postal_code"/>
										</div>
										<div class="form-group">
											<label for="floor_type">Typos Katikias</label>
											<select ng-model="newAddress.floor_type" class="form-control" id="floor_type">
												<option value="" style="display:none">Epilekste Typo Katikias</option>
												<option value="1">Monokatikia</option>
												<option value="2">Polykatikia</option>
											</select>
										</div>
										<div class="form-group" ng-if="newAddress.floor_type == 2">
											<label for="floor_num">Orofos</label>
											<input type="text" ng-model="newAddress.floor_num" class="form-control" id="floor_num"/>
										</div>
										<div class="form-group" ng-if="newAddress.floor_type == 2">
											<label for="floor_name">Onoma sto koudouni</label>
											<input type="text" ng-model="newAddress.floor_name" class="form-control" id="floor_name"/>
										</div>
										<div class="form-group">
											<label for="country">country</label>
											<input type="text" ng-model="newAddress.country" class="form-control" id="country"/>
										</div>
										<div class="form-group">
											<label for="city">City</label>
											<input type="text" ng-model="newAddress.city" class="form-control" id="city"/>
										</div>
										<div class="form-group">
											<label for="alias">Favorite Name</label>
											<input type="text" ng-model="newAddress.alias" class="form-control" id="alias"/>
										</div>
										<div class="form-group">
											<label for="notes">Sxolia gia th dieuthinsh</label>
											<textarea ng-model="newAddress.notes" class="form-control" id="notes"></textarea>
										</div>

									</div>
								</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Ακύρωση</button>
							<button 
								type="button" 
								class="btn btn-primary" 
								ng-disabled="checkNewAddressForm()"
								ng-click="saveNewAddress()"
							>Προσθήκη</button>
						</div>
					</div>
				</div>
			</div>


		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
		<script src="https://www.gstatic.com/firebasejs/5.9.0/firebase.js"></script>
		<script src="https://cdn.firebase.com/libs/angularfire/2.3.0/angularfire.min.js"></script>
		<script src="js/sweet-alert.min.js"></script>
		<script src="js/SweetAlert.min.js"></script>
		<script src="https://maps.google.com/maps/api/js?libraries=placeses,visualization,drawing,geometry,places&key=AIzaSyCwJeXqFUieJ-JyFQuZ5D5lBpNpLZ0xIAQ"></script>
		<script src="https://rawgit.com/allenhwkim/angularjs-google-maps/master/build/scripts/ng-map.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>