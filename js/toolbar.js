(function(window, CRM, $) {
  if (typeof CRM.debug_toolbar_profile_identifier === 'undefined') {
    return;
  }

  $.ajax({
    url: '/civicrm/debug-toolbar/toolbar',
    data: { snippet: 1, id: CRM.debug_toolbar_profile_identifier },
    dataType: "html"
  }).done(function(data) {
    $(window.document.body).append(data);
  });
})(window, CRM, CRM.$);
