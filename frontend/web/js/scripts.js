$(function() {
    if ($('.special-proposal-slider').length) {

    }
    if ($('#main-slider').length){

    }
    $('.navbar-toggle-button').on('click', function(event) {
        $('header nav').toggle();
    });
    $(".tabs-block").click(function(e) {
        e.preventDefault();
        var activeClass = 'tab-active';
        if(!$(this).hasClass(activeClass)){
            var indexTab = $(".tabs .tabs-block").index(this);
            $(".block-tabs-text").hide();
            $(".tabs-text .block-tabs-text").eq(indexTab).show();
            //setTimeout(explode, 1000);
            $(".tabs-block").removeClass(activeClass);
            $(this).addClass(activeClass);
        }
    });

    $('#productContainer').on('click','.fade_expand',function(){
        $(this).toggleClass('collapsed');
        $(this).parent().parent().find('.fade_inner').toggleClass('collapsed');
    }).on('click', '.scrollToDescription a', function(e){
        e.preventDefault();
        $("html, body").stop().animate({ scrollTop: $('#productDescription').offset().top }, "slow");
    });

    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
        increaseArea: '20%' // optional
    });

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:false,
        autoplay: true,

        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
});

/*! AdminLTE app.js
 * ================
 * Main JS application file for AdminLTE v2. This file
 * should be included in all pages. It controls some layout
 * options and implements exclusive AdminLTE plugins.
 *
 * @Author  Almsaeed Studio
 * @Support <http://www.almsaeedstudio.com>
 * @Email   <abdullah@almsaeedstudio.com>
 * @version 2.3.8
 * @license MIT <http://opensource.org/licenses/MIT>
 */
function _init(){"use strict";$.AdminLTE.layout={activate:function(){var a=this;a.fix(),a.fixSidebar(),$("body, html, .wrapper").css("height","auto"),$(window,".wrapper").resize(function(){a.fix(),a.fixSidebar()})},fix:function(){$(".layout-boxed > .wrapper").css("overflow","hidden");var a=$(".main-footer").outerHeight()||0,b=$(".main-header").outerHeight()+a,c=$(window).height(),d=$(".sidebar").height()||0;if($("body").hasClass("fixed"))$(".content-wrapper, .right-side").css("min-height",c-a);else{var e;c>=d?($(".content-wrapper, .right-side").css("min-height",c-b),e=c-b):($(".content-wrapper, .right-side").css("min-height",d),e=d);var f=$($.AdminLTE.options.controlSidebarOptions.selector);"undefined"!=typeof f&&f.height()>e&&$(".content-wrapper, .right-side").css("min-height",f.height())}},fixSidebar:function(){return $("body").hasClass("fixed")?("undefined"==typeof $.fn.slimScroll&&window.console&&window.console.error("Error: the fixed layout requires the slimscroll plugin!"),void($.AdminLTE.options.sidebarSlimScroll&&"undefined"!=typeof $.fn.slimScroll&&($(".sidebar").slimScroll({destroy:!0}).height("auto"),$(".sidebar").slimScroll({height:$(window).height()-$(".main-header").height()+"px",color:"rgba(0,0,0,0.2)",size:"3px"})))):void("undefined"!=typeof $.fn.slimScroll&&$(".sidebar").slimScroll({destroy:!0}).height("auto"))}},$.AdminLTE.pushMenu={activate:function(a){var b=$.AdminLTE.options.screenSizes;$(document).on("click",a,function(a){a.preventDefault(),$(window).width()>b.sm-1?$("body").hasClass("sidebar-collapse")?$("body").removeClass("sidebar-collapse").trigger("expanded.pushMenu"):$("body").addClass("sidebar-collapse").trigger("collapsed.pushMenu"):$("body").hasClass("sidebar-open")?$("body").removeClass("sidebar-open").removeClass("sidebar-collapse").trigger("collapsed.pushMenu"):$("body").addClass("sidebar-open").trigger("expanded.pushMenu")}),$(".content-wrapper").click(function(){$(window).width()<=b.sm-1&&$("body").hasClass("sidebar-open")&&$("body").removeClass("sidebar-open")}),($.AdminLTE.options.sidebarExpandOnHover||$("body").hasClass("fixed")&&$("body").hasClass("sidebar-mini"))&&this.expandOnHover()},expandOnHover:function(){var a=this,b=$.AdminLTE.options.screenSizes.sm-1;$(".main-sidebar").hover(function(){$("body").hasClass("sidebar-mini")&&$("body").hasClass("sidebar-collapse")&&$(window).width()>b&&a.expand()},function(){$("body").hasClass("sidebar-mini")&&$("body").hasClass("sidebar-expanded-on-hover")&&$(window).width()>b&&a.collapse()})},expand:function(){$("body").removeClass("sidebar-collapse").addClass("sidebar-expanded-on-hover")},collapse:function(){$("body").hasClass("sidebar-expanded-on-hover")&&$("body").removeClass("sidebar-expanded-on-hover").addClass("sidebar-collapse")}},$.AdminLTE.tree=function(a){var b=this,c=$.AdminLTE.options.animationSpeed;$(document).off("click",a+" li a").on("click",a+" li a",function(a){var d=$(this),e=d.next();if(e.is(".treeview-menu")&&e.is(":visible")&&!$("body").hasClass("sidebar-collapse"))e.slideUp(c,function(){e.removeClass("menu-open")}),e.parent("li").removeClass("active");else if(e.is(".treeview-menu")&&!e.is(":visible")){var f=d.parents("ul").first(),g=f.find("ul:visible").slideUp(c);g.removeClass("menu-open");var h=d.parent("li");e.slideDown(c,function(){e.addClass("menu-open"),f.find("li.active").removeClass("active"),h.addClass("active"),b.layout.fix()})}e.is(".treeview-menu")&&a.preventDefault()})},$.AdminLTE.controlSidebar={activate:function(){var a=this,b=$.AdminLTE.options.controlSidebarOptions,c=$(b.selector),d=$(b.toggleBtnSelector);d.on("click",function(d){d.preventDefault(),c.hasClass("control-sidebar-open")||$("body").hasClass("control-sidebar-open")?a.close(c,b.slide):a.open(c,b.slide)});var e=$(".control-sidebar-bg");a._fix(e),$("body").hasClass("fixed")?a._fixForFixed(c):$(".content-wrapper, .right-side").height()<c.height()&&a._fixForContent(c)},open:function(a,b){b?a.addClass("control-sidebar-open"):$("body").addClass("control-sidebar-open")},close:function(a,b){b?a.removeClass("control-sidebar-open"):$("body").removeClass("control-sidebar-open")},_fix:function(a){var b=this;if($("body").hasClass("layout-boxed")){if(a.css("position","absolute"),a.height($(".wrapper").height()),b.hasBindedResize)return;$(window).resize(function(){b._fix(a)}),b.hasBindedResize=!0}else a.css({position:"fixed",height:"auto"})},_fixForFixed:function(a){a.css({position:"fixed","max-height":"100%",overflow:"auto","padding-bottom":"50px"})},_fixForContent:function(a){$(".content-wrapper, .right-side").css("min-height",a.height())}},$.AdminLTE.boxWidget={selectors:$.AdminLTE.options.boxWidgetOptions.boxWidgetSelectors,icons:$.AdminLTE.options.boxWidgetOptions.boxWidgetIcons,animationSpeed:$.AdminLTE.options.animationSpeed,activate:function(a){var b=this;a||(a=document),$(a).on("click",b.selectors.collapse,function(a){a.preventDefault(),b.collapse($(this))}),$(a).on("click",b.selectors.remove,function(a){a.preventDefault(),b.remove($(this))})},collapse:function(a){var b=this,c=a.parents(".box").first(),d=c.find("> .box-body, > .box-footer, > form  >.box-body, > form > .box-footer");c.hasClass("collapsed-box")?(a.children(":first").removeClass(b.icons.open).addClass(b.icons.collapse),d.slideDown(b.animationSpeed,function(){c.removeClass("collapsed-box")})):(a.children(":first").removeClass(b.icons.collapse).addClass(b.icons.open),d.slideUp(b.animationSpeed,function(){c.addClass("collapsed-box")}))},remove:function(a){var b=a.parents(".box").first();b.slideUp(this.animationSpeed)}}}if("undefined"==typeof jQuery)throw new Error("AdminLTE requires jQuery");$.AdminLTE={},$.AdminLTE.options={navbarMenuSlimscroll:!0,navbarMenuSlimscrollWidth:"3px",navbarMenuHeight:"200px",animationSpeed:500,sidebarToggleSelector:"[data-toggle='offcanvas']",sidebarPushMenu:!0,sidebarSlimScroll:!0,sidebarExpandOnHover:!1,enableBoxRefresh:!0,enableBSToppltip:!0,BSTooltipSelector:"[data-toggle='tooltip']",enableFastclick:!1,enableControlTreeView:!0,enableControlSidebar:!0,controlSidebarOptions:{toggleBtnSelector:"[data-toggle='control-sidebar']",selector:".control-sidebar",slide:!0},enableBoxWidget:!0,boxWidgetOptions:{boxWidgetIcons:{collapse:"fa-minus",open:"fa-plus",remove:"fa-times"},boxWidgetSelectors:{remove:'[data-widget="remove"]',collapse:'[data-widget="collapse"]'}},directChat:{enable:!0,contactToggleSelector:'[data-widget="chat-pane-toggle"]'},colors:{lightBlue:"#3c8dbc",red:"#f56954",green:"#00a65a",aqua:"#00c0ef",yellow:"#f39c12",blue:"#0073b7",navy:"#001F3F",teal:"#39CCCC",olive:"#3D9970",lime:"#01FF70",orange:"#FF851B",fuchsia:"#F012BE",purple:"#8E24AA",maroon:"#D81B60",black:"#222222",gray:"#d2d6de"},screenSizes:{xs:480,sm:768,md:992,lg:1200}},$(function(){"use strict";$("body").removeClass("hold-transition"),"undefined"!=typeof AdminLTEOptions&&$.extend(!0,$.AdminLTE.options,AdminLTEOptions);var a=$.AdminLTE.options;_init(),$.AdminLTE.layout.activate(),a.enableControlTreeView&&$.AdminLTE.tree(".sidebar"),a.enableControlSidebar&&$.AdminLTE.controlSidebar.activate(),a.navbarMenuSlimscroll&&"undefined"!=typeof $.fn.slimscroll&&$(".navbar .menu").slimscroll({height:a.navbarMenuHeight,alwaysVisible:!1,size:a.navbarMenuSlimscrollWidth}).css("width","100%"),a.sidebarPushMenu&&$.AdminLTE.pushMenu.activate(a.sidebarToggleSelector),a.enableBSToppltip&&$("body").tooltip({selector:a.BSTooltipSelector,container:"body"}),a.enableBoxWidget&&$.AdminLTE.boxWidget.activate(),a.enableFastclick&&"undefined"!=typeof FastClick&&FastClick.attach(document.body),a.directChat.enable&&$(document).on("click",a.directChat.contactToggleSelector,function(){var a=$(this).parents(".direct-chat").first();a.toggleClass("direct-chat-contacts-open")}),$('.btn-group[data-toggle="btn-toggle"]').each(function(){var a=$(this);$(this).find(".btn").on("click",function(b){a.find(".btn.active").removeClass("active"),$(this).addClass("active"),b.preventDefault()})})}),function(a){"use strict";a.fn.boxRefresh=function(b){function c(a){a.append(f),e.onLoadStart.call(a)}function d(a){a.find(f).remove(),e.onLoadDone.call(a)}var e=a.extend({trigger:".refresh-btn",source:"",onLoadStart:function(a){return a},onLoadDone:function(a){return a}},b),f=a('<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>');return this.each(function(){if(""===e.source)return void(window.console&&window.console.log("Please specify a source first - boxRefresh()"));var b=a(this),f=b.find(e.trigger).first();f.on("click",function(a){a.preventDefault(),c(b),b.find(".box-body").load(e.source,function(){d(b)})})})}}(jQuery),function(a){"use strict";a.fn.activateBox=function(){a.AdminLTE.boxWidget.activate(this)},a.fn.toggleBox=function(){var b=a(a.AdminLTE.boxWidget.selectors.collapse,this);a.AdminLTE.boxWidget.collapse(b)},a.fn.removeBox=function(){var b=a(a.AdminLTE.boxWidget.selectors.remove,this);a.AdminLTE.boxWidget.remove(b)}}(jQuery),function(a){"use strict";a.fn.todolist=function(b){var c=a.extend({onCheck:function(a){return a},onUncheck:function(a){return a}},b);return this.each(function(){"undefined"!=typeof a.fn.iCheck?(a("input",this).on("ifChecked",function(){var b=a(this).parents("li").first();b.toggleClass("done"),c.onCheck.call(b)}),a("input",this).on("ifUnchecked",function(){var b=a(this).parents("li").first();b.toggleClass("done"),c.onUncheck.call(b)})):a("input",this).on("change",function(){var b=a(this).parents("li").first();b.toggleClass("done"),a("input",b).is(":checked")?c.onCheck.call(b):c.onUncheck.call(b)})})}}(jQuery);




/*! =========================================================
 * bootstrap-slider.js
 *
 * Maintainers:
 *		Kyle Kemp
 *			- Twitter: @seiyria
 *			- Github:  seiyria
 *		Rohit Kalkur
 *			- Twitter: @Rovolutionary
 *			- Github:  rovolution
 *
 * =========================================================
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


/**
 * Bridget makes jQuery widgets
 * v1.0.1
 * MIT license
 */

