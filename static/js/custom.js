jQuery(document).ready(function(){

    $('#login_ajax_link').fancybox({
        href: '#loginbox',
        onComplete: function ()
        {
            $('#iUserLogin_username').focus();
        }
    });
    
    //$('#loginbox').disableSelection();

	k_menu(); // controls the dropdown menu
	k_pixelperfect();
	
	
	// news slider
	jQuery('.newsslider').kriesi_news_slider({
			slides: '.featured',				// wich element inside the container should serve as slide
			animationSpeed: 900,				// animation duration in milliseconds
			autorotation: true,					// autorotation true or false?
			autorotationSpeed:5					// duration between autorotation switch in Seconds
	});

	jQuery('#main').kriesi_image_preloader({delay:200});	// activates preloader for non-slideshow images

});

function sendMail(a, b) {
	location.href = 'm'+'a'+'i'+'l'+'t'+'o'+':'+a+'@'+b;
}
	
// -------------------------------------------------------------------------------------------
// The Image preloader
// -------------------------------------------------------------------------------------------


jQuery.fn.extend({
    disableSelection : function() {
        this.each(function() {
            this.onselectstart = function() { return false; };
                this.unselectable = "on";
                jQuery(this).css({
                     '-moz-user-select': 'none'
                    ,'-o-user-select': 'none'
                    ,'-khtml-user-select': 'none'
                    ,'-webkit-user-select': 'none'
                    ,'-ms-user-select': 'none'
                    ,'user-select': 'none'
                });
            });
        }
});



(function($)
{
	$.fn.kriesi_image_preloader = function(options) 
	{
		var defaults = 
		{
			repeatedCheck: 500,
			fadeInSpeed: 1000,
			delay:600,
			callback: ''
		};
		
		var options = $.extend(defaults, options);
		
		return this.each(function()
		{
			var imageContainer = jQuery(this),
				images = imageContainer.find('img').css({opacity:0, visibility:'hidden'}),
				imagesToLoad = images.length;				
				
				imageContainer.operations =
				{	
					preload: function()
					{	
						var stopPreloading = true;
						
						images.each(function(i, event)
						{	
							var image = $(this);
							
							
							if(event.complete == true)
							{	
								imageContainer.operations.showImage(image);
							}
							else
							{
								image.bind('error load',{currentImage: image}, imageContainer.operations.showImage);
							}
							
						});
						
						return this;
					},
					
					showImage: function(image)
					{	
						imagesToLoad --;
						if(image.data.currentImage != undefined) {image = image.data.currentImage;}
												
						if (options.delay <= 0) image.css('visibility','visible').animate({opacity:1}, options.fadeInSpeed);
												 
						if(imagesToLoad == 0)
						{
							if(options.delay > 0)
							{
								images.each(function(i, event)
								{	
									var image = $(this);
									setTimeout(function()
									{	
										image.css('visibility','visible').animate({opacity:1}, options.fadeInSpeed);
									},
									options.delay*(i+1));
								});
								
								if(options.callback != '')
								{
									setTimeout(options.callback, options.delay*images.length);
								}
							}
							else if(options.callback != '')
							{
								(options.callback)();
							}
							
						}
						
					}

				};
				
				imageContainer.operations.preload();
		});
		
	}
})(jQuery);


// -------------------------------------------------------------------------------------------
// The News Slider
// -------------------------------------------------------------------------------------------

