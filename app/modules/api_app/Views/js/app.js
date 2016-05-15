var app = angular.module('apiCall', []);
app.controller('apiCallController', function($scope,$http) {
    $scope.submit = function(){
        if ($scope.company_id != null && $scope.sm_type_id != null) {
            $scope.url = "http://socialdata.edutechsolutionsbd.com/api/v1/posts/"+ $scope.company_id +"/"+ $scope.sm_type_id +"?limit=10&email=admin&password=admin";
            //$scope.url = "http://social.etsb.dev/api/v1/posts/123/2/2";
            $http({
                method: 'jsonp',
                url: $scope.url,
                params: {
                    format: 'jsonp',
                    callback: 'JSON_CALLBACK'
                }
            }).then(function (response) {
                $scope.postData = response.data['posts']['data'];
                //alert(response.data);
            });
        }
    }
});