(function(root, factory) {
    if(typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    }
    else if(typeof module === "object" && module.exports) {
        var jQuery;
        try {
            jQuery = require("jquery");
        }
        catch (err) {
            jQuery = null;
        }
        module.exports = factory(jQuery);
    }
    else {
        root.Slider = factory(root.jQuery);
    }
}(this, function($) {
    // Reference to Slider constructor
    var Slider;


    (function( $ ) {

        'use strict';

        // -------------------------- utils -------------------------- //

        var slice = Array.prototype.slice;

        function noop() {}

        // -------------------------- definition -------------------------- //

        function defineBridget( $ ) {

            // bail if no jQuery
            if ( !$ ) {
                return;
            }

            // -------------------------- addOptionMethod -------------------------- //

            /**
             * adds option method -> $().plugin('option', {...})
             * @param {Function} PluginClass - constructor class
             */
            function addOptionMethod( PluginClass ) {
                // don't overwrite original option method
                if ( PluginClass.prototype.option ) {
                    return;
                }

                // option setter
                PluginClass.prototype.option = function( opts ) {
                    // bail out if not an object
                    if ( !$.isPlainObject( opts ) ){
                        return;
                    }
                    this.options = $.extend( true, this.options, opts );
                };
            }


            // -------------------------- plugin bridge -------------------------- //

            // helper function for logging errors
            // $.error breaks jQuery chaining
            var logError = typeof console === 'undefined' ? noop :
                function( message ) {
                    console.error( message );
                };

            /**
             * jQuery plugin bridge, access methods like $elem.plugin('method')
             * @param {String} namespace - plugin name
             * @param {Function} PluginClass - constructor class
             */
            function bridge( namespace, PluginClass ) {
                // add to jQuery fn namespace
                $.fn[ namespace ] = function( options ) {
                    if ( typeof options === 'string' ) {
                        // call plugin method when first argument is a string
                        // get arguments for method
                        var args = slice.call( arguments, 1 );

                        for ( var i=0, len = this.length; i < len; i++ ) {
                            var elem = this[i];
                            var instance = $.data( elem, namespace );
                            if ( !instance ) {
                                logError( "cannot call methods on " + namespace + " prior to initialization; " +
                                    "attempted to call '" + options + "'" );
                                continue;
                            }
                            if ( !$.isFunction( instance[options] ) || options.charAt(0) === '_' ) {
                                logError( "no such method '" + options + "' for " + namespace + " instance" );
                                continue;
                            }

                            // trigger method with arguments
                            var returnValue = instance[ options ].apply( instance, args);

                            // break look and return first value if provided
                            if ( returnValue !== undefined && returnValue !== instance) {
                                return returnValue;
                            }
                        }
                        // return this if no return value
                        return this;
                    } else {
                        var objects = this.map( function() {
                            var instance = $.data( this, namespace );
                            if ( instance ) {
                                // apply options & init
                                instance.option( options );
                                instance._init();
                            } else {
                                // initialize new instance
                                instance = new PluginClass( this, options );
                                $.data( this, namespace, instance );
                            }
                            return $(this);
                        });

                        if(!objects || objects.length > 1) {
                            return objects;
                        } else {
                            return objects[0];
                        }
                    }
                };

            }

            // -------------------------- bridget -------------------------- //

            /**
             * converts a Prototypical class into a proper jQuery plugin
             *   the class must have a ._init method
             * @param {String} namespace - plugin name, used in $().pluginName
             * @param {Function} PluginClass - constructor class
             */
            $.bridget = function( namespace, PluginClass ) {
                addOptionMethod( PluginClass );
                bridge( namespace, PluginClass );
            };

            return $.bridget;

        }

        // get jquery from browser global
        defineBridget( $ );

    })( $ );


    /*************************************************

     BOOTSTRAP-SLIDER SOURCE CODE

     **************************************************/

    (function($) {

        var ErrorMsgs = {
            formatInvalidInputErrorMsg : function(input) {
                return "Invalid input value '" + input + "' passed in";
            },
            callingContextNotSliderInstance : "Calling context element does not have instance of Slider bound to it. Check your code to make sure the JQuery object returned from the call to the slider() initializer is calling the method"
        };

        var SliderScale = {
            linear: {
                toValue: function(percentage) {
                    var rawValue = percentage/100 * (this.options.max - this.options.min);
                    if (this.options.ticks_positions.length > 0) {
                        var minv, maxv, minp, maxp = 0;
                        for (var i = 0; i < this.options.ticks_positions.length; i++) {
                            if (percentage <= this.options.ticks_positions[i]) {
                                minv = (i > 0) ? this.options.ticks[i-1] : 0;
                                minp = (i > 0) ? this.options.ticks_positions[i-1] : 0;
                                maxv = this.options.ticks[i];
                                maxp = this.options.ticks_positions[i];

                                break;
                            }
                        }
                        if (i > 0) {
                            var partialPercentage = (percentage - minp) / (maxp - minp);
                            rawValue = minv + partialPercentage * (maxv - minv);
                        }
                    }

                    var value = this.options.min + Math.round(rawValue / this.options.step) * this.options.step;
                    if (value < this.options.min) {
                        return this.options.min;
                    } else if (value > this.options.max) {
                        return this.options.max;
                    } else {
                        return value;
                    }
                },
                toPercentage: function(value) {
                    if (this.options.max === this.options.min) {
                        return 0;
                    }

                    if (this.options.ticks_positions.length > 0) {
                        var minv, maxv, minp, maxp = 0;
                        for (var i = 0; i < this.options.ticks.length; i++) {
                            if (value  <= this.options.ticks[i]) {
                                minv = (i > 0) ? this.options.ticks[i-1] : 0;
                                minp = (i > 0) ? this.options.ticks_positions[i-1] : 0;
                                maxv = this.options.ticks[i];
                                maxp = this.options.ticks_positions[i];

                                break;
                            }
                        }
                        if (i > 0) {
                            var partialPercentage = (value - minv) / (maxv - minv);
                            return minp + partialPercentage * (maxp - minp);
                        }
                    }

                    return 100 * (value - this.options.min) / (this.options.max - this.options.min);
                }
            },

            logarithmic: {
                /* Based on http://stackoverflow.com/questions/846221/logarithmic-slider */
                toValue: function(percentage) {
                    var min = (this.options.min === 0) ? 0 : Math.log(this.options.min);
                    var max = Math.log(this.options.max);
                    var value = Math.exp(min + (max - min) * percentage / 100);
                    value = this.options.min + Math.round((value - this.options.min) / this.options.step) * this.options.step;
                    /* Rounding to the nearest step could exceed the min or
                     * max, so clip to those values. */
                    if (value < this.options.min) {
                        return this.options.min;
                    } else if (value > this.options.max) {
                        return this.options.max;
                    } else {
                        return value;
                    }
                },
                toPercentage: function(value) {
                    if (this.options.max === this.options.min) {
                        return 0;
                    } else {
                        var max = Math.log(this.options.max);
                        var min = this.options.min === 0 ? 0 : Math.log(this.options.min);
                        var v = value === 0 ? 0 : Math.log(value);
                        return 100 * (v - min) / (max - min);
                    }
                }
            }
        };


        /*************************************************

         CONSTRUCTOR

         **************************************************/
        Slider = function(element, options) {
            createNewSlider.call(this, element, options);
            return this;
        };

        function createNewSlider(element, options) {

            /*
             The internal state object is used to store data about the current 'state' of slider.

             This includes values such as the `value`, `enabled`, etc...
             */
            this._state = {
                value: null,
                enabled: null,
                offset: null,
                size: null,
                percentage: null,
                inDrag: false,
                over: false
            };


            if(typeof element === "string") {
                this.element = document.querySelector(element);
            } else if(element instanceof HTMLElement) {
                this.element = element;
            }

            /*************************************************

             Process Options

             **************************************************/
            options = options ? options : {};
            var optionTypes = Object.keys(this.defaultOptions);

            for(var i = 0; i < optionTypes.length; i++) {
                var optName = optionTypes[i];

                // First check if an option was passed in via the constructor
                var val = options[optName];
                // If no data attrib, then check data atrributes
                val = (typeof val !== 'undefined') ? val : getDataAttrib(this.element, optName);
                // Finally, if nothing was specified, use the defaults
                val = (val !== null) ? val : this.defaultOptions[optName];

                // Set all options on the instance of the Slider
                if(!this.options) {
                    this.options = {};
                }
                this.options[optName] = val;
            }

            /*
             Validate `tooltip_position` against 'orientation`
             - if `tooltip_position` is incompatible with orientation, swith it to a default compatible with specified `orientation`
             -- default for "vertical" -> "right"
             -- default for "horizontal" -> "left"
             */
            if(this.options.orientation === "vertical" && (this.options.tooltip_position === "top" || this.options.tooltip_position === "bottom")) {

                this.options.tooltip_position	= "right";

            }
            else if(this.options.orientation === "horizontal" && (this.options.tooltip_position === "left" || this.options.tooltip_position === "right")) {

                this.options.tooltip_position	= "top";

            }

            function getDataAttrib(element, optName) {
                var dataName = "data-slider-" + optName.replace(/_/g, '-');
                var dataValString = element.getAttribute(dataName);

                try {
                    return JSON.parse(dataValString);
                }
                catch(err) {
                    return dataValString;
                }
            }

            /*************************************************

             Create Markup

             **************************************************/

            var origWidth = this.element.style.width;
            var updateSlider = false;
            var parent = this.element.parentNode;
            var sliderTrackSelection;
            var sliderTrackLow, sliderTrackHigh;
            var sliderMinHandle;
            var sliderMaxHandle;

            if (this.sliderElem) {
                updateSlider = true;
            } else {
                /* Create elements needed for slider */
                this.sliderElem = document.createElement("div");
                this.sliderElem.className = "slider";

                /* Create slider track elements */
                var sliderTrack = document.createElement("div");
                sliderTrack.className = "slider-track";

                sliderTrackLow = document.createElement("div");
                sliderTrackLow.className = "slider-track-low";

                sliderTrackSelection = document.createElement("div");
                sliderTrackSelection.className = "slider-selection";

                sliderTrackHigh = document.createElement("div");
                sliderTrackHigh.className = "slider-track-high";

                sliderMinHandle = document.createElement("div");
                sliderMinHandle.className = "slider-handle min-slider-handle";
                sliderMinHandle.setAttribute('role', 'slider');
                sliderMinHandle.setAttribute('aria-valuemin', this.options.min);
                sliderMinHandle.setAttribute('aria-valuemax', this.options.max);

                sliderMaxHandle = document.createElement("div");
                sliderMaxHandle.className = "slider-handle max-slider-handle";
                sliderMaxHandle.setAttribute('role', 'slider');
                sliderMaxHandle.setAttribute('aria-valuemin', this.options.min);
                sliderMaxHandle.setAttribute('aria-valuemax', this.options.max);

                sliderTrack.appendChild(sliderTrackLow);
                sliderTrack.appendChild(sliderTrackSelection);
                sliderTrack.appendChild(sliderTrackHigh);

                /* Add aria-labelledby to handle's */
                var isLabelledbyArray = Array.isArray(this.options.labelledby);
                if (isLabelledbyArray && this.options.labelledby[0]) {
                    sliderMinHandle.setAttribute('aria-labelledby', this.options.labelledby[0]);
                }
                if (isLabelledbyArray && this.options.labelledby[1]) {
                    sliderMaxHandle.setAttribute('aria-labelledby', this.options.labelledby[1]);
                }
                if (!isLabelledbyArray && this.options.labelledby) {
                    sliderMinHandle.setAttribute('aria-labelledby', this.options.labelledby);
                    sliderMaxHandle.setAttribute('aria-labelledby', this.options.labelledby);
                }

                /* Create ticks */
                this.ticks = [];
                if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {
                    for (i = 0; i < this.options.ticks.length; i++) {
                        var tick = document.createElement('div');
                        tick.className = 'slider-tick';

                        this.ticks.push(tick);
                        sliderTrack.appendChild(tick);
                    }

                    sliderTrackSelection.className += " tick-slider-selection";
                }

                sliderTrack.appendChild(sliderMinHandle);
                sliderTrack.appendChild(sliderMaxHandle);

                this.tickLabels = [];
                if (Array.isArray(this.options.ticks_labels) && this.options.ticks_labels.length > 0) {
                    this.tickLabelContainer = document.createElement('div');
                    this.tickLabelContainer.className = 'slider-tick-label-container';

                    for (i = 0; i < this.options.ticks_labels.length; i++) {
                        var label = document.createElement('div');
                        var noTickPositionsSpecified = this.options.ticks_positions.length === 0;
                        var tickLabelsIndex = (this.options.reversed && noTickPositionsSpecified) ? (this.options.ticks_labels.length - (i + 1)) : i;
                        label.className = 'slider-tick-label';
                        label.innerHTML = this.options.ticks_labels[tickLabelsIndex];

                        this.tickLabels.push(label);
                        this.tickLabelContainer.appendChild(label);
                    }
                }


                var createAndAppendTooltipSubElements = function(tooltipElem) {
                    var arrow = document.createElement("div");
                    arrow.className = "tooltip-arrow";

                    var inner = document.createElement("div");
                    inner.className = "tooltip-inner";

                    tooltipElem.appendChild(arrow);
                    tooltipElem.appendChild(inner);

                };

                /* Create tooltip elements */
                var sliderTooltip = document.createElement("div");
                sliderTooltip.className = "tooltip tooltip-main";
                sliderTooltip.setAttribute('role', 'presentation');
                createAndAppendTooltipSubElements(sliderTooltip);

                var sliderTooltipMin = document.createElement("div");
                sliderTooltipMin.className = "tooltip tooltip-min";
                sliderTooltipMin.setAttribute('role', 'presentation');
                createAndAppendTooltipSubElements(sliderTooltipMin);

                var sliderTooltipMax = document.createElement("div");
                sliderTooltipMax.className = "tooltip tooltip-max";
                sliderTooltipMax.setAttribute('role', 'presentation');
                createAndAppendTooltipSubElements(sliderTooltipMax);


                /* Append components to sliderElem */
                this.sliderElem.appendChild(sliderTrack);
                this.sliderElem.appendChild(sliderTooltip);
                this.sliderElem.appendChild(sliderTooltipMin);
                this.sliderElem.appendChild(sliderTooltipMax);

                if (this.tickLabelContainer) {
                    this.sliderElem.appendChild(this.tickLabelContainer);
                }

                /* Append slider element to parent container, right before the original <input> element */
                parent.insertBefore(this.sliderElem, this.element);

                /* Hide original <input> element */
                this.element.style.display = "none";
            }
            /* If JQuery exists, cache JQ references */
            if($) {
                this.$element = $(this.element);
                this.$sliderElem = $(this.sliderElem);
            }

            /*************************************************

             Setup

             **************************************************/
            this.eventToCallbackMap = {};
            this.sliderElem.id = this.options.id;

            this.touchCapable = 'ontouchstart' in window || (window.DocumentTouch && document instanceof window.DocumentTouch);

            this.tooltip = this.sliderElem.querySelector('.tooltip-main');
            this.tooltipInner = this.tooltip.querySelector('.tooltip-inner');

            this.tooltip_min = this.sliderElem.querySelector('.tooltip-min');
            this.tooltipInner_min = this.tooltip_min.querySelector('.tooltip-inner');

            this.tooltip_max = this.sliderElem.querySelector('.tooltip-max');
            this.tooltipInner_max= this.tooltip_max.querySelector('.tooltip-inner');

            if (SliderScale[this.options.scale]) {
                this.options.scale = SliderScale[this.options.scale];
            }

            if (updateSlider === true) {
                // Reset classes
                this._removeClass(this.sliderElem, 'slider-horizontal');
                this._removeClass(this.sliderElem, 'slider-vertical');
                this._removeClass(this.tooltip, 'hide');
                this._removeClass(this.tooltip_min, 'hide');
                this._removeClass(this.tooltip_max, 'hide');

                // Undo existing inline styles for track
                ["left", "top", "width", "height"].forEach(function(prop) {
                    this._removeProperty(this.trackLow, prop);
                    this._removeProperty(this.trackSelection, prop);
                    this._removeProperty(this.trackHigh, prop);
                }, this);

                // Undo inline styles on handles
                [this.handle1, this.handle2].forEach(function(handle) {
                    this._removeProperty(handle, 'left');
                    this._removeProperty(handle, 'top');
                }, this);

                // Undo inline styles and classes on tooltips
                [this.tooltip, this.tooltip_min, this.tooltip_max].forEach(function(tooltip) {
                    this._removeProperty(tooltip, 'left');
                    this._removeProperty(tooltip, 'top');
                    this._removeProperty(tooltip, 'margin-left');
                    this._removeProperty(tooltip, 'margin-top');

                    this._removeClass(tooltip, 'right');
                    this._removeClass(tooltip, 'top');
                }, this);
            }

            if(this.options.orientation === 'vertical') {
                this._addClass(this.sliderElem,'slider-vertical');
                this.stylePos = 'top';
                this.mousePos = 'pageY';
                this.sizePos = 'offsetHeight';
            } else {
                this._addClass(this.sliderElem, 'slider-horizontal');
                this.sliderElem.style.width = origWidth;
                this.options.orientation = 'horizontal';
                this.stylePos = 'left';
                this.mousePos = 'pageX';
                this.sizePos = 'offsetWidth';

            }
            this._setTooltipPosition();
            /* In case ticks are specified, overwrite the min and max bounds */
            if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {
                this.options.max = Math.max.apply(Math, this.options.ticks);
                this.options.min = Math.min.apply(Math, this.options.ticks);
            }

            if (Array.isArray(this.options.value)) {
                this.options.range = true;
                this._state.value = this.options.value;
            }
            else if (this.options.range) {
                // User wants a range, but value is not an array
                this._state.value = [this.options.value, this.options.max];
            }
            else {
                this._state.value = this.options.value;
            }

            this.trackLow = sliderTrackLow || this.trackLow;
            this.trackSelection = sliderTrackSelection || this.trackSelection;
            this.trackHigh = sliderTrackHigh || this.trackHigh;

            if (this.options.selection === 'none') {
                this._addClass(this.trackLow, 'hide');
                this._addClass(this.trackSelection, 'hide');
                this._addClass(this.trackHigh, 'hide');
            }

            this.handle1 = sliderMinHandle || this.handle1;
            this.handle2 = sliderMaxHandle || this.handle2;

            if (updateSlider === true) {
                // Reset classes
                this._removeClass(this.handle1, 'round triangle');
                this._removeClass(this.handle2, 'round triangle hide');

                for (i = 0; i < this.ticks.length; i++) {
                    this._removeClass(this.ticks[i], 'round triangle hide');
                }
            }

            var availableHandleModifiers = ['round', 'triangle', 'custom'];
            var isValidHandleType = availableHandleModifiers.indexOf(this.options.handle) !== -1;
            if (isValidHandleType) {
                this._addClass(this.handle1, this.options.handle);
                this._addClass(this.handle2, this.options.handle);

                for (i = 0; i < this.ticks.length; i++) {
                    this._addClass(this.ticks[i], this.options.handle);
                }
            }

            this._state.offset = this._offset(this.sliderElem);
            this._state.size = this.sliderElem[this.sizePos];
            this.setValue(this._state.value);

            /******************************************

             Bind Event Listeners

             ******************************************/

            // Bind keyboard handlers
            this.handle1Keydown = this._keydown.bind(this, 0);
            this.handle1.addEventListener("keydown", this.handle1Keydown, false);

            this.handle2Keydown = this._keydown.bind(this, 1);
            this.handle2.addEventListener("keydown", this.handle2Keydown, false);

            this.mousedown = this._mousedown.bind(this);
            if (this.touchCapable) {
                // Bind touch handlers
                this.sliderElem.addEventListener("touchstart", this.mousedown, false);
            }
            this.sliderElem.addEventListener("mousedown", this.mousedown, false);


            // Bind tooltip-related handlers
            if(this.options.tooltip === 'hide') {
                this._addClass(this.tooltip, 'hide');
                this._addClass(this.tooltip_min, 'hide');
                this._addClass(this.tooltip_max, 'hide');
            }
            else if(this.options.tooltip === 'always') {
                this._showTooltip();
                this._alwaysShowTooltip = true;
            }
            else {
                this.showTooltip = this._showTooltip.bind(this);
                this.hideTooltip = this._hideTooltip.bind(this);

                this.sliderElem.addEventListener("mouseenter", this.showTooltip, false);
                this.sliderElem.addEventListener("mouseleave", this.hideTooltip, false);

                this.handle1.addEventListener("focus", this.showTooltip, false);
                this.handle1.addEventListener("blur", this.hideTooltip, false);

                this.handle2.addEventListener("focus", this.showTooltip, false);
                this.handle2.addEventListener("blur", this.hideTooltip, false);
            }

            if(this.options.enabled) {
                this.enable();
            } else {
                this.disable();
            }
        }



        /*************************************************

         INSTANCE PROPERTIES/METHODS

         - Any methods bound to the prototype are considered
         part of the plugin's `public` interface

         **************************************************/
        Slider.prototype = {
            _init: function() {}, // NOTE: Must exist to support bridget

            constructor: Slider,

            defaultOptions: {
                id: "",
                min: 0,
                max: 10,
                step: 1,
                precision: 0,
                orientation: 'horizontal',
                value: 5,
                range: false,
                selection: 'before',
                tooltip: 'show',
                tooltip_split: false,
                handle: 'round',
                reversed: false,
                enabled: true,
                formatter: function(val) {
                    if (Array.isArray(val)) {
                        return val[0] + " : " + val[1];
                    } else {
                        return val;
                    }
                },
                natural_arrow_keys: false,
                ticks: [],
                ticks_positions: [],
                ticks_labels: [],
                ticks_snap_bounds: 0,
                scale: 'linear',
                focus: false,
                tooltip_position: null,
                labelledby: null
            },

            getElement: function() {
                return this.sliderElem;
            },

            getValue: function() {
                if (this.options.range) {
                    return this._state.value;
                }
                else {
                    return this._state.value[0];
                }
            },

            setValue: function(val, triggerSlideEvent, triggerChangeEvent) {
                if (!val) {
                    val = 0;
                }
                var oldValue = this.getValue();
                this._state.value = this._validateInputValue(val);
                var applyPrecision = this._applyPrecision.bind(this);

                if (this.options.range) {
                    this._state.value[0] = applyPrecision(this._state.value[0]);
                    this._state.value[1] = applyPrecision(this._state.value[1]);

                    this._state.value[0] = Math.max(this.options.min, Math.min(this.options.max, this._state.value[0]));
                    this._state.value[1] = Math.max(this.options.min, Math.min(this.options.max, this._state.value[1]));
                }
                else {
                    this._state.value = applyPrecision(this._state.value);
                    this._state.value = [ Math.max(this.options.min, Math.min(this.options.max, this._state.value))];
                    this._addClass(this.handle2, 'hide');
                    if (this.options.selection === 'after') {
                        this._state.value[1] = this.options.max;
                    } else {
                        this._state.value[1] = this.options.min;
                    }
                }

                if (this.options.max > this.options.min) {
                    this._state.percentage = [
                        this._toPercentage(this._state.value[0]),
                        this._toPercentage(this._state.value[1]),
                        this.options.step * 100 / (this.options.max - this.options.min)
                    ];
                } else {
                    this._state.percentage = [0, 0, 100];
                }

                this._layout();
                var newValue = this.options.range ? this._state.value : this._state.value[0];

                if(triggerSlideEvent === true) {
                    this._trigger('slide', newValue);
                }
                if( (oldValue !== newValue) && (triggerChangeEvent === true) ) {
                    this._trigger('change', {
                        oldValue: oldValue,
                        newValue: newValue
                    });
                }
                this._setDataVal(newValue);

                return this;
            },

            destroy: function(){
                // Remove event handlers on slider elements
                this._removeSliderEventHandlers();

                // Remove the slider from the DOM
                this.sliderElem.parentNode.removeChild(this.sliderElem);
                /* Show original <input> element */
                this.element.style.display = "";

                // Clear out custom event bindings
                this._cleanUpEventCallbacksMap();

                // Remove data values
                this.element.removeAttribute("data");

                // Remove JQuery handlers/data
                if($) {
                    this._unbindJQueryEventHandlers();
                    this.$element.removeData('slider');
                }
            },

            disable: function() {
                this._state.enabled = false;
                this.handle1.removeAttribute("tabindex");
                this.handle2.removeAttribute("tabindex");
                this._addClass(this.sliderElem, 'slider-disabled');
                this._trigger('slideDisabled');

                return this;
            },

            enable: function() {
                this._state.enabled = true;
                this.handle1.setAttribute("tabindex", 0);
                this.handle2.setAttribute("tabindex", 0);
                this._removeClass(this.sliderElem, 'slider-disabled');
                this._trigger('slideEnabled');

                return this;
            },

            toggle: function() {
                if(this._state.enabled) {
                    this.disable();
                } else {
                    this.enable();
                }
                return this;
            },

            isEnabled: function() {
                return this._state.enabled;
            },

            on: function(evt, callback) {
                this._bindNonQueryEventHandler(evt, callback);
                return this;
            },

            off: function(evt, callback) {
                if($) {
                    this.$element.off(evt, callback);
                    this.$sliderElem.off(evt, callback);
                } else {
                    this._unbindNonQueryEventHandler(evt, callback);
                }
            },

            getAttribute: function(attribute) {
                if(attribute) {
                    return this.options[attribute];
                } else {
                    return this.options;
                }
            },

            setAttribute: function(attribute, value) {
                this.options[attribute] = value;
                return this;
            },

            refresh: function() {
                this._removeSliderEventHandlers();
                createNewSlider.call(this, this.element, this.options);
                if($) {
                    // Bind new instance of slider to the element
                    $.data(this.element, 'slider', this);
                }
                return this;
            },

            relayout: function() {
                this._layout();
                return this;
            },

            /******************************+

             HELPERS

             - Any method that is not part of the public interface.
             - Place it underneath this comment block and write its signature like so:

             _fnName : function() {...}

             ********************************/
            _removeSliderEventHandlers: function() {
                // Remove keydown event listeners
                this.handle1.removeEventListener("keydown", this.handle1Keydown, false);
                this.handle2.removeEventListener("keydown", this.handle2Keydown, false);

                if (this.showTooltip) {
                    this.handle1.removeEventListener("focus", this.showTooltip, false);
                    this.handle2.removeEventListener("focus", this.showTooltip, false);
                }
                if (this.hideTooltip) {
                    this.handle1.removeEventListener("blur", this.hideTooltip, false);
                    this.handle2.removeEventListener("blur", this.hideTooltip, false);
                }

                // Remove event listeners from sliderElem
                if (this.showTooltip) {
                    this.sliderElem.removeEventListener("mouseenter", this.showTooltip, false);
                }
                if (this.hideTooltip) {
                    this.sliderElem.removeEventListener("mouseleave", this.hideTooltip, false);
                }
                this.sliderElem.removeEventListener("touchstart", this.mousedown, false);
                this.sliderElem.removeEventListener("mousedown", this.mousedown, false);
            },
            _bindNonQueryEventHandler: function(evt, callback) {
                if(this.eventToCallbackMap[evt] === undefined) {
                    this.eventToCallbackMap[evt] = [];
                }
                this.eventToCallbackMap[evt].push(callback);
            },
            _unbindNonQueryEventHandler: function(evt, callback) {
                var callbacks = this.eventToCallbackMap[evt];
                if(callbacks !== undefined) {
                    for (var i = 0; i < callbacks.length; i++) {
                        if (callbacks[i] === callback) {
                            callbacks.splice(i, 1);
                            break;
                        }
                    }
                }
            },
            _cleanUpEventCallbacksMap: function() {
                var eventNames = Object.keys(this.eventToCallbackMap);
                for(var i = 0; i < eventNames.length; i++) {
                    var eventName = eventNames[i];
                    this.eventToCallbackMap[eventName] = null;
                }
            },
            _showTooltip: function() {
                if (this.options.tooltip_split === false ){
                    this._addClass(this.tooltip, 'in');
                    this.tooltip_min.style.display = 'none';
                    this.tooltip_max.style.display = 'none';
                } else {
                    this._addClass(this.tooltip_min, 'in');
                    this._addClass(this.tooltip_max, 'in');
                    this.tooltip.style.display = 'none';
                }
                this._state.over = true;
            },
            _hideTooltip: function() {
                if (this._state.inDrag === false && this.alwaysShowTooltip !== true) {
                    this._removeClass(this.tooltip, 'in');
                    this._removeClass(this.tooltip_min, 'in');
                    this._removeClass(this.tooltip_max, 'in');
                }
                this._state.over = false;
            },
            _layout: function() {
                var positionPercentages;

                if(this.options.reversed) {
                    positionPercentages = [ 100 - this._state.percentage[0], this.options.range ? 100 - this._state.percentage[1] : this._state.percentage[1]];
                }
                else {
                    positionPercentages = [ this._state.percentage[0], this._state.percentage[1] ];
                }

                this.handle1.style[this.stylePos] = positionPercentages[0]+'%';
                this.handle1.setAttribute('aria-valuenow', this._state.value[0]);

                this.handle2.style[this.stylePos] = positionPercentages[1]+'%';
                this.handle2.setAttribute('aria-valuenow', this._state.value[1]);

                /* Position ticks and labels */
                if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {

                    var styleSize = this.options.orientation === 'vertical' ? 'height' : 'width';
                    var styleMargin = this.options.orientation === 'vertical' ? 'marginTop' : 'marginLeft';
                    var labelSize = this._state.size / (this.options.ticks.length - 1);

                    if (this.tickLabelContainer) {
                        var extraMargin = 0;
                        if (this.options.ticks_positions.length === 0) {
                            if (this.options.orientation !== 'vertical') {
                                this.tickLabelContainer.style[styleMargin] = -labelSize/2 + 'px';
                            }

                            extraMargin = this.tickLabelContainer.offsetHeight;
                        } else {
                            /* Chidren are position absolute, calculate height by finding the max offsetHeight of a child */
                            for (i = 0 ; i < this.tickLabelContainer.childNodes.length; i++) {
                                if (this.tickLabelContainer.childNodes[i].offsetHeight > extraMargin) {
                                    extraMargin = this.tickLabelContainer.childNodes[i].offsetHeight;
                                }
                            }
                        }
                        if (this.options.orientation === 'horizontal') {
                            this.sliderElem.style.marginBottom = extraMargin + 'px';
                        }
                    }
                    for (var i = 0; i < this.options.ticks.length; i++) {

                        var percentage = this.options.ticks_positions[i] || this._toPercentage(this.options.ticks[i]);

                        if (this.options.reversed) {
                            percentage = 100 - percentage;
                        }

                        this.ticks[i].style[this.stylePos] = percentage + '%';

                        /* Set class labels to denote whether ticks are in the selection */
                        this._removeClass(this.ticks[i], 'in-selection');
                        if (!this.options.range) {
                            if (this.options.selection === 'after' && percentage >= positionPercentages[0]){
                                this._addClass(this.ticks[i], 'in-selection');
                            } else if (this.options.selection === 'before' && percentage <= positionPercentages[0]) {
                                this._addClass(this.ticks[i], 'in-selection');
                            }
                        } else if (percentage >= positionPercentages[0] && percentage <= positionPercentages[1]) {
                            this._addClass(this.ticks[i], 'in-selection');
                        }

                        if (this.tickLabels[i]) {
                            this.tickLabels[i].style[styleSize] = labelSize + 'px';

                            if (this.options.orientation !== 'vertical' && this.options.ticks_positions[i] !== undefined) {
                                this.tickLabels[i].style.position = 'absolute';
                                this.tickLabels[i].style[this.stylePos] = percentage + '%';
                                this.tickLabels[i].style[styleMargin] = -labelSize/2 + 'px';
                            } else if (this.options.orientation === 'vertical') {
                                this.tickLabels[i].style['marginLeft'] =  this.sliderElem.offsetWidth + 'px';
                                this.tickLabelContainer.style['marginTop'] = this.sliderElem.offsetWidth / 2 * -1 + 'px';
                            }
                        }
                    }
                }

                var formattedTooltipVal;

                if (this.options.range) {
                    formattedTooltipVal = this.options.formatter(this._state.value);
                    this._setText(this.tooltipInner, formattedTooltipVal);
                    this.tooltip.style[this.stylePos] = (positionPercentages[1] + positionPercentages[0])/2 + '%';

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip, 'margin-top', -this.tooltip.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip, 'margin-left', -this.tooltip.offsetWidth / 2 + 'px');
                    }

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip, 'margin-top', -this.tooltip.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip, 'margin-left', -this.tooltip.offsetWidth / 2 + 'px');
                    }

                    var innerTooltipMinText = this.options.formatter(this._state.value[0]);
                    this._setText(this.tooltipInner_min, innerTooltipMinText);

                    var innerTooltipMaxText = this.options.formatter(this._state.value[1]);
                    this._setText(this.tooltipInner_max, innerTooltipMaxText);

                    this.tooltip_min.style[this.stylePos] = positionPercentages[0] + '%';

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip_min, 'margin-top', -this.tooltip_min.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip_min, 'margin-left', -this.tooltip_min.offsetWidth / 2 + 'px');
                    }

                    this.tooltip_max.style[this.stylePos] = positionPercentages[1] + '%';

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip_max, 'margin-top', -this.tooltip_max.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip_max, 'margin-left', -this.tooltip_max.offsetWidth / 2 + 'px');
                    }
                } else {
                    formattedTooltipVal = this.options.formatter(this._state.value[0]);
                    this._setText(this.tooltipInner, formattedTooltipVal);

                    this.tooltip.style[this.stylePos] = positionPercentages[0] + '%';
                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip, 'margin-top', -this.tooltip.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip, 'margin-left', -this.tooltip.offsetWidth / 2 + 'px');
                    }
                }

                if (this.options.orientation === 'vertical') {
                    this.trackLow.style.top = '0';
                    this.trackLow.style.height = Math.min(positionPercentages[0], positionPercentages[1]) +'%';

                    this.trackSelection.style.top = Math.min(positionPercentages[0], positionPercentages[1]) +'%';
                    this.trackSelection.style.height = Math.abs(positionPercentages[0] - positionPercentages[1]) +'%';

                    this.trackHigh.style.bottom = '0';
                    this.trackHigh.style.height = (100 - Math.min(positionPercentages[0], positionPercentages[1]) - Math.abs(positionPercentages[0] - positionPercentages[1])) +'%';
                }
                else {
                    this.trackLow.style.left = '0';
                    this.trackLow.style.width = Math.min(positionPercentages[0], positionPercentages[1]) +'%';

                    this.trackSelection.style.left = Math.min(positionPercentages[0], positionPercentages[1]) +'%';
                    this.trackSelection.style.width = Math.abs(positionPercentages[0] - positionPercentages[1]) +'%';

                    this.trackHigh.style.right = '0';
                    this.trackHigh.style.width = (100 - Math.min(positionPercentages[0], positionPercentages[1]) - Math.abs(positionPercentages[0] - positionPercentages[1])) +'%';

                    var offset_min = this.tooltip_min.getBoundingClientRect();
                    var offset_max = this.tooltip_max.getBoundingClientRect();

                    if (offset_min.right > offset_max.left) {
                        this._removeClass(this.tooltip_max, 'top');
                        this._addClass(this.tooltip_max, 'bottom');
                        this.tooltip_max.style.top = 18 + 'px';
                    } else {
                        this._removeClass(this.tooltip_max, 'bottom');
                        this._addClass(this.tooltip_max, 'top');
                        this.tooltip_max.style.top = this.tooltip_min.style.top;
                    }
                }
            },
            _removeProperty: function(element, prop) {
                if (element.style.removeProperty) {
                    element.style.removeProperty(prop);
                } else {
                    element.style.removeAttribute(prop);
                }
            },
            _mousedown: function(ev) {
                if(!this._state.enabled) {
                    return false;
                }

                this._state.offset = this._offset(this.sliderElem);
                this._state.size = this.sliderElem[this.sizePos];

                var percentage = this._getPercentage(ev);

                if (this.options.range) {
                    var diff1 = Math.abs(this._state.percentage[0] - percentage);
                    var diff2 = Math.abs(this._state.percentage[1] - percentage);
                    this._state.dragged = (diff1 < diff2) ? 0 : 1;
                } else {
                    this._state.dragged = 0;
                }

                this._state.percentage[this._state.dragged] = percentage;
                this._layout();

                if (this.touchCapable) {
                    document.removeEventListener("touchmove", this.mousemove, false);
                    document.removeEventListener("touchend", this.mouseup, false);
                }

                if(this.mousemove){
                    document.removeEventListener("mousemove", this.mousemove, false);
                }
                if(this.mouseup){
                    document.removeEventListener("mouseup", this.mouseup, false);
                }

                this.mousemove = this._mousemove.bind(this);
                this.mouseup = this._mouseup.bind(this);

                if (this.touchCapable) {
                    // Touch: Bind touch events:
                    document.addEventListener("touchmove", this.mousemove, false);
                    document.addEventListener("touchend", this.mouseup, false);
                }
                // Bind mouse events:
                document.addEventListener("mousemove", this.mousemove, false);
                document.addEventListener("mouseup", this.mouseup, false);

                this._state.inDrag = true;
                var newValue = this._calculateValue();

                this._trigger('slideStart', newValue);

                this._setDataVal(newValue);
                this.setValue(newValue, false, true);

                this._pauseEvent(ev);

                if (this.options.focus) {
                    this._triggerFocusOnHandle(this._state.dragged);
                }

                return true;
            },
            _triggerFocusOnHandle: function(handleIdx) {
                if(handleIdx === 0) {
                    this.handle1.focus();
                }
                if(handleIdx === 1) {
                    this.handle2.focus();
                }
            },
            _keydown: function(handleIdx, ev) {
                if(!this._state.enabled) {
                    return false;
                }

                var dir;
                switch (ev.keyCode) {
                    case 37: // left
                    case 40: // down
                        dir = -1;
                        break;
                    case 39: // right
                    case 38: // up
                        dir = 1;
                        break;
                }
                if (!dir) {
                    return;
                }

                // use natural arrow keys instead of from min to max
                if (this.options.natural_arrow_keys) {
                    var ifVerticalAndNotReversed = (this.options.orientation === 'vertical' && !this.options.reversed);
                    var ifHorizontalAndReversed = (this.options.orientation === 'horizontal' && this.options.reversed);

                    if (ifVerticalAndNotReversed || ifHorizontalAndReversed) {
                        dir = -dir;
                    }
                }

                var val = this._state.value[handleIdx] + dir * this.options.step;
                if (this.options.range) {
                    val = [ (!handleIdx) ? val : this._state.value[0],
                        ( handleIdx) ? val : this._state.value[1]];
                }

                this._trigger('slideStart', val);
                this._setDataVal(val);
                this.setValue(val, true, true);

                this._setDataVal(val);
                this._trigger('slideStop', val);
                this._layout();

                this._pauseEvent(ev);

                return false;
            },
            _pauseEvent: function(ev) {
                if(ev.stopPropagation) {
                    ev.stopPropagation();
                }
                if(ev.preventDefault) {
                    ev.preventDefault();
                }
                ev.cancelBubble=true;
                ev.returnValue=false;
            },
            _mousemove: function(ev) {
                if(!this._state.enabled) {
                    return false;
                }

                var percentage = this._getPercentage(ev);
                this._adjustPercentageForRangeSliders(percentage);
                this._state.percentage[this._state.dragged] = percentage;
                this._layout();

                var val = this._calculateValue(true);
                this.setValue(val, true, true);

                return false;
            },
            _adjustPercentageForRangeSliders: function(percentage) {
                if (this.options.range) {
                    var precision = this._getNumDigitsAfterDecimalPlace(percentage);
                    precision = precision ? precision - 1 : 0;
                    var percentageWithAdjustedPrecision = this._applyToFixedAndParseFloat(percentage, precision);
                    if (this._state.dragged === 0 && this._applyToFixedAndParseFloat(this._state.percentage[1], precision) < percentageWithAdjustedPrecision) {
                        this._state.percentage[0] = this._state.percentage[1];
                        this._state.dragged = 1;
                    } else if (this._state.dragged === 1 && this._applyToFixedAndParseFloat(this._state.percentage[0], precision) > percentageWithAdjustedPrecision) {
                        this._state.percentage[1] = this._state.percentage[0];
                        this._state.dragged = 0;
                    }
                }
            },
            _mouseup: function() {
                if(!this._state.enabled) {
                    return false;
                }
                if (this.touchCapable) {
                    // Touch: Unbind touch event handlers:
                    document.removeEventListener("touchmove", this.mousemove, false);
                    document.removeEventListener("touchend", this.mouseup, false);
                }
                // Unbind mouse event handlers:
                document.removeEventListener("mousemove", this.mousemove, false);
                document.removeEventListener("mouseup", this.mouseup, false);

                this._state.inDrag = false;
                if (this._state.over === false) {
                    this._hideTooltip();
                }
                var val = this._calculateValue(true);

                this._layout();
                this._setDataVal(val);
                this._trigger('slideStop', val);

                return false;
            },
            _calculateValue: function(snapToClosestTick) {
                var val;
                if (this.options.range) {
                    val = [this.options.min,this.options.max];
                    if (this._state.percentage[0] !== 0){
                        val[0] = this._toValue(this._state.percentage[0]);
                        val[0] = this._applyPrecision(val[0]);
                    }
                    if (this._state.percentage[1] !== 100){
                        val[1] = this._toValue(this._state.percentage[1]);
                        val[1] = this._applyPrecision(val[1]);
                    }
                } else {
                    val = this._toValue(this._state.percentage[0]);
                    val = parseFloat(val);
                    val = this._applyPrecision(val);
                }

                if (snapToClosestTick) {
                    var min = [val, Infinity];
                    for (var i = 0; i < this.options.ticks.length; i++) {
                        var diff = Math.abs(this.options.ticks[i] - val);
                        if (diff <= min[1]) {
                            min = [this.options.ticks[i], diff];
                        }
                    }
                    if (min[1] <= this.options.ticks_snap_bounds) {
                        return min[0];
                    }
                }

                return val;
            },
            _applyPrecision: function(val) {
                var precision = this.options.precision || this._getNumDigitsAfterDecimalPlace(this.options.step);
                return this._applyToFixedAndParseFloat(val, precision);
            },
            _getNumDigitsAfterDecimalPlace: function(num) {
                var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if (!match) { return 0; }
                return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
            },
            _applyToFixedAndParseFloat: function(num, toFixedInput) {
                var truncatedNum = num.toFixed(toFixedInput);
                return parseFloat(truncatedNum);
            },
            /*
             Credits to Mike Samuel for the following method!
             Source: http://stackoverflow.com/questions/10454518/javascript-how-to-retrieve-the-number-of-decimals-of-a-string-number
             */
            _getPercentage: function(ev) {
                if (this.touchCapable && (ev.type === 'touchstart' || ev.type === 'touchmove')) {
                    ev = ev.touches[0];
                }

                var eventPosition = ev[this.mousePos];
                var sliderOffset = this._state.offset[this.stylePos];
                var distanceToSlide = eventPosition - sliderOffset;
                // Calculate what percent of the length the slider handle has slid
                var percentage = (distanceToSlide / this._state.size) * 100;
                percentage = Math.round(percentage / this._state.percentage[2]) * this._state.percentage[2];
                if (this.options.reversed) {
                    percentage = 100 - percentage;
                }

                // Make sure the percent is within the bounds of the slider.
                // 0% corresponds to the 'min' value of the slide
                // 100% corresponds to the 'max' value of the slide
                return Math.max(0, Math.min(100, percentage));
            },
            _validateInputValue: function(val) {
                if (typeof val === 'number') {
                    return val;
                } else if (Array.isArray(val)) {
                    this._validateArray(val);
                    return val;
                } else {
                    throw new Error( ErrorMsgs.formatInvalidInputErrorMsg(val) );
                }
            },
            _validateArray: function(val) {
                for(var i = 0; i < val.length; i++) {
                    var input =  val[i];
                    if (typeof input !== 'number') { throw new Error( ErrorMsgs.formatInvalidInputErrorMsg(input) ); }
                }
            },
            _setDataVal: function(val) {
                this.element.setAttribute('data-value', val);
                this.element.setAttribute('value', val);
                this.element.value = val;
            },
            _trigger: function(evt, val) {
                val = (val || val === 0) ? val : undefined;

                var callbackFnArray = this.eventToCallbackMap[evt];
                if(callbackFnArray && callbackFnArray.length) {
                    for(var i = 0; i < callbackFnArray.length; i++) {
                        var callbackFn = callbackFnArray[i];
                        callbackFn(val);
                    }
                }

                /* If JQuery exists, trigger JQuery events */
                if($) {
                    this._triggerJQueryEvent(evt, val);
                }
            },
            _triggerJQueryEvent: function(evt, val) {
                var eventData = {
                    type: evt,
                    value: val
                };
                this.$element.trigger(eventData);
                this.$sliderElem.trigger(eventData);
            },
            _unbindJQueryEventHandlers: function() {
                this.$element.off();
                this.$sliderElem.off();
            },
            _setText: function(element, text) {
                if(typeof element.innerText !== "undefined") {
                    element.innerText = text;
                } else if(typeof element.textContent !== "undefined") {
                    element.textContent = text;
                }
            },
            _removeClass: function(element, classString) {
                var classes = classString.split(" ");
                var newClasses = element.className;

                for(var i = 0; i < classes.length; i++) {
                    var classTag = classes[i];
                    var regex = new RegExp("(?:\\s|^)" + classTag + "(?:\\s|$)");
                    newClasses = newClasses.replace(regex, " ");
                }

                element.className = newClasses.trim();
            },
            _addClass: function(element, classString) {
                var classes = classString.split(" ");
                var newClasses = element.className;

                for(var i = 0; i < classes.length; i++) {
                    var classTag = classes[i];
                    var regex = new RegExp("(?:\\s|^)" + classTag + "(?:\\s|$)");
                    var ifClassExists = regex.test(newClasses);

                    if(!ifClassExists) {
                        newClasses += " " + classTag;
                    }
                }

                element.className = newClasses.trim();
            },
            _offsetLeft: function(obj){
                return obj.getBoundingClientRect().left;
            },
            _offsetTop: function(obj){
                var offsetTop = obj.offsetTop;
                while((obj = obj.offsetParent) && !isNaN(obj.offsetTop)){
                    offsetTop += obj.offsetTop;
                }
                return offsetTop;
            },
            _offset: function (obj) {
                return {
                    left: this._offsetLeft(obj),
                    top: this._offsetTop(obj)
                };
            },
            _css: function(elementRef, styleName, value) {
                if ($) {
                    $.style(elementRef, styleName, value);
                } else {
                    var style = styleName.replace(/^-ms-/, "ms-").replace(/-([\da-z])/gi, function (all, letter) {
                        return letter.toUpperCase();
                    });
                    elementRef.style[style] = value;
                }
            },
            _toValue: function(percentage) {
                return this.options.scale.toValue.apply(this, [percentage]);
            },
            _toPercentage: function(value) {
                return this.options.scale.toPercentage.apply(this, [value]);
            },
            _setTooltipPosition: function(){
                var tooltips = [this.tooltip, this.tooltip_min, this.tooltip_max];
                if (this.options.orientation === 'vertical'){
                    var tooltipPos = this.options.tooltip_position || 'right';
                    var oppositeSide = (tooltipPos === 'left') ? 'right' : 'left';
                    tooltips.forEach(function(tooltip){
                        this._addClass(tooltip, tooltipPos);
                        tooltip.style[oppositeSide] = '100%';
                    }.bind(this));
                } else if(this.options.tooltip_position === 'bottom') {
                    tooltips.forEach(function(tooltip){
                        this._addClass(tooltip, 'bottom');
                        tooltip.style.top = 22 + 'px';
                    }.bind(this));
                } else {
                    tooltips.forEach(function(tooltip){
                        this._addClass(tooltip, 'top');
                        tooltip.style.top = -this.tooltip.outerHeight - 14 + 'px';
                    }.bind(this));
                }
            }
        };

        /*********************************

         Attach to global namespace

         *********************************/
        if($) {
            var namespace = $.fn.slider ? 'bootstrapSlider' : 'slider';
            $.bridget(namespace, Slider);
        }

    })( $ );

    return Slider;
}));


