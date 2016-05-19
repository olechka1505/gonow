(function ($) {
  //namespace
  $.DirectConnect = $.DirectConnect || {};
  $.extend($.DirectConnect, {
    DebugOn: false,
    Init: function () {
      $.DirectConnect.Connect();
    },
    CurrentTicket: -1,
    Connect: function () {
      $.DirectConnect.ClearError();
      //validations
      if (!$("#connectionAgreement").is(":checked")) {
          $.DirectConnect.HandleError('Please check the box next to Step 2 to authorize remote access to your computer.');
        return;
      }
      var enteredTicket = $("#connectionCode").val();
      if ($.trim(enteredTicket) == '') {
          $.DirectConnect.HandleError("Sorry, but we couldn't verify the ticket number entered. Please try again.");
        return;
      }
      var bttnClass = jQuery('#connectButton').prop("className");
      if (bttnClass && bttnClass == "standardButtonDisabled") {
        return;
      }
      jQuery('#connectButton').prop("className", "standardButtonDisabled");
      jQuery('#connectButton').css("opacity", 0.5);

      //Submit form
      $("#connectForm").submit();
    },

    HandleError: function (errorMessage) {
      $('#errorMessage').html(errorMessage);
    },

    ClearError: function () {
      $('#errorMessage').html('');
    },

    Debug: function (message) {
      if (!$.DirectConnect.DebugOn) {
        return;
      }
      var dbg = document.createElement('div');
      dbg.style.color = 'blue';
      dbg.innerHTML = "[" + new Date().toTimeString() + "]" + message;
      document.body.appendChild(dbg);
    }

  });

  $(document).ready(function () {
  });
})(jQuery);

jQuery(document).ready(function ($) {
  $("#connectionCode").focus();
  try {
        //Code to try to maxmize the window 
		top.window.moveTo(0,0); 
		if (document.all) {
		   top.window.resizeTo(screen.availWidth,screen.availHeight);
		} 
		else if (document.layers || document.getElementById)  {
		    if (top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth) { 
		        top.window.outerHeight = top.screen.availHeight;
		        top.window.outerWidth = top.screen.availWidth; 
		    } 
		} 
  }  catch (e){}
  

  //Code to try to inject browser and os info
  try {
    var browser = $.client.browser.name;
    if ($.client.browser.version != null) browser += " " + $.client.browser.version;
    $('#browserName').text(browser);
    var os = $.client.os.friendlyName || "Unknown";
    $('#osName').text(os);
  }  catch (e){}


  if ($("#connectButton").length > 0) {
    $("#connectButton").live("click", function () {
      $.DirectConnect.Init();
    });
  }

  $(document).bind("keypress", function (event) {
    if (event && event.keyCode == 13) {
      $('#connectButton').click();
      event.stopPropagation();
      return false;
    }
  });
});
