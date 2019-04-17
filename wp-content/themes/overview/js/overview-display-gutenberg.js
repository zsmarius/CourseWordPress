/*
 Copyright (C) 2017-2018 _Y_Power ( ypower.nouveausiteweb.fr )

 This file is part of the OverView WordPress theme package.

 The JavaScript code in this page is free software: you can
 redistribute it and/or modify it under the terms of the GNU
 General Public License (GNU GPL) as published by the Free Software
 Foundation, either version 2 of the License, or (at your option)
 any later version.  The code is distributed WITHOUT ANY WARRANTY;
 without even the implied warranty of MERCHANTABILITY or FITNESS
 FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.
 */

(function(){
    
    'use strict';
    
    var jQ = jQuery.noConflict();

    /* OverView Gutenberg Display main arguments */
    var OverViewGutenbergDisplayArgs = {

	elements: {
	    // OverView Display
	    mainContainer: 'overview-front-page-posts-section-container',
	    splash: 'overview-front-page-posts-section-splash-screen',
	    // OverView Display content
	    contentContainer: 'overview-front-page-section-content-container',
	    contentImgContainer: 'overview-front-page-posts-section-img-container',
	    contentImg: 'overview-front-page-posts-section-img',
	    content: 'overview-front-page-posts-section-content',
	    contentTitle: 'overview-front-page-posts-section-title',
	    contentTags: 'overview-front-page-posts-section-tags',
	    contentMetas: 'overview-front-page-posts-section-metas',
	    contentMetaDate: 'overview-front-page-posts-section-metas-date',
	    contentMetaAuthor: 'overview-front-page-posts-section-metas-author',
	    contentCategories :'overview-front-page-posts-section-metas-categories',
	    contentSingleCategory: 'overview-front-page-posts-category-link',
	    // OverView Display navigation
	    mainNavContainer: 'overview-front-page-display-navigation-container',
	    prevButton: 'overview-front-page-display-navigation-prev-button',
	    mobilePrevButton: 'overview-front-page-display-navigation-mobile-prev-button',
	    nextButton: 'overview-front-page-display-navigation-next-button',
	    mobileNextButton: 'overview-front-page-display-navigation-mobile-next-button'
	},

	classes: {
	    legacySplash: 'overview-single-box-container-splash-screen',
	    legacyActiveSplash: 'overview-splash-active',
	    legacyFadeoutSplash: 'overview-splash-active-fadeout',
	    ovdSplash: 'overview-display-splash',
	    ovdActiveSplash: 'overview-display-splash-active',
	    ovdFadeoutSplash: 'overview-display-splash-fadeout',
	    nextButtonAnimation: 'overview-display-nav-animation-next',
	    prevButtonAnimation: 'overview-display-nav-animation-prev',
	    disabledNav: 'ov-nav-disabled',
	    featuredImgFallback: 'overview-posts-display-default-image-fallback'
	},

	tools: {
	    // set splash size and position
	    setSplash: function( splashEl, reset ){
		if ( reset && reset !== 'reset' ){
		    console.log( '\nERRROR!\nWrong reset argument passed to\'setSplash\'!Reset parameter: \n', reset );
		}
		else if ( ! splashEl ){
		    console.log( '\nERRROR!\nNo splash element passed to\'setSplash\'!Passed splash element: \n', splashEl );
		}
		else {
		    var splashParent = jQ( splashEl ).parent( 'div' ),
			splashOffset = splashParent.offset(),
			isReset = reset && reset === 'reset' ? true : false;
		    splashEl.offset({
			top: ! isReset ? splashOffset.top : '0',
			left: ! isReset ? splashOffset.left : '0'
		    });
		    splashEl.css({
			width: ! isReset ? splashParent.outerWidth() + 'px' : '0px',
			height: ! isReset ? splashParent.outerHeight() + 'px' : '0px'
		    });
		}
	    },
	    // return formatted date
	    formatPostDate: function( date ){
                var formattedDate = {
		    day: parseInt( date.slice( 8, 10 ) ),
		    month:  OVAPIVars.OVLocalLangCalendar[ date.slice( 5, 7 ) ],
		    year: parseInt( date.slice( 0, 4 ) ),
		    time: date.slice( 11 )
		};
                //return outputDate;
		return formattedDate;
            },
	    // return new FA icon
	    buildIcon: function( iconType, iconSize ){
		var newIcon = document.createElement( 'i' );
		newIcon.classList.add( 'fa', 'fa-' + iconType );
		if ( iconSize ){
		    newIcon.classList.add( 'fa-' + iconSize + 'x' );
		}
		newIcon.setAttribute( 'aria-hidden', 'true' );
		return newIcon;
	    },
	    // return featured image fallback icon
            getFeaturedImgFallbackIconCode: function( postFormat ){
		/* switch icon according to post type */
		var fallbackPostIcon;
		switch (postFormat){
		case 'standard':
                    fallbackPostIcon = 'pencil-square';
                    break;
		case 'aside':
                    fallbackPostIcon = 'commenting-o';
                    break;
		case 'audio':
                    fallbackPostIcon = 'volume-up';
                    break;
		case 'chat':
                    fallbackPostIcon = 'comments';
                    break;
		case 'gallery':
                    fallbackPostIcon = 'picture-o';
                    break;
		case 'image':
                    fallbackPostIcon = 'camera';
                    break;
		case 'link':
                    fallbackPostIcon = 'link';
                    break;
		case 'quote':
                    fallbackPostIcon = 'quote-left';
                    break;
		case 'status':
                    fallbackPostIcon = 'hourglass-half';
                    break;
		case 'video':
                    fallbackPostIcon = 'video-camera';
                    break;
		default:
                    fallbackPostIcon = 'pencil-square';
		}
		return fallbackPostIcon;
            }
	}

    };
    /* ./main controller arguments */
    
    /* OverView Gutenberg Display main controller object */
    function OverView_Gutenberg_Display( OVGDArgs ){

	'use strict';
	
	// main init
	this.init = function(){
	    // init Display splash
	    this.splashInit();
	    // init WP REST API call
	    this.WPAPIInit();
	    // init Display navigation setup
	    this.navSetup();
	};

	// OverView Display state obj
	this.state = {
	    totalPosts: null,
	    totalPostsPages: null,
	    callsAmount: null,
	    prevPost: null,
	    nextPost: null,
	    presentPost: null,
	    postsCollection: {
		cached: []
	    },
	    busy: true,
	    precaching: false,
	    isInit: true
	};

	// get OverView Gutenberg Display state object
	this.getState = function( stateProperty ){
	    if ( stateProperty ){
		return this.state[ stateProperty ];
	    }
	    else {
		return this.state;
	    }
	};

	// set OverView Display state object - takes either the entire object or a single property in the form of property -> value
	this.setState = function( updatedState, updatedProperty ){
	    if ( typeof( updatedState ) == 'String' || typeof( updatedState ) == 'string' ){
		this.state[ updatedState ] = updatedProperty;
	    }
	    else if ( typeof( updatedState ) == 'Object' || typeof( updatedState ) == 'object' ){
		this.state = updatedState;
	    }
	    else {
		console.log( '\nERROR!\nRequested to set a new state with wrong paramaters!\nPassed parameters:\n', updatedState );
	    }
	};
	
	// init WP API
	this.WPAPIInit = function(){
	    //console.log( '\nWP obj:\n', wp );
	    // init ajax call - no arguments passed
	    var initCallArgs = this.getAPICallArgs();
	    if ( initCallArgs.url !== null ){
		// launch precache
		this.setState( 'precaching', true );
		// get collections
		jQ.ajax( initCallArgs );
	    }
	    else {
		console.log( '\nNullWordPress REST API URL!\nAjax call arguments:\n', initCallArgs );
	    }
	};

	// init splash
	this.splashInit = function(){
	    var splashEl = this.get.el( OVGDArgs.elements.splash );
	    // remove legacy splash classes
	    splashEl.classList.remove( OVGDArgs.classes.legacySplash );
	    splashEl.classList.remove( OVGDArgs.classes.legacyActiveSplash );
	    // add OverView Gutenberg Display class
	    splashEl.classList.add( OVGDArgs.classes.ovdSplash );
	    // set splash animation handler
	    splashEl.addEventListener( 'animationend', this.splashAnimationEnd() );
	    // add spinner icon
	    splashEl.append( OVGDArgs.tools.buildIcon( 'spinner', 5 ) );
	    // add splash resizing and repositioning function to window resize events
	    window.addEventListener( 'resize', OVGDArgs.tools.setSplash( jQ( splashEl ) ) );
	    // toggle splash
	    this.toggleSplash( 'init' );
	};
	
	// toggle OverView Gutenberg Display splash
	this.toggleSplash = function( toggleMode ){
	    var splashEl = this.get.el( OVGDArgs.elements.splash, 'jQ' );
	    switch ( toggleMode ){
	    case 'init':
		splashEl.children( 'i.fa' ).addClass( 'fa-pulse' );
		splashEl.removeClass( OVGDArgs.classes.ovdFadeoutSplash );
		splashEl.addClass( OVGDArgs.classes.ovdActiveSplash );
		this.setSplash( splashEl );
	    case 'on':
		this.setSplash( splashEl );
		splashEl.children( 'i.fa' ).addClass( 'fa-pulse' );
		splashEl.removeClass( OVGDArgs.classes.ovdFadeoutSplash );
		splashEl.addClass( OVGDArgs.classes.ovdActiveSplash );
		break;
	    case 'off':
		splashEl.removeClass( OVGDArgs.classes.ovdActiveSplash );
		splashEl.addClass( OVGDArgs.classes.ovdFadeoutSplash );
		break;
	    default:
		console.log( '\nERROR!\nWrong splash toggle mode declared!\nRequested toggle mode:\n', toggleMode );
	    }
	};

	// set splash size and position
	this.setSplash = OVGDArgs.tools.setSplash;

	// spalsh animation handler
	this.splashAnimationEnd = function(){
	    return function(){
		if ( arguments[0].animationName == 'ov_display_fadeout_splash' ){
		    var splashEl = jQ( arguments[0].target );
		    //console.log( '\nSplash animation end arguments:\n', arguments );
		    OverViewGutenbergDisplayArgs.tools.setSplash( splashEl, 'reset' );
		    splashEl.children( 'i.fa' ).removeClass( 'fa-pulse' );
		    splashEl.removeClass( 'overview-display-splash-fadeout' );
		}
	    };
	};

	// navigation setup
	this.navSetup = function(){
	    // get OverView Display legacy mobile navigation structure
	    var legacyMobileNavObj = new OVGD_Mobile_Navigation_Structure( OVGDArgs.tools.buildIcon),
		rebuiltLegacyMobileNavStructure = legacyMobileNavObj.getStructure(),
		contentContainerEl = this.get.el( OVGDArgs.elements.contentContainer );
	    // insert legacy mobile navigation structure
	    contentContainerEl.appendChild( rebuiltLegacyMobileNavStructure );
	    // setup navigation
	    var nextButton = this.get.el( OVGDArgs.elements.nextButton ),
		prevButton = this.get.el( OVGDArgs.elements.prevButton );
	    // setup legacy mobile navigation
	    var mobileNextButton = this.get.el( OVGDArgs.elements.mobileNextButton ),
		mobilePrevButton = this.get.el( OVGDArgs.elements.mobilePrevButton );
	    
	    // init disabled classes
	    this.setDisabledNav( 'prev' );
	    // add listeners
	    mobileNextButton.addEventListener( 'click', this.nextPostNav( this ) );
	    mobilePrevButton.addEventListener( 'click', this.prevPostNav( this ) );
	    nextButton.addEventListener( 'click', this.nextPostNav( this ) );
	    prevButton.addEventListener( 'click', this.prevPostNav( this ) );
	    // add animations listeners
	    var mobileNavNextEl = mobileNextButton.parentNode,
		mobileNavPrevEl = mobilePrevButton.parentNode,
		navNextEl = nextButton.parentNode,
		navPrevEl = prevButton.parentNode;
	    mobileNavNextEl.addEventListener( 'transitionend', this.endNavAnimation );
	    mobileNavPrevEl.addEventListener( 'transitionend', this.endNavAnimation );
	    navNextEl.addEventListener( 'transitionend', this.endNavAnimation );
	    navPrevEl.addEventListener( 'transitionend', this.endNavAnimation );
	};

	// navigation animations
	this.navAnimate = function( animationMode ){
	    if ( animationMode !== 'prev' && animationMode !== 'next'  ){
		console.log( '\nERROR!\nWrong navigation animation mode!\nPassed mode:\n', animationMode );
	    }
	    else {
		var buttonEl = animationMode === 'next' ? this.get.el( OVGDArgs.elements.nextButton ) : this.get.el( OVGDArgs.elements.prevButton ),
		    navEl = buttonEl.parentNode,
		    mobileButtonEl = animationMode === 'next' ? this.get.el( OVGDArgs.elements.mobileNextButton ) : this.get.el( OVGDArgs.elements.mobilePrevButton ),
		    mobileNavEl = mobileButtonEl.parentNode,
		    animationClass = animationMode === 'next' ? OVGDArgs.classes.nextButtonAnimation : OVGDArgs.classes.prevButtonAnimation;
		// add animation class
		navEl.classList.add( animationClass );
		mobileNavEl.classList.add( animationClass );
	    }
	};

	// reset Display navigation animations
	this.endNavAnimation = function(){
	    var transitionedEl = this,
		transitionProp = arguments[0].propertyName;
	    // if padding transition
	    if ( transitionProp == 'padding-right' || transitionProp == 'padding-left' ){
		var displayEls = OverViewGutenbergDisplayArgs.elements,
		    displayClasses = OverViewGutenbergDisplayArgs.classes,
		    validTransition = false,
		    transitionedClass;
		// if target is a Display nav button next
		if ( transitionedEl.classList.contains( displayClasses.nextButtonAnimation ) ){
		    validTransition = true;
		    transitionedClass = displayClasses.nextButtonAnimation;
		}
		// if target is a Display nav button prev
		if ( transitionedEl.classList.contains( displayClasses.prevButtonAnimation ) ){
		    validTransition = true;
		    transitionedClass = displayClasses.prevButtonAnimation;
		}
		// if valid navigation animation transition end
		if ( validTransition ){
		    // remove Display navigation animation class from all nav containers
		    jQ( '.' + transitionedClass ).removeClass( transitionedClass );
		}
	    }
	};
	
	// get standard navigation args
	this.getNavArgs = function(){
	    var navState = {
		presentPost: parseInt( this.getState( 'presentPost' ) ),
		prevPost: parseInt( this.getState( 'prevPost' ) ),
		totalPosts: parseInt( this.getState( 'totalPosts' ) ),
		busy: this.getState( 'busy' ),
		precaching: this.getState( 'precaching' )
	    };
	    return navState;
	};

	// navigate to next post
	this.nextPostNav = function( mainCtx ){
	    return function(){
		arguments[0].preventDefault();
		var state = mainCtx.getNavArgs(),
		    navElPadding = window.getComputedStyle( arguments[0].target.parentNode, null ).getPropertyValue( 'padding-left' );
		if ( ( ! state.precaching && ! state.busy ) && state.presentPost != null && state.presentPost < state.totalPosts && '0px' == navElPadding ){
		    state.busy = true;
		    mainCtx.setState( 'busy', true );
		    mainCtx.navAnimate( 'next' );
		    mainCtx.toggleSplash( 'on' );
		    if ( state.presentPost === state.totalPosts -1 ){
			mainCtx.setDisabledNav( 'next' );
		    }
		    else {
			mainCtx.setDisabledNav( 'none' );
		    }
		    var newPostIndex = state.presentPost;
		    mainCtx.manageSingleView( newPostIndex +1 );
		}
	    };
	};

	// navigate to prev post
	this.prevPostNav = function( mainCtx ){
	    return function(){
		arguments[0].preventDefault();
		var state = mainCtx.getNavArgs(),
		    navElPadding = window.getComputedStyle( arguments[0].target.parentNode, null ).getPropertyValue( 'padding-right' );
		if ( ( ! state.precaching && ! state.busy ) && state.presentPost != null && state.prevPost >= 1 && '0px' == navElPadding ){
		    state.busy = true;
		    mainCtx.setState( 'busy', true );
		    mainCtx.navAnimate( 'prev' );
		    mainCtx.toggleSplash( 'on' );
		    if ( state.prevPost === 1 ){
			mainCtx.setDisabledNav( 'prev' );
		    }
		    else {
			mainCtx.setDisabledNav( 'none' );
		    }
		    var newPostIndex = state.presentPost;
		    mainCtx.manageSingleView( newPostIndex -1 );
		}
	    };
	};
	
	// set navigation state
	this.setNavigationState = function( postNumber ){
	    postNumber = parseInt( postNumber );
	    this.setState( 'prevPost', ( postNumber -1 ) );
	    this.setState( 'presentPost', postNumber );
	    this.setState( 'nextPost', ( postNumber +1 ) );
	};

	// set disabled navigation
	this.setDisabledNav = function( navDirection ){
	    var prevButton = this.get.el( OVGDArgs.elements.prevButton ),
		mobilePrevButton = this.get.el( OVGDArgs.elements.mobilePrevButton ),
		nextButton = this.get.el( OVGDArgs.elements.nextButton ),
		mobileNextButton = this.get.el( OVGDArgs.elements.mobileNextButton );
	    switch( navDirection ){
	    case 'prev':
		prevButton.classList.add( OVGDArgs.classes.disabledNav );
		mobilePrevButton.classList.add( OVGDArgs.classes.disabledNav );
		nextButton.classList.remove( OVGDArgs.classes.disabledNav );
		mobileNextButton.classList.remove( OVGDArgs.classes.disabledNav );
		break;
	    case 'next':
		nextButton.classList.add( OVGDArgs.classes.disabledNav );
		mobileNextButton.classList.add( OVGDArgs.classes.disabledNav );
		prevButton.classList.remove( OVGDArgs.classes.disabledNav );
		mobilePrevButton.classList.remove( OVGDArgs.classes.disabledNav );		
		break;
	    case 'all':
		nextButton.classList.add( OVGDArgs.classes.disabledNav );
		mobileNextButton.classList.add( OVGDArgs.classes.disabledNav );
		prevButton.classList.add( OVGDArgs.classes.disabledNav );
		mobilePrevButton.classList.add( OVGDArgs.classes.disabledNav );
	    case 'none':
		nextButton.classList.remove( OVGDArgs.classes.disabledNav );
		mobileNextButton.classList.remove( OVGDArgs.classes.disabledNav );
		prevButton.classList.remove( OVGDArgs.classes.disabledNav );
		mobilePrevButton.classList.remove( OVGDArgs.classes.disabledNav );
		break;
	    default:
		console.log( '\nERROR!\nWrong parameter passed to disabled button nav state setter!\n', navDirection );
	    }
	};
	
	// get API init call arguments - no call args for init and no custom handler for standard data call
	this.getAPICallArgs = function( apiCallArgs, customHandler ){
	    var callArgs = apiCallArgs ? apiCallArgs : 'posts&_embed=1&per_page=10&order=desc',
		rootCheck = this.getAPIRoot(),
		callURL = '?rest_route=/wp/v2/' + callArgs,
		vaildCustomHandlerName = customHandler === 'tags' || customHandler === 'categories' ? true : false,
		successHandler = customHandler && vaildCustomHandlerName ? this.assignAPICallHandler( 'success', customHandler ) : this.assignAPICallHandler( 'success' ),
		failHandler = customHandler && vaildCustomHandlerName ? this.assignAPICallHandler( 'fail', customHandler ) : this.assignAPICallHandler( 'fail' ),
		initArgs = {
		    url: callURL,
		    method: 'GET',
		    success: successHandler.bind( this ),
		    fail: failHandler.bind( this )
		};
	    return initArgs;
	};

	// assign WP REST API calls handlers
	this.assignAPICallHandler = function( responseType, customAPICallHandler ){
	    var newAPICallHandler;
	    switch ( responseType ){
		// SUCCESS
	    case 'success':
		if ( ! customAPICallHandler ){// if no custom handler is specified, fallback to standard posts call
		    // STANDARD DATA
		    newAPICallHandler = this.manageFetchedAPIData;
		}
		else {
		    switch ( customAPICallHandler ){
			// META
		    case 'tags':
			newAPICallHandler = this.manageFetchedAPITags;
			break;
		    case 'categories':
			newAPICallHandler = this.manageFetchedAPICategories;
			break;
		    default:
			console.log( '\nERROR!\nUnrecognized custom REST API call handler!\n' );
		    }
		}
		break;
		// FAIL
	    case 'fail':
		if ( ! customAPICallHandler ){// if no custom handler is specified, fallback to standard posts call
		    // STANDARD DATA
		    newAPICallHandler = this.manageFailedAPIData;
		}
		else {
		    switch ( customAPICallHandler ){
			// META
		    case 'tags':
			newAPICallHandler = this.manageFailedAPITags;
			break;
		    case 'categories':
			newAPICallHandler = this.manageFailedAPICategories;
			break;
		    default:
			console.log( '\nERROR!\nUnrecognized custom REST API call handler!\n' );
		    }
		}
		break;
	    default:
		console.log( '\nERROR!\nREST API call response type is missing or incorrect!\n' );
	    }
	    return newAPICallHandler;
	};
	
	// manage API successfully fetched data
	this.manageFetchedAPIData = function( fetchedData, status, responseObj ){
	    //console.log( '\nReached init!\nData:\n', fetchedData, '\nAll arguments:\n', arguments, '\nAll response headers\n', responseObj.getAllResponseHeaders(), '\nThis context:\n', this );
	    var oldState = this.getState(),
		newState = {
		    totalPosts: parseInt( responseObj.getResponseHeader( 'X-WP-Total' ) ),
		    totalPostsPages: parseInt( responseObj.getResponseHeader( 'X-WP-TotalPages' ) ),
		    callsAmount: oldState.callsAmount === null ? 1 : oldState.callsAmount +1,
		    prevPost: oldState.prevPost,
		    nextPost: oldState.nextPost,
		    presentPost: oldState.presentPost,
		    postsCollection: {
			cached: oldState.postsCollection.cached
		    },
		    busy: oldState.busy,
		    precaching: oldState.precaching,
		    isInit: false
		};
	    // define new cached elements
	    var newCachedEntries = newState.postsCollection.cached,
		newIndexes = [],
		indexAdjuster = 10 * ( newState.callsAmount -1 ); // 10 - posts per page
	    fetchedData.forEach(function( thisPost, thisPostIndex ){
		if ( newCachedEntries.length <= newState.totalPosts ){
		    newCachedEntries.push( thisPost );
		    newIndexes.push( thisPostIndex + indexAdjuster );
		}
	    });
	    // assign new cached elements
	    newState.postsCollection.cached = newCachedEntries;
	    // assign new state
	    this.setState( newState );
	    this.precacheSetup( newIndexes );
	    // if init, launch first view
	    if ( oldState.isInit === true ){
		this.manageSingleView( 'init' );
	    }
	};

	// get WP API root
	this.getAPIRoot = function(){
	    var links = document.getElementsByTagName( 'link' ),
		apiRoot = null,
		apiCheck = getMainRoot( links );
	    if ( null === apiCheck ){
		console.log( '\nNo valid WP API root URL found!\n' );
		return false;
	    }
	    else {
		return apiCheck;
	    }
	    
	    function getMainRoot( allLinks ){
		var link = Array.prototype.filter.call( allLinks, function ( item ) {
		    return ( item.rel === 'https://api.w.org/' );
		} ),
		    root = link[0] ? link[0].href : null;
		return root;
	    }
	};

	// WP API connect fails count 
	this.connectFailsCount = 0;
	this.getConnectFailsCount = function(){ // WP API connect fails count getter
	    return this.connectFailsCount;
	};
	this.addToConnectFailCount = function(){ // WP API connect fails count setter
	    this.connectFailsCount++;
	};
	// hide OverView Gutenberg Display
	this.connectFailhide = function( error, status, responseObj, failedRequest ){
	    // if no result on init, hide Display
	    var initCheck = this.getConnectFailsCount();
	    if ( initCheck >= 3 ){
		var displayEl = this.get.el( OVGDArgs.elements.mainContainer ),
		    navEls = this.get.els( OVGDArgs.elements.mainNavContainer );
		displayEl.style[ 'display' ] = 'none';
		navEls.style[ 'display' ] = 'none';
	    }
	    if ( failedRequest ){
		console.log( '\nWordPress API ' + failedRequest + ' connection error! Please check your settings.\nStatus:\n', status, '\nError:\n', error, '\nResponse object:\n', responseObj );
		// reset busy state
		this.setState( 'busy', false );
	    }
	    else {
		console.log( '\nERROR!\nNo or unrecognized failed connection hide mode!\n' );
		// reset busy state
		this.setState( 'busy', false );
	    }
	};

	/* Failed API connections */
	
	// manage failed API connection for full data
	this.manageFailedAPIData = function( error, status, responseObj ){
	    // hide Display
	    this.connectFailhide( 'standard', error, status, responseObj );
	    console.log( '\nWordPress API connection error! Please check your settings.\nStatus:\n', status, '\nError:\n', error, '\nResponse object:\n', responseObj );
	};

	// manage API failed connection categories
	this.manageFailedAPICategories = function( apiError, status, responseObj ){
	    // hide Display
	    this.connectFailhide( 'categories', apiError, status, responseObj );
	    console.log( '\nWordPress API connection error! Please check your settings.\nStatus:\n', status, '\nError:\n', apiError, '\nResponse object:\n', responseObj );
	};

	// manage API failed connection tags
	this.manageFailedAPITags = function( apiError, status, responseObj ){
	    // hide Display
	    this.connectFailhide( 'tags', apiError, status, responseObj );
	    console.log( '\nWordPress API connection error! Please check your settings.\nStatus:\n', status, '\nError:\n', apiError, '\nResponse object:\n', responseObj );
	};

	/* Successful extra API Connections */
		
	// manage API successfully fetched categories
	this.manageFetchedAPICategories = function( fetchedCategories, status, responseObj ){
	    console.log( '\nReached fetched categories!\nCategories:\n', fetchedCategories );
	};
	
	// manage API successfully fetched tags
	this.manageFetchedAPITags = function( fetchedTags, status, responseObj ){
	    console.log( '\nReached fetched tags!\nTags:\n', fetchedTags );
	};

	
	/* content height */
        this.setContentHeight = function( displayEls ){
	    return function(){
		//console.log( '\nReached content container resize closure!\nArguments:\n', arguments );
		var titleEl = jQ( '#' + displayEls.contentTitle ),
		    tagsEl = jQ( '#' + displayEls.contentTags ),
		    metasEl = jQ( '#' + displayEls.contentMetas ),
		    contentEl = jQ( '#' + displayEls.content ),
		    newHeight = ( 400 - titleEl.outerHeight() ) - ( tagsEl.outerHeight() ) - ( metasEl.outerHeight() ) + 'px';
		contentEl.css({
                    maxHeight: newHeight
		});
	    };
        };

	// precached Display items
	this.precachedItems = {
	    collection: {},
	    isInit: true
	};
	// precached Display items getter
	this.getPrecachedItems = function( precachedItem ){
	    if ( typeof( precachedItem ) == 'String' || typeof( precachedItem ) == 'string' ){
		return this.precachedItems[ precachedItem ];
	    }
	    else {
		return this.precachedItems;
	    }
	};
	// precached Display items setter - set a single property or entire object
	this.setPrecachedItems = function( newItems, newItem ){
	    if ( typeof( newItems ) == 'String' || typeof( newItems ) == 'string' ){
		this.precachedItems[ newItems ] = newItem;
	    }
	    else {
		this.precachedItems = newItems;
	    }
	};
	// precached items counter
	this.precachedItemsCount = null;
	this.getPrecachedItemsCount = function( countItem ){ // precached items counter getter
	    if ( typeof( countItem ) == 'String' || typeof( countItem ) == 'string'){
		return this.precachedItemsCount[ countItem ];
	    }
	    else {
		return this.precachedItemsCount;
	    }
	};
	this.setPrecachedItemsCount = function( newCount, newCountItem ){ // precached items counter setter - set a single property or entire object
	    if ( typeof( newCount ) == 'String' || typeof( newCount ) == 'string' ){
		this.precachedItemsCount[ newCount ] = newCountItem;
	    }
	    else {
		this.precachedItemsCount = newCount;
	    }
	};
	
	// setup OverView Gutenberg Display posts collection items precache
	this.precacheSetup = function( postsIndexes ){
	    var state = this.getState( 'postsCollection' ),
		postsCollection = state.cached,
		isInit = this.getPrecachedItems( 'isInit' ),
		newPostsCollection = [],
		newPostsIndexes = [],
		initCheck = isInit;
	    // if init
	    if ( initCheck === true ){
		isInit = false;
		// update precached collection
		this.setPrecachedItems( 'isInit', isInit );
		// define precache init
		var initItems = [ postsCollection[ 0 ], postsCollection[ 1 ], postsCollection[ 2 ] ],
		    initItemsIndexes = [ 0, 1, 2 ],
		    indexInitReset = [ 3, 4, 5, 6, 7, 8, 9 ];
		// launch precache init
		this.precache( initItems, initItemsIndexes );
		// set second init collection
		indexInitReset.forEach(function( thisIndex ){
		    newPostsCollection.push( postsCollection[ thisIndex ] );
		});
		newPostsIndexes = indexInitReset;
	    }
	    else {
		newPostsIndexes = postsIndexes;
		postsIndexes.forEach(function( entryIndex ){
		    newPostsCollection.push( postsCollection[ entryIndex ] );
		});
	    }
	    // launch precache
	    this.precache( newPostsCollection, newPostsIndexes );
	};
	
	// precache Display posts collection items
	this.precache = function( newPostsCollection, newPostsIndexes ){
	    //console.log( '\nReached precache!\nNew posts collection:\n', newPostsCollection, '\nNew posts indexes:\n', newPostsIndexes );
	    // define precache count
	    this.setPrecachedItemsCount({
		postsAmount: newPostsIndexes.length,
		completed: 0
	    });
	    // setup precache
	    var precachedItems = this.getPrecachedItems(),
		tempElement = document.createElement( 'div' ),
		mainCtx = this;
	    newPostsCollection.forEach(function( newPost, entryIndex ){
		if ( newPost && newPost != null && newPost !== 'undefined' ){// if item to precache is available
		    var thisIndex = newPostsIndexes[ entryIndex ],
			// define new precached item
			newPrecachedItem = {
			    id: newPost.id,
			    tempEl: tempElement,
			    completed: false
			},
			// define new precached featured image
			newFeaturedImg = document.createElement( 'img' );
		    // setup precached image
		    newFeaturedImg.src = parseInt( newPost.featured_media ) !== 0 ? newPost._embedded[ 'wp:featuredmedia' ][ 0 ].source_url : '';
		    newFeaturedImg.setAttribute( 'ovPrecacheId', thisIndex );
		    newPrecachedItem.tempEl.appendChild( newFeaturedImg );
		    //console.log( '\nTemporary elements collection:\n', precachedItems );
		    // assign new precached element item
		    precachedItems.collection[ thisIndex ] = newPrecachedItem;
		    // update precached items
		    mainCtx.setPrecachedItems.apply( mainCtx, [ precachedItems ] );
		    // add precache completition handler
		    newFeaturedImg.addEventListener( 'onload', mainCtx.precachedCompletedCheck.apply( mainCtx, [ thisIndex ] ) );
		    //console.log( '\nNew precached collection:\n', precachedItems );
		}
	    });
	    //console.log( '\nUpdated cached items:\n', precachedItems, '\nGetting updated cached:\n', this.getPrecachedItems() );
	};

	// check for precache completition
	this.precachedCompletedCheck = function( precacheIndex ){
	    //console.log( '\nReached precache completition test!\nArguments:\n', precacheIndex );
	    var precachedCount = this.getPrecachedItemsCount();
	    // if completed
	    if ( precachedCount.completed === ( precachedCount.postsAmount -1 ) ){
		var busyState = this.getState( 'busy' );
		if ( ! busyState ){
		    this.toggleSplash( 'off' );
		}
		// complete item
		var updatedPrecache = this.getPrecachedItems();
		updatedPrecache.collection[ precacheIndex ].completed = true;
		delete updatedPrecache.collection[ precacheIndex ].tempEl;
		this.setPrecachedItems( updatedPrecache );
		// reset count object
		this.setPrecachedItemsCount( null );
		// reset Display precaching state
		this.setState( 'precaching', false );
	    }
	    else {
		//console.log( '\nReached precache count!\nCompleted count:\n', precachedCount.completed, '\nPrecached items:\n', this.getPrecachedItems() );
		var cacheUpdate = this.getPrecachedItems();
		//console.log( '\nReached precache count!\nCompleted count:\n', precachedCount.completed, '\nPrecached items:\n', this.getPrecachedItems(), '\nThis precached item:\n', cacheUpdate );
		cacheUpdate.collection[ precacheIndex ].completed = true;
		delete cacheUpdate.collection[ precacheIndex ].tempEl;
		this.setPrecachedItems( cacheUpdate );
		// flag item as complete
		this.setPrecachedItemsCount( 'completed', precachedCount.completed +1 );
	    }
	};
	
	// check if more posts to display are needed
	this.morePostsCheck = function( stateCheck ){
	    if ( ( stateCheck.nextPost + 5 ) == stateCheck.cachedLength ){
		var callArgs = 'posts&_embed=1&order=desc&per_page=10&page=' + ( stateCheck.callsAmount + 1 ),
		    morePostsCallArgs = this.getAPICallArgs( callArgs );
		jQ.ajax( morePostsCallArgs );
	    }
	    
	    if ( ! stateCheck.precaching ){
		this.toggleSplash( 'off' );
	    }
	    //reset Display busy state
	    this.setState( 'busy', false );
	};

	// active view object
	this.activePostView = null;
	
	// single view manager
	this.manageSingleView = function( viewArg ){
	    var activePost,
		newState = this.getState(),
		postNumber = viewArg === 'init' ? 1 : parseInt( viewArg ),
		precachedLength = newState.postsCollection.cached.length;
	    // set post to view
	    activePost = newState.postsCollection.cached[ ( postNumber -1 ) ];
	    // if post is valid
	    if ( activePost && null != activePost && 'undefined' != activePost ){
		// if not init, delete previous view object
		if ( this.activePostView !== null ){
		    delete this.activePostView;
		}
		// content resizer
		var contentResizer = this.setContentHeight;
		// set new navigation state
		this.setNavigationState( postNumber );
		// create new post view
		this.activePostView = new OVGD_Single_View( activePost, OVGDArgs, precachedLength );
		// check if more posts to display are needed
		var morePostsCheckArgs = {
		    nextPost: parseInt( newState.nextPost ),
		    cachedLength: parseInt( newState.postsCollection.cached.length ),
		    callsAmount: newState.callsAmount,
		    busy: newState.busy,
		    precaching: newState.precaching
		};
		this.morePostsCheck( morePostsCheckArgs );
		// if init, set content height on window resize
		if ( viewArg === 'init' ){
		    // setup content height size adjustments on window resize
		    window.addEventListener( 'resize', contentResizer( OVGDArgs.elements ) );
		}
	    }
	    else {
		// if post has not been already cached, abort and  reset Display busy state
		this.setState( 'busy', false );
	    }
	    //console.log('\nState:\n', this.getState());
	};

	// elements getters
	this.get = new OVGD_Elements_Getter();
	
	// launch init on obj creation
	this.init();
	
    }
    /* ./main controller object */

    /* OverView Gutenberg Display single post view object */
    function OVGD_Single_View( OVGDPost, UIArgs, precachedLength ){
	'use strict';
	// init
	this.init = function(){
	    // init single view structure and assign it as single view object property
	    this.activeView = new OVGD_Single_View_Structure( OVGDPost, UIArgs );
	    var structureCheck = this.isStructureLoaded();
	    //console.log( '\nExisting structure presence check:\n', structureCheck );
	    // if structure is loaded, update it
	    //console.log( '\nPrecached length:\n', precachedLength );
	    if ( structureCheck && parseInt( precachedLength ) > 3 ){ // 3 - precache posts amount init
		this.update( OVGDPost, UIArgs.elements );
	    }
	    else {
		// get built view and init insertion
		this.getBuiltView( OVGDPost, UIArgs );
	    }
	    // resize content area
	    this.resizeContent( UIArgs.elements );
	    // resize splash
	    var splashEl = this.get.el( UIArgs.elements.splash, 'jQ' );
	    UIArgs.tools.setSplash( splashEl );
	};
	// define content resizer
	this.resizeContent = function( displayEls ){
	    //console.log( '\nReached content container resize closure!\nArguments:\n', arguments );
	    var titleEl = jQ( '#' + displayEls.contentTitle ),
		tagsEl = jQ( '#' + displayEls.contentTags ),
		metasEl = jQ( '#' + displayEls.contentMetas ),
		contentEl = jQ( '#' + displayEls.content ),
		newHeight = ( 400 - titleEl.outerHeight() ) - ( tagsEl.outerHeight() ) - ( metasEl.outerHeight() ) + 'px';
	    contentEl.css({
                maxHeight: newHeight
	    });
	    // scroll to the top of the new content
	    contentEl.animate({
		scrollTop: 0
	    }, 0);
        };
	// active view property
	this.activeView = null;
	// get new post view structured content
	this.getBuiltView = function( postData, UIVars ){
	    var structureCheck = this.isStructureLoaded();
	    var contentContainer = this.get.el( UIVars.elements.contentContainer ), // main content
		postContentStructure = this.activeView.getView( postData, UIVars ),
		postContentContainer = document.createElement( 'div' );
	    postContentContainer.classList.add( UIVars.elements.contentContainer );
	    // append Display elements
	    jQ( contentContainer ).prepend( postContentStructure.image.el );
	    if ( ! postData.featured_media || postData.featured_media.toString() === '0' ){
		postContentStructure.image.el.classList.add( UIVars.classes.featuredImgFallback );
	    }
	    // append to content container
	    postContentContainer.appendChild( postContentStructure.title.el );
	    postContentContainer.appendChild( postContentStructure.tags.el );
	    postContentContainer.appendChild( postContentStructure.meta.el );
	    postContentContainer.appendChild( postContentStructure.content.el );
	    // append post content to content container
	    contentContainer.classList.add( 'overview-front-page-display-container' );
	    contentContainer.appendChild( postContentContainer );
	    // append categories to meta
	    var metaContainer = this.get.el( UIVars.elements.contentMetas );
	    metaContainer.appendChild( postContentStructure.categories.el );
	};
	// update Display html with new post data
	this.update = function( newPostData, updateEls ){
	    //console.log( '\nReached update!\nNew post data:\n', newPostData );
	    var newViewData = {
		    link: newPostData.link,
		    image: newPostData._embedded[ 'wp:featuredmedia' ] ? newPostData._embedded[ 'wp:featuredmedia' ][ 0 ].source_url : this.buildIcon( UIArgs.tools.getFeaturedImgFallbackIconCode( newPostData.format ), 5 ),
		    title: newPostData.title.rendered,
		    meta: {
			date: newPostData.date,
			gmtDate: newPostData.date_gmt,
			postLink: newPostData.link,
			author: { name: newPostData._embedded.author[ 0 ].name, url: newPostData._embedded.author[ 0 ].link }
		    },
		    categories: newPostData._embedded[ 'wp:term' ][ 0 ],
		    tags: newPostData._embedded[ 'wp:term' ][ 1 ],
		    content: newPostData.content.rendered
		};
	    // update elements
	    this.updateViewElements( newViewData, updateEls );
	};
	// update view elements
	this.updateViewElements = function( newViewData, updateEls ){
	    //console.log( '\nReached view elements update!\nNew view data:\n', newViewData );
	    // Display elements to update
	    var imgEl = this.get.el( updateEls.contentImg ),
		titleEl = this.get.el( updateEls.contentTitle ),
		metaEl = this.get.el( updateEls.contentMetas ),
		tagsEl = this.get.el( updateEls.contentTags ),
		contentEl = this.get.el( updateEls.content );
	    // update image
	    var imgChildren = imgEl.parentNode.children,
		childrenCount = 0;
	    while ( childrenCount < imgChildren.length ){
		//console.log( '\nThis image child:\n', imgChildren[ childrenCount ], '\nHas this element the \'fa\' class:\n', imgChildren[ childrenCount ].classList.contains( 'fa' ) );
		// if there is a previous icon, remove it
		if ( imgChildren[ childrenCount ].classList.contains( 'fa' ) ){
		    jQ( imgChildren[ childrenCount ] ).remove();
		    childrenCount = imgChildren.length;
		}
		childrenCount++;
	    }
	    // if element is a url
	    if ( typeof( newViewData.image ) == 'string' ){
		imgEl.src = newViewData.image;
		imgEl.parentNode.parentNode.classList.remove( UIArgs.classes.featuredImgFallback );
	    }
	    else {
		imgEl.src = '';
		imgEl.parentNode.appendChild( newViewData.image );
		imgEl.parentNode.parentNode.classList.add( UIArgs.classes.featuredImgFallback );
	    }
	    imgEl.parentNode.href = newViewData.link;
	    // update title
	    titleEl.innerHTML = newViewData.title;
	    titleEl.parentNode.href = newViewData.link;
	    // update tags
	    if ( newViewData.tags && newViewData.tags[ 0 ] ){
		var tagsElParent = tagsEl.parentNode,
		    newTags = this.activeView.getContentTags( newViewData.tags );
		tagsElParent.replaceChild( newTags, tagsEl );
	    }
	    else {
		tagsEl.innerHTML = '';
	    }
	    // update meta
	    var metaElParent = metaEl.parentNode,
		newMeta = this.activeView.getContentMeta( newViewData.meta );
	    metaElParent.replaceChild( newMeta, metaEl );
	    // update categories
	    var metaContainer = this.get.el( updateEls.contentMetas ),
		newCategories = this.activeView.getContentCategories( newViewData.categories );
	    metaContainer.appendChild( newCategories );
	    // update content
	    contentEl.innerHTML = newViewData.content;
	};
	// check if OverView Gutenberg Display structure is already loaded
	this.isStructureLoaded = function(){
	    var response = true,
		structureCheckEl = this.get.el( UIArgs.elements.contentTitle );
	    if ( ! structureCheckEl || null === structureCheckEl ){
		response = false;
	    }
	    return response;
	};
	// build FA icons
	this.buildIcon = UIArgs.tools.buildIcon;
	// elements getters
	this.get = new OVGD_Elements_Getter();
	// init on new object instance
	this.init();
    }
    /* ./single post view object */

    /* OverView Gutenberg Display single built view getter */
    function OVGD_Single_View_Structure( postData, UITools ){
	'use strict';
	this.init = function(){
	    // get the view
	    this.getView( postData, UITools );
	};
	// get whole post view
	this.getView = function( postData, UITools){
	    var displayContainerEl = this.get.el( UITools.elements.mainContainer );
	    //console.log( '\nReached single display view!\nThis post:\n', postData, '\nUI arguments:\n', UITools );
	    // get view content
	    var viewContent = this.getContentStructure( postData );
	    //console.log( '\nStructured data:\n', viewContent );
	    return viewContent;
	};
	// get basic OverView Display content structure
	this.getContentStructure = function( postData ){
	    var imageEl = this.buildStructureEl( this.getContentImage(  ( postData._embedded[ 'wp:featuredmedia' ] ? postData._embedded[ 'wp:featuredmedia' ][ 0 ].source_url : this.getIcon( UITools.tools.getFeaturedImgFallbackIconCode( postData.format ), 5 ) ), postData.link ) ),
		titleEl = this.buildStructureEl( this.getContentTitle( postData.title, postData.link ) ),
		tagsEl = this.buildStructureEl( this.getContentTags( postData._embedded[ 'wp:term' ][ 1 ] ) ),
		metaEl = this.buildStructureEl( this.getContentMeta( { date: postData.date, gmtDate: postData.date_gmt, postLink: postData.link, author: { name: postData._embedded.author[ 0 ].name, url: postData._embedded.author[ 0 ].link } } ) ),
		categoriesEl = this.buildStructureEl( this.getContentCategories( postData._embedded[ 'wp:term' ][ 0 ] ) ),
		contentEl = this.buildStructureEl( this.getContent( postData.content ) ),
		newDisplayContent = {
		    image: imageEl,
		    title: titleEl,
		    tags: tagsEl,
		    meta: metaEl,
		    categories: categoriesEl,
		    content: contentEl
		};
	    return newDisplayContent;
	};
	// build feature image
	this.getContentImage = function( imgData, postLink ){
	    //console.log( '\nImage data:\n', imgData, '\nType of image:\n', typeof( imgData ) );
	    //var contentImgEl = this.get.el( UITools.elements.contentImg );
	    var postImgContainer = document.createElement( 'div' ),
		postImgLink = document.createElement( 'a' ),
		postImg = document.createElement( 'img' );
	    postImgContainer.classList.add( UITools.elements.contentImgContainer );
	    postImgLink.href = postLink;
	    postImg.id = UITools.elements.contentImg;
	    // if there is a featured image
	    if ( typeof( imgData ) == 'string' ){
		postImg.src = imgData;
	    }
	    else {
		postImgContainer.appendChild( imgData );
	    }
	    // append elements
	    postImgLink.appendChild( postImg );
	    postImgContainer.appendChild( postImgLink );
	    return postImgContainer;
	};
	// build content
	this.getContent = function( contentData ){
	    //console.log( '\nContent data:\n', contentData );
	    //var contentContainerEl = this.get.el( UITools.elements.contentContainer ), content = this.get.el( UITools.elements.content );
	    var postContent = document.createElement( 'div' );
	    postContent.classList.add( UITools.elements.content );
	    postContent.id = UITools.elements.content;
	    postContent.innerHTML = contentData.rendered;
	    return postContent;
	};
	// build content title
	this.getContentTitle = function( titleData, postLink ){
	    //console.log( '\nTitle data:\n', titleData );
	    //var contentTitleEl = this.get.el( UITools.elements.contentTitle );
	    var postTitleLink = document.createElement( 'a' ),
		postTitle = document.createElement( 'h2' );
	    postTitle.id = UITools.elements.contentTitle;
	    postTitle.classList.add( 'overview-front-page-section-title' );
	    postTitle.innerHTML = titleData.rendered;
	    postTitleLink.href = postLink;
	    postTitleLink.appendChild( postTitle );
	    return postTitleLink;
	};
	// build content tags
	this.getContentTags = function( tagsData ){
	    //console.log( '\nTags data:\n', tagsData );
	    //var contentTagsEl = this.get.el( UITools.elements.contentTags );
	    var postTags = document.createElement( 'div' );
	    postTags.id = UITools.elements.contentTags;
	    tagsData.forEach(function( thisTag ){
		var newTag = document.createElement( 'a' );
		newTag.href = thisTag.link;
		newTag.innerHTML = thisTag.name;
		postTags.appendChild( newTag );
	    });
	    if ( tagsData.length > 0 ){
		jQ( postTags ).prepend( this.getIcon( 'tags' ) );
	    }
	    return postTags;
	};
	// build content meta
	this.getContentMeta = function( metaData ){
	    //console.log( '\nMeta data:\n', metaData );
	    //var contentMetaEl = this.get.el( UITools.elements.contentMeta );
	    var postMeta = document.createElement( 'div' );
	    postMeta.id = UITools.elements.contentMetas;
	    // meta date
	    var postMetaDateContainer = document.createElement( 'div' ),
		postDateEl = document.createElement( 'a' );
	    postMetaDateContainer.classList.add( UITools.elements.contentMetaDate );
	    postDateEl.href = metaData.postLink;
	    var formattedDate = UITools.tools.formatPostDate( metaData.date );
	    postDateEl.innerHTML = formattedDate.day + ' ' + formattedDate.month + ' ' + formattedDate.year;
	    jQ( postDateEl ).prepend( ' ' );
	    jQ( postDateEl ).prepend( this.getIcon( 'calendar' ) );
	    postMetaDateContainer.appendChild( postDateEl );
	    postMeta.appendChild( postMetaDateContainer );
	    // author
	    var postAuthor = document.createElement( 'div' ),
		postAuthorLink = document.createElement( 'a' );
	    postAuthor.classList.add( UITools.elements.contentMetaAuthor );
	    postAuthorLink.href = metaData.author.url;
	    postAuthorLink.innerHTML = metaData.author.name;
	    jQ( postAuthorLink ).prepend( ' ' );
	    jQ( postAuthorLink ).prepend( this.getIcon( 'id-card-o' ) );
	    postAuthor.appendChild( postAuthorLink );
	    postMeta.appendChild( postAuthor );
	    // return meta elements
	    return postMeta;
	};
	// build content categories
	this.getContentCategories = function( categoriesData ){
	    //console.log( '\nCategories data:\n', categoriesData );
	    //var contentCategoriesEl = this.get.el( UITools.elements.contentCategories );
	    var postCategoriesContainer = document.createElement( 'div' );
	    // add categories
	    categoriesData.forEach(function( postCategory ){
		if ( postCategory.id != 1 ){ // if not uncategorized
		    var newCategory = document.createElement( 'a' );
		    newCategory.classList.add( UITools.elements.contentSingleCategory );
		    newCategory.href = postCategory.link;
		    newCategory.innerHTML = postCategory.name;
		    postCategoriesContainer.appendChild( newCategory );
		}
	    });
	    if ( categoriesData.length > 0 && categoriesData[ 0 ].id != 1 ){// if not uncategorized
		postCategoriesContainer.classList.add( UITools.elements.contentCategories );
		jQ( postCategoriesContainer ).prepend( this.getIcon( 'folder-open' ) );
	    }
	    // return categories element
	    return postCategoriesContainer;
	};
	// elements getter
	this.get = new OVGD_Elements_Getter();
	// build FA icons
	this.getIcon = UITools.tools.buildIcon;
	// build elements
	this.buildStructureEl = function( builtEl, rawData ){
	    var newEl = {
		el: builtEl
	    };
	    if ( rawData ){
		newEl.raw = rawData;
	    }
	    return newEl;
	};
	// init on new object instance
	this.init();
    }
    /* ./single built view getter */

    /* OverView Gutenberg Display mobile navigation structure getter object - from OverView Display legacy structure */
    function OVGD_Mobile_Navigation_Structure( iconsBuilder ){
	'use strict';
	this.getStructure = function(){
	    // create html elelments
	    var navContainer = document.createElement( 'div' ),
		navEl = document.createElement( 'div' ),
		navPrevEl = document.createElement( 'div' ),
		navPrevButton = document.createElement( 'button' ),
		navNextEl = document.createElement( 'div' ),
		navNextButton = document.createElement( 'button' );
	    // assign classes
	    navContainer.classList.add( 'overview-front-page-display-navigation-mobile-container');
	    navEl.classList.add( 'overview-front-page-display-navigation-mobile' );
	    navPrevEl.classList.add( 'overview-front-page-display-navigation-mobile-prev' );
	    navPrevButton.id = 'overview-front-page-display-navigation-mobile-prev-button';
	    navNextEl.classList.add( 'overview-front-page-display-navigation-mobile-next' );
	    navNextButton.id = 'overview-front-page-display-navigation-mobile-next-button';
	    // append to buttons
	    navPrevButton.appendChild( iconsBuilder( 'angle-left', 2 ) );
	    navNextButton.appendChild( iconsBuilder( 'angle-right', 2 ) );
	    // append to nav els
	    navPrevEl.appendChild( navPrevButton );
	    navNextEl.appendChild( navNextButton );
	    // append to main el
	    navEl.appendChild( navPrevEl );
	    navEl.appendChild( navNextEl );
	    // append to container
	    navContainer.appendChild( navEl );
	    // return structure
	    return navContainer;
	};
    }
    /* ./mobile navigation structure getter object */

    /* OverView Gutenberg Display elements getter object */
    function OVGD_Elements_Getter(){

	'use strict';

	// OverView element by id getter
	this.el = function( elSelector, elType ){
	    if ( elType && elType === 'jQ' ){
		return this.getSingleJQEl( elSelector );
	    }
	    else {
		return this.getSingleEl( elSelector );
	    }
	};
	// OverView class elements getter
	this.els = function( elsClass, elsType ){
	    if ( elsType && elsType === 'jQ' ){
		return this.getClassJQEls( elsClass );
	    }
	    else {
		return this.getClassEls( elsClass );
	    }
	};
	// all getters
	this.getSingleEl = function( singleEl ){
	    return document.getElementById( singleEl );
	};
	this.getClassEls = function( elsClass ){
	    return document.getElementsByClassName( elsClass );
	};
	this.getSingleJQEl = function( singleEl ){
	    return jQ( '#' + singleEl );
	};
	this.getClassJQEls = function( elsClass ){
	    return jQ( '.' + elsClass );
	};
    }
    /* ./elements getter object */	

    jQ(document).ready(function(){
	// new OverView Gutenberg Display controller
	var overviewGutenbergDisplay = new OverView_Gutenberg_Display( OverViewGutenbergDisplayArgs );
    });

})();