/*
 * jquery-match-height 0.7.2 by @liabru
 * http://brm.io/jquery-match-height/
 * License MIT
 */

/*
!function(t){"use strict";"function"==typeof define&&define.amd?define(["jquery"],t):"undefined"!=typeof module&&module.exports?module.exports=t(require("jquery")):t(jQuery)}(function(t){var e=-1,o=-1,n=function(t){return parseFloat(t)||0},a=function(e){var o=1,a=t(e),i=null,r=[];return a.each(function(){var e=t(this),a=e.offset().top-n(e.css("margin-top")),s=r.length>0?r[r.length-1]:null;null===s?r.push(e):Math.floor(Math.abs(i-a))<=o?r[r.length-1]=s.add(e):r.push(e),i=a}),r},i=function(e){var o={
    byRow:!0,property:"height",target:null,remove:!1};return"object"==typeof e?t.extend(o,e):("boolean"==typeof e?o.byRow=e:"remove"===e&&(o.remove=!0),o)},r=t.fn.matchHeight=function(e){var o=i(e);if(o.remove){var n=this;return this.css(o.property,""),t.each(r._groups,function(t,e){e.elements=e.elements.not(n)}),this}return this.length<=1&&!o.target?this:(r._groups.push({elements:this,options:o}),r._apply(this,o),this)};r.version="0.7.2",r._groups=[],r._throttle=80,r._maintainScroll=!1,r._beforeUpdate=null,
    r._afterUpdate=null,r._rows=a,r._parse=n,r._parseOptions=i,r._apply=function(e,o){var s=i(o),h=t(e),l=[h],c=t(window).scrollTop(),p=t("html").outerHeight(!0),u=h.parents().filter(":hidden");return u.each(function(){var e=t(this);e.data("style-cache",e.attr("style"))}),u.css("display","block"),s.byRow&&!s.target&&(h.each(function(){var e=t(this),o=e.css("display");"inline-block"!==o&&"flex"!==o&&"inline-flex"!==o&&(o="block"),e.data("style-cache",e.attr("style")),e.css({display:o,"padding-top":"0",
    "padding-bottom":"0","margin-top":"0","margin-bottom":"0","border-top-width":"0","border-bottom-width":"0",height:"100px",overflow:"hidden"})}),l=a(h),h.each(function(){var e=t(this);e.attr("style",e.data("style-cache")||"")})),t.each(l,function(e,o){var a=t(o),i=0;if(s.target)i=s.target.outerHeight(!1);else{if(s.byRow&&a.length<=1)return void a.css(s.property,"");a.each(function(){var e=t(this),o=e.attr("style"),n=e.css("display");"inline-block"!==n&&"flex"!==n&&"inline-flex"!==n&&(n="block");var a={
    display:n};a[s.property]="",e.css(a),e.outerHeight(!1)>i&&(i=e.outerHeight(!1)),o?e.attr("style",o):e.css("display","")})}a.each(function(){var e=t(this),o=0;s.target&&e.is(s.target)||("border-box"!==e.css("box-sizing")&&(o+=n(e.css("border-top-width"))+n(e.css("border-bottom-width")),o+=n(e.css("padding-top"))+n(e.css("padding-bottom"))),e.css(s.property,i-o+"px"))})}),u.each(function(){var e=t(this);e.attr("style",e.data("style-cache")||null)}),r._maintainScroll&&t(window).scrollTop(c/p*t("html").outerHeight(!0)),
    this},r._applyDataApi=function(){var e={};t("[data-match-height], [data-mh]").each(function(){var o=t(this),n=o.attr("data-mh")||o.attr("data-match-height");n in e?e[n]=e[n].add(o):e[n]=o}),t.each(e,function(){this.matchHeight(!0)})};var s=function(e){r._beforeUpdate&&r._beforeUpdate(e,r._groups),t.each(r._groups,function(){r._apply(this.elements,this.options)}),r._afterUpdate&&r._afterUpdate(e,r._groups)};r._update=function(n,a){if(a&&"resize"===a.type){var i=t(window).width();if(i===e)return;e=i;
}n?o===-1&&(o=setTimeout(function(){s(a),o=-1},r._throttle)):s(a)},t(r._applyDataApi);var h=t.fn.on?"on":"bind";t(window)[h]("load",function(t){r._update(!1,t)}),t(window)[h]("resize orientationchange",function(t){r._update(!0,t)})});

$(function() {
   setEqualHeight();
});

function setEqualHeight() {
    $('.equal-height').matchHeight();
    $('.equal-height-img').matchHeight();
    $('.equal-height-meta').matchHeight();
}
*/
/*! =========================================================
 * bootstrap-slider.js
 *
 * Maintainers:
 *		Kyle Kemp
 *			- Twitter: @seiyria
 *			- Github:  seiyria
 *		Rohit Kalkur
 *			- Twitter: @Rovolutionary
 *			- Github:  rovolution
 *
 * =========================================================
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */


