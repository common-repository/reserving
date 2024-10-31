
jQuery(document).ready(function ($) {

    var order_table = jQuery("#reserving-last-24h-orders").DataTable({
        ordering: false,
        pageLength: 10,
         language: {
          emptyTable: "No order founds.",
        },
    });

    jQuery('.reserving-dashboard-report-wrap .reserving-row-cards').sortable({
        update: function( event, ui ) {

            var div_sort = jQuery(this).children().get().map(function(el) {
                let classes = jQuery.grep(el.className.split(" "), function(v, i){
                    return v.indexOf('reserving-report-') === 0;
                });

                return classes;
            });
     
            $.ajax({
                url: reserving_obj.ajaxurl,
                type: 'post',
                data: {
                    'action':'reserving_dashboard_report_card_sorting',
                    'reserving-dashboard-card-sorted-element':div_sort,
                    'option': 'reserving_sorted_cards'
                }
               
            });
        
        }
      });

});