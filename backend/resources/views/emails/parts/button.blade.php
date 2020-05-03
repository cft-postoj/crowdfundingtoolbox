<table border="0" cellspacing="0" cellpadding="0" style="margin-top: 20px;">
    <tbody>
    <tr>
        <td align="left" style="border-radius: 3px;"
            style="padding-top: 18px; padding-left: 18px!important; padding-right: 18px!important; padding-bottom: 0px!important; mso-line-height-rule: exactly; mso-padding-alt: 18px 18px 0px 13px;">
            <a class="button raised" href="@yield('buttonUrl')" target="_blank"
               style="font-size: 18px; line-height: 14px; font-weight: 600; font-family: Helvetica, Arial, sans-serif; color: #ffffff; background-color: #158eea; text-decoration: none; border-radius: 3px; padding: 15px 35px; border: 1px solid #17bef7; display: inline-block;">
                @yield('buttonText')
            </a>
        </td>
    </tr>
    <tr>
        <td>
            <br/>
            @yield('buttonAlternative')
            <a href="@yield('buttonUrl')">
                @yield('buttonUrl')
            </a>
        </td>
    </tr>
    </tbody>
</table>
