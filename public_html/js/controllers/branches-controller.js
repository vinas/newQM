app.controller('branchesController', function($scope, $routeParams, $window, BranchesService, ResponseService) {

    $scope.branches = {};

    $scope.loadBranches = function()
    {
        BranchesService.getResultList()
            .success(function(branches) {
                $scope.branches = branches.content;
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
            });
    };

    $scope.goEditBranch = function(branchId)
    {
        $window.location.href = '#/branches/edit/'+branchId;
    };

    $scope.goEditField = function(id)
    {
        $window.location.href = '#/fields/edit/'+id;
    };

    $scope.getBranchData = function(id)
    {
        BranchesService.getBranchData(id)
            .success(function(branch) {
                $scope.branch = branch.content;
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
            });
    };

    $scope.save = function()
    {
        if (BranchesService.isBranchDataValid($scope.branch)) {
            BranchesService.save($scope.branch)
                .success(function(branch) {
                    ResponseService.handleDefaultResponse(branch, 'save');
                    $scope.goEditBranch(branch.content.id);
                })
                .error(function(res, status) {
                    ResponseService.error(600, res, status);
                });
        } else {
            ResponseService.error(602);
        }
    };

    $scope.delete = function(id)
    {
        if (confirmDelete()) {
            BranchesService.delete(id)
                .success(function(res) {
                    ResponseService.handleDefaultResponse(res);
                    setTimeout(function() {
                        $window.location.href = '#/branches/';
                    }, showTime);
                })
                .error(function(res, status) {
                    ResponseService.error(600, res, status);
                });
        }
    }

    var confirmDelete = function()
    {
        return confirm('This will delete all fields, courses and questions related to this branch.\n\nAre you sure you want to delete it?')
    };

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