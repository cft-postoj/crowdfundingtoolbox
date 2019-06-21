<table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="wrapper" style="background-color: #f3f8fc;padding: 30px 0;">
    <tbody><tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" style="background-color: #f3f8fc">
                <tbody><tr>
                    <td style="border-radius: 3px; padding-bottom: 30px; background-color: #f3f8fc" class="card-1" width="100%" valign="top" align="center">
                        <table style="border-radius: 3px;" width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="wrapper" bgcolor="#f3f8fc">
                            <tbody><tr>
                                <td align="center">
                                    <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                                        <!-- START HEADER IMAGE -->
                                        <tbody><tr>
                                            <td align="center" class="hund ripplelink" width="600">
                                                @include('emails.parts.logo')
                                            </td>
                                        </tr>
                                        <!-- END HEADER IMAGE -->
                                        <!-- START BODY COPY -->
                                        <tr>
                                            <td class="td-padding" align="center" style="font-family: 'Roboto', monospace; color: #212121!important; font-size: 23px; font-weight: bold; line-height: 30px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;">
                                                @yield('title')
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="td-padding" align="left" style="font-family: 'Roboto', monospace; color: #212121!important; font-size: 16px; line-height: 25px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;">
                                                @yield('body')
                                            </td>
                                        </tr>
                                        <tr style="font-family: 'Roboto', monospace; color: #212121!important; font-size: 16px; line-height: 25px; padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;display: @yield('displayButton')">
                                            <td>
                                                @include('emails.parts.button')
                                            </td>
                                        </tr>

                                        <!-- END BUTTON -->
                                        </tbody></table>
                                </td>
                            </tr>
                            </tbody></table>
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    </tbody></table>