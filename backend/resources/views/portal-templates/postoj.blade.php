
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="" lang="sk">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konzervatívny denník</title>

    <meta name="description" content="Čítajte nové profesionálne médium, ktoré vyznáva konzervatívne hodnoty. Naša skúsená redakcia prináša každý deň kvalitné články na témy, o ktorých sa mlčí.">
    <meta name="title" content="Konzervatívny denník Postoj je tu">
    <meta property="og:url" content="https://www.postoj.sk">
    <meta property="og:title" content="Konzervatívny denník Postoj je tu">
    <meta property="og:type" content="website">
    <meta property="og:description" content="Čítajte nové profesionálne médium, ktoré vyznáva konzervatívne hodnoty. Naša skúsená redakcia prináša každý deň kvalitné články na témy, o ktorých sa mlčí.">
    <meta property="og:image" content="https://www.postoj.sk/frontend/img/placeholder/facebook.png">

    <meta name="csrf-token" content="Msf625wbxrm3kNl2zZY0inGDl9GKhlpvCHRMA0ZM"/>
    <meta name="google-site-verification" content="Bxa67H10I7IKDg_4wM5NjYqeuCDCFiZmqNrLqThmaY0" />

    <link rel="icon" type="image/png" href="/favicon.png">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,600,700,300,100&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,600,700,300,100&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css"/>


    <link rel="stylesheet" href="https://static.postoj.sk/frontend/build/style-7238b040.css">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type='text/javascript'>
        var googletag = googletag || {};
        googletag.cmd = googletag.cmd || [];
        (function() {
            var gads = document.createElement('script');
            gads.async = true;
            gads.type = 'text/javascript';
            var useSSL = 'https:' == document.location.protocol;
            gads.src = (useSSL ? 'https:' : 'http:') +
                '//www.googletagservices.com/tag/js/gpt.js';
            var node = document.getElementsByTagName('script')[0];
            node.parentNode.insertBefore(gads, node);
        })();
    </script>


    <script type='text/javascript'>
        googletag.cmd.push(function() {


            googletag.defineSlot('/66396820/Home-newSquares-300x250-300', [[300, 250], [300, 300], [300, 600]], 'div-gpt-ad-1446196972660-0').addService(googletag.pubads());

            googletag.defineSlot('/66396820/NewHeader-1200x200-Home', [1200, 200], 'div-gpt-ad-1445940141819-0').addService(googletag.pubads());
            googletag.defineSlot('/66396820/Home-new300x125', [[300, 300], [300, 600], [300, 125]], 'div-gpt-ad-1453381495492-0').addService(googletag.pubads());
            googletag.defineSlot('/66396820/Home-newBranding-right-160x60', [160, 600], 'div-gpt-ad-1445941370521-0').addService(googletag.pubads());
            googletag.defineSlot('/66396820/Home-newBranding-left-160x60', [160, 600], 'div-gpt-ad-1445941723878-0').addService(googletag.pubads());
            googletag.defineSlot('/66396820/KratkeSpravy-300-600-HOME', [[300, 600], [300, 300], [300, 250]], 'div-gpt-ad-1446111677017-0').addService(googletag.pubads());
            googletag.defineSlot('/66396820/DnesTrebaVidiet-300-600', [[300, 300], [300, 600], [300, 250]], 'div-gpt-ad-1446111448787-0').addService(googletag.pubads());
            googletag.defineSlot('/66396820/Home-newBillboard-970x300-500', [[970, 300], [970, 500], [970, 400]], 'div-gpt-ad-1445950671011-0').addService(googletag.pubads());



            var isMobileOrTablet = 0;

            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            //googletag.pubads().enableSyncRendering(); // uncomment this only if you use synchronous loading
            googletag.enableServices();

            googletag.pubads().addEventListener('slotRenderEnded', function(event) {
                if(event.isEmpty){
                    var el              =  document.getElementById(event.slot.getSlotId().getDomId()).parentNode.parentNode,
                        bannerWrapClass = 'banner-wrap';

                    if(el.className && new RegExp("(^|\\s)" + bannerWrapClass + "(\\s|$)").test(el.className)) el.style.display = "none";
                }
                else{
                    if(event.slot.getSlotId().getName() == '/66396820/NewHeader-1200x200-Home' ||
                        event.slot.getSlotId().getName() == '/66396820/SK-newHeader-1200x200' ||
                        event.slot.getSlotId().getName() == '/66396820/Article-newHeader-1200x200' ||
                        event.slot.getSlotId().getName() == '/66396820/NewHeader-1200x200-Listing' ||
                        event.slot.getSlotId().getName() == '/66396820/Home_Mobile_Header_320x100' ||
                        event.slot.getSlotId().getName() == '/66396820/SK_new_Mobile_Header_320x100' ||
                        event.slot.getSlotId().getName() == '/66396820/Article_new_Mobile_Header_320x100' ||
                        event.slot.getSlotId().getName() == '/66396820/Listing_new_Mobile_Header_320x100'
                    ){


                        App.topBannerShown = true;


                        App.headerTop = $('#banner-header').outerHeight();


                        if( $(window).width() < App.responsiveBreakPoint || isMobileOrTablet){
                            $('body').addClass('with-top-banner-responsive');
                            // App.initResponsiveAds($('.banner-header'), true, false);
                            // $(document).ready(function() {
                            // App.initResponsiveAds($('.banner-header'), true, false);
                            // });

                            // $(window).on('resize', function() {
                            // App.initResponsiveAds($('.banner-header'), true, true);
                            // });
                        } else {
                            $('body').addClass('with-top-banner');
                        }


                        $(window).on('resize', function() {
                            if( $(window).width() < App.responsiveBreakPoint || isMobileOrTablet) {
                                $('body').removeClass('with-top-banner').addClass('with-top-banner-responsive');
                            } else {
                                $('body').removeClass('with-top-banner-responsive').addClass('with-top-banner');
                            }
                        });

                        setTimeout(function(){
                            // App.initStickySections(true);
                            // $('.outside-wrapper-banner').affix('checkPosition');
                        },3500);

                    }
                }


            });
        });
    </script>


    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '751421528225259');
        fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=751421528225259&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Facebook Pixel Code -->

    <!-- Google Tag Manager DataLayer -->
    <script>
        dataLayer = [];
    </script>
    <!-- End Google Tag Manager DataLayer-->

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-7546497677154042",
            enable_page_level_ads: true
        });
    </script>

</head>

<body class="">


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WNJBPB"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-WNJBPB');</script>
<!-- End Google Tag Manager -->

<section id="banner-header" class="banner-wrap banner-header">
    <div class="banner">
        <!-- /66396820/NewHeader-1200x200-Home -->
        <div id='div-gpt-ad-1445940141819-0' style='height:200px; width:1200px;'>
            <script type='text/javascript'>
                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1445940141819-0'); });
            </script>
        </div>

    </div>
</section>







<div class="container">
    <div class="banner-wrap outside-wrapper-banner outside-wrapper-banner-left">
        <div class="banner">

            <!-- /66396820/Home-newBranding-left-160x60 -->
            <div id='div-gpt-ad-1445941723878-0' style='height:600px; width:160px;'>
                <script type='text/javascript'>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1445941723878-0'); });
                </script>
            </div>

        </div>
    </div>
    <div class="banner-wrap outside-wrapper-banner outside-wrapper-banner-right">
        <div class="banner">

            <!-- /66396820/Home-newBranding-right-160x60 -->
            <div id='div-gpt-ad-1445941370521-0' style='height:600px; width:160px;'>
                <script type='text/javascript'>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1445941370521-0'); });
                </script>
            </div>

        </div>
    </div>
</div>


<!-- Facebook SDK -->
<div id="fb-root"></div>

<div class="fb-quote" data-href="https://www.postoj.sk"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1689972617902906',
            xfbml      : true,
            version    : 'v2.4'
        });
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/sk_SK/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<!-- Facebook SDK -->

<!-- Twitter -->
<script>window.twttr = (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0],
            t = window.twttr || {};
        if (d.getElementById(id)) return t;
        js = d.createElement(s);
        js.id = id;
        js.src = "https://platform.twitter.com/widgets.js";
        fjs.parentNode.insertBefore(js, fjs);

        t._e = [];
        t.ready = function(f) {
            t._e.push(f);
        };

        return t;
    }(document, "script", "twitter-wjs"));
</script>
<!-- End Twitter -->
<header id="site-header" class="site-header ">

    <div class="container">
        <div class="row">
            <div class=" col-xxs-5 col-md-3 ">


                <h1>

                    <a href=" https://www.postoj.sk"  class="brand-header track-me-pls " data-category="vsade_logo" data-action="click">
                        <img src="https://www.postoj.sk/assets/frontend/build/img/brand-main.png" class="hidden-kd-mobile" alt="Konzervat&iacute;vny denn&iacute;k">
                        <img src="https://www.postoj.sk/assets/frontend/build/img/postoj-responsive.png" class="show-kd-mobile" alt="Konzervat&iacute;vny denn&iacute;k">
                    </a>

                </h1>
            </div>
            <div class="col-xxs-6 text-right show-kd-mobile">
                <a href="https://podpora.postoj.sk" class="btn btn-kd-red btn--kd-mobile-support track-me-pls" data-category="vsade_podpora-vpravo-hore" data-action="click">Podporiť</a>
            </div>

            <div class="col-xxs-12 col-md-6">
                <div class="pull-right support-head">
                    <h3 class="pull-right"><a href="https://podpora.postoj.sk" class="btn btn-kd-red track-me-pls" data-category="vsade_podpora-vpravo-hore" data-action="click">Podporiť denník</a></h3>

                    <div id="header-carousel" class="carousel slide pull-right " data-keyboard="false" data-interval="false">
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <h3>Potrebujeme v&aacute;s.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxs-12 col-md-1">
                <input type="image" src="https://www.google.com/uds/css/v2/search_box_icon.png" class="google-search-button" title="hľadať">
            </div>
            <div class="col-xxs-12 col-md-2" style="padding-right: 0">
                <div id="cft--login" style="float:right"></div>
            </div>
        </div>



        <div class="google-search" id="google-search">
            <script>
                (function() {
                    var cx = '014208288000063306100:hevbepubdsu';
                    var gcse = document.createElement('script');
                    gcse.type = 'text/javascript';
                    gcse.async = true;
                    gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(gcse, s);
                })();
            </script>
            <gcse:searchbox-only resultsUrl="https://www.postoj.sk/vyhladavanie"></gcse:searchbox-only>
        </div>
    </div>

    <nav class="navbar navbar-default navbar-kd">
        <div class="container relative">

            <a id="mini-brand-logo" class="mini-brand-logo scroll-up" href="#"></a>

            <div class="navbar-header">
                <button id="nav-icon" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-collapse" aria-expanded="false">
                    <span class="nav-icon-bar"></span>
                    <span class="nav-icon-bar"></span>
                    <span class="nav-icon-bar"></span>
                    <span class="sr-only">Toggle navigation</span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="bs-collapse">
                <ul class="nav navbar-nav navbar-nav-kd-main">
                    <li>
                        <a href="https://www.postoj.sk/komentare-nazory" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Koment&aacute;re a n&aacute;zory">Koment&aacute;re a n&aacute;zory</a>
                    </li>


                    <li>
                        <a href="https://www.postoj.sk/spravodajstvo" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Spravodajstvo">Spravodajstvo</a>
                    </li>


                    <li>
                        <a href="https://www.postoj.sk/politika" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Politika">Politika</a>
                    </li>


                    <li>
                        <a href="https://www.postoj.sk/spolocnost" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Spoločnosť">Spoločnosť</a>
                    </li>


                    <li>
                        <a href="https://www.postoj.sk/kultura" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Kult&uacute;ra">Kult&uacute;ra</a>
                    </li>


                    <li>
                        <a href="https://svetkrestanstva.postoj.sk/svet-krestanstva" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Svet kresťanstva">Svet kresťanstva</a>
                    </li>

                    <li>
                        <a href="https://www.postoj.sk/blog" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Blog">Blog</a>
                    </li>


                    <li>
                        <a href="https://www.postoj.sk/rodina" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Rodina">Rodina</a>
                    </li>



                    <!--  <li>
			    <a href="https://www.postoj.sk/inzercia"
			       class="track-me-pls "
			       data-category="vsade_menu-polozka" data-action="click" data-label="Inzercia">Inzercia</a>
		    </li>
		    <li>
			    <a href="https://podpora.postoj.sk/klub-podporovatelov" class="track-me-pls"
			       data-category="vsade_menu-polozka" data-action="click" data-label="Klub-podporovateľov">Klub
				    podporovateľov</a>
		    </li> *-->




                    <li class="visible-lg visible-md">
                        <a href="https://www.postoj.sk/25362/o-denniku" class="odenniku "
                           data-category="vsade_menu-polozka" data-action="click" data-label="O-denniku">O denníku</a>
                    </li>

                    <li class="dropdown visible-xs visible-sm">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">O denniku</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="https://www.postoj.sk/25362/o-denniku" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="O denn&iacute;ku">O denn&iacute;ku</a></li>
                            <li><a href="https://www.postoj.sk/25361/redakcia" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Redakcia">Redakcia</a></li>
                            <li><a href="https://www.postoj.sk/25366/inzercia" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Inzercia">Inzercia</a></li>
                            <li><a href="https://www.postoj.sk/25364/klub-postoj" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Klub Postoj">Klub Postoj</a></li>
                            <li><a href="https://www.postoj.sk/25365/pre-podnikatelov" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Pre podnikateľov">Pre podnikateľov</a></li>
                            <li><a href="https://www.postoj.sk/25363/financovanie" class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Financovanie">Financovanie</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="https://obchod.postoj.sk" class="track-me-pls" data-category="vsade_menu-polozka" data-action="click" data-label="nase-knihy">Naše knihy</a>
                    </li>
                </ul>




                <div class="nav navbar-nav navbar-right navbar-nav-kd-right">
                </div>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div class="navbar navbar-default navbar-submenu">
        <div class="container relative">
            <div class="collapse navbar-collapse" id="bs-collapse">
                <ul class="nav navbar-nav navbar-nav-kd-submenu">
                    <li>
                        <a href="https://www.postoj.sk/25362/o-denniku " class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="O denn&iacute;ku">O denn&iacute;ku</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/25361/redakcia " class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Redakcia">Redakcia</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/25366/inzercia " class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Inzercia">Inzercia</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/25364/klub-postoj " class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Klub Postoj">Klub Postoj</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/25365/pre-podnikatelov " class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Pre podnikateľov">Pre podnikateľov</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/25363/financovanie " class="track-me-pls " data-category="vsade_menu-polozka" data-action="click" data-label="Financovanie">Financovanie</a>
                    </li>
                </ul>

            </div>
        </div>
    </div><!-- /.navbar-collapse -->
</header>


<div class="modal fade modal-login-blog" id="loginBlogModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="tab-content">

                <div role="tabpanel" class="tab-pane fade in active" id="login-panel">
                    <div class="modal-header">
                        <h4 class="modal-title">Prihlásenie do blogu</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon icon-close"></i></button>
                    </div>
                    <div class="modal-body">

                        <form method="POST" action="https://blog.postoj.sk/prihlasit" accept-charset="UTF-8" class="kd-form" novalidate="novalidate"><input name="_token" type="hidden" value="Msf625wbxrm3kNl2zZY0inGDl9GKhlpvCHRMA0ZM">

                            <div class="form-group">
                                <input type="email" name="email" value="" class="form-control form-control-kd form-control-kd-blog required email " id="blog-login-email" placeholder="E-mail" data-err-msg="E-mail je povinný údaj" data-err-msg-email="E-mail je v nesprávnom tvare">
                                <div class="err-msg"></div>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control form-control-kd form-control-kd-blog required " id="blog-login-password" placeholder="Heslo" data-err-msg="Heslo je povinný údaj">
                                <div class="err-msg"></div>
                            </div>
                            <button type="submit" class="btn btn-kd btn-kd-blog">Prihlásiť</button>
                        </form>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <p class="modal-note"><a href="#forget-password-panel" class="reset-password-show" aria-controls="forget-password-panel" role="tab" data-toggle="tab">Zabudli ste svoje heslo?</a></p>
                        <p class="modal-note"> Ak nie ste zaregistrovaný, <a href="https://blog.postoj.sk/registracia">zaregistrujte sa tu</a>. </p>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="forget-password-panel">
                    <div class="modal-header">
                        <h4 class="modal-title">Zabudli ste svoje heslo?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon icon-close"></i></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="https://www.postoj.sk/reset" accept-charset="UTF-8" class="kd-form" novalidate="novalidate"><input name="_token" type="hidden" value="Msf625wbxrm3kNl2zZY0inGDl9GKhlpvCHRMA0ZM">
                            <div class="form-group">
                                <input type="email" name="emailRemember" class="form-control form-control-kd form-control-kd-blog required email" id="blog-forget-password-email" placeholder="E-mail" data-err-msg="E-mail je povinný údaj" data-err-msg-email="E-mail je v nesprávnom tvare">
                                <div class="err-msg"></div>
                            </div>
                            <button type="submit" class="btn btn-kd btn-kd-blog">Vygenerovať nové heslo</button>
                        </form>
                        <hr>
                    </div>
                    <div class="modal-footer">
                        <p class="modal-note"><a href="#login-panel" aria-controls="login-panel" role="tab" data-toggle="tab">Prihlásenie do blogu</a></p>
                        <p class="modal-note"> Ak nie ste zaregistrovaný, <a href="https://blog.postoj.sk/registracia">zaregistrujte sa tu</a>. </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-support" id="thanksModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Ďakujeme
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon icon-close"></i></button>

                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="icon icon-close"></i></button> -->
            </div>
            <div class="modal-body">
                <p>
                    Na email Vám bolo zaslané potvrdenie.
                </p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-kd-blue close-support-popup" data-dismiss="modal" aria-label="Close">Ok</a>
            </div>
        </div>
    </div>
</div>


