jQuery(document).ready(function (t) {
  ({
    color: function () {
      t(".reserving-color-picker").wpColorPicker();
    },

    shortcode_copy: function () {
      t("body").on(
        "click",
        ".reserving-shortcode-option .reserving-copy-shortcode-text",
        function (a) {
          a.preventDefault();
          var b_input = jQuery(this).siblings();

          b_input.css({ "border-bottom": "3px solid #F54748" });
          b_input.focus();

          var $temp = jQuery("<input>");
          jQuery("body").append($temp);
          $temp.val(b_input.text().trim()).select();
          document.execCommand("copy");
          $temp.remove();
          setTimeout(() => {
            b_input.css({ border: "0" });
          }, 5000);
        }
      );
    },
    date: function () {},
    media: function () {
      var e,
        i = "";
      t("body").on("click", ".reserving-media-delete-button", function (e) {
        e.preventDefault(),
          (i = t("#" + t(this).data("input-id"))).val(""),
          t(this).closest("td").find(".image-preview").remove();
      }),
        t("body").on("click", ".reserving-media-button", function (a) {
          a.preventDefault(),
            (i = t("#" + t(this).data("input-id"))),
            void 0 === e
              ? ((e = wp.media.frames.file_frame =
                  wp.media({
                    frame: "post",
                    state: "insert",
                    multiple: !1,
                    library: { type: "image" },
                  })).on("insert", function () {
                  e.state()
                    .get("selection")
                    .each(function (t, e) {
                      (t = t.toJSON()), 0 === e && i.val(t.url);
                      jQuery(".reserving-image-preview img").attr("src", t.url);
                    });
                }),
                e.open())
              : e.open();
        });
    },
    audio: function () {
      var e,
        i = "";
      t("body").on("click", ".reserving-media-delete-button", function (e) {
        e.preventDefault(),
          (i = t("#" + t(this).data("input-id"))).val(""),
          t(this).closest("td").find(".image-preview").remove();
      }),
        t("body").on("click", ".reserving-media-audio", function (a) {
          a.preventDefault(),
            (i = t("#" + t(this).data("input-id"))),
            void 0 === e
              ? ((e = wp.media.frames.file_frame =
                  wp.media({
                    frame: "post",
                    state: "insert",
                    multiple: !1,
                    library: { type: "audio" },
                  })).on("insert", function () {
                  e.state()
                    .get("selection")
                    .each(function (t, e) {
                      (t = t.toJSON()), 0 === e && i.val(t.url);
                    });
                }),
                e.open())
              : e.open();
        });
    },
    image_select: function () {
      t("input.radioImageSelect").each(function (e) {
        t(this)
          .hide()
          .after(
            '<img src="' + t(this).data("image") + '" alt="radio image" />'
          );
        var i = t(this).next("img");
        i.addClass("radio-img-item"),
          t(this).prop("checked") &&
            i.addClass("item-selected wp-ui-highlight"),
          i.on("click", function (e) {
            var i, a;
            t(this)
              .prev('input[type="radio"]')
              .prop("checked", !0)
              .trigger("change"),
              (i = t(this)),
              (a = i.prev('input[type="radio"]').attr("name")),
              t('input[name="' + a + '"]').each(function () {
                var e = t(this).next("img");
                t(this).prop("checked")
                  ? e.addClass("item-selected wp-ui-highlight")
                  : e.removeClass("item-selected wp-ui-highlight");
              });
          });
      });
    },
    repeat: function () {
      var e = t(".reserving-repeat-table-wrap");
      e.on("click", ".add-row", function (i) {
        i.preventDefault();
        var a = t(this).data("count"),
          n = e
            .find("tr.clone")
            .clone()
            .removeAttr("class")
            .removeAttr("style")
            .wrap("<div/>")
            .parent()
            .html()
            .replace(/field_count/g, a);
        e.find("tbody").append(n), (a += 1), t(this).data("count", a);
      }),
        e.on("click", "tbody tr .item-action", function (e) {
          e.preventDefault(), t(this).closest("tr").remove();
        });
    },
    init: function () {
      this.shortcode_copy(),
        this.color(),
        this.audio(),
        this.media(),
        this.image_select(),
        this.repeat(),
        this.date();
    },
  }).init();
});

document.addEventListener("DOMContentLoaded", () => {
  const elements = document.querySelectorAll(".disable-click");

  if (elements.length > 0) {
    elements.forEach(function (element) {
      if (element !== undefined && element !== null) {
        element.addEventListener("click", function (event) {
          event.preventDefault();
          event.stopPropagation();
          console.log("Click disabled for element:", element);
        });
      }
    });
  }
});
