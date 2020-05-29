(function ($, Drupal, drupalSettings) {

  'use strict';

  Drupal.behaviors.licenses = {
    attach: function (context, settings) {

      $('.licenses--license-text', context).hide();
      $('.licenses--full-license-link a', context).click(function (e) {
        e.preventDefault();
        $(this).parent().parent().next('.licenses--license-text').toggle();
      });

      $('.licenses--license-toggle-all', context).click(function (e) {
        e.preventDefault();
        console.log('maeh.');
        $('details summary').click();
        $('.licenses--full-license-link a', context).click();
      });



    }
  };

})(jQuery, Drupal, drupalSettings);
