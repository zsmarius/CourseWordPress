/*
 Copyright (C) 2017-2018 _Y_Power ( ypower.nouveausiteweb.fr )

 This file is part of the OverView WordPress theme package.

 The JavaScript code in this page is free software: you can
 redistribute it and/or modify it under the terms of the GNU
 General Public License (GNU GPL) as published by the Free Software
 Foundation, either version 3 of the License, or (at your option)
 any later version.  The code is distributed WITHOUT ANY WARRANTY;
 without even the implied warranty of MERCHANTABILITY or FITNESS
 FOR A PARTICULAR PURPOSE.  See the GNU GPL for more details.

 As additional permission under GNU GPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.
 */

(function(){

    var jQ = jQuery.noConflict();

    /* OverView jQuery custom functions START */
    jQ.fn.extend({
        
	/* splash screen */
	overviewSplashStart: function(OVSplash, activeClass, OVSplashFadeOut){
	    splashSetup();
	    /* re-compute setup on window resize */
	    jQ(window).resize(function(){
		splashSetup(true);
	    });
	    /* splash screen setup */
	    function splashSetup(resize){
		var overviewParentSplashEl = OVSplash.parent('div');
		if ( ! resize ){
		    /* remove previous fade-out class, if any */
		    if ( OVSplash.hasClass(OVSplashFadeOut) ){
			OVSplash.removeClass(OVSplashFadeOut);
		    }
		}
		/* assign computed values */
		setSplashSize(OVSplash, overviewParentSplashEl);
		setSplashOffset(OVSplash, overviewParentSplashEl);
		if ( ! resize ){
		    /* add CSS animations */
		    OVSplash.addClass(activeClass);
		}
	    }
	    /* compute box size */
	    function setSplashSize(splashEl, splashElParent){
		/* assign parent div size */
		splashEl.css({
		    width: splashElParent.outerWidth() + 'px',
		    height: splashElParent.outerHeight() + 'px'
		});
	    }
	    /* compute box offset */
	    function setSplashOffset(splashEl, splashParent){
		var displayOffset = (splashParent.position().top);
		/* assign offset based on window */
		splashEl.offset({
		    top: displayOffset,
		    left: 0
		});
	    }
	},
	overviewSplashEnd: function(OVSplash, activeClass, OVSplashFadeOut){
	    /* remove CSS animations */
	    OVSplash.removeClass(activeClass).addClass(OVSplashFadeOut);
	    setTimeout(function(){
		OVSplash.removeClass(OVSplashFadeOut);
		/* reset splash screen size to 0 */
		OVSplash.css({
		    width: '0px',
		    height: '0px'
		});
	    }, 1000);
	}
	
    });
    /* OverView jQuery custom functions END */

    /* OverView main object START */
    var OverView_Page_Controller = function(){

	/* initialize */
	this.init = function(overviewInitParams){
	    /* configure and launch all functions passed in init array */
	    overviewInitParams.forEach(function(initFunction){
		/* if function needs arguments (look in further inner array) */
		if (initFunction[0]){
		    /* launch function with built parameters */
		    initFunction[0].apply(this, initFunction[1]);
		}
		/* if function needs no arguments */
		else {
		    initFunction();
		}
	    });
	};

	/* manage front-page posts */
	this.frontPagePostsManager = function(splashScreen){

	    /* create posts model */
	    var postsManagerModel = new wp.api.models.Post();

	    /* create posts collection */
	    var postsManagerCollections = new wp.api.collections.Posts();

            /* create posts authors collection */
            var postsManagerUser = new wp.api.collections.Users();
            
            /* create posts categories collection */
            var postsManagerCategories = new wp.api.collections.Categories();

            /* create posts tags collection */
            var postsManagerTags = new wp.api.collections.Tags();
	    
	    /* posts display query arguments */
	    var overviewPostsDisplayQueryArgs = {
		data: {
		    per_page: 1,
		    page: postsPageCounter
		}
	    },
                overviewPostsDisplayAuthorsQueryArgs = {},
                overviewPostsDisplayCategoriesQueryArgs = {},
                overviewPostsDisplayTagsQueryArgs = {};

	    /* init check */
	    var isInit = true;

            /* cached items array */
            var cachedEntries = [];
            /* cached entries args */
            var overviewCachedPostsDisplayQueryArgs = {
		data: {
		    per_page: 20,
		    page: 1
		}
	    };
            /* define cached entries model */
            var cachedPostsCollection = new wp.api.collections.Posts();
            /* fetch entries */
            cachedPostsCollection.fetch(overviewCachedPostsDisplayQueryArgs).done(function(data){
                /* push data into cached */
                data.forEach(function(cachedEntry){
                    cachedEntries.push(cachedEntry);
                });
            });

	    /* create posts display views */
	    var PostsManagerView = Backbone.View.extend({

		/* posts display */
		el: '#overview-front-page-section-content-container',
		/* posts events */
		initialize: function(){
		    this.listenTo(this.model, 'change', this.render);
		    this.collection.fetch(overviewPostsDisplayQueryArgs).done(function(data, status, response){
                        /* set max pages */
                        postsMaxPages = parseInt(response.getResponseHeader('X-WP-TotalPages'));
                    });
		    this.model.fetch(overviewPostsDisplayQueryArgs);
		    this.render();
		},
		/* posts display render */
		render: function(){
		    /* output html */
		    var html,
			OVPostData,
			OVPostImg;

                    /* if there is data */
		    if ( this.model.attributes[0] ){
                        
			/* define this post model var */
			OVPostData = getNewOrCachedEntry(this.model.attributes[0], cachedEntries);
                        /* check if entry has been cached */
                        function getNewOrCachedEntry(theEntry, allCachedEntries){
                            var computedEntry = null;
                            /* check if entry is cached and, if that is the case, set that obj as entry model */
                            allCachedEntries.forEach(function(entryIndex){
                                if ( entryIndex.id === theEntry.id ){
                                    computedEntry = entryIndex;
                                }
                            });
                            /* if entry is NOT chached, set it as model and push it in cached  */
                            if (null === computedEntry){
                                /* assign new model */
                                computedEntry = theEntry;
                                /* push new model into cached entries array */
                                allCachedEntries.push(computedEntry);
                            }
                            /* return entry obj */
                            return computedEntry;
                        }

                        /* define post feature image model var */
			getPostImage(OVPostData);
                        
                        /* query post author */
                        overviewPostsDisplayAuthorsQueryArgs['data'] = {
                            search: OVPostData.author
                        };
                        
                        /* fetch data and add extras */

                        /* date data */
                        var OVPostDate = formatPostDate(OVPostData.date);
                        
                        /* author data */
                        postsManagerUser.fetch(overviewPostsDisplayAuthorsQueryArgs).done(function(author){
                            /* create author html */
                            var authorHtml = '<a href="' + author[0].link + '"><i class="fa fa-id-card-o" aria-hidden="true"></i>' + author[0].name + '</a>';
                            /* add author html */
                            jQ('div.overview-front-page-posts-section-metas-author').append(authorHtml);
                        });

                        /* assign post categories and tags */
                        var postsCatsAndTags = new wp.api.models.Post({id: OVPostData.id});
                        postsCatsAndTags.fetch().done(function(){
                            /* set categories */
                            postsCatsAndTags.getCategories().done(function(allCategories){
                                if ( 0 < allCategories.length){
                                    /* create categories html */
                                    var categoriesHtml = '<i class="fa fa-folder-open" aria-hidden="true"></i>';
                                    allCategories.forEach(function(category){
                                        /* if NOT only uncategorized */
                                        if (category.name !== 'Uncategorized'){
                                            /* create html elements for each category and append them to output html */
                                            categoriesHtml += '<a class="overview-front-page-posts-category-link" style="display:none;" href="' + category.link + '">' + category.name + '</a>';
                                        }
                                        else {
                                            /* if only category is uncategorized, remove icon */
                                            if (allCategories.length === 1){
                                                categoriesHtml  = '';
                                            }
                                        }
                                    });
                                    /* add categories html */
                                    jQ('div.overview-front-page-posts-section-metas-categories').append(categoriesHtml);
                                    /* fade categories in */
                                    var fadeInDelay = 0;
                                    jQ('a.overview-front-page-posts-category-link').each(function(categoryLink){
                                        var thisLink = jQ(this);
                                        fadeInDelay += 300;
                                        setTimeout(function(){
                                            thisLink.fadeIn(250);
                                            setContentHeight();
                                        }, fadeInDelay);
                                    });
                                }
                                /* fade-in all other meta */
                                setTimeout(function(){
                                    jQ('div.overview-front-page-posts-section-metas-date, div.overview-front-page-posts-section-metas-categories, div.overview-front-page-posts-section-metas-author').fadeIn(250);
                                }, 300);
                            });
                            /* set tags */
                            postsCatsAndTags.getTags().done(function(allTags){
                                if ( 0 < allTags.length){
                                    /* define initial icon */
                                    var tagsHtml = '<i class="fa fa-tags" aria-hidden="true"></i>';
                                    /* create html elements for each tag and append them to output html */
                                    allTags.forEach(function(postTag){
                                        tagsHtml += '<a href="' + postTag.link + '">' + postTag.name + '</a>';
                                    });
                                    /* append tags and fade elements in */
                                    jQ('div#overview-front-page-posts-section-tags').append(tagsHtml).fadeIn(250);
                                    /* compute elements height */
                                    setContentHeight();
                                }
                            });
                        });
                        
                        /* build html */
                        html = '<div class="overview-front-page-posts-section-img-container"><a href="' + OVPostData.link + '"><img id="overview-front-page-posts-section-img" style="display: none;" alt="featured image"></img></a></div><div class="overview-front-page-display-navigation-mobile-container"><div class="overview-front-page-display-navigation-mobile"><div class="overview-front-page-display-navigation-mobile-prev"><button id="overview-front-page-display-navigation-mobile-prev-button"><i class="fa fa-2x fa-angle-left" aria-hidden="true"></i></button></div><div class="overview-front-page-display-navigation-mobile-next"><button id="overview-front-page-display-navigation-mobile-next-button"><i class="fa fa-2x fa-angle-right" aria-hidden="true"></i></button></div></div></div><div class="overview-front-page-section-content-container"><a href="' + OVPostData.link + '"><h2 id="overview-front-page-posts-section-title" class="overview-front-page-section-title">' + OVPostData.title.rendered + '</h2></a><div id="overview-front-page-posts-section-tags" style="display: none;"></div><div id="overview-front-page-posts-section-metas"><div class="overview-front-page-posts-section-metas-date" style="display: none;"><a href="' + OVPostData.link + '">' + OVPostDate + '</a></div><div class="overview-front-page-posts-section-metas-author" style="display: none;"></div><div class="overview-front-page-posts-section-metas-categories" style="display: none;"></div></div><div id="overview-front-page-posts-section-content" class="overview-front-page-section-content">' + OVPostData.content.rendered + '</div></div>';
		    }
                    
                    /* assign new html */
		    this.$el.html(html);
                    
		    /* set delays for post html-injection setup */
		    setTimeout(function(){

			/* init checks */
			if (isInit === true){
                            /* set to first page */
                            postsPageCounter = 1;
                            isInit = false;
			}
			else {
                            /* set splash delay */
                            setTimeout(function(){
				splashScreen.launch( jQ('div#overview-front-page-posts-section-splash-screen'), splashScreen.classes );
			    }, 200);
                            /* set focus delay */
                            setTimeout(function(){
                                /* assign focus to post's content div */
		                jQ('div#overview-front-page-display-posts-container').focus();
                            }, 300);
			}
			/* navigation buttons */
			postsNavigationSetup(postsPageCounter);

		    }, 100);

                    /* set content container height */
                    setContentHeight();
                    jQ(window).resize(function(){
                        setContentHeight();
                    });

		    /* return html */
		    return this;
		}

	    });

	    /* get featured image */
	    function getPostImage(postModel){
		var featImgPostQuery = new wp.api.models.Post({id: postModel.id}),
                    postFormatCheck;
		featImgPostQuery.fetch().done(function(thisPost){
                    /* get post type */
                    postFormatCheck = thisPost.format;
		    var featImgQuery = new wp.api.models.Media({id: thisPost.featured_media});
		    /* assign img element */
		    var postImgEl = jQ('img#overview-front-page-posts-section-img');
                    /* add spinner icon while loading */
                    postImgEl.parent('a').parent('div').append('<i class="fa fa-spinner fa-5x overview-posts-display-featured-img-loading-spinner" aria-hidden="true"></i>');
                    /* fetch image */
		    featImgQuery.fetch().done(function(featImg){
			postImgEl.attr('src', featImg.source_url);
			postImgEl.on('load', function(){
                            postImgEl.parent('a').siblings('i.fa-spinner').fadeOut(0);
                            jQ(this).fadeIn(1000);
			});
		    }).error(function(error){
                        /* no image found: use site logo, if available */
                        if ( null !== OVAPIVars.OVSiteLogo ){
                            /* assign img element */
		            var postImgEl = jQ('img#overview-front-page-posts-section-img');
                            postImgEl.attr('src', OVAPIVars.OVSiteLogo);
                            postImgEl.on('load', function(){
                                postImgEl.parent('a').siblings('i.fa-spinner').fadeOut(0);
                                jQ(this).fadeIn(500);
			    });
                        }
                        /* no featured img or website logo found: fallback to default icon */
                        else {
                            /* assign fallback icon */
                            var fallbackIcon = setFallbackPostTypeIcon(postFormatCheck);
                            /* create default fallback */
                            jQ('div.overview-front-page-posts-section-img-container').css('display', 'none').append('<i class="fa fa-' + fallbackIcon + ' fa-5x" aria-hidden="true"></i>').children('i.fa-' + fallbackIcon + '').parent('div').addClass('overview-posts-display-default-image-fallback').fadeIn(250).children('i.fa-' + fallbackIcon + '').siblings('i.fa-spinner').fadeOut(0);
                        }
		    });
		});
	    }

            /* set fallback icon */
            function setFallbackPostTypeIcon(postFormat){
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

            /* format post date */
            function formatPostDate(date){
                var day = parseInt( date.slice(8, 10) ),
                    month = OVAPIVars.OVLocalLangCalendar[ date.slice(5, 7) ], // change month name according to the localized calendar
                    year = parseInt( date.slice(0, 4) ),
                    time = date.slice(11),
                    /* RTL date option */
                    outputDate = ( '1' === OVAPIVars.OVSiteDirection ) ? '<i class="fa fa-calendar" aria-hidden="true"></i>' + year + ' ' + month + ' ' + day : '<i class="fa fa-calendar" aria-hidden="true"></i>' + day + ' ' + month + ' ' + year;
                //outputDate = '<i class="fa fa-calendar" aria-hidden="true"></i>' + day + ' ' + month + ' ' + year + '<i class="fa fa-clock-o" aria-hidden="true"></i>' + time; -- TO FINISH!!! - setup OverView Display WP post time option
                return outputDate;
            }
            
            /* content height */
            function setContentHeight(){
                var newHeight = ( 400 - jQ('h2#overview-front-page-posts-section-title').outerHeight() ) - (jQ('div#overview-front-page-posts-section-tags').outerHeight()) - (jQ('div#overview-front-page-posts-section-metas').outerHeight()) + 'px';
                jQ('div#overview-front-page-posts-section-content').css({
                    maxHeight: newHeight
                });
            }
            
            /* pagination var */
	    var postsPageCounter,
                postsMaxPages;
	    
	    /* pagination */
	    function postsNavigationSetup(){

                /* reset navigation events */
		jQ('button#overview-front-page-display-navigation-prev-button, button#overview-front-page-display-navigation-mobile-prev-button, button#overview-front-page-display-navigation-next-button, button#overview-front-page-display-navigation-mobile-next-button').off('click');
		/* prev button */
		jQ('button#overview-front-page-display-navigation-prev-button, button#overview-front-page-display-navigation-mobile-prev-button').click(function(navButton){
		    postsPageDown(navButton, 2);
		    /* reset navigation events */
		    jQ('button#overview-front-page-display-navigation-prev-button, button#overview-front-page-display-navigation-next-button').off('click');
		});
		/* next button */
		jQ('button#overview-front-page-display-navigation-next-button, button#overview-front-page-display-navigation-mobile-next-button').click(function(navButton){
                    postsPageUp(navButton, postsMaxPages);
		    /* reset navigation events */
		    jQ('button#overview-front-page-display-navigation-prev-button, button#overview-front-page-display-navigation-next-button').off('click');
		});
                /* set disabled nav */
                setDisabledNav( 1, postsMaxPages );
		function postsPageDown(el, min){
		    if (postsPageCounter >= min){
			postsPageCounter--;
			queryAndRebuild(jQ(el));
		    }		
		}
		function postsPageUp(el, max){
		    if (postsPageCounter <= max){
			postsPageCounter++;
			queryAndRebuild(jQ(el));
		    }	
		}
		function queryAndRebuild(navEl){
		    /* set splash */
		    splashScreen.launch( jQ('div#overview-front-page-posts-section-splash-screen'), splashScreen.classes);
		    /* update page counter */
		    overviewPostsDisplayQueryArgs.data.page = postsPageCounter;
		    setTimeout(function(){
			/* update model */
			postsManagerModel.fetch(overviewPostsDisplayQueryArgs);
		    }, 300);
		}
                function setDisabledNav(min, max){
                    if (postsPageCounter === min){
                        jQ('button#overview-front-page-display-navigation-prev-button, button#overview-front-page-display-navigation-mobile-prev-button').prop('disabled', true).addClass('ov-nav-disabled');
                    }
                    else if (postsPageCounter === max){
                        jQ('button#overview-front-page-display-navigation-next-button, button#overview-front-page-display-navigation-mobile-next-button').prop('disabled', true).addClass('ov-nav-disabled');
                    }
                    else {
                        /* reset both */
                        jQ('button#overview-front-page-display-navigation-prev-button, button#overview-front-page-display-navigation-mobile-prev-button, button#overview-front-page-display-navigation-next-button, button#overview-front-page-display-navigation-mobile-next-button').prop('disabled', false).removeClass('ov-nav-disabled');
                    }
                }
	    }

            /* posts manager view init */
	    var postsManagerView = new PostsManagerView( { model: postsManagerModel, collection:  postsManagerCollections} );
	    
	};
	
	/* splash screens elements and actions */
	this.splash = function(splashEl, splashElements){

	    setSplash(splashElements.OVSplashActiveClass, splashElements.OVSplashFadeOutClass);

	    /* set action according to active class */
	    function setSplash(activeClass, OVSplashFadeOut){
		/* toggle splash */
		if ( splashEl.hasClass(activeClass) ){
		    jQ(splashEl).overviewSplashEnd(splashEl, activeClass, OVSplashFadeOut);
		}
		else {
		    jQ(splashEl).overviewSplashStart(splashEl, activeClass, OVSplashFadeOut);
		}
	    }
	    
	};
	
    };
    /* OverView main object END */
    
    /* document ready START */
    jQ(document).ready(function(){
        
	/* on backbone ready START */
	wp.api.loadPromise.done(function(){

	    //console.log('Backbone JS obj: (Backbone)\n', Backbone, '\nWP REST API obj: (wp.api)\n', wp.api, '\nWP API Settings: (wpApiSettings)\n', wpApiSettings, '\nWP localized vars:\n', OVAPIVars);

	    /* OverView page controller var */
	    var overviewPageController;

	    /* create new page controller obj */
	    overviewPageController = new OverView_Page_Controller;

	    /* define splash css classes */
	    var splashClasses = {
		OVSplashActiveClass: 'overview-splash-active',
		OVSplashFadeOutClass: 'overview-splash-active-fadeout'
	    };

	    /* define splash functions obj */
	    var splashBox = {
		launch: overviewPageController.splash,
		set: overviewPageController.setSplash,
		classes: splashClasses
	    };

	    /* define init functions */
	    var overviewInitParams = [
		// posts manager
		[
		    overviewPageController.frontPagePostsManager,
		    // arguments
		    [
			splashBox
		    ]
		]
	    ];
	    /* page controller init */
	    overviewPageController.init(overviewInitParams);

	    /* if front-page END */
	    
	});
	/* on backbone ready END */
	
    });
    /* document ready END */
    
})();
