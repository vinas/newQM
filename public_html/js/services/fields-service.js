app.service('FieldsService', function(FieldsFactory) {

    this.getResultList = function()
    {
        return FieldsFactory.getListWithBranch();
    };

    this.getFieldsByBranch = function(branchId)
    {
        return FieldsFactory.getFieldsByBranchId(branchId);
    };

    this.getFieldData = function(id)
    {
        return FieldsFactory.get(id);
    };

    this.save = function(field)
    {
        return FieldsFactory.save(field);
    };

    this.delete = function(id)
    {
        return FieldsFactory.delete(id);
    };

    this.isFieldDataValid = function(field)
    {
        if (!field.branchId)
            return false;
        if (!field.field)
            return false;
        return true;
    };

    return this;

});