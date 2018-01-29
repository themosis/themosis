<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style type="text/css">
		/* latin */
		@font-face {
			font-family: 'Open Sans';
			font-style: normal;
			font-weight: 400;
			src: local('Open Sans'), local('OpenSans'), url(//fonts.gstatic.com/s/opensans/v10/cJZKeOuBrn4kERxqtaUH3ZBw1xU1rKptJj_0jans920.woff2) format('woff2');
			unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215, U+E0FF, U+EFFD, U+F000;
		}

		.clearfix:before,
		.clearfix:after {
			content: " "; /* 1 */
			display: table; /* 2 */
		}

		.clearfix:after {
			clear: both;
		}

		.clearfix {
			*zoom: 1;
		}

		body{
			background-color: #002832;
			margin: 0;
			padding: 0;
		}

		#app{
			width: 100%;
			padding: 6em 0;
			overflow: hidden;
		}

		.wrapper{
			width: 960px;
			margin: 0 auto;
		}

		h1{
			color: #f5f5f5;
			font-family: 'Open Sans', sans-serif;
			font-size: 44px;
			font-size: 2.75em;
			line-height: 100%;
			margin: 0.5em 0;
		}

		h2{
			color: #004c59;
			font-family: 'Open Sans', sans-serif;
			font-size: 326px;
			font-size: 1.625em;
			line-height: 100%;
			margin: 0 0 1em 0;
		}

		h3{
			color: #004c59;
			font-family: 'Open Sans', sans-serif;
			font-size: 16px;
			font-size: 1em;
			line-height: 100%;
			margin: 0 0 1em 0;
		}

		p{
			font-family: 'Open Sans', sans-serif;
			color: #666666;
			font-size: 16px;
			font-size: 1em;
			line-height: 1.5em;
		}

		a, a:link, a:active, a:visited{
			font-family: 'Open Sans', sans-serif;
			color: #666666;
			font-size: 14px;
			font-size: 0.875em;
			line-height: 1.5em;
			text-decoration: none;
		}

		a:hover{
			color: #00b49c;
		}

		.head{
			width: 960px;
			text-align: center;
			margin-bottom: 3em;
		}

		.head p{
			color: #f5f5f5;
		}

		#logo{
			width: 100px;
			height: 100px;
			margin: 0 auto;
		}

		.frame{
			width: 960px;
			background-color: #f5f5f5;
		}

		#get-started{
			width: 640px;
			float: left;
			background-color: #ffffff;
		}

		#get-started a, #get-started a:link, #get-started a:active, #get-started a:visited{
			display: inline-block;
			font-family: 'Open Sans', sans-serif;
			font-size: 18px;
			font-size: 1.125em;
			line-height: 100%;
			background-color: #00b49c;
			color: #ffffff;
			padding: 0.75em 1em;
			border: 1px solid #00b49c;
			-webkit-border-radius: 2px;
			-moz-border-radius: 2px;
			border-radius: 2px;
			text-decoration: none;
			-webkit-transition: background-color 0.3s ease, color 0.3s ease;
			-moz-transition: background-color 0.3s ease, color 0.3s ease;
			-o-transition: background-color 0.3s ease, color 0.3s ease;
			transition: background-color 0.3s ease, color 0.3s ease;
		}

		#get-started a:hover{
			background-color: #ffffff;
			color: #00b49c;
		}

		#links{
			width: 320px;
			float: left;
		}

		#links ul{
			margin: 0 0 0 1em;
			padding: 0;
		}

		.container{
			padding: 3.125em;
		}
	</style>
	<?php wp_head(); ?>
