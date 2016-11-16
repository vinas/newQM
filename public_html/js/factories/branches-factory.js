app.factory('BranchesFactory', function($http) {

    this.getAll = function()
    {
        return $http.get('api/Branches/getList/');
    };

    this.getListWithCounters = function()
    {
        return $http.get('api/Branches/getListWithCounters/');
    };

    this.getBranchWithFields = function(id)
    {
        return $http.get('api/Branches/getBranchWithFields/'+id);
    };

    this.save = function(branch)
    {
        return $http.post('api/Branches/save/', $.param(branch),
                {
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                }
            );
    };

    this.delete = function(id)
    {
        return $http.get('api/Branches/delete/'+id);
    };

    return this;
});