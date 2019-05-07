
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

    <meta name="csrf-token" content="3suL0nedT0cCa23ID0dkbiyncVdoeDYik0xqXQjL"/>
    <meta name="google-site-verification" content="Bxa67H10I7IKDg_4wM5NjYqeuCDCFiZmqNrLqThmaY0" />

    <link rel="icon" type="image/png" href="/favicon.png">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,600,700,300,100&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,600,700,300,100&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css"/>


    <link rel="stylesheet" href="https://static.postoj.sk/frontend/build/style-055b96b2.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->




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
            <div class=" col-xxs-12 col-md-4 ">


                <h1>

                    <a href=" https://www.postoj.sk"  class="brand-header track-me-pls " data-category="vsade_logo" data-action="click">
                        <img src="https://www.postoj.sk/assets/frontend/build/img/brand-main.png" class="hidden-kd-mobile" alt="Konzervat&iacute;vny denn&iacute;k">
                        <img src="https://www.postoj.sk/assets/frontend/build/img/brand-responsive.png" class="show-kd-mobile" alt="Konzervat&iacute;vny denn&iacute;k">
                    </a>

                </h1>
            </div>


            <div class="col-xxs-12 col-md-6">
                <div class="pull-right support-head">
                    <h3 class="pull-right"><a href="https://podpora.postoj.sk" class="btn btn-kd-red track-me-pls" data-category="vsade_podpora-vpravo-hore" data-action="click">Podporiť denník</a></h3>

                    <div id="header-carousel" class="carousel slide pull-right " data-keyboard="false" data-interval="false">
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <h3>Bez v&aacute;s by sme tu neboli.</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxs-12 col-md-1">
                <input type="image" src="https://www.google.com/uds/css/v2/search_box_icon.png" class="google-search-button" title="hľadať">
            </div>
            <div class="col-xxs-12 col-md-1">
                <div id="cft--login"></div>
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

                        <form method="POST" action="https://blog.postoj.sk/prihlasit" accept-charset="UTF-8" class="kd-form" novalidate="novalidate"><input name="_token" type="hidden" value="3suL0nedT0cCa23ID0dkbiyncVdoeDYik0xqXQjL">

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
                        <form method="POST" action="https://www.postoj.sk/reset" accept-charset="UTF-8" class="kd-form" novalidate="novalidate"><input name="_token" type="hidden" value="3suL0nedT0cCa23ID0dkbiyncVdoeDYik0xqXQjL">
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
                <section class="coment-of-the-day-section double-border-bottom eq-me">
                    <article class="coment-of-the-day">
                        <a href="https://www.postoj.sk/43131/europa-sa-potichu-pripravuje-na-to-ze-taliansko-buchne" class="track-me-pls" data-category="home_hlavny-clanok" data-action="click" data-label="Eur&oacute;pa sa potichu pripravuje na to, že Taliansko buchne-(43131)">
                            <div class="image-wrap">
                                <img  src="https://www.postoj.sk/uploads/19032/conversions/homepage.jpg"  alt="Eur&oacute;pa sa potichu pripravuje na to, že Taliansko buchne">
                            </div>
                        </a>
                        <div class="row">

                            <div class="col-md-9">
                                <header>
                                    <h2 class="article-title">
                                        <a href="https://www.postoj.sk/43131/europa-sa-potichu-pripravuje-na-to-ze-taliansko-buchne" class="track-me-pls" data-category="home_hlavny-clanok" data-action="click" data-label="Eur&oacute;pa sa potichu pripravuje na to, že Taliansko buchne-(43131)">Eur&oacute;pa sa potichu pripravuje na to, že Taliansko buchne</a>
                                    </h2>
                                </header>
                                <div class="perex">
                                    <p class="hidden-kd-mobile">Ak&yacute; bude scen&aacute;r, keď sa nahlas povie, že Taliansko so svoj&iacute;m dlhom už nem&ocirc;že ďalej fungovať.</p>
                                    <p class="show-kd-mobile">
                                        Ak&yacute; bude scen&aacute;r, keď sa nahlas povie, že Taliansko so svoj&iacute;m dlhom už nem&ocirc;že ďalej fungovať.                            </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/komentare-nazory" class="category-title">Koment&aacute;re a n&aacute;zory</a>
                                    <div class="show-kd-mobile-inline-block">
                                        <a href="https://www.postoj.sk/autor/fero-mucka" class="">
                                            <span class="author-name">Fero M&uacute;čka</span>
                                        </a>
                                    </div>
                                </footer>
                            </div>
                            <div class="col-md-3 text-center hidden-kd-mobile">
                                <a href="https://www.postoj.sk/autor/fero-mucka" class="avatar">
                                    <img src="https://www.postoj.sk/uploads/1388/conversions/square.jpg" alt="Fero M&uacute;čka">                <span class="author-name">Fero M&uacute;čka</span>
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
                                    <img src="https://www.postoj.sk/uploads/19037/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>
                                <span class="category-title hidden-kd-mobile">Ekonomika:</span>
                                <h3 class="article-title">
                                    <a href="https://www.postoj.sk/43137/rakusky-kancelar-kurz-chce-vsetkymi-prostriedkami-zabranit-dostavbe-mochoviec" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/43137/rakusky-kancelar-kurz-chce-vsetkymi-prostriedkami-zabranit-dostavbe-mochoviec" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="1">Rak&uacute;sky kancel&aacute;r Kurz chce v&scaron;etk&yacute;mi prostriedkami zabr&aacute;niť dostavbe Mochoviec</a>
                                </h3>
                            </div>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 19 min</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">„Telefonoval som so slovenským premiérom Petrom Pellegrinim, aby som ho odhovoril od dostavby jadrovej elektrárne. Jasne som tlmočil bezpečnostné obavy Rakúska a požadoval som čo najväčšiu transparentnosť,“ povedal Kurz.</span>
                                    <span class="show-kd-mobile">
				      				        „Telefonoval som so slovenským premiérom Petrom Pellegrinim, aby som ho odhovoril od dostavby jadrovej elektrárne. Jasne som tlmočil bezpečnostné obavy Rakúska a požadoval som čo najväčšiu transparentnosť,“ povedal Kurz.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/19037/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/43137/rakusky-kancelar-kurz-chce-vsetkymi-prostriedkami-zabranit-dostavbe-mochoviec">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Dom&aacute;ce:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/43135/koalicni-lidri-rokuju-o-socialnych-opatreniach-a-volbe-kandidatov-na-us" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/43135/koalicni-lidri-rokuju-o-socialnych-opatreniach-a-volbe-kandidatov-na-us" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="2">Koaličn&iacute; l&iacute;dri rokuj&uacute; o soci&aacute;lnych opatreniach a voľbe kandid&aacute;tov na &Uacute;S</a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 25 min</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Viacerí predstavitelia koalície už spomínali, že by mohli zvoliť desiatku mien kandidátov na ústavných sudcov, ktoré do výberu chýbajú.</span>
                                    <span class="show-kd-mobile">
				      				        Viacerí predstavitelia koalície už spomínali, že by mohli zvoliť desiatku mien kandidátov na ústavných sudcov, ktoré do výberu chýbajú.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/19036/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/43135/koalicni-lidri-rokuju-o-socialnych-opatreniach-a-volbe-kandidatov-na-us">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Dom&aacute;ce:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/43127/absolutnou-slovenkou-roka-2019-sa-stala-andrea-gontkovicova" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/43127/absolutnou-slovenkou-roka-2019-sa-stala-andrea-gontkovicova" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="3">Absol&uacute;tnou Slovenkou roka 2019 sa stala Andrea Gontkovičov&aacute;</a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 3 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Andrea Gontkovičová je členkou manažmentu a riaditeľkou pre inovácie a rozvoj v spoločnosti Philip Morris. Zároveň jej patrí aj prvenstvo v kategórii biznis a manažment.</span>
                                    <span class="show-kd-mobile">
				      				        Andrea Gontkovičová je členkou manažmentu a riaditeľkou pre inovácie a rozvoj v spoločnosti Philip Morris. Zároveň jej patrí aj prvenstvo v kategórii biznis a manažment.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/19028/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/43127/absolutnou-slovenkou-roka-2019-sa-stala-andrea-gontkovicova">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Zahraničn&eacute;:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/43134/mesto-negombo-na-sri-lanke-bolo-dejiskom-etnickych-nepokojov" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/43134/mesto-negombo-na-sri-lanke-bolo-dejiskom-etnickych-nepokojov" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="4">Mesto Negombo na Sr&iacute; Lanke bolo dejiskom etnick&yacute;ch nepokojov</a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 34 min</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Od atentátov na Srí Lanke platí výnimočný stav a varovanie pred ďalšími podobnými útokmi.</span>
                                    <span class="show-kd-mobile">
				      				        Od atentátov na Srí Lanke platí výnimočný stav a varovanie pred ďalšími podobnými útokmi.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/19035/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/43134/mesto-negombo-na-sri-lanke-bolo-dejiskom-etnickych-nepokojov">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">Zahraničn&eacute;:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/43133/eu-by-podla-orbana-mala-prevziat-rakusky-model-stredopravej-spoluprace" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/43133/eu-by-podla-orbana-mala-prevziat-rakusky-model-stredopravej-spoluprace" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="5">E&Uacute; by podľa Orb&aacute;na mala prevziať rak&uacute;sky model stredopravej spolupr&aacute;ce</a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 40 min</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">„Kresťanskí demokrati v Európe, a to najmä v Nemecku, sa posúvajú doľava. Uzatvárajú koalície so socialistami a preto musia prijímať kompromisy, čím strácajú svoju identitu a svoje hodnoty,“ povedal Orbán pre rakúske noviny Kleine Zeitung.</span>
                                    <span class="show-kd-mobile">
				      				        „Kresťanskí demokrati v Európe, a to najmä v Nemecku, sa posúvajú doľava. Uzatvárajú koalície so socialistami a preto musia prijímať kompromisy, čím strácajú svoju identitu a svoje hodnoty,“ povedal Orbán pre rakúske noviny Kleine Zeitung.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/19034/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/43133/eu-by-podla-orbana-mala-prevziat-rakusky-model-stredopravej-spoluprace">Čítať článok</a>
                            </div>
                        </div>


                        <article class="today-must-see-article">
                            <span class="category-title hidden-kd-mobile">&Scaron;port:</span>
                            <h3 class="article-title">
                                <a href="https://www.postoj.sk/43129/arc-bratislava-s-konopkom-ide-druhykrat-na-24-hodin-le-mans" class="track-me-pls tip-me show-ad" data-href="https://www.postoj.sk/43129/arc-bratislava-s-konopkom-ide-druhykrat-na-24-hodin-le-mans" data-category="home_dnes-treba-vediet-clanok" data-action="click" data-label="position" data-value="6">ARC Bratislava s Kon&ocirc;pkom ide druh&yacute;kr&aacute;t na 24 hod&iacute;n Le Mans</a>
                            </h3>
                        </article>

                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">

                                <header class="clearfix">
                                    <div class="header-text" style=" margin-left:0px; ">
                                        <div class="author-name">TASR</div><small style="margin-left: 5px;">• pred 2 hod</small>
                                    </div>
                                </header>

                                <div class="article-text">
                                    <span class="hidden-kd-mobile">Po druhý raz v histórii bude na motoristických pretekoch 24 hodín Le Mans štartovať slovenský tím.</span>
                                    <span class="show-kd-mobile">
				      				        Po druhý raz v histórii bude na motoristických pretekoch 24 hodín Le Mans štartovať slovenský tím.
				      				    </span>
                                </div>


                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/19030/conversions/cover.jpg" style="width:100%;height:auto;">
                                </div>

                                <a class="btn btn-blue-grad" href="https://www.postoj.sk/43129/arc-bratislava-s-konopkom-ide-druhykrat-na-24-hodin-le-mans">Čítať článok</a>
                            </div>
                        </div>


                    </div>
                </section>
            </div>
            <div class="col-xxs-12 show-kd-mobile hidden">
                <section class="short-news side-short-news">
                    <header class="clearfix">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/kratke-spravy-redakcie" class="track-me-pls" data-category="home_kratke-spravy-nadpis" data-action="click">Krátke správy z redakcie</a>
                        </h2>
                    </header>
                    <div class="short-news-items">
                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="1"  data-href="https://www.postoj.sk/shortnews/2482" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2482">
                            <div class="image-wrap">
                                <img src="https://www.postoj.sk/uploads/18983/conversions/cover.jpg">
                            </div>
                            <header>
                                <h3 class="author-link"><a href="https://www.postoj.sk/autor/jan-duda-1" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">J&aacute;n Duda</a></h3>
                                <small>• pred 1 d</small>
                            </header>
                            <div class="perex">
                                <p>Evanjelium tretej veľkonočnej nedele (5. 5. 2019) je dosť dlh&eacute; (Jn 21,1-19). K nemu len tri kr&aacute;tke pozn&aacute;mky.</p>    <p>(1) Vyznanie...
                            </div>


                        </article>
                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                <header class="clearfix">
                                    <div class="image-wrap show">
                                        <img src="https://www.postoj.sk/uploads/1885/conversions/profile.jpg" alt="J&aacute;n Duda">
                                    </div>
                                    <div class="header-text" style="">
                                        <div class="author-name">J&aacute;n Duda</div><small style="margin-left: 5px;">• pred 1 d</small>
                                    </div>
                                </header>

                                <div class="article-social-buttons">
                                    <div class="social-btn">
                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2482" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                        </div>
                                    </div>
                                    <div class="social-btn">
                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2482"  data-text="Potrebujeme pr&iacute;tomnosť P&aacute;na"  class="twitter-share-button">Tweet</a>
                                    </div>
                                </div>

                                <div class="article-text">
                                    <p>Evanjelium tretej veľkonočnej nedele (5. 5. 2019) je dosť dlh&eacute; (Jn 21,1-19). K nemu len tri kr&aacute;tke pozn&aacute;mky.</p>    <p>(1) Vyznanie viery. Tentoraz ho vyslovil apo&scaron;tol J&aacute;n po tom, ako ulovili veľk&eacute; množstvo r&yacute;b: &bdquo;P&aacute;n je to.&ldquo; Je tu siln&aacute; životn&aacute; sk&uacute;senosť: ulovili 153 r&yacute;b, J&aacute;n si dokonca zapam&auml;tal aj ich počet. A t&aacute;to siln&aacute; sk&uacute;senosť im otvorila oči a oni spoznali, že je to P&aacute;n! Ako my vyhodnocujeme svoje životn&eacute; sk&uacute;senosti? Otv&aacute;raj&uacute; n&aacute;m oči? Spozn&aacute;vame v nich p&ocirc;sobenie P&aacute;na?</p>    <p>(2) Efekt&iacute;vnosť. Peter sa chopil iniciat&iacute;vy a pod jeho vplyvom učen&iacute;ci vy&scaron;li chytať ryby. Ale nechytili nič. Nestač&iacute;, že sme iniciat&iacute;vni, ale pre efektivitu je potrebn&aacute; pr&iacute;tomnosť P&aacute;na! Darmo sa nam&aacute;hame, darmo sme iniciat&iacute;vni. Pri svojich nam&aacute;haniach potrebujeme pr&iacute;tomnosť P&aacute;na.</p>    <p>(3) &bdquo;Kde je Peter, tam je Cirkev.&ldquo; S&uacute; to slov&aacute; sv. Ambr&oacute;za (339 &ndash; 397) a s&uacute; nap&iacute;san&eacute; aj v kaplnke P&aacute;pežsk&eacute;ho slovensk&eacute;ho kol&eacute;gia v R&iacute;me. Ježi&scaron; 3x vyzval &Scaron;imona, aby mu povedal, že ho miluje, a 3x ho vyzval: &bdquo;Pas moje ovce!&ldquo; Katol&iacute;cky v&yacute;klad považuje tieto slov&aacute; za teologick&yacute; z&aacute;klad prim&aacute;tu Petrov&yacute;ch n&aacute;stupcov. Okrem Vyznania viery Petrovo prvenstvo je identick&yacute;m znakom jednoty kresťanov.</p>    <p>Požehnan&uacute; tretiu veľkonočn&uacute; nedeľu prajem v&scaron;etk&yacute;m.</p>    <p>J&aacute;n Duda</p>    <p>&nbsp;</p>    <p><em>Foto: www.ekolist.cz</em></p>
                                </div>

                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/18983/conversions/cover.jpg">
                                </div>
                            </div>
                        </div>
                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="2"  data-href="https://www.postoj.sk/shortnews/2481" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2481">
                            <div class="image-wrap">
                                <img src="https://www.postoj.sk/uploads/18954/conversions/cover.jpg">
                            </div>
                            <header>
                                <h3 class="author-link"><a href="https://www.postoj.sk/autor/martin-hanus" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Martin Hanus</a></h3>
                                <small>• pred 2 d</small>
                            </header>
                            <div class="perex">
                                <p>Včeraj&scaron;ie stretnutie Mattea Salviniho s Viktorom Orb&aacute;nom na maďarskej p&ocirc;de dopadlo podľa scen&aacute;ra: obaja rovnako ako vlani v Mil&aacute;ne&nbsp;demon&scaron;trovali vz&aacute;jomn&eacute;...
                            </div>


                        </article>
                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                <header class="clearfix">
                                    <div class="image-wrap show">
                                        <img src="https://www.postoj.sk/uploads/9311/conversions/profile.jpg" alt="Martin Hanus">
                                    </div>
                                    <div class="header-text" style="">
                                        <div class="author-name">Martin Hanus</div><small style="margin-left: 5px;">• pred 2 d</small>
                                    </div>
                                </header>

                                <div class="article-social-buttons">
                                    <div class="social-btn">
                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2481" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                        </div>
                                    </div>
                                    <div class="social-btn">
                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2481"  data-text="Viktor Orb&aacute;n: &bdquo;Salvini je najd&ocirc;ležitej&scaron;&iacute; človek v dne&scaron;nej Eur&oacute;pe.&ldquo; "  class="twitter-share-button">Tweet</a>
                                    </div>
                                </div>

                                <div class="article-text">
                                    <p>Včeraj&scaron;ie stretnutie Mattea Salviniho s Viktorom Orb&aacute;nom na maďarskej p&ocirc;de dopadlo podľa scen&aacute;ra: obaja rovnako ako vlani v Mil&aacute;ne&nbsp;demon&scaron;trovali vz&aacute;jomn&eacute; sympatie, taliansky minister vn&uacute;tra pred novin&aacute;rmi vyhl&aacute;sil, že do Budape&scaron;ti pri&scaron;iel, aby videl, ako sa br&aacute;nia hranice. Takže len čo prist&aacute;l v Budape&scaron;ti, helikopt&eacute;ra ho odviezla na hranice so Srbskom, kde ho v R&ouml;szke čakal Orb&aacute;n.</p>    <p>Zhruba v tom čase uverejnil s Orb&aacute;nom&nbsp;rozsiahly <a href="https://www.lastampa.it/2019/05/01/esteri/victor-orban-denaro-sicurezza-mercato-oggi-ci-sono-gi-tre-europe-ma-fingiamo-sia-soltanto-una-hChaJXulkKMsAk4TlKamBN/premium.html" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-exit-link">rozhovor</a> taliansky denn&iacute;k La Stampa (tu je v <a href="https://www.lastampa.it/2019/05/02/esteri/victor-orban-money-safety-market-today-there-are-already-three-europes-but-we-pretend-there-is-only-one-LpGkFQpBBo8xWuge3nuYTI/pagina.html" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-exit-link">anglickej verzii</a>). Orb&aacute;n v ňom&nbsp;označil Salviniho za &bdquo;hrdinu, ktor&yacute; ako prv&yacute; zastavil migr&aacute;ciu na mori, k&yacute;m my sme ju zastavili na s&uacute;&scaron;i&ldquo;&nbsp;a za &bdquo;najd&ocirc;ležitej&scaron;ieho človeka v dne&scaron;nej Eur&oacute;pe&ldquo;. Maďarsk&yacute; premi&eacute;r tiež povedal, že Eur&oacute;pskej&nbsp;ľudovej&nbsp;strane&nbsp;(Fidesz m&aacute; nateraz v EPP pozastaven&eacute; členstvo)&nbsp;hroz&iacute; samovražda, ak bude ďalej pokračovať v spojenectve so socialistami &ndash;&nbsp;jej jedinou z&aacute;chranou je preto spojenie s pravicovou alianciou okolo Salviniho, ktor&eacute;mu žel&aacute; čo najv&auml;č&scaron;&iacute; volebn&yacute; &uacute;spech.&nbsp;&nbsp;</p>    <p>Samozrejme, tieto slov&aacute;, ktor&eacute; trhaj&uacute; u&scaron;i v&auml;č&scaron;ine partnerov v EPP, s&uacute; s&uacute;časťou Orb&aacute;novej&nbsp;eurokampane, v ktorej&nbsp;mobilizuje svojich voličov na migračnej karte. S&uacute;časne t&yacute;m voči EPP vysiela sign&aacute;l, že&nbsp;ak suverenistick&yacute; blok na čele so Salvinim a Le Penovou v&yacute;znamne posilnia, on s&aacute;m bude zvažovať, či zostať form&aacute;lnou s&uacute;časťou &bdquo;samovražedn&eacute;ho&ldquo;&nbsp;spolku alebo stavať na novej osi&nbsp;Budape&scaron;ť &ndash; R&iacute;m.</p>    <p>Ak eur&oacute;pske voľby m&ocirc;žu priniesť v nejakej krajine politick&eacute;&nbsp;zemetrasenie, tak je to pr&aacute;ve v Taliansku. Očak&aacute;va sa, že Salviniho Liga z&iacute;ska takmer dvojn&aacute;sobn&yacute; podiel hlasov&nbsp;oproti 17 percent&aacute;m z parlamentn&yacute;ch&nbsp;volieb&nbsp;v marci 2018 a bude mať tak&nbsp;po nemeckej CDU najviac europoslancov. A keďže v koaličnej vl&aacute;de Hnutia&nbsp;piatich&nbsp;hviezd a Ligy narast&aacute; nap&auml;tie, mnoh&iacute; talianski koment&aacute;tori predpokladaj&uacute;, že ak p&auml;ťhviezdičkov&eacute; hnutie zaznamen&aacute; mas&iacute;vne straty, ako naznačuj&uacute; prieskumy, Liga&nbsp;to využije na vyvolanie skor&yacute;ch predčasn&yacute;ch volieb. Moc v krajine by tak mohol zdvihn&uacute;ť zo zeme len&nbsp;jedin&yacute; muž &ndash;&nbsp;Matteo Salvini.&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</p>    <p><em>Maďarsk&yacute; premi&eacute;r Viktor Orb&aacute;n a taliansky minister vn&uacute;tra Matteo Salvini&nbsp;&nbsp;si pod&aacute;vaj&uacute; ruky počas tlačovej konferencie 2. m&aacute;ja 2019 v Budape&scaron;ti. FOTO TASR/AP</em></p>
                                </div>

                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/18954/conversions/cover.jpg">
                                </div>
                            </div>
                        </div>
                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="3"  data-href="https://www.postoj.sk/shortnews/2480" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2480">
                            <div class="image-wrap">
                                <img src="https://www.postoj.sk/uploads/18929/conversions/cover.jpg">
                            </div>
                            <header>
                                <h3 class="author-link"><a href="https://www.postoj.sk/autor/lukas-krivosik" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a></h3>
                                <small>• pred 3 d</small>
                            </header>
                            <div class="perex">
                                <p>Katol&iacute;ci a&nbsp;evanjelici v&nbsp;Nemecku do roku 2060 stratia asi polovicu členov. Podľa &uacute;dajov z&nbsp;roku 2017 sa k&nbsp;dvom najv&auml;č&scaron;&iacute;m cirkv&aacute;m hl&aacute;si 44,8...
                            </div>


                        </article>
                        <div style="display: none;">
                            <div class="kd-qtip-arrow"></div>
                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                <header class="clearfix">
                                    <div class="image-wrap show">
                                        <img src="https://www.postoj.sk/uploads/9793/conversions/profile.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">
                                    </div>
                                    <div class="header-text" style="">
                                        <div class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</div><small style="margin-left: 5px;">• pred 3 d</small>
                                    </div>
                                </header>

                                <div class="article-social-buttons">
                                    <div class="social-btn">
                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2480" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                        </div>
                                    </div>
                                    <div class="social-btn">
                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2480"  data-text="Nemeck&eacute; cirkvi stratia polovicu veriacich do roku 2060"  class="twitter-share-button">Tweet</a>
                                    </div>
                                </div>

                                <div class="article-text">
                                    <p>Katol&iacute;ci a&nbsp;evanjelici v&nbsp;Nemecku do roku 2060 stratia asi polovicu členov. Podľa &uacute;dajov z&nbsp;roku 2017 sa k&nbsp;dvom najv&auml;č&scaron;&iacute;m cirkv&aacute;m hl&aacute;si 44,8 mili&oacute;na ľud&iacute;, čo predstavuje 54,4 percenta nemeckej popul&aacute;cie. No v&nbsp;roku 2060 m&aacute; v&nbsp;Nemecku žiť už len 22,7 mili&oacute;na katol&iacute;kov a&nbsp;evanjelikov, teda asi&nbsp;polovica zo s&uacute;časn&eacute;ho počtu.</p>    <p>Vypl&yacute;va to z&nbsp;progn&oacute;zy V&yacute;skumn&eacute;ho centra generačnej zmluvy Univerzity Alberta Ludwiga vo Freiburgu. Informovala o&nbsp;nej Nemeck&aacute; biskupsk&aacute; konferencia na <a href="https://dbk.de/themen/kirche-und-geld/projektion-2060/" class="track-me-pls" data-category="home_kratke-spravy-exit-link">svojej webovej str&aacute;nke</a>.</p>    <p>Katol&iacute;cka cirkev v&nbsp;Nemecku poklesne zo s&uacute;časn&yacute;ch 23,3 mili&oacute;na&nbsp;veriacich na 12,2 mili&oacute;na v&nbsp;roku 2060.</p>    <p>Evanjelick&aacute; cirkev poklesne z&nbsp;teraj&scaron;&iacute;ch 21,5 mili&oacute;na na 10,5 mili&oacute;na veriacich v&nbsp;roku 2060.</p>    <p>Tento v&yacute;voj m&aacute; byť čiastočne d&ocirc;sledkom &uacute;mrtnosti, čiastočne vyst&uacute;peniami z&nbsp;cirkv&iacute;, ktor&eacute; krsty nov&yacute;ch členov nestačia kompenzovať.</p>    <p><em>Kol&iacute;nsky d&oacute;m. FOTO &ndash;&nbsp;TASR/AP</em></p>
                                </div>

                                <div class="article-image">
                                    <img src="https://www.postoj.sk/uploads/18929/conversions/cover.jpg">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


            </div>
            <div class="col-xxs-12 col-md-3 col-md-3-plus-compensation">
                <div class=" eq-me  double-border-bottom border-left">



                    <section class="shop-product-banner">
                        <header class="clearfix">
                            <h2 class="section-title">Novinka z vydavateľstva</h2>
                        </header>

                        <div class="book-item row">

                            <div class="book-detail col-xs-6 col-lg-7">
                                <a href="https://obchod.postoj.sk/produkt/bud-kde-si/44" class="book-author track-me-pls"
                                   data-category="shop_banner_top-title"
                                   data-action="click"
                                   data-label="bud-kde-si">Buď, kde si</a>

                                <p class="book-perex">O m&uacute;drosti p&uacute;&scaron;tnych otcov a n&aacute;strah&aacute;ch dne&scaron;nej doby</p>

                                <h4 class="promo-text">Naša knižná novinka so zľavou 10 %</h4>

                                <a href="https://obchod.postoj.sk/produkt/bud-kde-si/44" class="book-link track-me-pls"
                                   data-category="shop_banner_top-about"
                                   data-action="click"
                                   data-label="bud-kde-si">O knihe</a>

                            </div>

                            <div class="book-image pull-right">
                                <a href="https://obchod.postoj.sk/produkt/bud-kde-si/44" class="track-me-pls"
                                   alt="Buď, kde si"
                                   data-category="shop_banner_top-img"
                                   data-action="click"
                                   data-label="bud-kde-si">

                                    <img src="https://www.postoj.sk/uploads/16476/conversions/variation_thumb.png">
                                </a>

                                <span class="badge badge-price">
                        Cena u nás:
                        <span class="price">9,81&nbsp;&euro;</span>
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
                                    <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43035/kostoly-na-sri-lanke-ostavaju-zatvorene-papezske-misijne-diela-ziadaju-o-pomoc"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Kostoly na Sr&iacute; Lanke ost&aacute;vaj&uacute; zatvoren&eacute;, P&aacute;pežsk&eacute; misijn&eacute; diela žiadaj&uacute; o pomoc</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43003/marian-kuffa-v-debate-o-zakovciach-harabinovi-aj-dzenderi-video"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="4"  >
                                        <span>4.</span>
                                        <h3 class="article-title">Mari&aacute;n Kuffa v debate o Žakovciach, Harabinovi aj dženderi (video)</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-today" data-value="5"  >
                                        <span>5.</span>
                                        <h3 class="article-title">Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem</h3>
                                    </a>
                                </article>
                            </div>
                            <div id="yesterday-popular-articles" class="popular-articles-list tab-pane" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43003/marian-kuffa-v-debate-o-zakovciach-harabinovi-aj-dzenderi-video"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Mari&aacute;n Kuffa v debate o Žakovciach, Harabinovi aj dženderi (video)</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="4"  >
                                        <span>4.</span>
                                        <h3 class="article-title">Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/42972/ako-obstal-marian-kuffa-v-kaviarni"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-yesterday" data-value="5"  >
                                        <span>5.</span>
                                        <h3 class="article-title">Ako obst&aacute;l Mari&aacute;n Kuffa v&nbsp;kaviarni? (+video)</h3>
                                    </a>
                                </article>
                            </div>
                            <div id="week-popular-articles" class="popular-articles-list tab-pane" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/42972/ako-obstal-marian-kuffa-v-kaviarni"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Ako obst&aacute;l Mari&aacute;n Kuffa v&nbsp;kaviarni? (+video)</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/42845/advokat-martiny-o-connor-z-postupu-vysetrovatelky-som-zhrozeny"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Advok&aacute;t Martiny O&#039;Connor: Z postupu vy&scaron;etrovateľky som zhrozen&yacute;</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43024/musime-ju-pocuvat"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Mus&iacute;me ju poč&uacute;vať</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43003/marian-kuffa-v-debate-o-zakovciach-harabinovi-aj-dzenderi-video"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="4"  >
                                        <span>4.</span>
                                        <h3 class="article-title">Mari&aacute;n Kuffa v debate o Žakovciach, Harabinovi aj dženderi (video)</h3>
                                    </a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/42964/vatikan-zacal-kanonicke-vysetrovanie-pripadu-martiny-o-connor"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-week" data-value="5"  >
                                        <span>5.</span>
                                        <h3 class="article-title">Vatik&aacute;n začal kanonick&eacute; vy&scaron;etrovanie pr&iacute;padu Martiny O&acute;Connor</h3>
                                    </a>
                                </article>
                            </div>
                            <div id="blog-popular-articles" class="popular-articles-list tab-pane" role="tabpanel">
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/43087/nestrielajte-na-otca-kuffu-otec-kuffa-nestrielajte-na-nas"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-blog" data-value="1"  >
                                        <span>1.</span>
                                        <h3 class="article-title">Nestrieľajte na otca Kuffu, otec Kuffa nestrieľajte na n&aacute;s</h3>
                                    </a> - <a href="https://www.postoj.sk/autor/ema-pagacova"  class="blog-author  track-me-pls "  data-category="kategoria_clanky-autor" data-action="click" >Ema Pag&aacute;čov&aacute;</a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/42978/ad-vladimir-palko-americka-zakladna-na-slovensku-a-geopolitika"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-blog" data-value="2"  >
                                        <span>2.</span>
                                        <h3 class="article-title">Ad: Vladim&iacute;r Palko - Americk&aacute; z&aacute;kladňa na Slovensku a&nbsp;geopolitika</h3>
                                    </a> - <a href="https://www.postoj.sk/autor/jaroslav-nad"  class="blog-author  track-me-pls "  data-category="kategoria_clanky-autor" data-action="click" >Jaroslav Naď</a>
                                </article>
                                <article class="popular-article">
                                    <a href="https://www.postoj.sk/42910/bude-arcibiskup-zvolensky-novym-slovenskym-kardinalom"  class="track-me-pls" data-category="home_najcitanejsie-clanok" data-action="click" data-label="position-blog" data-value="3"  >
                                        <span>3.</span>
                                        <h3 class="article-title">Bude arcibiskup Zvolensk&yacute; nov&yacute;m slovensk&yacute;m kardin&aacute;lom?</h3>
                                    </a> - <a href="https://www.postoj.sk/autor/lenka-nalevankova"  class="blog-author  track-me-pls "  data-category="kategoria_clanky-autor" data-action="click" >Lenka Nalevankov&aacute; Mi&scaron;enkov&aacute;</a>
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
                                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="1"  data-href="https://www.postoj.sk/shortnews/2482" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2482">
                                            <div class="image-wrap">
                                                <img src="https://www.postoj.sk/uploads/18983/conversions/cover.jpg">
                                            </div>
                                            <header>
                                                <h3 class="author-link"><a href="https://www.postoj.sk/autor/jan-duda-1" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">J&aacute;n Duda</a></h3>
                                                <small>• pred 1 d</small>
                                            </header>
                                            <div class="perex">
                                                <p>Evanjelium tretej veľkonočnej nedele (5. 5. 2019) je dosť dlh&eacute; (Jn 21,1-19). K nemu len tri kr&aacute;tke pozn&aacute;mky.</p>    <p>(1) Vyznanie...
                                            </div>


                                        </article>
                                        <div style="display: none;">
                                            <div class="kd-qtip-arrow"></div>
                                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                                <header class="clearfix">
                                                    <div class="image-wrap show">
                                                        <img src="https://www.postoj.sk/uploads/1885/conversions/profile.jpg" alt="J&aacute;n Duda">
                                                    </div>
                                                    <div class="header-text" style="">
                                                        <div class="author-name">J&aacute;n Duda</div><small style="margin-left: 5px;">• pred 1 d</small>
                                                    </div>
                                                </header>

                                                <div class="article-social-buttons">
                                                    <div class="social-btn">
                                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2482" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                                        </div>
                                                    </div>
                                                    <div class="social-btn">
                                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2482"  data-text="Potrebujeme pr&iacute;tomnosť P&aacute;na"  class="twitter-share-button">Tweet</a>
                                                    </div>
                                                </div>

                                                <div class="article-text">
                                                    <p>Evanjelium tretej veľkonočnej nedele (5. 5. 2019) je dosť dlh&eacute; (Jn 21,1-19). K nemu len tri kr&aacute;tke pozn&aacute;mky.</p>    <p>(1) Vyznanie viery. Tentoraz ho vyslovil apo&scaron;tol J&aacute;n po tom, ako ulovili veľk&eacute; množstvo r&yacute;b: &bdquo;P&aacute;n je to.&ldquo; Je tu siln&aacute; životn&aacute; sk&uacute;senosť: ulovili 153 r&yacute;b, J&aacute;n si dokonca zapam&auml;tal aj ich počet. A t&aacute;to siln&aacute; sk&uacute;senosť im otvorila oči a oni spoznali, že je to P&aacute;n! Ako my vyhodnocujeme svoje životn&eacute; sk&uacute;senosti? Otv&aacute;raj&uacute; n&aacute;m oči? Spozn&aacute;vame v nich p&ocirc;sobenie P&aacute;na?</p>    <p>(2) Efekt&iacute;vnosť. Peter sa chopil iniciat&iacute;vy a pod jeho vplyvom učen&iacute;ci vy&scaron;li chytať ryby. Ale nechytili nič. Nestač&iacute;, že sme iniciat&iacute;vni, ale pre efektivitu je potrebn&aacute; pr&iacute;tomnosť P&aacute;na! Darmo sa nam&aacute;hame, darmo sme iniciat&iacute;vni. Pri svojich nam&aacute;haniach potrebujeme pr&iacute;tomnosť P&aacute;na.</p>    <p>(3) &bdquo;Kde je Peter, tam je Cirkev.&ldquo; S&uacute; to slov&aacute; sv. Ambr&oacute;za (339 &ndash; 397) a s&uacute; nap&iacute;san&eacute; aj v kaplnke P&aacute;pežsk&eacute;ho slovensk&eacute;ho kol&eacute;gia v R&iacute;me. Ježi&scaron; 3x vyzval &Scaron;imona, aby mu povedal, že ho miluje, a 3x ho vyzval: &bdquo;Pas moje ovce!&ldquo; Katol&iacute;cky v&yacute;klad považuje tieto slov&aacute; za teologick&yacute; z&aacute;klad prim&aacute;tu Petrov&yacute;ch n&aacute;stupcov. Okrem Vyznania viery Petrovo prvenstvo je identick&yacute;m znakom jednoty kresťanov.</p>    <p>Požehnan&uacute; tretiu veľkonočn&uacute; nedeľu prajem v&scaron;etk&yacute;m.</p>    <p>J&aacute;n Duda</p>    <p>&nbsp;</p>    <p><em>Foto: www.ekolist.cz</em></p>
                                                </div>

                                                <div class="article-image">
                                                    <img src="https://www.postoj.sk/uploads/18983/conversions/cover.jpg">
                                                </div>
                                            </div>
                                        </div>
                                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="2"  data-href="https://www.postoj.sk/shortnews/2481" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2481">
                                            <div class="image-wrap">
                                                <img src="https://www.postoj.sk/uploads/18954/conversions/cover.jpg">
                                            </div>
                                            <header>
                                                <h3 class="author-link"><a href="https://www.postoj.sk/autor/martin-hanus" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Martin Hanus</a></h3>
                                                <small>• pred 2 d</small>
                                            </header>
                                            <div class="perex">
                                                <p>Včeraj&scaron;ie stretnutie Mattea Salviniho s Viktorom Orb&aacute;nom na maďarskej p&ocirc;de dopadlo podľa scen&aacute;ra: obaja rovnako ako vlani v Mil&aacute;ne&nbsp;demon&scaron;trovali vz&aacute;jomn&eacute;...
                                            </div>


                                        </article>
                                        <div style="display: none;">
                                            <div class="kd-qtip-arrow"></div>
                                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                                <header class="clearfix">
                                                    <div class="image-wrap show">
                                                        <img src="https://www.postoj.sk/uploads/9311/conversions/profile.jpg" alt="Martin Hanus">
                                                    </div>
                                                    <div class="header-text" style="">
                                                        <div class="author-name">Martin Hanus</div><small style="margin-left: 5px;">• pred 2 d</small>
                                                    </div>
                                                </header>

                                                <div class="article-social-buttons">
                                                    <div class="social-btn">
                                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2481" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                                        </div>
                                                    </div>
                                                    <div class="social-btn">
                                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2481"  data-text="Viktor Orb&aacute;n: &bdquo;Salvini je najd&ocirc;ležitej&scaron;&iacute; človek v dne&scaron;nej Eur&oacute;pe.&ldquo; "  class="twitter-share-button">Tweet</a>
                                                    </div>
                                                </div>

                                                <div class="article-text">
                                                    <p>Včeraj&scaron;ie stretnutie Mattea Salviniho s Viktorom Orb&aacute;nom na maďarskej p&ocirc;de dopadlo podľa scen&aacute;ra: obaja rovnako ako vlani v Mil&aacute;ne&nbsp;demon&scaron;trovali vz&aacute;jomn&eacute; sympatie, taliansky minister vn&uacute;tra pred novin&aacute;rmi vyhl&aacute;sil, že do Budape&scaron;ti pri&scaron;iel, aby videl, ako sa br&aacute;nia hranice. Takže len čo prist&aacute;l v Budape&scaron;ti, helikopt&eacute;ra ho odviezla na hranice so Srbskom, kde ho v R&ouml;szke čakal Orb&aacute;n.</p>    <p>Zhruba v tom čase uverejnil s Orb&aacute;nom&nbsp;rozsiahly <a href="https://www.lastampa.it/2019/05/01/esteri/victor-orban-denaro-sicurezza-mercato-oggi-ci-sono-gi-tre-europe-ma-fingiamo-sia-soltanto-una-hChaJXulkKMsAk4TlKamBN/premium.html" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-exit-link">rozhovor</a> taliansky denn&iacute;k La Stampa (tu je v <a href="https://www.lastampa.it/2019/05/02/esteri/victor-orban-money-safety-market-today-there-are-already-three-europes-but-we-pretend-there-is-only-one-LpGkFQpBBo8xWuge3nuYTI/pagina.html" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-exit-link">anglickej verzii</a>). Orb&aacute;n v ňom&nbsp;označil Salviniho za &bdquo;hrdinu, ktor&yacute; ako prv&yacute; zastavil migr&aacute;ciu na mori, k&yacute;m my sme ju zastavili na s&uacute;&scaron;i&ldquo;&nbsp;a za &bdquo;najd&ocirc;ležitej&scaron;ieho človeka v dne&scaron;nej Eur&oacute;pe&ldquo;. Maďarsk&yacute; premi&eacute;r tiež povedal, že Eur&oacute;pskej&nbsp;ľudovej&nbsp;strane&nbsp;(Fidesz m&aacute; nateraz v EPP pozastaven&eacute; členstvo)&nbsp;hroz&iacute; samovražda, ak bude ďalej pokračovať v spojenectve so socialistami &ndash;&nbsp;jej jedinou z&aacute;chranou je preto spojenie s pravicovou alianciou okolo Salviniho, ktor&eacute;mu žel&aacute; čo najv&auml;č&scaron;&iacute; volebn&yacute; &uacute;spech.&nbsp;&nbsp;</p>    <p>Samozrejme, tieto slov&aacute;, ktor&eacute; trhaj&uacute; u&scaron;i v&auml;č&scaron;ine partnerov v EPP, s&uacute; s&uacute;časťou Orb&aacute;novej&nbsp;eurokampane, v ktorej&nbsp;mobilizuje svojich voličov na migračnej karte. S&uacute;časne t&yacute;m voči EPP vysiela sign&aacute;l, že&nbsp;ak suverenistick&yacute; blok na čele so Salvinim a Le Penovou v&yacute;znamne posilnia, on s&aacute;m bude zvažovať, či zostať form&aacute;lnou s&uacute;časťou &bdquo;samovražedn&eacute;ho&ldquo;&nbsp;spolku alebo stavať na novej osi&nbsp;Budape&scaron;ť &ndash; R&iacute;m.</p>    <p>Ak eur&oacute;pske voľby m&ocirc;žu priniesť v nejakej krajine politick&eacute;&nbsp;zemetrasenie, tak je to pr&aacute;ve v Taliansku. Očak&aacute;va sa, že Salviniho Liga z&iacute;ska takmer dvojn&aacute;sobn&yacute; podiel hlasov&nbsp;oproti 17 percent&aacute;m z parlamentn&yacute;ch&nbsp;volieb&nbsp;v marci 2018 a bude mať tak&nbsp;po nemeckej CDU najviac europoslancov. A keďže v koaličnej vl&aacute;de Hnutia&nbsp;piatich&nbsp;hviezd a Ligy narast&aacute; nap&auml;tie, mnoh&iacute; talianski koment&aacute;tori predpokladaj&uacute;, že ak p&auml;ťhviezdičkov&eacute; hnutie zaznamen&aacute; mas&iacute;vne straty, ako naznačuj&uacute; prieskumy, Liga&nbsp;to využije na vyvolanie skor&yacute;ch predčasn&yacute;ch volieb. Moc v krajine by tak mohol zdvihn&uacute;ť zo zeme len&nbsp;jedin&yacute; muž &ndash;&nbsp;Matteo Salvini.&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;</p>    <p><em>Maďarsk&yacute; premi&eacute;r Viktor Orb&aacute;n a taliansky minister vn&uacute;tra Matteo Salvini&nbsp;&nbsp;si pod&aacute;vaj&uacute; ruky počas tlačovej konferencie 2. m&aacute;ja 2019 v Budape&scaron;ti. FOTO TASR/AP</em></p>
                                                </div>

                                                <div class="article-image">
                                                    <img src="https://www.postoj.sk/uploads/18954/conversions/cover.jpg">
                                                </div>
                                            </div>
                                        </div>
                                        <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-hover" data-action="mouseover" data-label="position" data-value="3"  data-href="https://www.postoj.sk/shortnews/2480" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2480">
                                            <div class="image-wrap">
                                                <img src="https://www.postoj.sk/uploads/18929/conversions/cover.jpg">
                                            </div>
                                            <header>
                                                <h3 class="author-link"><a href="https://www.postoj.sk/autor/lukas-krivosik" class="track-me-pls" data-category="home_kratke-spravy-autor" data-action="click">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a></h3>
                                                <small>• pred 3 d</small>
                                            </header>
                                            <div class="perex">
                                                <p>Katol&iacute;ci a&nbsp;evanjelici v&nbsp;Nemecku do roku 2060 stratia asi polovicu členov. Podľa &uacute;dajov z&nbsp;roku 2017 sa k&nbsp;dvom najv&auml;č&scaron;&iacute;m cirkv&aacute;m hl&aacute;si 44,8...
                                            </div>


                                        </article>
                                        <div style="display: none;">
                                            <div class="kd-qtip-arrow"></div>
                                            <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                                <header class="clearfix">
                                                    <div class="image-wrap show">
                                                        <img src="https://www.postoj.sk/uploads/9793/conversions/profile.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">
                                                    </div>
                                                    <div class="header-text" style="">
                                                        <div class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</div><small style="margin-left: 5px;">• pred 3 d</small>
                                                    </div>
                                                </header>

                                                <div class="article-social-buttons">
                                                    <div class="social-btn">
                                                        <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2480" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                                        </div>
                                                    </div>
                                                    <div class="social-btn">
                                                        <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2480"  data-text="Nemeck&eacute; cirkvi stratia polovicu veriacich do roku 2060"  class="twitter-share-button">Tweet</a>
                                                    </div>
                                                </div>

                                                <div class="article-text">
                                                    <p>Katol&iacute;ci a&nbsp;evanjelici v&nbsp;Nemecku do roku 2060 stratia asi polovicu členov. Podľa &uacute;dajov z&nbsp;roku 2017 sa k&nbsp;dvom najv&auml;č&scaron;&iacute;m cirkv&aacute;m hl&aacute;si 44,8 mili&oacute;na ľud&iacute;, čo predstavuje 54,4 percenta nemeckej popul&aacute;cie. No v&nbsp;roku 2060 m&aacute; v&nbsp;Nemecku žiť už len 22,7 mili&oacute;na katol&iacute;kov a&nbsp;evanjelikov, teda asi&nbsp;polovica zo s&uacute;časn&eacute;ho počtu.</p>    <p>Vypl&yacute;va to z&nbsp;progn&oacute;zy V&yacute;skumn&eacute;ho centra generačnej zmluvy Univerzity Alberta Ludwiga vo Freiburgu. Informovala o&nbsp;nej Nemeck&aacute; biskupsk&aacute; konferencia na <a href="https://dbk.de/themen/kirche-und-geld/projektion-2060/" class="track-me-pls" data-category="home_kratke-spravy-exit-link">svojej webovej str&aacute;nke</a>.</p>    <p>Katol&iacute;cka cirkev v&nbsp;Nemecku poklesne zo s&uacute;časn&yacute;ch 23,3 mili&oacute;na&nbsp;veriacich na 12,2 mili&oacute;na v&nbsp;roku 2060.</p>    <p>Evanjelick&aacute; cirkev poklesne z&nbsp;teraj&scaron;&iacute;ch 21,5 mili&oacute;na na 10,5 mili&oacute;na veriacich v&nbsp;roku 2060.</p>    <p>Tento v&yacute;voj m&aacute; byť čiastočne d&ocirc;sledkom &uacute;mrtnosti, čiastočne vyst&uacute;peniami z&nbsp;cirkv&iacute;, ktor&eacute; krsty nov&yacute;ch členov nestačia kompenzovať.</p>    <p><em>Kol&iacute;nsky d&oacute;m. FOTO &ndash;&nbsp;TASR/AP</em></p>
                                                </div>

                                                <div class="article-image">
                                                    <img src="https://www.postoj.sk/uploads/18929/conversions/cover.jpg">
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
                            <article class="articles article  article-more-authors   ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43125/pri-nudzovom-pristati-lietadla-v-moskve-zahynulo-41-ludi" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="1">
                                                    Pri n&uacute;dzovom prist&aacute;t&iacute; lietadla v Moskve zahynulo 41 ľud&iacute;
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43125/pri-nudzovom-pristati-lietadla-v-moskve-zahynulo-41-ludi" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="1">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/19026/conversions/square.jpg"  alt="Pri n&uacute;dzovom prist&aacute;t&iacute; lietadla v Moskve zahynulo 41 ľud&iacute;">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43125/pri-nudzovom-pristati-lietadla-v-moskve-zahynulo-41-ludi" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="1">
                                                    Pri n&uacute;dzovom prist&aacute;t&iacute; lietadla v Moskve zahynulo 41 ľud&iacute;
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Pos&aacute;dka pre Echo Moskvy uviedla, že lietadlo počas letu zasiahol blesk.</p>
                                            <p class="show-kd-mobile">
                                                Pos&aacute;dka pre Echo Moskvy uviedla, že lietadlo počas letu zasiahol blesk.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spravodajstvo" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spravodajstvo</a>
                                            <a href="https://www.postoj.sk/autor/tasr" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">TASR</span>
                                            </a>
                                            <a href="https://www.postoj.sk/autor/postoj" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">Postoj</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="2">
                                                    Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="2">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/19008/conversions/square.jpg"  alt="Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="2">
                                                    Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Rozhovor s Obianujou Ekeochou o tom, že Z&aacute;pad by Afrike najviac pomohol t&yacute;m, keby prestal s rozvojovou pomocou.</p>
                                            <p class="show-kd-mobile">
                                                Rozhovor s Obianujou Ekeochou o tom, že Z&aacute;pad by Afrike najviac pomohol t&yacute;m, keby prestal s rozvojovou pomocou.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/lukas-kekelak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/8772/conversions/square.jpg" alt="Luk&aacute;&scaron; Kekel&aacute;k">                      <span class="author-name">Luk&aacute;&scaron; Kekel&aacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="3">
                                                    Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="3">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/19001/conversions/square.jpg"  alt="Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="3">
                                                    Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Pozrite si videoz&aacute;znam z pr&iacute;hovoru arcibiskupa metropolitu Stanislava Zvolensk&eacute;ho o s&uacute;časn&yacute;ch v&yacute;zvach a z n&aacute;slednej diskusie.</p>
                                            <p class="show-kd-mobile">
                                                Pozrite si videoz&aacute;znam z pr&iacute;hovoru arcibiskupa metropolitu Stanislava Zvolensk&eacute;ho o s&uacute;časn&yacute;ch v&yacute;zvach a z n&aacute;slednej diskusie.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/postoj" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">Postoj</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43105/uz-zase-cestujem-miroslav-bielik" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="4">
                                                    Už zase cestujem (Miroslav Bielik)
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43105/uz-zase-cestujem-miroslav-bielik" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="4">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/19003/conversions/square.jpg"  alt="Už zase cestujem (Miroslav Bielik)">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43105/uz-zase-cestujem-miroslav-bielik" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="4">
                                                    Už zase cestujem (Miroslav Bielik)
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Zas cestujem domov, zmenene &ndash; zmenenou tmou</p>
                                            <p class="show-kd-mobile">
                                                Zas cestujem domov, zmenene &ndash; zmenenou tmou

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/kultura" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Kult&uacute;ra</a>
                                            <a href="https://www.postoj.sk/autor/michal-chuda" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/2553/conversions/square.jpg" alt="Michal Chuda">                      <span class="author-name">Michal Chuda</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="5">
                                                    Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="5">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18987/conversions/square.jpg"  alt="Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="5">
                                                    Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Pozrite si multiž&aacute;nrov&yacute; profil jedn&eacute;ho z najv&auml;č&scaron;&iacute;ch prorokov modernej doby G. K. Chestertona od Pavla Hraboveck&eacute;ho.</p>
                                            <p class="show-kd-mobile">
                                                Pozrite si multiž&aacute;nrov&yacute; profil jedn&eacute;ho z najv&auml;č&scaron;&iacute;ch prorokov modernej doby G. K. Chestertona od Pavla Hraboveck&eacute;ho.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/postoj" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">Postoj</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article  article-more-authors   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42986/nie-je-nic-horsie-ako-len-strielat-fakty-ktore-nemaju-nic-s-dianim-na-lade" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="6">
                                                    Presun slovensk&yacute;ch hokejistov do Ko&scaron;&iacute;c m&ocirc;že &scaron;ampion&aacute;t oživiť
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42986/nie-je-nic-horsie-ako-len-strielat-fakty-ktore-nemaju-nic-s-dianim-na-lade" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="6">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18874/conversions/square.jpg"  alt="Presun slovensk&yacute;ch hokejistov do Ko&scaron;&iacute;c m&ocirc;že &scaron;ampion&aacute;t oživiť">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42986/nie-je-nic-horsie-ako-len-strielat-fakty-ktore-nemaju-nic-s-dianim-na-lade" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="6">
                                                    Presun slovensk&yacute;ch hokejistov do Ko&scaron;&iacute;c m&ocirc;že &scaron;ampion&aacute;t oživiť
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Rozhovor s hokejov&yacute;m koment&aacute;torom Pavlom Ga&scaron;parom. </p>
                                            <p class="show-kd-mobile">
                                                Rozhovor s hokejov&yacute;m koment&aacute;torom Pavlom Ga&scaron;parom.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/adam-takac" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/9300/conversions/square.jpg" alt="Adam Tak&aacute;č">                      <span class="author-name">Adam Tak&aacute;č</span>
                                            </a>
                                            <a href="https://www.postoj.sk/autor/pavol-rabara" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/9298/conversions/square.jpg" alt="Pavol R&aacute;bara">                      <span class="author-name">Pavol R&aacute;bara</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43076/niektore-veci-sa-cenzurovat-musia" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="7">
                                                    Niektor&eacute; veci sa cenzurovať musia
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43076/niektore-veci-sa-cenzurovat-musia" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="7">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18975/conversions/square.jpg"  alt="Niektor&eacute; veci sa cenzurovať musia">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43076/niektore-veci-sa-cenzurovat-musia" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="7">
                                                    Niektor&eacute; veci sa cenzurovať musia
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Nejde o to, či je cenz&uacute;ra dobr&aacute; vec, ale o to, čo by sme mali cenzurovať.</p>
                                            <p class="show-kd-mobile">
                                                Nejde o to, či je cenz&uacute;ra dobr&aacute; vec, ale o to, čo by sme mali cenzurovať.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/david-warren" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">David Warren</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43083/slovensko-ma-podla-kisku-stastie-ze-sa-mozeme-opriet-o-stefanikov-odkaz" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="8">
                                                    Slovensko m&aacute; podľa Kisku &scaron;ťastie, že sa m&ocirc;žeme oprieť o &Scaron;tef&aacute;nikov odkaz
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43083/slovensko-ma-podla-kisku-stastie-ze-sa-mozeme-opriet-o-stefanikov-odkaz" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="8">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18994/conversions/square.jpg"  alt="Slovensko m&aacute; podľa Kisku &scaron;ťastie, že sa m&ocirc;žeme oprieť o &Scaron;tef&aacute;nikov odkaz">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43083/slovensko-ma-podla-kisku-stastie-ze-sa-mozeme-opriet-o-stefanikov-odkaz" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="8">
                                                    Slovensko m&aacute; podľa Kisku &scaron;ťastie, že sa m&ocirc;žeme oprieť o &Scaron;tef&aacute;nikov odkaz
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">S prejavmi pri pr&iacute;ležitosti 100. v&yacute;ročia tragick&eacute;ho &uacute;mrtia M. R. &Scaron;tef&aacute;nika v Brezovej pod Bradlom vyst&uacute;pili s pr&iacute;hovormi prezident Andrej Kiska, premi...</p>
                                            <p class="show-kd-mobile">
                                                S prejavmi pri pr&iacute;ležitosti 100. v&yacute;ročia tragick&eacute;ho &uacute;mrtia M. R. &Scaron;tef&aacute;nika v Brezovej pod Bradlom vyst&uacute;pili s pr&iacute;hovormi prezident Andrej Kiska, premi...

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spravodajstvo" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spravodajstvo</a>
                                            <a href="https://www.postoj.sk/autor/tasr" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">TASR</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43020/knihomolov-zapisnik-o-slovakoch-v-ceskoslovenskych-legiach" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="9">
                                                    Knihomoľov z&aacute;pisn&iacute;k: Slov&aacute;ci v československ&yacute;ch l&eacute;gi&aacute;ch
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43020/knihomolov-zapisnik-o-slovakoch-v-ceskoslovenskych-legiach" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="9">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18909/conversions/square.jpg"  alt="Knihomoľov z&aacute;pisn&iacute;k: Slov&aacute;ci v československ&yacute;ch l&eacute;gi&aacute;ch">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43020/knihomolov-zapisnik-o-slovakoch-v-ceskoslovenskych-legiach" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="9">
                                                    Knihomoľov z&aacute;pisn&iacute;k: Slov&aacute;ci v československ&yacute;ch l&eacute;gi&aacute;ch
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">&Scaron;esť kn&iacute;h spomienok Slov&aacute;kov, ktor&iacute; počas prvej svetovej vojny sl&uacute;žili v československ&yacute;ch l&eacute;gi&aacute;ch.</p>
                                            <p class="show-kd-mobile">
                                                &Scaron;esť kn&iacute;h spomienok Slov&aacute;kov, ktor&iacute; počas prvej svetovej vojny sl&uacute;žili v československ&yacute;ch l&eacute;gi&aacute;ch.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/kultura" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Kult&uacute;ra</a>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/9793/conversions/square.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">                      <span class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article  article-more-authors   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42938/dve-minuty-a-lietadlo-so-stefanikom-by-pristalo" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="10">
                                                    Dve min&uacute;ty a lietadlo so &Scaron;tef&aacute;nikom by prist&aacute;lo
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42938/dve-minuty-a-lietadlo-so-stefanikom-by-pristalo" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="10">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18818/conversions/square.jpg"  alt="Dve min&uacute;ty a lietadlo so &Scaron;tef&aacute;nikom by prist&aacute;lo">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42938/dve-minuty-a-lietadlo-so-stefanikom-by-pristalo" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="10">
                                                    Dve min&uacute;ty a lietadlo so &Scaron;tef&aacute;nikom by prist&aacute;lo
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Rozhovor s Pavlom Kanisom o p&aacute;de lietadla, pri ktorom pred sto rokmi zahynul Milan Rastislav &Scaron;tef&aacute;nik.</p>
                                            <p class="show-kd-mobile">
                                                Rozhovor s Pavlom Kanisom o p&aacute;de lietadla, pri ktorom pred sto rokmi zahynul Milan Rastislav &Scaron;tef&aacute;nik.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/martin-hanus" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/9311/conversions/square.jpg" alt="Martin Hanus">                      <span class="author-name">Martin Hanus</span>
                                            </a>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/9793/conversions/square.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">                      <span class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43051/ako-kristova-trnova-koruna-prezila-kriziacke-vojny-prevraty-a-poziar-notre-dame" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="11">
                                                    Ako Kristova tŕňov&aacute; koruna prežila križiacke vojny, prevraty a požiar Notre Dame
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43051/ako-kristova-trnova-koruna-prezila-kriziacke-vojny-prevraty-a-poziar-notre-dame" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="11">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18953/conversions/square.jpg"  alt="Ako Kristova tŕňov&aacute; koruna prežila križiacke vojny, prevraty a požiar Notre Dame">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43051/ako-kristova-trnova-koruna-prezila-kriziacke-vojny-prevraty-a-poziar-notre-dame" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="11">
                                                    Ako Kristova tŕňov&aacute; koruna prežila križiacke vojny, prevraty a požiar Notre Dame
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Tŕňov&aacute; koruna n&aacute;m pripom&iacute;na, že to, o čo pr&iacute;deme, m&ocirc;že raz op&auml;ť rozkvitn&uacute;ť.</p>
                                            <p class="show-kd-mobile">
                                                Tŕňov&aacute; koruna n&aacute;m pripom&iacute;na, že to, o čo pr&iacute;deme, m&ocirc;že raz op&auml;ť rozkvitn&uacute;ť.

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/svet-krestanstva" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Svet kresťanstva</a>
                                            <a href="https://www.postoj.sk/autor/emily-guerry" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <span class="author-name">Emily Guerry</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                            <article class="articles article   hidden-kd-mobile  ">
                                <div class="row">

                                    <div class="col-xxs-12 col-md-8 show-kd-mobile">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42542/utecencov-viacej-ako-domacich-no-nikde-ziadna-panika-vitajte-v-ugande" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="12">
                                                    Utečencov viac ako dom&aacute;cich, no nikde žiadna panika. Vitajte v Ugande!
                                                </a>
                                            </h3>
                                        </header>
                                    </div>

                                    <div class="col-xxs-5 col-md-4 img-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42542/utecencov-viacej-ako-domacich-no-nikde-ziadna-panika-vitajte-v-ugande" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="12">
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18376/conversions/square.jpg"  alt="Utečencov viac ako dom&aacute;cich, no nikde žiadna panika. Vitajte v Ugande!">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 mobile-text-col">
                                        <header class="hidden-kd-mobile">
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42542/utecencov-viacej-ako-domacich-no-nikde-ziadna-panika-vitajte-v-ugande" class="track-me-pls" data-category="home_clanky" data-action="click" data-label="position" data-value="12">
                                                    Utečencov viac ako dom&aacute;cich, no nikde žiadna panika. Vitajte v Ugande!
                                                </a>
                                            </h3>
                                        </header>
                                        <div class="perex">
                                            <p class="hidden-kd-mobile">Najhor&scaron;ie je prečkať deň s&nbsp;my&scaron;lienkou, čo bude zajtra, keď dnes, včera či aj mesiac predt&yacute;m ste&nbsp;robili to ist&eacute; &ndash; v&ocirc;bec nič. Report&aacute;ž z miesta, kde pom...</p>
                                            <p class="show-kd-mobile">
                                                Najhor&scaron;ie je prečkať deň s&nbsp;my&scaron;lienkou, čo bude zajtra, keď dnes, včera či aj mesiac predt&yacute;m ste&nbsp;robili to ist&eacute; &ndash; v&ocirc;bec nič. Report&aacute;ž z miesta, kde pom...

                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-xxs-12 col-md-8">
                                        <footer>
                                            <a href="https://www.postoj.sk/spolocnost" class="category-title track-me-pls" data-category="home_clanky-kategoria" data-action="click">Spoločnosť</a>
                                            <a href="https://www.postoj.sk/autor/lukas-kekelak" class="avatar avatar-little track-me-pls" data-category="home_clanky-autor" data-action="click">
                                                <img src="https://www.postoj.sk/uploads/8772/conversions/square.jpg" alt="Luk&aacute;&scaron; Kekel&aacute;k">                      <span class="author-name">Luk&aacute;&scaron; Kekel&aacute;k</span>
                                            </a>
                                        </footer>
                                    </div>
                                </div>
                            </article>

                        </section>
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
                                            <a href="https://www.postoj.sk/43001/bozia-podstata-je-nepochopitelna">
                                                <div class="image-wrap">
                                                    <img  src="https://www.postoj.sk/uploads/18969/conversions/square.jpg"  alt="Božsk&aacute; podstata je nepochopiteľn&aacute; ">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-7 col-md-7 mobile-text-col">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/43001/bozia-podstata-je-nepochopitelna">Božsk&aacute; podstata je nepochopiteľn&aacute; </a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item">
                                    <div class="row">
                                        <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                            <a href="https://www.postoj.sk/43108/papez-frantisek-pricestoval-do-bulharska-na-trojdnove-balkanske-turne">
                                                <div class="image-wrap">
                                                    <img  src="https://www.postoj.sk/uploads/19005/conversions/square.jpg"  alt="P&aacute;pež Franti&scaron;ek pricestoval do Bulharska. Začal trojdňov&eacute; balk&aacute;nske turn&eacute;">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-7 col-md-7 mobile-text-col">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/43108/papez-frantisek-pricestoval-do-bulharska-na-trojdnove-balkanske-turne">P&aacute;pež Franti&scaron;ek pricestoval do Bulharska. Začal trojdňov&eacute; balk&aacute;nske turn&eacute;</a>
                                                </h3>
                                            </header>
                                        </div>
                                    </div>
                                </article>
                                <article class="christianity-world-item">
                                    <div class="row">
                                        <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                            <a href="https://www.postoj.sk/42977/pravoslavie-je-kristovou-cirkvou-na-zemi">
                                                <div class="image-wrap">
                                                    <img  src="https://www.postoj.sk/uploads/18865/conversions/square.jpg"  alt="Pravosl&aacute;vie je Kristovou cirkvou na zemi">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxs-7 col-md-7 mobile-text-col">
                                            <header>
                                                <h3 class="article-title">
                                                    <a href="https://www.postoj.sk/42977/pravoslavie-je-kristovou-cirkvou-na-zemi">Pravosl&aacute;vie je Kristovou cirkvou na zemi</a>
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
                                                    <a href="https://www.postoj.sk/43051/ako-kristova-trnova-koruna-prezila-kriziacke-vojny-prevraty-a-poziar-notre-dame">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        Ako Kristova tŕňov&aacute; koruna prežila križiacke vojny, prevraty a požiar Notre Dame
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
                                                    <a href="https://www.postoj.sk/43035/kostoly-na-sri-lanke-ostavaju-zatvorene-papezske-misijne-diela-ziadaju-o-pomoc">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        Kostoly na Sr&iacute; Lanke ost&aacute;vaj&uacute; zatvoren&eacute;, P&aacute;pežsk&eacute; misijn&eacute; diela žiadaj&uacute; o pomoc
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
                                                    <a href="https://www.postoj.sk/43023/tak-vyzerali-traja-kosicki-mucenici">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        Tak vyzerali traja ko&scaron;ick&iacute; mučen&iacute;ci
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
                                                    <a href="https://www.postoj.sk/43004/papezska-nadacia-vyjadrila-znepokojenie-nad-utokmi-na-krestanov">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        P&aacute;pežsk&aacute; nad&aacute;cia vyjadrila znepokojenie nad &uacute;tokmi na kresťanov
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
                                                    <a href="https://www.postoj.sk/42988/papez-pricestuje-na-niekolko-hodin-do-severneho-macedonska">
                                                        <i class="icon icon-arrow-right-grey"></i>
                                                        P&aacute;pež pricestuje na niekoľko hod&iacute;n do Severn&eacute;ho Maced&oacute;nska
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
                            <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="1"  data-href="https://www.postoj.sk/shortnews/2479" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2479">
                                <div class="image-wrap">
                                    <img src="https://www.postoj.sk/uploads/18922/conversions/cover.jpg">
                                </div>
                                <header>
                                    <h3 class="author-link"><a href="https://www.postoj.sk/autor/adam-takac" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Adam Tak&aacute;č</a></h3>
                                    <small>• pred 3 d</small>
                                </header>
                                <div class="perex">
                                    <p>&bdquo;Nie je to dobr&yacute; preklad,&ldquo; <a href="https://svetkrestanstva.postoj.sk/38696/boh-neuvadza-do-pokusenia-vyhlasili-biskupi-a-upravili-preklad-otcenasa" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">povedal</a> koncom predminul&eacute;ho roka p&aacute;pež Franti&scaron;ek na margo ver&scaron;a &bdquo;neuveď n&aacute;s...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="https://www.postoj.sk/uploads/9300/conversions/profile.jpg" alt="Adam Tak&aacute;č">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Adam Tak&aacute;č</div><small style="margin-left: 5px;">• pred 3 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2479" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2479"  data-text="P&aacute;pež op&auml;ť vyjadril nes&uacute;hlas s prekladom prosby v modlitbe Otčen&aacute;&scaron;"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>&bdquo;Nie je to dobr&yacute; preklad,&ldquo; <a href="https://svetkrestanstva.postoj.sk/38696/boh-neuvadza-do-pokusenia-vyhlasili-biskupi-a-upravili-preklad-otcenasa" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">povedal</a> koncom predminul&eacute;ho roka p&aacute;pež Franti&scaron;ek na margo ver&scaron;a &bdquo;neuveď n&aacute;s do poku&scaron;enia&ldquo; v najzn&aacute;mej&scaron;ej&nbsp;kresťanskej modlitbe Otčen&aacute;&scaron;. Podľa hlavy Katol&iacute;ckej cirkvi vyznieva t&aacute;to formul&aacute;cia tak, že Boh vedie ľud&iacute; k&nbsp;hriechu.</p>    <p>Argent&iacute;nsky p&aacute;pež vtedy rozpr&uacute;dil kritikou prekladu Otčen&aacute;&scaron;a diskusiu o&nbsp;jeho možnej &uacute;prave.</p>    <p>&bdquo;Som to ja, kto pad&aacute;. Ale nie je to Boh, ktor&yacute; by ma postrčil do poku&scaron;enia, aby potom videl, ako som padol. (...) Ten, kto ťa vov&aacute;dza do poku&scaron;enia, je Satan. To je Satanova pr&aacute;ca,&ldquo; povedal Franti&scaron;ek vo vysielan&iacute; talianskej katol&iacute;ckej telev&iacute;zie TV 2000.</p>    <p>Podľa jeho vtedaj&scaron;&iacute;ch slov by bolo lep&scaron;ie znenie &bdquo;nenechaj n&aacute;s podľahn&uacute;ť poku&scaron;eniu&ldquo;.</p>    <p>Na tohtot&yacute;ždňovej gener&aacute;lnej audiencii na N&aacute;mest&iacute; sv. Petra sa p&aacute;pež k&nbsp;rozporupln&eacute;mu prekladu ver&scaron;a znovu <a href="https://www.vaticannews.va/sk/papez/news/2019-05/papez-frantisek-katecheza-o-otcenasi-neuved-nas-do-pokusenia.html" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">kriticky vyjadril</a>. Pr&aacute;ve t&aacute;to časť modlitby bola totiž t&eacute;mou jeho pravideln&yacute;ch katech&eacute;z o&nbsp;Otčen&aacute;&scaron;i, ktor&eacute; predn&aacute;&scaron;a v&nbsp;posledn&yacute;ch t&yacute;ždňoch pri gener&aacute;lnych audienci&aacute;ch.</p>    <p>&bdquo;Ako je zn&aacute;me, p&ocirc;vodn&eacute; gr&eacute;cke vyjadrenie obsiahnut&eacute; v evanjeli&aacute;ch je ťažk&eacute; presne vystihn&uacute;ť&nbsp;a v&scaron;etky modern&eacute; preklady tro&scaron;ku pokrivk&aacute;vaj&uacute;,&ldquo; povedal Franti&scaron;ek v&nbsp;stredaj&scaron;ej katech&eacute;ze. &bdquo;Na jednom prvku sa v&scaron;ak m&ocirc;žeme jednomyseľne zhodn&uacute;ť: pri akomkoľvek ch&aacute;pan&iacute; textu mus&iacute;me vyl&uacute;čiť, že Boh by bol protagonistom poku&scaron;en&iacute;, ktor&eacute; doliehaj&uacute; na ceste človeka. Ako keby Boh č&iacute;hal na svoje deti kladen&iacute;m n&aacute;strah a pasc&iacute;. V&yacute;klad tohto druhu je v rozpore predov&scaron;etk&yacute;m so samotn&yacute;m textom a je ďaleko od obrazu Boha, ktor&yacute; n&aacute;m Ježi&scaron; zjavil.&ldquo;</p>    <p>Podľa p&aacute;pežov&yacute;ch slov kresťania nemaj&uacute; nič do činenia so z&aacute;vistliv&yacute;m Bohom, ktor&yacute; by bol v&nbsp;konkurencii s&nbsp;človekom&nbsp;alebo by sa zab&aacute;val uv&aacute;dzan&iacute;m ho do sk&uacute;&scaron;ky.</p>    <p>&bdquo;Toto s&uacute; obrazy toľk&yacute;ch pohansk&yacute;ch bohov, nie?&ldquo; tvrd&iacute;. &bdquo;V liste apo&scaron;tola Jakuba č&iacute;tame takto: ,Nech nik v poku&scaron;en&iacute; nehovor&iacute;: &laquo;Boh ma pok&uacute;&scaron;a&raquo;. Veď Boha nemožno pok&uacute;&scaron;ať na zl&eacute; a ani on s&aacute;m nikoho nepok&uacute;&scaron;a&lsquo;&nbsp;(1,13). Pr&aacute;ve naopak: Otec nie je p&ocirc;vodcom zla, nijak&eacute;mu synovi, ktor&yacute; pros&iacute; o rybu, ned&aacute; hada (pozri Lk 11,11) &ndash; ako uč&iacute; Ježi&scaron; &ndash; a&nbsp; keď sa zlo objav&iacute; v živote človeka, bojuje po jeho boku, aby mohol byť osloboden&yacute;. Je to Boh, ktor&yacute; vždy bojuje za n&aacute;s, nie proti n&aacute;m. Otec! Toto je ten zmysel, v akom sa modl&iacute;me Otčen&aacute;&scaron;,&ldquo; dodal Franti&scaron;ek.</p>    <p><em>Foto: TASR/AP</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="https://www.postoj.sk/uploads/18922/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="2"  data-href="https://www.postoj.sk/shortnews/2478" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2478">
                                <div class="image-wrap">
                                    <img src="https://www.postoj.sk/uploads/18901/conversions/cover.jpg">
                                </div>
                                <header>
                                    <h3 class="author-link"><a href="https://www.postoj.sk/autor/lukas-obsitnik" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</a></h3>
                                    <small>• pred 3 d</small>
                                </header>
                                <div class="perex">
                                    <p>Americk&yacute; novin&aacute;r Rod Dreher, autor knihy <a href="https://obchod.postoj.sk/produkt/benediktova-volba/6" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link"><em>Benediktova voľba</em></a>, je v s&uacute;časnosti v Bratislave na Hanusov&yacute;ch dňoch. Na...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="https://www.postoj.sk/uploads/9304/conversions/profile.jpg" alt="Luk&aacute;&scaron; Ob&scaron;itn&iacute;k">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Luk&aacute;&scaron; Ob&scaron;itn&iacute;k</div><small style="margin-left: 5px;">• pred 3 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2478" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2478"  data-text="Rod Dreher: Pri&scaron;iel som sa učiť z va&scaron;ich sk&uacute;senost&iacute; z čias komunizmu"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Americk&yacute; novin&aacute;r Rod Dreher, autor knihy <a href="https://obchod.postoj.sk/produkt/benediktova-volba/6" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link"><em>Benediktova voľba</em></a>, je v s&uacute;časnosti v Bratislave na Hanusov&yacute;ch dňoch. Na svojom blogu v prest&iacute;žnom magaz&iacute;ne <em>The American Conservative</em>&nbsp;p&iacute;&scaron;e&nbsp;kr&aacute;tke postrehy zo svojej n&aacute;v&scaron;tevy.</p>    <p><a href="https://www.theamericanconservative.com/dreher/may-day-in-bratislava-communism/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">V prvom texte</a> hovor&iacute; o svojom stretnut&iacute; s Vladim&iacute;rom Palkom, americk&yacute;m čitateľom približuje pr&iacute;behy&nbsp;Vladim&iacute;ra Jukla, Silvestra Krčm&eacute;ryho a Tomislava Kolakoviča a&nbsp;p&iacute;&scaron;e aj o Sviečkovej&nbsp;manifest&aacute;cii&nbsp;(pridal dokonca aj videoz&aacute;znam zo z&aacute;kroku &Scaron;tB). Palko ho zaviedol na Hviezdoslavovo n&aacute;mestie na miesto, kde spolu s tis&iacute;ckami ďal&scaron;&iacute;ch st&aacute;l počas manifest&aacute;cie. Nesk&ocirc;r nav&scaron;t&iacute;vil aj Dev&iacute;n a na blogu zverejnil fotografie z pam&auml;tn&iacute;ka Br&aacute;na slobody, ktor&yacute; pripom&iacute;na &scaron;tyri stovky ľud&iacute;, ktor&iacute; pri&nbsp;pokuse o &uacute;tek na Z&aacute;pad zomreli n&aacute;silnou smrťou. &bdquo;Tak&yacute;to je pohľad od pam&auml;tn&iacute;ka,&ldquo; p&iacute;&scaron;e pri jednej fotke. &bdquo;Na druhom brehu je Rak&uacute;sko. Železn&aacute; opona prech&aacute;dzala prostriedkom rieky. Takto bl&iacute;zko bola sloboda. &Scaron;tyristo ľud&iacute; zomrelo pri pokuse dostať sa&nbsp;na slobodu. Dnes je ich pam&auml;tn&yacute; deň.&ldquo;</p>    <p><a href="https://www.theamericanconservative.com/dreher/coffee-timo-petra-bratislava-communism/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">V druhom texte</a> p&iacute;&scaron;e o svojom stretnut&iacute; s mlad&yacute;m fotografom Timotejom Križkom a jeho manželkou Petrou. Timotej mu&nbsp;rozpr&aacute;va o svojom dokumente obet&iacute; komunizmu, hovoria spolu, prečo je ich pamiatka d&ocirc;ležit&aacute;,&nbsp;a s Petrou mu približuj&uacute; s&uacute;časn&eacute; spoločensk&eacute; diskusie na Slovensku, v ktor&yacute;ch s&uacute; katol&iacute;ci zo strany liber&aacute;lnych m&eacute;di&iacute; často vytl&aacute;čan&iacute; na okraj. &bdquo;My Slov&aacute;ci vn&iacute;mame len dve možnosti: &iacute;sť na Z&aacute;pad alebo &iacute;sť na V&yacute;chod,&ldquo; hovor&iacute; mu Timo. &bdquo;Veľa ľud&iacute; sa V&yacute;chodu&nbsp;ob&aacute;va pre historick&eacute; sk&uacute;senosti s Ruskom, preto sa obraciame na Z&aacute;pad a k liberalizmu, slovensk&aacute; spoločnosť vn&iacute;ma, že odtiaľ prich&aacute;dza n&aacute;dej.&ldquo; &bdquo;Z&aacute;padn&eacute; spoločnosti s&uacute; v&scaron;ak vo veľk&yacute;ch probl&eacute;moch,&ldquo; oponuje mu Dreher. N&aacute;sledne sa spolu rozpr&aacute;vaj&uacute; o tom, prečo sa gener&aacute;cia rodičov Timoteja a Petry c&iacute;ti ako &bdquo;straten&aacute; gener&aacute;cia&ldquo;, o d&ocirc;vodoch nostalgie za komunizmom, diskutuj&uacute; o vn&iacute;man&iacute; slobody u n&aacute;s a v USA po &uacute;tokoch z 11. septembra 2001. Je to veľmi zauj&iacute;mav&eacute;.</p>    <p>Rod Dreher v s&uacute;časnosti p&iacute;&scaron;e knihu nadv&auml;zuj&uacute;cu na <em>Benediktovu voľbu</em>, v ktorej chce využiť pr&iacute;behy obet&iacute; komunizmu zo strednej Eur&oacute;py. Ch&aacute;pe, že dne&scaron;n&aacute; situ&aacute;cia je omnoho miernej&scaron;ia, no tak&yacute;to uhol pohľadu považuje za d&ocirc;ležit&yacute;. V diskusii na BHD okrem in&eacute;ho zd&ocirc;raznil, že sa na Slovensko pri&scaron;iel učiť z na&scaron;ich&nbsp;sk&uacute;senost&iacute; z čias komunizmu.</p>    <p>Svoj blog zakončil takto: &bdquo;Ľudia, ktor&yacute;ch som stretol tu na Slovensku, s&uacute; skutočne zauj&iacute;mav&iacute;. Ťažko uveriť, že som tu len necel&eacute; dva dni. V dne&scaron;nom programe m&aacute;m&nbsp;stretnutie s historikom tajnej cirkvi, n&aacute;v&scaron;tevu&nbsp;miesta, kde sa tlačil samizdat, potom stretnutie s ďal&scaron;&iacute;mi dvoma hlavn&yacute;mi l&iacute;drami tajnej cirkvi. Nedok&aacute;žem dostatočne poďakovať svojim hostiteľom z&nbsp;festivalu <a href="https://www.hanusovedni.sk/" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">Bratislavsk&eacute; Hanusov&eacute;&nbsp;dni</a>, ktor&yacute;&nbsp;organizuj&uacute; katol&iacute;cki &scaron;tudenti a absolventi, za sprostredkovanie t&yacute;chto stretnut&iacute;. Slov&aacute;ci, predov&scaron;etk&yacute;m slovensk&iacute; katol&iacute;ci, s&uacute; presvedčen&iacute;, že pr&iacute;beh utrpenia ich n&aacute;roda za vl&aacute;dy komunizmu a jeho hrdinsk&yacute; odpor sa na&nbsp;Z&aacute;pade prehliada. Maj&uacute; pravdu.&ldquo;</p>    <p><em>Foto: Rod Dreher počas diskusie na BHD, zdroj:&nbsp;facebook.com/BratislavskeHanusoveDni</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="https://www.postoj.sk/uploads/18901/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls   show-ad "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="3"  data-href="https://www.postoj.sk/shortnews/2477" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2477">
                                <div class="image-wrap">
                                    <img src="https://www.postoj.sk/uploads/18883/conversions/cover.jpg">
                                </div>
                                <header>
                                    <h3 class="author-link"><a href="https://www.postoj.sk/autor/lukas-krivosik" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a></h3>
                                    <small>• pred 4 d</small>
                                </header>
                                <div class="perex">
                                    <p>V&nbsp;r&aacute;mci fin&aacute;lov&eacute;ho večera, ktor&yacute; v&nbsp;stredu odvysielala RTVS k&nbsp;ankete Najv&auml;č&scaron;&iacute; Slov&aacute;k, bola vyhl&aacute;sen&aacute; trojica, ktor&aacute; z&iacute;skala najviac hlasov. Na 3. mieste...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="https://www.postoj.sk/uploads/9793/conversions/profile.jpg" alt="Luk&aacute;&scaron; Krivo&scaron;&iacute;k">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</div><small style="margin-left: 5px;">• pred 4 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2477" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2477"  data-text="Anketa: Najv&auml;č&scaron;&iacute; Slov&aacute;k je Milan Rastislav &Scaron;tef&aacute;nik"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>V&nbsp;r&aacute;mci fin&aacute;lov&eacute;ho večera, ktor&yacute; v&nbsp;stredu odvysielala RTVS k&nbsp;ankete Najv&auml;č&scaron;&iacute; Slov&aacute;k, bola vyhl&aacute;sen&aacute; trojica, ktor&aacute; z&iacute;skala najviac hlasov. Na 3. mieste skončil katol&iacute;cky kňaz a&nbsp;charitat&iacute;vny pracovn&iacute;k Anton Srholec. Na 2. mieste Ľudov&iacute;t &Scaron;t&uacute;r. A&nbsp;na 1. mieste sa umiestnil Milan Rastislav &Scaron;tef&aacute;nik.</p>    <p>&Uacute;primne, v&yacute;sledok ma neprekvapil. V&nbsp;posledn&yacute;ch t&yacute;ždňoch som sa ponoril do &Scaron;tef&aacute;nikovho života a&nbsp;preč&iacute;tal som niekoľko kn&iacute;h v&nbsp;r&aacute;mci pr&iacute;pravy pre m&ocirc;j <a href="https://www.postoj.sk/42877/preco-stefanik-pisal-masarykovi-po-cesky-a-co-vycital-amerike-a-rusku" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">nedeľn&yacute; čl&aacute;nok</a> a&nbsp;n&aacute;&scaron; <a href="https://www.postoj.sk/42938/dve-minuty-a-lietadlo-so-stefanikom-by-pristalo" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">dne&scaron;n&yacute; rozhovor</a>. Bez p&aacute;tosu - bol to povzn&aacute;&scaron;aj&uacute;ci pocit robiť na tejto t&eacute;me.</p>    <p>V&scaron;etci nejak&yacute; z&aacute;kladn&yacute; prehľad o&nbsp;&Scaron;tef&aacute;nikovom živote m&aacute;me. No keď sa do neho človek naplno ponor&iacute;, nem&ocirc;že prestať žasn&uacute;ť.</p>    <p>&Scaron;tef&aacute;nik v&nbsp;sebe sp&aacute;ja nesmiernu v&ocirc;ľu, &scaron;irok&yacute; rozhľad a&nbsp;schopnosť mať v&yacute;sledky, s&nbsp;romantikou, odvahou a&nbsp;dobrodružstvom. A to v&scaron;etko zapojil pred storoč&iacute;m do zdanlivo nemožnej misie: oslobodenia Slov&aacute;kov.</p>    <p>On bol popravde ten najv&auml;č&scaron;&iacute; spomedzi n&aacute;s.</p>    <p><em>Milan Rastislav &Scaron;tef&aacute;nik -&nbsp;Reprofoto TASR</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="https://www.postoj.sk/uploads/18883/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>

                        </div>                                       <div class="col-xxs-12 col-md-6 eq-me  border-left ">
                            <article class="short-news-item  with-img     track-me-pls  "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="4"  data-href="https://www.postoj.sk/shortnews/2476" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2476">
                                <div class="image-wrap">
                                    <img src="https://www.postoj.sk/uploads/18867/conversions/cover.jpg">
                                </div>
                                <header>
                                    <h3 class="author-link"><a href="https://www.postoj.sk/autor/pavol-rabara-1" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Pavol R&aacute;bara</a></h3>
                                    <small>• pred 4 d</small>
                                </header>
                                <div class="perex">
                                    <p>Organiz&aacute;tori Bratislavsk&yacute;ch Hanusov&yacute;ch dn&iacute; upozorňuj&uacute;, že hoci podľa inform&aacute;ci&iacute; na&nbsp;port&aacute;li&nbsp;ticketmedia&nbsp;s&uacute; niektor&eacute; akcie festivalu už vypredan&eacute;, neznamen&aacute; to, že sa na...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="header-text" style=" margin-left:0px; ">
                                            <div class="author-name">Pavol R&aacute;bara</div><small style="margin-left: 5px;">• pred 4 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2476" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2476"  data-text="BHD nie s&uacute; &uacute;plne vypredan&eacute;"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Organiz&aacute;tori Bratislavsk&yacute;ch Hanusov&yacute;ch dn&iacute; upozorňuj&uacute;, že hoci podľa inform&aacute;ci&iacute; na&nbsp;port&aacute;li&nbsp;ticketmedia&nbsp;s&uacute; niektor&eacute; akcie festivalu už vypredan&eacute;, neznamen&aacute; to, že sa na diskusiu či predn&aacute;&scaron;ku nedostanete.&nbsp;&nbsp;</p>    <p>Ist&yacute; počet l&iacute;stkov totiž držia pre majiteľov permanentiek, ale iba do 15 min&uacute;t pred začat&iacute;m akcie. Je preto veľk&aacute; &scaron;anca, že aj na ofici&aacute;lne vypredan&yacute;ch eventoch n&aacute;jdete miesto. Stač&iacute; pr&iacute;sť aspoň &scaron;tvrťhodinu&nbsp;pred ich začat&iacute;m a&nbsp;sp&yacute;tať sa organiz&aacute;torov.&nbsp;</p>    <p>Do konca BHD <a href="https://www.hanusovedni.sk/program/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">zost&aacute;va</a> e&scaron;te viacero zauj&iacute;mav&yacute;ch deb&aacute;t, dnes vyst&uacute;pi napr&iacute;klad oxfordsk&yacute; profesor John Finnis a americk&yacute; publicita a spisovateľ Rod Dreher (na sn&iacute;mke Postoja).&nbsp;</p>
                                    </div>

                                    <div class="article-image">
                                        <img src="https://www.postoj.sk/uploads/18867/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls  "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="5"  data-href="https://www.postoj.sk/shortnews/2475" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2475">
                                <div class="image-wrap">
                                    <img src="https://www.postoj.sk/uploads/18821/conversions/cover.jpg">
                                </div>
                                <header>
                                    <h3 class="author-link"><a href="https://www.postoj.sk/autor/jaroslav-daniska" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Jaroslav Dani&scaron;ka</a></h3>
                                    <small>• pred 6 d</small>
                                </header>
                                <div class="perex">
                                    <p>Mysl&iacute;m, že Williamovi F. Buckleymu (na obr.) by sa ten n&aacute;pad ohromne p&aacute;čil: Na univerzite Yale vznikla Buckleyho spoločnosť, ktor&aacute;...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="https://www.postoj.sk/uploads/9387/conversions/profile.jpg" alt="Jaroslav Dani&scaron;ka">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Jaroslav Dani&scaron;ka</div><small style="margin-left: 5px;">• pred 6 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2475" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2475"  data-text="Klub vyp&iacute;skan&yacute;ch &bdquo;fa&scaron;istov&ldquo;"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Mysl&iacute;m, že Williamovi F. Buckleymu (na obr.) by sa ten n&aacute;pad ohromne p&aacute;čil: Na univerzite Yale vznikla Buckleyho spoločnosť, ktor&aacute; poz&yacute;va na vyst&uacute;penia host&iacute;, ktor&yacute;ch univerzitn&iacute; &scaron;tudenti vyp&iacute;skali, pokrikovali na nich, že s&uacute; fa&scaron;isti či nacisti, pritom na to nebol žiadny d&ocirc;vod.</p>    <p>Port&aacute;l časopisu National Review, ktor&yacute; Buckeley založil a dlh&eacute; desaťročia viedol, <a href="https://www.nationalreview.com/2019/04/henry-kissinger-shouted-down-at-nyu-addresses-yales-wfb-society/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">priniesol</a> naposledy čl&aacute;nok o vyp&iacute;skanom Henrym Kissingerovi, 95-ročnom p&ocirc;vodom nemeckom Židovi, ktor&eacute;mu tiež univerzitn&iacute; nevzdelanci nad&aacute;vali do nacistov a fa&scaron;istov. Pritom Kissiger proti nacistom s&aacute;m bojoval, jeho rodina z Nemecka predt&yacute;m u&scaron;la. Buckleyho spoločnosť ho pozvala medzi seba, je to vyberan&aacute; spoločnosť, ako dokazuj&uacute; aj ďal&scaron;ie men&aacute;: George Will, Charles Murray, Raymond Kelly či Peter Thiel. Ver&iacute;m, že pozv&aacute;nku m&aacute; na ceste aj Ryszard Legutko. Viac o tejto spoločnosti n&aacute;jdete na <a href="https://www.buckleyprogram.com/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">ich webovej str&aacute;nke</a>, dodal by som, že tento vtipn&yacute; a origin&aacute;lny pokus p&iacute;&scaron;e posmrtne posledn&uacute; kapitolu k Buckleyho knižke God and Man at Yale.</p>    <p><em>Foto: YouTube.com</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="https://www.postoj.sk/uploads/18821/conversions/cover.jpg">
                                    </div>
                                </div>
                            </div>


                            <article class="short-news-item  with-img     track-me-pls  "  data-category="home_kratke-spravy-dolne-hover" data-action="mouseover" data-label="position" data-value="6"  data-href="https://www.postoj.sk/shortnews/2474" data-real-href="https://www.postoj.sk/kratke-spravy-redakcie/2474">
                                <div class="image-wrap">
                                    <img src="https://www.postoj.sk/uploads/18807/conversions/cover.jpg">
                                </div>
                                <header>
                                    <h3 class="author-link"><a href="https://www.postoj.sk/autor/jaroslav-daniska" class="track-me-pls" data-category="home_kratke-spravy-dolne-autor" data-action="click">Jaroslav Dani&scaron;ka</a></h3>
                                    <small>• pred 6 d</small>
                                </header>
                                <div class="perex">
                                    <p>Lidov&eacute; noviny <a href="https://www.lidovenoviny.cz/nahled.aspx?d=27.04.2019&amp;e=LN-PRAHA&amp;id=8245505" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">priniesli</a> zauj&iacute;mav&yacute; text o proteste umelca Domenica Esposita z Bostonu, ktor&yacute; minul&yacute; rok pred...
                                </div>


                            </article>
                            <div style="display: none;">
                                <div class="kd-qtip-arrow"></div>
                                <div style="overflow-x:hidden; overflow-y:auto; max-height:490px;">
                                    <header class="clearfix">
                                        <div class="image-wrap show">
                                            <img src="https://www.postoj.sk/uploads/9387/conversions/profile.jpg" alt="Jaroslav Dani&scaron;ka">
                                        </div>
                                        <div class="header-text" style="">
                                            <div class="author-name">Jaroslav Dani&scaron;ka</div><small style="margin-left: 5px;">• pred 6 d</small>
                                        </div>
                                    </header>

                                    <div class="article-social-buttons">
                                        <div class="social-btn">
                                            <div class="fb-like" data-href="https://www.postoj.sk/kratke-spravy-redakcie/2474" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">
                                            </div>
                                        </div>
                                        <div class="social-btn">
                                            <a href="https://twitter.com/intent/tweet?url=https://www.postoj.sk/kratke-spravy-redakcie/2474"  data-text="Lyžička ako protest"  class="twitter-share-button">Tweet</a>
                                        </div>
                                    </div>

                                    <div class="article-text">
                                        <p>Lidov&eacute; noviny <a href="https://www.lidovenoviny.cz/nahled.aspx?d=27.04.2019&amp;e=LN-PRAHA&amp;id=8245505" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">priniesli</a> zauj&iacute;mav&yacute; text o proteste umelca Domenica Esposita z Bostonu, ktor&yacute; minul&yacute; rok pred s&iacute;dlom farmaceutickej firmy Purdue Pharma in&scaron;taloval 360-kilogramov&uacute; hlin&iacute;kov&uacute; lyžičku, ktor&aacute; m&aacute; evokovať lyžičku, ak&uacute; použ&iacute;vaj&uacute; narkomani na pr&iacute;pravu heroinu.</p>    <p>Vo febru&aacute;ri tohto roku na Rhode Islande tento protest zopakoval pred s&iacute;dlom ďal&scaron;ej farmafirmy Rhodes Pharmaceuticals, ktor&aacute; zar&aacute;ba na predaji upokojuj&uacute;cich&nbsp;liekov, ktor&eacute; s&uacute; sp&aacute;jan&eacute; s vypuknut&iacute;m opi&aacute;tovej epid&eacute;mie v Amerike. Esposito sa angažuje aj kv&ocirc;li tomu, že jeho brat Danny, ktor&eacute;mu boli po &uacute;raze predp&iacute;san&eacute; upokojuj&uacute;ce lieky s n&aacute;zvom OxyContin, ktor&eacute; nemali vytv&aacute;rať z&aacute;vilosť, boli, naopak, prudko n&aacute;vykov&eacute;&nbsp;a množstvo ich už&iacute;vateľov (podobne ako jeho brat) z nich pre&scaron;li na hero&iacute;n, čo pre jeho brata a mnoh&yacute;ch ďal&scaron;&iacute;ch znamenalo smrť.</p>    <p>V USA zomrie podľa Lidov&yacute;ch nov&iacute;n denne na pred&aacute;vkovanie opi&aacute;tmi 130 ľud&iacute;, čo je viac, ako je počet obet&iacute; sp&aacute;jan&yacute;ch s voľnou držbou streľn&yacute;ch zbran&iacute; (108 denne). Umelec sa tak&yacute;mito protestami <a href="https://www.stamfordadvocate.com/business/article/Purdue-Pharma-spoon-sculpture-protest-reprised-in-13598545.php" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">snaž&iacute; upozorniť</a> na to, že prebiehaj&uacute;ce s&uacute;dy proti firm&aacute;m, ako je t&aacute;, ktor&aacute; patr&iacute; rodine Sacklerov&yacute;ch, nie s&uacute; efekt&iacute;vne, že super-bohat&eacute; firmy st&aacute;le ne&uacute;merne zar&aacute;baj&uacute; miliardy dol&aacute;rov a obete prib&uacute;daj&uacute;, že pr&aacute;vna situ&aacute;cia st&aacute;le nahr&aacute;va pred&aacute;torom a nechr&aacute;ni obete. A to aj napriek tomu, že napr. na rodinu Sacklerov&yacute;ch je podan&yacute;ch vy&scaron;e 1 600 žal&ocirc;b a koncom marca prehrali s&uacute;d, ktor&yacute; im k&aacute;že zaplatiť 240 mil. eur ako od&scaron;kodn&eacute; rodin&aacute;m obet&iacute;.</p>    <p>Protestu sa venuje aj <a href="http://www.theopioidspoonproject.com/press/" target="_blank" class="track-me-pls" data-category="home_kratke-spravy-dolne-exit-link">&scaron;pecializovan&aacute; webstr&aacute;nka</a>.</p>    <p><em>Foto: YouTube</em></p>
                                    </div>

                                    <div class="article-image">
                                        <img src="https://www.postoj.sk/uploads/18807/conversions/cover.jpg">
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
                                                    <a href="https://www.postoj.sk/43113/s-biblickymi-jazykmi-blizsie-k-boziemu-slovu">S biblick&yacute;mi jazykmi bliž&scaron;ie k Božiemu slovu</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/centrum-pre-studium-biblickeho-a-blizkovychodneho-sveta-centrum-pre-studium-biblickeho-a-blizkovychodneho-sveta" class="avatar avatar-little">
                                                        <img src="https://www.postoj.sk/uploads/11870/conversions/square.jpg" alt="Centrum pre &scaron;t&uacute;dium biblick&eacute;ho a bl&iacute;zkov&yacute;chodn&eacute;ho sveta">

                                                        <span class="author-name">Centrum pre &scaron;t&uacute;dium biblick&eacute;ho a bl&iacute;zkov&yacute;chodn&eacute;ho sveta</span>
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
                                                    <a href="https://www.postoj.sk/43132/glosa-na-zamyslenie">Glosa na zamyslenie...</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/robert-dick" class="avatar avatar-little">
                                                        <img src="https://www.postoj.sk/uploads/16154/conversions/square.jpg" alt="Robert Dick">

                                                        <span class="author-name">Robert Dick</span>
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
                                                    <a href="https://www.postoj.sk/43130/spomienky-zo-zivota-mamy-marty-babalovej-23-4-2019">Spomienky zo života mamy Marty Bab&aacute;lovej&nbsp;(&dagger; 23. 4. 2019)</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/kolektiv-autorov-deti-a-vnucata-marty-babalovej-kolektiv-autorov-deti-a-vnucata-marty-babalovej" class="avatar avatar-little">
                                                        <img src="https://www.postoj.sk/uploads/19020/conversions/square.jpg" alt="Deti a vn&uacute;čat&aacute; Marty Bab&aacute;lovej">

                                                        <span class="author-name">Deti a vn&uacute;čat&aacute; Marty Bab&aacute;lovej</span>
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
                                                        <a href="https://www.postoj.sk/autor/anton-sumichrast ">
                                                            Anton &Scaron;umichrast
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43124/mesiac-lasky-hokeja-a-eurovolieb-alebo-kto-ma-najsilnejsiu-zostavu">Mesiac l&aacute;sky, hokeja a eurovolieb,  alebo kto m&aacute; najsilnej&scaron;iu zostavu? </a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/juraj-vnencak ">
                                                            Juraj Vnenč&aacute;k
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43119/europa-aj-v-tvojich-rukach">Eur&oacute;pa aj v tvojich ruk&aacute;ch</a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/juraj-kriz ">
                                                            Juraj Kr&iacute;ž
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43117/dalsia-obet-metoo-sa-vola-bond-james-bond"> Ďal&scaron;ia obeť #MeToo sa vol&aacute;... Bond, James Bond!</a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/miroslav-klobucnik ">
                                                            Miroslav Klobučn&iacute;k
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43112/eurovolebny-bonus-andyho-hryca">Eurovolebn&yacute; bonus Andyho Hryca</a></h3>
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
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43097/kto-nam-nanutil-korupciu-teolog-carlotti-versus-arcibiskup-zvolensky">Kto n&aacute;m nan&uacute;til korupciu - teol&oacute;g Carlotti versus arcibiskup Zvolensk&yacute;</a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/ema-pagacova ">
                                                            Ema Pag&aacute;čov&aacute;
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43087/nestrielajte-na-otca-kuffu-otec-kuffa-nestrielajte-na-nas">Nestrieľajte na otca Kuffu, otec Kuffa nestrieľajte na n&aacute;s</a></h3>
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
                                                    <a href="https://www.postoj.sk/43087/nestrielajte-na-otca-kuffu-otec-kuffa-nestrielajte-na-nas">Nestrieľajte na otca Kuffu, otec Kuffa nestrieľajte na n&aacute;s</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/ema-pagacova" class="avatar avatar-little">

                                                        <span class="author-name">Ema Pag&aacute;čov&aacute;</span>
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
                                                    <a href="https://www.postoj.sk/42978/ad-vladimir-palko-americka-zakladna-na-slovensku-a-geopolitika">Ad: Vladim&iacute;r Palko - Americk&aacute; z&aacute;kladňa na Slovensku a&nbsp;geopolitika</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/jaroslav-nad" class="avatar avatar-little">
                                                        <img src="https://www.postoj.sk/uploads/18989/conversions/square.jpg" alt="Jaroslav Naď">

                                                        <span class="author-name">Jaroslav Naď</span>
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
                                                    <a href="https://www.postoj.sk/42910/bude-arcibiskup-zvolensky-novym-slovenskym-kardinalom">Bude arcibiskup Zvolensk&yacute; nov&yacute;m slovensk&yacute;m kardin&aacute;lom?</a>
                                                </h3>
                                            </header>


                                            <footer>
                                                <h3 class="author-link">
                                                    <a href="https://www.postoj.sk/autor/lenka-nalevankova" class="avatar avatar-little">
                                                        <img src="https://www.postoj.sk/uploads/10004/conversions/square.jpg" alt="Lenka Nalevankov&aacute; Mi&scaron;enkov&aacute;">

                                                        <span class="author-name">Lenka Nalevankov&aacute; Mi&scaron;enkov&aacute;</span>
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
                                                        <a href="https://www.postoj.sk/autor/viliam-oberhauser ">
                                                            Viliam Oberhauser
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/42949/ach-ten-nestastny-sex-a-dokedy-budu-trestne-organy-necinne">Ach ten ne&scaron;ťastn&yacute; sex a dokedy bud&uacute; trestn&eacute; org&aacute;ny nečinn&eacute; ?</a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/lukas-martiska ">
                                                            Luk&aacute;&scaron; Marti&scaron;ka
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43045/ako-krestanska-unia-podporuje-kotlebu-kollara-a-liberalne-strany">Ako Kresťansk&aacute; &uacute;nia podporuje Kotlebu, Koll&aacute;ra a liber&aacute;lne strany  </a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/katarina-mikulova ">
                                                            Katar&iacute;na Mikulov&aacute;
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/42765/odkaz-pre-knazov">Odkaz pre kňazov.</a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/juraj-kriz ">
                                                            Juraj Kr&iacute;ž
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/42903/styri-zle-spravy-pre-vladimira-palka">&Scaron;tyri zl&eacute; spr&aacute;vy pre Vladim&iacute;ra Palka </a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/branislav-skripek-1 ">
                                                            Branislav &Scaron;kripek
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/42976/slovenske-zdravotnictvo-zbavit-sa-pacienta-ako-sutaz">Slovensk&eacute; zdravotn&iacute;ctvo: zbaviť sa pacienta ako s&uacute;ťaž</a></h3>
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
                                                        <a href="https://www.postoj.sk/autor/samuel-miklas ">
                                                            Samuel Mikl&aacute;&scaron;
                                                        </a>
                                                    </h3>
                                                    <div class="center">
                                                        <div class="center-me">
                                                            <h3 class="article-title"><a href="https://www.postoj.sk/43070/neuved-nas-do-pokusenia">Neuveď n&aacute;s do poku&scaron;enia?</a></h3>
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
            <div class="col-xxs-12 col-md-9-minus-compensation eq-me">
                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://obchod.postoj.sk" class="track-me-pls" data-category="shop_banner_bottom-title" data-action="click">Naše knihy</a>
                        </h2>
                    </header>

                    <div class="row">
                        <div class="col-xxs-12 col-md-8 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big  border-right  book-item book-item book-item">
                                <div class="row category-article-item-big-row">

                                    <div class="category-article-item-big-left mobile-img-col">
                                        <a href="https://obchod.postoj.sk/balik/bud-kde-si-do-boja-s-ruzencom"  class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="1" >
                                            <img src="https://www.postoj.sk/uploads/16690/conversions/detail.png" alt="Buď, kde si + Do boja s ružencom">
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
                        <div class="col-xxs-12 col-md-4 right-col mobile-text-col">
                            <article class="category-article-item book-item  border-bottom ">
                                <div class="row">
                                    <div class="col-xxs-5 left-col mobile-img-col">
                                        <a href="https://obchod.postoj.sk/produkt/klub-nerozbitnych-deti/27"   class="track-me-pls" data-category="shop_banner_bottom" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img src="https://www.postoj.sk/uploads/13296/conversions/variation_thumb.png" alt="Klub nerozbitn&yacute;ch det&iacute;">
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
                                                <img src="https://www.postoj.sk/uploads/16520/conversions/variation_thumb.png" alt="Cesta na Z&aacute;pad">
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

                <section class="category-articles double-border-bottom">
                    <header class="triangle">
                        <h2 class="section-title">
                            <a href="https://www.postoj.sk/komentare-nazory" class="track-me-pls" data-category="home_spodne-clanky-kategoria" data-action="click">Koment&aacute;re a n&aacute;zory</a>
                        </h2>
                    </header>
                    <div class="row">
                        <div class="col-xxs-12 col-md-6 left-col mobile-img-col">
                            <article class="category-article-item category-article-item-big border-right">
                                <a href="https://www.postoj.sk/43131/europa-sa-potichu-pripravuje-na-to-ze-taliansko-buchne"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="https://www.postoj.sk/uploads/19032/conversions/square.jpg"  alt="Eur&oacute;pa sa potichu pripravuje na to, že Taliansko buchne">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/43131/europa-sa-potichu-pripravuje-na-to-ze-taliansko-buchne"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Eur&oacute;pa sa potichu pripravuje na to, že Taliansko buchne</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Ak&yacute; bude scen&aacute;r, keď sa nahlas povie, že Taliansko so svoj&iacute;m dlhom už nem&ocirc;že ďalej fungovať.</p>
                                    <p class="show-kd-mobile">
                                        Ak&yacute; bude scen&aacute;r, keď sa nahlas povie, že Taliansko so svoj&iacute;m dlhom už nem&ocirc;že ďalej fungovať.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/fero-mucka" class="author-link">Fero M&uacute;čka</a>
                                    <small>• 06. 05. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43024/musime-ju-pocuvat"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18913/conversions/square.jpg"  alt="Mus&iacute;me ju poč&uacute;vať">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43024/musime-ju-pocuvat"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Mus&iacute;me ju poč&uacute;vať</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/zuzana-hanusova" class="author-link">Zuzana Hanusov&aacute;</a>
                                            <small>• 02. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43007/fico-s-kotlebom-vladnut-nechce-kalkuluje-s-nim-inak"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18897/conversions/square.jpg"  alt="Fico s Kotlebom vl&aacute;dnuť nechce, kalkuluje s n&iacute;m inak">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43007/fico-s-kotlebom-vladnut-nechce-kalkuluje-s-nim-inak"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Fico s Kotlebom vl&aacute;dnuť nechce, kalkuluje s n&iacute;m inak</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/jozef-majchrak" class="author-link">Jozef Majchr&aacute;k</a>
                                            <small>• 02. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42957/skutocne-len-utopicky-zapas-redakcna-polemika"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18841/conversions/square.jpg"  alt="Skutočne len utopick&yacute; z&aacute;pas? (Redakčn&aacute; polemika)">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42957/skutocne-len-utopicky-zapas-redakcna-polemika"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Skutočne len utopick&yacute; z&aacute;pas? (Redakčn&aacute; polemika)</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/lukas-kekelak" class="author-link">Luk&aacute;&scaron; Kekel&aacute;k</a>
                                            <small>• 30. 04. 2019</small>
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
                                <a href="https://www.postoj.sk/42932/vitaz-pokazenej-debaty-o-fasizme"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="https://www.postoj.sk/uploads/18817/conversions/square.jpg"  alt="V&iacute;ťaz pokazenej debaty o fa&scaron;izme">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/42932/vitaz-pokazenej-debaty-o-fasizme"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >V&iacute;ťaz pokazenej debaty o fa&scaron;izme</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Dne&scaron;n&yacute; s&uacute;d nemohol dopadn&uacute;ť dobre.</p>
                                    <p class="show-kd-mobile">
                                        Dne&scaron;n&yacute; s&uacute;d nemohol dopadn&uacute;ť dobre.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/jaroslav-daniska" class="author-link">Jaroslav Dani&scaron;ka</a>
                                    <small>• 29. 04. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42895/ako-verit-v-system-ktory-za-tridsat-rokov-nedokaze-postavit-nemocnicu"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18773/conversions/square.jpg"  alt="Ako veriť v syst&eacute;m, ktor&yacute; za tridsať rokov nedok&aacute;že postaviť nemocnicu?">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42895/ako-verit-v-system-ktory-za-tridsat-rokov-nedokaze-postavit-nemocnicu"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Ako veriť v syst&eacute;m, ktor&yacute; za tridsať rokov nedok&aacute;že postaviť nemocnicu?</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/jozef-majchrak" class="author-link">Jozef Majchr&aacute;k</a>
                                            <small>• 29. 04. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42844/talianski-populisti-isli-navzdy-porazit-chudobu-len-im-to-akosi-nevychadza"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18715/conversions/square.jpg"  alt="Talianski populisti i&scaron;li navždy poraziť chudobu, len im to akosi nevych&aacute;dza">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42844/talianski-populisti-isli-navzdy-porazit-chudobu-len-im-to-akosi-nevychadza"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Talianski populisti i&scaron;li navždy poraziť chudobu, len im to akosi nevych&aacute;dza</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/martin-leidenfrost" class="author-link">Martin Leidenfrost</a>
                                            <small>• 26. 04. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42831/trump-vytiahol-proti-demokratom-vlastnu-zbran"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18705/conversions/square.jpg"  alt="Trump vytiahol proti mest&aacute;m demokratov ich vlastn&uacute; zbraň">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42831/trump-vytiahol-proti-demokratom-vlastnu-zbran"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Trump vytiahol proti mest&aacute;m demokratov ich vlastn&uacute; zbraň</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/lukas-kekelak" class="author-link">Luk&aacute;&scaron; Kekel&aacute;k</a>
                                            <small>• 25. 04. 2019</small>
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
                                <a href="https://www.postoj.sk/43105/uz-zase-cestujem-miroslav-bielik"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="https://www.postoj.sk/uploads/19003/conversions/square.jpg"  alt="Už zase cestujem (Miroslav Bielik)">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/43105/uz-zase-cestujem-miroslav-bielik"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Už zase cestujem (Miroslav Bielik)</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Zas cestujem domov, zmenene &ndash; zmenenou tmou</p>
                                    <p class="show-kd-mobile">
                                        Zas cestujem domov, zmenene &ndash; zmenenou tmou

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/michal-chuda" class="author-link">Michal Chuda</a>
                                    <small>• 05. 05. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43020/knihomolov-zapisnik-o-slovakoch-v-ceskoslovenskych-legiach"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18909/conversions/square.jpg"  alt="Knihomoľov z&aacute;pisn&iacute;k: Slov&aacute;ci v československ&yacute;ch l&eacute;gi&aacute;ch">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43020/knihomolov-zapisnik-o-slovakoch-v-ceskoslovenskych-legiach"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Knihomoľov z&aacute;pisn&iacute;k: Slov&aacute;ci v československ&yacute;ch l&eacute;gi&aacute;ch</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="author-link">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a>
                                            <small>• 04. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42893/bytie-moje-stefan-bucko"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18768/conversions/square.jpg"  alt="Bytie moje... (&Scaron;tefan Bučko)">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42893/bytie-moje-stefan-bucko"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Bytie moje... (&Scaron;tefan Bučko)</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/michal-chuda" class="author-link">Michal Chuda</a>
                                            <small>• 28. 04. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42858/knihomolov-zapisnik-diplomati-stroskotanec-a-viera-na-pracovisku"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18752/conversions/square.jpg"  alt="Knihomoľov z&aacute;pisn&iacute;k: Diplomati, stroskotanec a viera na pracovisku">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42858/knihomolov-zapisnik-diplomati-stroskotanec-a-viera-na-pracovisku"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Knihomoľov z&aacute;pisn&iacute;k: Diplomati, stroskotanec a viera na pracovisku</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/lukas-krivosik" class="author-link">Luk&aacute;&scaron; Krivo&scaron;&iacute;k</a>
                                            <small>• 26. 04. 2019</small>
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
                                <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="https://www.postoj.sk/uploads/19008/conversions/square.jpg"  alt="Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/43110/na-zapade-ma-nepovazuju-za-menejcennu-pre-farbu-pleti-ale-pre-prolife-nazory"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >Na Z&aacute;pade ma nepovažuj&uacute; za menejcenn&uacute; pre farbu pleti, ale pre pro-life n&aacute;zory</a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">Rozhovor s Obianujou Ekeochou o tom, že Z&aacute;pad by Afrike najviac pomohol t&yacute;m, keby prestal s rozvojovou pomocou.</p>
                                    <p class="show-kd-mobile">
                                        Rozhovor s Obianujou Ekeochou o tom, že Z&aacute;pad by Afrike najviac pomohol t&yacute;m, keby prestal s rozvojovou pomocou.

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/lukas-kekelak" class="author-link">Luk&aacute;&scaron; Kekel&aacute;k</a>
                                    <small>• 05. 05. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/19001/conversions/square.jpg"  alt="Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43103/arcibiskup-stanislav-zvolensky-sprava-o-katolickej-cirkvi-na-slovensku"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >Arcibiskup Stanislav Zvolensk&yacute;: Spr&aacute;va o Katol&iacute;ckej cirkvi na Slovensku</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/postoj" class="author-link">Postoj</a>
                                            <small>• 05. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18987/conversions/square.jpg"  alt="Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43090/pavol-hrabovecky-o-g-k-chestertonovi-a-burani-modernych-dogiem"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Pavol Hraboveck&yacute; o G. K. Chestertonovi a b&uacute;ran&iacute; modern&yacute;ch dogiem</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/postoj" class="author-link">Postoj</a>
                                            <small>• 04. 05. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/43076/niektore-veci-sa-cenzurovat-musia"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18975/conversions/square.jpg"  alt="Niektor&eacute; veci sa cenzurovať musia">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/43076/niektore-veci-sa-cenzurovat-musia"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Niektor&eacute; veci sa cenzurovať musia</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/david-warren" class="author-link">David Warren</a>
                                            <small>• 04. 05. 2019</small>
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
                                <a href="https://www.postoj.sk/42716/ma-sibacka-a-oblievacka-buducnost"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >
                                    <div class="image-wrap">
                                        <img  src="https://www.postoj.sk/uploads/18574/conversions/square.jpg"  alt="M&aacute; &scaron;ibačka a oblievačka bud&uacute;cnosť? ">
                                    </div>
                                </a>
                                <header>
                                    <h3 class="article-title">
                                        <a href="https://www.postoj.sk/42716/ma-sibacka-a-oblievacka-buducnost"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="1" >M&aacute; &scaron;ibačka a oblievačka bud&uacute;cnosť? </a>
                                    </h3>
                                </header>

                                <div class="perex">
                                    <p class="hidden-kd-mobile">M&aacute;me k tomu viesť svoje deti?</p>
                                    <p class="show-kd-mobile">
                                        M&aacute;me k tomu viesť svoje deti?

                                    </p>
                                </div>

                                <footer>
                                    <a href="https://www.postoj.sk/autor/zuzana-hanusova" class="author-link">Zuzana Hanusov&aacute;</a>
                                    <small>• 22. 04. 2019</small>
                                </footer>
                            </article>
                        </div>
                        <div class="col-xxs-12 col-md-6 right-col mobile-text-col">
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42615/vychova-deti-k-nabozenstvu-a-spiritualite-moze-ochranit-ich-mentalne-zdravie"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18457/conversions/square.jpg"  alt="V&yacute;chova det&iacute; k n&aacute;boženstvu a spiritualite m&ocirc;že ochr&aacute;niť ich ment&aacute;lne zdravie">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42615/vychova-deti-k-nabozenstvu-a-spiritualite-moze-ochranit-ich-mentalne-zdravie"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="2" >V&yacute;chova det&iacute; k n&aacute;boženstvu a spiritualite m&ocirc;že ochr&aacute;niť ich ment&aacute;lne zdravie</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/zuzana-hanusova" class="author-link">Zuzana Hanusov&aacute;</a>
                                            <small>• 18. 04. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42535/brat-deti-na-velkonocne-obrady"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18368/conversions/square.jpg"  alt="Brať deti na veľkonočn&eacute; obrady?">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42535/brat-deti-na-velkonocne-obrady"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="3" >Brať deti na veľkonočn&eacute; obrady?</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/zuzana-hanusova" class="author-link">Zuzana Hanusov&aacute;</a>
                                            <small>• 16. 04. 2019</small>
                                        </footer>
                                    </div>
                                </div>
                            </article>
                            <article class="category-article-item">
                                <div class="row">
                                    <div class="col-xxs-5 col-md-4 left-col mobile-img-col">
                                        <a href="https://www.postoj.sk/42364/zeny-maju-menej-deti-ako-si-naozaj-zelali"   class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >
                                            <div class="image-wrap">
                                                <img  src="https://www.postoj.sk/uploads/18179/conversions/square.jpg"  alt="Ženy maj&uacute; menej det&iacute;, ako si naozaj želali">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-xxs-7 col-md-8 right-col mobile-text-col">
                                        <header>
                                            <h3 class="article-title">
                                                <a href="https://www.postoj.sk/42364/zeny-maju-menej-deti-ako-si-naozaj-zelali"  class="track-me-pls" data-category="home_spodne-clanky" data-action="click" data-label="position" data-value="4" >Ženy maj&uacute; menej det&iacute;, ako si naozaj želali</a>
                                            </h3>
                                        </header>
                                        <footer>
                                            <a href="https://www.postoj.sk/autor/zuzana-hanusova" class="author-link">Zuzana Hanusov&aacute;</a>
                                            <small>• 10. 04. 2019</small>
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
                                    <a href="https://www.postoj.sk/42956/eurovolby-co-caka-eu-v-najblizsich-rokoch-anketa">
                                        <div class="image-wrap">
                                            <img  src="https://www.postoj.sk/uploads/18839/conversions/square.jpg"  alt="Eurovoľby: Čo čak&aacute; E&Uacute; v najbliž&scaron;&iacute;ch rokoch? (anketa)">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxs-7 col-md-7 mobile-text-col">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/42956/eurovolby-co-caka-eu-v-najblizsich-rokoch-anketa">Eurovoľby: Čo čak&aacute; E&Uacute; v najbliž&scaron;&iacute;ch rokoch? (anketa)</a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item">
                            <div class="row">
                                <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                    <a href="https://www.postoj.sk/42819/b-skripek-z-krestanskej-unie-sa-stal-najvplyvnejsim-slovenskym-europoslancom">
                                        <div class="image-wrap">
                                            <img  src="https://www.postoj.sk/uploads/18689/conversions/square.jpg"  alt="B. &Scaron;kripek z Kresťanskej &uacute;nie sa stal najvplyvnej&scaron;&iacute;m slovensk&yacute;m europoslancom">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxs-7 col-md-7 mobile-text-col">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/42819/b-skripek-z-krestanskej-unie-sa-stal-najvplyvnejsim-slovenskym-europoslancom">B. &Scaron;kripek z Kresťanskej &uacute;nie sa stal najvplyvnej&scaron;&iacute;m slovensk&yacute;m europoslancom</a>
                                        </h3>
                                    </header>
                                </div>
                            </div>
                        </article>
                        <article class="press-releases-item">
                            <div class="row">
                                <div class="col-xxs-5 col-md-5 img-col mobile-img-col">
                                    <a href="https://www.postoj.sk/42623/pre-vitazstvo-zivota-musime-nieco-urobit">
                                        <div class="image-wrap">
                                            <img  src="https://www.postoj.sk/uploads/18459/conversions/square.jpg"  alt="Pre v&iacute;ťazstvo života mus&iacute;me niečo urobiť">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-xxs-7 col-md-7 mobile-text-col">
                                    <header>
                                        <h3 class="article-title">
                                            <a href="https://www.postoj.sk/42623/pre-vitazstvo-zivota-musime-nieco-urobit">Pre v&iacute;ťazstvo života mus&iacute;me niečo urobiť</a>
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
                                            <a href="https://www.postoj.sk/42365/vdaka-slovakom-moze-chodit-do-skoly-viac-ako-3-700-deti">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Vďaka Slov&aacute;kom m&ocirc;že chodiť do &scaron;koly viac ako 3 700 det&iacute;
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
                                            <a href="https://www.postoj.sk/42294/europoslanci-anna-zaborska-a-branislav-skripek-ideme-spolocne">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Europoslanci Anna Z&aacute;borsk&aacute; a Branislav &Scaron;kripek: Ideme spoločne
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
                                            <a href="https://www.postoj.sk/42003/dopravne-zapchy-su-problem-verejna-doprava-je-jeho-riesenim-ak-bude-dobra">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Dopravn&eacute; z&aacute;pchy s&uacute; probl&eacute;m &ndash; verejn&aacute; doprava je jeho rie&scaron;en&iacute;m. Ak bude dobr&aacute;
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
                                            <a href="https://www.postoj.sk/41434/bojujem-za-slusne-slovensko-cely-zivot-video">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Bojujem za slu&scaron;n&eacute; Slovensko cel&yacute; život (video)
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
                                            <a href="https://www.postoj.sk/41137/zlo-sa-moze-premenit-na-dobro-len-ak-ostaneme-verni-spravnym-hodnotam">
                                                <i class="icon icon-arrow-right-grey"></i>
                                                Zlo sa m&ocirc;že premeniť na dobro, len ak ostaneme vern&iacute; spr&aacute;vnym hodnot&aacute;m
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
<script type="text/javascript" src="https://static.postoj.sk/frontend/build/main-d57218b1.js"></script>

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

<script src="{{ mix('js/app.js') }}"></script>


</body>
</html>