</head>
<body>
<div id="app">
	<div class="wrapper">
		<div class="head">
			<div id="logo">
				<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" width="100px" height="100px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><g><g><path fill="#00B49C" d="M13.895 63.88c-1.571-1.568-1.489-4.066 0.007-5.564c1.497-1.494 36.121-36.119 36.121-36.119l5.559 5.6 c0 0-34.65 34.65-36.123 36.123C17.988 65.3 15.5 65.5 13.9 63.88z"/><path fill="#00B49C" d="M30.569 24.976c1.572 1.6 1.5 4.067-0.006 5.564C29.067 32 5.6 55.5 5.6 55.546L0 50 c0 0 23.533-23.534 25.005-25.005C26.477 23.5 29 23.4 30.6 24.976z"/><path fill="#00B49C" d="M72.254 33.312c-2.655 2.655-14.1 14.101-19.453 19.454c-1.695 1.696-4.212 1.348-5.559 0 c-1.345-1.347-1.678-3.879 0-5.559c5.185-5.184 15.896-15.896 16.84-16.839c1.334-1.335 1.548-3.678 0-5.228 c-3.746-3.745-10.314-10.312-11.447-11.445c-1.603-1.603-3.962-1.266-5.227 0c-0.743 0.742-3.537 3.537-5.724 5.7 c-1.541 1.541-4.069 1.487-5.558 0c-1.487-1.489-1.62-3.939 0-5.559c2.545-2.544 6.228-6.226 8.336-8.337 c3.455-3.453 8.361-2.754 11.1 0c2.755 2.8 13.9 13.9 16.7 16.675C75.044 25 75.7 29.8 72.3 33.312z"/></g><g><path fill="#00B49C" d="M86.15 36.091c-1.572-1.573-4.07-1.489-5.564 0.006c-1.498 1.496-36.123 36.119-36.123 36.119l5.559 5.6 c0 0 34.649-34.648 36.12-36.12C87.615 40.2 87.7 37.7 86.2 36.091z"/><path fill="#00B49C" d="M80.458 63.926c1.572 1.6 4.1 1.5 5.564-0.008C87.521 62.4 100 49.9 100 49.941l-5.559-5.558 c0 0-12.505 12.505-13.976 13.978C78.993 59.8 78.9 62.4 80.5 63.926z"/><path fill="#00B49C" d="M55.581 94.449C58.235 91.8 69.7 80.4 75 75c1.692-1.697 1.343-4.215 0-5.559 c-1.35-1.348-3.882-1.68-5.559 0c-5.185 5.182-15.898 15.895-16.841 16.836c-1.337 1.336-3.68 1.549-5.227 0 c-3.745-3.744-10.314-10.312-11.447-11.447c-1.603-1.6-1.266-3.961 0-5.225c0.742-0.744 3.538-3.539 5.723-5.726 c1.542-1.541 1.489-4.068 0-5.557c-1.487-1.487-3.938-1.62-5.558-0.002c-2.545 2.545-6.226 6.229-8.336 8.3 c-3.454 3.455-2.757 8.4 0 11.115c2.755 2.8 13.9 13.9 16.7 16.674C47.252 97.2 52.1 97.9 55.6 94.449z"/></g></g></svg>
			</div>
			<h1><?php _e('Congratulations!', THEME_TEXTDOMAIN); ?></h1>
			<p><?php _e('The Themosis framework is running.', THEME_TEXTDOMAIN); ?></p>
		</div>
		<div class="frame clearfix">
			<div id="get-started">
				<div class="container">
					<h2><?php _e('Get started:', THEME_TEXTDOMAIN); ?></h2>
					<p><?php _e('Check the documentation and build your next WordPress website/application.', THEME_TEXTDOMAIN); ?></p>
					<a href="http://framework.themosis.com/docs/" target="_blank" title="<?php _e('Themosis framework documentation', THEME_TEXTDOMAIN); ?>"><?php _e('View documentation', THEME_TEXTDOMAIN); ?></a>
				</div>
			</div>
			<div id="links">
				<div class="container">
					<h3><?php _e('Links:', THEME_TEXTDOMAIN); ?></h3>
					<ul>
						<li><a href="http://framework.themosis.com" target="_blank" title="Themosis framework">Themosis framework</a></li>
						<li><a href="https://github.com/themosis" target="_blank" title="GitHub - Themosis">GitHub</a></li>
						<li><a href="https://twitter.com/Themosis" target="_blank" title="Twitter - Themosis">Twitter</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>