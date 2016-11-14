app.controller('branchesController', function($scope, $routeParams, $location, BranchesService) {

    $scope.content = 'hello';

    $scope.branches = {};

    $scope.loadBranches = function()
    {
        BranchesService.getResultList()
            .success(function(branches) {
                $scope.branches = branches.content;
            })
            .error(function(res, status) {
                console.log("Error: " + res + "\nStatus: " + status);
            }
        );
    };

    $scope.goEditBranch = function(branchId)
    {
        $location.url('branches/edit/'+branchId);
    };

    $scope.getBranchData = function(id)
    {
        BranchesService.getBranchData(id)
            .success(function(branch) {
                $scope.branch = branch.content;
            })
            .error(function(response, status) {
                console.log("Error: " + response + "\nStatus: " + status);
            });
    };

    $scope.save = function() {
        console.log('will save branch');
    }

    // TEMP
    var setNavigationModel = function()
    {
        var res = {};

        res.orderBy = 'id';
        res.nextPage = '3';
        res.prevPage = '1';
        res.currentPage = '2';
        res.totalPages = '10';
        res.totalRows = '200';
        res.maxRows = '20';
        res.limit = '20';
        res.direction = 'ASC';

        return res;
    };

    var init = function()
    {
        if ($routeParams.id) {
            $scope.getBranchData($routeParams.id);
            return false;
        }
        $scope.navigation = setNavigationModel();
        $scope.loadBranches();
    };

    init();
});