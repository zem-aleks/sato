<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?= $title; ?></title>
        <meta name="keywords" content="<?= $keywords; ?>"/>
        <meta name="description" content="<?= $description; ?>"/>
        <base href="<?= base_url() ?>" />

        <link rel="shortcut icon" href="/images/front/favicon.ico" />
        <link href="/css/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css" />
        <link href="/css/front.css" rel="stylesheet" type="text/css" />
        <link href="css/lightbox.css" rel="stylesheet" />
        
        <!--<script src="/js/jquery-1.8.3.js" language="javascript"></script>
        <script src="/js/jquery-ui-1.9.2.custom.min.js" language="javascript"></script>
        <script src="/js/jquery.placeholder.min.js" type="text/javascript"></script>
        <script src="/js/jquery.maskedinput.min.js" type="text/javascript"></script>
        <script src="/js/jquery.flexslider-min.js" type="text/javascript"></script>
        <script src="/js/lightbox.min.js"></script>-->
        <script src="/js/common.js" type="text/javascript"></script>
        <script src="/js/front.js" type="text/javascript"></script>
        
    

        <!--[if lt IE 9]>
            <script src="/js/css3-mediaqueries.js"></script>
            <link href="/css/frontie.css" rel="stylesheet" type="text/css"/>
        <![endif]-->
    </head>
    <body>

        <? if ($this->session->userdata('is_logged_in')): ?>
            <div class="backend"><a href="/admin">Перейти в админку</a></div>
        <? endif; ?>
        
        <div class="wrapper"></div>