/**
 * Bridget makes jQuery widgets
 * v1.0.1
 * MIT license
 */

(function(root, factory) {
    if(typeof define === "function" && define.amd) {
        define(["jquery"], factory);
    }
    else if(typeof module === "object" && module.exports) {
        var jQuery;
        try {
            jQuery = require("jquery");
        }
        catch (err) {
            jQuery = null;
        }
        module.exports = factory(jQuery);
    }
    else {
        root.Slider = factory(root.jQuery);
    }
}(this, function($) {
    // Reference to Slider constructor
    var Slider;


    (function( $ ) {

        'use strict';

        // -------------------------- utils -------------------------- //

        var slice = Array.prototype.slice;

        function noop() {}

        // -------------------------- definition -------------------------- //

        function defineBridget( $ ) {

            // bail if no jQuery
            if ( !$ ) {
                return;
            }

            // -------------------------- addOptionMethod -------------------------- //

            /**
             * adds option method -> $().plugin('option', {...})
             * @param {Function} PluginClass - constructor class
             */
            function addOptionMethod( PluginClass ) {
                // don't overwrite original option method
                if ( PluginClass.prototype.option ) {
                    return;
                }

                // option setter
                PluginClass.prototype.option = function( opts ) {
                    // bail out if not an object
                    if ( !$.isPlainObject( opts ) ){
                        return;
                    }
                    this.options = $.extend( true, this.options, opts );
                };
            }


            // -------------------------- plugin bridge -------------------------- //

            // helper function for logging errors
            // $.error breaks jQuery chaining
            var logError = typeof console === 'undefined' ? noop :
                function( message ) {
                    console.error( message );
                };

            /**
             * jQuery plugin bridge, access methods like $elem.plugin('method')
             * @param {String} namespace - plugin name
             * @param {Function} PluginClass - constructor class
             */
            function bridge( namespace, PluginClass ) {
                // add to jQuery fn namespace
                $.fn[ namespace ] = function( options ) {
                    if ( typeof options === 'string' ) {
                        // call plugin method when first argument is a string
                        // get arguments for method
                        var args = slice.call( arguments, 1 );

                        for ( var i=0, len = this.length; i < len; i++ ) {
                            var elem = this[i];
                            var instance = $.data( elem, namespace );
                            if ( !instance ) {
                                logError( "cannot call methods on " + namespace + " prior to initialization; " +
                                    "attempted to call '" + options + "'" );
                                continue;
                            }
                            if ( !$.isFunction( instance[options] ) || options.charAt(0) === '_' ) {
                                logError( "no such method '" + options + "' for " + namespace + " instance" );
                                continue;
                            }

                            // trigger method with arguments
                            var returnValue = instance[ options ].apply( instance, args);

                            // break look and return first value if provided
                            if ( returnValue !== undefined && returnValue !== instance) {
                                return returnValue;
                            }
                        }
                        // return this if no return value
                        return this;
                    } else {
                        var objects = this.map( function() {
                            var instance = $.data( this, namespace );
                            if ( instance ) {
                                // apply options & init
                                instance.option( options );
                                instance._init();
                            } else {
                                // initialize new instance
                                instance = new PluginClass( this, options );
                                $.data( this, namespace, instance );
                            }
                            return $(this);
                        });

                        if(!objects || objects.length > 1) {
                            return objects;
                        } else {
                            return objects[0];
                        }
                    }
                };

            }

            // -------------------------- bridget -------------------------- //

            /**
             * converts a Prototypical class into a proper jQuery plugin
             *   the class must have a ._init method
             * @param {String} namespace - plugin name, used in $().pluginName
             * @param {Function} PluginClass - constructor class
             */
            $.bridget = function( namespace, PluginClass ) {
                addOptionMethod( PluginClass );
                bridge( namespace, PluginClass );
            };

            return $.bridget;

        }

        // get jquery from browser global
        defineBridget( $ );

    })( $ );


    /*************************************************

     BOOTSTRAP-SLIDER SOURCE CODE

     **************************************************/

    (function($) {

        var ErrorMsgs = {
            formatInvalidInputErrorMsg : function(input) {
                return "Invalid input value '" + input + "' passed in";
            },
            callingContextNotSliderInstance : "Calling context element does not have instance of Slider bound to it. Check your code to make sure the JQuery object returned from the call to the slider() initializer is calling the method"
        };

        var SliderScale = {
            linear: {
                toValue: function(percentage) {
                    var rawValue = percentage/100 * (this.options.max - this.options.min);
                    if (this.options.ticks_positions.length > 0) {
                        var minv, maxv, minp, maxp = 0;
                        for (var i = 0; i < this.options.ticks_positions.length; i++) {
                            if (percentage <= this.options.ticks_positions[i]) {
                                minv = (i > 0) ? this.options.ticks[i-1] : 0;
                                minp = (i > 0) ? this.options.ticks_positions[i-1] : 0;
                                maxv = this.options.ticks[i];
                                maxp = this.options.ticks_positions[i];

                                break;
                            }
                        }
                        if (i > 0) {
                            var partialPercentage = (percentage - minp) / (maxp - minp);
                            rawValue = minv + partialPercentage * (maxv - minv);
                        }
                    }

                    var value = this.options.min + Math.round(rawValue / this.options.step) * this.options.step;
                    if (value < this.options.min) {
                        return this.options.min;
                    } else if (value > this.options.max) {
                        return this.options.max;
                    } else {
                        return value;
                    }
                },
                toPercentage: function(value) {
                    if (this.options.max === this.options.min) {
                        return 0;
                    }

                    if (this.options.ticks_positions.length > 0) {
                        var minv, maxv, minp, maxp = 0;
                        for (var i = 0; i < this.options.ticks.length; i++) {
                            if (value  <= this.options.ticks[i]) {
                                minv = (i > 0) ? this.options.ticks[i-1] : 0;
                                minp = (i > 0) ? this.options.ticks_positions[i-1] : 0;
                                maxv = this.options.ticks[i];
                                maxp = this.options.ticks_positions[i];

                                break;
                            }
                        }
                        if (i > 0) {
                            var partialPercentage = (value - minv) / (maxv - minv);
                            return minp + partialPercentage * (maxp - minp);
                        }
                    }

                    return 100 * (value - this.options.min) / (this.options.max - this.options.min);
                }
            },

            logarithmic: {
                /* Based on http://stackoverflow.com/questions/846221/logarithmic-slider */
                toValue: function(percentage) {
                    var min = (this.options.min === 0) ? 0 : Math.log(this.options.min);
                    var max = Math.log(this.options.max);
                    var value = Math.exp(min + (max - min) * percentage / 100);
                    value = this.options.min + Math.round((value - this.options.min) / this.options.step) * this.options.step;
                    /* Rounding to the nearest step could exceed the min or
                     * max, so clip to those values. */
                    if (value < this.options.min) {
                        return this.options.min;
                    } else if (value > this.options.max) {
                        return this.options.max;
                    } else {
                        return value;
                    }
                },
                toPercentage: function(value) {
                    if (this.options.max === this.options.min) {
                        return 0;
                    } else {
                        var max = Math.log(this.options.max);
                        var min = this.options.min === 0 ? 0 : Math.log(this.options.min);
                        var v = value === 0 ? 0 : Math.log(value);
                        return 100 * (v - min) / (max - min);
                    }
                }
            }
        };


        /*************************************************

         CONSTRUCTOR

         **************************************************/
        Slider = function(element, options) {
            createNewSlider.call(this, element, options);
            return this;
        };

        function createNewSlider(element, options) {

            /*
             The internal state object is used to store data about the current 'state' of slider.

             This includes values such as the `value`, `enabled`, etc...
             */
            this._state = {
                value: null,
                enabled: null,
                offset: null,
                size: null,
                percentage: null,
                inDrag: false,
                over: false
            };


            if(typeof element === "string") {
                this.element = document.querySelector(element);
            } else if(element instanceof HTMLElement) {
                this.element = element;
            }

            /*************************************************

             Process Options

             **************************************************/
            options = options ? options : {};
            var optionTypes = Object.keys(this.defaultOptions);

            for(var i = 0; i < optionTypes.length; i++) {
                var optName = optionTypes[i];

                // First check if an option was passed in via the constructor
                var val = options[optName];
                // If no data attrib, then check data atrributes
                val = (typeof val !== 'undefined') ? val : getDataAttrib(this.element, optName);
                // Finally, if nothing was specified, use the defaults
                val = (val !== null) ? val : this.defaultOptions[optName];

                // Set all options on the instance of the Slider
                if(!this.options) {
                    this.options = {};
                }
                this.options[optName] = val;
            }

            /*
             Validate `tooltip_position` against 'orientation`
             - if `tooltip_position` is incompatible with orientation, swith it to a default compatible with specified `orientation`
             -- default for "vertical" -> "right"
             -- default for "horizontal" -> "left"
             */
            if(this.options.orientation === "vertical" && (this.options.tooltip_position === "top" || this.options.tooltip_position === "bottom")) {

                this.options.tooltip_position	= "right";

            }
            else if(this.options.orientation === "horizontal" && (this.options.tooltip_position === "left" || this.options.tooltip_position === "right")) {

                this.options.tooltip_position	= "top";

            }

            function getDataAttrib(element, optName) {
                var dataName = "data-slider-" + optName.replace(/_/g, '-');
                var dataValString = element.getAttribute(dataName);

                try {
                    return JSON.parse(dataValString);
                }
                catch(err) {
                    return dataValString;
                }
            }

            /*************************************************

             Create Markup

             **************************************************/

            var origWidth = this.element.style.width;
            var updateSlider = false;
            var parent = this.element.parentNode;
            var sliderTrackSelection;
            var sliderTrackLow, sliderTrackHigh;
            var sliderMinHandle;
            var sliderMaxHandle;

            if (this.sliderElem) {
                updateSlider = true;
            } else {
                /* Create elements needed for slider */
                this.sliderElem = document.createElement("div");
                this.sliderElem.className = "slider";

                /* Create slider track elements */
                var sliderTrack = document.createElement("div");
                sliderTrack.className = "slider-track";

                sliderTrackLow = document.createElement("div");
                sliderTrackLow.className = "slider-track-low";

                sliderTrackSelection = document.createElement("div");
                sliderTrackSelection.className = "slider-selection";

                sliderTrackHigh = document.createElement("div");
                sliderTrackHigh.className = "slider-track-high";

                sliderMinHandle = document.createElement("div");
                sliderMinHandle.className = "slider-handle min-slider-handle";
                sliderMinHandle.setAttribute('role', 'slider');
                sliderMinHandle.setAttribute('aria-valuemin', this.options.min);
                sliderMinHandle.setAttribute('aria-valuemax', this.options.max);

                sliderMaxHandle = document.createElement("div");
                sliderMaxHandle.className = "slider-handle max-slider-handle";
                sliderMaxHandle.setAttribute('role', 'slider');
                sliderMaxHandle.setAttribute('aria-valuemin', this.options.min);
                sliderMaxHandle.setAttribute('aria-valuemax', this.options.max);

                sliderTrack.appendChild(sliderTrackLow);
                sliderTrack.appendChild(sliderTrackSelection);
                sliderTrack.appendChild(sliderTrackHigh);

                /* Add aria-labelledby to handle's */
                var isLabelledbyArray = Array.isArray(this.options.labelledby);
                if (isLabelledbyArray && this.options.labelledby[0]) {
                    sliderMinHandle.setAttribute('aria-labelledby', this.options.labelledby[0]);
                }
                if (isLabelledbyArray && this.options.labelledby[1]) {
                    sliderMaxHandle.setAttribute('aria-labelledby', this.options.labelledby[1]);
                }
                if (!isLabelledbyArray && this.options.labelledby) {
                    sliderMinHandle.setAttribute('aria-labelledby', this.options.labelledby);
                    sliderMaxHandle.setAttribute('aria-labelledby', this.options.labelledby);
                }

                /* Create ticks */
                this.ticks = [];
                if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {
                    for (i = 0; i < this.options.ticks.length; i++) {
                        var tick = document.createElement('div');
                        tick.className = 'slider-tick';

                        this.ticks.push(tick);
                        sliderTrack.appendChild(tick);
                    }

                    sliderTrackSelection.className += " tick-slider-selection";
                }

                sliderTrack.appendChild(sliderMinHandle);
                sliderTrack.appendChild(sliderMaxHandle);

                this.tickLabels = [];
                if (Array.isArray(this.options.ticks_labels) && this.options.ticks_labels.length > 0) {
                    this.tickLabelContainer = document.createElement('div');
                    this.tickLabelContainer.className = 'slider-tick-label-container';

                    for (i = 0; i < this.options.ticks_labels.length; i++) {
                        var label = document.createElement('div');
                        var noTickPositionsSpecified = this.options.ticks_positions.length === 0;
                        var tickLabelsIndex = (this.options.reversed && noTickPositionsSpecified) ? (this.options.ticks_labels.length - (i + 1)) : i;
                        label.className = 'slider-tick-label';
                        label.innerHTML = this.options.ticks_labels[tickLabelsIndex];

                        this.tickLabels.push(label);
                        this.tickLabelContainer.appendChild(label);
                    }
                }


                var createAndAppendTooltipSubElements = function(tooltipElem) {
                    var arrow = document.createElement("div");
                    arrow.className = "tooltip-arrow";

                    var inner = document.createElement("div");
                    inner.className = "tooltip-inner";

                    tooltipElem.appendChild(arrow);
                    tooltipElem.appendChild(inner);

                };

                /* Create tooltip elements */
                var sliderTooltip = document.createElement("div");
                sliderTooltip.className = "tooltip tooltip-main";
                sliderTooltip.setAttribute('role', 'presentation');
                createAndAppendTooltipSubElements(sliderTooltip);

                var sliderTooltipMin = document.createElement("div");
                sliderTooltipMin.className = "tooltip tooltip-min";
                sliderTooltipMin.setAttribute('role', 'presentation');
                createAndAppendTooltipSubElements(sliderTooltipMin);

                var sliderTooltipMax = document.createElement("div");
                sliderTooltipMax.className = "tooltip tooltip-max";
                sliderTooltipMax.setAttribute('role', 'presentation');
                createAndAppendTooltipSubElements(sliderTooltipMax);


                /* Append components to sliderElem */
                this.sliderElem.appendChild(sliderTrack);
                this.sliderElem.appendChild(sliderTooltip);
                this.sliderElem.appendChild(sliderTooltipMin);
                this.sliderElem.appendChild(sliderTooltipMax);

                if (this.tickLabelContainer) {
                    this.sliderElem.appendChild(this.tickLabelContainer);
                }

                /* Append slider element to parent container, right before the original <input> element */
                parent.insertBefore(this.sliderElem, this.element);

                /* Hide original <input> element */
                this.element.style.display = "none";
            }
            /* If JQuery exists, cache JQ references */
            if($) {
                this.$element = $(this.element);
                this.$sliderElem = $(this.sliderElem);
            }

            /*************************************************

             Setup

             **************************************************/
            this.eventToCallbackMap = {};
            this.sliderElem.id = this.options.id;

            this.touchCapable = 'ontouchstart' in window || (window.DocumentTouch && document instanceof window.DocumentTouch);

            this.tooltip = this.sliderElem.querySelector('.tooltip-main');
            this.tooltipInner = this.tooltip.querySelector('.tooltip-inner');

            this.tooltip_min = this.sliderElem.querySelector('.tooltip-min');
            this.tooltipInner_min = this.tooltip_min.querySelector('.tooltip-inner');

            this.tooltip_max = this.sliderElem.querySelector('.tooltip-max');
            this.tooltipInner_max= this.tooltip_max.querySelector('.tooltip-inner');

            if (SliderScale[this.options.scale]) {
                this.options.scale = SliderScale[this.options.scale];
            }

            if (updateSlider === true) {
                // Reset classes
                this._removeClass(this.sliderElem, 'slider-horizontal');
                this._removeClass(this.sliderElem, 'slider-vertical');
                this._removeClass(this.tooltip, 'hide');
                this._removeClass(this.tooltip_min, 'hide');
                this._removeClass(this.tooltip_max, 'hide');

                // Undo existing inline styles for track
                ["left", "top", "width", "height"].forEach(function(prop) {
                    this._removeProperty(this.trackLow, prop);
                    this._removeProperty(this.trackSelection, prop);
                    this._removeProperty(this.trackHigh, prop);
                }, this);

                // Undo inline styles on handles
                [this.handle1, this.handle2].forEach(function(handle) {
                    this._removeProperty(handle, 'left');
                    this._removeProperty(handle, 'top');
                }, this);

                // Undo inline styles and classes on tooltips
                [this.tooltip, this.tooltip_min, this.tooltip_max].forEach(function(tooltip) {
                    this._removeProperty(tooltip, 'left');
                    this._removeProperty(tooltip, 'top');
                    this._removeProperty(tooltip, 'margin-left');
                    this._removeProperty(tooltip, 'margin-top');

                    this._removeClass(tooltip, 'right');
                    this._removeClass(tooltip, 'top');
                }, this);
            }

            if(this.options.orientation === 'vertical') {
                this._addClass(this.sliderElem,'slider-vertical');
                this.stylePos = 'top';
                this.mousePos = 'pageY';
                this.sizePos = 'offsetHeight';
            } else {
                this._addClass(this.sliderElem, 'slider-horizontal');
                this.sliderElem.style.width = origWidth;
                this.options.orientation = 'horizontal';
                this.stylePos = 'left';
                this.mousePos = 'pageX';
                this.sizePos = 'offsetWidth';

            }
            this._setTooltipPosition();
            /* In case ticks are specified, overwrite the min and max bounds */
            if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {
                this.options.max = Math.max.apply(Math, this.options.ticks);
                this.options.min = Math.min.apply(Math, this.options.ticks);
            }

            if (Array.isArray(this.options.value)) {
                this.options.range = true;
                this._state.value = this.options.value;
            }
            else if (this.options.range) {
                // User wants a range, but value is not an array
                this._state.value = [this.options.value, this.options.max];
            }
            else {
                this._state.value = this.options.value;
            }

            this.trackLow = sliderTrackLow || this.trackLow;
            this.trackSelection = sliderTrackSelection || this.trackSelection;
            this.trackHigh = sliderTrackHigh || this.trackHigh;

            if (this.options.selection === 'none') {
                this._addClass(this.trackLow, 'hide');
                this._addClass(this.trackSelection, 'hide');
                this._addClass(this.trackHigh, 'hide');
            }

            this.handle1 = sliderMinHandle || this.handle1;
            this.handle2 = sliderMaxHandle || this.handle2;

            if (updateSlider === true) {
                // Reset classes
                this._removeClass(this.handle1, 'round triangle');
                this._removeClass(this.handle2, 'round triangle hide');

                for (i = 0; i < this.ticks.length; i++) {
                    this._removeClass(this.ticks[i], 'round triangle hide');
                }
            }

            var availableHandleModifiers = ['round', 'triangle', 'custom'];
            var isValidHandleType = availableHandleModifiers.indexOf(this.options.handle) !== -1;
            if (isValidHandleType) {
                this._addClass(this.handle1, this.options.handle);
                this._addClass(this.handle2, this.options.handle);

                for (i = 0; i < this.ticks.length; i++) {
                    this._addClass(this.ticks[i], this.options.handle);
                }
            }

            this._state.offset = this._offset(this.sliderElem);
            this._state.size = this.sliderElem[this.sizePos];
            this.setValue(this._state.value);

            /******************************************

             Bind Event Listeners

             ******************************************/

            // Bind keyboard handlers
            this.handle1Keydown = this._keydown.bind(this, 0);
            this.handle1.addEventListener("keydown", this.handle1Keydown, false);

            this.handle2Keydown = this._keydown.bind(this, 1);
            this.handle2.addEventListener("keydown", this.handle2Keydown, false);

            this.mousedown = this._mousedown.bind(this);
            if (this.touchCapable) {
                // Bind touch handlers
                this.sliderElem.addEventListener("touchstart", this.mousedown, false);
            }
            this.sliderElem.addEventListener("mousedown", this.mousedown, false);


            // Bind tooltip-related handlers
            if(this.options.tooltip === 'hide') {
                this._addClass(this.tooltip, 'hide');
                this._addClass(this.tooltip_min, 'hide');
                this._addClass(this.tooltip_max, 'hide');
            }
            else if(this.options.tooltip === 'always') {
                this._showTooltip();
                this._alwaysShowTooltip = true;
            }
            else {
                this.showTooltip = this._showTooltip.bind(this);
                this.hideTooltip = this._hideTooltip.bind(this);

                this.sliderElem.addEventListener("mouseenter", this.showTooltip, false);
                this.sliderElem.addEventListener("mouseleave", this.hideTooltip, false);

                this.handle1.addEventListener("focus", this.showTooltip, false);
                this.handle1.addEventListener("blur", this.hideTooltip, false);

                this.handle2.addEventListener("focus", this.showTooltip, false);
                this.handle2.addEventListener("blur", this.hideTooltip, false);
            }

            if(this.options.enabled) {
                this.enable();
            } else {
                this.disable();
            }
        }



        /*************************************************

         INSTANCE PROPERTIES/METHODS

         - Any methods bound to the prototype are considered
         part of the plugin's `public` interface

         **************************************************/
        Slider.prototype = {
            _init: function() {}, // NOTE: Must exist to support bridget

            constructor: Slider,

            defaultOptions: {
                id: "",
                min: 0,
                max: 10,
                step: 1,
                precision: 0,
                orientation: 'horizontal',
                value: 5,
                range: false,
                selection: 'before',
                tooltip: 'show',
                tooltip_split: false,
                handle: 'round',
                reversed: false,
                enabled: true,
                formatter: function(val) {
                    if (Array.isArray(val)) {
                        return val[0] + " : " + val[1];
                    } else {
                        return val;
                    }
                },
                natural_arrow_keys: false,
                ticks: [],
                ticks_positions: [],
                ticks_labels: [],
                ticks_snap_bounds: 0,
                scale: 'linear',
                focus: false,
                tooltip_position: null,
                labelledby: null
            },

            getElement: function() {
                return this.sliderElem;
            },

            getValue: function() {
                if (this.options.range) {
                    return this._state.value;
                }
                else {
                    return this._state.value[0];
                }
            },

            setValue: function(val, triggerSlideEvent, triggerChangeEvent) {
                if (!val) {
                    val = 0;
                }
                var oldValue = this.getValue();
                this._state.value = this._validateInputValue(val);
                var applyPrecision = this._applyPrecision.bind(this);

                if (this.options.range) {
                    this._state.value[0] = applyPrecision(this._state.value[0]);
                    this._state.value[1] = applyPrecision(this._state.value[1]);

                    this._state.value[0] = Math.max(this.options.min, Math.min(this.options.max, this._state.value[0]));
                    this._state.value[1] = Math.max(this.options.min, Math.min(this.options.max, this._state.value[1]));
                }
                else {
                    this._state.value = applyPrecision(this._state.value);
                    this._state.value = [ Math.max(this.options.min, Math.min(this.options.max, this._state.value))];
                    this._addClass(this.handle2, 'hide');
                    if (this.options.selection === 'after') {
                        this._state.value[1] = this.options.max;
                    } else {
                        this._state.value[1] = this.options.min;
                    }
                }

                if (this.options.max > this.options.min) {
                    this._state.percentage = [
                        this._toPercentage(this._state.value[0]),
                        this._toPercentage(this._state.value[1]),
                        this.options.step * 100 / (this.options.max - this.options.min)
                    ];
                } else {
                    this._state.percentage = [0, 0, 100];
                }

                this._layout();
                var newValue = this.options.range ? this._state.value : this._state.value[0];

                if(triggerSlideEvent === true) {
                    this._trigger('slide', newValue);
                }
                if( (oldValue !== newValue) && (triggerChangeEvent === true) ) {
                    this._trigger('change', {
                        oldValue: oldValue,
                        newValue: newValue
                    });
                }
                this._setDataVal(newValue);

                return this;
            },

            destroy: function(){
                // Remove event handlers on slider elements
                this._removeSliderEventHandlers();

                // Remove the slider from the DOM
                this.sliderElem.parentNode.removeChild(this.sliderElem);
                /* Show original <input> element */
                this.element.style.display = "";

                // Clear out custom event bindings
                this._cleanUpEventCallbacksMap();

                // Remove data values
                this.element.removeAttribute("data");

                // Remove JQuery handlers/data
                if($) {
                    this._unbindJQueryEventHandlers();
                    this.$element.removeData('slider');
                }
            },

            disable: function() {
                this._state.enabled = false;
                this.handle1.removeAttribute("tabindex");
                this.handle2.removeAttribute("tabindex");
                this._addClass(this.sliderElem, 'slider-disabled');
                this._trigger('slideDisabled');

                return this;
            },

            enable: function() {
                this._state.enabled = true;
                this.handle1.setAttribute("tabindex", 0);
                this.handle2.setAttribute("tabindex", 0);
                this._removeClass(this.sliderElem, 'slider-disabled');
                this._trigger('slideEnabled');

                return this;
            },

            toggle: function() {
                if(this._state.enabled) {
                    this.disable();
                } else {
                    this.enable();
                }
                return this;
            },

            isEnabled: function() {
                return this._state.enabled;
            },

            on: function(evt, callback) {
                this._bindNonQueryEventHandler(evt, callback);
                return this;
            },

            off: function(evt, callback) {
                if($) {
                    this.$element.off(evt, callback);
                    this.$sliderElem.off(evt, callback);
                } else {
                    this._unbindNonQueryEventHandler(evt, callback);
                }
            },

            getAttribute: function(attribute) {
                if(attribute) {
                    return this.options[attribute];
                } else {
                    return this.options;
                }
            },

            setAttribute: function(attribute, value) {
                this.options[attribute] = value;
                return this;
            },

            refresh: function() {
                this._removeSliderEventHandlers();
                createNewSlider.call(this, this.element, this.options);
                if($) {
                    // Bind new instance of slider to the element
                    $.data(this.element, 'slider', this);
                }
                return this;
            },

            relayout: function() {
                this._layout();
                return this;
            },

            /******************************+

             HELPERS

             - Any method that is not part of the public interface.
             - Place it underneath this comment block and write its signature like so:

             _fnName : function() {...}

             ********************************/
            _removeSliderEventHandlers: function() {
                // Remove keydown event listeners
                this.handle1.removeEventListener("keydown", this.handle1Keydown, false);
                this.handle2.removeEventListener("keydown", this.handle2Keydown, false);

                if (this.showTooltip) {
                    this.handle1.removeEventListener("focus", this.showTooltip, false);
                    this.handle2.removeEventListener("focus", this.showTooltip, false);
                }
                if (this.hideTooltip) {
                    this.handle1.removeEventListener("blur", this.hideTooltip, false);
                    this.handle2.removeEventListener("blur", this.hideTooltip, false);
                }

                // Remove event listeners from sliderElem
                if (this.showTooltip) {
                    this.sliderElem.removeEventListener("mouseenter", this.showTooltip, false);
                }
                if (this.hideTooltip) {
                    this.sliderElem.removeEventListener("mouseleave", this.hideTooltip, false);
                }
                this.sliderElem.removeEventListener("touchstart", this.mousedown, false);
                this.sliderElem.removeEventListener("mousedown", this.mousedown, false);
            },
            _bindNonQueryEventHandler: function(evt, callback) {
                if(this.eventToCallbackMap[evt] === undefined) {
                    this.eventToCallbackMap[evt] = [];
                }
                this.eventToCallbackMap[evt].push(callback);
            },
            _unbindNonQueryEventHandler: function(evt, callback) {
                var callbacks = this.eventToCallbackMap[evt];
                if(callbacks !== undefined) {
                    for (var i = 0; i < callbacks.length; i++) {
                        if (callbacks[i] === callback) {
                            callbacks.splice(i, 1);
                            break;
                        }
                    }
                }
            },
            _cleanUpEventCallbacksMap: function() {
                var eventNames = Object.keys(this.eventToCallbackMap);
                for(var i = 0; i < eventNames.length; i++) {
                    var eventName = eventNames[i];
                    this.eventToCallbackMap[eventName] = null;
                }
            },
            _showTooltip: function() {
                if (this.options.tooltip_split === false ){
                    this._addClass(this.tooltip, 'in');
                    this.tooltip_min.style.display = 'none';
                    this.tooltip_max.style.display = 'none';
                } else {
                    this._addClass(this.tooltip_min, 'in');
                    this._addClass(this.tooltip_max, 'in');
                    this.tooltip.style.display = 'none';
                }
                this._state.over = true;
            },
            _hideTooltip: function() {
                if (this._state.inDrag === false && this.alwaysShowTooltip !== true) {
                    this._removeClass(this.tooltip, 'in');
                    this._removeClass(this.tooltip_min, 'in');
                    this._removeClass(this.tooltip_max, 'in');
                }
                this._state.over = false;
            },
            _layout: function() {
                var positionPercentages;

                if(this.options.reversed) {
                    positionPercentages = [ 100 - this._state.percentage[0], this.options.range ? 100 - this._state.percentage[1] : this._state.percentage[1]];
                }
                else {
                    positionPercentages = [ this._state.percentage[0], this._state.percentage[1] ];
                }

                this.handle1.style[this.stylePos] = positionPercentages[0]+'%';
                this.handle1.setAttribute('aria-valuenow', this._state.value[0]);

                this.handle2.style[this.stylePos] = positionPercentages[1]+'%';
                this.handle2.setAttribute('aria-valuenow', this._state.value[1]);

                /* Position ticks and labels */
                if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {

                    var styleSize = this.options.orientation === 'vertical' ? 'height' : 'width';
                    var styleMargin = this.options.orientation === 'vertical' ? 'marginTop' : 'marginLeft';
                    var labelSize = this._state.size / (this.options.ticks.length - 1);

                    if (this.tickLabelContainer) {
                        var extraMargin = 0;
                        if (this.options.ticks_positions.length === 0) {
                            if (this.options.orientation !== 'vertical') {
                                this.tickLabelContainer.style[styleMargin] = -labelSize/2 + 'px';
                            }

                            extraMargin = this.tickLabelContainer.offsetHeight;
                        } else {
                            /* Chidren are position absolute, calculate height by finding the max offsetHeight of a child */
                            for (i = 0 ; i < this.tickLabelContainer.childNodes.length; i++) {
                                if (this.tickLabelContainer.childNodes[i].offsetHeight > extraMargin) {
                                    extraMargin = this.tickLabelContainer.childNodes[i].offsetHeight;
                                }
                            }
                        }
                        if (this.options.orientation === 'horizontal') {
                            this.sliderElem.style.marginBottom = extraMargin + 'px';
                        }
                    }
                    for (var i = 0; i < this.options.ticks.length; i++) {

                        var percentage = this.options.ticks_positions[i] || this._toPercentage(this.options.ticks[i]);

                        if (this.options.reversed) {
                            percentage = 100 - percentage;
                        }

                        this.ticks[i].style[this.stylePos] = percentage + '%';

                        /* Set class labels to denote whether ticks are in the selection */
                        this._removeClass(this.ticks[i], 'in-selection');
                        if (!this.options.range) {
                            if (this.options.selection === 'after' && percentage >= positionPercentages[0]){
                                this._addClass(this.ticks[i], 'in-selection');
                            } else if (this.options.selection === 'before' && percentage <= positionPercentages[0]) {
                                this._addClass(this.ticks[i], 'in-selection');
                            }
                        } else if (percentage >= positionPercentages[0] && percentage <= positionPercentages[1]) {
                            this._addClass(this.ticks[i], 'in-selection');
                        }

                        if (this.tickLabels[i]) {
                            this.tickLabels[i].style[styleSize] = labelSize + 'px';

                            if (this.options.orientation !== 'vertical' && this.options.ticks_positions[i] !== undefined) {
                                this.tickLabels[i].style.position = 'absolute';
                                this.tickLabels[i].style[this.stylePos] = percentage + '%';
                                this.tickLabels[i].style[styleMargin] = -labelSize/2 + 'px';
                            } else if (this.options.orientation === 'vertical') {
                                this.tickLabels[i].style['marginLeft'] =  this.sliderElem.offsetWidth + 'px';
                                this.tickLabelContainer.style['marginTop'] = this.sliderElem.offsetWidth / 2 * -1 + 'px';
                            }
                        }
                    }
                }

                var formattedTooltipVal;

                if (this.options.range) {
                    formattedTooltipVal = this.options.formatter(this._state.value);
                    this._setText(this.tooltipInner, formattedTooltipVal);
                    this.tooltip.style[this.stylePos] = (positionPercentages[1] + positionPercentages[0])/2 + '%';

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip, 'margin-top', -this.tooltip.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip, 'margin-left', -this.tooltip.offsetWidth / 2 + 'px');
                    }

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip, 'margin-top', -this.tooltip.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip, 'margin-left', -this.tooltip.offsetWidth / 2 + 'px');
                    }

                    var innerTooltipMinText = this.options.formatter(this._state.value[0]);
                    this._setText(this.tooltipInner_min, innerTooltipMinText);

                    var innerTooltipMaxText = this.options.formatter(this._state.value[1]);
                    this._setText(this.tooltipInner_max, innerTooltipMaxText);

                    this.tooltip_min.style[this.stylePos] = positionPercentages[0] + '%';

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip_min, 'margin-top', -this.tooltip_min.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip_min, 'margin-left', -this.tooltip_min.offsetWidth / 2 + 'px');
                    }

                    this.tooltip_max.style[this.stylePos] = positionPercentages[1] + '%';

                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip_max, 'margin-top', -this.tooltip_max.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip_max, 'margin-left', -this.tooltip_max.offsetWidth / 2 + 'px');
                    }
                } else {
                    formattedTooltipVal = this.options.formatter(this._state.value[0]);
                    this._setText(this.tooltipInner, formattedTooltipVal);

                    this.tooltip.style[this.stylePos] = positionPercentages[0] + '%';
                    if (this.options.orientation === 'vertical') {
                        this._css(this.tooltip, 'margin-top', -this.tooltip.offsetHeight / 2 + 'px');
                    } else {
                        this._css(this.tooltip, 'margin-left', -this.tooltip.offsetWidth / 2 + 'px');
                    }
                }

                if (this.options.orientation === 'vertical') {
                    this.trackLow.style.top = '0';
                    this.trackLow.style.height = Math.min(positionPercentages[0], positionPercentages[1]) +'%';

                    this.trackSelection.style.top = Math.min(positionPercentages[0], positionPercentages[1]) +'%';
                    this.trackSelection.style.height = Math.abs(positionPercentages[0] - positionPercentages[1]) +'%';

                    this.trackHigh.style.bottom = '0';
                    this.trackHigh.style.height = (100 - Math.min(positionPercentages[0], positionPercentages[1]) - Math.abs(positionPercentages[0] - positionPercentages[1])) +'%';
                }
                else {
                    this.trackLow.style.left = '0';
                    this.trackLow.style.width = Math.min(positionPercentages[0], positionPercentages[1]) +'%';

                    this.trackSelection.style.left = Math.min(positionPercentages[0], positionPercentages[1]) +'%';
                    this.trackSelection.style.width = Math.abs(positionPercentages[0] - positionPercentages[1]) +'%';

                    this.trackHigh.style.right = '0';
                    this.trackHigh.style.width = (100 - Math.min(positionPercentages[0], positionPercentages[1]) - Math.abs(positionPercentages[0] - positionPercentages[1])) +'%';

                    var offset_min = this.tooltip_min.getBoundingClientRect();
                    var offset_max = this.tooltip_max.getBoundingClientRect();

                    if (offset_min.right > offset_max.left) {
                        this._removeClass(this.tooltip_max, 'top');
                        this._addClass(this.tooltip_max, 'bottom');
                        this.tooltip_max.style.top = 18 + 'px';
                    } else {
                        this._removeClass(this.tooltip_max, 'bottom');
                        this._addClass(this.tooltip_max, 'top');
                        this.tooltip_max.style.top = this.tooltip_min.style.top;
                    }
                }
            },
            _removeProperty: function(element, prop) {
                if (element.style.removeProperty) {
                    element.style.removeProperty(prop);
                } else {
                    element.style.removeAttribute(prop);
                }
            },
            _mousedown: function(ev) {
                if(!this._state.enabled) {
                    return false;
                }

                this._state.offset = this._offset(this.sliderElem);
                this._state.size = this.sliderElem[this.sizePos];

                var percentage = this._getPercentage(ev);

                if (this.options.range) {
                    var diff1 = Math.abs(this._state.percentage[0] - percentage);
                    var diff2 = Math.abs(this._state.percentage[1] - percentage);
                    this._state.dragged = (diff1 < diff2) ? 0 : 1;
                } else {
                    this._state.dragged = 0;
                }

                this._state.percentage[this._state.dragged] = percentage;
                this._layout();

                if (this.touchCapable) {
                    document.removeEventListener("touchmove", this.mousemove, false);
                    document.removeEventListener("touchend", this.mouseup, false);
                }

                if(this.mousemove){
                    document.removeEventListener("mousemove", this.mousemove, false);
                }
                if(this.mouseup){
                    document.removeEventListener("mouseup", this.mouseup, false);
                }

                this.mousemove = this._mousemove.bind(this);
                this.mouseup = this._mouseup.bind(this);

                if (this.touchCapable) {
                    // Touch: Bind touch events:
                    document.addEventListener("touchmove", this.mousemove, false);
                    document.addEventListener("touchend", this.mouseup, false);
                }
                // Bind mouse events:
                document.addEventListener("mousemove", this.mousemove, false);
                document.addEventListener("mouseup", this.mouseup, false);

                this._state.inDrag = true;
                var newValue = this._calculateValue();

                this._trigger('slideStart', newValue);

                this._setDataVal(newValue);
                this.setValue(newValue, false, true);

                this._pauseEvent(ev);

                if (this.options.focus) {
                    this._triggerFocusOnHandle(this._state.dragged);
                }

                return true;
            },
            _triggerFocusOnHandle: function(handleIdx) {
                if(handleIdx === 0) {
                    this.handle1.focus();
                }
                if(handleIdx === 1) {
                    this.handle2.focus();
                }
            },
            _keydown: function(handleIdx, ev) {
                if(!this._state.enabled) {
                    return false;
                }

                var dir;
                switch (ev.keyCode) {
                    case 37: // left
                    case 40: // down
                        dir = -1;
                        break;
                    case 39: // right
                    case 38: // up
                        dir = 1;
                        break;
                }
                if (!dir) {
                    return;
                }

                // use natural arrow keys instead of from min to max
                if (this.options.natural_arrow_keys) {
                    var ifVerticalAndNotReversed = (this.options.orientation === 'vertical' && !this.options.reversed);
                    var ifHorizontalAndReversed = (this.options.orientation === 'horizontal' && this.options.reversed);

                    if (ifVerticalAndNotReversed || ifHorizontalAndReversed) {
                        dir = -dir;
                    }
                }

                var val = this._state.value[handleIdx] + dir * this.options.step;
                if (this.options.range) {
                    val = [ (!handleIdx) ? val : this._state.value[0],
                        ( handleIdx) ? val : this._state.value[1]];
                }

                this._trigger('slideStart', val);
                this._setDataVal(val);
                this.setValue(val, true, true);

                this._setDataVal(val);
                this._trigger('slideStop', val);
                this._layout();

                this._pauseEvent(ev);

                return false;
            },
            _pauseEvent: function(ev) {
                if(ev.stopPropagation) {
                    ev.stopPropagation();
                }
                if(ev.preventDefault) {
                    ev.preventDefault();
                }
                ev.cancelBubble=true;
                ev.returnValue=false;
            },
            _mousemove: function(ev) {
                if(!this._state.enabled) {
                    return false;
                }

                var percentage = this._getPercentage(ev);
                this._adjustPercentageForRangeSliders(percentage);
                this._state.percentage[this._state.dragged] = percentage;
                this._layout();

                var val = this._calculateValue(true);
                this.setValue(val, true, true);

                return false;
            },
            _adjustPercentageForRangeSliders: function(percentage) {
                if (this.options.range) {
                    var precision = this._getNumDigitsAfterDecimalPlace(percentage);
                    precision = precision ? precision - 1 : 0;
                    var percentageWithAdjustedPrecision = this._applyToFixedAndParseFloat(percentage, precision);
                    if (this._state.dragged === 0 && this._applyToFixedAndParseFloat(this._state.percentage[1], precision) < percentageWithAdjustedPrecision) {
                        this._state.percentage[0] = this._state.percentage[1];
                        this._state.dragged = 1;
                    } else if (this._state.dragged === 1 && this._applyToFixedAndParseFloat(this._state.percentage[0], precision) > percentageWithAdjustedPrecision) {
                        this._state.percentage[1] = this._state.percentage[0];
                        this._state.dragged = 0;
                    }
                }
            },
            _mouseup: function() {
                if(!this._state.enabled) {
                    return false;
                }
                if (this.touchCapable) {
                    // Touch: Unbind touch event handlers:
                    document.removeEventListener("touchmove", this.mousemove, false);
                    document.removeEventListener("touchend", this.mouseup, false);
                }
                // Unbind mouse event handlers:
                document.removeEventListener("mousemove", this.mousemove, false);
                document.removeEventListener("mouseup", this.mouseup, false);

                this._state.inDrag = false;
                if (this._state.over === false) {
                    this._hideTooltip();
                }
                var val = this._calculateValue(true);

                this._layout();
                this._setDataVal(val);
                this._trigger('slideStop', val);

                return false;
            },
            _calculateValue: function(snapToClosestTick) {
                var val;
                if (this.options.range) {
                    val = [this.options.min,this.options.max];
                    if (this._state.percentage[0] !== 0){
                        val[0] = this._toValue(this._state.percentage[0]);
                        val[0] = this._applyPrecision(val[0]);
                    }
                    if (this._state.percentage[1] !== 100){
                        val[1] = this._toValue(this._state.percentage[1]);
                        val[1] = this._applyPrecision(val[1]);
                    }
                } else {
                    val = this._toValue(this._state.percentage[0]);
                    val = parseFloat(val);
                    val = this._applyPrecision(val);
                }

                if (snapToClosestTick) {
                    var min = [val, Infinity];
                    for (var i = 0; i < this.options.ticks.length; i++) {
                        var diff = Math.abs(this.options.ticks[i] - val);
                        if (diff <= min[1]) {
                            min = [this.options.ticks[i], diff];
                        }
                    }
                    if (min[1] <= this.options.ticks_snap_bounds) {
                        return min[0];
                    }
                }

                return val;
            },
            _applyPrecision: function(val) {
                var precision = this.options.precision || this._getNumDigitsAfterDecimalPlace(this.options.step);
                return this._applyToFixedAndParseFloat(val, precision);
            },
            _getNumDigitsAfterDecimalPlace: function(num) {
                var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                if (!match) { return 0; }
                return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
            },
            _applyToFixedAndParseFloat: function(num, toFixedInput) {
                var truncatedNum = num.toFixed(toFixedInput);
                return parseFloat(truncatedNum);
            },
            /*
             Credits to Mike Samuel for the following method!
             Source: http://stackoverflow.com/questions/10454518/javascript-how-to-retrieve-the-number-of-decimals-of-a-string-number
             */
            _getPercentage: function(ev) {
                if (this.touchCapable && (ev.type === 'touchstart' || ev.type === 'touchmove')) {
                    ev = ev.touches[0];
                }

                var eventPosition = ev[this.mousePos];
                var sliderOffset = this._state.offset[this.stylePos];
                var distanceToSlide = eventPosition - sliderOffset;
                // Calculate what percent of the length the slider handle has slid
                var percentage = (distanceToSlide / this._state.size) * 100;
                percentage = Math.round(percentage / this._state.percentage[2]) * this._state.percentage[2];
                if (this.options.reversed) {
                    percentage = 100 - percentage;
                }

                // Make sure the percent is within the bounds of the slider.
                // 0% corresponds to the 'min' value of the slide
                // 100% corresponds to the 'max' value of the slide
                return Math.max(0, Math.min(100, percentage));
            },
            _validateInputValue: function(val) {
                if (typeof val === 'number') {
                    return val;
                } else if (Array.isArray(val)) {
                    this._validateArray(val);
                    return val;
                } else {
                    throw new Error( ErrorMsgs.formatInvalidInputErrorMsg(val) );
                }
            },
            _validateArray: function(val) {
                for(var i = 0; i < val.length; i++) {
                    var input =  val[i];
                    if (typeof input !== 'number') { throw new Error( ErrorMsgs.formatInvalidInputErrorMsg(input) ); }
                }
            },
            _setDataVal: function(val) {
                this.element.setAttribute('data-value', val);
                this.element.setAttribute('value', val);
                this.element.value = val;
            },
            _trigger: function(evt, val) {
                val = (val || val === 0) ? val : undefined;

                var callbackFnArray = this.eventToCallbackMap[evt];
                if(callbackFnArray && callbackFnArray.length) {
                    for(var i = 0; i < callbackFnArray.length; i++) {
                        var callbackFn = callbackFnArray[i];
                        callbackFn(val);
                    }
                }

                /* If JQuery exists, trigger JQuery events */
                if($) {
                    this._triggerJQueryEvent(evt, val);
                }
            },
            _triggerJQueryEvent: function(evt, val) {
                var eventData = {
                    type: evt,
                    value: val
                };
                this.$element.trigger(eventData);
                this.$sliderElem.trigger(eventData);
            },
            _unbindJQueryEventHandlers: function() {
                this.$element.off();
                this.$sliderElem.off();
            },
            _setText: function(element, text) {
                if(typeof element.innerText !== "undefined") {
                    element.innerText = text;
                } else if(typeof element.textContent !== "undefined") {
                    element.textContent = text;
                }
            },
            _removeClass: function(element, classString) {
                var classes = classString.split(" ");
                var newClasses = element.className;

                for(var i = 0; i < classes.length; i++) {
                    var classTag = classes[i];
                    var regex = new RegExp("(?:\\s|^)" + classTag + "(?:\\s|$)");
                    newClasses = newClasses.replace(regex, " ");
                }

                element.className = newClasses.trim();
            },
            _addClass: function(element, classString) {
                var classes = classString.split(" ");
                var newClasses = element.className;

                for(var i = 0; i < classes.length; i++) {
                    var classTag = classes[i];
                    var regex = new RegExp("(?:\\s|^)" + classTag + "(?:\\s|$)");
                    var ifClassExists = regex.test(newClasses);

                    if(!ifClassExists) {
                        newClasses += " " + classTag;
                    }
                }

                element.className = newClasses.trim();
            },
            _offsetLeft: function(obj){
                return obj.getBoundingClientRect().left;
            },
            _offsetTop: function(obj){
                var offsetTop = obj.offsetTop;
                while((obj = obj.offsetParent) && !isNaN(obj.offsetTop)){
                    offsetTop += obj.offsetTop;
                }
                return offsetTop;
            },
            _offset: function (obj) {
                return {
                    left: this._offsetLeft(obj),
                    top: this._offsetTop(obj)
                };
            },
            _css: function(elementRef, styleName, value) {
                if ($) {
                    $.style(elementRef, styleName, value);
                } else {
                    var style = styleName.replace(/^-ms-/, "ms-").replace(/-([\da-z])/gi, function (all, letter) {
                        return letter.toUpperCase();
                    });
                    elementRef.style[style] = value;
                }
            },
            _toValue: function(percentage) {
                return this.options.scale.toValue.apply(this, [percentage]);
            },
            _toPercentage: function(value) {
                return this.options.scale.toPercentage.apply(this, [value]);
            },
            _setTooltipPosition: function(){
                var tooltips = [this.tooltip, this.tooltip_min, this.tooltip_max];
                if (this.options.orientation === 'vertical'){
                    var tooltipPos = this.options.tooltip_position || 'right';
                    var oppositeSide = (tooltipPos === 'left') ? 'right' : 'left';
                    tooltips.forEach(function(tooltip){
                        this._addClass(tooltip, tooltipPos);
                        tooltip.style[oppositeSide] = '100%';
                    }.bind(this));
                } else if(this.options.tooltip_position === 'bottom') {
                    tooltips.forEach(function(tooltip){
                        this._addClass(tooltip, 'bottom');
                        tooltip.style.top = 22 + 'px';
                    }.bind(this));
                } else {
                    tooltips.forEach(function(tooltip){
                        this._addClass(tooltip, 'top');
                        tooltip.style.top = -this.tooltip.outerHeight - 14 + 'px';
                    }.bind(this));
                }
            }
        };

        /*********************************

         Attach to global namespace

         *********************************/
        if($) {
            var namespace = $.fn.slider ? 'bootstrapSlider' : 'slider';
            $.bridget(namespace, Slider);
        }

    })( $ );

    return Slider;
}));

