'use strict'

ucenterCtrl = angular.module('ucenterCtrl', ['ui.bootstrap'])
ucenterCtrl.controller 'accordionCtrl', ['$scope', '$location', ($scope, $location)->
	$(document).ready ->
		heading = $(document.querySelectorAll('.panel-heading'))
		heading.on 'click', ->
			heading.removeClass('open')
			$(this).addClass('open')

		entry = $(document.querySelectorAll('.panel-group p'))
		entry.on 'click', ->
			entry.removeClass('active')
			$(this).addClass('active')

		link = $(document.querySelector("[href='##{$location.path()}']"))
		link.parent().click()
		$($(link.parent().parent().parent().parent().children()[0]).children()[0]).children().click()
]

ucenterCtrl.controller 'personalInfoCtrl', ['$scope', 'Info', ($scope, Info)->
	$scope.info = Info.get()
]

ucenterCtrl.controller 'bookingInfoCtrl', ['$scope', ($scope)->
	$scope.title = '预约信息'
]

