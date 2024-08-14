/*! Auxin WordPress Framework - v5.16.3 (2024-07-08)
 *  Scripts for initializing plugins 
 *  http://averta.net
 *  (c) 2014-2024 averta;
 */



/* ================== js/src/functions.js =================== */


/*--------------------------------------------
 *  Functions
 *--------------------------------------------*/

function auxin_is_rtl(){
    return ((typeof auxin !== 'undefined') && (auxin.is_rtl == "1" || auxin.wpml_lang == "fa") )?true:false;
}

// Detect color contrast
function auxin_get_contrast( color ){
    var r,b,g,hsp
      , a = color;

    if (a.match(/^rgb/)) {
      a = a.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);
      r = a[1];
      g = a[2];
      b = a[3];
    } else {
      a = +("0x" + a.slice(1).replace(
          a.length < 5 && /./g, '$&$&'
        )
      );
      r = a >> 16;
      b = a >> 8 & 255;
      g = a & 255;
    }
    hsp = Math.sqrt(
      0.299 * (r * r) +
      0.587 * (g * g) +
      0.114 * (b * b)
    );
    
    // Best value is 127.5, but we use 200 for some reasons
	return ( hsp > 200 ) ? 'black' : 'white';
};


/* ================== js/src/generals.js =================== */


/* ------------------------------------------------------------------------------ */
// General javascripts
/* ------------------------------------------------------------------------------ */

;(function ( $, window, document, undefined ) {
    "use strict";

    var $window = $(window),
        $siteHeader = $('#site-header'),
        headerStickyHeight = $('#site-header').data('sticky-height') || 0;

    /* ------------------------------------------------------------------------------ */
    // goto top
    var gotoTopBtn = $('.aux-goto-top-btn'), distToFooter, footerHeight;

    $( function() {
        if ( gotoTopBtn.length && jQuery.fn.scrollTo ) {
            footerHeight = $('#sitefooter').outerHeight();

            gotoTopBtn.on( 'click touchstart', function() {
                $window.scrollTo( 0, {duration: gotoTopBtn.data('animate-scroll') ? 1500 : 0,  easing:'easeInOutQuart'});
            } );

            gotoTopBtn.css('display', 'block');
            scrollToTopOnScrollCheck();
            $window.on('scroll', scrollToTopOnScrollCheck);
        }


        function scrollToTopOnScrollCheck() {
            if ( $window.scrollTop() > 200 ) {
                gotoTopBtn[0].style[window._jcsspfx + 'Transform'] = 'translateY(0)';
                distToFooter = document.body.scrollHeight - $window.scrollTop() - window.innerHeight - footerHeight;

                if ( distToFooter < 0 ) {
                    gotoTopBtn[0].style[window._jcsspfx + 'Transform'] = 'translateY('+distToFooter+'px)';
                }
            } else {
                gotoTopBtn[0].style[window._jcsspfx + 'Transform'] = 'translateY(150px)';
            }
        }

        /* ------------------------------------------------------------------------------ */
        // add dom ready helper class
        $('body').addClass( 'aux-dom-ready' )
                 .removeClass( 'aux-dom-unready' );

        /* ------------------------------------------------------------------------------ */
        // animated goto
        if ( $.fn.scrollTo ) {
            var allLinks = document.querySelectorAll('a:not([href^="\#elementor-"])');

            Array.prototype.slice.call(allLinks).forEach(function (link) {

                var isElementorPopupTriggerPoint = false;
                var elementorPopups = document.querySelectorAll('.elementor-location-popup');
                for (var i = 0; i < elementorPopups.length; i++) {
                    var elementorPopup = elementorPopups[i];
                    var popupSettings = JSON.parse(elementorPopup.dataset.elementorSettings);
                    if (!popupSettings.open_selector) {
                        continue;
                    }
                    var menuTriggerPoint = document.querySelector(popupSettings.open_selector);
                    if (menuTriggerPoint.isEqualNode(link)) {
                        isElementorPopupTriggerPoint = true;
                        break;
                    }
                }

                if ( !isElementorPopupTriggerPoint && (link.href && link.href.indexOf('#') != -1) && ( (link.pathname == location.pathname) || ('/'+link.pathname == location.pathname) ) && (link.search == location.search) ) {

                    link.addEventListener('click', function(e) {
                        var isWCTabs     = this.closest('.woocommerce-tabs');

                        if ( !this.hash || isWCTabs ) {
                            return;
                        }

                        e.preventDefault();
                        e.stopPropagation();

                        if ( this.classList.contains('woocommerce-review-link') ) {
                            var reviewTab = document.querySelector('#tab-title-reviews');

                            if ( !reviewTab.classList.contains('active') ) {
                                $(reviewTab).find('a').trigger('click');
                            }
                        }

                        var isFullScreen = this.closest('.aux-fs-popup .aux-fs-menu'),
                            target       = document.querySelector( this.hash );

                        if ( target ) {
                            $window.scrollTo( $(target).offset().top - headerStickyHeight, this.classList.contains( 'aux-jump' )  ? 0 : 1500,  {easing:'easeInOutQuart'});
                        }

                        if  ( isFullScreen ) {
                            $(isFullScreen).siblings('.aux-panel-close').trigger('click')
                        }
                    });

                }
            } );

        }

        /* ------------------------------------------------------------------------------ */
        // add space above sticky header if we have the wp admin bar in the page

        var $adminBar            = $('#wpadminbar'),
            marginFrameThickness = $('.aux-side-frames').data('thickness') || 0,
            siteHeaderTopPosition;

        $('#site-header').on( 'sticky', function(){
            if ( $adminBar.hasClass('mobile') || window.innerWidth <= 600 ) {
                return;
            }
            // calculate the top position
            siteHeaderTopPosition = 0;
            if( $adminBar.length ){
                siteHeaderTopPosition += $adminBar.height();
            }
            if( marginFrameThickness && window.innerWidth >= 700 ){
                siteHeaderTopPosition += marginFrameThickness;
            }
            $(this).css( 'top', siteHeaderTopPosition + 'px' );

        }).on( 'unsticky', function(){
            $(this).css( 'top', '' );
        });

        /* ------------------------------------------------------------------------------ */
        // disable search submit if the field is empty

        $('.aux-search-field, #searchform #s').each(function(){
            var $this = $(this);
            $this.parent('form').on( 'submit', function( e ){
                if ( $this.val() === '' ) {
                    e.preventDefault();
                }
            });
        });

        /* ------------------------------------------------------------------------------ */
        // fix megamenu width for middle aligned menu in header
        // var $headerContainer = $siteHeader.find('.aux-header-elements'),
        //     $headerMenu = $('#master-menu-main-header');
        // var calculateMegamenuWidth = function(){
        //     var $mm = $siteHeader.find( '.aux-middle .aux-megamenu' );
        //     if ( $mm.length ) {
        //         $mm.width( $headerContainer.innerWidth() );
        //         $mm.css( 'left', -( $headerMenu.offset().left - $headerContainer.offset().left ) + 'px' );
        //     } else {
        //         $headerMenu.find( '.aux-megamenu' ).css('width', '').css( 'left', '' );
        //     }
        // };

        // $(window).load(function() {
        //     calculateMegamenuWidth();
        // });

        // $window.on( 'resize', calculateMegamenuWidth );

        /* ------------------------------------------------------------------------------ */
        // Get The height of Top bar When Overlay Header Option is enable
        if ( $siteHeader.hasClass('aux-overlay-with-tb') || $siteHeader.hasClass('aux-overlay-header') ){

            if( $siteHeader.hasClass('aux-overlay-with-tb') ){
                var $topBarHeight = $('#top-header').outerHeight();
                $('.aux-overlay-with-tb').css( 'top' , $topBarHeight+'px') ;
            }

        }

    });


    /* ------------------------------------------------------------ */
    // Switch the color of header buttons on sticky
    /* ------------------------------------------------------------ */

    window.auxinSetupLogoSwitcher = function(){

        if( ! $('body').hasClass('aux-top-sticky') ){
            return;
        }

        var $btns = $('#site-header .aux-btns-box .aux-button'), $btn,
            $default_logo   = $('.aux-logo-header .aux-logo-anchor:not(.aux-logo-sticky), .aux-widget-logo .aux-logo-anchor:not(.aux-logo-sticky)'),
            $sticky_logo    = $('.aux-logo-header .aux-logo-anchor.aux-logo-sticky, .aux-widget-logo .aux-logo-anchor.aux-logo-sticky'),
            has_sticky_logo = $sticky_logo.length;

        $('#site-header, #site-elementor-header').on( 'sticky', function(){
            for ( var i = 0, l = $btns.length; i < l; i++ ) {
                $btn = $btns.eq(i);
                $btn.removeClass( "aux-" + $btn.data("colorname-default") ).addClass( "aux-" + $btn.data("colorname-sticky") );
            }
            if( has_sticky_logo ){
                $default_logo.addClass('aux-logo-hidden');
                $sticky_logo.removeClass('aux-logo-hidden');
            }
        }).on( 'unsticky', function(){
            for ( var i = 0, l = $btns.length; i < l; i++ ) {
                $btn = $btns.eq(i);
                $btn.removeClass( "aux-" + $btn.data("colorname-sticky") ).addClass( "aux-" + $btn.data("colorname-default") );
            }
            if( has_sticky_logo ){
                $default_logo.removeClass('aux-logo-hidden');
                $sticky_logo.addClass('aux-logo-hidden');
            }
        });

    };
    window.auxinSetupLogoSwitcher();


    // this snippet prevents auto scrolling after updating cart items in the cart or checkout page
    $(document).ready(function($) {
        $(document).ajaxComplete(function() {
        if ($('body').hasClass('woocommerce-checkout') || $('body').hasClass('woocommerce-cart')) {
            jQuery( 'html, body' ).stop();
        }
      });
    });


})(jQuery, window, document);


/** ------------------------------------------------------------
 * WP Ulike HearBeat Animation
 */
 var UlikeHeart  = document.querySelectorAll('.wp_ulike_btn');

function auxinUlikeHeartBeat(e){
    e.target.classList.add('aux-icon-heart');
}
function removeAuxinUlikeHeartBeat(e){
    e.target.classList.remove('aux-icon-heart');
}

for ( var i = 0 ; UlikeHeart.length > i; i++){
    UlikeHeart[i].addEventListener('click', auxinUlikeHeartBeat );
    UlikeHeart[i].addEventListener('animationend', removeAuxinUlikeHeartBeat );
}

/** ------------------------------------------------------------
 * A fix for elements with fixed-position animated panels.
 */
(function () {
    // add more fixed elements here...
    var target = ".aux-search-popup, .aux-fs-popup";
    document.querySelectorAll(target).forEach(function (element) {
      var closestAnimElement = element.closest(".aux-appear-watch-animation > .elementor-widget-container,.aux-appear-watch-animation > .elementor-column-wrap");

      if (closestAnimElement) {
        [closestAnimElement, closestAnimElement.parentElement].forEach(function (animElement) {
          return animElement.addEventListener("animationstart", animElement.addEventListener("animationend", function () {
            animElement.style.animationName = "none";
            animElement.style.opacity = 1;
          }));
        });
      }
    });
  })();


/* ================== js/src/jquery-numerator.js =================== */


/*
 *   jQuery Numerator Plugin 0.2.1
 *   https://github.com/garethdn/jquery-numerator
 *
 *   Copyright 2015, Gareth Nolan
 *   http://ie.linkedin.com/in/garethnolan/

 *   Based on jQuery Boilerplate by Zeno Rocha with the help of Addy Osmani
 *   http://jqueryboilerplate.com
 *
 *   Licensed under the MIT license:
 *   http://www.opensource.org/licenses/MIT
 */