$.easing.jswing = $.easing.swing;

$.extend($.easing,
    {
        def: 'easeOutQuad',
        swing: function (x, t, b, c, d) {
            //alert($.easing.default);
            return $.easing[$.easing.def](x, t, b, c, d);
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
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        },
        easeOutElastic: function (x, t, b, c, d) {
            var s=1.70158;var p=0;var a=c;
            if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
            if (a < Math.abs(c)) { a=c; var s=p/4; }
            else var s = p/(2*Math.PI) * Math.asin (c/a);
            return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
        },
        easeInOutElastic: function (x, t, b, c, d) {
            var s=1.70158;var p=0;var a=c;
            if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
            if (a < Math.abs(c)) { a=c; var s=p/4; }
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
            return c - $.easing.easeOutBounce (x, d-t, 0, c, d) + b;
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
            if (t < d/2) return $.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
            return $.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
        }
    });



$('#productContainer').on('submit','#add-to-cart-form', function(event) {
    event.preventDefault();
    event.stopPropagation();
    form = $(this);
    form.find('.buybtn').toggle();

    $.ajax({
        type: "POST",
        url: form.attr('action'),
        dataType: 'json',
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {

            $('#cartInformer').html(data.informer);
            $('#productContainer').html(data.chunk);
            var myToast = new ax5.ui.toast({
                icon: '<i class="fa fa-shopping-cart"></i>',
                containerPosition: "top-right",
                closeIcon: '<i class="fa fa-times"></i>',
                "displayTime":5000,
            });
            form.find('.buybtn').toggle();
            myToast.push("Товар добавлен в корзину: "+form.data('name')+'<br/><a href="/cart/index" class="btn btn-primary btn-block top10">Корзина</a>');

        }
    });

    var cart = $('.basket');
    var imgtodrag = $('#productContainer').find("#mainImage");

    if (imgtodrag) {
        var imgclone = imgtodrag.clone()
            .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            .css({
                'opacity': '1',
                'position': 'absolute',
                'height': imgtodrag.width(),
                'width': imgtodrag.height(),
                'z-index': '10120'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75,
                'opacity': '0.5',
            }, 500);

        imgclone.animate({
            'width': 0,
            'height': 0
        }, function () {
            $(this).detach();
        });
    }


});



