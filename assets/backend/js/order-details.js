var reserving_order_details_modal = jQuery("#reserving_order_details_modal");
var modal_close_btn = document.getElementsByClassName("close")[0];

let checkmark_svg = `<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="19" cy="19" r="19" fill="white"/>
<path d="M16.6584 26.711C16.4675 26.8965 16.207 27 15.9364 27C15.6659 27 15.4054 26.8965 15.2145 26.711L9.44877 21.1411C8.85041 20.5631 8.85041 19.626 9.44877 19.0491L10.1707 18.3516C10.7693 17.7737 11.7384 17.7737 12.3368 18.3516L15.9364 21.8287L25.6632 12.4335C26.2618 11.8555 27.2319 11.8555 27.8293 12.4335L28.5512 13.131C29.1496 13.7089 29.1496 14.6459 28.5512 15.2229L16.6584 26.711Z" fill="#27AE60"/>
</svg>`;

var loader_img = document.createElement("img");
loader_img.src = reserving_params.loader;

// Show Order Details
jQuery("body").on("click", "#orders_table button.view_details", function (e) {
  let id = e.target.id;
  var $admin_form_btns = jQuery(".reserving--order--action-btns button");

  jQuery.each($admin_form_btns, function (key) {
    jQuery(this).removeClass("active");
  });

  jQuery(reserving_order_details_modal).show();

  jQuery("#reserving_order_details_modal .loader")
    .addClass("active")
    .html(loader_img);

  jQuery("#reserving_order_details_modal .order_details #order_id_input").val(
    id
  );

  jQuery(".order_details .reserving_order_action_btns button span").html("");

  jQuery.ajax({
    method: "GET",
    url: reserving_params.ajax_url,
    data: {
      action: "view_order_details",
      id: id,
    },
    success: function (res) {
      jQuery("#reserving_order_details_modal .order_details .order_id").html(
        `<strong> Order ID: <span> #${res.id} </span> </strong>`
      );

      jQuery("#reserving_order_details_modal .reserving_print_pdf").attr(
        "data-order_id",
        res.id
      );

      jQuery(
        "#reserving_order_details_modal .order_details .billing_info"
      ).html(reserving_order_billing_info(res));
      jQuery(
        "#reserving_order_details_modal .order_details .shipping_info"
      ).html(reserving_order_shipping_info(res));

      jQuery(
        "#reserving_order_details_modal .order_details .delivery_info"
      ).html(reserving_delivery_info(res.reserving_delivery_info));

      jQuery(
        "#reserving_order_details_modal .order_details .assign_delivery"
      ).html(reserving_delivery_men_list(res));

      jQuery("#reserving_order_details_modal .order_details .dataTable").html(
        reserving_order_items(res.order_items)
      );

      jQuery(
        "#reserving_order_details_modal .order_details .order_total .shipping_total"
      ).html(
        "Shipping Cost: " +
          reserving_params.currency_symbol +
          res.shipping_total
      );

      jQuery(
        "#reserving_order_details_modal .order_details .order_total .total"
      ).html(
        "<strong>Total Cost: " +
          reserving_params.currency_symbol +
          res.total +
          "</strong>"
      );

      jQuery(".order_details .reserving_order_action_btns")
        .find("[data-order-status='" + res.status + "'] span")
        .html(checkmark_svg);

      jQuery(".order_details .reserving_order_action_btns")
        .find("[data-order-status='" + res.status + "']")
        .addClass("active");

      jQuery("#reserving_order_details_modal .loader")
        .removeClass("active")
        .html("");
    },
    error: function (err) {},
  });
});

