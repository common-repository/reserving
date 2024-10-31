function openForm(form_id) {
  jQuery("#" + form_id).show();
}

function closeForm(form_id) {
  jQuery("#" + form_id).hide();
}

function reservingGenerateError(form_id, message) {
  jQuery("#" + form_id + " .message").removeClass("success");
  jQuery("#" + form_id + " .message").addClass("error");
  jQuery("#" + form_id + " .message").show();
  jQuery("#" + form_id + " .message").html(message);
  jQuery("#" + form_id + " .availibity_checker_btn").text("Check Again");
  jQuery(".loader").hide();
}

function reservingClearMessages() {
  jQuery(".message").removeClass("success");
  jQuery(".message").removeClass("error");
  jQuery(".message").html("");
  jQuery(".message").hide();
  jQuery(".loader").hide();
}

function reservingGetFormId(btn) {
  let form_id = jQuery(btn).closest(".form-container")[0].id;
  return form_id;
}

function roundMinutes(date) {
  date.setHours(date.getHours() + Math.ceil(date.getMinutes() / 60));
  date.setMinutes(0, 0, 0); // Resets also seconds and milliseconds

  return date;
}

let reserving_user_date = new Date();
let reserving_user_time = roundMinutes(reserving_user_date).getHours();

reservingSetCookie("reserving_user_time", reserving_user_time);

// Load Time slots
function reservingLoadTimeSlots(form_id) {
  let branch_id = jQuery(
    "#" + form_id + ' select[name="reserving_branch"]'
  ).val();
  let delivery_date = jQuery(
    "#" + form_id + ' input[name="delivery_date"]'
  ).val();

  let action = "load_single_branch_time_slots";

  // console.log(branch_id);

  if (undefined !== branch_id) {
    action = "load_multi_branch_time_slots";

    if (!branch_id) {
      reservingGenerateError(form_id, "Please select a branch.");
      return;
    }
  }

  reserving_user_date = new Date();

  reserving_user_time = roundMinutes(reserving_user_date).getHours();

  reservingSetCookie("reserving_user_time", reserving_user_time);

  jQuery.ajax({
    method: "GET",
    url: ReservingData.ajax_url,
    data: {
      action: action,
      branch_id: branch_id,
      form_id: form_id,
      delivery_date: delivery_date,
      user_time: reserving_user_time,
    },
    success: function (res) {
      jQuery("#" + form_id + " .delivery_time").html(res);
    },
    error: function (err) {
      console.log(err);
    },
  });
}

jQuery('input[name="delivery_date"]').on("change", function () {
  reservingLoadTimeSlots(reservingGetFormId(this));
});

jQuery('.form-container select[name="reserving_branch"]').on(
  "change",
  function (e) {
    reservingLoadDeliveryAreas(e.target.value);
    reservingLoadTimeSlots(reservingGetFormId(this));
  }
);

// Load delivery areas
function reservingLoadDeliveryAreas(branch_id = 0) {
  jQuery("#reserving_delivery_areas").hide();
  jQuery(".message").html("");
  jQuery("#checkoutDeliveryInfo #reserving_delivery_areas").show();

  if (!branch_id) {
    return;
  }

  jQuery(".loader").show();

  const deliveryAreas = jQuery("#reserving_delivery_areas .delivery_areas");
  const messageBox = jQuery("#deliveryChecker .message");

  deliveryAreas.html("");
  messageBox.html("");

  fetch(
    ReservingData.site_url + "/wp-json/wp/v2/reserving-branches/" + branch_id
  )
    .then((response) => response.json())
    .then((data) => {
      let delivery_areas = data["reserving-delivery-area"];
      if (delivery_areas.length <= 0) {
        jQuery("#reserving_delivery_areas").hide();

        messageBox.addClass("error");
        messageBox.text(
          "No Delivery Area Available. Please select another branch"
        );
        jQuery(".loader").hide();
        return;
      }

      let delivery_area_option = "";

      delivery_areas.forEach((id, index) => {
        fetch(
          ReservingData.site_url +
            "/wp-json/wp/v2/reserving-delivery-area/" +
            id
        )
          .then((response) => response.json())
          .then((delivery_area) => {
            delivery_area_option = `<li onclick="reservingGetItemValue(this)" data-value="${delivery_area.id}"> ${delivery_area.name} </li>`;

            deliveryAreas.append(delivery_area_option);

            if (index === delivery_areas.length - 1) {
              jQuery(".loader").hide();
              // jQuery("#reserving_delivery_areas a.start_order").show();
              jQuery("#reserving_delivery_areas").show();
            }
          });
      });
    });
}
reservingLoadDeliveryAreas();

