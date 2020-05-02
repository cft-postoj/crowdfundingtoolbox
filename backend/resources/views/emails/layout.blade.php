<center style="background-color: #f3f8fc">
    <style>
        /* cyrillic-ext */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufA5qW54A.woff2) format('woff2');
            unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }
        /* cyrillic */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufJ5qW54A.woff2) format('woff2');
            unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* greek-ext */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufB5qW54A.woff2) format('woff2');
            unicode-range: U+1F00-1FFF;
        }
        /* greek */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufO5qW54A.woff2) format('woff2');
            unicode-range: U+0370-03FF;
        }
        /* vietnamese */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufC5qW54A.woff2) format('woff2');
            unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
        }
        /* latin-ext */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufD5qW54A.woff2) format('woff2');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
            font-family: 'Roboto Slab';
            font-style: normal;
            font-weight: 400;
            src: local('Roboto Slab Regular'), local('RobotoSlab-Regular'), url(https://fonts.gstatic.com/s/robotoslab/v9/BngMUXZYTXPIvIBgJJSb6ufN5qU.woff2) format('woff2');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }
        body {
            font-family: 'Roboto Slab', Helvetica, Sans-Serif
        }
    </style>
    <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="wrapper"
           style="background-color: #ffffff;padding: 30px 0;">
        <tbody>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff">
                    <tbody>
                    <tr>
                        <td style="border-radius: 3px; padding-bottom: 30px; background-color: #ffffff" class="card-1"
                            width="100%" valign="top" align="center">
                            <table style="border-radius: 3px;" width="600" cellpadding="0" cellspacing="0" border="0"
                                   align="center" class="wrapper" bgcolor="#ffffff">
                                <tbody>
                                <tr>
                                    <td align="center">
                                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                                            <!-- START HEADER IMAGE -->
                                            <tbody>
                                            <tr>
                                                <td align="left" class="hund ripplelink" width="600" style="padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important;">
                                                    @include('emails.parts.logo')
                                                </td>
                                            </tr>
                                            <!-- END HEADER IMAGE -->
                                            <!-- START BODY COPY -->
                                            <tr>
                                                <td class="td-padding" align="left"
                                                    style="font-family: 'Roboto Slab', Helvetica, Sans-Serif; color: #004E83!important; font-size: 23px; font-weight: bold; line-height: 30px; padding-top: 35px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 35px 18px 0px 13px;">
                                                    @yield('title')
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="td-padding" align="left"
                                                    style="font-family: 'Roboto Slab', Helvetica, Sans-Serif; color: #212121!important; font-size: 15px; line-height: 25px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;">
                                                    @yield('body')
                                                </td>
                                            </tr>
                                            <tr style="font-family: 'Roboto Slab', Helvetica, Sans-Serif; color: #212121!important; font-size: 15px; line-height: 25px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;display: @yield('displayButton')">
                                                <td>
                                                    @include('emails.parts.button')
                                                </td>
                                            </tr>


                                            <tr style="font-family: 'Roboto Slab', Helvetica, Sans-Serif; margin-top: 30px; color: #212121!important; font-size: 15px; line-height: 25px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;display: @yield('displayButton')">
                                                <td>
                                                    @yield('footer')
                                                </td>
                                            </tr>

                                            <!-- END BUTTON -->
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

</center>