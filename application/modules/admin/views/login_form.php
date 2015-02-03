<html>
	<head>
		<base href="<?=base_url()?>" />
		<title><?=$this->lang->line('login_title');?> MustAdmin::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" href="images/favicon.ico" />
		<link href="/css/admin.css" rel="stylesheet" type="text/css"/>
                <script src="/js/jquery-1.8.3.js" language="javascript"> </script>
                <script src="/js/jquery.placeholder.min.js" type="text/javascript"></script>
                <script src="/js/admin.js" type="text/javascript"></script>
	</head>
<body>
<div class="bg">
	<table class="login-table">
            <tr>
                <td>
                    <div class="box">
			<div id="login_form">			
				<h2>Вход</h2>
				<?=form_open('admin/validate_credentials');?>
				<input type="text" name="username" placeholder="Логин">
                                <input type="password" name="password" placeholder="Пароль">
                                <?=form_submit('submit', $this->lang->line('login_button'));?>
				<?=form_close();?>
			</div>
                    </div>
                    <div class="clear"></div>
                </td>
            </tr>
        </table>
		<!--
			
		
    -->
	
</div>
	
</body>
</html>