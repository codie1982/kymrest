
<body>
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" valign="top" id="templateHeader" data-template-container>
                            <!--[if gte mso 9]>
                            <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                            <tr>
                            <td align="center" valign="top" width="600" style="width:600px;">
                            <![endif]-->
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                                <tr>
                                    <td valign="top" class="headerContainer">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                                            <tbody class="mcnImageBlockOuter">
                                                <tr>
                                                    <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                                                        <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">


                                                            <img align="center" alt="" src="<?= $mail_logo ?>"  style="max-width:400px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnImage"/>
                                                            <?= $mail_check ?> 


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
                </table>
                <!--[if gte mso 9]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
        <tr>
            <td align="center" valign="top" id="templateBody" data-template-container>
                <!--[if gte mso 9]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                <tr>
                <td align="center" valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                    <tr>
                        <td valign="top" class="bodyContainer"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                    <tr>
                                        <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                            <!--[if mso]>
                                                            <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                                            <tr>
                                                            <![endif]-->

                                            <!--[if mso]>
                                            <td valign="top" width="600" style="width:600px;">
                                            <![endif]-->
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                                <tbody>
                                                    <tr>
                                                        <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                            <h1 style="text-align:left !important;">Sn' <?= $user_fullname ?> Kağıt Sepetine'e Hoşgeldiniz.</h1>
                                                            <p style="text-align:left !important;">Kağıt Sepetine Üyeliğiniz başarıyla gerçekleşti.</p>
                                                            <p style="text-align:left !important;">Mail Adresinizi Bu <a href="<?= 'https://www.kagitsepeti.com'. DS . 'register' . DS . 'mailconfirm' . DS . trim($mail_code) ?>">linke</a> tıklayarak aktif edebilirsiniz.</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!--[if mso]>
                                            </td>
                                            </tr>
                                            </table>
                                            <![endif]-->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
        </tr>
        <?= $footer//$this->sendmail->mail_footer(); ?>
    </table>
    <!-- // END TEMPLATE -->
</td>
</tr>
</table>
</center>
</body>