// Search Deliver areas
function reservingSearchDeliveryAreas(search_text) {
  const deliveryAreas = jQuery(".reserving_delivery_areas .delivery_areas li");
  jQuery(".reserving_delivery_areas .delivery_areas").show();
  jQuery(".reserving_delivery_areas .item_value").val("");

  deliveryAreas.each(function (i, item) {
    jQuery(item).removeClass("selected");
    if (
      jQuery(item).text().toLowerCase().indexOf(search_text.toLowerCase()) >= 0
    ) {
      jQuery(item).show();
    } else {
      jQuery(item).hide();
    }
  });
}

// Search Delivery Area
function reservingGetItemValue(item) {
  jQuery(item).closest("form").find(".search_item").val(jQuery(item).text());

  jQuery(item)
    .closest("form")
    .find(".item_value")
    .val(jQuery(item).data("value"));

  jQuery(item)
    .closest("form")
    .find('[name="delivery_area"]')
    .val(jQuery(item).data("value"));

  jQuery("li.selected").removeClass("selected");
  jQuery(item).addClass("selected");

  jQuery(".reserving_delivery_areas .delivery_areas").hide();
}

// Load single branch tables
function reservingLoadRestaurantTables() {
  reservingClearMessages();
  jQuery("#reserving_tables .tables").html("");

  let branch_id = jQuery(
    "#inRestChecker select[name='reserving_branch']"
  ).val();

  let booking_date = jQuery("#inRestChecker input[name='delivery_date']").val();
  let start_time = jQuery(
    "#inRestChecker select[name='reserving_start_time']"
  ).val();
  let end_time = jQuery(
    "#inRestChecker select[name='reserving_end_time']"
  ).val();

  if (
    booking_date == null ||
    booking_date == undefined ||
    start_time == null ||
    start_time == undefined ||
    end_time == null ||
    end_time == undefined
  ) {
    return;
  }

  let data = {
    action: "load_available_tables",
    booking_date: booking_date,
    start_time: start_time,
    end_time: end_time,
  };

  if (branch_id) {
    data.branch_id = branch_id;
  }

  if (start_time >= end_time) {
    reservingGenerateError(
      "inRestChecker",
      "End Time can't be same or earlier than Start Time"
    );
    return;
  }

  jQuery.ajax({
    method: "GET",
    url: ReservingData.ajax_url,
    data: data,
    success: function (res) {
      jQuery("#reserving_tables .tables").html(res);
    },
    error: function (err) {},
  });
}

jQuery("#inRestChecker .delivery_time select").on("change", function () {
  reservingLoadRestaurantTables();
});

jQuery("#inRestChecker .delivery_date input").on("change", function () {
  jQuery('[name="reserving_start_time"]').val(null);
  jQuery('[name="reserving_end_time"]').val(null);
  reservingLoadRestaurantTables();
});

// Check Availability
function reservingCheckAvailability(form_id) {
  jQuery(".message").html("");

  let reservingBranch = jQuery("#" + form_id)
    .find('[name="reserving_branch"]')
    .val();
  let areaID = jQuery("#" + form_id)
    .find('[name="item_value"]')
    .val();
  let deliveryType = jQuery("#" + form_id)
    .find('[name="delivery_type"]')
    .val();

  const search_text = jQuery("#" + form_id + ' [name="search_delivery_area"]')
    .val()
    .trim()
    .toLowerCase();

  if (!reservingBranch) {
    reservingGenerateError(
      form_id,
      "Please at first select a branch and try again."
    );
    return;
  }

  if (!areaID || "" === search_text) {
    reservingGenerateError(
      form_id,
      "Please at first select your location and try again."
    );
    return;
  }

  jQuery.ajax({
    url:
      ReservingData.site_url +
      "/wp-json/wp/v2/reserving-branches/" +
      reservingBranch,
    type: "GET",
    success: function (response) {
      jQuery("#" + form_id + " .message").show();

      let areaTexts = [];
      const deliveryAreas = document.querySelectorAll(
        "#reserving_delivery_areas .delivery_areas li"
      );

      deliveryAreas.forEach((item) => {
        areaTexts.push(jQuery(item).text().trim().toLowerCase());
      });

      if (
        response["reserving-delivery-area"].indexOf(Number(areaID)) >= 0 ||
        areaTexts.indexOf(search_text) >= 0
      ) {
        jQuery("#" + form_id + " .message").removeClass("error");
        jQuery("#" + form_id + " .message").addClass("success");
        jQuery("#" + form_id + " .message").html("Delivery is available.");
        jQuery("#" + form_id + " a.start_order").css("display", "block");
      } else {
        jQuery("#" + form_id + " .message").removeClass("success");
        jQuery("#" + form_id + " .message").addClass("error");
        jQuery("#" + form_id + " .message").html(
          "Sorry, Delivery is not available. Please try another branch and select your location."
        );
      }

      jQuery("#" + form_id + " .availibity_checker_btn").removeAttr("disabled");
      jQuery("#" + form_id + " .availibity_checker_btn").text("Check Again");
      jQuery(".loader").hide();
    },
    error: function (error) {
      jQuery("#" + form_id + " .message").show();
      jQuery("#" + form_id + " .message").addClass("error");
      jQuery("#" + form_id + " .message").html(
        "Someting went wrong. Please try again letter."
      );
      jQuery(".loader").hide();
    },
  });
}

