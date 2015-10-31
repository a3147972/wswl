$(function(){
    $('.login-form').submit(function(){
        var data = $(this).serialize();
        var url = $(this).attr('action');

        $.ajax({
            url:url,
            data : data,
            type : 'post',
            dataType : 'json',
            success : function(i) {
                if (i.status == 1) {
                    window.location.href = i.url;
                } else {
                    alert(i.info);
                }
            }
        })
        return false;
    })
})