(function ($, Drupal) {
Drupal.behaviors.licences = {
  attach: function (context, settings) {
    $('tr.full-license-text', context).each(function () {
      let license = this;
      $(this).hide().prev().click(function () {
        $(license).toggle();
      });
    });
  }
};
})(jQuery, Drupal);
