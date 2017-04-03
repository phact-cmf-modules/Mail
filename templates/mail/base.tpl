<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html style="height: 100%" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width"/>
</head>
<body style="height: 100%">

<table cellpadding="0" cellspacing="0" border="0" width="100%" style="height: 100%">
    <tr>
        <td style="background-color: rgba(223, 237, 241, 0.62); height: 100%" valign="top" align="center">
            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 600px; margin-top: 20px; margin-bottom: 20px; box-shadow: 0 13px 27px rgba(0,0,0,.05);">
                <tr>
                    <td style="background-color: #fff;" valign="top" align="center">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%" style="max-width: 530px; margin-top: 35px;">
                            {block 'logo'}
                                {add $logoPath = '/static/frontend/dist/images/base/logo.png'}
                                {if $logoPath}
                                    <tr>
                                        <td style="text-align: center; vertical-align: middle;">
                                            <img src='{$hostInfo}{$logoPath}'/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30"></td>
                                    </tr>
                                {/if}
                            {/block}
                            <tr>
                                <td  valign="top" style="{block 'content-style'}font-family: Arial;{/block} " align="left">
                                    {block 'content'}
                                    {/block}
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>

                            <tr>
                                <td height="50"></td>
                            </tr>
                            <tr>
                                <td height="20" style="border-top: 1px solid #d7d7d7;"></td>
                            </tr>
                            <tr>
                                <td valign="top" style="font-family: Arial;">
                                    {block 'bottom'}
                                        Сайт:
                                        <a style="color: black;" href="{$hostInfo}">
                                           {$hostInfo}
                                        </a>
                                    {/block}
                                </td>
                            </tr>
                            <tr>
                                <td height="40"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>