(function($)
{
	$.fn.kriesi_news_slider= function(options) 
	{
		var defaults = 
		{
			slides: '>div',				// wich element inside the container should serve as slide
			animationSpeed: 900,		// animation duration
			autorotation: true,			// autorotation true or false?
			autorotationSpeed:3,		// duration between autorotation switch in Seconds
			easing: 'easeOutQuint',
			backgroundOpacity:0.8		// opacity for background
		};
		
		var options = $.extend(defaults, options);
		
		return this.each(function()
		{
			var slideWrapper 	= $(this),								
				slides			= slideWrapper.find(options.slides).css({display:'none',zIndex:0}),
				slideCount 	= slides.length,
				accelerator = 0,				// accelerator of scrolling speed
				scrollInterval = '',			// var that stores the setInterval id
				mousePos = '',					// current mouse position
				moving = false,					// scrollbar currently moving or not?
				controllWindowHeight = 0,		// height of the wrapping element that hides overflow
				controllWindowPart = 0,			// mouseoverpart of the wrapping element that hides overflow
				itemWindowHeight = 0,			// height of element to move
				current_class = 'active_item',
				skipSwitch = true,
				currentSlideNumber = 0,
				newsSelect ='',
				newsItems = '',
                autoSwitch = true,
                switchInterval = '',
                switchSpeed = 5000;	
				
				slides.find('.feature_excerpt').css('opacity',options.backgroundOpacity);			
				
				slideWrapper.methods = {
				
					init: function()
					{
						newsSelect = $('<div></div>').addClass('newsselect').appendTo(slideWrapper);
						newsItems = $('<div></div>').addClass('newsItems').appendTo(newsSelect);
						fadeout = $('<div></div>').addClass('fadeout').addClass('ie6fix').appendTo(slideWrapper);
						
						slides.filter(':eq(0)').css({zIndex:2, display:'block'});
						
						slides.each(function(i)
						{	
							var slide = $(this),
								url = slide.find('a').attr('href'),
								controll = $('<a class="single_item '+current_class+'"></a>').appendTo(newsItems).attr('href',url);
								current_class ='';
								
							slide.find('.feature_excerpt .sliderheading, .feature_excerpt .sliderdate').clone().appendTo(controll);
							controll.bind('click', {currentSlideNumber: i}, slideWrapper.methods.switchSlide);
						});
						
						controllWindowHeight = newsSelect.height();
						controllWindowPart = controllWindowHeight/3;
						itemWindowHeight = newsItems.height();
						
						if(slideCount > 1)
						{
							slideWrapper.kriesi_image_preloader({delay:200});
							slideWrapper.methods.preloadingDone();
                            
                            if (autoSwitch) {
                                switchInterval = setInterval(function () {slideWrapper.methods.autoSwitch();}, switchSpeed);
                                
                                /*newsSelect.bind('mouseleave', function()
                                { 
                                    clearInterval(switchInterval); 
                                });*/
                            }
						}
					},
                    
                    autoSwitch: function ()
                    {
                        var passed = {data: {currentSlideNumber: 0}};
                        
                        if (currentSlideNumber < slideCount - 1) {
                            passed.data.currentSlideNumber = currentSlideNumber + 1;
                        } else {
                            passed.data.currentSlideNumber = 0;
                        }
                        
                        slideWrapper.methods.switchSlide(passed);
                       
                    },
					
					preloadingDone: function()
					{	
						skipSwitch = false;
						var offset = newsSelect.offset();
						
						newsSelect.mousemove(function(e)
						{
							mousePos = e.pageY - offset.top;
							
							if(!moving)
							{
								scrollInterval = setInterval(function() {slideWrapper.methods.scrollItem(mousePos);}, 25);
								moving = true;
							}
						}); 
										
						newsSelect.bind('mouseleave', function()
						{ 
							clearInterval(scrollInterval); 
							moving = false;
							accelerator = 0;
						});
						
					},
					
					scrollItem: function()
					{	
						var movement = 0,
							percent = controllWindowPart / 100,
							modifier = 10,
							currentTop = parseInt(newsItems.css('top'));
							
						accelerator = accelerator <= 2 ? accelerator + 0.5 : accelerator; 
						
						if(mousePos < controllWindowPart)
						{	
							movement = ((controllWindowPart - mousePos) / percent) * accelerator;
							newPos = currentTop + (movement/modifier);
							
							if(currentTop < 0)
							{	
								if (newPos > 0) newPos = 0;
								newsItems.css({top:newPos + "px"});
							}
						}
						else if(mousePos > controllWindowPart * 2)
						{	
							movement = ((mousePos - controllWindowPart * 2) / percent) * accelerator;
							newPos = currentTop + (movement/modifier * -1);
							
							if((currentTop * -1) < itemWindowHeight - controllWindowHeight)
							{
								if (newPos * -1 > itemWindowHeight - controllWindowHeight) newPos = controllWindowHeight - itemWindowHeight;
								
								newsItems.css({top:newPos + "px"});
							}
						}
						else
						{
							accelerator = 0;
						}
					},
					
					switchSlide: function(passed)
					{	
						var noAction = false;
						
						if(passed != undefined && !skipSwitch)
						{
							if(currentSlideNumber != passed.data.currentSlideNumber)
							{	
								currentSlideNumber = passed.data.currentSlideNumber;
							}
							else
							{
								noAction = true;
							}
						}
						
						if(passed != undefined)
						{	
							// clearInterval(interval);
						}
						
						
						if(!skipSwitch && noAction == false)
						{	
							skipSwitch = true;
							var currentSlide = slides.filter(':visible'),
								nextSlide = slides.filter(':eq('+currentSlideNumber+')');
																
							newsSelect.find('.active_item').removeClass('active_item');
							newsSelect.find('a:eq('+currentSlideNumber+')').addClass('active_item');	
																
							currentSlide.css({zIndex:4});
							nextSlide.css({zIndex:2, display:'block'});
							
							currentSlide.fadeOut(options.animationSpeed, function()
							{
								currentSlide.css({zIndex:0, display:"none"});
								skipSwitch = false;
							});
						}
						return false;
					},
					
					autorotate: function()
					{	
						//autorotation not yet supportet
					}
				
				};
				
				slideWrapper.methods.init();
		});
		
	}
})(jQuery);