$('.products_table').on('submit','.micro-add-to-cart-form', function(event) {
    event.preventDefault();
    form = $(this);
    form.find('.buybtn').toggle();
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        dataType: 'json',
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            form.find('.buybtn').toggle();
            $('#cartInformer').html(data.informer);
            $('#productContainer').html(data.chunk);

            var myToast = new ax5.ui.toast({
                icon: '<i class="fa fa-shopping-cart"></i>',
                containerPosition: "top-right",
                closeIcon: '<i class="fa fa-times"></i>',
                "displayTime":5000,
            });
            myToast.push("Товар добавлен в корзину: "+form.data('name')+'<br/><a href="/cart/index" class="btn btn-primary btn-block top10">Корзина</a>');

        }
    });
});

$('.products_thumbnails').on('submit','.thumb-add-to-cart-form', function(event) {
    event.preventDefault();
    $form = $(this);
    $(this).find('.thumbbuybtn').toggle();
    $.ajax({
        type: "POST",
        url: $form.attr('action'),
        dataType: 'json',
        data: $form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            $('#cartInformer').html(data.informer);
            $('#productContainer').html(data.chunk);

        }
    });
    var cart = $('.basket');
    var imgtodrag = $(this).closest('.thumbview').find("img");
    if (imgtodrag) {
        var imgclone = imgtodrag.clone()
            .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            .css({
                'opacity': '1',
                'position': 'absolute',
                'height': imgtodrag.width(),
                'width': imgtodrag.height(),
                'z-index': '10120'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75,
                'opacity': '0.5',
            }, 1500);

        imgclone.animate({
            'width': 0,
            'height': 0
        }, function () {
            $(this).detach();
        });
    }

    var myToast = new ax5.ui.toast({
        icon: '<i class="fa fa-shopping-cart"></i>',
        containerPosition: "top-right",
        closeIcon: '<i class="fa fa-times"></i>',
        "displayTime":5000,
    });
    myToast.push("Товар добавлен в корзину: "+$form.data('name')+'<br/><a href="/cart/index" class="btn btn-primary btn-block top10">Корзина</a>');

});

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
    $('#showFilter').click(function(e){
        e.preventDefault();
        $('#filter_in_category').slideToggle();
    });
});


