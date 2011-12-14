(function($) {
    
    function activate_edit_box()
    {
        //editable-item-name
        //editable-item-buttons
        
        var sOldAlias = $('#editable-item-name').html();
        
        var sEditElement = '<input type="text" id="item-permalink-new" class="mini-input" value="' + sOldAlias + '" />';
        var sButtonsHtml = '<a id="item-permalink-button-save" class="button" href="javascript:void(0)">ОК</a> <a id="item-permalink-button-cancel" class="cancel" href="javascript:void(0)">Отмена</a>';
        
        $('#editable-item-name').html(sEditElement);
        $('#item-permalink-buttons').html(sButtonsHtml);
        
        $('#editable-item-name').unbind('click');
        
        $('#item-permalink-button-save').click(function () {
            $('#PublicationsPost_alias').val($('#item-permalink-new').val());
            
            $('#editable-item-name').html($('#item-permalink-new').val());
            $('#item-permalink-buttons').html('<a id="item-permalink-button-edit" class="button" href="javascript:void(0)">Изменить</a>');
            
            $('#editable-item-name').click(function () {
               activate_edit_box();
            });
            
            $('#item-permalink-button-edit').click(function () {
               activate_edit_box();
            });
        });
        
        $('#item-permalink-button-cancel').click(function () {
            $('#PublicationsPost_alias').val(sOldAlias);
            
            $('#editable-item-name').html(sOldAlias);
            $('#item-permalink-buttons').html('<a id="item-permalink-button-edit" class="button" href="javascript:void(0)">Изменить</a>');
            
            $('#editable-item-name').click(function () {
               activate_edit_box();
            });
            
            $('#item-permalink-button-edit').click(function () {
               activate_edit_box();
            });
        });
    }
    
    
    $.fn.permalink = function() 
    {
        return this.each(function()
        {
            $(this).find('#editable-item-name').click(function () {
               activate_edit_box();
            });
            
            $(this).find('#item-permalink-button-edit').click(function () {
               activate_edit_box();
            });
            
            
            
        });
    };    
})(jQuery);