let reservingProductCorePrice = 0;

// Fetch the price from the price element on page load
jQuery(document).ready(function () {
  const priceElement = jQuery(
    ".reserving_product_price .woocommerce-Price-amount"
  );

  if (priceElement.length) {
    // Extract the number (core price) from the price element
    reservingProductCorePrice = parseFloat(
      priceElement.text().replace(/[^\d.]/g, "")
    );

    // If the core price is not valid, default to 0
    if (isNaN(reservingProductCorePrice)) {
      reservingProductCorePrice = 0;
    }
  }

  // Trigger the initial price calculation
  reservingUpdateSingleProductPrice();
});

// Function to update the total price based on extra items and main product quantity
function reservingUpdateSingleProductPrice() {
  // Get the current main product quantity
  let productQuantity = parseInt(jQuery(".reserving_add_quantity").val(), 10);
  if (isNaN(productQuantity) || productQuantity <= 0) {
    productQuantity = 1; // Default to 1 if no valid quantity is provided
  }

  let extra_price = 0;
  let corePriceTotal = reservingProductCorePrice * productQuantity;

  // Loop through all the extra items (checkboxes) and calculate their total price
  let items = jQuery(
    ".reserving-single-page .reserving_extra_items input[type='checkbox']"
  );

  jQuery.each(items, function (index, item) {
    if (jQuery(item).is(":checked")) {
      // Get the quantity of the extra item
      let extraQuantity = parseFloat(
        jQuery(item).closest("li").find(".extra_quantity").val()
      );

      // Default to 1 if the quantity is invalid
      if (isNaN(extraQuantity) || extraQuantity <= 0) {
        extraQuantity = 1;
      }

      // Add the price of the extra item (price * extra quantity * main product quantity)
      extra_price +=
        parseFloat(jQuery(item).val()) * extraQuantity * productQuantity;
    }
  });

  // Total price = core product price (multiplied by quantity) + extra item prices
  let total_price = (corePriceTotal + extra_price).toFixed(2);

  // Update the total price displayed on the page
  jQuery(
    ".reserving-single-page .reserving_product_price .woocommerce-Price-amount"
  ).html(
    '<span class="woocommerce-Price-currencySymbol">' +
      ReservingData.currency_symbol + // Use your dynamic currency symbol here
      "</span>" +
      total_price
  );
}

// Event listeners for changes to checkboxes and quantity fields

// Update price when checkboxes for extra items are clicked
jQuery(
  ".reserving-single-page .reserving_extra_items input[type='checkbox']"
).on("change", reservingUpdateSingleProductPrice);

// Update price when the quantity of extra items is changed
jQuery(".reserving-single-page .reserving_extra_items .extra_quantity").on(
  "change keyup",
  reservingUpdateSingleProductPrice
);

// Update price when the main product quantity is changed
jQuery(".reserving_add_quantity").on(
  "change keyup",
  reservingUpdateSingleProductPrice
);
