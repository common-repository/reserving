var product_modal = jQuery("#product_quick_view_form");
var reservingProductGridCorePrice = 0;
let close_span = jQuery("#product_quick_view_form .close");
close_span.on("click", function () {
  product_modal.hide();
});

function reservingQuickViewProductDetails(btn) {
  product_modal.show();

  jQuery("#product_quick_view_form .modal-content .reserving-product").html(
    "Loading..."
  );

  let product_id = jQuery(btn)
    .closest("li.product")
    .find("a.product_type_simple")
    .data("product_id");

  if (isNaN(product_id)) {
    product_id = jQuery(btn).attr("data-product_id");
  }

  jQuery.ajax({
    method: "POST",
    url: ReservingData.ajax_url,
    data: {
      action: "quick_view_product_details",
      product_id: product_id,
    },
    success: function (res) {
      reservingProductGridCorePrice = parseFloat(res.price);
      let product_iframe = "";
      if (res.view == "extra_item") {
        product_iframe = res.content;
      } else {
        product_iframe = `<iframe src="${res.url}?reserving-popup-type=quickview#product-${product_id}"></iframe>`;
      }
      jQuery("#product_quick_view_form .modal-content .reserving-product").html(
        product_iframe
      );
    },
    error: function (err) {},
  });
}
jQuery(".reserving_quick_view_btn").on("click", function (e) {
  e.preventDefault();

  reservingQuickViewProductDetails(this);
});

/* Extra Items */

function reservingUpdateSingleProductPrice() {
  let items = jQuery(
    ".reserving-extra--item .reserving_extra_items input[type='checkbox']"
  );

  let extra_price = 0;
  let total_price = 0;

  jQuery.each(items, function (index, item) {
    if (jQuery(item).is(":checked")) {
      let extra_quantity = parseFloat(
        jQuery(item).closest("li").find(".extra_quantity").val()
      );

      if (
        extra_quantity == "" ||
        isNaN(extra_quantity) ||
        extra_quantity <= 0
      ) {
        extra_quantity = 1;
      }

      extra_price +=
        parseFloat(jQuery(item).val()) * parseFloat(extra_quantity);
    }
  });

  total_price = (
    parseFloat(reservingProductGridCorePrice) + extra_price
  ).toFixed(2);

  jQuery(
    ".reserving-extra--item .reserving_product_price .woocommerce-Price-amount"
  ).html(
    '<span class="woocommerce-Price-currencySymbol">' +
      ReservingData.currency_symbol +
      "</span>" +
      total_price
  );
}

jQuery(document).on(
  "click",
  ".reserving-extra--item .reserving_extra_items input[type='checkbox']",
  function () {
    reservingUpdateSingleProductPrice();
  }
);

jQuery(document).on(
  "change",
  ".reserving-extra--item .reserving_extra_items .extra_quantity",
  reservingUpdateSingleProductPrice
);

jQuery(document).on(
  "click",
  ".reserving-extra--item .reserving_extra_items .extra_quantity",
  reservingUpdateSingleProductPrice
);

jQuery(document).on(
  "keyup",
  ".reserving-extra--item .reserving_extra_items .extra_quantity",
  reservingUpdateSingleProductPrice
);

jQuery(document).on(
  "click",
  ".reserving-extra--item .reserving-single-item-wrapper .reserving--single_add--to--cart--button",
  function (e) {
    e.preventDefault();
    var $button = jQuery(this);
    let qproduct_id = jQuery(this).val();
    var form_data = jQuery(this).parent().parent().serialize();

    form_data = form_data +=
      "&" +
      jQuery.param({
        action: "reserving_quick_view_product_add_to_cart",
        nonce: ReservingData.nonce,
        product_id: qproduct_id,
      });

    reserving__ajax({
      method: "POST",
      url: ReservingData.ajax_url,
      data: form_data,
    })
      .then(
        function fulfillHandler(response) {
          if (response.success) {
            jQuery(document.body).trigger("added_to_cart");
            jQuery(document.body).trigger("wc_fragments_refreshed");
            jQuery(document.body).trigger("update_checkout");

            if (!$button.next(".added_to_cart").length) {
              $button.after(response.data.view_button);
            }
          }
        },
        function rejectHandler(jqXHR, textStatus, errorThrown) {}
      )
      .catch(function errorHandler(error) {});
  }
);

function reserving__ajax(options) {
  return new Promise(function (resolve, reject) {
    jQuery.ajax(options).done(resolve).fail(reject);
  });
}
