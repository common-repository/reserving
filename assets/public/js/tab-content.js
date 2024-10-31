function openTabContent(evt, tabContentId) {
  evt.preventDefault();
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    jQuery(tabcontent[i]).hide();
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  jQuery("#" + tabContentId).show();
  evt.currentTarget.className += " active";

  jQuery('.reserving-form-checker-wrapper').addClass('active');
}

/* Default tab-- */

var option_tab_default = Boolean(parseInt(reserving_data.option_tab_default));

if(option_tab_default){
  
  let reservingCheckerFirstTab = document.querySelector(
    ".shop_page.reserving__tabs button.tablinks:first-child"
  );
  
  if (reservingCheckerFirstTab) {
    reservingCheckerFirstTab.classList.add("active");
  }
  
  if(document.querySelector(".reserving__tabs .tablinks.active") ){
    document.querySelector(".reserving__tabs .tablinks.active").click();
  }

}

jQuery('.reserving-form-checker-wrapper').on('click',function(){
  jQuery(this).removeClass('active');

  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    jQuery(tabcontent[i]).hide();
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
 
});