$('#laterProductsContainer, .laterProductsContainer').on('submit','.add-to-cart-form', function(event) {
    event.preventDefault();
    event.stopPropagation();
    event.stopImmediatePropagation();
    form = $(this);
    form.find('.buybtn').toggle();
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        dataType: 'json',
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            //form.find('.buybtn').toggle();
            $('#cartInformer').html(data.informer);
            $('#product_modal_container').html(data.modal);
            form.closest('tr').remove();
        }
    });
}).on('click', '.deleteLater', function(e){
    e.preventDefault();
    link = $(this);
    $.ajax({
        type: "POST",
        url: link.attr('href'),
        dataType: 'json',
        success: function()
        {
            link.closest('tr').remove();
        }
    });
}).on('click', '.deleteRequested', function(e){
    e.preventDefault();
    link = $(this);
    $.ajax({
        type: "POST",
        url: link.attr('href'),
        dataType: 'json',
        success: function()
        {
            link.closest('tr').remove();
        }
    });
});

var latestScroll = 0;



$(window).scroll(function() {
    $('#scrollPageBack').hide();
    if($(window).scrollTop() > 210){
        $('#scrollPageUp').show();
        $('#scrollPageDown').hide();
    } else {
        $('#scrollPageUp').hide();
        if(document.referrer.indexOf('rybalkashop.ru') >= 0 && latestScroll === 0) {
            $('#scrollPageBack').show();
            $('#scrollPageBack').attr('onclick', 'history.go(-1);');
        } else if(latestScroll !== 0) {
            $('#scrollPageDown').show();
        }
    }
});

