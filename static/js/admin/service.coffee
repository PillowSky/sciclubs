'use strict'

adminService = angular.module('adminService', ['ngResource'])
adminService.config(['$resourceProvider', ($resourceProvider)->
	$resourceProvider.defaults.actions.update =
		method: 'PUT'
])

adminService.factory('Category', ['$resource', ($resource)->
	$resource('/admin/categoryAdmin/')
])

adminService.factory('CategoryField', ['$resource', ($resource)->
	$resource('/admin/categoryField/')
])

adminService.factory('CategoryKeyword', ['$resource', ($resource)->
	$resource('/admin/categoryKeyword/')
])

adminService.factory('User', ['$resource', ($resource)->
	$resource('/admin/peopleUser/')
])

adminService.factory('Operator', ['$resource', ($resource)->
	$resource('/admin/peopleStaff/')
])

adminService.factory('Supervisor', ['$resource', ($resource)->
	$resource('/admin/peopleAdmin/')
])