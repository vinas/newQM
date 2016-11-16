app.service('BranchesService', function(BranchesFactory) {

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

    this.save = function(branch)
    {
        return BranchesFactory.save(branch);
    };

    this.delete = function(id)
    {
        return BranchesFactory.delete(id);
    };

    this.isBranchDataValid = function(branch)
    {
        if (!branch.branch)
            return false;
        return true;
    };

    return this;
});