;(function (factory) {
    'use strict';
    if (typeof define === 'function' && define.amd) {
        // AMD is used - Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        factory(require('jquery'));
    } else {
        // Neither AMD nor CommonJS used. Use global variables.
        if (typeof jQuery === 'undefined') {
            throw 'jquery-numerator requires jQuery to be loaded first';
        }
        factory(jQuery);
    }
}(function ($) {

    var pluginName = "numerator",
    defaults = {
        easing: 'swing',
        duration: 500,
        delimiter: undefined,
        rounding: 0,
        toValue: undefined,
        fromValue: undefined,
        queue: false,
        onStart: function(){},
        onStep: function(){},
        onProgress: function(){},
        onComplete: function(){}
    };

    function Plugin ( element, options ) {
        this.element = element;
        this.settings = $.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {

        init: function () {
            this.parseElement();
            this.setValue();
        },

        parseElement: function () {
            var elText = $(this.element).text().trim();

            this.settings.fromValue = this.settings.fromValue || this.format(elText);
        },

        setValue: function() {
            var self = this;

            $({value: self.settings.fromValue}).animate({value: self.settings.toValue}, {

                duration: parseInt(self.settings.duration, 10),

                easing: self.settings.easing,

                start: self.settings.onStart,

                step: function(now, fx) {
                    $(self.element).text(self.format(now));
                    // accepts two params - (now, fx)
                    self.settings.onStep(now, fx);
                },

                // accepts three params - (animation object, progress ratio, time remaining(ms))
                progress: self.settings.onProgress,

                complete: self.settings.onComplete
            });
        },

        format: function(value){
            var self = this;

            if ( parseInt(this.settings.rounding ) < 1) {
                value = parseInt(value, 10);
            } else {
                value = parseFloat(value).toFixed( parseInt(this.settings.rounding) );
            }

            if (self.settings.delimiter) {
                return this.delimit(value)
            } else {
                return value;
            }
        },

        // TODO: Add comments to this function
        delimit: function(value){
            var self = this;

            value = value.toString();

            if (self.settings.rounding && parseInt(self.settings.rounding, 10) > 0) {
                var decimals = value.substring( (value.length - (self.settings.rounding + 1)), value.length ),
                    wholeValue = value.substring( 0, (value.length - (self.settings.rounding + 1)));

                return self.addDelimiter(wholeValue) + decimals;
            } else {
                return self.addDelimiter(value);
            }
        },

        addDelimiter: function(value){
            return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.settings.delimiter);
        }
    };

    $.fn[ pluginName ] = function ( options ) {
        return this.each(function() {
            if ( $.data( this, "plugin_" + pluginName ) ) {
                $.data(this, 'plugin_' + pluginName, null);
            }
            $.data( this, "plugin_" + pluginName, new Plugin( this, options ) );
        });
    };

}));


/* ================== js/src/jquery.twbsPagination.js =================== */


/*!
 * jQuery pagination plugin v1.2.6
 * http://esimakin.github.io/twbs-pagination/
 *
 * Copyright 2014, Eugene Simakin
 * Released under Apache 2.0 license
 * http://apache.org/licenses/LICENSE-2.0.html
 */
(function ($, window, document, undefined) {

    'use strict';

    var old = $.fn.twbsPagination;

    // PROTOTYPE AND CONSTRUCTOR

    var TwbsPagination = function (element, options) {
        this.$element = $(element);
        this.options = $.extend({}, $.fn.twbsPagination.defaults, options);

        if (this.options.startPage < 1 || this.options.startPage > this.options.totalPages) {
            throw new Error('Start page option is incorrect');
        }

        this.options.totalPages = parseInt(this.options.totalPages);
        if (isNaN(this.options.totalPages)) {
            throw new Error('Total pages option is not correct!');
        }

        this.options.visiblePages = parseInt(this.options.visiblePages);
        if (isNaN(this.options.visiblePages)) {
            throw new Error('Visible pages option is not correct!');
        }

        if (this.options.totalPages < this.options.visiblePages) {
            this.options.visiblePages = this.options.totalPages;
        }

        if (this.options.onPageClick instanceof Function) {
            this.$element.first().on('page', this.options.onPageClick);
        }

        if (this.options.href) {
            var match, regexp = this.options.href.replace(/[-\/\\^$*+?.|[\]]/g, '\\$&');
            regexp = regexp.replace(this.options.hrefVariable, '(\\d+)');
            if ((match = new RegExp(regexp, 'i').exec(window.location.href)) != null) {
                this.options.startPage = parseInt(match[1], 10);
            }
        }

        var tagName = (typeof this.$element.prop === 'function') ?
            this.$element.prop('tagName') : this.$element.attr('tagName');

        if (tagName === 'UL') {
            this.$listContainer = this.$element;
        } else {
            this.$listContainer = $('<ul></ul>');
        }

        this.$listContainer.addClass(this.options.paginationClass);

        if (tagName !== 'UL') {
            this.$element.append(this.$listContainer);
        }

        this.render(this.getPages(this.options.startPage));
        this.setupEvents();

        if (this.options.initiateStartPageClick) {
            this.$element.trigger('page', this.options.startPage);
        }

        return this;
    };

    TwbsPagination.prototype = {

        constructor: TwbsPagination,

        destroy: function () {
            this.$element.empty();
            this.$element.removeData('twbs-pagination');
            this.$element.off('page');

            return this;
        },

        show: function (page) {
            if (page < 1 || page > this.options.totalPages) {
                throw new Error('Page is incorrect.');
            }

            this.render(this.getPages(page));
            this.setupEvents();

            this.$element.trigger('page', page);

            return this;
        },

        buildListItems: function (pages) {
            var listItems = [];

            if (this.options.first) {
                listItems.push(this.buildItem('first', 1));
            }

            if (this.options.prev) {
                var prev = pages.currentPage > 1 ? pages.currentPage - 1 : this.options.loop ? this.options.totalPages  : 1;
                listItems.push(this.buildItem('prev', prev));
            }

            for (var i = 0; i < pages.numeric.length; i++) {
                listItems.push(this.buildItem('page', pages.numeric[i]));
            }

            if (this.options.next) {
                var next = pages.currentPage < this.options.totalPages ? pages.currentPage + 1 : this.options.loop ? 1 : this.options.totalPages;
                listItems.push(this.buildItem('next', next));
            }

            if (this.options.last) {
                listItems.push(this.buildItem('last', this.options.totalPages));
            }

            return listItems;
        },

        buildItem: function (type, page) {
            var $itemContainer = $('<li></li>'),
                $itemContent = $('<a></a>'),
                itemText = null;

            switch (type) {
                case 'page':
                    itemText = page;
                    $itemContainer.addClass(this.options.pageClass);
                    break;
                case 'first':
                    itemText = this.options.first;
                    $itemContainer.addClass(this.options.firstClass);
                    break;
                case 'prev':
                    itemText = this.options.prev;
                    $itemContainer.addClass(this.options.prevClass);
                    break;
                case 'next':
                    itemText = this.options.next;
                    $itemContainer.addClass(this.options.nextClass);
                    break;
                case 'last':
                    itemText = this.options.last;
                    $itemContainer.addClass(this.options.lastClass);
                    break;
                default:
                    break;
            }

            $itemContainer.data('page', page);
            $itemContainer.data('page-type', type);
            $itemContainer.append($itemContent.attr('href', this.makeHref(page)).html(itemText));

            return $itemContainer;
        },

        getPages: function (currentPage) {
            var pages = [];

            var half = Math.floor(this.options.visiblePages / 2);
            var start = currentPage - half + 1 - this.options.visiblePages % 2;
            var end = currentPage + half;

            // handle boundary case
            if (start <= 0) {
                start = 1;
                end = this.options.visiblePages;
            }
            if (end > this.options.totalPages) {
                start = this.options.totalPages - this.options.visiblePages + 1;
                end = this.options.totalPages;
            }

            var itPage = start;
            while (itPage <= end) {
                pages.push(itPage);
                itPage++;
            }

            return {"currentPage": currentPage, "numeric": pages};
        },

        render: function (pages) {
            var _this = this;
            this.$listContainer.children().remove();
            this.$listContainer.append(this.buildListItems(pages));

            this.$listContainer.children().each(function () {
                var $this = $(this),
                    pageType = $this.data('page-type');

                switch (pageType) {
                    case 'page':
                        if ($this.data('page') === pages.currentPage) {
                            $this.addClass(_this.options.activeClass);
                        }
                        break;
                    case 'first':
                            $this.toggleClass(_this.options.disabledClass, pages.currentPage === 1);
                        break;
                    case 'last':
                            $this.toggleClass(_this.options.disabledClass, pages.currentPage === _this.options.totalPages);
                        break;
                    case 'prev':
                            $this.toggleClass(_this.options.disabledClass, !_this.options.loop && pages.currentPage === 1);
                        break;
                    case 'next':
                            $this.toggleClass(_this.options.disabledClass,
                                !_this.options.loop && pages.currentPage === _this.options.totalPages);
                        break;
                    default:
                        break;
                }

            });
        },

        setupEvents: function () {
            var _this = this;
            this.$listContainer.find('li').each(function () {
                var $this = $(this);
                $this.off();
                if ($this.hasClass(_this.options.disabledClass) || $this.hasClass(_this.options.activeClass)) {
                    $this.on('click', false);
                    return;
                }
                $this.on('click', function (evt) {
                    // Prevent click event if href is not set.
                    !_this.options.href && evt.preventDefault();
                    _this.show(parseInt($this.data('page')));
                });
            });
        },

        makeHref: function (c) {
            return this.options.href ? this.options.href.replace(this.options.hrefVariable, c) : "#";
        }

    };

    // PLUGIN DEFINITION

    $.fn.twbsPagination = function (option) {
        var args = Array.prototype.slice.call(arguments, 1);
        var methodReturn;

        var $this = $(this);
        var data = $this.data('twbs-pagination');
        var options = typeof option === 'object' && option;

        if (!data) $this.data('twbs-pagination', (data = new TwbsPagination(this, options) ));
        if (typeof option === 'string') methodReturn = data[ option ].apply(data, args);

        return ( methodReturn === undefined ) ? $this : methodReturn;
    };

    $.fn.twbsPagination.defaults = {
        totalPages: 0,
        startPage: 1,
        visiblePages: 5,
        initiateStartPageClick: true,
        href: false,
        hrefVariable: '{{number}}',
        first: 'First',
        prev: 'Previous',
        next: 'Next',
        last: 'Last',
        loop: false,
        onPageClick: null,
        paginationClass: 'pagination',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first',
        pageClass: 'page',
        activeClass: 'active',
        disabledClass: 'disabled'
    };

    $.fn.twbsPagination.Constructor = TwbsPagination;

    $.fn.twbsPagination.noConflict = function () {
        $.fn.twbsPagination = old;
        return this;
    };

})(window.jQuery, window, document);


/* ================== js/src/module.carousel-lightbox.js =================== */


/**
 * Init Carousel and Lightbox
 *
 */
(function($, window, document, undefined){
    "use strict";

    $.fn.AuxinCarouselInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-lightbox-frame').photoSwipe({
                target: '.aux-lightbox-btn',
                bgOpacity: 0.8,
                shareEl: true
            }
        );

        $scope.find('.aux-lightbox-gallery').photoSwipe({
                target: '.aux-lightbox-btn',
                bgOpacity: 0.97,
                shareEl: true
            }
        );

        $scope.find('.aux-lightbox-video').photoSwipe({
                target: '.aux-open-video',
                bgOpacity: 0.97,
                shareEl: true
            }
        );

        $scope.find('.master-carousel-slider').AuxinCarousel({
            autoplay: false,
            columns: 1,
            speed: 15,
            inView: 15,
            autohight: false,
            rtl: $('body').hasClass('rtl')
        }).on( 'auxinCarouselInit', function(){
            // init lightbox on slider after carousel init
            $scope.find('.aux-lightbox-in-slider').photoSwipe({
                    target: '.aux-lightbox-btn',
                    bgOpacity: 0.8,
                    shareEl: true
                }
            );
        } );

        // all other master carousel instances
        $scope.find('.master-carousel').AuxinCarousel({
            speed: 30,
            rtl: $('body').hasClass('rtl')
        });

        // trigger a resize on body after full window load to correct the calculated height size of carousel wrappers
        $(window).on('load', function () {
            $('body').trigger('resize');
        });
    };

})(jQuery, window, document);