// Generate Billing Info
function reserving_order_billing_info(order_info) {
  let billing_info = "";
  billing_info += `<h4> Billing Info:</h4>`;
  billing_info += `<p> <strong> Name:</strong> ${order_info.billing.first_name} ${order_info.billing.last_name}</p>`;
  billing_info += `<p> <strong> Phone: </strong> ${order_info.billing.phone}</p>`;
  billing_info += `<p> <strong> Address: </strong> ${
    order_info.billing.address_1 || order_info.billing.address_2
  }</p>`;

  return billing_info;
}
// Generate shipping Info
function reserving_order_shipping_info(order_info) {
  let shipping_info = "";
  shipping_info += `<h4>shipping Info:</h4>`;
  shipping_info += `<p> <strong> Name: </strong> ${order_info.shipping.first_name} ${order_info.shipping.last_name}</p>`;
  shipping_info += `<p> <strong> Phone: </strong> ${order_info.shipping.phone}</p>`;
  shipping_info += `<p> <strong>Address: </strong> ${
    order_info.shipping.address_1 || order_info.shipping.address_2
  }</p>`;

  return shipping_info;
}

// Generate Delivery Info
function reserving_delivery_info(info) {
  let delivery_info = "<h4>Delivery Info:</h4>";
  if (info != "undefined" && info?.delivery_type) {
    if (info.delivery_type.toLowerCase() == "in_restaurant") {
      delivery_info += `<p><strong> Delivery Type: </strong> In Restaurant </p>`;
    } else {
      delivery_info += `<p><strong> Delivery Type: </strong> ${
        info ? info?.delivery_type : "N/A"
      } </p>`;
    }
  }

  if (info != "undefined" && info?.reserving_branch) {
    delivery_info += `<p><strong> Branch: </strong> ${
      info ? info?.reserving_branch : "N/A"
    }</p>`;
  }

  if (info != "undefined" && info?.delivery_area) {
    delivery_info += `<p><strong> Delivery Area: </strong> ${
      info ? info?.delivery_area : "N/A"
    }</p>`;
  }

  if (info != "undefined" && info?.reserving_tables) {
    delivery_info += `<ul class='reserving-tables'><strong> Tables: </strong> `;
    if (info.reserving_tables.length <= 0) {
      delivery_info += "No table founds.";
    } else {
      jQuery.each(info.reserving_tables, function (i, table) {
        delivery_info += `<li>${table?.table_info?.name} (Max: ${table?.max_person})</li>`;
      });
    }
    delivery_info += `</ul>`;
  }

  let delivery_label =
    info != "undefined" &&
    info?.delivery_type &&
    "pickup" === info.delivery_type.toLowerCase()
      ? "Pickup"
      : "Delivery";

  if (info != "undefined" && info?.booking_date) {
    delivery_info += `<p><strong> Booking Date: </strong> ${info.booking_date}</p>`;
  } else if (info != "undefined" && info?.delivery_date) {
    delivery_info += `<p><strong> ${delivery_label} Date: </strong> ${info.delivery_date}</p>`;
  }

  if (info != "undefined" && info?.delivery_time) {
    delivery_info += `<p><strong> ${delivery_label} Time: </strong> ${info.delivery_time}</p>`;
  }

  if (info != "undefined" && info?.start_time) {
    delivery_info += `<p><strong> Start Time: </strong> ${info.start_time}</p>`;
  }

  if (info != "undefined" && info?.end_time) {
    delivery_info += `<p><strong> End Time: </strong> ${info.end_time}</p>`;
  }

  return delivery_info;
}

function reserving_delivery_men_list(order) {
  let delivery_type =
    order?.reserving_delivery_info?.delivery_type.toLowerCase();
  if ("delivery" !== delivery_type) {
    return "";
  }
  let delivery_men = order.reserving_delivery_men;

  let man_id = order.meta_data.find(
    (meta) => meta.key == "reserving_delivery_man"
  )?.value;

  let list = "";

  list += `<label for="assign_delivery">Asign Delivery Man</label>
  <div class="bookta-assign-delivery-man-area">
  <select name="assign_delivery" id="assign_delivery">`;

  delivery_men.forEach(function (man, i) {
    let selected = "";

    if (man_id == man.ID) {
      selected = "selected";
    }
    list += `<option value="${man.ID}" ${selected}>${man.data.display_name}</option>`;
  });

  list += `</select>
  <button id="assign_delivery_btn" data-order_id="${order.id}" onclick="reservingAssignDeliveryMan(this)">Assign</button> </div>`;

  return list;
}