<section class="home-entry-section">
    <div class="container">
        <div class="row equalize" data-equalize-selector=".eq-me" data-equalize-all="true">
            <div class="col-xxs-12 col-md-push-3 col-md-6 col-md-3-push-minus-compensation">
                <section class="coment-of-the-day-section double-border-bottom double-border-bottom--md-hide-bottom eq-me">
                    <article class="coment-of-the-day">
                        <a href="https://www.postoj.sk/44179/nase-pozvanie-plati-nech-pridu-domov" class="track-me-pls" data-category="home_hlavny-clanok" data-action="click" data-label="Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov-(44179)">
                            <div class="image-wrap">
                                <img  src="/uploads/20131/conversions/homepage.jpg"  alt="Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov">
                            </div>
                        </a>
                        <div class="row">

                            <div class="col-md-9">
                                <div class="show-kd-mobile-inline-block">
                                    <a href="https://www.postoj.sk/autor/fero-mucka" class="">
                                        <span class="author-name">Fero M&uacute;čka</span>
                                    </a>
                                </div>
                                <header>
                                    <h2 class="article-title">
                                        <a href="https://www.postoj.sk/44179/nase-pozvanie-plati-nech-pridu-domov" class="track-me-pls" data-category="home_hlavny-clanok" data-action="click" data-label="Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov-(44179)">Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov</a>
                                    </h2>
                                </header>
                                <div class="perex">
                                    <p class="hidden-kd-mobile">Dnes by som to už takto nerie&scaron;il, hovor&iacute; predseda KDH Alojz Hlina o blogu, ktor&yacute; nap&iacute;sal po voľb&aacute;ch na adresu Franti&scaron;ka Miklo&scaron;ka.</p>
                                    <p class="show-kd-mobile">
                                        Dnes by som to už takto nerie&scaron;il, hovor&iacute; predseda KDH Alojz Hlina o blogu, ktor&yacute; nap&iacute;sal po voľb&aacute;ch na adresu Franti&scaron;ka Miklo&scaron;ka.                            </p>
                                </div>

                                <footer class="hidden-kd-mobile">
                                    <a href="https://www.postoj.sk/politika" class="category-title">Politika</a>
                                </footer>
                            </div>
                            <div class="col-md-3 text-center hidden-kd-mobile">
                                <a href="https://www.postoj.sk/autor/fero-mucka" class="avatar">
                                    <img src="/uploads/1388/conversions/square.jpg" alt="Fero M&uacute;čka">                <span class="author-name">Fero M&uacute;čka</span>
                                </a>
                            </div>

                        </div>
                    </article>
                </section>

                <div id="article-list-mobile">
                </div>
            </div>

            <div class="col-xxs-12 col-md-pull-6 col-md-3 col-md-3-minus-compensation">
                <section class="today-must-see-articles today-must-see-articles-sidebar double-border-bottom border-right eq-me">
                    <header class="clearfix">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/spravodajstvo" class="track-me-pls" data-category="home_dnes-treba-vediet-nadpis" data-action="click">
                                Dnes treba vedieť
                            </a>
                        </h2>
                    </header>
                    <div class="today-must-see-list">
                        <article class="today-must-see-article">
                            <div class="today-must-see-top">
                                <div class="today-must-see-top-image">
                                    <img src="/uploads/20139/conversions/cover.jpg" class="hidden-kd-mobile" style="width:100%;height:auto;">
                                    <img src="/uploads/20139/conversions/homepage.jpg" class="show-kd-mobile" style="width:100%;height:auto;">
                                </div>
                                <span class="category-title hidden-kd-mobile">Dom&aacute;ce:</span>
                                <h3 class="article-title">
                                    <a href="https://www.postoj.sk/44191/pellegrini-sa-dnes-stretne-s-putinom-pozve-ho-na-oslavy-75-vyrocia-snp" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/44191/pellegrini-sa-dnes-stretne-s-putinom-pozve-ho-na-oslavy-75-vyrocia-snp" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="1">Pellegrini sa dnes stretne s Putinom, pozve ho na oslavy 75. v&yacute;ročia SNP </a>
                                </h3>
                            </div>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="image-wrap show">
                                        <img src="/uploads/9298/conversions/profile.jpg" alt="Pavol R&aacute;bara">
                                    </div>
                                    <div class="header-text" style="">
                                        <div class="author-name">Pavol R&aacute;bara</div><small style="margin-left: 5px;">• pred 1 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Rokovať by mali aj o návrhu udeľovať status veterána vojakom z okupácie v roku 1968.</span>
                                    <span class="show-kd-mobile">
				      				        Rokovať by mali aj o návrhu udeľovať status veterána vojakom z okupácie v roku 1968.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="/uploads/20139/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/44191/pellegrini-sa-dnes-stretne-s-putinom-pozve-ho-na-oslavy-75-vyrocia-snp">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Dom&aacute;ce:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/44189/obvineny-z-vrazdy-kuciaka-tvrdi-ze-si-mal-vrazdu-objednat-cudzinec" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/44189/obvineny-z-vrazdy-kuciaka-tvrdi-ze-si-mal-vrazdu-objednat-cudzinec" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="2">Obvinen&yacute; z vraždy Kuciaka tvrd&iacute;, že si mal vraždu objednať cudzinec </a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 1 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Povedať mu to mal ďalší obvinený Zoltán A. </span>
                                    <span class="show-kd-mobile">
				      				        Povedať mu to mal ďalší obvinený Zoltán A.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="/uploads/20137/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/44189/obvineny-z-vrazdy-kuciaka-tvrdi-ze-si-mal-vrazdu-objednat-cudzinec">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Zahraničn&eacute;:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/44194/ceski-poslanci-odsudili-navrh-ruskeho-zakona-o-veteranoch" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/44194/ceski-poslanci-odsudili-navrh-ruskeho-zakona-o-veteranoch" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="3">Česk&iacute; poslanci ods&uacute;dili n&aacute;vrh rusk&eacute;ho z&aacute;kona o veter&aacute;noch </a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 1 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Rusko chce podľa názoru poslancov týmto krokom prepisovať a falšovať dejiny. </span>
                                    <span class="show-kd-mobile">
				      				        Rusko chce podľa názoru poslancov týmto krokom prepisovať a falšovať dejiny.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="/uploads/20142/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/44194/ceski-poslanci-odsudili-navrh-ruskeho-zakona-o-veteranoch">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Zahraničn&eacute;:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/44190/dansky-premier-odstupuje-po-prehratych-volbach" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/44190/dansky-premier-odstupuje-po-prehratych-volbach" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="4">D&aacute;nsky premi&eacute;r odstupuje po prehrat&yacute;ch voľb&aacute;ch </a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 1 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Po štyroch rokoch v opozícii v Dánsku pravdepodobne opäť dostane k moci blok stredoľavých strán.</span>
                                    <span class="show-kd-mobile">
				      				        Po štyroch rokoch v opozícii v Dánsku pravdepodobne opäť dostane k moci blok stredoľavých strán.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="/uploads/20138/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/44190/dansky-premier-odstupuje-po-prehratych-volbach">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Ekonomika:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/44192/koncert-fiat-chrysler-stiahol-ponuku-na-fuziu-s-renaultom" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/44192/koncert-fiat-chrysler-stiahol-ponuku-na-fuziu-s-renaultom" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="5">Koncert Fiat Chrysler stiahol ponuku na f&uacute;ziu s Renaultom </a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 1 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Taliansko-americký koncern zdôvodnil stiahnutie tým, že na realizáciu fúzie v súčasnosti neexistujú vo Francúzsku politické podmienky.</span>
                                    <span class="show-kd-mobile">
				      				        Taliansko-americký koncern zdôvodnil stiahnutie tým, že na realizáciu fúzie v súčasnosti neexistujú vo Francúzsku politické podmienky.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="/uploads/20140/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/44192/koncert-fiat-chrysler-stiahol-ponuku-na-fuziu-s-renaultom">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">&Scaron;port:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/44193/ronaldo-poslal-hetrikom-portugalsko-do-finale-ligy-narodov" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/44193/ronaldo-poslal-hetrikom-portugalsko-do-finale-ligy-narodov" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="6">Ronaldo poslal hetrikom Portugalsko do fin&aacute;le Ligy n&aacute;rodov</a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 1 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Súperom úradujúcich majstrov Európy v nedeľnom finále bude víťaz zápasu Holandsko - Anglicko.</span>
                                    <span class="show-kd-mobile">
				      				        Súperom úradujúcich majstrov Európy v nedeľnom finále bude víťaz zápasu Holandsko - Anglicko.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="/uploads/20141/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/44193/ronaldo-poslal-hetrikom-portugalsko-do-finale-ligy-narodov">Čítať článok</a>
                            </div>
                        </div>


                    </div>
                </section>
            </div>
            <div class="col-xxs-12 col-md-3 col-md-3-plus-compensation">
                <div class=" eq-me  double-border-bottom border-left flex-column">



                    <section class="shop-product-banner">
                        <header class="clearfix">
                            <h2 class="section-title">Novinka z vydavateľstva</h2>
                        </header>

                        <div class="book-item row">

                            <div class="book-detail col-xxs-6 col-lg-7">
                                <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50" class="book-author track-me-pls"
                                   data-category="shop_banner_top-title"
                                   data-action="click"
                                   data-label="cesta-na-zapad">Cesta na Z&aacute;pad</a>

                                <p class="book-perex">Po stop&aacute;ch ochočen&eacute;ho Boha</p>

                                <h4 class="promo-text">Novinka obľúbeného autora Štěpána Smolena</h4>

                                <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50" class="book-link track-me-pls"
                                   data-category="shop_banner_top-about"
                                   data-action="click"
                                   data-label="cesta-na-zapad">O knihe</a>

                            </div>

                            <div class="book-image pull-right">
                                <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50" class="track-me-pls"
                                   alt="Cesta na Z&aacute;pad"
                                   data-category="shop_banner_top-img"
                                   data-action="click"
                                   data-label="cesta-na-zapad">

                                    <img src="/uploads/16520/conversions/variation_thumb.png">
                                </a>

                                <span class="badge badge-price">
                        Cena u nás:
                        <span class="price">9,90&nbsp;&euro;</span>
                    </span>
                            </div>
                        </div>
                    </section>

                    <section   class="popular-articles popular-articles-sidebar">

                        <header class="triangle clearfix">
                            <h2 class="section-title">Najčítanejšie</h2>
                            <ul class="popular-articles-switch clearfix" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#today-popular-articles"  class="track-me-pls" data-category="home_najcitanejsie-filter" data-action="click" data-label="today"  aria-controls="today-popular-articles" role="tab" data-toggle="tab">deň</a>
                                </li>
                                <li role="presentation">
                                    <a href="#yesterday-popular-articles"  class="track-me-pls" data-category="home_najcitanejsie-filter" data-action="click" data-label="yesterday"  aria-controls="yesterday-popular-articles" role="tab" data-toggle="tab">2 dni</a>
                                </li>
                                <li role="presentation">
                                    <a href="#week-popular-articles"  class="track-me-pls" data-category="home_najcitanejsie-filter" data-action="click" data-label="week"  aria-controls="week-popular-articles" role="tab" data-toggle="tab">7 dní</a>
                                </li>
                                <li role="presentation">
                                    <a href="#blog-popular-articles"  class="track-me-pls" data-category="home_najcitanejsie-filter" data-action="click" data-label="blog"  aria-controls="blog-popular-articles" role="tab" data-toggle="tab">blogy</a>
                                </li>
                            </ul>
                        </header>

                        <div class="tab-content">
                            <div id="today-popular-articles" class="popular-articles-list tab-pane active" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44179/nase-pozvanie-plati-nech-pridu-domov"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44162/dobre-otazky-ziadna-odpoved"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="4"  >
                                        <span>4.</span>
                                        <h3 class="article-title">Dobr&eacute; ot&aacute;zky, žiadna odpoveď</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="5"  >
                                        <span>5.</span>
                                        <h3 class="article-title">Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu</h3>
                                    </a>
                                </article>
                            </div>
                            <div id="yesterday-popular-articles" class="popular-articles-list tab-pane" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44076/niektori-knazi-a-reholnicky-sa-nechaju-vylucit-spolu-s-romami"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Niektor&iacute; kňazi a&nbsp;rehoľn&iacute;čky sa nechaj&uacute; vyl&uacute;čiť spolu s&nbsp;R&oacute;mami</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44116/kdh-napadlo-na-ustavnom-sude-rozdelenie-mandatov-z-eurovolieb"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="4"  >
                                        <span>4.</span>
                                        <h3 class="article-title">KDH napadlo na &Uacute;stavnom s&uacute;de rozdelenie mand&aacute;tov z eurovolieb</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="5"  >
                                        <span>5.</span>
                                        <h3 class="article-title">Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici</h3>
                                    </a>
                                </article>
                            </div>
                            <div id="week-popular-articles" class="popular-articles-list tab-pane" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43941/kauza-prijimanie-kto-by-si-mal-spytovat-svedomie-"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Kauza prij&iacute;manie: kto by si mal spytovať svedomie</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43976/brat-filip-detom-chyba-laskava-tvrdost-rodicov-video"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="4"  >
                                        <span>4.</span>
                                        <h3 class="article-title">Brat Filip: Deťom ch&yacute;ba l&aacute;skav&aacute; tvrdosť rodičov (video)</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/44076/niektori-knazi-a-reholnicky-sa-nechaju-vylucit-spolu-s-romami"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="5"  >
                                        <span>5.</span>
                                        <h3 class="article-title">Niektor&iacute; kňazi a&nbsp;rehoľn&iacute;čky sa nechaj&uacute; vyl&uacute;čiť spolu s&nbsp;R&oacute;mami</h3>
                                    </a>
                                </article>
                            </div>
                            <div id="blog-popular-articles" class="popular-articles-list tab-pane" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43989/koalicia-kdhku-by-jednote-krestanov-v-politike-uskodila"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-blog" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Koal&iacute;cia KDH/K&Uacute; by jednote kresťanov v politike u&scaron;kodila</h3>
                                    </a> - <a href="https://www.postoj.sk/autor/slavomir-gregorik"  class="blog-author  track-me-pls "  data-category="kategoria_clanky-autor" data-action="click" >Slavom&iacute;r Gregor&iacute;k</a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43991/co-sa-to-prave-udialo-v-polsku"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-blog" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Čo sa to pr&aacute;ve udialo v Poľsku?</h3>
                                    </a> - <a href="https://www.postoj.sk/autor/julius-eckhardt"  class="blog-author  track-me-pls "  data-category="kategoria_clanky-autor" data-action="click" >J&uacute;lius Eckhardt</a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43954/koho-volili-volici-kdh-po-okresoch"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-blog" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Koho si vybrali voliči KDH v jednotliv&yacute;ch okresoch?</h3>
                                    </a> - <a href="https://www.postoj.sk/autor/jozef-simko"  class="blog-author  track-me-pls "  data-category="kategoria_clanky-autor" data-action="click" >Jozef &Scaron;imko</a>
                                </article>
                            </div>
                        </div>

                    </section>
                </div>                </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="container">
        <div class="row">
            <div class="col-xxs-12">
                <div class="row equalize" data-equalize-selector=".eq-me" data-equalize-all="true">
                    <div class="col-md-3 col-md-3-minus-compensation eq-me hidden-kd-mobile">
                        <div class="pinned-wrap"  data-margin="0" data-manual-compensation="25" data-height="100" data-compensation=".newsletter-fixed-bottom">
                            <div class="pin-me-pls" data-offset="75" data-toggle='.newsletter-fixed-bottom'>
                                <section class="short-news side-short-news">
                                    <header class="clearfix">
                                        <h2 class="section-title">
                                            <a href="https://www.postoj.sk/kratke-spravy-redakcie" class="track-me-pls" data-category="home_kratke-spravy-nadpis" data-action="click">Krátke správy z redakcie</a>
                                        </h2>
                                    </header>
                                    <div class="short-news-items">
                                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="1"  data-href="https://www.postoj.sk/shortnews/2525" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2525">
                                            <time datetime="2019-06-05 15:01:30">
                                            </time>
                                            <div class="image-wrap hidden-kd-mobile">
                                                <img src="/uploads/20122/conversions/cover.jpg">
                                            </div>
                                            <header class="clearfix">
                                                <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/martin-hanus" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Martin Hanus</a></h3>
                                                <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                                    <a class="author-img" href="https://www.postoj.sk/autor/martin-hanus" data-category="home_kratke-spravy-autor" data-action="click">
                                                        <img src="/uploads/9311/conversions/square.jpg" alt="Martin Hanus">          </a>
                                                    <div class="title">
                                                        <a class="author" href="https://www.postoj.sk/autor/martin-hanus"> <span>Martin Hanus</span> </a>
                                                        <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2525">
                                                            <span>Steve Bannon: Ak nacionalisti nedobyj&uacute; E&Uacute;, Č&iacute;na znič&iacute; Z&aacute;pad</span> </a>
                                                    </div>
                                                </div>
                                                <small class="hidden-kd-mobile">• pred 18 hod</small>
                                            </header>
                                            <div class="perex hidden-kd-mobile">
                                                <p>Steve Bannon, b&yacute;val&yacute; hlavn&yacute; strat&eacute;g Donalda Trumpa, v t&yacute;chto mesiacoch cestuje po Eur&oacute;pe a so svojou mimovl&aacute;dkou The Movement sa...
                                            </div>
                                            <div class="perex show-kd-mobile">
                                                <p>Steve Bannon, b&yacute;val&yacute; hlavn&yacute; strat&eacute;g Donalda Trumpa, v t&yacute;chto mesiacoch cestuje po Eur&oacute;pe a so svojou mimovl&aacute;dkou The Movement sa snaž&iacute; dať dokopy nacionalistick&eacute; a populistick&eacute; strany, aby vytvorili v Eur&oacute;pskom parlamente ak&uacute;si &bdquo;Super Group&ldquo;.<br...
                                            </div>


                                        </article>
                                        <div style="display: none;">
                                            <div class="kd-qtip-arrow"></div>
                                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                                <header class="clearfix">
                                                    <div class="image-wrap show">
                                                        <img src="/uploads/9311/conversions/profile.jpg" alt="Martin Hanus">
                                                    </div>
                                                    <div class="header-text" style="">
                                                        <div class="author-name">Martin Hanus</div><small style="margin-left: 5px;">• pred 18 hod</small>
                                                    </div>
                                                </header>

                                                <div class="article-social-buttons">
                                                    <div class="social-btn">
                                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2525" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                                        </div>
                                                    </div>
                                                    <div class="social-btn">
                                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2525"  data-text="Steve Bannon: Ak nacionalisti nedobyj&uacute; E&Uacute;, Č&iacute;na znič&iacute; Z&aacute;pad"  class="twitter-share-button">Tweet</a>
                                                    </div>
                                                </div>

                                                <div class="article-text">
                                                    <p>Steve Bannon, b&yacute;val&yacute; hlavn&yacute; strat&eacute;g Donalda Trumpa, v t&yacute;chto mesiacoch cestuje po Eur&oacute;pe a so svojou mimovl&aacute;dkou The Movement sa snaž&iacute; dať dokopy nacionalistick&eacute; a populistick&eacute; strany, aby vytvorili v Eur&oacute;pskom parlamente ak&uacute;si &bdquo;Super Group&ldquo;.<br />  <br />  S Bannonom sa e&scaron;te kr&aacute;tko pred eurovoľbami zhov&aacute;rali novin&aacute;ri z liber&aacute;lneho &scaron;vajčiarskeho denn&iacute;ka Neue Z&uuml;rcher Zeitung (NZZ), v&yacute;sledkom je <a href="https://www.nzz.ch/international/steve-bannon-im-interview-bruessel-wird-zu-stalingrad-ld.1481934?mktcid=nled&amp;mktcval=107_2019-05-16&amp;kid=_2019-5-15" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-exit-link">nap&iacute;nav&aacute; sonda</a> nielen do myslenia Bannona, ale aj samotn&eacute;ho Trumpa.<br />  <br />  Podľa Bannona s&uacute;peria v Eur&oacute;pe dve hlavn&eacute; sily, t&aacute;bor globalistov na čele s Macronom, ktor&eacute;ho cieľom s&uacute; Spojen&eacute; &scaron;t&aacute;ty eur&oacute;pske, teda &bdquo;n&aacute;rody ako spr&aacute;vne jednotky centr&aacute;lnej byrokracie&ldquo;, proti nim stoja z&aacute;stancovia vestf&aacute;lskeho syst&eacute;mu, teda n&aacute;rodn&yacute;ch &scaron;t&aacute;tov, ktor&eacute; tvoria E&Uacute;, ale tak&uacute;, ktor&aacute; by mala mať&nbsp;viac obchodn&yacute; než politick&yacute; charakter.<br />  <br />  Bannon ďalej rozv&aacute;dza, že pre jeho &bdquo;populisticko-nacionalistick&yacute; projekt&ldquo; je kľ&uacute;čovou krajinou Nemecko, preto chod&iacute; radiť najm&auml; AfD&nbsp;a veľmi ho zauj&iacute;ma, ako na jeseň dopadn&uacute; voľby v troch v&yacute;chodonemeck&yacute;ch regi&oacute;noch, kde m&ocirc;že t&aacute;to strana zažiariť.<br />  <br />  Steve Bannon ver&iacute;, že sa pr&aacute;ve zač&iacute;na obrat, po eurovoľb&aacute;ch &bdquo;bude každ&yacute; deň v Bruseli Stalingradom&ldquo;, nacionalisti s&iacute;ce e&scaron;te nepresadia svoju v&ocirc;ľu, ale vo fragmentovanom europarlamente bud&uacute; m&ocirc;cť blokovať globalistov. Bannon čel&iacute; ot&aacute;zke, či jednotn&aacute; aliancia&nbsp;nacionalistov v E&Uacute; nie je len fikciou, pretože Eur&oacute;pa nie je Amerika, Bannon sa vyhne priamej odpovedi.<br />  <br />  Tvrd&iacute;, že jeho cieľom nie je E&Uacute; zru&scaron;iť, ale zmeniť zvn&uacute;tra, aby sa Z&aacute;pad postavil svojmu skutočn&eacute;mu existenčn&eacute;mu nepriateľovi, ktor&yacute;m je Č&iacute;na. Glob&aacute;lne elity vraj č&iacute;nsku hrozbu nechc&uacute; pripustiť, pretože na vzostupe Č&iacute;ny dobre zar&aacute;baj&uacute;.<br />  <br />  Č&iacute;na je podľa Bannona &bdquo;totalit&aacute;rna diktat&uacute;ra&ldquo;, jej čipy, roboty a umel&aacute; inteligencia s&uacute; pre nemeck&eacute; inžinierstvo &bdquo;klincom do rakvy&ldquo;, do roku 2025 bude v&scaron;etko &bdquo;made in China&ldquo;. Preto ho najviac rozčuľuje, že &bdquo;globalisti sa tv&aacute;ria, akoby bol č&iacute;nsky vzostup len nejak&yacute; druh&yacute; termodynamick&yacute; z&aacute;kon&ldquo;. Č&iacute;nski lobisti sedia pritom v City of London a na Wall Street, ale z&aacute;padn&aacute; elita z Davosu &bdquo;sa spr&aacute;va ako roztlieskavačky, je to nechutn&eacute;&ldquo;.<br />  <br />  Na ot&aacute;zku NZZ, ako vn&iacute;ma hrozbu z Ruska, Bannon vrav&iacute;, že celkom by stačilo, keby Nemci s Rusmi neuzavreli Nordstream 2. Ale inak je pre neho oveľa men&scaron;&iacute;m probl&eacute;mom než Č&iacute;na, &bdquo;rusk&aacute; ekonomika je asi tak&aacute; veľk&aacute;, ako ekonomika &scaron;t&aacute;tu New York, krajina sa nach&aacute;dza v demografickej &scaron;pir&aacute;le smrti, nevyr&aacute;ba žiadne vyspel&eacute; technol&oacute;gie, je to kleptokracia, ktor&uacute; riadia zl&iacute; chlap&iacute;ci, m&aacute; v&scaron;ak veľa zbran&iacute;, a preto rob&iacute; starosti v r&ocirc;znych častiach sveta&ldquo;.<br />  <br />  V z&aacute;vere sa Bannon e&scaron;te vyzn&aacute;va, že jeho najvy&scaron;&scaron;ou životnou prioritou je znovuzvolenie Trumpa v roku 2020, &bdquo;ide o&nbsp;absol&uacute;tne existenčn&uacute;&nbsp;ot&aacute;zku, pre USA aj pre Z&aacute;pad&ldquo;. A že najlep&scaron;&iacute;m miestom, odkiaľ m&ocirc;že dnes&nbsp;Trumpovi pom&aacute;hať, je pr&aacute;ve Eur&oacute;pa.</p>    <p><em>Steve Bannon, FOTO TASR /AP&nbsp;</em></p>
                                                </div>

                                                <div class="article-image">
                                                    <img src="/uploads/20122/conversions/cover.jpg">
                                                </div>
                                            </div>
                                        </div>
                                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="2"  data-href="https://www.postoj.sk/shortnews/2524" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2524">
                                            <time datetime="2019-06-05 12:07:09">
                                            </time>
                                            <div class="image-wrap hidden-kd-mobile">
                                                <img src="/uploads/20114/conversions/cover.jpg">
                                            </div>
                                            <header class="clearfix">
                                                <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/jozef-majchrak" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Jozef Majchr&aacute;k</a></h3>
                                                <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                                    <a class="author-img" href="https://www.postoj.sk/autor/jozef-majchrak" data-category="home_kratke-spravy-autor" data-action="click">
                                                        <img src="/uploads/9302/conversions/square.jpg" alt="Jozef Majchr&aacute;k">          </a>
                                                    <div class="title">
                                                        <a class="author" href="https://www.postoj.sk/autor/jozef-majchrak"> <span>Jozef Majchr&aacute;k</span> </a>
                                                        <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2524">
                                                            <span>Ozve sa aj Pellegrini?</span> </a>
                                                    </div>
                                                </div>
                                                <small class="hidden-kd-mobile">• pred 20 hod</small>
                                            </header>
                                            <div class="perex hidden-kd-mobile">
                                                <p>Premi&eacute;r Peter Pellegrini je na n&aacute;v&scaron;teve v Moskve. Dnes by sa mal stretn&uacute;ť s premi&eacute;rom Medvedevom a zajtra s prezidentom...
                                            </div>
                                            <div class="perex show-kd-mobile">
                                                <p>Premi&eacute;r Peter Pellegrini je na n&aacute;v&scaron;teve v Moskve. Dnes by sa mal stretn&uacute;ť s premi&eacute;rom Medvedevom a zajtra s prezidentom Putinom.&nbsp;</p>    <p>Premi&eacute;r ide do Ruska v čase, keď sa v ruskom parlamente objavil n&aacute;vrh z&aacute;kona,...
                                            </div>


                                        </article>
                                        <div style="display: none;">
                                            <div class="kd-qtip-arrow"></div>
                                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                                <header class="clearfix">
                                                    <div class="image-wrap show">
                                                        <img src="/uploads/9302/conversions/profile.jpg" alt="Jozef Majchr&aacute;k">
                                                    </div>
                                                    <div class="header-text" style="">
                                                        <div class="author-name">Jozef Majchr&aacute;k</div><small style="margin-left: 5px;">• pred 20 hod</small>
                                                    </div>
                                                </header>

                                                <div class="article-social-buttons">
                                                    <div class="social-btn">
                                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2524" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                                        </div>
                                                    </div>
                                                    <div class="social-btn">
                                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2524"  data-text="Ozve sa aj Pellegrini?"  class="twitter-share-button">Tweet</a>
                                                    </div>
                                                </div>

                                                <div class="article-text">
                                                    <p>Premi&eacute;r Peter Pellegrini je na n&aacute;v&scaron;teve v Moskve. Dnes by sa mal stretn&uacute;ť s premi&eacute;rom Medvedevom a zajtra s prezidentom Putinom.&nbsp;</p>    <p>Premi&eacute;r ide do Ruska v čase, keď sa v ruskom parlamente objavil n&aacute;vrh z&aacute;kona, ktor&yacute; uzn&aacute;va &uacute;častn&iacute;kov okup&aacute;cie Československa z augusta 1968&nbsp;za vojnov&yacute;ch veter&aacute;nov.</p>    <p>Z&aacute;kon, pochopiteľne, vyvolal v Česku a na Slovensku ostr&eacute; reakcie a zo stoličky <a href="https://www.lidovky.cz/domov/zeman-odsuzuje-navrh-na-uznani-okupantu-z-roku-1968-za-veterany-pozval-si-velvyslance.A190605_110407_ln_domov_ele" class="track-me-pls" data-category="home_kratke-spravy-exit-link">zdvihol </a>aj prezidenta Milo&scaron;a Zemana, ktor&eacute;ho sa určite ned&aacute; podozrievať z rusof&oacute;bie. Zeman si už predvolal rusk&eacute;ho veľvyslanca, od ktor&eacute;ho bude žiadať vysvetlenie tejto iniciat&iacute;vy.&nbsp;</p>    <p>Ot&aacute;zkou t&yacute;ch dn&iacute; tak je, či sa ozve aj n&aacute;&scaron; premi&eacute;r, ktor&yacute; m&aacute; unik&aacute;tnu možnosť povedať svoj n&aacute;zor priamo najvy&scaron;&scaron;&iacute;m rusk&yacute;m l&iacute;drom.&nbsp;</p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>    <p><em>Foto: TASR/Jakub Kotian</em></p>
                                                </div>

                                                <div class="article-image">
                                                    <img src="/uploads/20114/conversions/cover.jpg">
                                                </div>
                                            </div>
                                        </div>
                                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="3"  data-href="https://www.postoj.sk/shortnews/2523" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2523">
                                            <time datetime="2019-06-04 20:16:42">
                                            </time>
                                            <div class="image-wrap hidden-kd-mobile">
                                                <img src="/uploads/20091/conversions/cover.jpg">
                                            </div>
                                            <header class="clearfix">
                                                <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/jaroslav-daniska" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Jaroslav Dani&scaron;ka</a></h3>
                                                <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                                    <a class="author-img" href="https://www.postoj.sk/autor/jaroslav-daniska" data-category="home_kratke-spravy-autor" data-action="click">
                                                        <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">          </a>
                                                    <div class="title">
                                                        <a class="author" href="https://www.postoj.sk/autor/jaroslav-daniska"> <span>Jaroslav Dani&scaron;ka</span> </a>
                                                        <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2523">
                                                            <span>Proti Babi&scaron;ovi &ndash; a nov&eacute; riziko pre česk&uacute; opoz&iacute;ciu</span> </a>
                                                    </div>
                                                </div>
                                                <small class="hidden-kd-mobile">• pred 1 d</small>
                                            </header>
                                            <div class="perex hidden-kd-mobile">
                                                <p>V Prahe sa dnes podvečer kon&aacute; (konala) demon&scaron;tr&aacute;cia proti tamoj&scaron;iemu premi&eacute;rovi Babi&scaron;ovi a ministerke spravodlivosti M&aacute;rii Bene&scaron;ovej, ľud&iacute; mobilizuje Babi&scaron;ov...
                                            </div>
                                            <div class="perex show-kd-mobile">
                                                <p>V Prahe sa dnes podvečer kon&aacute; (konala) demon&scaron;tr&aacute;cia proti tamoj&scaron;iemu premi&eacute;rovi Babi&scaron;ovi a ministerke spravodlivosti M&aacute;rii Bene&scaron;ovej, ľud&iacute; mobilizuje Babi&scaron;ov podvod s eurofondmi (&bdquo;V&scaron;etci kradn&uacute;, iba ja čerp&aacute;m&ldquo;) a pokus ust&aacute;ť to a urobiť z...
                                            </div>


                                        </article>
                                        <div style="display: none;">
                                            <div class="kd-qtip-arrow"></div>
                                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                                <header class="clearfix">
                                                    <div class="image-wrap show">
                                                        <img src="/uploads/9387/conversions/profile.jpg" alt="Jaroslav Dani&scaron;ka">
                                                    </div>
                                                    <div class="header-text" style="">
                                                        <div class="author-name">Jaroslav Dani&scaron;ka</div><small style="margin-left: 5px;">• pred 1 d</small>
                                                    </div>
                                                </header>

                                                <div class="article-social-buttons">
                                                    <div class="social-btn">
                                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2523" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                                        </div>
                                                    </div>
                                                    <div class="social-btn">
                                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2523"  data-text="Proti Babi&scaron;ovi &ndash; a nov&eacute; riziko pre česk&uacute; opoz&iacute;ciu"  class="twitter-share-button">Tweet</a>
                                                    </div>
                                                </div>

                                                <div class="article-text">
                                                    <p>V Prahe sa dnes podvečer kon&aacute; (konala) demon&scaron;tr&aacute;cia proti tamoj&scaron;iemu premi&eacute;rovi Babi&scaron;ovi a ministerke spravodlivosti M&aacute;rii Bene&scaron;ovej, ľud&iacute; mobilizuje Babi&scaron;ov podvod s eurofondmi (&bdquo;V&scaron;etci kradn&uacute;, iba ja čerp&aacute;m&ldquo;) a pokus ust&aacute;ť to a urobiť z jeho konfliktu spor Českej republiky a E&Uacute;. Podľa port&aacute;lu Echo24 pri&scaron;lo na V&aacute;clavsk&eacute; n&aacute;mestie asi 120-tis&iacute;c ľud&iacute;, vystupovala pestr&aacute; zmes ľud&iacute; z regi&oacute;nov, spieval sa protestsong v slovenčine o Babi&scaron;ovi-Bure&scaron;ovi a podobne.</p>    <p>Demon&scaron;tr&aacute;ciou sa niesli odkazy na V&aacute;clava Havla, v&yacute;zvy na vstup do politiky a zmenu pomerov. Demon&scaron;tranti predviedli rad vtipn&yacute;ch aj menej vtipn&yacute;ch sloganov, nabud&uacute;ce chc&uacute; demon&scaron;tr&aacute;ciu zorganizovať na Letnej. Hlavn&yacute;m organiz&aacute;torom je organiz&aacute;cia s n&aacute;zvom Milion chvilek pro demokracii.</p>    <p>Nehroz&iacute;, že by demon&scaron;tr&aacute;cia don&uacute;tila Babi&scaron;a odst&uacute;piť, m&ocirc;že mať ale dosah&nbsp;na podobu českej opozičnej sc&eacute;ny. Na Slovensku m&aacute;me sk&uacute;senosť, ako vznikaj&uacute; cez r&ocirc;zne demon&scaron;tr&aacute;cie nov&eacute; politick&eacute; strany a rastie t&yacute;m fragment&aacute;cia politick&eacute;ho spektra. T&uacute; demon&scaron;tr&aacute;ciu sleduj&uacute; &uacute;plne inak odhodlan&iacute; anti-Babi&scaron;ovci medzi voličmi a inak odhodlan&iacute; anti-Babi&scaron;ovci v politike, najm&auml; politici ODS a Pir&aacute;tov. Keďže sami ulicu neorganizuj&uacute;, pr&aacute;ve im vznik&aacute; konkurencia.</p>    <p>Video z demon&scaron;tr&aacute;cie si <a href="https://echo24.cz/a/SAPDM/zive-vaclavak-proti-babisovi-lez-ma-capi-nohy-skanduje-120-000-lidi" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-exit-link">možno pozrieť v texte na Echu</a>.</p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>    <p><em>Foto: TASR/AP</em></p>
                                                </div>

                                                <div class="article-image">
                                                    <img src="/uploads/20091/conversions/cover.jpg">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>


                            </div>
                        </div>
                        <section class="newsletter-side-form track-me-pls newsletter-fixed-bottom"  data-category="home_newsletter-pridanie" data-action="click" >
                            <header class="">
                                <h2 class="section-title">Nechcete stratiť prehľad?</h2>
                            </header>
                            <form data-url="https://www.postoj.sk/subscribe" class="subscribeForm" action="https://www.postoj.sk/subscribe">

                                <div class="form-group">
                                    <label for="newsletter-email">Odoberajte <strong>náš výber</strong> najdôležitejších článkov a noviniek v redakcii.</label>
                                    <input type="email" id="newsletter-email" name="newsletter-email" class="form-control newsletter-side-form__email-input" placeholder="Váš e-mail">
                                </div>
                                <div class="form-group newsletter-side-form__terms-wrapper clearfix">
                                    <input class="newsletter-side-form__terms-checkbox" type="checkbox" name="terms" id="newsletter-side-form__terms">
                                    <label class="newsletter-side-form__terms-label" for="newsletter-side-form__terms">Súhlasím so spracovaním <a
                                                href="https://podpora.postoj.sk/assets/donations-widget/pdf/suhlas_so_spracovanim_osobnych_udajov.pdf">osobných údajov</a> a zasielaním noviniek </label>
                                </div>

                                <button type="submit" class="btn btn-blue-grad">Chcem prehľad noviniek</button>
                            </form>
                        </section>

                    </div>
                    <div id="article-list-desktop" class="col-md-6 hidden-kd-mobile eq-me">
                        <section class="articles home-articles ">
                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/lukas-mak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/8706/conversions/square.jpg" alt="Luk&aacute;&scaron; Mak">                    <span class="author-name">Luk&aacute;&scaron; Mak</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/25808/po-stopach-vylodenia-" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="1">
                                                    Po stop&aacute;ch vylodenia
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/25808/po-stopach-vylodenia-" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="1">
                                            <div class="image-wrap">
                                                <img  src="/uploads/8707/conversions/square.jpg"  alt="Po stop&aacute;ch vylodenia">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/25808/po-stopach-vylodenia-" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="1">
                                                    Po stop&aacute;ch vylodenia
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Ako dnes vyzeraj&uacute; miesta, kde sa pred 75 rokmi odohrala najv&auml;č&scaron;ia vyloďovacia oper&aacute;cia v&nbsp;hist&oacute;rii.</p>
                                            <p class="show-kd-mobile">
                                                Ako vyzeraj&uacute; miesta, kde sa odohrala najv&auml;č&scaron;ia vyloďovacia oper&aacute;cia v&nbsp;hist&oacute;rii.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/lukas-mak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/8706/conversions/square.jpg" alt="Luk&aacute;&scaron; Mak">                            <span class="author-name">Luk&aacute;&scaron; Mak</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <section class="short-news hidden">
                                <div id="placeholder-for-short-news-0">
                                </div>
                            </section>
                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/maria-melicherova" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/2464/conversions/square.jpg" alt="M&aacute;ria Melicherov&aacute;">                    <span class="author-name">M&aacute;ria Melicherov&aacute;</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44155/nechat-deti-pobit-sa" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="2">
                                                    Nechať deti pobiť sa?
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44155/nechat-deti-pobit-sa" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="2">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20117/conversions/square.jpg"  alt="Nechať deti pobiť sa?">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44155/nechat-deti-pobit-sa" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="2">
                                                    Nechať deti pobiť sa?
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Kedy m&aacute; rodič zasahovať do s&uacute;rodeneck&yacute;ch &scaron;arv&aacute;tok a ako? Robiť sudcu, medi&aacute;tora alebo si to nev&scaron;&iacute;mať?</p>
                                            <p class="show-kd-mobile">
                                                Kedy m&aacute; rodič zasahovať do s&uacute;rodeneck&yacute;ch &scaron;arv&aacute;tok a ako? Robiť sudcu, medi&aacute;tora alebo si to nev&scaron;&iacute;mať?

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/komentare-nazory" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Koment&aacute;re a n&aacute;zory</a>
                                            <a href="https://www.postoj.sk/autor/maria-melicherova" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/2464/conversions/square.jpg" alt="M&aacute;ria Melicherov&aacute;">                            <span class="author-name">M&aacute;ria Melicherov&aacute;</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/jaroslav-daniska" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">                    <span class="author-name">Jaroslav Dani&scaron;ka</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44162/dobre-otazky-ziadna-odpoved" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="3">
                                                    Dobr&eacute; ot&aacute;zky, žiadna odpoveď
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44162/dobre-otazky-ziadna-odpoved" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="3">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20115/conversions/square.jpg"  alt="Dobr&eacute; ot&aacute;zky, žiadna odpoveď">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44162/dobre-otazky-ziadna-odpoved" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="3">
                                                    Dobr&eacute; ot&aacute;zky, žiadna odpoveď
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Čo pon&uacute;ka druh&yacute; diel knihy Radosť evanjelia na Slovensku.</p>
                                            <p class="show-kd-mobile">
                                                Čo pon&uacute;ka druh&yacute; diel knihy Radosť evanjelia na Slovensku.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/svet-krestanstva" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Svet kresťanstva</a>
                                            <a href="https://www.postoj.sk/autor/jaroslav-daniska" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">                            <span class="author-name">Jaroslav Dani&scaron;ka</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <section class="short-news hidden">
                                <div id="placeholder-for-short-news-1">
                                </div>
                            </section>
                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/martin-hanus" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9311/conversions/square.jpg" alt="Martin Hanus">                    <span class="author-name">Martin Hanus</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="4">
                                                    Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="4">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20077/conversions/square.jpg"  alt="Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="4">
                                                    Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Trojica Pellegrini, Ra&scaron;i a&nbsp;Žiga op&auml;ť pochop&iacute;, že ak chce ukazovať svaly, mus&iacute; ich najsk&ocirc;r mať.</p>
                                            <p class="show-kd-mobile">
                                                Trojica Pellegrini, Ra&scaron;i a&nbsp;Žiga op&auml;ť pochop&iacute;, že ak chce ukazovať svaly, mus&iacute; ich najsk&ocirc;r mať.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/politika" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Politika</a>
                                            <a href="https://www.postoj.sk/autor/martin-hanus" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9311/conversions/square.jpg" alt="Martin Hanus">                            <span class="author-name">Martin Hanus</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/lukas-krivosik" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9793/conversions/square.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">                    <span class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44131/medzi-zapadom-a-vychodom-stale-koliseme-a-nie-sme-v-tom-sami" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="5">
                                                    Medzi Z&aacute;padom a V&yacute;chodom st&aacute;le kol&iacute;&scaron;eme a nie sme v tom sami
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44131/medzi-zapadom-a-vychodom-stale-koliseme-a-nie-sme-v-tom-sami" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="5">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20084/conversions/square.jpg"  alt="Medzi Z&aacute;padom a V&yacute;chodom st&aacute;le kol&iacute;&scaron;eme a nie sme v tom sami">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44131/medzi-zapadom-a-vychodom-stale-koliseme-a-nie-sme-v-tom-sami" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="5">
                                                    Medzi Z&aacute;padom a V&yacute;chodom st&aacute;le kol&iacute;&scaron;eme a nie sme v tom sami
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">O čom vypovedaj&uacute; v&yacute;sledky prieskumu GLOBSEC Trends 2019?</p>
                                            <p class="show-kd-mobile">
                                                O čom vypovedaj&uacute; v&yacute;sledky prieskumu GLOBSEC Trends 2019?

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/politika" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Politika</a>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9793/conversions/square.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">                            <span class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <section class="short-news hidden">
                                <div id="placeholder-for-short-news-2">
                                </div>
                            </section>
                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/inzercia" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <span class="author-name">Inzercia</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44171/nedus-nasu-buducnost" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="6">
                                                    Nedus na&scaron;u bud&uacute;cnosť!
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44171/nedus-nasu-buducnost" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="6">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20121/conversions/square.jpg"  alt="Nedus na&scaron;u bud&uacute;cnosť!">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44171/nedus-nasu-buducnost" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="6">
                                                    Nedus na&scaron;u bud&uacute;cnosť!
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Už od roku 1974 je 5. j&uacute;n dňom, kedy cel&yacute; svet venuje &scaron;peci&aacute;lnu pozornosť problematike znečisťovania a&nbsp;ochrany životn&eacute;ho prostredia. Hlavnou t&eacute;mou Sve...</p>
                                            <p class="show-kd-mobile">
                                                Už od roku 1974 je 5. j&uacute;n dňom, kedy cel&yacute; svet venuje &scaron;peci&aacute;lnu pozornosť problematike znečisťovania a&nbsp;ochrany životn&eacute;ho prostredia. Hlavnou t&eacute;mou Sve...

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/tlacove-spravy" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Tlačov&eacute; spr&aacute;vy</a>
                                            <a href="https://www.postoj.sk/autor/inzercia" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">Inzercia</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/imrich-gazda" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9308/conversions/square.jpg" alt=" Imrich Gazda">                    <span class="author-name"> Imrich Gazda</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="7">
                                                    Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="7">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20075/conversions/square.jpg"  alt="Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="7">
                                                    Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">M&aacute;jov&yacute; s&uacute;hrn diania v kresťanskom svete od ved&uacute;ceho rubriky Svet kresťanstva Imricha Gazdu.</p>
                                            <p class="show-kd-mobile">
                                                M&aacute;jov&yacute; s&uacute;hrn diania v kresťanskom svete od ved&uacute;ceho rubriky Svet kresťanstva Imricha Gazdu.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/svet-krestanstva" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Svet kresťanstva</a>
                                            <a href="https://www.postoj.sk/autor/imrich-gazda" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9308/conversions/square.jpg" alt=" Imrich Gazda">                            <span class="author-name"> Imrich Gazda</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/jozef-majchrak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9302/conversions/square.jpg" alt="Jozef Majchr&aacute;k">                    <span class="author-name">Jozef Majchr&aacute;k</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44116/kdh-napadlo-na-ustavnom-sude-rozdelenie-mandatov-z-eurovolieb" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="8">
                                                    KDH napadlo na &Uacute;stavnom s&uacute;de rozdelenie mand&aacute;tov z eurovolieb
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44116/kdh-napadlo-na-ustavnom-sude-rozdelenie-mandatov-z-eurovolieb" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="8">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20068/conversions/square.jpg"  alt="KDH napadlo na &Uacute;stavnom s&uacute;de rozdelenie mand&aacute;tov z eurovolieb">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44116/kdh-napadlo-na-ustavnom-sude-rozdelenie-mandatov-z-eurovolieb" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="8">
                                                    KDH napadlo na &Uacute;stavnom s&uacute;de rozdelenie mand&aacute;tov z eurovolieb
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Chc&uacute;, aby &uacute;stavn&iacute; sudcovia o ich podan&iacute; rozhodli už do začiatku j&uacute;la.</p>
                                            <p class="show-kd-mobile">
                                                Chc&uacute;, aby &uacute;stavn&iacute; sudcovia o ich podan&iacute; rozhodli už do začiatku j&uacute;la.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/politika" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Politika</a>
                                            <a href="https://www.postoj.sk/autor/jozef-majchrak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9302/conversions/square.jpg" alt="Jozef Majchr&aacute;k">                            <span class="author-name">Jozef Majchr&aacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/jozef-majchrak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9302/conversions/square.jpg" alt="Jozef Majchr&aacute;k">                    <span class="author-name">Jozef Majchr&aacute;k</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44097/permanentna-kampan-volodymyra-zelenskeho" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="9">
                                                    Permanentn&aacute; kampaň Volodymyra Zelensk&eacute;ho
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44097/permanentna-kampan-volodymyra-zelenskeho" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="9">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20048/conversions/square.jpg"  alt="Permanentn&aacute; kampaň Volodymyra Zelensk&eacute;ho">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44097/permanentna-kampan-volodymyra-zelenskeho" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="9">
                                                    Permanentn&aacute; kampaň Volodymyra Zelensk&eacute;ho
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Nov&yacute; ukrajinsk&yacute; prezident sľubuje zemetrasenie a chce čo najsk&ocirc;r z&iacute;skať v&auml;č&scaron;inu v parlamente.

                                            </p>
                                            <p class="show-kd-mobile">
                                                Nov&yacute; ukrajinsk&yacute; prezident sľubuje zemetrasenie a chce čo najsk&ocirc;r z&iacute;skať v&auml;č&scaron;inu v parlamente.



                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/politika" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Politika</a>
                                            <a href="https://www.postoj.sk/autor/jozef-majchrak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9302/conversions/square.jpg" alt="Jozef Majchr&aacute;k">                            <span class="author-name">Jozef Majchr&aacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/jaroslav-daniska" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">                    <span class="author-name">Jaroslav Dani&scaron;ka</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44103/cinsky-sen" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="10">
                                                    Č&iacute;nsky sen
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44103/cinsky-sen" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="10">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20057/conversions/square.jpg"  alt="Č&iacute;nsky sen">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44103/cinsky-sen" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="10">
                                                    Č&iacute;nsky sen
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Čo sa stalo pred 30 rokmi a ako to zmenilo svet.</p>
                                            <p class="show-kd-mobile">
                                                Čo sa stalo pred 30 rokmi a ako to zmenilo svet.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/politika" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Politika</a>
                                            <a href="https://www.postoj.sk/autor/jaroslav-daniska" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">                            <span class="author-name">Jaroslav Dani&scaron;ka</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/lukas-obsitnik" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/9304/conversions/square.jpg" alt="Luk&aacute;&scaron; Ob&scaron;itn&iacute;k">                    <span class="author-name">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44093/netflix-a-disney-planuju-pre-pro-life-zakon-stiahnut-zo-statu-georgia-investicie" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="11">
                                                    Netflix a Disney pl&aacute;nuj&uacute; pre pro-life z&aacute;kon stiahnuť zo &scaron;t&aacute;tu Georgia invest&iacute;cie
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44093/netflix-a-disney-planuju-pre-pro-life-zakon-stiahnut-zo-statu-georgia-investicie" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="11">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20047/conversions/square.jpg"  alt="Netflix a Disney pl&aacute;nuj&uacute; pre pro-life z&aacute;kon stiahnuť zo &scaron;t&aacute;tu Georgia invest&iacute;cie">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44093/netflix-a-disney-planuju-pre-pro-life-zakon-stiahnut-zo-statu-georgia-investicie" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="11">
                                                    Netflix a Disney pl&aacute;nuj&uacute; pre pro-life z&aacute;kon stiahnuť zo &scaron;t&aacute;tu Georgia invest&iacute;cie
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">V Georgii sa už nakr&uacute;ca viac ako v Kalifornii. Veľk&eacute; filmov&eacute; spoločnosti sa v&scaron;ak pre pro-life legislat&iacute;vu vyhr&aacute;žaj&uacute; odchodom.</p>
                                            <p class="show-kd-mobile">
                                                V Georgii sa už nakr&uacute;ca viac ako v Kalifornii. Veľk&eacute; filmov&eacute; spoločnosti sa v&scaron;ak pre pro-life legislat&iacute;vu vyhr&aacute;žaj&uacute; odchodom.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/lukas-obsitnik" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/9304/conversions/square.jpg" alt="Luk&aacute;&scaron; Ob&scaron;itn&iacute;k">                            <span class="author-name">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">
                                    <div class="col-xxs-12 show-kd-mobile">
                                        <a href="https://www.postoj.sk/autor/fero-mucka" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                            <img src="/uploads/1388/conversions/square.jpg" alt="Fero M&uacute;čka">                    <span class="author-name">Fero M&uacute;čka</span>
                                        </a>
                                    </div>
                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="12">
                                                    Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="12">
                                            <div class="image-wrap">
                                                <img  src="/uploads/20022/conversions/square.jpg"  alt="Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="12">
                                                    Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Pellegrini ohl&aacute;sil z&aacute;ujem byť predsedom Smeru, Fico by sa s t&yacute;m mohol zmieriť. Čo to sprav&iacute; s bud&uacute;cimi koaličn&yacute;mi kombin&aacute;ciami?</p>
                                            <p class="show-kd-mobile">
                                                Pellegrini ohl&aacute;sil z&aacute;ujem byť predsedom Smeru, Fico by sa s t&yacute;m mohol zmieriť. Čo to sprav&iacute; s bud&uacute;cimi koaličn&yacute;mi kombin&aacute;ciami?

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer class="hidden-kd-mobile">
                                            <a href="https://www.postoj.sk/komentare-nazory" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Koment&aacute;re a n&aacute;zory</a>
                                            <a href="https://www.postoj.sk/autor/fero-mucka" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="/uploads/1388/conversions/square.jpg" alt="Fero M&uacute;čka">                            <span class="author-name">Fero M&uacute;čka</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                        </section>
                    </div>
                    <div class="col-md-12 hidden show-kd-mobile">
                        <div id="our-books__mobile-placeholder">
                        </div>
                    </div>
                    <div class="col-md-3 col-md-3-plus-compensation eq-me">
                        <section class="banner-wrap side-banner  hidden-kd-mobile ">
                            <header>
                                <h3>Inzercia</h3>
                            </header>
                            <div class="banner">


                                <!-- /66396820/Home-newSquares-300x250-300 -->
                                <div id='div-gpt-ad-1446196972660-0'>
                                    <script type='text/javascript'>
                                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1446196972660-0'); });
                                    </script>
                                </div>


                            </div>
                        </section>

                        <section class="christianity-world">
                            <header class="clearfix">
                                <h2 class="section-title">
                                    <a href="https://svetkrestanstva.postoj.sk/svet-krestanstva">Svet kresťanstva</a>
                                </h2>
                            </header>
                            <div class="christianity-world-items">
                                <article class="christianity-world-item">
                                    <div class="row">
                                        <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                            <a href="https://www.postoj.sk/44162/dobre-otazky-ziadna-odpoved">
                                                <div class="image-wrap">
                                                    <img  src="/uploads/20115/conversions/square.jpg"  alt="Dobr&eacute; ot&aacute;zky, žiadna odpoveď">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-7 col-md-7 mobile-text-col">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44162/dobre-otazky-ziadna-odpoved">Dobr&eacute; ot&aacute;zky, žiadna odpoveď</a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item">
                                    <div class="row">
                                        <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                            <a href="https://www.postoj.sk/44148/pred-sudom-v-melbourne-sa-zacalo-odvolacie-konanie-v-pripade-kardinala-pella">
                                                <div class="image-wrap">
                                                    <img  src="/uploads/20102/conversions/square.jpg"  alt="Pred s&uacute;dom v Melbourne sa začalo odvolacie konanie v pr&iacute;pade kardin&aacute;la Pella">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-7 col-md-7 mobile-text-col">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44148/pred-sudom-v-melbourne-sa-zacalo-odvolacie-konanie-v-pripade-kardinala-pella">Pred s&uacute;dom v Melbourne sa začalo odvolacie konanie v pr&iacute;pade kardin&aacute;la Pella</a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item">
                                    <div class="row">
                                        <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                            <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici">
                                                <div class="image-wrap">
                                                    <img  src="/uploads/20075/conversions/square.jpg"  alt="Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-7 col-md-7 mobile-text-col">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44122/vatikan-zbavil-knaza-obvinenia-zo-sexualneho-obtazovania-v-spovednici">Vatik&aacute;n zbavil kňaza obvinenia zo sexu&aacute;lneho obťažovania v spovednici</a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item-small hidden-kd-mobile">
                                    <div class="row">
                                        <div class="col-xxs-12">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44115/kardinal-sako-iracania-nemaju-energiu-na-to-aby-vydrzali-viac-konfliktov">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        Kardin&aacute;l Sako: Iračania nemaj&uacute; energiu na to, aby vydržali viac konfliktov
                                                    </a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item-small hidden-kd-mobile">
                                    <div class="row">
                                        <div class="col-xxs-12">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44088/papez-frantisek-blahoreceni-biskupi-zanechali-rumunskemu-ludu-vzacne-dedicstvo">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        P&aacute;pež Franti&scaron;ek: Blahorečen&iacute; biskupi zanechali rumunsk&eacute;mu ľudu vz&aacute;cne dedičstvo
                                                    </a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item-small hidden-kd-mobile">
                                    <div class="row">
                                        <div class="col-xxs-12">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44076/niektori-knazi-a-reholnicky-sa-nechaju-vylucit-spolu-s-romami">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        Niektor&iacute; kňazi a&nbsp;rehoľn&iacute;čky sa nechaj&uacute; vyl&uacute;čiť spolu s&nbsp;R&oacute;mami
                                                    </a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item-small hidden-kd-mobile">
                                    <div class="row">
                                        <div class="col-xxs-12">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44068/papez-vyzval-na-europsku-jednotu-ideologie-podla-jeho-ohrozuju-existenciu-eu">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        P&aacute;pež vyzval na eur&oacute;psku jednotu, ideol&oacute;gie podľa neho ohrozuj&uacute; existenciu E&Uacute;
                                                    </a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item-small hidden-kd-mobile">
                                    <div class="row">
                                        <div class="col-xxs-12">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44057/papez-blahorecil-v-rumunsku-sedem-biskupov-prenasledovanych-komunistami">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        P&aacute;pež blahorečil v Rumunsku sedem biskupov a požiadal R&oacute;mov o odpustenie
                                                    </a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                            </div>

                        </section>


                        <section class="banner-wrap side-banner  hidden-kd-mobile ">
                            <header>
                                <h3>Inzercia</h3>
                            </header>
                            <div class="banner">



                                <!-- /66396820/Home-new300x125 -->
                                <div id='div-gpt-ad-1453381495492-0'>
                                    <script type='text/javascript'>
                                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-1453381495492-0'); });
                                    </script>
                                </div>

                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-support-bar">
    <div class="container">
        <div class="row">
            <div class="col-xxs-12">

                <section class="banner-wrap billboard-banner ">
                    <div class="banner">
                        <!-- /66396820/Home-newBillboard-970x300-500 -->
                        <div id='div-gpt-ad-1445950671011-0'>
                            <script type='text/javascript'>
                                googletag.cmd.push(function() { googletag.display('div-gpt-ad-1445950671011-0'); });
                            </script>
                        </div>


                    </div>
                </section>











            </div>
        </div>
    </div>