$('#scrollPageUp').click(function(e){
    latestScroll = $(window).scrollTop();
    $("html, body").stop().animate({ scrollTop: 0 }, "slow", function(){
        $('#scrollPageDown').show();
    });
});

$('#scrollPageDown').click(function(e){
    $("html, body").stop().animate({ scrollTop: latestScroll }, "slow", function(){
        $('#scrollPageDown').hide();
    });
});

$(document).ready(function(){
    if(document.referrer.indexOf('rybalkashop.ru') >= 0) {
        $('#scrollPageBack').show();
        $('#scrollPageBack').attr('onclick', 'history.go(-1);');
    }
    resizeScroller();

    $('#cd .cdtime').countdown({until: $.countdown.UTCDate(+3, new Date(2018, 10, 26, 1)), padZeroes: true});
    /*setInterval(timer, 1000)*/

});
$(window).resize(function(){
    resizeScroller();
});
function resizeScroller()
{
    if($('.main-content > .container').offset().left > 80){
        $('#scrollPageDown, #scrollPageUp, #scrollPageBack, #rightContainer').css({width:$('.main-content > .container').offset().left+"px"});
    } else {
        $('#scrollPageDown, #scrollPageUp, #scrollPageBack, #rightContainer').css({width:0+"px"});
    }

}


$('.container').hover(function(){
    $('#scrollPageDown, #scrollPageUp, #scrollPageBack').removeClass('rightPosition');
});

/*
function timer() {
    var ta = new Date(2017, 10, 23, 16, 21, 0, 0);
    var t1 = new Date();
    var t2 = new Date(2017, 10, 24, 0, 0, 0, 0);
    var difa = t2.getTime() - ta.getTime();
    var dif = t2.getTime() - t1.getTime();

    var currentPercent = Number((dif/difa*100).toFixed(2));
    var rightPercent = Number((100-currentPercent).toFixed(2));

    $('#tilldiscountpercent').html(rightPercent+'%').css({width:rightPercent+'%'});
    $('#tilldiscount').css({width:rightPercent+'%'});
}

*/

