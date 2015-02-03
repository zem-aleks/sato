(function($) {
    
    
    function init(options) {
        
        var settings = $.extend( {
            addInput : true,
            listValues : [0,1,2,3,4,5],
            onSelect : function($selector, val){},
            type : 'int',
            selectorOfPageContainer : $('#wrapper')
        }, options);
        
        $('html').bind('click.dropdown', function(e) {
            if($(e.target).closest('.dropdown').length <= 0)
                $('.drop-list').slideUp(200);
        });
        
        
        return this.each(function() {
            
            var $this = $(this);
            var data = $this.data('mydrop');
            // Если плагин ещё не проинициализирован
            if (!data) {
                // build a srtuct of dropdown
                var initValue = $this.text();
                $this.addClass('dropdown').html('');
                var $display = $('<input/>').addClass('drop-display').attr({
                                    type : 'text'
                                }).val(initValue);
                var $list = $('<div>').addClass('drop-list');
                for(var k = 0; k < settings.listValues.length; ++k) {
                    $list.append( $('<div>').addClass('drop-option').text(settings.listValues[k]) )
                }
                //if(settings.addInput) {
                    $this.append( $display, $list );
                //}
                
                // add events to show/hide list
                $display.bind('focus.dropdown', function(){
                    if(!$list.is(':visible'))
                    {
                        $('.drop-list').slideUp(200);
                        $display.data('before', $display.val());
                        $display.val('');
                        $list.show();
                        var pageHeight = $(settings.selectorOfPageContainer).height();
                        if (pageHeight - ($list.offset().top + $list.height()) < 0)
                        {
                            $list.css({
                                top: 'auto',
                                bottom: '15px',
                                display: 'block',
                                'border-top' : '1px solid #e0e0e0'
                            });
                        } 
                        
                        var scroll = $list.offset().top;
                        if ($(window).height() - $list.height() > 0)
                            scroll = $list.offset().top - ($(window).height() - $list.height()*2)/2 ;
                        $('body,html').animate({
                            scrollTop: scroll
                        }, 600);
                        
                        
                        
                        
                        
                    }
                });  
                $display.bind('keypress.dropdown',function(e){
                   if(e.which == 13){
                       $list.slideUp(200);
                       
                       $display.trigger('blur');
                       validValue($display, settings);
                       select($this, $display, settings);
                   }
                });
                
                // events to change value of list
                $display.bind('change.dropdown',function(){
                   validValue($display, settings);
                   select($this, $display, settings);
                });
                
                
                $('html').click(function(e){
                    if ($list.is(':visible') && $(e.target).closest($display).length <= 0 && isNaN(parseInt($display.val())))
                    {
                        validValue($display, settings);
                        select($this, $display, settings);
                    }
                });
                
                $list.find('.drop-option').bind('click.dropdown',function(){
                    $list.slideUp(200);
                    var val = parseInt($(this).text());
                    $display.val(val);
                    validValue($display, settings);
                    select($this, $display, settings);
                });
                // end events
                
                /*
                 * Тут выполняем инициализацию
                 */
                $(this).data('mydrop',{
                    target: $this,
                    settings: settings
                });
            }
        });
        
        function select($this, $display, settings)
        {
            if($display.data('before') != $display.val())
            {
                settings.onSelect($this, $display.val()); 
                $display.data('before',$display.val()); 
            }
        }
        
        function validValue($display, settings)
        {
            if (settings.type == 'int') {
                var val = parseInt($display.val(), 10);
                if (isNaN(val))
                    val = 0;
                $display.val(val)
            } 
        }
        
    }

    var methods = {
        init: init,
        destroy: function() {},
        show: function() {},
        hide: function() {},
        update: function(content) {}
    };
    
    $.fn.dropdown = function(method) {

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Метод с именем ' + method + ' не существует для jQuery.dropdown');
        }

    };
})(jQuery);
