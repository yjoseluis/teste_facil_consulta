jQuery(window).ready(function()
{
  jQuery("#loader").delay(200).css("display", "none");   
  jQuery('body').bootstrapMaterialDesign();

});

facil = 
{
  showNotification: function(from, align, msg, type)
  {
    $.notify({
      icon: "add_alert",
      message: msg
    }, {
      type: type,
      timer: 3000,
      element: 'body',
      z_index: 1060,
      placement: {
        from: from,
        align: align
      }
    });
  },

  resetForm: function(form)
  {
    $(form)[0].reset();
    $('.bmd-form-group').removeClass('has-success');  
    $('.bmd-form-group').removeClass('is-focused');  
    $('.bmd-form-group').removeClass('is-filled');
  },

  urlParam: function(name)
  {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null) {
      return null;
    }
    return decodeURI(results[1]) || 0;
  },

  initDatetimepickers: function()
  {

    $('.datepicker').datetimepicker(
    {
      format: 'DD/MM/YYYY',
    });

    $('.timepicker').datetimepicker(
    {
      format: 'H:mm',
    });
  },

}

$.extend(true, $.fn.datetimepicker.defaults,
{
  icons:
  {
      time: 'fa fa-clock',
      date: 'fa fa-calendar',
      up: 'fa fa-arrow-up',
      down: 'fa fa-arrow-down',
      previous: 'fa fa-chevron-left',
      next: 'fa fa-chevron-right',
      today: 'fa fa-calendar-check',
      clear: 'fa fa-trash-alt',
      close: 'fa fa-times-circle'
  }
});