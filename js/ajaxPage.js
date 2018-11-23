(function($, Drupal) {
  Drupal.AjaxCommands.prototype.ajaxSampleCommand = function(ajax, response, status){
    url = response.url;
    jQuery("#myAlert_resp").load(url);
    jQuery("#myAlert").show();
    jQuery("#myAlert_link").attr("href", url);
    jQuery("#myAlert_link").html(url);
  }
  Drupal.AjaxCommands.prototype.modalCloseCommand = function(){
    jQuery("#myAlert").hide();
  }
})(jQuery, Drupal)