/* ================== js/src/module.elements.js =================== */


/**
 * General Modules
 */
;(function($, window, document, undefined){

    // Init Tilt
    $.fn.AuxinTiltElementInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-tilt-box').tilt({
            maxTilt : $(this).data('max-tilt'),
            easing: 'cubic-bezier(0.23, 1, 0.32, 1)',
            speed: $(this).data('time'),
            perspective: 2000
        });
    }

    // Init FitVids
    $.fn.AuxinFitVideosInit = function( $scope ){
        $scope = $scope || $(this);
        $scope.find('main').fitVids();
        $scope.find('main').fitVids({ customSelector: 'iframe[src^="http://w.soundcloud.com"], iframe[src^="https://w.soundcloud.com"]'});
    }

    // Init Image box
    $.fn.AuxinImageBoxInit = function( $scope ){
        $scope = $scope || $(this);
        $scope.find('.aux-image-box').AuxinImagebox();
    }

    // Init Before after
    $.fn.AuxinBeforeAfterInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-before-after').imagesLoaded( function(){
            // init before after slider
            $scope.find('.aux-before-after').each( function() {
                var $slider = $(this);
                $slider.twentytwenty({
                    default_offset_pct: $slider.data( 'offset' ) || 0.5,
                    orientation: 'horizontal'
                });
            });
        });
    }

    // Parallax Box
    $.fn.AuxinParallaxBoxInit = function( $scope ){
        $scope = $scope || $(this);

        // General parallax box
        $scope.find('.aux-parallax-box').AvertaParallaxBox();
    };

    // Parallax Section
    $.fn.AuxinParallaxSectionInit = function( $scope ){
        $scope = $scope || $(this);

        var $target = $scope.hasClass('aux-parallax-section') ? $scope : $scope.find('.aux-parallax-section');
        if( ! $target.length ){
            return;
        }

        // Only init the parallax on deepest section
        $target.each( function(key, item){
            var $parallax_box = $(this);

            if( ! $parallax_box.find('.aux-parallax-section').length ){
                $parallax_box.AvertaParallaxBox({
                    targets: 'aux-parallax-piece'
                });
            }
        });
    };


    // Parallax Section
    $.fn.AuxinScrollableAnimsInit = function( $scope ){
        $scope = $scope || $(this);

        var $target = $scope.hasClass('aux-scroll-anim') ? $scope : $scope.find('.aux-scroll-anim');
        if( ! $target.length ){
            return;
        }

        // Only init the parallax on deepest section
        $target.each( function(key, item){
            var $parallax_box = $(this);
            $parallax_box.AvertaScrollAnims();
        });
    };

    // Ajax Search
    $.fn.AuxinAjaxSearch = function( $scope ){
        $scope = $scope || $(this);

        var $target = $scope.hasClass('is-ajax') ? $scope : $scope.find('.is-ajax');
        if( ! $target.length ){
            return;
        }
        // initialize ajax search
        var xhr = null;
        function init($scope) {
            var input = $scope.find('input.aux-search-field');
            var catDropDown = $scope.find('select#cat');
            input.on('keyup', function() {
                search($scope,$(this),catDropDown)
            });
            if (catDropDown.length) {
                catDropDown.select2({
                    minimumResultsForSearch: -1,
                    dropdownCssClass: "aux-search-dropdown"
                });
                catDropDown.on('change', function() {
                    search($scope,input,catDropDown);
                });
            }
            $scope.find('input[type="submit"]').on('click',function(){
                $(this).parents('form').submit();
            });
        }
        function search($scope,input,catDropDown) {
            if (xhr)
                xhr.abort();
            var value = input.val();

            // check if search phrase length have lass than 3 characters return
            if (value.length < 3 || value == '') {
                $scope.find( '.aux-spinner' ).removeClass( 'show' );
                if ($('.aux-search-overlay > .aux-search-field').hasClass('has-result')) {
                    $('.aux-search-overlay .aux-search-result').html('');
                    $('.aux-search-overlay > .aux-search-field').removeClass('has-result');
                }
                return;
            }
            $scope.find('.aux-spinner').addClass( 'show' );
            $scope.find( '.aux-search-result' ).addClass( 'hide' );
            var selectedCat;
            if (catDropDown.length) {
                selectedCat = catDropDown.val();
            } else {
                selectedCat = 0;
            }

            var data = {
                action: 'auxin_ajax_search',
                s: value,
                cat: selectedCat,
            }
            xhr = $.ajax({
                type        :'get',
                dataType    : 'html',
                url         : auxin.ajax_url,
                data : data,
            })
            .done(function(response) {
                $scope.find( '.aux-spinner' ).removeClass( 'show' );
                $scope.find( '.aux-search-result' ).removeClass( 'hide' );
                if (!$('.aux-search-overlay > .aux-search-field').hasClass('has-result')) {
                    $('.aux-search-overlay > .aux-search-field').addClass('has-result');
                    setTimeout(function(){
                        $scope.find('.aux-search-result').html(response)
                    },1000);
                } else {
                    $scope.find('.aux-search-result').html(response)
                }

            });
        }
        // Only init the parallax on deepest section
        $target.each( function(key, item){
            init($(this));
        });
    };

    $.fn.AuxinModernSearchAjax = function( $scope ) {
        $scope = $scope || $( this ) ;

        var $targets = $scope.find( '.aux-search-ajax' );

        function ajaxSearchRequest( searchKey, cat, postTypes, outputWrapper, spinner ) {

            spinner.removeClass( 'aux-spinner-hide' );
            outputWrapper.empty();

            var data = {
                action      : 'aux_modern_search_handler',
                s           : searchKey,
                cat         : cat.id,
                taxonomy    : cat.taxonomy,
                'post_type' : cat.postType,
                'post_types': postTypes
            }

            $.ajax({
                type        :'get',
                dataType    : 'html',
                url         : auxin.ajax_url,
                data : data,
            })
            .done( function( res ) {
                var response = JSON.parse( res );
                var output = generateMarkup( response.data );

                setTimeout( function() {
                    outputWrapper.html(output);
                    spinner.addClass( 'aux-spinner-hide' );
                }, 1500 )

            });


        }

        function generateMarkup( postTypes, wrapper ) {
            var output = '';

            postTypes.forEach( function(postType) {
                var item = postType.results;
                var itemOutput = '';
                var title = '';

                if (item.length) {
                    title = '<a class="aux-other-search-result-label" href="' + postType.searchLink + '">' + postType.fromTitle + '</a>'

                    item.forEach( function(post) {
                        itemOutput += post;
                    })


                } else {
                    title = '<a class="aux-other-search-result-label" href="' + postType.searchLink + '">' + postType.noResultMessage + '</a>'
                }

                output += '<div class="aux-other-search-result">' + title + itemOutput + '</div>';

            } );

            return output;

        }

        function initAjaxSearch( element ) {
            var $el             = $( element ),
                $popupContainer = $el.parent('.aux-search-popup-content'),
                $field          = $el.find('.aux-search-field'),
                $spinner        = $popupContainer.find('.aux-loading-spinner'),
                $ajaxOutput     = $popupContainer.find('.aux-search-ajax-output'),
                $cats           = $popupContainer.find('.aux-modern-search-cats'),
                catID           = 0,
                taxonomy        = $cats.length ? $cats.find('option:selected').data('taxonomy') : ['category'],
                postType        = $cats.length ? $cats.find('option:selected').data('post-type') : ['post'],
                postTypes       = $field.data('post-types'),
                delay           = 0,
                fieldValue      = $field.val();


            $field.on( 'keyup' , function( event ) {
                var searchKey = event.target.value;

                if ( searchKey.length <= 3 || searchKey.length >= 35 || fieldValue === event.target.value ) {
                    return;
                }

                if ( delay ) {
                    clearTimeout( delay );
                }

                delay = setTimeout( function(){
                    fieldValue = event.target.value;
                    ajaxSearchRequest( searchKey, { id: catID, taxonomy: taxonomy, postType: postType }, postTypes , $ajaxOutput, $spinner );
                }, 700);

            });

            if ( $cats.length ) {
                $cats.on( 'change', function(event) {
                    var selectedOption= $(event.target).find('option:selected'),
                        selectedTax = selectedOption.data('taxonomy'),
                        selectedPostType = selectedOption.data('post-type');

                    catID    = event.target.value;
                    taxonomy = selectedTax;
                    postType = selectedPostType;

                    ajaxSearchRequest( $field.val(), { id: catID, taxonomy: taxonomy, postType: postType }, postTypes, $ajaxOutput, $spinner );
                });
            }

        }


        $targets.each( function() {
            initAjaxSearch( this );
        } )

    };

    // Elementor Search Element
    $.fn.AuxinElementorSearchElement = function($scope){
        $scope = $scope || $(this);

        var $target = $scope.hasClass('aux-search-elementor-element') ? $scope : $scope.find('.aux-search-elementor-element');
        if( ! $target.length ){
            return;
        }
        $target.each(function(key, item) {
            if ( $(this).parents('.elementor-element').length && $(this).parents('.elementor-element').width() <= 634 ) {
                $(this).addClass('responsive');
            } else if ($(this).hasClass('responsive')) {
                $(this).removeClass('responsive');
            }
        });
    };

    // Media Element init
    $.fn.AuxinMediaElementInit = function(){
        if ( typeof MediaElementPlayer === 'function' ) {
            var settings        = window._wpmejsSettings || {};
            settings.features   = settings.features || mejs.MepDefaults.features;
            settings.features.push( 'AuxinPlayList' );
            /* ------------------------------------------------------------------------------ */
            MediaElementPlayer.prototype.buildAuxinPlayList = function( player, controls, layers, media ) {
                if ( player.container.closest('.wp-video-playlist').length ) {
                    // Add special elements for once.
                    if ( !player.container.closest('.aux-mejs-container').length ){
                        // Add new custom wrap
                        player.container.wrap( "<div class='aux-mejs-container aux-4-6 aux-tb-1 aux-mb-1'></div>" );
                        // Add auxin classes
                        player.container.closest( '.wp-playlist' ).addClass('aux-row').find('.wp-playlist-tracks').addClass('aux-2-6 aux-tb-1 aux-mb-1');
                        // Run perfect scrollbar
                        new PerfectScrollbar('.wp-playlist-tracks');
                    }
                    player.container.addClass( 'aux-player-light' );
                    player.options.stretching = 'none';
                    player.width              = '100%';
                    var $playlistContainer    = player.container.closest( '.wp-playlist' ).find( '.wp-playlist-tracks' );
                    if( !$playlistContainer.find('.aux-playlist-background').length ) {
                        $playlistContainer.prepend( "<div class='aux-playlist-background'></div>" );
                    }
                    var $postFormatHeight     = $('.aux-primary .content').width();
                    // Set playlist Height
                    if( $postFormatHeight >= 1600 ) {
                        player.height = 720;
                    } else if( $postFormatHeight >= 768 && $postFormatHeight < 1600 ) {
                        player.height = 480;
                    } else if( $postFormatHeight >= 480 && $postFormatHeight < 768 ) {
                        player.height = 360;
                    } else {
                        player.height = 240;
                    }
                    // Set playlist height by player's height
                    $playlistContainer.css('height', player.height);
                }
            };
        }
    }

    // Dynamic image drop shadow
    $.fn.AuxinDynamicDropshadow = function(){

        var imgFrame, clonedImg, img;

        if( this instanceof jQuery ){
            if( this && this[0] ){
                img = this[0];
            } else {
                return;
            }
        } else {
            img = this;
        }

        if ( ! img.classList.contains('aux-img-has-shadow')){
            imgFrame  = document.createElement('div');
            clonedImg = img.cloneNode();

            clonedImg.classList.add('aux-img-dynamic-dropshadow-cloned');
            clonedImg.classList.remove('aux-img-dynamic-dropshadow');
            img.classList.add('aux-img-has-shadow');
            imgFrame.classList.add('aux-img-dynamic-dropshadow-frame');

            img.parentNode.appendChild(imgFrame);
            imgFrame.appendChild(img);
            imgFrame.appendChild(clonedImg);
        }
    };

    // Dynamic image drop shadow init
    $.fn.AuxinDynamicDropshadowInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-img-dynamic-dropshadow').each(function() {
            $(this).AuxinDynamicDropshadow();
        });
    };

    // Blur images with scroll
    $.fn.AuxinScrollBlurImage = function( blurValue, startFrom, opacitySpeed ){
        var $this =  $(this),
            prefix = window._jcsspfx || '',
            clonedImage = getImage($this),
            bluredImage = createBluredImage(clonedImage),
            yVisible = startFrom * $this.outerHeight(),
            remainHeight = $this.outerHeight() - yVisible,
            scrollValue,
            opacityValue;

        function getImage($target) {
            var backgroundImage = $target.css('background-image');
            $target.addClass('aux-orginal-blured-img');
            return backgroundImage;
        }

        function createBluredImage (imgUrl){
            var bgImgElement = document.createElement('div');

            $(bgImgElement).appendTo($this);
            $(bgImgElement).addClass('aux-blured-img');

            bgImgElement.style[prefix + 'backgroundImage'] = imgUrl;

            if ( 'auto' != $this.css('background-size') ) {
                bgImgElement.style[prefix + 'backgroundSize'] = $this.css('background-size');
            }

            if ( '0% 0%' != $this.css('background-position') ) {
                bgImgElement.style[prefix + 'backgroundPosition'] = $this.css('background-position');
            }

            if ( 'repeat' != $this.css('background-repeat') ) {
                bgImgElement.style[prefix + 'backgroundRepeat'] = $this.css('background-repeat');
            }

            bgImgElement.style[prefix + 'filter'] = 'blur(' + blurValue + 'px)';

            return $(bgImgElement);
        }

        $(window).on('scroll', function(){
            var winBot = $(window).scrollTop();
            scrollValue = ( winBot - $this.offset().top ) - yVisible;

            if ( scrollValue > 0 ){
                opacityValue = scrollValue / remainHeight;
                opacityValue = Math.min(1, opacityValue * opacitySpeed );

                if( opacityValue < 1 ){
                    bluredImage[0].style[prefix + 'opacity'] = opacityValue;
                } else {
                    bluredImage[0].style[prefix + 'opacity'] = 1;
                }

            } else if ( scrollValue < 0 ){
                bluredImage[0].style[prefix + 'opacity'] = 0;
            }

        });
    }

    // Blur images with scroll - Init
    $.fn.AuxinScrollBlurImageInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-blur-fade').each(function() {
            $(this).AuxinScrollBlurImage( 15, 0.3, 4 );
        });
    }

    // Miscellaneous Elements
    $.fn.AuxinOtherElementsInit = function( $scope ){
        $scope = $scope || $(this);
    }

    // Document ready modules ===============================================

    // Tabs
    $.fn.AuxinLiveTabsInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.widget-tabs .widget-inner').avertaLiveTabs({
            tabs:            'ul.tabs > li',            // Tabs selector
            tabsActiveClass: 'active',                  // A Class that indicates active tab
            contents:        'ul.tabs-content > li',    // Tabs content selector
            contentsActiveClass: 'active',              // A Class that indicates active tab-content
            transition:      'fade',                    // Animation type white switching tabs
            duration :       '500'                      // Animation duration in milliseconds
        });
    }

    // Accordion Element
    $.fn.AuxinAccordionInit = function( $scope ){
        $scope = $scope || $(this);

        var _collapseOnInit = $(this).find('.aux-toggle-widget.aux-open').length ? true : false;

        $scope.find('.aux-sidebar .aux-widget-area').each( function( index, el ) {
            $(this).avertaAccordion({
                items           : '.aux-toggle-widget',
                itemHeader      : '.widget-title',
                itemContent     : '.widget-title + *',
                itemActiveClass : 'aux-open',
                contentWrapClass: 'aux-toggle-widget-wrapper',
                oneVisible      : false,
                collapseOnInit  : _collapseOnInit,
                onExpand: function( $item ){
                    var height = 0;

                    $item.find('.aux-toggle-widget-wrapper > * ').each( function( index, el ) {
                        height += $(el).outerHeight(true);
                    })

                    $item.find('.aux-toggle-widget-wrapper').css( 'height', height );
                },
                onCollapse: function( $item ) {
                    var wrapper = $item.find('.aux-toggle-widget-wrapper'),
                        height = wrapper.outerHeight();

                    wrapper.css('height', height);
                }
            });
        });

        $scope.find('.widget-toggle .widget-inner').each( function( index, el ) {
            $(this).avertaAccordion({
                itemHeader : '.toggle-header',
                itemContent: '.toggle-content',
                oneVisible : $(this).data("toggle") ,
            });
        });

        $scope.find('.aux-widget-faq').each(function (index, el) {
            var faqAccordion = $(this);
            $(this).avertaAccordion({
                items : '.aux-faq-item',
                itemHeader : '.toggle-header',
                itemContent: '.toggle-content',
                oneVisible : $(this).data("toggle") ,
                expandHashItem: false,
                onExpand: function ($item) {
                    var faqAccordionOptions = this;
                    setTimeout(function () {
                        var height = 0;
                        height += $item.outerHeight();
                        $item.siblings(faqAccordionOptions.items).each(function (index, item) {
                            if ($(item).is(faqAccordionOptions.items)) {
                                height += $(item).outerHeight();   
                            }
                        });
                        faqAccordion.find('.aux-isotope-faq').height(height);
                    }, this.showDuration);
                }
            });
        });
    }

    // Timeline
    $.fn.AuxinTimelineInit = function( $scope ){
        $scope = $scope || $(this);

        // init timeline
        $scope.find('.aux-timeline').each( function(){
            if ( $(this).hasClass('aux-right') ){
                $(this).AuxinTimeline( { responsive : { 760: 'right' } } );
            }else{
                $(this).AuxinTimeline();
            }
        });
    }

    // Code highlighter
    $.fn.AuxinCodeHighlightInit = function( $scope ){
        $scope = $scope || $(this);

        // init highlight js
        if(typeof hljs !== 'undefined') {
            $scope.find('pre code').each(function(i, block) {
                hljs.highlightBlock(block);
            });
        }
    }

    // Load More functionality
    $.fn.AuxinLoadMoreInit = function( $scope ){
        $scope = $scope || $(this);

        // init auxin load more functionality
        $scope.find('.widget-container[class*="aux-ajax-type"]').AuxLoadMore();
    }

    // Video Box
    $.fn.AuxinVideoBoxInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-video-box').AuxinVideobox();
    }

    // Image interaction
    $.fn.AuxinImageInteractionInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-frame-cube').AuxinCubeHover();
        $scope.find('.aux-hover-twoway').AuxTwoWayHover();
    }

    // Toggle-able List
    $.fn.AuxinToggleListInit = function( $scope ){
        $scope = $scope || $(this);

        if ( ! $scope.find('.aux-togglable').length ) { return; }
        // togglable lists
        $scope.find('.aux-togglable').AuxinToggleSelected();
    }

    // Masonry Animate
    $.fn.AuxinMasonryAnimateInit = function( $scope ){
        $scope = $scope || $(this);
        // init masonry Animation
        $scope.find('.aux-product-parallax-wrapper').AuxinMasonryAnimate();
    }

    // Select2 Dropdown
    $.fn.AuxinSelect2Init = function( $scope ){
        $scope = $scope || $(this);

        // init select2 dropdown
        $('.aux-custom-dropdown select').select2({
            minimumResultsForSearch: Infinity,
        })

        $('.aux-modern-search-cats').select2({
            minimumResultsForSearch: Infinity,
            dropdownCssClass: 'aux-search-cats-dropdown',
            dropdownAutoWidth: 'true'
        })

    }

    // Carousel Navigation
    $.fn.AuxinCarouselNavigation = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-carousel-navigation').each( function() {
            var $this   = $(this),
                $target = $( $this.data('target') ).find('.master-carousel');

            if ( !$target || typeof AuxinCarousel == 'undefined' ) {
                return ;
            }
            $( $this.data('target') ).each( function(index){
                $target = $( this ).find('.master-carousel')[0];
                if ( $target ) {
                    var instance = AuxinCarousel[$target.getAttribute('data-element-id')];

                    $this.find('.aux-prev').on('click', { action: 'prev' }, instance._controlCarousel.bind( instance ) );

                    $this.find('.aux-next').on('click', { action: 'next' }, instance._controlCarousel.bind( instance ) );
                }
            });

        } );


    }

})(jQuery, window, document);


