angular.module('etApp')
    .factory('ajaxHelper', ['$http', function($http){
        return {
            request: function(action, data) {
                data = data || {};
                data.action = action;
                return $http({
                    url: ajaxUrl,
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    transformRequest: function(obj) {
                        var serialize = function(obj, prefix) {
                            var str = [];
                            for(var p in obj) {
                                if (obj.hasOwnProperty(p)) {
                                    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
                                    str.push(typeof v == "object" ?
                                        serialize(v, k) :
                                    encodeURIComponent(k) + "=" + encodeURIComponent(v));
                                }
                            }
                            return str.join("&");
                        }
                        return serialize(obj);
                    },
                    data: data,
                }).then(function(response){
                    return response;
                });
            }
        };
    }]);