function k_menu()
{
    jQuery(".dropdown-menu-box").fadeOut();
    
    jQuery(".dropdown").hover(
        function () {
            jQuery(this).find(".dropdown-menu-box").css("left", 697);
            jQuery(this).find(".dropdown-menu-box").css("top", 50);
            jQuery(this).find(".dropdown-menu-box").fadeIn();
        },
        
        function () {
            jQuery(this).find(".dropdown-menu-box").fadeOut();
        }
    );    
}


//equalHeights by james padolsey
jQuery.fn.equalHeights = function() {
    return this.height(Math.max.apply(null,
        this.map(function() {
           return jQuery(this).height()
        }).get()
    ));
};


function k_pixelperfect()
{	
	// sometimes some elements are offset by one or two pixels. 
	// this isnt anything bad but i really like pixel perfection, therefore this function adds some css rules for specific browsers :)
	if((jQuery.browser.msie && jQuery.browser.version < 7 ) || jQuery.browser.opera)
	{	
		jQuery('#headextras #searchsubmit').css({top:"10px"});
	}
	
	//same size for sidebars:
	//jQuery('.sidebar').equalHeights();
}


/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
	def: 'easeOutQuad',
	swing: function (x, t, b, c, d) {
		//alert(jQuery.easing.default);
		return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
	},
	easeInQuad: function (x, t, b, c, d) {
		return c*(t/=d)*t + b;
	},
	easeOutQuad: function (x, t, b, c, d) {
		return -c *(t/=d)*(t-2) + b;
	},
	easeInOutQuad: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t + b;
		return -c/2 * ((--t)*(t-2) - 1) + b;
	},
	easeInCubic: function (x, t, b, c, d) {
		return c*(t/=d)*t*t + b;
	},
	easeOutCubic: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t + 1) + b;
	},
	easeInOutCubic: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t + b;
		return c/2*((t-=2)*t*t + 2) + b;
	},
	easeInQuart: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t + b;
	},
	easeOutQuart: function (x, t, b, c, d) {
		return -c * ((t=t/d-1)*t*t*t - 1) + b;
	},
	easeInOutQuart: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
		return -c/2 * ((t-=2)*t*t*t - 2) + b;
	},
	easeInQuint: function (x, t, b, c, d) {
		return c*(t/=d)*t*t*t*t + b;
	},
	easeOutQuint: function (x, t, b, c, d) {
		return c*((t=t/d-1)*t*t*t*t + 1) + b;
	},
	easeInOutQuint: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
		return c/2*((t-=2)*t*t*t*t + 2) + b;
	},
	easeInSine: function (x, t, b, c, d) {
		return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
	},
	easeOutSine: function (x, t, b, c, d) {
		return c * Math.sin(t/d * (Math.PI/2)) + b;
	},
	easeInOutSine: function (x, t, b, c, d) {
		return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
	},
	easeInExpo: function (x, t, b, c, d) {
		return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
	},
	easeOutExpo: function (x, t, b, c, d) {
		return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
	},
	easeInOutExpo: function (x, t, b, c, d) {
		if (t==0) return b;
		if (t==d) return b+c;
		if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
		return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
	},
	easeInCirc: function (x, t, b, c, d) {
		return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
	},
	easeOutCirc: function (x, t, b, c, d) {
		return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
	},
	easeInOutCirc: function (x, t, b, c, d) {
		if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
		return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
	},
	easeInElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;if ((t/=d)==1) return b+c;if (!p) p=d*.3;
		if (a < Math.abs(c)) {a=c;var s=p/4;}
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
	},
	easeOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;if ((t/=d)==1) return b+c;if (!p) p=d*.3;
		if (a < Math.abs(c)) {a=c;var s=p/4;}
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
	},
	easeInOutElastic: function (x, t, b, c, d) {
		var s=1.70158;var p=0;var a=c;
		if (t==0) return b;if ((t/=d/2)==2) return b+c;if (!p) p=d*(.3*1.5);
		if (a < Math.abs(c)) {a=c;var s=p/4;}
		else var s = p/(2*Math.PI) * Math.asin (c/a);
		if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
	},
	easeInBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*(t/=d)*t*((s+1)*t - s) + b;
	},
	easeOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158;
		return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
	},
	easeInOutBack: function (x, t, b, c, d, s) {
		if (s == undefined) s = 1.70158; 
		if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
		return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
	},
	easeInBounce: function (x, t, b, c, d) {
		return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
	},
	easeOutBounce: function (x, t, b, c, d) {
		if ((t/=d) < (1/2.75)) {
			return c*(7.5625*t*t) + b;
		} else if (t < (2/2.75)) {
			return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
		} else if (t < (2.5/2.75)) {
			return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
		} else {
			return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
		}
	},
	easeInOutBounce: function (x, t, b, c, d) {
		if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
		return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
	}
});