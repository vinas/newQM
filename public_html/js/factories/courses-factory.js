app.factory('CoursesFactory', function($http) {

    this.getListWithAll = function()
    {
        return $http.get('api/Courses/getListWithAll/');
    };

    this.get = function(id)
    {
        return $http.get('api/Courses/getWithBranchId/'+id);
    };

    this.save = function(field)
    {
        return $http.post('api/Courses/save/', $.param(field),
                {
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                }
            );
    };

    this.delete = function(id)
    {
        return $http.get('api/Courses/delete/'+id);
    };

    return this;

});