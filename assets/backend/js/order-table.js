jQuery(document).ready(function ($) {
  var order_table = jQuery("#orders_table").DataTable({
    order: [[0, "desc"]], // 0 is the index of the 'id' column
  });

  if (
    reserving_params.q != "indefined" &&
    reserving_params.q != null &&
    reserving_params.q != ""
  ) {
    order_table.search(reserving_params.q).draw();
  }

  /**
   * =====================================
   * Filter Orders
   * =====================================
   */
  // Filter by date
  const reserving_months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  jQuery(".filter_by_date input").on("change click", function () {
    let d = new Date(jQuery(this).val());
    let date =
      reserving_months[d.getMonth()] +
      " " +
      d.getDate() +
      ", " +
      d.getFullYear();

    jQuery("#orders_table_filter input[type='search']")
      .val(date)
      .trigger("keyup");

    if (date.includes(NaN)) {
      jQuery("#orders_table_filter input[type='search']")
        .val("")
        .trigger("keyup");
    }
  });

  jQuery("#orders_table_filter .all_orders").on("click", function () {
    jQuery(".filter_by_date input").val("");
  });

  // Filter by order status
  function reserving_filter_orders(btn) {
    let status = jQuery(btn).find(".status-text").text();
    if (status == "All Order") {
      status = "";
    }
    jQuery("#orders_table_filter input[type='search']")
      .val(status)
      .trigger("keyup");
  }

  function reserving_order_active_filter_button(btn) {
    jQuery(".reserving_order_filter_btns > div").each(function () {
      jQuery(this).removeClass("active");
    });
    jQuery(btn).parent().addClass("active");
  }

  jQuery(".reserving_order_filter_btns button").on("click", function () {
    reserving_order_active_filter_button(this);
    reserving_filter_orders(this);
  });
});
