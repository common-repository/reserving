!(function () {
  "use strict";
  var e,
    t = {
      186: function (e, t, n) {
        var r = window.wp.blocks,
          i = window.wp.element,
          o = (window.wp.i18n, window.wp.serverSideRender),
          l = n.n(o),
          a = (window.wp.components, window.wp.blockEditor),
          c = JSON.parse(
            '{"apiVersion":2,"name":"qs-reserving/availability-checker","version":"0.1.0","title":"Reserving Availability checker","category":"widgets","icon":"index-card","description":"Frontend Availability Checker","attributes":{"textAlign":{"type":"string","default":"left"}},"supports":{"html":true},"textdomain":"reserving","render_callback":"reserving_availabil_checker_render_callback","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}'
          );
        (0, r.registerBlockType)(c, {
          edit: function (e) {
            let { attributes: t, setAttributes: n } = e;
            const r = (0, a.useBlockProps)({
              style: { "text-align": t.textAlign },
            });
            return (0, i.createElement)(
              "div",
              r,
              (0, i.createElement)(
                a.BlockControls,
                null,
                (0, i.createElement)(a.BlockAlignmentToolbar, {
                  value: t.textAlign,
                  onChange: (e) => {
                    n({ textAlign: e });
                  },
                })
              ),
              (0, i.createElement)(l(), {
                block: "qs-reserving/availability-checker",
                attributes: t,
              })
            );
          },
          save: function () {
            return null;
          },
        });
      },
    },
    n = {};
  function r(e) {
    var i = n[e];
    if (void 0 !== i) return i.exports;
    var o = (n[e] = { exports: {} });
    return t[e](o, o.exports, r), o.exports;
  }
  (r.m = t),
    (e = []),
    (r.O = function (t, n, i, o) {
      if (!n) {
        var l = 1 / 0;
        for (u = 0; u < e.length; u++) {
          (n = e[u][0]), (i = e[u][1]), (o = e[u][2]);
          for (var a = !0, c = 0; c < n.length; c++)
            (!1 & o || l >= o) &&
            Object.keys(r.O).every(function (e) {
              return r.O[e](n[c]);
            })
              ? n.splice(c--, 1)
              : ((a = !1), o < l && (l = o));
          if (a) {
            e.splice(u--, 1);
            var s = i();
            void 0 !== s && (t = s);
          }
        }
        return t;
      }
      o = o || 0;
      for (var u = e.length; u > 0 && e[u - 1][2] > o; u--) e[u] = e[u - 1];
      e[u] = [n, i, o];
    }),
    (r.n = function (e) {
      var t =
        e && e.__esModule
          ? function () {
              return e.default;
            }
          : function () {
              return e;
            };
      return r.d(t, { a: t }), t;
    }),
    (r.d = function (e, t) {
      for (var n in t)
        r.o(t, n) &&
          !r.o(e, n) &&
          Object.defineProperty(e, n, { enumerable: !0, get: t[n] });
    }),
    (r.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    }),
    (function () {
      var e = { 506: 0, 26: 0 };
      r.O.j = function (t) {
        return 0 === e[t];
      };
      var t = function (t, n) {
          var i,
            o,
            l = n[0],
            a = n[1],
            c = n[2],
            s = 0;
          if (
            l.some(function (t) {
              return 0 !== e[t];
            })
          ) {
            for (i in a) r.o(a, i) && (r.m[i] = a[i]);
            if (c) var u = c(r);
          }
          for (t && t(n); s < l.length; s++)
            (o = l[s]), r.o(e, o) && e[o] && e[o][0](), (e[o] = 0);
          return r.O(u);
        },
        n = (self.webpackChunkwp_settings_framework =
          self.webpackChunkwp_settings_framework || []);
      n.forEach(t.bind(null, 0)), (n.push = t.bind(null, n.push.bind(n)));
    })();
  var i = r.O(void 0, [26], function () {
    return r(186);
  });
  i = r.O(i);
})();