// Generate Order items
function reserving_order_items(order_items) {
  let item_table = "";

  item_table += `<thead><tr class="heading-row">
        <th>Item Name</th>
        <th>Extra Items</th>
        <th>Item Quantity</th>
        <th>Item Total Price</th>
    </tr> </thead>`;
  item_table += "<tbody>";
  jQuery.each(order_items, (i, item) => {
    item_table += "<tr>";
    item_table +=
      "<td>" +
      item.product_name +
      " ( " +
      reserving_params.currency_symbol +
      item.product_price +
      ")</td>";

    item_table += "<td>";

    jQuery.each(item.allmeta, (i, meta) => {
      if (
        meta.key == "_reduced_stock" ||
        meta.key == "reserving_delivery_info"
      ) {
        return true;
      }
      item_table += meta.key + " " + meta.value + "<br>";
    });

    item_table += "</td>";

    item_table += "<td>" + item.quantity + "</td>";

    item_table +=
      "<td>" + reserving_params.currency_symbol + item.total + "</td>";

    item_table += "</tr>";
  });
  item_table += "</tbody>";
  return item_table;
}

// Update Order Status
jQuery(".order_details .reserving_order_action_btns button").on(
  "click",
  function (e) {
    let id = jQuery(
      "#reserving_order_details_modal .order_details #order_id_input"
    ).val();
    let status = jQuery(this).data("order-status");

    jQuery("#reserving_order_details_modal .loader").html("Updating...");

    jQuery.ajax({
      method: "POST",
      url: reserving_params.ajax_url,
      data: {
        action: "update_order_status",
        id: id,
        status: status,
      },
      success: function (res) {
        reservingOrderInfo = res;
        jQuery(".order_details .reserving_order_action_btns button span").html(
          ""
        );
        let button_ele = jQuery(
          ".order_details .reserving_order_action_btns"
        ).find("[data-order-status='" + res.status + "']");
        let button_eles = jQuery(
          ".order_details .reserving_order_action_btns"
        ).find("button");

        jQuery(".order_details .reserving_order_action_btns")
          .find("[data-order-status='" + res.status + "'] span")
          .html(checkmark_svg);

        bookta_remove_elements_attr(button_eles, "active");
        button_ele.addClass("active");

        jQuery("#orders_table .order-status-" + id).html(res.status_text);

        jQuery("#reserving_order_details_modal .loader").html("");
      },
      error: function (err) {},
    });
  }
);

function bookta_remove_elements_attr(selector, cls = "active") {
  selector.each(function (i, obj) {
    jQuery(this).removeClass(cls);
  });
}
// Assign delivery man
function reservingAssignDeliveryMan(btn) {
  jQuery("#reserving_order_details_modal .loader").html("");

  let order_id = jQuery(btn).data("order_id");
  let man_id = jQuery("#assign_delivery").val();

  jQuery.ajax({
    method: "POST",
    url: reserving_params.ajax_url,
    data: {
      order_id: order_id,
      man_id: man_id,
      action: "assign_delivery_man",
    },
    success: function (res) {
      if (res?.ID || res?.id) {
        jQuery("#reserving_order_details_modal .loader").html(
          "<span class='success'> Delivery man assigned successfully.</span>"
        );
        jQuery(reserving_order_details_modal).hide();
        location.reload();
      } else {
        jQuery("#reserving_order_details_modal .loader").html(
          "<span class='error'> Something went wrong!</span>"
        );
      }
    },
    error: function (err) {
      console.log(err);
    },
  });
}

// Close Order Details
jQuery(modal_close_btn).on("click", function () {
  jQuery(reserving_order_details_modal).hide();
});

function reservingPrintOrderPDF(button) {
  jQuery("#reserving_order_details_modal .pdf_section").html("");
  let order_id = jQuery(button).attr("data-order_id");

  jQuery.ajax({
    method: "POST",
    url: reserving_params.ajax_url,
    data: {
      action: "print_order_pdf",
      order_id: order_id,
    },
    success: function (res) {
      jQuery("#reserving_order_details_modal .pdf_section").html(res);
      printJS("printJS-form", "html");
    },
    error: function (err) {
      console.log(err);
    },
  });
}
