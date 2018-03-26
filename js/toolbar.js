(function(window, CRM, $) {
  if (typeof CRM.debug_toolbar_profile_identifier === 'undefined') {
    return;
  }

  $.ajax({
    url: '/civicrm/debug-toolbar/toolbar',
    data: { snippet: 4, id: CRM.debug_toolbar_profile_identifier },
    dataType: "html"
  }).done(function(data) {
    $(window.document.body).append(data);

    $('.da-toolbar-close-button').on('click', function() {
      $('#da-debug-toolbar').addClass('da-toolbar-closed');
    });

    $('.da-toolbar-open-button').on('click', function() {
      $('#da-debug-toolbar').removeClass('da-toolbar-closed');
    });
  });
})(window, CRM, CRM.$);
