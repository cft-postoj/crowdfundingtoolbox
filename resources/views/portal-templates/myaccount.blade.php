
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


<div id="cft--myAccountContent">
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
