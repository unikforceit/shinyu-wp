(function($){

	$(document).ready(function(){

    $('#shinyu-icons-modal').dialog({
      title: 'Icon',
      dialogClass: 'wp-dialog',
      autoOpen: false,
      draggable: false,
      width: '500px',
      modal: true,
      resizable: false,
      closeOnEscape: true,
    });

    var input = null;

    $(document).on('click', '.shinyu-icon input', function() {

      input = $(this);
      
      $('#shinyu-icons-modal').dialog('open');

    });

    $(document).on('click', '.shinyu-icons-modal input', function() {
      $('#shinyu-icons-modal').dialog('close');

      input.val($(this).val());

    });
    
	});

  $(window).load(function() {

  });

})(jQuery);