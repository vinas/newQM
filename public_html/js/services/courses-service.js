app.service('CoursesService', function(CoursesFactory) {

    this.getAll = function()
    {
        return CoursesFactory.getListWithAll();
    };

    this.getCourseData = function(id)
    {
        return CoursesFactory.get(id);
    };

    this.save = function(course)
    {
        return CoursesFactory.save(course);
    };

    this.delete = function(id)
    {
        return CoursesFactory.delete(id);
    };

    this.isCourseDataValid = function(course)
    {
        if (!course.fieldId)
            return false;
        if (!course.course)
            return false;
        if (!course.level)
            return false;
        return true;
    };

    return this;

});