jQuery("#deliveryChecker").on("click", ".availibity_checker_btn", function (e) {
  e.preventDefault();

  jQuery(".loader").show();

  jQuery("#deliveryChecker .message").hide();
  jQuery("#deliveryChecker .btn.start_order").hide();
  jQuery("#deliveryChecker .availibity_checker_btn").text("Checking...");
  jQuery("#deliveryChecker .availibity_checker_btn").attr("disabled", true);

  reservingCheckAvailability("deliveryChecker");
});

jQuery(".deliveryCheckerForm").on("submit", function (e) {
  e.preventDefault();
});

// Start Order function
function reservingStartOrder(form_id, btn) {
  jQuery("#" + form_id + " .message").html("");

  let data = {};
  data.reserving_tables = [];

  if (form_id === "inRestChecker") {
    data.delivery_type = "in_restaurant";
    data.reserving_branch = jQuery(
      "#inRestChecker [name='reserving_branch']"
    ).val();
    data.start_time = jQuery(
      "#inRestChecker [name='reserving_start_time']"
    ).val();
    data.end_time = jQuery("#inRestChecker [name='reserving_end_time']").val();

    let tables = jQuery("#reserving_tables .single_table input:checked");

    Object.values(tables).forEach((table) => {
      data.reserving_tables.push(table.value);
    });
  } else if (form_id === "pickupChecker") {
    delete data.reserving_tables;
    delete data.delivery_area;

    data.delivery_type = "pickup";
    data.reserving_branch = jQuery(
      "#pickupChecker [name='reserving_branch']"
    ).val();
    data.delivery_time = jQuery(
      "#" + form_id + " select[name='delivery_time']"
    ).val();
  } else if (form_id === "deliveryChecker") {
    data.delivery_type = "delivery";
    delete data.reserving_tables;

    data.reserving_branch = jQuery(
      "#deliveryChecker [name='reserving_branch']"
    ).val();
    data.delivery_area = jQuery("#deliveryChecker [name='item_value']").val();

    data.delivery_time = jQuery(
      "#" + form_id + " select[name='delivery_time']"
    ).val();
  }

  data.delivery_date = jQuery(
    "#" + form_id + " input[name='delivery_date']"
  ).val();

  let delivery_info = JSON.stringify(data);

  reservingSetCookie("reserving_delivery_info", delivery_info, 30);

  let isCheckout = parseInt(ReservingData.is_checkout_page);

  if (isCheckout) {
    jQuery("#" + form_id + " .message").html("Information updated.");
    jQuery("#" + form_id + " .message").show();
  }

  let start_btn_url = jQuery(btn).attr("href");
  if ("#" === start_btn_url || !start_btn_url) {
    return;
  }
  window.location.href = jQuery(btn).attr("href");
}

jQuery("a.start_order").on("click", function (e) {
  e.preventDefault();

  let form_id = jQuery(this).closest(".form-container")[0].id;

  reservingStartOrder(form_id, this);
});

function reservingSetCookie(cname, cvalue, exdays = 30) {
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function reservingGetCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

document.addEventListener("DOMContentLoaded", function () {
  function updateStartOrderHref(formId, branchValue) {
    const form = document.getElementById(formId);

    if (form) {
      const startOrderBtn = form.querySelector(".start_order");

      if (startOrderBtn) {
        const currentUrl = new URL(startOrderBtn.href);
        if (branchValue) {
          currentUrl.searchParams.set("branch", branchValue);
        } else {
          currentUrl.searchParams.delete("branch");
        }
        startOrderBtn.href = currentUrl.toString();
      }
    }
  }

  document
    .querySelectorAll('select[name="reserving_branch"]')
    .forEach((select) => {
      select.addEventListener("change", function () {
        const formId = this.closest("form").id;
        const selectedBranch = this.value;
        updateStartOrderHref(formId, selectedBranch);
      });
    });
});
