app.service('ResponseService', function() {

    this.code = false;
    this.message = false;
    this.response = false;
    this.status = false;

    this.handleDefaultResponse = function(res, mode)
    {
        if (res.code != 200) {
            this.error(res.code);
            return false;
        }

        if (mode == 'save') {
            if (res.content.id) {
                this.ok('Saved succefully!');
                return true;
            }
            this.error(601);
            return false;
        }

        this.ok(res.message);
        return true;
    };

    this.ok = function(msg)
    {
        this.displayOk(msg, shortDisplayTime);
    };

    this.error = function(err, res, status)
    {
        this.setError(err, res, status);
        this.printErrorOnConsole();
        this.displayError();
    };

    this.setError = function(err, res, status)
    {
        switch (err) {
            case 600:
                this.code = 600;
                this.message = 'Request could not be completed.';
                break;
            case 601:
                this.code = 601;
                this.message = 'Something with the REST services went terribly wrong.';
                break;
            case 602:
                this.code = 602;
                this.message = 'The data on your form is invalid. Please check.';
                break;
            default:
                this.code = 666;
                this.message = 'An handled error had happened.';
        }

        if (res)
            this.response = res;
        if (status)
            this.status = res;
    };

    this.displayError = function()
    {
        this.display(this.message, 'errorMessage');
    };

    this.displayOk = function(msg, time)
    {
        this.display(msg, 'okMessage', time);
    };

    this.printErrorOnConsole = function()
    {
        console.log('code: '+this.code);
        console.log('error: '+this.message);
        console.log('response: '+this.response);
        console.log('status: '+this.status);
    };

    this.display = function(content, css, time)
    {
        $('#msgBox').html(content);
        $('#msgBox').addClass(css);
        $('#msgBox').show(showTime);
        setTimeout(function() {
            $('#msgBox').hide(hideTime);
            $('#msgBox').removeClass(css);
        }, (time > 0) ? time : displayTime);
    };

    return this;
});