/* ================== js/src/module.isotope.js =================== */


//tile element

;(function($, window, document, undefined){
    "use strict";

    $.fn.AuxinIsotopeInit = function( $scope ){
        $scope = $scope || $(this);

        $.fn.AuxinIsotopeLayoutInit( $scope );
        $.fn.AuxinIsotopeImageLayoutsInit( $scope );;
        $.fn.AuxinIsotopeBigGridInit( $scope );
        $.fn.AuxinIsotopeFAQInit( $scope );;
    };

    $.fn.AuxinIsotopeImageLayoutsInit = function( $scope ){
        $scope = $scope || $(this);

        $.fn.AuxinIsotopeGalleryInit( $scope );
        $.fn.AuxinIsotopeMasonryInit( $scope );
        $.fn.AuxinIsotopeTilesInit( $scope );
    };

    $.fn.AuxinIsotopeLayoutInit = function( $scope ){
        $scope = $scope || $(this);

        // general isotope layout
        $scope.find('.aux-isotope-layout').AuxIsotope({
            itemSelector:'.aux-iso-item',
            revealTransitionDuration  : 600,
            revealBetweenDelay        : 50,
            revealTransitionDelay     : 0,
            hideTransitionDuration    : 300,
            hideBetweenDelay          : 0,
            hideTransitionDelay       : 0,
            updateUponResize          : true,
            transitionHelper          : true
        });
    }

    $.fn.AuxinIsotopeGalleryInit = function( $scope ){
        $scope = $scope || $(this);

        // init gallery
        $scope.find(".aux-gallery .aux-gallery-container").AuxIsotope({
            itemSelector:'.gallery-item',
            justifyRows: {maxHeight: 340, gutter:0},
            masonry: { gutter:0 },
            revealTransitionDuration  : 600,
            hideTransitionDuration    : 600,
            revealBetweenDelay        : 70,
            hideBetweenDelay          : 40,
            revealTransitionDelay     : 0,
            hideTransitionDelay       : 0,
            updateUponResize          : true,
            transitionHelper          : true,
            deeplink                  : false
        });
    }

    $.fn.AuxinIsotopeTilesInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find(".aux-tiles-layout").AuxIsotope({
            itemSelector        :'.aux-post-tile, .aux-iso-item',
            layoutMode          : 'packery',
            revealTransitionDuration  : 600,
            hideTransitionDuration    : 600,
            revealBetweenDelay        : 70,
            hideBetweenDelay          : 40,
            revealTransitionDelay     : 0,
            hideTransitionDelay       : 0,
            updateUponResize          : true,
            transitionHelper          : true,
            packery: {
                gutter      : 0
            },
            containerStyle : {
                position : '',
            },
        }).on( 'auxinIsotopeReveal', function( e, items ){
            items.forEach( function( item, index ) {
                // update image alignment inside the tiles upon pagination
                if ( item.$element.hasClass( 'aux-image-box' ) ) {
                    item.$element.AuxinImagebox('update');
                }
            } );
        });
    }

    $.fn.AuxinIsotopeBigGridInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find(".aux-big-grid-layout").AuxIsotope({
            itemSelector        :'.aux-news-big-grid, .aux-iso-item',
            layoutMode          : 'packery',
            revealTransitionDuration  : 600,
            hideTransitionDuration    : 600,
            revealBetweenDelay        : 70,
            hideBetweenDelay          : 40,
            revealTransitionDelay     : 0,
            hideTransitionDelay       : 0,
            updateUponResize          : true,
            transitionHelper          : true,
            packery: {
                gutter      : 0,
            }
        }).on( 'auxinIsotopeReveal', function( e, items ){
            items.forEach( function( item, index ) {
                // update image alignment inside the tiles upon pagination
                if ( item.$element.hasClass( 'aux-image-box' ) ) {
                    item.$element.AuxinImagebox('update');
                }
            } );
        });
    }

    $.fn.AuxinIsotopeMasonryInit = function( $scope ){
        $scope = $scope || $(this);

        // init masonry
        $scope.find(".aux-masonry-layout").AuxIsotope({
            itemSelector        :'.aux-post-masonry',
            layoutMode          : 'masonry',
            updateUponResize    : true,
            transitionHelper    : false,
            transitionDuration  : 0
        });
    }

    $.fn.AuxinIsotopeFAQInit = function( $scope ){
        $scope = $scope || $(this);

        // faq element isotope
        $scope.find('.aux-isotope-faq').AuxIsotope({
            itemSelector:'.aux-iso-item',
            revealTransitionDuration  : 600,
            hideTransitionDuration    : 600,
            revealBetweenDelay        : 70,
            hideBetweenDelay          : 40,
            revealTransitionDelay     : 0,
            hideTransitionDelay       : 0,
            updateUponResize          : false,
            transitionHelper          : true
        }).on('auxinIsotopeReveal',function(){
            $scope.find('.aux-iso-item').css({
                'position' : ''
            });
        });
    }

})(jQuery, window, document);


