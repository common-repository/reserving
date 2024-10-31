!(function () {
  "use strict";
  var e,
    t = {
      399: function (e, t, n) {
        var o = window.wp.blocks,
          l = window.wp.element,
          r = window.wp.i18n,
          i = window.wp.serverSideRender,
          a = n.n(i),
          u = window.wp.components,
          d = window.wp.blockEditor,
          s = JSON.parse(
            '{"apiVersion":2,"name":"qs-reserving/frontend-dashboard","version":"0.1.0","title":"Reserving Frontend Dashboard","category":"widgets","icon":"index-card","description":"Frontend Dashboard For Reserving plugin . Which use Manager and Delivery Man.","attributes":{"textAlign":{"type":"string","default":"left"},"radiologinformField":{"type":"string","default":"yes"},"checkboxField":{"type":"boolean","default":true},"headingField":{"type":"string"},"buttonlField":{"type":"string"},"buttonlColorField":{"type":"string","selector":".button"},"buttonlabelColorField":{"type":"string","selector":"label"},"buttonlbgColorField":{"type":"string"},"button_style":{"type":"object"}},"supports":{"html":false},"textdomain":"reserving","render_callback":"reserving_frontend_dashboard_optins_dynamic_render_callback","editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}'
          );
        (0, o.registerBlockType)(s, {
          edit: function (e) {
            let { attributes: t, setAttributes: n } = e;
            const o = (0, d.useBlockProps)({
                style: { "text-align": t.textAlign },
              }),
              { headingField: i, buttonlField: s, radiologinformField: c } = t;
            return (0, l.createElement)(
              "div",
              o,
              (0, l.createElement)(
                d.BlockControls,
                null,
                (0, l.createElement)(d.BlockAlignmentToolbar, {
                  value: t.textAlign,
                  onChange: (e) => {
                    n({ textAlign: e });
                  },
                })
              ),
              (0, l.createElement)(
                d.InspectorControls,
                null,
                (0, l.createElement)(
                  u.PanelBody,
                  { title: (0, r.__)("Settings") },
                  (0, l.createElement)(u.RadioControl, {
                    label: "Login Form",
                    selected: c,
                    options: [
                      { label: "Yes", value: "yes" },
                      { label: "No", value: "no" },
                    ],
                    onChange: function (e) {
                      n({ radiologinformField: e });
                    },
                  }),
                  (0, l.createElement)(u.TextControl, {
                    label: "Heading",
                    help: "Heading Text",
                    value: i,
                    onChange: function (e) {
                      n({ headingField: e });
                    },
                  }),
                  (0, l.createElement)(u.TextControl, {
                    label: "Button",
                    help: "Button Text",
                    value: s,
                    onChange: function (e) {
                      n({ buttonlField: e });
                    },
                  })
                ),
                (0, l.createElement)(
                  u.PanelBody,
                  { title: (0, r.__)("Style") },
                  (0, l.createElement)("h2", null, " Label Color "),
                  (0, l.createElement)(u.ColorPicker, {
                    label: "Label Color",
                    help: "Label Color Style",
                    value: t.buttonlabelColorField,
                    onChange: (e) => {
                      n({ buttonlabelColorField: e });
                    },
                  }),
                  (0, l.createElement)("h2", null, " Button Color "),
                  (0, l.createElement)(u.ColorPicker, {
                    label: "Button Color",
                    help: "Button Color Style",
                    value: t.buttonlColorField,
                    onChange: (e) => {
                      n({ buttonlColorField: e }),
                        n({ button_style: { ...t.button_style, color: e } });
                    },
                  }),
                  (0, l.createElement)("h2", null, " Button Background Color "),
                  (0, l.createElement)(u.ColorPicker, {
                    label: "Button Background",
                    help: "Button Background Style",
                    value: t.buttonlbgColorField,
                    onChange: (e) => {
                      n({ buttonlbgColorField: e }),
                        n({
                          button_style: { ...t.button_style, background: e },
                        });
                    },
                  })
                )
              ),
              (0, l.createElement)(a(), {
                block: "qs-reserving/frontend-dashboard",
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
  function o(e) {
    var l = n[e];
    if (void 0 !== l) return l.exports;
    var r = (n[e] = { exports: {} });
    return t[e](r, r.exports, o), r.exports;
  }
  (o.m = t),
    (e = []),
    (o.O = function (t, n, l, r) {
      if (!n) {
        var i = 1 / 0;
        for (s = 0; s < e.length; s++) {
          (n = e[s][0]), (l = e[s][1]), (r = e[s][2]);
          for (var a = !0, u = 0; u < n.length; u++)
            (!1 & r || i >= r) &&
            Object.keys(o.O).every(function (e) {
              return o.O[e](n[u]);
            })
              ? n.splice(u--, 1)
              : ((a = !1), r < i && (i = r));
          if (a) {
            e.splice(s--, 1);
            var d = l();
            void 0 !== d && (t = d);
          }
        }
        return t;
      }
      r = r || 0;
      for (var s = e.length; s > 0 && e[s - 1][2] > r; s--) e[s] = e[s - 1];
      e[s] = [n, l, r];
    }),
    (o.n = function (e) {
      var t =
        e && e.__esModule
          ? function () {
              return e.default;
            }
          : function () {
              return e;
            };
      return o.d(t, { a: t }), t;
    }),
    (o.d = function (e, t) {
      for (var n in t)
        o.o(t, n) &&
          !o.o(e, n) &&
          Object.defineProperty(e, n, { enumerable: !0, get: t[n] });
    }),
    (o.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    }),
    (function () {
      var e = { 898: 0, 703: 0 };
      o.O.j = function (t) {
        return 0 === e[t];
      };
      var t = function (t, n) {
          var l,
            r,
            i = n[0],
            a = n[1],
            u = n[2],
            d = 0;
          if (
            i.some(function (t) {
              return 0 !== e[t];
            })
          ) {
            for (l in a) o.o(a, l) && (o.m[l] = a[l]);
            if (u) var s = u(o);
          }
          for (t && t(n); d < i.length; d++)
            (r = i[d]), o.o(e, r) && e[r] && e[r][0](), (e[r] = 0);
          return o.O(s);
        },
        n = (self.webpackChunkwp_settings_framework =
          self.webpackChunkwp_settings_framework || []);
      n.forEach(t.bind(null, 0)), (n.push = t.bind(null, n.push.bind(n)));
    })();
  var l = o.O(void 0, [703], function () {
    return o(399);
  });
  l = o.O(l);
})();
