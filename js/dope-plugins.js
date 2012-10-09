
(function($) {
    $(document).ready(function() {
        var $dialog = $('#dope-plugin-dialog').dialog({
            dialogClass: 'wp-dialog',
            autoOpen: false,
            title: 'DG\'s Object-oriented Plugin Extension',
            modal: true,
            width: '800px',
            height: 'auto',
            position: 'center',
            resizable: true,
            buttons: [
            {
                text: "Cancel",
                'class': 'button-secondary',
                click: cancel_button
            },
            {
                text: "Deactivate", 
                'class': 'button-primary',
                click: deactivate_button
            }
            ]
        });
        
        var deactivate_link = $('#dgs-object-oriented-plugin-extension .deactivate:first a');
        deactivate_link.click(function() {
            var count = $('#dope_pcount').val();
            console.log(count);
            if (count == 0){
                // safe to deactivate
                return true;
            }
            $dialog.dialog('open');
            // prevent the default action, e.g., following a link
            return false;
        });
        $('#helloworld').click(function(){
            console.log($dialog);
            $dialog.dialog('open');
            return false;
        });
    });
    
    var cancel_button = function() {
        $( this ).dialog( "close" );
    };
    var deactivate_button = function() {
        var win = $( this );
        $.post( ajaxurl, {
            action: "dope_deactivate_plugin"
        } ).success( function( result ) {
            // If there was an error with the AJAX call.. do a normal POST
            if ( '-1' == result ) {
                console.log("Error: " + result);
                return false;
            }
            // Display the AJAX reponse
            console.log(result);
            win.dialog( "close" );
                        
            // reload html body
            $.ajax({
                url: "",
                context: document.body,
                success: function(s){
                    $(this).html(s);
                }
            });
            return false;
        });
    };
    
})(jQuery)