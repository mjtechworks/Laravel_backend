(function (define) {
    define(['jquery'], function ($) {
        return (function () {

            var axiosToastrNoti = {
                getAxiosObjErrToHtml: getAxiosObjErrToHtml,
                getAxiosObjErrToHtmlESNew: getAxiosObjErrToHtmlESNew,
                triggerToastr: triggerToastr,
                alertErr: alertErr,
                alertMsg: alertMsg
            };

            return axiosToastrNoti;
            
            function getAxiosObjErrToHtml(err) {
                // #1
                let errList = [];
                for (const prop in err) {
                    let errListItem = err[prop].map(function(value){
                        return `<li>${value}</li>`;
                    }).join('')
                    errList.push(errListItem);
                }
                return `<ul>${errList.join('')}</ul>`;
            }
            function getAxiosObjErrToHtmlESNew() {
                // #2 new version but some browser not support
                let errList = Object.values(err);
                let errListHtml = errList.map(function(errValue){
                    return errValue.map(function(value){
                        return `<li>${value}</li>`;
                    }).join('');
                }).join('');
                return`<ul>${errListHtml}</ul>`;
            } 
            function triggerToastr(msg) {
                toastr.error(msg);
            }
            function alertErr(err) {
                this.triggerToastr(this.getAxiosObjErrToHtml(err));
            }
            function alertMsg(obj) {
                /**
                 * obj = {type: '', msg: ''}
                 */
                switch (obj.type) {
                    case 'success':
                        toastr.success(obj.msg);
                        break;
                    case 'warning':
                        toastr.warning(obj.msg);
                        break;
                    case 'info':
                        toastr.info(obj.msg);
                        break;
                    case 'error':
                        toastr.error(obj.msg);
                        break;
                }
            }
        })();
    });
}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    } else {
        window.axiosToastrNoti = factory(window.jQuery);
    }
}));