/* ================== js/src/module.page-animation.js =================== */


;(function ( $, window, document, undefined ) {
    "use strict";

    // Page preload animation init
    $.fn.AuxinPagePreloadAnimationInit = function( $scope ){
        $scope = $scope || $(this);

        // preload and init page animation
        var $innerBody       = $scope.find('#inner-body'),
            $body            = $scope.find('body'),
            transitionTarget,
            animationConfig;

        if( ! $body.length ){
            return;
        }

        /* ------------------------------------------------------------------------------ */
        // page animation timing config
        var pageAnimationConfig = {
            fade: {
                eventTarget: '.aux-page-animation-overlay',
                propertyWatch: 'opacity',
                hideDelay: 800,
                loadingHideDuration: 810
            },

            circle: {
                eventTarget: '#inner-body',
                propertyWatch: 'transform',
                hideDelay: 1000,
                loadingHideDuration: 810
            },

            cover: {
                eventTarget: '.aux-page-animation-overlay',
                propertyWatch: 'transform',
                hideDelay: 500,
                loadingHideDuration: 810
            },

            slideup: {
                eventTarget: '.aux-page-animation-overlay',
                propertyWatch: 'transform',
                hideDelay: 500,
                loadingHideDuration: 810
            }
        },
        progressbarHideDuration = 700;

        /* ------------------------------------------------------------------------------ */

        if ( $body.hasClass( 'aux-page-preload' ) ) {
            var $pageProgressbar = $scope.find('#pagePreloadProgressbar'),
                pageLoading = document.getElementById( 'pagePreloadLoading' );

            $(window).on( 'load.preload', function( instance ) {

                if ( $body.data( 'page-animation' ) && Modernizr && Modernizr.csstransitions ) {
                    setupPageAnimate();
                } else {
                    if ( pageLoading ) {
                        setTimeout( function() {
                            pageLoading.style.display = 'none';
                        }, 810 );
                    }
                }

                $body.addClass( 'aux-page-preload-done' );

                if ( $pageProgressbar.length ) {
                    var pageProgressbar = $pageProgressbar[0];
                    pageProgressbar.style.width = pageProgressbar.offsetWidth + 'px';
                    $pageProgressbar.removeClass('aux-no-js');
                    pageProgressbar.style[ window._jcsspfx + 'AnimationPlayState' ] = 'paused';

                    setTimeout( function(){
                        pageProgressbar.style.width = '100%';
                        $pageProgressbar.addClass( 'aux-hide' );
                        $body.addClass( 'aux-progressbar-done' );
                    }, 10 );

                    setTimeout( function(){
                        pageProgressbar.style.display = 'none';
                    }, progressbarHideDuration );
                }
            });

            window.onerror = function( e ) {
                $pageProgressbar.addClass( 'aux-hide' );
                $body.addClass( 'aux-page-preload-done' );
                $(window).off( 'load.preload' );
            }

        } else {

            // Using this event handler in your page prevents Firefox
            // from caching the page in the in-memory bfcache.

            // Firefox Fix
            $(window).on( "unload", function () { $(window).off('unload'); });

            // IOS Safari Fix
            $(window).on('pageshow', function(event) {
                if (event.originalEvent.persisted) {
                    window.location.reload()
                }
            });

            if ( document.visibilityState === 'hidden' ) {
                document.addEventListener("visibilitychange", function () {
                    if (!document.hidden) {
                        setupPageAnimate()
                    }
                  }, false);
            } else {
                setupPageAnimate()
            }

        }

        function setupPageAnimate() {
            // disable page animation in old browsers
            if ( Modernizr && !Modernizr.csstransitions ) {
                return;
            }

            if ( !$body.hasClass( 'aux-page-animation' ) ) {
                return;
            }

            var animType         = $body.data('page-animation-type');

            animationConfig  = pageAnimationConfig[animType];
            transitionTarget = $(pageAnimationConfig[animType].eventTarget)[0];

            transitionTarget.addEventListener( 'transitionend', pageShowAnimationDone );

            $( 'a:not([href^="\#"]):not([href=""]), .elementor-template-canvas' ).AuxinAnimateAndRedirect( {
                scrollFixTarget      : '#inner-body',
                delay       : animationConfig.hideDelay,
                //  disableOn   : '.aux-lightbox-frame, ul.tabs, .aux-gallery .aux-pagination',
                animateIn   : 'aux-page-show-' + animType,
                animateOut  : 'aux-page-hide-' + animType,
                beforeAnimateOut  : 'aux-page-before-hide-' + animType
            });
        }

        function pageShowAnimationDone( e ) {
            if ( e.target === transitionTarget && e.propertyName.indexOf( animationConfig.propertyWatch ) !== -1 ) {
                $body.addClass( 'aux-page-animation-done' );

                // this line using for elementor stretch container option
                if ( 'circle' === $body.data('page-animation-type') ) $body.trigger('resize');

                transitionTarget.removeEventListener( 'transitionend', pageShowAnimationDone );

                var pageAnimationDoneEvent = new CustomEvent( 'AuxPageAnimationDone' );
                document.body.dispatchEvent(pageAnimationDoneEvent);

                $.fn.AuxinAppearAnimationsInit( $body );
            }
        }
    }

    // Page cover animation
    $.fn.AuxinPageCoverAnimation = function(){
        var $this      = $(this),
            $window    = $(window),
            fired      = false,
            scrollLock = true,
            posTop;

        $this.closest('body').addClass('aux-page-cover');

        $window.on('scroll', function(){
            if( scrollLock && ! fired ){
                $window.scrollTo(0);
                $('body').addClass('aux-page-cover-off');
            } else if ( window.elementorFrontendConfig && 0 === $window.scrollTop() ){

                if ( window.elementorFrontendConfig.isEditMode ) {
                    $('body').removeClass('aux-page-cover-off');
                }
            }
        });

        $this.on('transitionend webkitTransitionEnd oTransitionEnd', function (e) {
            if (e.originalEvent.propertyName !== 'transform') return;

            posTop = $this.offset().top ;

            if ( posTop !== 0 ){
                fired = true;
                scrollLock = false;
            } else {
                fired = false;
                scrollLock = true;
            }
        });

        $this.find('.aux-page-cover-footer-text a').on('click', function(){
            $('body').addClass('aux-page-cover-off');
        });

    };

    // Page cover animation init
    $.fn.AuxinPageCoverAnimationInit = function( $scope ){
        $scope = $scope || $(this);

        if ( $scope.hasClass('aux-page-cover-wrapper') ){
            $scope.AuxinPageCoverAnimation();
        } else {
            $scope.find('.aux-page-cover-wrapper').each( function() {
                $(this).AuxinPageCoverAnimation();
            });
        }
    };

    // Set on appear
    $.fn.AuxinSetOnApearInit = function(){

        if ( $.fn.appearl ) {
            var appearBuffer = 0,
                appearTo;

            $.fn.setOnAppear = function( once, delay ) {
                return $(this).each( function( index, element ) {
                    var $element = $(element);
                    $element.appearl();
                    $element[ once ? 'one' : 'on']( 'appear', function(){
                        if ( delay && !$element.hasClass( 'aux-appeared-once' ) ) {
                            element.style.transitionDelay = (appearBuffer++) * delay + 'ms';
                            appearTo = setTimeout( function() {
                                appearBuffer = 0;
                            }, 10);
                        }

                        $element.addClass( 'aux-appeared-once' );
                        $element.addClass( 'aux-appeared' ).removeClass( 'aux-disappeared' );
                    });

                    if ( !once ){
                        $element.on( 'disappear', function(){
                            $element.removeClass( 'aux-appeared' ).addClass( 'aux-disappeared' );
                        });
                    }

                });
            }
        }
    };

    // InView Transitions
    $.fn.AuxinAppearTransitionsInit = function( $scope ){
        $scope = $scope || $(this);

        // InView Transitions
        $scope.find('.aux-check-appear, .aux-appear-watch:not(.aux-appear-repeat)').appearl({
            offset: '150px',
            insetOffset:'0px'
        }).one( 'appear', function(event, data) {
            this.classList.add('aux-appeared');
            this.classList.add('aux-appeared-once');
        });

        $scope.find('.aux-check-appear, .aux-appear-watch.aux-appear-repeat').appearl({
            offset: '150px',
            insetOffset:'0px'
        }).on( 'appear disappear', function(event, data) {
            if( event.type === 'disappear' ){
                this.classList.remove('aux-appeared');
                this.classList.add('aux-disappeared');
            } else {
                this.classList.remove('aux-disappeared');
                this.classList.add('aux-appeared');
            }
        });

    };

    // InView Animation
    $.fn.AuxinAppearAnimationsInit = function( $scope ){
        $scope = $scope || $(this);

        var $target      = $scope.hasClass('aux-appear-watch-animation') ? $scope: $scope.find('.aux-appear-watch-animation');

        if( ! $target.length ){
            return;
        }

        function appear() {
            $target.appearl({
                offset: '200px',
                insetOffset:'0px'
            }).one( 'appear', function(event, data) {
                this.classList.add('aux-animated');
                this.classList.add('aux-animated-once');
            });
        }

        if ( document.visibilityState === 'hidden' ) {
            document.addEventListener("visibilitychange", function () {
                if (!document.hidden) {
                    appear();
                }
              }, false);
        } else {
            appear();
        }


    };

})(jQuery, window, document);


