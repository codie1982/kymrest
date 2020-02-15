/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var camp = function () {
    var _pack = function () {
        console.log("Pack Çalışıyor...")
    }

    return {
        init: function () {
            _pack();
        }
    }
}();
jQuery(document).ready(function () {
    camp.init(); // init metronic core componets
});