app.controller('coursesController', function($scope, $routeParams, $window, CoursesService, BranchesService, FieldsService, ResponseService) {

    $scope.getCourseData = function(id)
    {
        CoursesService.getCourseData(id)
            .success(function(course) {
                $scope.course = course.content;
                $scope.getFieldsOfBranch($scope.course.branchId);
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
            });
    };

    $scope.getFieldsOfBranch = function(branchId)
    {
        FieldsService.getFieldsByBranch(branchId)
            .success(function(fields) {
                $scope.fields = fields.content;
            })
            .error(function(res, status) {
                ResponseService.error(600, res, status);
            });
    };

    $scope.goEditCourse = function(id)
    {
        $window.location.href = '#/courses/edit/'+id;
    };

    $scope.save = function()
    {
        if (CoursesService.isCourseDataValid($scope.course)) {
            CoursesService.save($scope.course)
                .success(function(course) {
                    ResponseService.handleDefaultResponse(course, 'save');
                    $scope.goEditCourse(course.content.id);
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
            CoursesService.delete(id)
                .success(function(res) {
                    ResponseService.handleDefaultResponse(res);
                    setTimeout(function() {
                        $window.location.href = '#/courses/';
                    }, showTime);
                })
                .error(function(res, status) {
                    ResponseService.error(600, res, status);
                });
        }
    }

    var confirmDelete = function()
    {
        return confirm('This will delete all questions related to this course.\n\nAre you sure you want to delete it?')
    };

    var getAllCourses = function()
    {
        CoursesService.getAll()
        .success(function(courses) {
            $scope.courses = courses.content;
        })
        .error(function(res, status) {
            ResponseService.error(600, res, status);
        });
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
            $scope.course.isActive = '1';
            if (($routeParams.id) && $routeParams.action == 'edit') {
                $scope.getCourseData($routeParams.id);
            }
            return false;
        }
        $scope.courses = getAllCourses();
    };

    $scope.courses = [];
    $scope.course = {};
 
    init();

});
