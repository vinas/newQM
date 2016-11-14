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

    return this;
});