</section>

<section class="home-summary-section">
    <div class="container">
        <div class="row equalize" data-equalize-selector=".eq-me" data-equalize-all="true">
            <div class="col-xxs-12 col-md-6 hidden-kd-mobile eq-me" >
                <section class="short-news short-news-summary">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/kratke-spravy-redakcie" class="track-me-pls" data-category="home_kratke-spravy-dolne-nadpis">
                                Krátke správy redakcie
                            </a>
                        </h2>
                    </header>
                    <div class="row equalize" data-equalize-selector=".eq-me" data-equalize-all="true">
                        <div class="col-xxs-12 col-md-6 eq-me ">
                            <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="1"  data-href="https://www.postoj.sk/shortnews/2522" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2522">
                                <time datetime="2019-06-04 10:39:44">
                                </time>
                                <div class="image-wrap hidden-kd-mobile">
                                    <img src="/uploads/20064/conversions/cover.jpg">
                                </div>
                                <header class="clearfix">
                                    <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/lukas-krivosik" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a></h3>
                                    <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                        <a class="author-img" href="https://www.postoj.sk/autor/lukas-krivosik" data-category="home_kratke-spravy-dolne-autor" data-action="click">
                                            <img src="/uploads/9793/conversions/square.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">          </a>
                                        <div class="title">
                                            <a class="author" href="https://www.postoj.sk/autor/lukas-krivosik"> <span>Luk&aacute;&scaron; Krivo&scaron;&iacute;k</span> </a>
                                            <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2522">
                                                <span>Konzervat&iacute;vny in&scaron;tit&uacute;t osl&aacute;vil dvadsiatku</span> </a>
                                        </div>
                                    </div>
                                    <small class="hidden-kd-mobile">• pred 1 d</small>
                                </header>
                                <div class="perex hidden-kd-mobile">
                                    <p>Konzervat&iacute;vny in&scaron;tit&uacute;t M. R. &Scaron;tef&aacute;nika (KI) si včera pripomenul 20. v&yacute;ročie svojho vzniku. Pri tejto pr&iacute;ležitosti sa v&nbsp;P&aacute;lffyho pal&aacute;ci v&nbsp;Bratislave...
                                </div>
                                <div class="perex show-kd-mobile">
                                    <p>Konzervat&iacute;vny in&scaron;tit&uacute;t M. R. &Scaron;tef&aacute;nika (KI) si včera pripomenul 20. v&yacute;ročie svojho vzniku. Pri tejto pr&iacute;ležitosti sa v&nbsp;P&aacute;lffyho pal&aacute;ci v&nbsp;Bratislave konalo sl&aacute;vnostn&eacute; podujatie.</p>    <p>Konzervat&iacute;vny in&scaron;tit&uacute;t, to s&uacute; predov&scaron;etk&yacute;m men&aacute; jeho spolupracovn&iacute;kov, ktor&iacute; prehov&aacute;raj&uacute; k&nbsp;verejn&yacute;m t&eacute;mam:...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="/uploads/9793/conversions/profile.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</div><small style="margin-left: 5px;">• pred 1 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2522" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2522"  data-text="Konzervat&iacute;vny in&scaron;tit&uacute;t osl&aacute;vil dvadsiatku"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Konzervat&iacute;vny in&scaron;tit&uacute;t M. R. &Scaron;tef&aacute;nika (KI) si včera pripomenul 20. v&yacute;ročie svojho vzniku. Pri tejto pr&iacute;ležitosti sa v&nbsp;P&aacute;lffyho pal&aacute;ci v&nbsp;Bratislave konalo sl&aacute;vnostn&eacute; podujatie.</p>    <p>Konzervat&iacute;vny in&scaron;tit&uacute;t, to s&uacute; predov&scaron;etk&yacute;m men&aacute; jeho spolupracovn&iacute;kov, ktor&iacute; prehov&aacute;raj&uacute; k&nbsp;verejn&yacute;m t&eacute;mam: Riaditeľ KI a ekon&oacute;m Peter Gonda, ale tiež Du&scaron;an Sloboda, Radovan Kazda&nbsp;či Ivan Kuhn. Spomen&uacute;ť tiež treba b&yacute;val&eacute;ho riaditeľa a v s&uacute;časnosti poslanca parlamentu Ondreja Dost&aacute;la.&nbsp;</p>    <p>S&nbsp;t&yacute;mto think-tankom je taktiež neodmysliteľne spojen&aacute; Cena Dominika Tatarku&nbsp;či každoročn&yacute; cyklus semin&aacute;rov Akad&eacute;mia klasickej ekon&oacute;mie. A&nbsp;mnoh&eacute; in&eacute; podujatia.</p>    <p>Napr&iacute;klad na dnes večer KI organizuje diskusn&yacute; klub s&nbsp;n&aacute;zvom <a href="http://www.konzervativizmus.sk/article.php?6243" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">Obloha je na&scaron;e more</a> o&nbsp;československ&yacute;ch letcoch, ktor&iacute; počas druhej svetovej vojny bojovali v&nbsp;britskom kr&aacute;ľovskom letectve. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>    <p>Pre mňa je jednou z&nbsp;najlep&scaron;&iacute;ch akci&iacute; KI predn&aacute;&scaron;kov&yacute; cyklus CEQLS (Conservative Economic Quarterly Lecture Series), v&nbsp;r&aacute;mci ktor&eacute;ho každ&yacute; &scaron;tvrťrok na Slovensko zav&iacute;ta zauj&iacute;mav&yacute; renomovan&yacute; ekon&oacute;m zo zahraničia. S&nbsp;viacer&yacute;mi ste sa stretli aj na str&aacute;nkach Postoja.</p>    <p>Na&scaron;e rozhovory s&nbsp;<a href="https://www.postoj.sk/42939/dnes-mi-pripadate-ako-normalna-spolocnost" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">Davidom Anderssonom</a>, <a href="https://www.postoj.sk/34014/ak-chcete-rychlejsie-dobiehanie-zvolte-si-lepsich-politikov" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">Leszekom Balcerowiczom</a>, či <a href="https://www.postoj.sk/32329/svajciarsky-uspech-je-zmesou-usilia-a-stastia" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">Robertom Nefom</a> boli možn&eacute; pr&aacute;ve vďaka tomu, že pri&scaron;li na Slovensko v&nbsp;r&aacute;mci predn&aacute;&scaron;kov&eacute;ho cyklu CEQLS na pozvanie KI...</p>    <p>K narodenin&aacute;m Konzervat&iacute;vnemu in&scaron;tit&uacute;tu žel&aacute;me v&scaron;etko najlep&scaron;ie a e&scaron;te veľa &uacute;spe&scaron;n&yacute;ch rokov.</p>    <p><em>&Uacute;častn&iacute;kom podujatia k 20. narodenin&aacute;m Konzervat&iacute;vneho in&scaron;tit&uacute;tu sa prihovoril aj Franti&scaron;ek Miklo&scaron;ko (vľavo). Vpravo: s&uacute;časn&yacute; riaditeľ KI Peter Gonda a b&yacute;val&yacute; riaditeľ Ondrej Dost&aacute;l. FOTO &ndash;&nbsp;Facebook/Ondrej Dost&aacute;l</em></p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-dolne-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="/uploads/20064/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="2"  data-href="https://www.postoj.sk/shortnews/2521" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2521">
                                <time datetime="2019-06-03 13:51:17">
                                </time>
                                <div class="image-wrap hidden-kd-mobile">
                                    <img src="/uploads/20038/conversions/cover.jpg">
                                </div>
                                <header class="clearfix">
                                    <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/martin-hanus" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Martin Hanus</a></h3>
                                    <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                        <a class="author-img" href="https://www.postoj.sk/autor/martin-hanus" data-category="home_kratke-spravy-dolne-autor" data-action="click">
                                            <img src="/uploads/9311/conversions/square.jpg" alt="Martin Hanus">          </a>
                                        <div class="title">
                                            <a class="author" href="https://www.postoj.sk/autor/martin-hanus"> <span>Martin Hanus</span> </a>
                                            <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2521">
                                                <span>Ktor&aacute; vl&aacute;da padne prv&aacute;, talianska či nemeck&aacute;?</span> </a>
                                        </div>
                                    </div>
                                    <small class="hidden-kd-mobile">• pred 2 d</small>
                                </header>
                                <div class="perex hidden-kd-mobile">
                                    <p>Eur&oacute;pske voľby sp&ocirc;sobili politick&eacute; zemetrasenie v dvoch v&yacute;znamn&yacute;ch &scaron;t&aacute;toch E&Uacute;. V Nemecku dosiahol proces sebazničenia (&bdquo;Selbstzerst&ouml;rung&ldquo;&nbsp;je dnes v nemčine veľmi...
                                </div>
                                <div class="perex show-kd-mobile">
                                    <p>Eur&oacute;pske voľby sp&ocirc;sobili politick&eacute; zemetrasenie v dvoch v&yacute;znamn&yacute;ch &scaron;t&aacute;toch E&Uacute;. V Nemecku dosiahol proces sebazničenia (&bdquo;Selbstzerst&ouml;rung&ldquo;&nbsp;je dnes v nemčine veľmi popul&aacute;rne slovo) SPD nov&yacute; vrchol. Doteraj&scaron;ia &scaron;&eacute;fka soci&aacute;lnych demokratov&nbsp;Andrea Nahles chcela po volebnej katastrofe prin&uacute;tiť...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="/uploads/9311/conversions/profile.jpg" alt="Martin Hanus">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Martin Hanus</div><small style="margin-left: 5px;">• pred 2 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2521" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2521"  data-text="Ktor&aacute; vl&aacute;da padne prv&aacute;, talianska či nemeck&aacute;?"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Eur&oacute;pske voľby sp&ocirc;sobili politick&eacute; zemetrasenie v dvoch v&yacute;znamn&yacute;ch &scaron;t&aacute;toch E&Uacute;. V Nemecku dosiahol proces sebazničenia (&bdquo;Selbstzerst&ouml;rung&ldquo;&nbsp;je dnes v nemčine veľmi popul&aacute;rne slovo) SPD nov&yacute; vrchol. Doteraj&scaron;ia &scaron;&eacute;fka soci&aacute;lnych demokratov&nbsp;Andrea Nahles chcela po volebnej katastrofe prin&uacute;tiť stran&iacute;kov, aby jej vyjadrili podporu.&nbsp;Udial sa v&scaron;ak prav&yacute; opak, od vlastn&yacute;ch poslancov si musela vypočuť, že je s&iacute;ce fajn, ale na to nem&aacute;.</p>    <p>Dotknut&aacute;&nbsp;Nahles včera&nbsp;ozn&aacute;mila rezign&aacute;ciu, č&iacute;m &scaron;okovala stran&iacute;kov, a t&iacute; sa dnes predh&aacute;ňaj&uacute; v prejavoch&nbsp;zdesenia&nbsp;nad t&yacute;m, ako nemilosrdne SPD zaobch&aacute;dza so svojimi l&iacute;drami. Nahles bola&nbsp;prvou ženou na čele SPD, razila ľavicovej&scaron;&iacute; kurz, nikam to v&scaron;ak neviedlo, pre mlad&yacute;ch voličov s&uacute; soci&aacute;lni demokrati&nbsp;nudnou fos&iacute;liou, oveľa coolovej&scaron;ie je voliť Zelen&yacute;ch. A&nbsp;robotn&iacute;cka trieda&nbsp;v starom zmysle slova sa scvrkla a nechce voliť slniečkarsk&uacute;&nbsp;stranu pr&aacute;ce, ale protimigrantsk&uacute; AfD.</p>    <p>O miere rozkladu&nbsp;SPD svedč&iacute;&nbsp;aj fakt, že najambici&oacute;znej&scaron;&iacute;&nbsp;politici strany odmietli Nahles nahradiť, &iacute;sť do čela&nbsp;SPD sa dnes vn&iacute;ma ako&nbsp;samovražedn&aacute; misia. Medzit&yacute;m v SPD zosilnel&nbsp;hlas, že jedinou možnosťou, ako zachr&aacute;niť stranu pred osudom franc&uacute;zskych socialistov, je ukončiť koal&iacute;ciu s CDU/CSU, &iacute;sť si po por&aacute;žku v predčasn&yacute;ch voľb&aacute;ch&nbsp;a veriť, že potom&nbsp;sa najstar&scaron;ia nemeck&aacute; strana pozviecha.&nbsp;V strane v&scaron;ak už nie je toho, kto by zavelil, takže o ďal&scaron;om smerovan&iacute; rozhodn&uacute; em&oacute;cie v členskej z&aacute;kladni.</p>    <p>Z trochu podobn&eacute;ho d&ocirc;vodu sa otriasa aj talianska vl&aacute;da. Hnutie 5 hviezd utrpelo v eurovoľb&aacute;ch fiasko, k&yacute;m v opoz&iacute;cii sa mu roky darilo, lebo jeho pravou identitou je iba protest, vo vl&aacute;de je bezprizorn&eacute;. V&nbsp;posledn&yacute;ch t&yacute;ždňoch len &uacute;toč&iacute; na Mattea Salviniho, čo ho e&scaron;te viac oslabuje. Naopak, nabuden&yacute; eurov&iacute;ťaz&nbsp;Salvini, ktor&yacute; m&aacute; jasn&uacute; ideologick&uacute; agendu, už dal&nbsp;jasne najavo, že ak mu koaličn&yacute; partner neust&uacute;pi v troch-&scaron;tyroch t&eacute;mach,&nbsp;prestane ho to baviť.</p>    <p>Je zrejm&eacute;, že Salvini už len hľad&aacute; z&aacute;mienku, ako povaliť popul&aacute;rnu vl&aacute;du a vyvolať predčasn&eacute; voľby (len to mus&iacute; zahrať tak, aby nebol vinn&iacute;kom) &ndash;&nbsp;ako povedal jeden jeho spolustran&iacute;k, keby ste videli, že ovocie vis&iacute; tak n&iacute;zko, nesiahli by ste po ňom?&nbsp;</p>    <p>S&uacute;časn&yacute; premi&eacute;r Giuseppe Conte už ch&aacute;pe, že jeho dni &scaron;tatistu sa kr&aacute;tia, dnes večer sa chce prihovoriť Talianom &ndash;&nbsp;očak&aacute;va sa, že vyzve koaličn&yacute;ch partnerov, aby sa pok&uacute;sili o nov&yacute; začiatok, lebo inak to už nebude baviť ani jeho.&nbsp;</p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-dolne-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>    <p><em>Na sn&iacute;mke taliansky minister vn&uacute;tra a l&iacute;der Ligy Matteo Salvini,&nbsp;FOTO TASR/AP&nbsp;</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="/uploads/20038/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="3"  data-href="https://www.postoj.sk/shortnews/2520" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2520">
                                <time datetime="2019-06-03 12:29:21">
                                </time>
                                <div class="image-wrap hidden-kd-mobile">
                                    <img src="/uploads/20037/conversions/cover.jpg">
                                </div>
                                <header class="clearfix">
                                    <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/jaroslav-daniska" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Jaroslav Dani&scaron;ka</a></h3>
                                    <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                        <a class="author-img" href="https://www.postoj.sk/autor/jaroslav-daniska" data-category="home_kratke-spravy-dolne-autor" data-action="click">
                                            <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">          </a>
                                        <div class="title">
                                            <a class="author" href="https://www.postoj.sk/autor/jaroslav-daniska"> <span>Jaroslav Dani&scaron;ka</span> </a>
                                            <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2520">
                                                <span>V&aacute;clav Benda, 20. v&yacute;ročie smrti</span> </a>
                                        </div>
                                    </div>
                                    <small class="hidden-kd-mobile">• pred 2 d</small>
                                </header>
                                <div class="perex hidden-kd-mobile">
                                    <p>Je to 20 rokov, čo zomrel V&aacute;clav Benda (1946 &ndash; 1999), v&yacute;znamn&yacute; česk&yacute; filozof a disident, konzervat&iacute;vny katol&iacute;k, ktor&yacute; po...
                                </div>
                                <div class="perex show-kd-mobile">
                                    <p>Je to 20 rokov, čo zomrel V&aacute;clav Benda (1946 &ndash; 1999), v&yacute;znamn&yacute; česk&yacute; filozof a disident, konzervat&iacute;vny katol&iacute;k, ktor&yacute; po roku 1989 spojil svoje vn&iacute;manie politiky s ODS, čo sa &ndash;&nbsp;mysl&iacute;m &ndash;&nbsp;uk&aacute;zalo byť nielen spr&aacute;vne,...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="/uploads/9387/conversions/profile.jpg" alt="Jaroslav Dani&scaron;ka">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Jaroslav Dani&scaron;ka</div><small style="margin-left: 5px;">• pred 2 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2520" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2520"  data-text="V&aacute;clav Benda, 20. v&yacute;ročie smrti"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Je to 20 rokov, čo zomrel V&aacute;clav Benda (1946 &ndash; 1999), v&yacute;znamn&yacute; česk&yacute; filozof a disident, konzervat&iacute;vny katol&iacute;k, ktor&yacute; po roku 1989 spojil svoje vn&iacute;manie politiky s ODS, čo sa &ndash;&nbsp;mysl&iacute;m &ndash;&nbsp;uk&aacute;zalo byť nielen spr&aacute;vne, ale v posledn&yacute;ch rokoch aj prezierav&eacute; a &uacute;spe&scaron;n&eacute;. Celkom iste to plat&iacute; od Klausovho vetovania z&aacute;kona o registrovan&yacute;ch partnerstv&aacute;ch a n&aacute;stupu&nbsp;viacer&yacute;ch katol&iacute;kov do čela ODS, patr&iacute; sa spomen&uacute;ť Petra Nečasa a Petra Fialu.</p>    <p>V ODS sa tiež dar&iacute; Markovi Bendovi, synovi disidenta V&aacute;clava Bendu, a dar&iacute; sa aj konverzi&aacute;m, pred časom konvertoval na vieru Alexander Vondra, b&yacute;val&yacute; bl&iacute;zky spolupracovn&iacute;k V&aacute;clava Havla a po posledn&yacute;ch voľb&aacute;ch europoslanec, pred n&iacute;m napr. b&yacute;val&yacute; premi&eacute;r Topol&aacute;nek.&nbsp;</p>    <p>Benda zostane v pam&auml;ti najm&auml; kv&ocirc;li <a href="https://cs.wikipedia.org/wiki/Paraleln%C3%AD_polis" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">konceptu paralelnej polis</a>, ktor&yacute; patr&iacute; k tomu najorigin&aacute;lnej&scaron;iemu, čo v československom disente vzniklo. Bendovu pamiatku si dnes pripom&iacute;na aj pražsk&yacute; Občiansky in&scaron;tit&uacute;t, na ktor&eacute;ho čele&nbsp;stoj&iacute; ďal&scaron;&iacute; katol&iacute;k Roman Joch (<a href="http://www.obcinst.cz/zizen-po-spravedlnosti-vaclav-benda-1946-1999/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">viac tu</a>), no a na Slovensku by sme nemali zab&uacute;dať, že Benda bol azda najviac pro-slovensk&yacute; spomedzi pražsk&yacute;ch disidentov, dok&aacute;zal to viacer&yacute;mi textami a postojmi, o. i. ocenen&iacute;m mas&iacute;vneho &uacute;spechu p&uacute;te na Velehrad, čo op&iacute;sal v obsiahlej eseji v samizdate Rozmluvy v roku 1986, ako aj docenen&iacute;m veľkej roly, ktor&uacute; na Slovensku zohr&aacute;vala tajn&aacute; Cirkev, čo si na rozdiel od &Scaron;tB viacer&iacute; liber&aacute;lni disidenti ani nev&scaron;imli.</p>    <p>Bendovu pamiatku si treba pripomen&uacute;ť a jeho dielo poznať. S&uacute;bor jeho textov vy&scaron;iel v roku 2009 ako <em><span class="reference-text">Nočn&iacute; k&aacute;drov&yacute; dotazn&iacute;k a jin&eacute; boje</span></em>.</p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-dolne-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="/uploads/20037/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>

                        </div>                                       <div class="col-xxs-12 col-md-6 eq-me  border-left ">
                            <article class="short-news-item  with-img     track-me-pls  "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="4"  data-href="https://www.postoj.sk/shortnews/2519" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2519">
                                <time datetime="2019-06-03 11:34:51">
                                </time>
                                <div class="image-wrap hidden-kd-mobile">
                                    <img src="/uploads/20031/conversions/cover.jpg">
                                </div>
                                <header class="clearfix">
                                    <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/jaroslav-daniska" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Jaroslav Dani&scaron;ka</a></h3>
                                    <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                        <a class="author-img" href="https://www.postoj.sk/autor/jaroslav-daniska" data-category="home_kratke-spravy-dolne-autor" data-action="click">
                                            <img src="/uploads/9387/conversions/square.jpg" alt="Jaroslav Dani&scaron;ka">          </a>
                                        <div class="title">
                                            <a class="author" href="https://www.postoj.sk/autor/jaroslav-daniska"> <span>Jaroslav Dani&scaron;ka</span> </a>
                                            <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2519">
                                                <span>Ako ir&aacute;nsky politik zabil svoju ženu</span> </a>
                                        </div>
                                    </div>
                                    <small class="hidden-kd-mobile">• pred 2 d</small>
                                </header>
                                <div class="perex hidden-kd-mobile">
                                    <p>Tento pr&iacute;beh sa vymyk&aacute; v&scaron;etk&eacute;mu, v Ir&aacute;ne, kde k nemu do&scaron;lo, vyvolal &scaron;ok a vlnu kon&scaron;pir&aacute;ci&iacute;. Mohammad Ali Najafi (na...
                                </div>
                                <div class="perex show-kd-mobile">
                                    <p>Tento pr&iacute;beh sa vymyk&aacute; v&scaron;etk&eacute;mu, v Ir&aacute;ne, kde k nemu do&scaron;lo, vyvolal &scaron;ok a vlnu kon&scaron;pir&aacute;ci&iacute;. Mohammad Ali Najafi (na obr. vpravo), ročn&iacute;k 1952, je &scaron;pičkov&yacute; ir&aacute;nsky matematik, absolvent MIT v Amerike, PhD &scaron;t&uacute;dium preru&scaron;il...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="/uploads/9387/conversions/profile.jpg" alt="Jaroslav Dani&scaron;ka">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Jaroslav Dani&scaron;ka</div><small style="margin-left: 5px;">• pred 2 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2519" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2519"  data-text="Ako ir&aacute;nsky politik zabil svoju ženu"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Tento pr&iacute;beh sa vymyk&aacute; v&scaron;etk&eacute;mu, v Ir&aacute;ne, kde k nemu do&scaron;lo, vyvolal &scaron;ok a vlnu kon&scaron;pir&aacute;ci&iacute;. Mohammad Ali Najafi (na obr. vpravo), ročn&iacute;k 1952, je &scaron;pičkov&yacute; ir&aacute;nsky matematik, absolvent MIT v Amerike, PhD &scaron;t&uacute;dium preru&scaron;il a nedokončil kv&ocirc;li tomu, že sa po vypuknut&iacute; ir&aacute;nskej revol&uacute;cie vr&aacute;til domov.&nbsp;</p>    <p>Doma sa mu darilo, <a href="https://en.wikipedia.org/wiki/Mohammad-Ali_Najafi" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">zast&aacute;val vysok&eacute; poz&iacute;cie</a> v akademickej sf&eacute;re, viedol techno-in&scaron;tit&uacute;t, univerzitu, opakovane bol ministrom alebo vysok&yacute;m &uacute;radn&iacute;kom či poradcom vo vl&aacute;dach s reformn&yacute;m premi&eacute;rom. Bol napr&iacute;klad ministrom &scaron;kolstva, ministrom vedy a napokon v rokoch 2017-2018 prim&aacute;torom Teher&aacute;nu. &nbsp;</p>    <p>Pred dvomi rokmi ho oslovila v&yacute;razne mlad&scaron;ia herečka&nbsp;Mitra Ostadov&aacute; (na obr. vľavo), ktor&aacute; chcela kandidovať do zastupiteľstva, Ali Najafi ju podporil, ale ona neuspela. Minul&yacute; rok sa v&scaron;ak zosob&aacute;&scaron;ili, kr&aacute;tko predt&yacute;m sa rozviedol so svojou ženou, čo bol prv&yacute; &scaron;ok, keďže ir&aacute;nska spoločnosť a vl&aacute;dnuci klerici s&uacute; k tak&yacute;mto veciam kritick&iacute;. V tom istom roku Ali Najafi odst&uacute;pil z postu prim&aacute;tora Teher&aacute;nu, kde mal blokovať niektor&eacute; developersk&eacute; projekty napojen&eacute; na tvrd&scaron;iu l&iacute;niu ir&aacute;nskych politikov. D&ocirc;vodom jeho odst&uacute;penia bolo pre niektor&yacute;ch jeho zdravie, pre in&yacute;ch video, kde mal byť &uacute;častn&yacute; na večierku s tancuj&uacute;cimi ženami.</p>    <p>&Scaron;ok pri&scaron;iel na konci minul&eacute;ho t&yacute;ždňa: Ali Najafi doma zastrelil svoju ženu Mitru, mala 35 rokov.&nbsp;</p>    <p>K vražde sa priznal, pr&aacute;vnici tvrdia, že nebola pl&aacute;novan&aacute;, že bol popuden&yacute; t&yacute;m, čo si preč&iacute;tal na jej Whatsuppe, keď sa sprchovala, zobral pi&scaron;toľ, pri&scaron;iel do k&uacute;peľne, ona na neho skočila a do&scaron;lo k tragickej nehode. Pol&iacute;cia hovor&iacute; o dvoch v&yacute;streloch a dvoch poraneniach, Mitra Ostadov&aacute; bola na mieste mŕtva.</p>    <p>Ali Najafi najsk&ocirc;r z miesta činu u&scaron;iel, cestoval 300 km na hrob svojho otca, potom i&scaron;iel na pol&iacute;ciu a k činu sa priznal. Za d&ocirc;vod popudlivej akcie označil to, že jeho žena mala kontakt s tajn&yacute;mi službami. Minister pre tajn&eacute; služby to poprel. Ali Najafi je moment&aacute;lne zadržan&yacute; a čak&aacute; na vznesenie obvinenia, matka Mitry Ostadovej žiada trest smrti.</p>    <p>Podľa <a href="https://www.ft.com/content/fdf51926-82a5-11e9-9935-ad75bb96c849" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">čl&aacute;nku denn&iacute;ka Financial Times</a> mal byť Ali Najafi bud&uacute;cim kandid&aacute;tom na &uacute;rad ir&aacute;nskeho prezidenta, FT tiež opisuje vlnu kon&scaron;piračn&yacute;ch te&oacute;ri&iacute;, ktor&eacute;&nbsp;za vraždou vidia pascu proti nemu, Ali Najafi podľa nich nevystupuje ako vrah, do&scaron;lo totiž k ďal&scaron;ej netradičnej veci &ndash;&nbsp;Najafi verejne vyst&uacute;pil v telev&iacute;zii, po vražde, kde sa k činu priznal. Jeho obhajcovia vidia v tejto vražde dve obete, tak či onak, mimoriadne z&uacute;fal&yacute; obraz s&uacute;časn&eacute;ho Ir&aacute;nu.</p>    <p>Na YouTube n&aacute;jdete viacero vide&iacute;, ktor&eacute; sa t&eacute;me venuj&uacute;, <a href="https://www.youtube.com/watch?v=4jK1dI06mSg" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">uk&aacute;žka napr. tu</a>.&nbsp;</p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-dolne-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="/uploads/20031/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls  "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="5"  data-href="https://www.postoj.sk/shortnews/2518" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2518">
                                <time datetime="2019-06-01 17:55:01">
                                </time>
                                <div class="image-wrap hidden-kd-mobile">
                                    <img src="/uploads/19999/conversions/cover.jpg">
                                </div>
                                <header class="clearfix">
                                    <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/jan-duda-1" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">J&aacute;n Duda</a></h3>
                                    <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                        <a class="author-img" href="https://www.postoj.sk/autor/jan-duda-1" data-category="home_kratke-spravy-dolne-autor" data-action="click">
                                            <img src="/uploads/1885/conversions/square.jpg" alt="J&aacute;n Duda">          </a>
                                        <div class="title">
                                            <a class="author" href="https://www.postoj.sk/autor/jan-duda-1"> <span>J&aacute;n Duda</span> </a>
                                            <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2518">
                                                <span>Jednota medzi človekom a Bohom</span> </a>
                                        </div>
                                    </div>
                                    <small class="hidden-kd-mobile">• pred 4 d</small>
                                </header>
                                <div class="perex hidden-kd-mobile">
                                    <p>Evanjelium siedmej veľkonočnej nedele (2. 6. 2019) patr&iacute; k Ježi&scaron;ovej rozl&uacute;čkovej reči (Jn 17,20-26). Ježi&scaron; ju povedal e&scaron;te pred svoj&iacute;m...
                                </div>
                                <div class="perex show-kd-mobile">
                                    <p>Evanjelium siedmej veľkonočnej nedele (2. 6. 2019) patr&iacute; k Ježi&scaron;ovej rozl&uacute;čkovej reči (Jn 17,20-26). Ježi&scaron; ju povedal e&scaron;te pred svoj&iacute;m utrpen&iacute;m a smrťou, liturgia n&aacute;m text predklad&aacute; v nedeľu pred sviatkom Zoslania Ducha Sv&auml;t&eacute;ho. Ježi&scaron;...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="/uploads/1885/conversions/profile.jpg" alt="J&aacute;n Duda">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">J&aacute;n Duda</div><small style="margin-left: 5px;">• pred 4 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2518" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2518"  data-text="Jednota medzi človekom a Bohom"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Evanjelium siedmej veľkonočnej nedele (2. 6. 2019) patr&iacute; k Ježi&scaron;ovej rozl&uacute;čkovej reči (Jn 17,20-26). Ježi&scaron; ju povedal e&scaron;te pred svoj&iacute;m utrpen&iacute;m a smrťou, liturgia n&aacute;m text predklad&aacute; v nedeľu pred sviatkom Zoslania Ducha Sv&auml;t&eacute;ho. Ježi&scaron; pros&iacute; o tak&uacute; jednotu medzi veriacimi, ak&aacute; existuje medzi n&iacute;m a jeho Otcom, ba pros&iacute; o jednotu medzi ľuďmi a Bohom!</p>    <p>(1) Jednotu medzi človekom a Bohom pripom&iacute;na nedeľn&eacute; prv&eacute; č&iacute;tanie. &Scaron;tefan, pln&yacute; Ducha Sv&auml;t&eacute;ho, videl otvoren&eacute; nebo a Syna človeka st&aacute;ť po pravici Boha (Sk 7,55). T&uacute;to mystick&uacute; jednotu s Bohom zažil v kľ&uacute;čovom momente svojho života: v momente svojej mučen&iacute;ckej smrti. Prečo dne&scaron;n&yacute; svet tak m&aacute;lo in&scaron;piruj&uacute; mučen&iacute;ci, ľudia mor&aacute;lne čist&iacute;? &bdquo;Ľud, ktor&yacute; zabudol na svojich hrdinov, je mŕtvym ľudom. Cirkev, ktor&aacute; zab&uacute;da na svojich hrdinov, je nemocnou.&ldquo; (R. Laurentin, s. 213)</p>    <p>(2) Ježi&scaron; hovor&iacute; o l&aacute;ske svojho Otca pr&iacute;tomnej v n&aacute;s (Jn 17,26), Skutky apo&scaron;tolov hovoria, že &bdquo;&Scaron;tefan bol pln&yacute; Ducha Sv&auml;t&eacute;ho&ldquo; (Sk 7,55). Každ&aacute; inform&aacute;cia o Duchu Sv&auml;tom nie je postačuj&uacute;cou. Ale možno to trochu objasniť pr&iacute;kladom. Muž a žena, ktor&iacute; vst&uacute;pia do manželstva, nikdy nebud&uacute; mať dostatok inform&aacute;ci&iacute; jeden o druhom. Taktiež nikdy nebud&uacute; mať primeran&eacute; prirodzen&eacute; kvality, ktor&eacute; by potrebovali pre v&yacute;chovu svojich det&iacute;. Ale v konečnom d&ocirc;sledku, je to l&aacute;ska muža a ženy, otca a matky, ktor&aacute; najviac formuje hodnoty a vlastnosti v ich deťoch (Laurentin, s. 10).</p>    <p>Požehnan&uacute; veľkonočn&uacute; nedeľu prajem v&scaron;etk&yacute;m.</p>    <p>J&aacute;n Duda</p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-dolne-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>    <p><em>Na sn&iacute;mke: Bernardo Daddi &ndash; Umučenie sv. &Scaron;tefana (freska, 1324), kostol Santa Croce, Florencia.</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="/uploads/19999/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls  "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="6"  data-href="https://www.postoj.sk/shortnews/2517" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2517">
                                <time datetime="2019-06-01 13:10:36">
                                </time>
                                <div class="image-wrap hidden-kd-mobile">
                                    <img src="/uploads/19990/conversions/cover.jpg">
                                </div>
                                <header class="clearfix">
                                    <h3 class="author-link hidden-kd-mobile"><a href="https://www.postoj.sk/autor/lukas-obsitnik" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</a></h3>
                                    <div class="avatar avatar--show-kd-mobile show-kd-mobile">
                                        <a class="author-img" href="https://www.postoj.sk/autor/lukas-obsitnik" data-category="home_kratke-spravy-dolne-autor" data-action="click">
                                            <img src="/uploads/9304/conversions/square.jpg" alt="Luk&aacute;&scaron; Ob&scaron;itn&iacute;k">          </a>
                                        <div class="title">
                                            <a class="author" href="https://www.postoj.sk/autor/lukas-obsitnik"> <span>Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</span> </a>
                                            <a class="article-title" href="https://www.postoj.sk/kratke-spravy-redakcie/2517">
                                                <span>Louisiana je už &ocirc;smym &scaron;t&aacute;tom USA, kde pro-life z&aacute;kon o bit&iacute; srdca podp&iacute;sal guvern&eacute;r</span> </a>
                                        </div>
                                    </div>
                                    <small class="hidden-kd-mobile">• pred 4 d</small>
                                </header>
                                <div class="perex hidden-kd-mobile">
                                    <p>Guvern&eacute;r americk&eacute;ho &scaron;t&aacute;tu&nbsp;Louisiana John Bel Edwards <a href="https://www.lifenews.com/2019/05/30/louisiana-gov-john-bel-edwards-signs-banning-abortions-when-unborn-babys-heartbeat-begins/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">podp&iacute;sal</a> z&aacute;kon na ochranu života nenaroden&yacute;ch det&iacute;, ktor&yacute; predt&yacute;m <a...
                                </div>
                                <div class="perex show-kd-mobile">
                                    <p>Guvern&eacute;r americk&eacute;ho &scaron;t&aacute;tu&nbsp;Louisiana John Bel Edwards <a href="https://www.lifenews.com/2019/05/30/louisiana-gov-john-bel-edwards-signs-banning-abortions-when-unborn-babys-heartbeat-begins/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">podp&iacute;sal</a> z&aacute;kon na ochranu života nenaroden&yacute;ch det&iacute;, ktor&yacute; predt&yacute;m <a href="https://www.postoj.sk/43961/v-louisiane-schvalili-prisny-zakaz-interrupcii-od-6-tyzdna" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">schv&aacute;lil</a> louisiansk&yacute; parlament. Z&aacute;kon zakazuje vykonanie potratu po tom, čo je plodu diagnostikovan&eacute;...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="/uploads/9304/conversions/profile.jpg" alt="Luk&aacute;&scaron; Ob&scaron;itn&iacute;k">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</div><small style="margin-left: 5px;">• pred 4 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2517" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2517"  data-text="Louisiana je už &ocirc;smym &scaron;t&aacute;tom USA, kde pro-life z&aacute;kon o bit&iacute; srdca podp&iacute;sal guvern&eacute;r"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Guvern&eacute;r americk&eacute;ho &scaron;t&aacute;tu&nbsp;Louisiana John Bel Edwards <a href="https://www.lifenews.com/2019/05/30/louisiana-gov-john-bel-edwards-signs-banning-abortions-when-unborn-babys-heartbeat-begins/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">podp&iacute;sal</a> z&aacute;kon na ochranu života nenaroden&yacute;ch det&iacute;, ktor&yacute; predt&yacute;m <a href="https://www.postoj.sk/43961/v-louisiane-schvalili-prisny-zakaz-interrupcii-od-6-tyzdna" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">schv&aacute;lil</a> louisiansk&yacute; parlament. Z&aacute;kon zakazuje vykonanie potratu po tom, čo je plodu diagnostikovan&eacute; bitie srdca (približne &scaron;iesty t&yacute;ždeň&nbsp;tehotenstva), umožňuje ho len v pr&iacute;pade ohrozenia života matky.</p>    <p>Z&aacute;kon predt&yacute;m <a href="http://www.legis.la.gov/legis/BillInfo.aspx?s=19RS&amp;b=SB184&amp;sbi=y" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">schv&aacute;lil</a>&nbsp;louisiansk&yacute; Sen&aacute;t s v&yacute;raznou v&auml;č&scaron;inou v pomere hlasov 31 k 5 a podobne&nbsp;Snemovňa reprezentantov v pomere 79 k 23. Zauj&iacute;mav&eacute; je, že ho podp&iacute;sal guvern&eacute;r Edwards, ktor&yacute; je jedn&yacute;m z m&aacute;la pro-life demokratov. Pri podpise povedal: &bdquo;Uvedomujem si, že vec&nbsp;potratov mnoho ľud&iacute; vn&iacute;ma veľmi z&aacute;sadne a že so mnou nes&uacute;hlasia &ndash; a ja ich n&aacute;zory re&scaron;pektujem. O&nbsp;&uacute;rad guvern&eacute;ra som sa uch&aacute;dzal ako pro-life kandid&aacute;t po &ocirc;smich rokoch svojho p&ocirc;sobenia ako pro-life z&aacute;konodarca. Ako guvern&eacute;r si stoj&iacute;m za svoj&iacute;m slovom a presvedčen&iacute;m. Ale tiež &uacute;primne ver&iacute;m v to, že byť pro-life znamen&aacute; viac než len &sbquo;pro-narodenie&lsquo;. Moja vl&aacute;da za posledn&eacute; tri roky prijala rad opatren&iacute; pre to, aby mohli byť mnoh&eacute; deti prijat&eacute; do n&aacute;&scaron;ho syst&eacute;mu pest&uacute;nskej starostlivosti.&ldquo;</p>    <p>Z&aacute;kon&nbsp;v Louisiane vst&uacute;pi do platnosti, ak podobn&eacute; ustanovenie v susednom Mississippi uspeje pred odvolac&iacute;m s&uacute;dom, keďže mu dočasne pozastavil platnosť feder&aacute;lny sudca.</p>    <p>Louisiana sa tak stala &ocirc;smym americk&yacute;m &scaron;t&aacute;tom, v ktorom z&aacute;konodarn&yacute; zbor schv&aacute;lil tzv. <a href="https://www.postoj.sk/42381/zakony-o-biti-srdca-nenarodenych-prijme-mozno-az-10-statov-usa" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">z&aacute;kon o bit&iacute; srdca</a>&nbsp;a s&uacute;časne ho podp&iacute;sal aj guvern&eacute;r. V minulom obdob&iacute; tak&yacute; z&aacute;kon schv&aacute;lili &scaron;t&aacute;ty Arkansas, Severn&aacute; Dakota, Iowa, Kentucky, Mississippi, Ohio a&nbsp;Georgia. Jeho schv&aacute;lenie je na dobrej ceste aj vo viacer&yacute;ch ďal&scaron;&iacute;ch &scaron;t&aacute;toch. Podobn&yacute; pro-life z&aacute;kon (neviažuci sa na bitie srdca) pred p&aacute;r t&yacute;ždňami schv&aacute;lili aj <a href="https://www.postoj.sk/43632/cim-prolife-zakon-v-alabame-je-a-cim-nie-je" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">v Alabame</a>.</p>    <p>Vzhľadom na platn&eacute; rozhodnutie Najvy&scaron;&scaron;ieho s&uacute;du USA z roku 1973 v pr&iacute;pade Roe vs. Wade tak&aacute;to legislat&iacute;va konč&iacute; na s&uacute;doch.&nbsp;Očak&aacute;va sa v&scaron;ak, že sa &scaron;t&aacute;ty odvolaj&uacute; a pr&iacute;pad op&auml;tovne presk&uacute;ma Najvy&scaron;&scaron;&iacute; s&uacute;d, ktor&yacute; m&ocirc;že svoje predo&scaron;l&eacute; stanovisko teraz opraviť.</p>    <p><em>Foto: Mapa &scaron;t&aacute;tov s pro-life legislat&iacute;vou &bdquo;o bit&iacute; srdca&ldquo;: ikona srdca: &scaron;t&aacute;ty, kde bol z&aacute;kon schv&aacute;len&yacute; oboma komorami parlamentu a podp&iacute;san&yacute; guvern&eacute;rom, modr&aacute; farba: z&aacute;kon schv&aacute;lili obe komory parlamentu, zelen&aacute;: z&aacute;kon pre&scaron;iel jednou komorou parlamentu v roku 2019, červen&aacute;: z&aacute;kon bol v roku 2019 uveden&yacute; v parlamente, ružov&aacute;: z&aacute;kon bol uveden&yacute; v parlamente v predo&scaron;l&yacute;ch rokoch a v s&uacute;časnosti sa v ňom nekon&aacute;. Stav k 30. m&aacute;ju 2019.&nbsp;Zdroj: Population Research&nbsp;Institute (pop.org)</em></p>    <p><em>Ďakujeme, že č&iacute;tate Postoj. P&iacute;&scaron;eme vďaka darom od na&scaron;ich čitateľov, ľud&iacute;, ako ste vy.&nbsp;<strong><u><a data-category="home_kratke-spravy-dolne-exit-link" href="https://podpora.postoj.sk/nova-kampan?utm_source=postoj&amp;utm_medium=kratka_sprava&amp;utm_campaign=na_zaciatku" target="_blank" class="track-me-pls">Podporte n&aacute;s, pros&iacute;me</a>.</u></strong></em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="/uploads/19990/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>

                        </div>









































                    </div>
                </section>
            </div>
            <div class="col-xxs-12 col-md-6 eq-me border-left blog-section-col">
                <section class="blog-summary">
                    <header class="clearfix">
                        <h2 class="section-title">
                            <a href="https://blog.postoj.sk/blog" class="track-me-pls" data-category="home_blog-nadpis">Blogy</a>
                        </h2>


                        <ul class="blog-summary-switch clearfix" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#latest" aria-controls="home" role="tab" data-toggle="tab">najnovšie</a>
                            </li>
                            <li role="presentation">
                                <a href="#most-popular" aria-controls="profile" role="tab" data-toggle="tab">najčítanejšie</a>
                            </li>
                        </ul>
                    </header>

                    <div class="tab-content">
                        <div id="latest" class="blog-summary-list tab-pane active equalize" data-equalize-selector=".eq-me" data-equalize-all="true" role="tabpanel">
                            <article class="blog-summary-full-item">
                                <i class="icon icon-arrow-right-grey"></i>
                                <div class="row">
                                    <div class="col-xxs-12 col-md-12">
                                        <div class="blog-about pull-left">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44169/pisanie-v-kryte">P&iacute;sanie v kryte</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/dominika-marusakova" class="avatar avatar-little">
                                                        <img src="/uploads/20054/conversions/square.jpg" alt="Dominika Maru&scaron;akov&aacute;">

                                                        <span class="author-name">Dominika Maru&scaron;akov&aacute;</span>
                                                    </a>
                                                </h3>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </article>




                            <article class="blog-summary-full-item">
                                <i class="icon icon-arrow-right-grey"></i>
                                <div class="row">
                                    <div class="col-xxs-12 col-md-12">
                                        <div class="blog-about pull-left">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44172/zomierajuce-dedicstvo-svateho-bonifaca">Zomieraj&uacute;ce dedičstvo sv&auml;t&eacute;ho Bonif&aacute;ca</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/gabriel-huncaga-1" class="avatar avatar-little">
                                                        <img src="/uploads/6526/conversions/square.jpg" alt="Gabriel Hunčaga">

                                                        <span class="author-name">Gabriel Hunčaga</span>
                                                    </a>
                                                </h3>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </article>




                            <article class="blog-summary-full-item">
                                <i class="icon icon-arrow-right-grey"></i>
                                <div class="row">
                                    <div class="col-xxs-12 col-md-12">
                                        <div class="blog-about pull-left">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/44170/po-vyjadreniach-hlinu-sa-kardinal-sarah-prihovara-mlciacim-clenom-kdh">Po vyjadreniach Hlinu sa kardin&aacute;l Sarah prihov&aacute;ra mlčiacim členom KDH</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/ferdinand-turinic" class="avatar avatar-little">
                                                        <img src="/uploads/11874/conversions/square.jpg" alt="Ferdinand Turinič">

                                                        <span class="author-name">Ferdinand Turinič</span>
                                                    </a>
                                                </h3>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <div class="row">
                                <div class="col-xxs-12 col-md-6 blog-summary-articles-list hidden-kd-mobile eq-me">




                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/jan-pola ">
                                                            J&aacute;n Poľa
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44159/preco-si-vsetci-gejovia-nezasluzia-legislativnu-podporu">Prečo si v&scaron;etci gejovia nezasl&uacute;žia legislat&iacute;vnu podporu?</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/radomir-tomecek ">
                                                            Radom&iacute;r Tomeček
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44111/peklo-je-vecne">Peklo je večn&eacute;</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/alex-trstensky ">
                                                            Alex Trstensk&yacute;
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44091/edgar-allan-poe-annabel-lee-1849">Edgar Allan Poe: Annabel Lee (1849)</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>



                                </div>
                                <div class="col-xxs-12 col-md-6 blog-summary-articles-list border-left hidden-kd-mobile eq-me">



                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/jakub-malota ">
                                                            Jakub  Malota
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44080/ako-sme-vymenili-mece-za-smartfony">Ako sme vymenili meče za smartf&oacute;ny</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/miroslav-klobucnik ">
                                                            Miroslav Klobučn&iacute;k
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44079/kto-bude-stat-po-boku-prezidentky">Kto bude st&aacute;ť po boku prezidentky?</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/robert-puk ">
                                                            Robert  Puk
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44067/ako-hojsik-nastupuje-do-europarlamentu">Ako &quot;ochran&aacute;r&quot; Hojs&iacute;k nastupuje do europarlamentu</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>




                                </div>

                            </div>
                        </div>

                        <div id="most-popular" class="blog-summary-list tab-pane" role="tabpanel">
                            <article class="blog-summary-full-item">
                                <i class="icon icon-arrow-right-grey"></i>
                                <div class="row">
                                    <div class="col-xxs-12 col-md-12">
                                        <div class="blog-about pull-left">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/43989/koalicia-kdhku-by-jednote-krestanov-v-politike-uskodila">Koal&iacute;cia KDH/K&Uacute; by jednote kresťanov v politike u&scaron;kodila</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/slavomir-gregorik" class="avatar avatar-little">
                                                        <img src="/uploads/16175/conversions/square.jpg" alt="Slavom&iacute;r Gregor&iacute;k">

                                                        <span class="author-name">Slavom&iacute;r Gregor&iacute;k</span>
                                                    </a>
                                                </h3>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </article>




                            <article class="blog-summary-full-item">
                                <i class="icon icon-arrow-right-grey"></i>
                                <div class="row">
                                    <div class="col-xxs-12 col-md-12">
                                        <div class="blog-about pull-left">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/43991/co-sa-to-prave-udialo-v-polsku">Čo sa to pr&aacute;ve udialo v Poľsku?</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/julius-eckhardt" class="avatar avatar-little">
                                                        <img src="/uploads/6495/conversions/square.jpg" alt="J&uacute;lius Eckhardt">

                                                        <span class="author-name">J&uacute;lius Eckhardt</span>
                                                    </a>
                                                </h3>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </article>




                            <article class="blog-summary-full-item">
                                <i class="icon icon-arrow-right-grey"></i>
                                <div class="row">
                                    <div class="col-xxs-12 col-md-12">
                                        <div class="blog-about pull-left">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/43954/koho-volili-volici-kdh-po-okresoch">Koho si vybrali voliči KDH v jednotliv&yacute;ch okresoch?</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/jozef-simko" class="avatar avatar-little">
                                                        <img src="/uploads/11375/conversions/square.jpg" alt="Jozef &Scaron;imko">

                                                        <span class="author-name">Jozef &Scaron;imko</span>
                                                    </a>
                                                </h3>
                                            </footer>
                                        </div>
                                    </div>
                                </div>
                            </article>

                            <div class="row">
                                <div class="col-xxs-12 col-md-6 blog-summary-articles-list hidden-kd-mobile">




                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/pavol-prikryl ">
                                                            Pavol Prikryl
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44036/blaznive-a-pohorsujuce">Bl&aacute;zniv&eacute; a pohor&scaron;uj&uacute;ce</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/miroslav-klobucnik ">
                                                            Miroslav Klobučn&iacute;k
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44014/co-riesite-fico-skoncil">Čo rie&scaron;ite?, Fico skončil</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/pavol-martinicky-1 ">
                                                            Pavol Martinick&yacute;
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44048/poucenie-z-krizoveho-vyvoja-krestanskej-politiky">Poučenie z kr&iacute;zov&eacute;ho v&yacute;voja kresťanskej politiky</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>



                                </div>
                                <div class="col-xxs-12 col-md-6 blog-summary-articles-list border-left hidden-kd-mobile">



                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/miroslav-klobucnik ">
                                                            Miroslav Klobučn&iacute;k
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43965/trump-musi-padnut">Trump mus&iacute; padn&uacute;ť,</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/miroslav-klobucnik ">
                                                            Miroslav Klobučn&iacute;k
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44079/kto-bude-stat-po-boku-prezidentky">Kto bude st&aacute;ť po boku prezidentky?</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>






                                    <article class="blog-summary-half-item">
                                        <div class="row">
                                            <div class="col-xxs-12">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                <header>

                                                    <h3 class="author-link">
                                                        <a href="https://www.postoj.sk/autor/viliam-oberhauser ">
                                                            Viliam Oberhauser
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/44063/co-hovoria-krestanom-vysledky-volieb-do-ep">Čo hovoria kresťanom v&yacute;sledky volieb do EP</a></h3>
                                                        </div>
                                                    </div>

                                                </header>
                                            </div>
                                        </div>
                                    </article>




                                </div>

                            </div>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>
</section>

<section class="category-articles-section">
    <div class="container">
        <div class="row equalize" data-equalize-selector=".eq-me" data-equalize-all="true">
            <div class="col-xxs-12 col-md-9-minus-compensation hidden-kd-mobile eq-me">
                <div id="our-books">
                    <section class="category-articles double-border-bottom" >
                        <header class="triangle">
                            <h2 class="section-title">
                                <a href="https://obchod.postoj.sk" class="track-me-pls" data-category="shop_banner_bottom-title" data-action="click">Naše knihy</a>
                            </h2>
                        </header>

                        <div class="row">
                            <div class="col-md-8 left-col mobile-img-col hidden-kd-mobile">
                                <article class="category-article-item category-article-item-big  border-right  book-item book-item book-item">
                                    <div class="row category-article-item-big-row">

                                        <div class="category-article-item-big-left mobile-img-col">
                                            <a href="https://obchod.postoj.sk/balik/bud-kde-si-do-boja-s-ruzencom"  class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="1" >
                                                <img src="/uploads/16690/conversions/detail.png" alt="Buď, kde si + Do boja s ružencom">
                                            </a>
                                        </div>

                                        <div class="category-article-item-big-right mobile-text-col">
                                            <a href="https://obchod.postoj.sk/balik/bud-kde-si-do-boja-s-ruzencom" class="book-author  track-me-pls "  data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="1" >Buď, kde si + Do boja s ružencom</a>
                                            <p class="book-perex">V&yacute;hodn&yacute; bal&iacute;k na&scaron;ich kn&iacute;h</p>

                                            <p class="book-our-price">Cena u nás:  11,84 €</p>
                                            <p class="book-save-percent">Ušetríte: 20 %</p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <div class="col-md-4 right-col mobile-text-col hidden-kd-mobile">
                                <article class="category-article-item book-item  border-bottom ">
                                    <div class="row">
                                        <div class="col-xxs-5 left-col mobile-img-col">
                                            <a href="https://obchod.postoj.sk/produkt/klub-nerozbitnych-deti/27"   class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="2" >
                                                <div class="image-wrap">
                                                    <img src="/uploads/13296/conversions/variation_thumb.png" alt="Klub nerozbitn&yacute;ch det&iacute;">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxs-7 right-col mobile-text-col">
                                            <a href="https://obchod.postoj.sk/produkt/klub-nerozbitnych-deti/27" class="book-author  track-me-pls "   data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="2" >Klub nerozbitn&yacute;ch det&iacute;</a>
                                            <p class="book-perex">Sedem vec&iacute;, ktor&eacute; pom&ocirc;žu va&scaron;im deťom prežiť v modernej dobe</p>

                                            <p class="book-our-price">Cena u nás:  11,73 €</p>
                                            <p class="book-save-percent">Ušetríte: 15 %</p>
                                        </div>
                                    </div>
                                </article>



                                <article class="category-article-item book-item ">
                                    <div class="row">
                                        <div class="col-xxs-5 left-col mobile-img-col">
                                            <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50"   class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="3" >
                                                <div class="image-wrap">
                                                    <img src="/uploads/16520/conversions/variation_thumb.png" alt="Cesta na Z&aacute;pad">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxs-7 right-col mobile-text-col">
                                            <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50" class="book-author  track-me-pls "   data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="3" >Cesta na Z&aacute;pad</a>
                                            <p class="book-perex">Po stop&aacute;ch ochočen&eacute;ho Boha</p>

                                            <p class="book-our-price">Cena u nás:  9,90 €</p>
                                        </div>
                                    </div>
                                </article>



                            </div>

                            <div class="col-xxs-12 left-col mobile-img-col show-kd-mobile">
                                <article class="category-article-item book-item  border-bottom ">
                                    <div class="row">
                                        <div class="col-xxs-5 left-col mobile-img-col">
                                            <a href="https://obchod.postoj.sk/balik/bud-kde-si-do-boja-s-ruzencom"   class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="1" >
                                                <div class="image-wrap">
                                                    <img src="/uploads/16692/conversions/product_thumb.png" alt="Buď, kde si + Do boja s ružencom">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxs-7 right-col mobile-text-col">
                                            <a href="https://obchod.postoj.sk/balik/bud-kde-si-do-boja-s-ruzencom" class="book-author  track-me-pls "   data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="1" >Buď, kde si + Do boja s ružencom</a>
                                            <p class="book-perex">V&yacute;hodn&yacute; bal&iacute;k na&scaron;ich kn&iacute;h</p>

                                            <p class="book-our-price">Cena u nás:  11,84 €</p>
                                            <p class="book-save-percent">Ušetríte: 20 %</p>
                                        </div>
                                    </div>
                                </article>



                                <article class="category-article-item book-item  border-bottom ">
                                    <div class="row">
                                        <div class="col-xxs-5 left-col mobile-img-col">
                                            <a href="https://obchod.postoj.sk/produkt/klub-nerozbitnych-deti/27"   class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="2" >
                                                <div class="image-wrap">
                                                    <img src="/uploads/13296/conversions/variation_thumb.png" alt="Klub nerozbitn&yacute;ch det&iacute;">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxs-7 right-col mobile-text-col">
                                            <a href="https://obchod.postoj.sk/produkt/klub-nerozbitnych-deti/27" class="book-author  track-me-pls "   data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="2" >Klub nerozbitn&yacute;ch det&iacute;</a>
                                            <p class="book-perex">Sedem vec&iacute;, ktor&eacute; pom&ocirc;žu va&scaron;im deťom prežiť v modernej dobe</p>

                                            <p class="book-our-price">Cena u nás:  11,73 €</p>
                                            <p class="book-save-percent">Ušetríte: 15 %</p>
                                        </div>
                                    </div>
                                </article>



                                <article class="category-article-item book-item ">
                                    <div class="row">
                                        <div class="col-xxs-5 left-col mobile-img-col">
                                            <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50"   class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="3" >
                                                <div class="image-wrap">
                                                    <img src="/uploads/16520/conversions/variation_thumb.png" alt="Cesta na Z&aacute;pad">
                                                </div>
                                            </a>
                                        </div>

                                        <div class="col-xxs-7 right-col mobile-text-col">
                                            <a href="https://obchod.postoj.sk/produkt/cesta-na-zapad/50" class="book-author  track-me-pls "   data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="3" >Cesta na Z&aacute;pad</a>
                                            <p class="book-perex">Po stop&aacute;ch ochočen&eacute;ho Boha</p>

                                            <p class="book-our-price">Cena u nás:  9,90 €</p>
                                        </div>
                                    </div>
                                </article>



                            </div>
                        </div>

                    </section>
                </div>

                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/komentare-nazory" class="track-me-pls" data-category="home_spodne-clanky-kategoria" data-action="click">Koment&aacute;re a n&aacute;zory</a>
                        </h2>
                    </header>
                    <div class="row">
                        <div class="col-xxs-12 col-md-6 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big border-right">
                                <a href="https://www.postoj.sk/44155/nechat-deti-pobit-sa"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="/uploads/20117/conversions/square.jpg"  alt="Nechať deti pobiť sa?">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/44155/nechat-deti-pobit-sa"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Nechať deti pobiť sa?</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Kedy m&aacute; rodič zasahovať do s&uacute;rodeneck&yacute;ch &scaron;arv&aacute;tok a ako? Robiť sudcu, medi&aacute;tora alebo si to nev&scaron;&iacute;mať?</p>
                                    <p class="show-kd-mobile">
                                        Kedy m&aacute; rodič zasahovať do s&uacute;rodeneck&yacute;ch &scaron;arv&aacute;tok a ako? Robiť sudcu, medi&aacute;tora alebo si to nev&scaron;&iacute;mať?

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/maria-melicherova" class="author-link">M&aacute;ria Melicherov&aacute;</a>
                                    <small>• 05. 06. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/20022/conversions/square.jpg"  alt="Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44074/ako-sa-prekresli-politicka-mapa-ak-fico-pojde-do-utlmu"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Ako sa prekresl&iacute; politick&aacute; mapa, ak Fico p&ocirc;jde do &uacute;tlmu</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/fero-mucka" class="author-link">Fero M&uacute;čka</a>
                                            <small>• 03. 06. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43986/progresivizmus-a-zapad"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19933/conversions/square.jpg"  alt="Progresivizmus a Z&aacute;pad">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43986/progresivizmus-a-zapad"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Progresivizmus a Z&aacute;pad</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/bo-winegard" class="author-link">Bo Winegard</a>
                                            <small>• 30. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43966/revolticka"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19909/conversions/square.jpg"  alt="Revoltička">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43966/revolticka"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Revoltička</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/fero-mucka" class="author-link">Fero M&uacute;čka</a>
                                            <small>• 30. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/politika" class="track-me-pls" data-category="home_spodne-clanky-kategoria" data-action="click">Politika</a>
                        </h2>
                    </header>
                    <div class="row">
                        <div class="col-xxs-12 col-md-6 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big border-right">
                                <a href="https://www.postoj.sk/44179/nase-pozvanie-plati-nech-pridu-domov"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="/uploads/20131/conversions/square.jpg"  alt="Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/44179/nase-pozvanie-plati-nech-pridu-domov"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Na&scaron;e pozvanie plat&iacute;, nech pr&iacute;du domov</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Dnes by som to už takto nerie&scaron;il, hovor&iacute; predseda KDH Alojz Hlina o blogu, ktor&yacute; nap&iacute;sal po voľb&aacute;ch na adresu Franti&scaron;ka Miklo&scaron;ka.</p>
                                    <p class="show-kd-mobile">
                                        Dnes by som to už takto nerie&scaron;il, hovor&iacute; predseda KDH Alojz Hlina o blogu, ktor&yacute; nap&iacute;sal po voľb&aacute;ch na adresu Franti&scaron;ka Miklo&scaron;ka.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/fero-mucka" class="author-link">Fero M&uacute;čka</a>
                                    <small>• 05. 06. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/20077/conversions/square.jpg"  alt="Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44124/zajtra-sa-fico-vrati-a-bude-po-kosickej-vzbure"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Zajtra sa Fico vr&aacute;ti a bude po ko&scaron;ickej vzbure</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/martin-hanus" class="author-link">Martin Hanus</a>
                                            <small>• 05. 06. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44131/medzi-zapadom-a-vychodom-stale-koliseme-a-nie-sme-v-tom-sami"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/20084/conversions/square.jpg"  alt="Medzi Z&aacute;padom a V&yacute;chodom st&aacute;le kol&iacute;&scaron;eme a nie sme v tom sami">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44131/medzi-zapadom-a-vychodom-stale-koliseme-a-nie-sme-v-tom-sami"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Medzi Z&aacute;padom a V&yacute;chodom st&aacute;le kol&iacute;&scaron;eme a nie sme v tom sami</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="author-link">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a>
                                            <small>• 04. 06. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44116/kdh-napadlo-na-ustavnom-sude-rozdelenie-mandatov-z-eurovolieb"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/20068/conversions/square.jpg"  alt="KDH napadlo na &Uacute;stavnom s&uacute;de rozdelenie mand&aacute;tov z eurovolieb">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44116/kdh-napadlo-na-ustavnom-sude-rozdelenie-mandatov-z-eurovolieb"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >KDH napadlo na &Uacute;stavnom s&uacute;de rozdelenie mand&aacute;tov z eurovolieb</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/jozef-majchrak" class="author-link">Jozef Majchr&aacute;k</a>
                                            <small>• 04. 06. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/kultura" class="track-me-pls" data-category="home_spodne-clanky-kategoria" data-action="click">Kult&uacute;ra</a>
                        </h2>
                    </header>
                    <div class="row">
                        <div class="col-xxs-12 col-md-6 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big border-right">
                                <a href="https://www.postoj.sk/44053/dieta-rudolf-dobias"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="/uploads/20003/conversions/square.jpg"  alt="Dieťa (Rudolf Dobi&aacute;&scaron;)">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/44053/dieta-rudolf-dobias"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Dieťa (Rudolf Dobi&aacute;&scaron;)</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">B&aacute;seň ku Dňu det&iacute;.</p>
                                    <p class="show-kd-mobile">
                                        B&aacute;seň ku Dňu det&iacute;.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/michal-chuda" class="author-link">Michal Chuda</a>
                                    <small>• 02. 06. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44006/knihomolov-zapisnik-kosican-marai-odhaluje-traumy-madarov"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19955/conversions/square.jpg"  alt="Knihomoľov z&aacute;pisn&iacute;k: Horthy v Ko&scaron;iciach a smutn&yacute; S&aacute;ndor M&aacute;rai">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44006/knihomolov-zapisnik-kosican-marai-odhaluje-traumy-madarov"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Knihomoľov z&aacute;pisn&iacute;k: Horthy v Ko&scaron;iciach a smutn&yacute; S&aacute;ndor M&aacute;rai</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="author-link">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a>
                                            <small>• 01. 06. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44000/ked-jedina-gitara-nahradi-cely-orchester"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19950/conversions/square.jpg"  alt="Keď jedin&aacute; gitara nahrad&iacute; cel&yacute; orchester">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44000/ked-jedina-gitara-nahradi-cely-orchester"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Keď jedin&aacute; gitara nahrad&iacute; cel&yacute; orchester</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/jan-vinter" class="author-link">Jana Vinterov&aacute;</a>
                                            <small>• 31. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43828/dialog-s-bohom-jan-motulko"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19775/conversions/square.jpg"  alt="Dial&oacute;g s Bohom (J&aacute;n Motulko)">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43828/dialog-s-bohom-jan-motulko"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Dial&oacute;g s Bohom (J&aacute;n Motulko)</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/michal-chuda" class="author-link">Michal Chuda</a>
                                            <small>• 26. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/spolocnost" class="track-me-pls" data-category="home_spodne-clanky-kategoria" data-action="click">Spoločnosť</a>
                        </h2>
                    </header>
                    <div class="row">
                        <div class="col-xxs-12 col-md-6 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big border-right">
                                <a href="https://www.postoj.sk/44093/netflix-a-disney-planuju-pre-pro-life-zakon-stiahnut-zo-statu-georgia-investicie"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="/uploads/20047/conversions/square.jpg"  alt="Netflix a Disney pl&aacute;nuj&uacute; pre pro-life z&aacute;kon stiahnuť zo &scaron;t&aacute;tu Georgia invest&iacute;cie">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/44093/netflix-a-disney-planuju-pre-pro-life-zakon-stiahnut-zo-statu-georgia-investicie"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Netflix a Disney pl&aacute;nuj&uacute; pre pro-life z&aacute;kon stiahnuť zo &scaron;t&aacute;tu Georgia invest&iacute;cie</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">V Georgii sa už nakr&uacute;ca viac ako v Kalifornii. Veľk&eacute; filmov&eacute; spoločnosti sa v&scaron;ak pre pro-life legislat&iacute;vu vyhr&aacute;žaj&uacute; odchodom.</p>
                                    <p class="show-kd-mobile">
                                        V Georgii sa už nakr&uacute;ca viac ako v Kalifornii. Veľk&eacute; filmov&eacute; spoločnosti sa v&scaron;ak pre pro-life legislat&iacute;vu vyhr&aacute;žaj&uacute; odchodom.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/lukas-obsitnik" class="author-link">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</a>
                                    <small>• 03. 06. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/44011/mam-pocit-ze-zacinam-odznova"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19960/conversions/square.jpg"  alt="M&aacute;m pocit, že zač&iacute;nam odznova">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/44011/mam-pocit-ze-zacinam-odznova"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >M&aacute;m pocit, že zač&iacute;nam odznova</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/jaroslav-daniska" class="author-link">Jaroslav Dani&scaron;ka</a>
                                            <small>• 02. 06. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43975/den-ked-britania-mohla-prehrat-vojnu"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19921/conversions/square.jpg"  alt="Deň, keď Brit&aacute;nia mohla prehrať vojnu">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43975/den-ked-britania-mohla-prehrat-vojnu"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Deň, keď Brit&aacute;nia mohla prehrať vojnu</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/andrej-ziarovsky" class="author-link">Andrej Žiarovsk&yacute;</a>
                                            <small>• 31. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43942/uber-neurcuje-a-ani-nemoze-urcit-cenu-jazdneho"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19886/conversions/square.jpg"  alt="Uber neurčuje a ani nem&ocirc;že určiť cenu jazdn&eacute;ho">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43942/uber-neurcuje-a-ani-nemoze-urcit-cenu-jazdneho"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Uber neurčuje a ani nem&ocirc;že určiť cenu jazdn&eacute;ho</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/robert-chovanculiak" class="author-link">R&oacute;bert Chovanculiak</a>
                                            <small>• 30. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/rodina" class="track-me-pls" data-category="home_spodne-clanky-kategoria" data-action="click">Rodina</a>
                        </h2>
                    </header>
                    <div class="row">
                        <div class="col-xxs-12 col-md-6 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big border-right">
                                <a href="https://www.postoj.sk/43912/komu-drzat-stranu-ked-si-stat-pyta-paetrocne-deti-videodebata"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="/uploads/19856/conversions/square.jpg"  alt="Komu držať stranu, keď si &scaron;t&aacute;t p&yacute;ta p&auml;ťročn&eacute; deti? (Videodebata)">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/43912/komu-drzat-stranu-ked-si-stat-pyta-paetrocne-deti-videodebata"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Komu držať stranu, keď si &scaron;t&aacute;t p&yacute;ta p&auml;ťročn&eacute; deti? (Videodebata)</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Krist&iacute;na Visolajsk&aacute; a Marta Glossov&aacute; polemizuj&uacute; o chystanej zmene v z&aacute;kone, ktor&aacute; m&aacute; spr&iacute;sniť pravidl&aacute; pre deti, ktor&eacute; nechodia do &scaron;k&ocirc;lky.</p>
                                    <p class="show-kd-mobile">
                                        Krist&iacute;na Visolajsk&aacute; a Marta Glossov&aacute; polemizuj&uacute; o chystanej zmene v z&aacute;kone, ktor&aacute; m&aacute; spr&iacute;sniť pravidl&aacute; pre deti, ktor&eacute; nechodia do &scaron;k&ocirc;lky.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/fero-mucka" class="author-link">Fero M&uacute;čka</a>
                                    <small>• 28. 05. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43903/ako-zistit-ci-dieta-patri-do-skoly"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19854/conversions/square.jpg"  alt="Ako zistiť, či už dieťa patr&iacute; do &scaron;koly?">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43903/ako-zistit-ci-dieta-patri-do-skoly"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Ako zistiť, či už dieťa patr&iacute; do &scaron;koly?</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/maria-melicherova" class="author-link">M&aacute;ria Melicherov&aacute;</a>
                                            <small>• 28. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43383/smer-to-skusa-na-mladych-chce-vyraznejsie-zvysit-rodicovsky-prispevok"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/19301/conversions/square.jpg"  alt="Smer to sk&uacute;&scaron;a na mlad&yacute;ch, chce v&yacute;raznej&scaron;ie zv&yacute;&scaron;iť rodičovsk&yacute; pr&iacute;spevok">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43383/smer-to-skusa-na-mladych-chce-vyraznejsie-zvysit-rodicovsky-prispevok"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Smer to sk&uacute;&scaron;a na mlad&yacute;ch, chce v&yacute;raznej&scaron;ie zv&yacute;&scaron;iť rodičovsk&yacute; pr&iacute;spevok</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/pavol-rabara" class="author-link">Pavol R&aacute;bara</a>
                                            <small>• 14. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42716/ma-sibacka-a-oblievacka-buducnost"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="/uploads/18574/conversions/square.jpg"  alt="M&aacute; &scaron;ibačka a oblievačka bud&uacute;cnosť? ">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42716/ma-sibacka-a-oblievacka-buducnost"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >M&aacute; &scaron;ibačka a oblievačka bud&uacute;cnosť? </a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/zuzana-hanusova" class="author-link">Zuzana Hanusov&aacute;</a>
                                            <small>• 22. 04. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-xxs-12 col-md-3-plus-compensation eq-me">
                <section class="press-releases">
                    <header class="clearfix">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/tlacove-spravy">Tlačov&eacute; spr&aacute;vy</a>
                        </h2>
                    </header>
                    <div class="press-releases-items">
                        <article class="press-releases-item">
                            <div class="row">
                                <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                    <a href="https://www.postoj.sk/44171/nedus-nasu-buducnost">
                                        <div class="image-wrap">
                                            <img  src="/uploads/20121/conversions/square.jpg"  alt="Nedus na&scaron;u bud&uacute;cnosť!">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxs-7 col-md-7 mobile-text-col">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/44171/nedus-nasu-buducnost">Nedus na&scaron;u bud&uacute;cnosť!</a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item">
                            <div class="row">
                                <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                    <a href="https://www.postoj.sk/44009/ukrajinski-chlapci-patria-do-rodiny-aku-ste-nezazili">
                                        <div class="image-wrap">
                                            <img  src="/uploads/19958/conversions/square.jpg"  alt="Ukrajinsk&iacute; chlapci patria do rodiny, ak&uacute; ste nezažili">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxs-7 col-md-7 mobile-text-col">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/44009/ukrajinski-chlapci-patria-do-rodiny-aku-ste-nezazili">Ukrajinsk&iacute; chlapci patria do rodiny, ak&uacute; ste nezažili</a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item">
                            <div class="row">
                                <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                    <a href="https://www.postoj.sk/43664/eurovolby-ako-chcete-motivovat-ludi-aby-prisli-volit-anketa">
                                        <div class="image-wrap">
                                            <img  src="/uploads/19590/conversions/square.jpg"  alt="Eurovoľby: Ako chcete motivovať ľud&iacute;, aby pri&scaron;li voliť? (anketa)">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxs-7 col-md-7 mobile-text-col">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/43664/eurovolby-ako-chcete-motivovat-ludi-aby-prisli-volit-anketa">Eurovoľby: Ako chcete motivovať ľud&iacute;, aby pri&scaron;li voliť? (anketa)</a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item-small hidden-kd-mobile">
                            <div class="row">
                                <div class="col-xxs-12">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/43481/papez-by-ma-vyhodil-keby-som-s-tymto-suhlasila">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                P&aacute;pež by ma vyhodil, keby som s&nbsp;t&yacute;mto s&uacute;hlasila
                                            </a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item-small hidden-kd-mobile">
                            <div class="row">
                                <div class="col-xxs-12">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/43398/eurovolby-ako-chcete-motivovat-ludi-aby-prisli-volit-anketa">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Eurovoľby: Ako chcete motivovať ľud&iacute;, aby pri&scaron;li voliť? (anketa)
                                            </a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item-small hidden-kd-mobile">
                            <div class="row">
                                <div class="col-xxs-12">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/43391/konzervativni-lidri-v-eurovolbach-podporili-miriam-lexmann">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Konzervat&iacute;vni l&iacute;dri v eurovoľb&aacute;ch podporili Miriam Lexmann
                                            </a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item-small hidden-kd-mobile">
                            <div class="row">
                                <div class="col-xxs-12">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/43194/eurovolby-co-caka-eu-v-najblizsich-rokoch-anketa">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Eurovoľby: Čo čak&aacute; E&Uacute; v najbliž&scaron;&iacute;ch rokoch? (anketa)
                                            </a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item-small hidden-kd-mobile">
                            <div class="row">
                                <div class="col-xxs-12">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/42956/eurovolby-co-caka-eu-v-najblizsich-rokoch-anketa">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Eurovoľby: Čo čak&aacute; E&Uacute; v najbliž&scaron;&iacute;ch rokoch? (anketa)
                                            </a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                    </div>

                    <p class="side-articles-note">Publikovanie alebo ďal&scaron;ie &scaron;&iacute;renie spr&aacute;v zo zdrojov TASR je bez predch&aacute;dzaj&uacute;ceho p&iacute;somn&eacute;ho s&uacute;hlasu TASR poru&scaron;en&iacute;m autorsk&eacute;ho z&aacute;kona.</p>
                </section>

            </div>
        </div>
    </div>
</section>

<div id="short-news-ad" class="short-news-ad">
    <section class="banner-wrap side-banner  hidden-kd-mobile ">
        <div class="banner">


            <!-- /66396820/KratkeSpravy-300-600-HOME -->
            <div id='div-gpt-ad-1446111677017-0'>
                <script type='text/javascript'>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1446111677017-0'); });
                </script>
            </div>

        </div>
    </section>
</div>

<div id="today-news" class="short-news-ad">
    <section class="banner-wrap side-banner  hidden-kd-mobile ">
        <div class="banner">


            <!-- /66396820/DnesTrebaVidiet-300-600 -->
            <div id='div-gpt-ad-1446111448787-0'>
                <script type='text/javascript'>
                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-1446111448787-0'); });
                </script>
            </div>

        </div>
    </section>
</div>


<div class="cookie-policy-message">
    <div class="container">
        <div class="row">
            <div class="col-xxs-12 col-xxs-offset-0 col-md-6 col-md-offset-1 text-left">
                <p>
                    Používaním webstránky denník Postoj súhlasíte s používaním cookies,
                    ktoré nám pomáhajú zabezpečiť lepšie služby.
                </p>
            </div>
            <div class="col-xxs-12 col-xxs-offset-0 col-md-3 col-md-offset-0 text-right">
                <a href="https://www.postoj.sk/zasady-pouzivania-suborov-cookies" class="more-info">Viac informácií </a>
                <a href="#" class="btn-blue-grad cookie-policy-ok">OK</a>
            </div>
        </div>

    </div>


</div><footer class="site-footer">
    <div class="container relative">
        <a href="#" class="scroll-up">
            <i class="icon-ft-up-strong"></i>
        </a>

        <div class="row">
            <div class="col-xxs-12 col-md-3">
                <a href="">
                    <img src="https://www.postoj.sk/assets/frontend/build/img/brand-footer.png" alt="Konzervat&iacute;vny denn&iacute;k">
                </a>

                <ul class="footer-link-list">
                    <li>
                        <a href="https://www.postoj.sk/25362/o-denniku">O denníku</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/redakcia">Redakcia</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/ochrana_sukromia.pdf" target="_blank">Ochrana súkromia</a>
                    </li>
                </ul>


            </div>

            <div class="col-xxs-12 col-md-2">
                <h3 class="footer-title">Aktuálne</h3>
                <ul class="footer-link-list">
                    <li>
                        <a href="https://www.postoj.sk/komentare-nazory">Komentáre a názory</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/spravodajstvo">Spravodajstvo</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/spolocnost">Spoločnosť</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/kultura">Kultúra</a>
                    </li>
                </ul>
            </div>
            <div class="col-xxs-12 col-md-2">
                <h3 class="footer-title">&nbsp;</h3>
                <ul class="footer-link-list">
                    <li>
                        <a href="https://svetkrestanstva.postoj.sk/svet-krestanstva">Svet kresťanstva</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/blog">Blog</a>
                    </li>
                    <li>
                        <a href="https://www.postoj.sk/25366/inzercia">Inzercia</a>
                    </li>
                    <li>
                        <a href="https://podpora.postoj.sk">Klub podporovateľov</a>
                    </li>
                    <!-- <li>
              <a href="https://www.postoj.sk/videa">Videá</a>
            </li> -->
                </ul>
            </div>
            <div class="col-xxs-12 col-md-5">
                <h3 class="footer-title">Kontakt</h3>
                <p class="address">
                    Konzervatívny denník Postoj, <br>
                    Pražská 11, 811 04 Bratislava <br>
                    <a href="mailto:redakcia@postoj.sk">redakcia@postoj.sk</a> <br>
                    Číslo účtu: IBAN: SK5211000000002943460300 <br>
                    <small>Do poznámky, prosím, uveďte vašu mailovú adresu.</small>
                </p>
            </div>
        </div>



        <div class="row footer-social-row">
            <div class="col-xxs-12 col-md-7">
                <section class="social-icons">
                    <a class="social-icon" href="https://www.facebook.com/Postoy.sk" target="_blank"><i class="icon icon-fb"></i></a>
                    <a href="https://www.facebook.com/Postoy.sk" target="_blank" class="txt">Spojte sa s nami na Facebooku</a>
                    <span class="divider"></span>
                    <a href="https://podpora.postoj.sk" target="_blank" class="txt track-me-pls" data-category="vsade_podpora-text-dole" data-action="click">Podporte nás a stante sa členom klubu Postoj </a>
                </section>
            </div>
            <div class="col-xxs-12 col-md-5">
                <a href="https://podpora.postoj.sk" target="_blank" class="btn-kd btn-kd-red track-me-pls" data-category="vsade_podpora-button-dole" data-action="click">Podporiť denník</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xxs-12">
                <p class="copyright text-right">COPYRIGHT Vydavateľstvo POSTOJ MEDIA, s.r.o., ISSN: 1336-720X</p>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="https://static.postoj.sk/frontend/build/main-5cdba7bf.js"></script>

<script>
    $(function() {
        App.baseUrl = "";
        App.init();
    })
</script>

<!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
    window.__insp = window.__insp || [];
    __insp.push(['wid', 1276184632]);
    (function() {
        function ldinsp(){if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
        setTimeout(ldinsp, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent('onload', ldinsp) : window.addEventListener('load', ldinsp, false)) : ldinsp();
    })();
</script>
<!-- End Inspectlet Embed Code -->

<script type="text/javascript">
    $(function(){

        if(window.location.hash) {
            var hash = window.location.hash.substring(1);
            if(hash == 'resetPassword' || hash == 'resetpassword'){
                $('#login-panel').find('a.reset-password-show').tab('show');
                $('#loginBlogModal').modal('show');
            }
            else if(hash == 'login'){
                $('#loginBlogModal').modal('show');
            }
        }

    })

</script>

<script type="text/javascript">
    $(function() {
        $('.google-search-button').click(function() {
            $(this).hide();
            $('#google-search').show(20, 'linear', function(){
                $('body').click(function(evt){
                    console.log(evt);
                    if(evt.target.id == "google-search")
                        return;
                    //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
                    if($(evt.target).closest('#google-search').length)
                        return;
                    $('#google-search').hide();
                    $('.google-search-button').show();
                    $( this ).unbind( evt );
                });
            });
        });
    });
</script>

<script>
    $(function(){
        if($('#fb-share-count').length > 0) {
            var url = window.location.href.replace(".dev/", ".sk/");
            url = url.replace("http://", "https://");
            url = url.replace(".develop.postoj", ".postoj");
            url = url.replace(".staging.postoj", ".postoj");
//            console.log("https://graph.facebook.com/"+url);
            $.ajax({
                method: "GET",
                dataType: "json",
                url: "https://graph.facebook.com/"+url,
            })
                .done(function(data) {
//                console.log(data);
                    if(typeof data.share != typeof undefined && data.share) {
                        if(typeof data.share.share_count != typeof undefined && data.share.share_count) {
//                        console.log(data.share.share_count);
                            $('#fb-share-count').html(data.share.share_count);
                        }
                    }
                });
        }
    });
</script>

<script>
    $(function() {
        var showChar = 200;
        var ellipsestext = "...";
        var moretext = "Čítaj viac";
        var lesstext = "Čítaj menej";
        $('.more-text').each(function() {
            var content = $(this).html();

            if(content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="more-ellipses">' + ellipsestext+ '&nbsp;</span><span class="more-content"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="more-link">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $('.more-link').click(function(){
            if($(this).hasClass("less")) {
                $(this).removeClass("less");
                $(this).html(moretext);
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().toggle();
            $(this).prev().toggle();
            return false;
        });

        $(function() {
            window.mobilecheck = function() {
                var check = false;
                (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
                return check;
            };
            if (mobilecheck()) {
                $('.short-news-item').on('hover', function() {
                    $(this).click();
                });
            }
        });
    })
</script>

<script>
    //    twttr.ready(
    //        function (twttr) {
    //            twttr.events.bind(
    //                    'loaded',
    //                    function (event) {
    //                        event.widgets.forEach(function (widget) {
    //                            console.log("Created widget", widget.id);
    //                            console.log(widget);
    //                        });
    //                    }
    //            );
    //            twttr.events.bind(
    //                    'rendered',
    //                    function (event) {
    //                        console.log("Rendered widget", event.target.id);
    //                    }
    //            );
    //        }
    //    );


</script>


<!-- CFT SCRIPT -->
<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
