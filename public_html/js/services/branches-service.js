app.service('BranchesService', function(BranchesFactory) {

    this.branches = [];
    this.branch = {};

    this.getAll = function()
    {
        return BranchesFactory.getAll();
    };

    this.getResultList = function()
    {
        return BranchesFactory.getListWithCounters();
    };

    this.getBranchData = function(id)
    {
        return BranchesFactory.getBranchWithFields(id);
    };

    return this;
});