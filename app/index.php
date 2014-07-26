<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta content='text/html; charset=utf-8' http-equiv='content-type'>
        <title>Dota 2 Highlights</title>
        <link rel='stylesheet' href='css/main.css'>
        <script src='js/jquery-2.1.1.min.js'></script>
        <script src='js/angular.min.js'></script>
    </head>
    <body>

<script>
function SearchCtrl($scope, $http) {
	$scope.url = 'search.php'; // The url of our search

	// The function that will be executed on button click (ng-click="search()")
	$scope.search = function() {

		// Create the http post request
		// the data holds the keywords
		// The request is a JSON request.
		$http.post($scope.url, { "data" : $scope.keywords}).
		success(function(data, status) {
			$scope.status = status;
			$scope.data = data;
			$scope.result = data; // Show result from server in our <pre></pre> element
		})
		.
		error(function(data, status) {
			$scope.data = data || "Request failed";
			$scope.status = status;
		});
	};
}
</script>

        <div id='container'>

            <div id='left'>

            </div>


            <div id='center'>
                <div id='header'>
                    <div id='banner' style='width: 50%; height: 100%; float: left;'>
                        <img src='banner.png' width='100%' height='100%' />
                    </div>
                    <div id='links' style='width: 50%; height: 100%; font-size: medium; float: left;'>
                        <a href='test'>highlights<a>
                        <a href='test'>Contact<a>
                    </div>
                </div>

                <div id='data'>
                    Copyright © 2014 - Dota2HL.gg
                    All rights reserved.
                </div>

                <div id='footer'>
                    Copyright © 2014 - Dota2HL.gg
                    All rights reserved.
                </div>
            </div>

            <div id='right'>

            </div>
        </div>

    </body>
</html>
