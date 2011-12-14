(function($) {
    
    function translit(sText, sResultId)
    {
        $('#' + sResultId).val(urlLit(sText));
    }
    
    function urlLit(w) {
        var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
        var ww=''; w=w.toLowerCase().replace(/ /g,'-');
        for(i=0; i<w.length; ++i) { 
            cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]); 
            if(ch.length<3) ww+=ch; else ww+=eval(ch)[0]; 
        }
        return(ww.replace(/~/g,''));
    }
    
    
    $.fn.translit = function(params) 
    {
        return $(this).keyup(function () {
           translit($(this).val(), params['alias_box']);
        });
    };    
})(jQuery);