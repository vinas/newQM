var app = angular.module('questionMaster', ['ngRoute'])
	.config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
		$locationProvider.html5Mode(false);
		$routeProvider
			.when('/', {
				redirectTo: '/home'
			})
			.when('/home', {
				templateUrl: 'templates/home.html'
			})
			.when('/branches', {
				templateUrl: 'templates/branches.html',
				controller: 'branchesController'
			})
			.when('/branches/edit/:id', {
				templateUrl: 'templates/branches-branch.html',
				controller: 'branchesController'
			})
			.when('/branches/new', {
				templateUrl: 'templates/branches-branch.html',
				controller: 'branchesController'
			})
			.when('/fields', {
				templateUrl: 'templates/fields.html',
				controller: 'fieldsController'
			})
			.when('/fields/:action/:id', {
				templateUrl: 'templates/fields-field.html',
				controller: 'fieldsController'
			})
			.when('/courses', {
				templateUrl: 'templates/courses.html',
				controller: 'coursesController'
			})
			.when('/courses/:action/:id', {
				templateUrl: 'templates/courses-course.html',
				controller: 'coursesController'
			})
			.when('/questions', {
				templateUrl: 'templates/questions.html'
			})
			.when('/contact', {
				templateUrl: 'templates/contact.html'
			})
			.otherwise({
				redirectTo: '/home'
			})
	}]);
