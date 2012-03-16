$(function(){
    $("a.userPopup").click(function(){
        var href = $(this).attr('href');
        console.log(href);
        $("body").append("<div id='dialog' title='Username' style='display:none;'>Username: <input name='username' id='username'></div>");
        $("#dialog").dialog({
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                'Go': function(){
                    window.location.href = href+'&username='+$("#username").val();
                }
            }
        });
        return false;
    });
});