/* ================== js/src/module.page.js =================== */


/**
 * Page Modules
 */
;(function($, window, document, undefined){

    // Page Layout
    $.fn.AuxinPageLayoutInit = function( $scope ){
        $scope = $scope || $(this);

        $(function(){
            // general sticky init
            $scope.find('.aux-sticky-side > .entry-side, .aux-sticky-piece').AuxinStickyPosition();
        });

        // float layout init
        var isResp = $scope.find('body').hasClass( 'aux-resp' );
        $scope.find('.aux-float-layout').AuxinFloatLayout({ autoLocate: isResp });
    };

    // Match heights
    $.fn.AuxinMatchHeightInit = function( $scope ){
        $scope = $scope || $(this);
        // init matchHeight
        $scope.find('.aux-match-height > .aux-col').matchHeight();
    };

    // Page Header Layout
    $.fn.AuxinPageHeaderLayoutInit = function( $scope ){
        $scope = $scope || $(this);

        var $window = $(window),
            $siteHeader = $scope.find('#site-header, #site-elementor-header'),
            headerStickyHeight = $siteHeader.data('sticky-height') || 0;

        if ( $siteHeader.find( '.secondary-bar' ).length ) {
            headerStickyHeight += 35; // TODO: it should changed to a dynamic way in future
        }

        // header sticky position
        if ( $scope.find('body').hasClass( 'aux-top-sticky' ) ) {
            $siteHeader.AuxinStickyPosition();
        }

        // fullscreen header
        $scope.find('.page-header.aux-full-height').AuxinFullscreenHero();

        // scroll to bottom in title bar
        if ( jQuery.fn.scrollTo ) {
            var $scrollToTarget = $scope.find('#site-title');
            $scope.find('.aux-title-scroll-down .aux-arrow-nav').on( 'click', function(){
                var target = $scrollToTarget.offset().top + $scrollToTarget.height() - headerStickyHeight;
                $window.scrollTo( target , {duration: 1500, easing:'easeInOutQuart'}  );
            });
        }
    };

    // Modern form
    $.fn.AuxinModernForm = function( $scope ){
        $scope = $scope || $(this);

        var groupClass = '.aux-input-group',
            focusClass = 'aux-focused',
            $allFields = $scope.find( groupClass + ' input ,' + groupClass + ' textarea' );

        if ( $allFields.val()){
            $allFields.each( function(){
                if( $scope.val() ) {
                    $scope.parents( groupClass ).addClass( focusClass );
                }
            });
        };


        $allFields.on('focus', function(){
            $(this).parents( groupClass ).addClass( focusClass );
        })
        .on('blur', function(){
            if ( $(this).val() === '' ) {
                $(this).parents( groupClass ).removeClass( focusClass);
            }
        });

    };

    // Modern form init
    $.fn.AuxinModernFormInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-modern-form').each( function(){
            $(this).AuxinModernForm();
        });
    };

    // Dropdown Click/Hover
    $.fn.AuxinDropdownEffect = function( $scope ){
        $basketWrapper = $scope || $(this);

        var isHover       = $basketWrapper.find( '.aux-action-on-hover' ).length,
            dropdownClass       = 'aux-cart-display-dropdown',
            $dropdownWrapper = $basketWrapper.find('.aux-card-dropdown');

        $(window).on('load resize', function() {
            if( $dropdownWrapper.length ){
                var offsetRight = $dropdownWrapper.offset().left  + $dropdownWrapper.outerWidth();

                if ( offsetRight > $(window).width() && ! $dropdownWrapper.hasClass('aux-card-dropdown-resp') ) {
                    $dropdownWrapper.addClass('aux-card-dropdown-resp');
                } else {
                    $dropdownWrapper.removeClass('aux-card-dropdown-resp');
                }
            }
        });

        if (  isHover  ) {
            $basketWrapper.each(function(){
                var $basket = $(this);
                $basket.on('mouseover', function () {
                    $basket.addClass( dropdownClass )
                });

                $(document).on('mouseover', function(e){
                    if ( ! $( e.target ).closest( $basket ).length ) {
                        $basket.removeClass( dropdownClass );
                    }
                });
            });

        } else {
            $basketWrapper.each(function(){
                var $basket = $(this);
                $basket.on( 'click', function () {
                    $basket.addClass( dropdownClass )
                });
                $(document).on( 'click', function(e){
                    if ( ! $( e.target ).closest( $basket ).length ) {
                        $basket.removeClass( dropdownClass );
                    }
                });
            });
        }
    };

    // Dropdown Click/Hover init
    $.fn.AuxinDropdownEffectInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-top-header .aux-cart-wrapper, .site-header-section .aux-cart-wrapper, .aux-cart-element').each(function() {
            $(this).AuxinDropdownEffect();
        });
    };

    // Shopping Cart Canvas Menu
    $.fn.AuxinCartCanvasInit = function( $scope ){
        $scope = $scope || $(this);

        // Cart elements
        var $headerElement = $scope.find('.site-header-section');
        if ( !$headerElement.length )
            $headerElement = $scope.find('.aux-cart-element-container');

        if ( !$headerElement.length )
            return;

        $cartWrapper       = $headerElement.find('.aux-cart-wrapper'),
        $cartDropdown      = $headerElement.find('.aux-card-dropdown'),
        $burgerBasket      = $headerElement.find('.aux-shopping-basket'),
        $basketContainer   = $scope.find('#offcart'),
        isClosed           = true;

        // Append cart content to the offcanvas menu
        $cartDropdown.clone().appendTo( $basketContainer.find('.aux-offcart-content') );

        // check responsive state of cart - offcanvas or dropdown state
        if ( $cartWrapper.hasClass('aux-cart-type-offcanvas') ) {
            $basketContainer.find('.aux-offcart-content .aux-card-dropdown').removeClass('aux-desktop-off aux-tablet-off');
        } else {
            if ( $cartDropdown.hasClass('aux-tablet-off') ) {
                $basketContainer.find('.aux-offcart-content .aux-card-dropdown').removeClass('aux-tablet-off');
            }
        }

        // Add canvas dark class
        if( $cartDropdown.hasClass('aux-card-dropdown-dark') ) {
            $basketContainer.addClass('aux-offcanvas-dark');
        }

        // Remove dropdown hidden class from canvas container
        $basketContainer.find('.aux-card-dropdown').removeClass('aux-phone-off');

        // Toggle canvas open/close classes
        function toggleOffcanvasBasket() {
            if ( $('body').hasClass('woocommerce-cart') || $('body').hasClass('woocommerce-checkout') ) {
                return;
            }
            $basketContainer.toggleClass( 'aux-open' );
            $scope.toggleClass( 'aux-offcanvas-overlay' );
            isClosed = !isClosed;
        }

        // Display offcanvas on click icon button
        $burgerBasket.on( 'click', toggleOffcanvasBasket );

        // Hide offcanvas on click close button
        $basketContainer.find('.aux-close').on( 'click', toggleOffcanvasBasket );

        $(window).on( 'load resize', function() {
            var $dropDownCheck = false; // check if cart style is dropdown or offcanvas

            if ( window.innerWidth > 767 && $cartWrapper.hasClass('aux-cart-type-dropdown') ) {
                if ( window.innerWidth < 1025 ) {
                    if ( !$cartDropdown.hasClass('aux-tablet-off') ) {
                        $dropDownCheck = true;
                    }
                } else {
                    $dropDownCheck = true;
                }
            }

            if ($dropDownCheck) {
                $basketContainer.hide();
                if( !isClosed ){
                    $scope.removeClass( 'aux-offcanvas-overlay' );
                }
            } else {
                $basketContainer.show();
                if( !isClosed ){
                    $scope.addClass( 'aux-offcanvas-overlay' );
                }
            }
        });

        // close offcanvas cart when clicking outside of cart
        $(document).on('click', function(e) {
            if ( !$(e.target).parents('.aux-cart-wrapper').length && !$(e.target).is('.aux-cart-wrapper') && !$(e.target).parents('#offcart').length && !$(e.target).is('#offcart') ) {
                if ( !isClosed ) {
                    toggleOffcanvasBasket();
                }
            }
        });
    }

    // DropDown For Filters
    $.fn.AuxinDropDownSelect = function( $scope ){
        $scope = $scope || $(this);
        $this = $scope.hasClass('aux-dropdown-filter') ? $scope : $scope.find('.aux-dropdown-filter');

        var $DropDown   = $this.find('ul'),
            $FilterBy   = $this.find('.aux-filter-by'),
            $AllOptions = Array.from($DropDown.children('li'));

        function ClassCheck(){
            if ( ! $DropDown.hasClass('aux-active') ) {
                $DropDown.addClass('aux-active');
            } else{
                $DropDown.removeClass('aux-active');
            }
        }

        $FilterBy.on( 'click', function() {
            ClassCheck();
        });

        function InsertText(){
            var $ItemLabel = $(this).text();

            $FilterBy.find('.aux-filter-name').html($ItemLabel);
            ClassCheck();

        }

        if( ! $this.attr('data-insert-text') ){

            for ( var i = 0 ; $AllOptions.length > i ; i++){
                $AllOptions[i].addEventListener('click', InsertText );
            }

        }

        window.addEventListener('click', function(e){

            if ( e.target.className != $FilterBy.attr('class') && e.target.className != $FilterBy.find('.aux-filter-name').attr('class') && e.target.className != $FilterBy.find('.aux-filter-name-current').attr('class') ) {
                if ( $DropDown.hasClass('aux-active') ){
                    $DropDown.removeClass('aux-active');
                }
            }

        });
    }

    // DropDown For Filters init
    $.fn.AuxinDropDownSelectInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-filters.aux-dropdown-filter').each(function() {
            $(this).AuxinDropDownSelect();
        });
    };

    $.fn.AuxinTriggerResize = function( $scope ){
        $scope = $scope || $(window);
        $scope.trigger( 'resize' );
    };

    $.fn.AuxinFeaturedColor = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-featured-color').each(function() {
            var featuredColor = $(this).data('featured-color');
            if( featuredColor != '' ) {
                $(this).css({
                    "background-color": featuredColor ,
                    "color"           : auxin_get_contrast( featuredColor )
                });
            }
        });
    };

    // Scale Element By Scroll
    $.fn.AuxinScrollScale = function( start, target, startScale, endScale ){
        var $this        = $(this),
            $el          = $(start),
            $target      = $(target),
            $window      = $(window),
            endScale     = endScale || 1 ,
            targetHeight = $target.outerHeight(),
            scrollValue,
            elBot,
            scaleValue;

        $window.on('scroll', function(){
            scrollValue = $window.height() + $window.scrollTop();
            elBot        = $el.offset().top + $el.outerHeight();

            if( scrollValue > elBot ) {
                scrollValue = ( scrollValue - elBot ) / targetHeight ;
                scaleValue  = ( startScale - ( scrollValue   * ( startScale - endScale ) ) );

                if ( scaleValue < endScale ){
                    $target[0].style[window._jcsspfx + 'Transform'] = 'scale(' + scaleValue + ')';
                }
            }

        });
    }

    // Scale Element By Scroll Init
    $.fn.AuxinScrollScaleInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.aux-bs-get-started').each(function() {
            $(this).AuxinScrollScale( '.aux-bs-footer-scale', '.aux-subfooter .aux-wrapper', 0.94, 1 );
        });
    };

    /**
     * Opens or closes the overlay container in page
     *
     * @param  {jQuery Element} $overlay
     * @param  {Boolean}        close              Is it closed right now?
     * @param  {Number}         animDuration
     */
    window.auxinToggleOverlayContainer = function( $overlay, close, animDuration ) {
        var anim = $overlay.data( 'anim' ),
            overlay = $overlay[0],
            animDuration = animDuration || 800;

        if ( anim ) {
            anim.stop( true );
        }

        if ( close ) {
            $overlay.css( {
                opacity: 0,
                display: 'block'
            } );

            overlay.style[ window._jcsspfx + 'Transform' ] = 'perspective(200px) translateZ(30px)';
            anim = CTween.animate($overlay, animDuration, {
                transform: 'none', opacity: 1
            }, {
                ease: 'easeOutQuart'
            });

        } else {
            anim = CTween.animate($overlay, animDuration / 2, {
                transform: 'perspective(200px) translateZ(30px)',
                opacity: 0
            }, {
                ease: 'easeInQuad',
                complete: function() {
                    $overlay.css( 'display', 'none' );
                }
            });
        }

        $overlay.data( 'anim', anim );

    };

    // Offcanvas and overlay menu
    $.fn.AuxinMobileMenuInit = function( $scope ){
        $scope = $scope || $(this);

        var $burgerBtns = $scope.find('.aux-burger-box');
            $window     = $(window);

        $burgerBtns.each(  function( button ) {

            var args = {
                menu         : $( $(this).data( 'target-content') ),
                icon         : $(this).find('>.aux-burger'),
                isClosed     : true,
                animDuration : 600,
                type         : $(this).data( 'target-panel' ),
                anim         : null,
            }

            var isInit = $(this).data('init');

            if ( isInit ) {
                 return
            }

            $(this).data('init', true);

            args.scrollToLinks = args.menu.find( '.aux-menu-item > a[href^="#"]' );
            args.targetWrapper = $( args.menu.data( 'switch-parent' ) );
            args.activeWidth   = args.menu.data( 'switch-width' )

            /* Functions */
            /* ------------------------------------------------------------------------------ */

            args.toggleExpnadableMenu = function() {
                args.icon.toggleClass( 'aux-close' );

                if ( args.anim ) {
                    args.anim.stop( true );
                }

                if ( args.isClosed ) {
                    args.anim = CTween.animate(args.targetWrapper, args.animDuration, { height: args.menu.outerHeight() + 'px' }, {
                        ease: 'easeInOutQuart',
                        complete: function() {
                            args.targetWrapper.css( 'height', 'auto' );
                        }
                    } );
                } else {
                    args.targetWrapper.css( 'height', args.menu.outerHeight() + 'px' );
                    args.anim = CTween.animate(args.targetWrapper, args.animDuration, { height: 0 }, { ease: 'easeInOutQuart' } );
                }

                args.isClosed = !args.isClosed;

            }

            /* ------------------------------------------------------------------------------ */

            args.toggleOffcanvasMenu = function () {
                args.icon.toggleClass( 'aux-close' );
                args.targetWrapper.toggleClass( 'aux-open' );
                args.isClosed = !args.isClosed;
            }

            /* ------------------------------------------------------------------------------ */

            args.toggleOverlayMenu = function () {
                args.icon.toggleClass( 'aux-close' );
                if ( args.isClosed ) {
                    args.targetWrapper.show();
                }
                auxinToggleOverlayContainer( args.targetWrapper, args.isClosed );
                args.isClosed = !args.isClosed;
            }

            /* ------------------------------------------------------------------------------ */

            args.closeOnEsc = function ( toggleFunction ) {
                $(document).on('keydown', function(e) {
                    if ( e.keyCode == 27 && !args.isClosed ) {
                        toggleFunction();
                    }
                });
            }

            /* ------------------------------------------------------------------------------ */

            switch ( args.type ) {
                case 'toggle-bar':
                    $(this).on( 'click', args.toggleExpnadableMenu );
                    // args.scrollToLinks.on( 'click', args.toggleExpnadableMenu );
                    break;

                case 'offcanvas':
                    args.targetWrapper = args.targetWrapper.closest('.aux-offcanvas-menu ');
                    $(this).on( 'click', args.toggleOffcanvasMenu );
                    args.targetWrapper.find('.aux-close').on( 'click', args.toggleOffcanvasMenu );
                    // args.scrollToLinks.on( 'click', args.toggleOffcanvasMenu );

                    args.dir         = ( args.targetWrapper.hasClass( 'aux-pin-right' ) ? 'right' : 'left' );

                    if ( args.activeWidth !== undefined ) {
                        $window.on( 'resize', function() {
                            if ( window.innerWidth > args.activeWidth ) {

                                args.targetWrapper.hide();
                            } else {
                                if ( !args.isClosed ) {

                                }
                                args.targetWrapper.show();
                            }
                        });
                    }

                    args.closeOnEsc( args.toggleOffcanvasMenu );
                    break;

                case 'overlay':
                var isBurger = !!args.menu,
                    oldSkinClassName;

                args.targetWrapper = args.targetWrapper.closest('.aux-fs-popup');

                if ( !isBurger ) {
                    oldSkinClassName = args.menu.attr( 'class' ).match( /aux-skin-\w+/ )[0];
                }

                $(this).on( 'click', args.toggleOverlayMenu );
                args.targetWrapper.find( '.aux-panel-close' ).on( 'click', args.toggleOverlayMenu );

                var checkForHide = function() {
                    if ( window.innerWidth > args.activeWidth ) {
                        args.targetWrapper.hide();

                        if ( !isBurger ) {
                            args.menu.addClass( oldSkinClassName );
                        }

                    } else {
                        if ( !args.isClosed ) {
                            args.targetWrapper.show();
                        }

                        if ( !isBurger ) {
                            args.menu.removeClass( oldSkinClassName );
                        }

                    }
                }

                if ( args.activeWidth !== undefined ) {
                    checkForHide();
                    $window.on( 'resize', checkForHide );
                }

                args.closeOnEsc( args.toggleOverlayMenu );

            }

        })

    };

    // Overlat Search
    $.fn.AuxinOverlaySearchInit = function( $scope ){
        $scope = $scope || $(this);

        // fullscreen/overlay search
        var overlaySearchIsClosed = true,
            overlaySearchContainer = $scope.find('#fs-search'),
            searchField = overlaySearchContainer.find( 'input[type="text"]' );

        $scope.find('.aux-overlay-search').on( 'click', toggleOverlaySearch );
        overlaySearchContainer.find( '.aux-panel-close' ).on( 'click', toggleOverlaySearch );

        $(document).on('keydown', function(e) {
            if ( e.keyCode == 27 && !overlaySearchIsClosed ) {
                toggleOverlaySearch();
            }
        });

        function toggleOverlaySearch() {
            auxinToggleOverlayContainer( overlaySearchContainer, overlaySearchIsClosed );
            overlaySearchIsClosed = !overlaySearchIsClosed;
            if ( !overlaySearchIsClosed ) {
                searchField.focus();
            }
        };
    }
    // Overlay Modern Search
    $.fn.AuxinOverlayModernSearchInit = function( $scope ){
        $scope = $scope || $(this);

        var $searchBoxes = $scope.find( '.aux-search-fullscreen' );

        $searchBoxes.each( function() {
            var $this = $(this),
                target = $this.data('target');

            if ( !target ) {
                return;
            }

            var $target = $scope.find( target );

            if ( !target ) {
                return;
            }

            var $closeBtn       = $target.find( '.aux-panel-close' ),
                $searchField    = $target.find( '.aux-search-field' ),
                overlayIsClosed = true;

            if ( document.getElementById('wpadminbar')) {
                $target.css({top: '32px'})
            }

            // Listeners
            $this.on( 'click' , function() {
                auxinToggleOverlayContainer( $target, overlayIsClosed );
                overlayIsClosed = !overlayIsClosed;

                if ( !overlayIsClosed ) {
                    $searchField.focus();
                }

            } );

            $closeBtn.on( 'click' , function() {
                auxinToggleOverlayContainer( $target, overlayIsClosed );
                overlayIsClosed = !overlayIsClosed;
            } );

            $(document).on('keydown', function(e) {
                if ( e.keyCode == 27 && !overlayIsClosed ) {
                    auxinToggleOverlayContainer( $target, overlayIsClosed );
                    overlayIsClosed = !overlayIsClosed;
                }
            });

        } );


    }

    // Menu Auto Switch
    $.fn.AuxinMenuAutoSwitchInit = function( $scope ){
        $scope = $scope || $(this);

        var isResp = $('body').hasClass( 'aux-resp' );

        // init Master Menu
        if ( !isResp && $scope.find('.aux-master-menu').data( 'switch-width' ) < 7000 ) {
            // disable switch if layout is not responsive
            $scope.find('.aux-master-menu').data( 'switch-width', 0 );
        }

        if ( $scope.find('.aux-fs-popup').hasClass('aux-no-indicator') ){
            $scope.find('.aux-master-menu').mastermenu( { useSubIndicator: false , addSubIndicator: false} );
        } else if ( $('body').hasClass( 'aux-vertical-menu' ) ) {  // Disable CheckSubmenuPosition in Vertical Menu
            $scope.find('.aux-master-menu').mastermenu( { keepSubmenuInView: false } );
        } else{
            $scope.find('.aux-master-menu').mastermenu( /*{openOn:'press'}*/ );
        }
    };

    $.fn.AuxinCurrentAnchorDetect = function( $scope ) {
        $scope = $scope || $(this) ;

        var $anchors = $('a[href*="#"]'),
            currentClass = 'current-menu-item',
            currentClassTarget = '.aux-menu-item';

        $anchors.each( function( index, element ) {

            // abort on invalid hash IDs
            if( !! element.hash.match(/[^A-Za-z0-9-#]/g) ){
                return;
            }

            var $target = $(element.hash);

            if ( !$target.length ) {
                return
            }

            function toggleClass() {
                var boundaries    = $target[0].getBoundingClientRect();
                    delta         = Math.floor( Math.min( Math.max( (boundaries.y + boundaries.height) / window.innerHeight , -1 ), 1 ) ),
                    currentTarget = element.closest( currentClassTarget );

                if ( !currentTarget ) {
                    return
                }


                if ( delta === 0 ) {
                    if ( !currentTarget.classList.contains(currentClass) ) {
                        currentTarget.classList.add(currentClass);
                    }
                } else {
                    if ( currentTarget.classList.contains(currentClass) ) {
                        currentTarget.classList.remove(currentClass);
                    }
                }
            }

            toggleClass();
            $(window).on('scroll', toggleClass)

        })

    }


})(jQuery, window, document);


