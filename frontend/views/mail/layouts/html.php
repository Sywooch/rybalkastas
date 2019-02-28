<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var \yii\web\View $this
 * @var yii\mail\BaseMessage $content
 */

?>

<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php $this->head() ?>
</head>
<body bgcolor="#2ca0c5" style="background-image: url('http://rybalkashop.ru/img/springwall_c.jpg');background-color: #2ca0c5;background-size: initial;background-position: center;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;font-size: 100%;line-height: 1.6;-webkit-font-smoothing: antialiased;-webkit-text-size-adjust: none;width: 100% !important;height: 100%;margin: 0;padding: 0;">
<table class="body-wrap" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 20px;">
    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
        <td class="container" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; display: block !important; max-width: 800px !important; clear: both !important; margin: 0 auto; padding: 0;">
            <div class="content" style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; max-width: 800px; display: block; margin: 0 auto; padding: 20px;">
                <table style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; width: 100%; margin: 0; padding: 0;">
                    <tr>
                        <td>
                            <div style="text-align: center;margin-bottom: 20px">
                                <img src="http://rybalkashop.ru/img/logo.png"/>
                            </div>
                            <div>
                                <div style="margin-bottom: 0;list-style-type: none;text-align: justify;padding-left: 0">
                                    <span style="background:#ebecf0;font-weight:700;font-family:Arial;text-align:center;border-radius:7px;border-top-right-radius:7px;border:1px solid #ccc;border-bottom:none;display: table-cell;width: 1%;"><a style="color:#42598c;display:block;padding:12px 0 10px" href="http://rybalkashop.ru/">Главная</a></span>
                                    <span style="background:#ebecf0;font-weight:700;font-family:Arial;text-align:center;border-radius:7px;border-top-right-radius:7px;border:1px solid #ccc;border-bottom:none;display: table-cell;width: 1%;"><a style="color:#42598c;display:block;padding:12px 0 10px" href="http://rybalkashop.ru/page/o-nas">О компании</a></span>
                                    <span style="background:#ebecf0;font-weight:700;font-family:Arial;text-align:center;border-radius:7px;border-top-right-radius:7px;border:1px solid #ccc;border-bottom:none;display: table-cell;width: 1%;"><a style="color:#42598c;display:block;padding:12px 0 10px" href="http://rybalkashop.ru/page/skidki-i-akcii">Скидки и акции</a></span>
                                    <span style="background:#ebecf0;font-weight:700;font-family:Arial;text-align:center;border-radius:7px;border-top-right-radius:7px;border:1px solid #ccc;border-bottom:none;display: table-cell;width: 1%;"><a style="color:#42598c;display:block;padding:12px 0 10px" href="http://rybalkashop.ru/page/shops">Контакты</a></span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
                        <td bgcolor="#fff" style="border-top:solid 2px #e93232; font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;">
                            <?php $this->beginBody() ?>
                            <?= $content ?>
                            <?php $this->endBody() ?>

                            <p style="font-size:1em;text-align:center;color:#000;font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">© Rybalkashop.ru <?= date('Y') ?>.</p>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6; margin: 0; padding: 0;"></td>
    </tr>
</table>
</body>
</html>
<?php $this->endPage() ?>
