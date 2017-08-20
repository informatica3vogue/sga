$(function () {
    (function (BootStrap, $, undefined) {
        var Utils = (function () {
            function Utils() {
                //ctor
            }
            Utils.prototype.createAlert = function (title, message, alertType, targetElement) {
                var html = '<div class="alert alert-block ' + alertType + '">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<h4>' + title + '</h4>' + message +
                        '</div>'
                $(targetElement).prepend(html);
            }
            return Utils;
        })();
        BootStrap.Utils = Utils;
    })(window.BootStrap || (window.BootStrap = {}), jQuery);
});