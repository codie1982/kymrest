/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var upgrades_pack = function () {
    var _pack = function () {
        console.log("upgrades Çalışıyor...")
    }

    return {
        init: function () {
            _pack();
        }
    }
}();
jQuery(document).ready(function () {
    upgrades_pack.init(); // init metronic core componets
});