/* ================== js/src/module.resize.js =================== */


/**
 * Page resize scripts
 */
;(function($){

    var $_window                = $(window),
        $body                   = $('body'),
        screenWidth             = $_window.width(),
        $main_content           = $('#main'),
        breakpoint_tablet       = 768,
        breakpoint_desktop      = 1024,
        breakpoint_desktop_plus = 1140,
        original_page_layout    = '',
        layout_class_names      = {
            'right-left-sidebar' : 'right-sidebar',
            'left-right-sidebar' : 'left-sidebar',
            'left2-sidebar'      : 'left-sidebar',
            'right2-sidebar'     : 'right-sidebar'
        };


    function updateSidebarsHeight() {

        screenWidth = window.innerWidth;

        var $content   = $('.aux-primary');
        var $sidebars  = $('.aux-sidebar');

        var max_height = $('.aux-sidebar .sidebar-inner').map(function(){
            return $(this).outerHeight();
        }).get();

        max_height = Math.max.apply(null, max_height);
        max_height = Math.max( $content.outerHeight(), max_height );
        $sidebars.height( screenWidth >= breakpoint_tablet ? max_height : 'auto' );

        // Switching 2 sidebar layouts on mobile and tablet size
        // ------------------------------------------------------------

        // if it was not on desktop size
        if( screenWidth <= breakpoint_desktop_plus ){

            for ( original in layout_class_names) {
                if( $main_content.hasClass( original ) ){
                    original_page_layout =  original;
                    $main_content.removeClass( original ).addClass( layout_class_names[ original ] );
                    return;
                }
            }

        // if it was on desktop size
        } else if( '' !== original_page_layout ) {
            $main_content.removeClass('left-sidebar')
                         .removeClass('right-sidebar')
                         .addClass( original_page_layout );

            original_page_layout = '';
        }
    };


    // overrides instagram feed class and updates sidebar height on instagram images load
    if ( window.instagramfeed ) {
        var _run = instagramfeed.prototype.run;
        instagramfeed.prototype.run = function() {
            var $target = $(this.options.target);
            if ( $target.parents( '.aux-sidebar' ).length > 0 ) {
                var _after = this.options.after;
                this.options.after = function() {
                    _after.apply( this, arguments );
                    $target.find('img').one( 'load', updateSidebarsHeight );
                };
            }
            _run.apply( this, arguments );
        };
    }


    // if site frame is enabled
    if( $body.data('framed') ){

        // disable frame on small screens
        $_window.on( "debouncedresize", function(){
            $body.toggleClass('aux-framed', $_window.width() > 700 );
        });

    }

    if( $body.hasClass("aux-sticky-footer") ){

        // update the
        $_window.on( "debouncedresize", function(){

            var marginFrameThickness = $body.hasClass('aux-framed') ? $('.aux-side-frames').data('thickness') : 0,

                $footer            = $(".aux-site-footer, .aux-elementor-footer"),
                $subfooter         = $(".aux-subfooter"),
                $subfooterBar      = $(".aux-subfooter-bar"),
                footerHeight       = $footer.is(":visible") ? $footer.outerHeight() : 0;
                subfooterHeight    = $subfooter.is(":visible") ? $subfooter.outerHeight() : 0;
                subfooterBarHeight = $subfooterBar.is(":visible") ? $subfooterBar.outerHeight() : 0;
            
            if( screenWidth <= breakpoint_tablet ){
                $('body').removeClass('aux-sticky-footer');
                $("#main").css( "margin-bottom", "" );
                $footer.css( "bottom");
                $subfooter.css( "bottom", "" );
                $subfooterBar.css( "bottom", "" );
            } else{

                if ( ! $body.hasClass("aux-sticky-footer") ) {
                    $('body').addClass('aux-sticky-footer');
                }

                $("#main").css( "margin-bottom", footerHeight + subfooterHeight + subfooterBarHeight );
                $footer.css( "bottom", marginFrameThickness );
                $subfooter.css( "bottom", footerHeight + marginFrameThickness );
                $subfooterBar.css( "bottom", footerHeight + subfooterHeight + marginFrameThickness );
            } 
            
        });

    }

    $_window.on( "debouncedresize", updateSidebarsHeight ).trigger('debouncedresize');


    $(document).on( 'lazyloaded', function(){
        $_window.trigger('resize');
    });

})(jQuery);

