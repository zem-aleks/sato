<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <base href="<?= base_url() ?>" />
        <title><?= $title ?> | <?= $this->lang->line('admin_panel'); ?></title>


        <link href="/images/admin/favicon.ico" rel="shortcut icon"/>
        <link href="/css/admin.css" rel="stylesheet" type="text/css"/>
        <link href="/css/jquery.alerts.css" rel="stylesheet" type="text/css" />
        <!--<link href="/css/flags.css" rel="stylesheet" type="text/css" />-->
        <link href="/css/style.css" rel="stylesheet"  type="text/css" media="screen" />
        <link href="/css/jquery.fancybox.css" rel="stylesheet" type="text/css"/>
        <link href="/css/jquery-ui-1.9.2.custom.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/css/font-awesome-4.2.0/css/font-awesome.min.css">

        <script src="/js/jquery-1.8.3.js" language="javascript"></script>
        <script src="/js/jquery.placeholder.min.js" type="text/javascript"></script>
        <script src="/js/jquery.alerts.js" type="text/javascript"></script>
        <script src="/js/jquery.fancybox-1.3.1.pack.js" language="javascript"></script>
        <script src="/js/jquery.tablednd.js" type="text/javascript"></script>
        <script src="/js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
        <script src="/js/common.js" type="text/javascript"></script>
        <script src="/js/admin.js" type="text/javascript"></script>

    </head>
    <body>
        <div class="bg">
            <div class="frontend"><a href="/"><?= $this->lang->line('to_site'); ?></a></div>
            <div id="maincontainer">
                <div class="header">
                    <!--Header -->      
                    <!--<div style="float:left;width:215px;">
                        <a href="<?= base_url() ?>admin"  style="text-decoration:none;">
                            <div class="logo">&nbsp;</div>
                        </a>
                    </div>-->
                    <div >
                        <div class="lang"><img src='/images/admin/lang.png' /><span><a href='#'><?= $this->lang->line('language'); ?></a>: Русский</span></div>
                        <div class="user_info">
                            Добро пожаловать,  Admin в админ панель ::
                            <a href="<?= base_url() ?>admin/password">Изменить пароль</a> :: 
                            <a href="<?= base_url() ?>admin/logout">Выход</a>
                        </div>
                        <ul class="header_menu">
                            <li><a href="/dashboard/pages"><?= $this->lang->line('pages'); ?></a></li>
                            <li><a href="/dashboard/category"><?= $this->lang->line('menu'); ?></a></li>
                            <li><a href="/dashboard/module"><?= $this->lang->line('modules'); ?></a></li>
                            <li><a href="/dashboard/settings"><?= $this->lang->line('settings'); ?></a></li>
                        </ul>
                    </div>
                    <!-- /Header -->
                </div>
                <div id="contentwrapper">
                    <?php if ($this->uri->segment(2) != "category" && $this->uri->segment(2) != "pages" && $this->uri->segment(2) != "settings") { ?>
                        <div class="left_menu">    
                            <?php $this->load->module('module')->left_menu(); ?>
                        </div>
                        <div class="content content2">
                        <?php
                        }
                        else
                            print '<div class="content">';?>