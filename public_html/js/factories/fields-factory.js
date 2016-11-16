app.factory('FieldsFactory', function($http) {

    this.getListWithBranch = function()
    {
        return $http.get('api/Fields/getListWithBranch/');
    };

    this.get = function(id)
    {
        return $http.get('api/Fields/get/'+id);
    };

    this.save = function(field)
    {
        return $http.post('api/Fields/save/', $.param(field),
                {
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
                }
            );
    };

    this.delete = function(id)
    {
        return $http.get('api/Fields/delete/'+id);
    };

    return this;

});