/*--------------------------------------------*/


;


/* ================== js/src/module.socials.js =================== */


/**
 * Socials Modules
 */
;(function($, window, document, undefined){
    "use strict";

    $.fn.AuxinJsSocialsInit = function( $scope ){
        $scope = $scope || $(this);

        var $shareButtons       = $scope.find(".aux-tooltip-socials"),        // share buttons
            mainWrapperClass    = 'aux-tooltip-socials-container',  // class for main container for button and tooltip
            tooltipWrapperClass = 'aux-tooltip-socials-wrapper';    // class for wrapper of tooltip

        if( ! $shareButtons.length ){
            return;
        }

        for ( var i = 0, l = $shareButtons.length; i < l; i++ ) {

            $shareButtons.eq(i).on( "click", function( e ){
                var $this = $(this);
                e.preventDefault();
                e.stopPropagation();

                if( ! $this.parent( '.' + mainWrapperClass ).length ){
                    // wrap the button within a container
                    $this.wrap( "<div class='"+mainWrapperClass+"'></div>" );

                    // append a wrapper for tooltip in main container
                    var $container = $this.parent( '.' + mainWrapperClass );
                        $container.append( "<div class='"+tooltipWrapperClass+"'></div>" );

                    // ini the social links after clicking the main share button
                    $container.children( "." + tooltipWrapperClass ).jsSocials({
                        shares: [
                            {
                                share: "facebook",
                                label: "Facebook",
                                logo : "auxicon-facebook"
                            },
                            {
                                share: "twitter",
                                label: "Tweet",
                                logo : "auxicon-twitter"
                            },
                            {
                                share: "googleplus",
                                label: "Google Plus",
                                logo : "auxicon-googleplus"
                            },
                            {
                                share: "pinterest",
                                label: "Pinterest",
                                logo : "auxicon-pinterest"
                            },
                            {
                                share: "linkedin",
                                label: "LinkedIn",
                                logo : "auxicon-linkedin"
                            },
                            {
                                share: "stumbleupon",
                                label: "Stumbleupon",
                                logo : "auxicon-stumbleupon"
                            },
                            {
                                share: "whatsapp",
                                label: "WhatsApp",
                                logo : "auxicon-whatsapp"
                            },
                            {
                                share: "pocket",
                                label: "Pocket",
                                logo : "auxicon-pocket"
                            },
                            {
                                share: "email",
                                label: "Email",
                                logo : "auxicon-email"
                            },
                            {
                                share: "telegram",
                                label: "Telegram",
                                logo : "auxicon-paperplane"
                            },
                        ],
                        shareIn: 'blank',
                        showLabel: false
                    });
                }

                // toggle the open class by clicking on share button
                $this.parent( "." + mainWrapperClass ).addClass('aux-tip-open').removeClass('aux-tip-close');
            });

        }

        // hide tooltip if outside the element was click
        $(window).on( "click", function() {
            $scope.find( "." + mainWrapperClass ).removeClass('aux-tip-open').addClass('aux-tip-close');
        });

    }

})(jQuery, window, document);


/* ================== js/src/modules.init.js =================== */


/**
 * Initialize All Modules
 */
;(function($, window, document, undefined){

    /**
     * Initializes static modules in page
     */
    window.AuxinInitPageModules = function( $scope ){
        $scope = $scope || $(document);

        // Init set on appear
        $.fn.AuxinSetOnApearInit( $scope );

        // Init Share Btns
        $.fn.AuxinJsSocialsInit( $scope );

        // Page Header Layout
        $.fn.AuxinPageHeaderLayoutInit( $scope );

        // Page preload animation init
        $.fn.AuxinPagePreloadAnimationInit( $scope );

        // Page cover animation init
        $.fn.AuxinPageCoverAnimationInit( $scope );

        // Dropdown Click/Hover init
        $.fn.AuxinDropdownEffectInit( $scope );

        // Shopping Cart Canvas Menu init
        $.fn.AuxinCartCanvasInit( $scope );

        // DropDown For Filters init
        $.fn.AuxinDropDownSelectInit( $scope );

       // Auxin Featured Color
        $.fn.AuxinFeaturedColor( $scope );

        // Scale Element By Scroll Init
        $.fn.AuxinScrollScaleInit( $scope );

        // Match heights Init
        $.fn.AuxinMatchHeightInit( $scope );

        // Page Layout
        $.fn.AuxinPageLayoutInit( $scope );

        // Offcanvas and overlay menu init
        $.fn.AuxinMobileMenuInit( $scope );

        // Menu Auto Switch Init
        $.fn.AuxinMenuAutoSwitchInit( $scope );

        // Overlay Search Init
        $.fn.AuxinOverlaySearchInit( $scope );

        // Overlay Modern Search Init
        $.fn.AuxinOverlayModernSearchInit( $scope );

        // Anchor Add Current Class
        $.fn.AuxinCurrentAnchorDetect( $scope );

        // InView Animations init
        $.fn.AuxinAppearAnimationsInit( $scope );

    }

    /**
     * Initializes general modules
     */
    window.AuxinInitElements = function( $scope ){
        $scope = $scope || $(document);

        // Init Tilt
        $.fn.AuxinTiltElementInit( $scope );

        // Init FitVids
        $.fn.AuxinFitVideosInit( $scope );

        // Init Image box
        $.fn.AuxinImageBoxInit( $scope );

        // Init Before After
        $.fn.AuxinBeforeAfterInit( $scope );

        // Init Carousel and Lightbox
        $.fn.AuxinCarouselInit( $scope );

        // Modern form init
        $.fn.AuxinModernFormInit( $scope );

        // Miscellaneous scripts
        $.fn.AuxinOtherElementsInit( $scope );

        // InView Transitions init
        $.fn.AuxinAppearTransitionsInit( $scope );

        // Dynamic image drop shadow init
        $.fn.AuxinDynamicDropshadowInit( $scope );

        // Blur images with scroll - Init
        $.fn.AuxinScrollBlurImageInit( $scope );

    }

    /**
     * Initializes the general modules on doc ready
     */
    window.AuxinInitElementsOnReady = function( $scope ){
        $scope = $scope || $(document);

        // Init Isotope
        $.fn.AuxinIsotopeInit( $scope );

        // Tabs
        $.fn.AuxinLiveTabsInit( $scope );

        // Accordion Element
        $.fn.AuxinAccordionInit( $scope );

        // Timeline
        $.fn.AuxinTimelineInit( $scope );

        // Code highlighter
        $.fn.AuxinCodeHighlightInit( $scope );

        // Load More functionality
        $.fn.AuxinLoadMoreInit( $scope );

        // Video Box
        $.fn.AuxinVideoBoxInit( $scope );

        // Image interaction
        $.fn.AuxinImageInteractionInit( $scope );

        // Toggle-able List
        $.fn.AuxinToggleListInit( $scope );

        // Masonry Animate
        $.fn.AuxinMasonryAnimateInit( $scope );

        // Media Element init
        $.fn.AuxinMediaElementInit( $scope );

        // Parallax Box init
        $.fn.AuxinParallaxBoxInit( $scope );

        // Parallax Section init
        $.fn.AuxinParallaxSectionInit( $scope );

        // Select2 init
        $.fn.AuxinSelect2Init( $scope );

        // Scrollable Anims init
        $.fn.AuxinScrollableAnimsInit( $scope );

        // Ajax Search Init
        $.fn.AuxinAjaxSearch( $scope );

        // Ajax Modern Search Init
        $.fn.AuxinModernSearchAjax( $scope );

        // Carousel Navigation init
        $.fn.AuxinCarouselNavigation( $scope );

    }

    /**
     * Initializes all Auxin modules
     */
    window.AuxinInitAllModules = function( $scope ){
        $scope = $scope || $(document);

        AuxinInitPageModules( $scope );
        AuxinInitElements( $scope );
        AuxinInitElementsOnReady( $scope );
    }

    // Init static modules in page
    AuxinInitPageModules();

    // Init general modules
    AuxinInitElements();

    // Init some modules on doc ready
    $(function(){
        AuxinInitElementsOnReady();
    });

})(jQuery, window, document);


/* ================== js/src/modules.init.visual-builders.js =================== */


/**
 * Initialize Modules on Vidual Editors
 */
;(function($, window, document, undefined){

    var $vcWindow, $__window = $(window);

    // Add js callback for customizer partials trigger
    if( typeof wp !== 'undefined' && typeof wp.customize !== 'undefined' ) {
        if( typeof wp.customize.selectiveRefresh !== 'undefined' ){
            wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
                // Init auxin modules
                AuxinInitAllModules( $('body') );
            });
        }
    }

    // Init Elementor
    // $__window.on('elementor/frontend/init', function (){

    // });

})(jQuery, window, document);