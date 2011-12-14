FDB = {};

FDB.AJAX = {
    ratePostSuccess: function (data)
    {
        if (data.status == 'success') {
            
            $('#post-rating-plus-box').html('+');
            $('#post-rating-minus-box').html('-');
            $('#post-rating-count-box, #entry-rating-link').html(data.rating);
            
            return true;
        }
        
        return false;
    },
    
    rateCommentSuccess: function (data)
    {
        if (data.status == 'success') {
            
            $('#comment_' + data.id + '_rating_plus').html('+');
            $('#comment_' + data.id + '_rating_minus').html('-');
            $('#comment_' + data.id + '_rating').html(data.rating);
            
            return true;
        }
        
        return false;
    }
};

FDB.UTILS = {
    vkButtonChange: function(state) 
    {
        var row = $('#vkshare0 tr:first');
        var elem = row.find('td#vk-text-td a div div');
        
        if (state == 0) {
            elem.css('backgroundColor', '#6d8fb3');
            elem.css('borderColor', '#7e9cbc #5c82ab #5c82ab');
        } else if (state == 1) {
            elem.css('backgroundColor', '#84a1bf');
            elem.css('borderColor', '#92acc7 #7293b7 #7293b7');
        } else if (state == 2) {
            elem.css('backgroundColor', '#6688ad');
            elem.css('borderColor', '#51779f #51779f #7495b8');
        }
        var left = row.find('td:first a');
        if (left) {
            if (state == 0) {
                left.css('backgroundPosition', '-21px -42px');
            } else if (state == 1) {
                left.css('backgroundPosition', '-23px -42px');
            } else if (state == 2) {
                left.css('backgroundPosition', '-25px -42px');
            }
        }
    },
    
    reply_comment: function (id)
    {
        var form_html = $('#comment_form').parent().html();
        $('#comment_form').parent().html('');
        
        if (id == 0) {
            $('#comment_new_box').html(form_html); 
        } else {
            $('#comment_reply_' + id).html(form_html); 
            $('#comment_new_box').html('<input type="button" value="Комментировать" id="send" class="button" onclick="FDB.UTILS.reply_comment(0)" />');
        }    
               
        $('#PublicationsComment_parentId').val(id);
        
        return true;
        
    }
}