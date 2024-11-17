!function (n, e) {
  "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : ((n = n || self).__vee_validate_locale__hy = n.__vee_validate_locale__hy || {}, n.__vee_validate_locale__hy.js = e())
}(this, function () {
  "use strict";
  var n, e = {
    name: "hy", messages: {
      _default: function (n) {
        return n + " դաշտի արժեքը անթույլատրելի է"
      }, after: function (n, e) {
        var t = e[0];
        return n + "դաշտի ամսաթիվը պետք է լինի մեծ " + (e[1] ? "կամ հավասար " : "") + t
      }, alpha: function (n) {
        return n + " դաշտը պետք է պարունակի միայն տառեր"
      }, alpha_dash: function (n) {
        return n + " դաշտը պետք է պարունակի միայն տառեր, թվեր և գծիկներ"
      }, alpha_num: function (n) {
        return n + " դաշտը պետք է պարունակի միայն տառեր և թվեր"
      }, alpha_spaces: function (n) {
        return n + " դաշտը պետք է պարունակի միայն տառեր և բացատ"
      }, before: function (n, e) {
        var t = e[0];
        return n + " դաշտի ամսաթիվը պետք է լինի մինչև " + (e[1] ? "կամ հավասար " : "") + t
      }, between: function (n, e) {
        return n + " դաշտը պետք է լինի " + e[0] + "-ի" + " և " + e[1] + "-ի միջև"
      }, confirmed: function (n, e) {
        return n + " դաշտը չի համապատասխանում " + e[0]  + " դաշտի հետ"
      }, credit_card: function (n) {
        return n + " դաշտը պետք է լինի գործող բանկային քարտի համար"
      }, date_between: function (n, e) {
        return n + " դաշտի ամսաթիվը պետք է լինի " + e[0] + " և " + e[1] + "-ի միջև"
      }, date_format: function (n, e) {
        return  + " դաշտը պետք է լինի " + e[0] + " ֆորմատով"
      }, decimal: function (n, e) {
        void 0 === e && (e = []);
        var t = e[0];
        return void 0 === t && (t = "*"), n + " դաշտը պետք է լինի թիվ և կարող է պարունակել" + ("*" === t ? " տասնորդական թիվ" : " " + t + " տասնորդական թվեր")
      }, digits: function (n, e) {
        return n + " դաշտը պետք է լինի թվային և պարունակի միայն " + e[0] + " թվանշան"
      }, dimensions: function (n, e) {
        return n + " դաշտը պետք է լինի " + e[0] + " պիքսել x " + e[1] + " պիքսել"
      }, email: function (n) {
        return n + " դաշտը պետք է լինի վավերական Էլ․ հասցե"
      }, excluded: function (n) {
        return n + " դաշտը պետք է ունենա թույլատրելի արժեք"
      }, ext: function (n, e) {
        return n + " դաշտը պետք է լինի գործող ֆայլ (" + e[0] + ")"
      }, image: function (n) {
        return "Поле " + n + " должно быть изображением"
      }, included: function (n) {
        return n + " դաշտը պետք է լինի նկար"
      }, integer: function (n) {
        return n + " դաշտը պետք է լինի ամբողջ թիվ"
      }, ip: function (n) {
        return n + " դաշտը պետք է լինի վավեր IP հասցե"
      }, length: function (n, e) {
        var t = e[0], r = e[1];
        return r ? n + " դաշտի երկարությունը պետք է լինի " + t  + "-ի" + " և " + r + "-ի միջև" : "դաշտի երկարությունը " + n + " պետք է լինի " + t
      }, max: function (n, e) {
        return n + " դաշտի նիշերի քանակը չի կարող գերազանցել " + e[0] + "-ը"
      }, max_value: function (n, e) {
        return n + " դաշտը պետք է լինի " + e[0] + " կամ ավելի փոքր"
      }, mimes: function (n, e) {
        return n + " դաշտի ֆայլի տեսակը պետք է լինի հետևյալներից մեկը (" + e[0] + ")"
      }, min: function (n, e) {
        return n + " դաշտի նիշերի քանակը պետք է լինի առնվազն " + e[0]
      }, min_value: function (n, e) {
        return n + " դաշտը պետք է լինի " + e[0] + " կամ ավելի մեծ"
      }, numeric: function (n) {
        return n + " դաշտը պետք է լինի թվային"
      }, regex: function (n) {
        return n + " դաշտը ունի սխալ ձևաչափ"
      }, required: function (n) {
        return n + " դաշտը պարտադիր է"
      }, size: function (n, e) {
        return n + " դաշտը պետք է լինի ավելի փոքր, քան " + function (n) {
          var e = 1024, t = 0 === (n = Number(n) * e) ? 0 : Math.floor(Math.log(n) / Math.log(e));
          return 1 * (n / Math.pow(e, t)).toFixed(2) + " " + ["Byte", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"][t]
        }(e[0])
      }, url: function (n) {
        return n + " դաշտն ունի սխալ URL ձևաչափ"
      }
    }, attributes: {}
  };
  return "undefined" != typeof VeeValidate && VeeValidate.Validator.localize(((n = {})[e.name] = e, n)), e
});