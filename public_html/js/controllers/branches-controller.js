app.controller('branchesController', function($scope, BranchesService) {

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
        console.log('-> '+branchId);
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
        $scope.navigation = setNavigationModel();
        $scope.loadBranches();
    };

    init();
});