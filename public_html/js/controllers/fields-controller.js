app.controller('fieldsController', function($scope, $routeParams, $window, FieldsService, BranchesService, ResponseService) {

    $scope.loadFields = function() {
        FieldsService.getResultList()
            .success(function(fields) {
                $scope.fields = fields.content;
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
            });
    };

    $scope.getFieldData = function(id)
    {
        FieldsService.getFieldData(id)
            .success(function(field) {
                $scope.field = field.content;
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
            });
    };

    $scope.goEditField = function(id)
    {
        $window.location.href = '#/fields/edit/'+id;
    };

    $scope.save = function()
    {
        if (FieldsService.isFieldDataValid($scope.field)) {
            FieldsService.save($scope.field)
                .success(function(field) {
                    ResponseService.handleDefaultResponse(field, 'save');
                    $scope.goEditField(field.content.id);
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
            FieldsService.delete(id)
                .success(function(res) {
                    ResponseService.handleDefaultResponse(res);
                    setTimeout(function() {
                        $window.location.href = '#/fields/';
                    }, showTime);
                })
                .error(function(res, status) {
                    ResponseService.error(600, res, status);
                });
        }
    }

    var confirmDelete = function()
    {
        return confirm('This will delete all courses and questions related to this branch.\n\nAre you sure you want to delete it?')
    };

    var getAllBranches = function()
    {
        BranchesService.getAll()
        .success(function(branches) {
            $scope.branches = branches.content;
        })
        .error(function(res, status) {
            ResponseService.error(600, res, status);
        });
    };

    var init = function()
    {
        if ($routeParams.action) {
            getAllBranches();
            $scope.field.isActive = '1';
            if ($routeParams.id) {
                if ($routeParams.action == 'edit')
                    $scope.getFieldData($routeParams.id);
                if ($routeParams.action == 'new') {
                    $scope.field.branchId = $routeParams.id;
                }
            }
            return false;
        }
        $scope.loadFields();
    };

    $scope.branches = [];
    $scope.field = {};

    init();

});
