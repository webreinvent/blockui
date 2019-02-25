import axios from 'axios';

const VueHelpers = {
    options: {},

    //---------------------------------------------------------------------

    //---------------------------------------------------------------------
    setOptions (opts) {
        this.options = opts
        return this
    },

    //---------------------------------------------------------------------
    ajax: function(url, params, callback, nprogress=true)
    {
        if(nprogress)
        {
            NProgress.start();
        }
        axios.post(url, params)
            .then(response => {
                if(response.data.status == 'success')
                {
                    if(response.data.messages)
                    {
                        this.messages(response.data.messages);
                    }

                    if(response.data.warnings)
                    {
                        this.warnings(response.data.warnings);
                    }

                    callback(response.data.data)
                } else
                {
                    console.log(response);
                    if(response.data.errors)
                    {
                        this.errors(response.data.errors);
                    }

                }
            });

    },
    //---------------------------------------------------------------------
    warnings: function (warnings) {
        $.each(warnings, function (index, object) {
            alertify.error(object);
        });
    },
    //---------------------------------------------------------------------
    errors: function (errors) {
        $.each(errors, function (index, error_objects) {

            $.each(error_objects, function (index, object) {
                alertify.error(object);
            });

        });
        this.stopNprogress();
    },
    //---------------------------------------------------------------------
    messages: function (messages) {
        $.each(messages, function (index, object) {
            alertify.success(object);
        });
    },
    //---------------------------------------------------------------------
    success: function (message) {
        if(message === undefined)
        {
            message = "success"
        }
        alertify.success(message);
    },
    //---------------------------------------------------------------------
    stopNprogress: function()
    {
        NProgress.done();
    },
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------
    //---------------------------------------------------------------------


};


export default {
    install: function (Vue, opts) {
        const helpers = VueHelpers.setOptions(opts);
        Vue.prototype.$helpers = helpers;
        Vue.helpers = helpers
    }
}
