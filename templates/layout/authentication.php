<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= h(__($title)) ?></title>
		<?= $this->Html->meta('icon') ?>
		<!-- CDN -->
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/uikit@latest/dist/css/uikit.min.css">
		<!-- CSS FILES -->
		<?= $this->Html->css('uikit.min.css') ?>
		<?= $this->Html->css('login-dark.css') ?>
	</head>
	<body class="login uk-cover-container uk-background-secondary uk-flex uk-flex-center uk-flex-middle uk-height-viewport uk-overflow-hidden uk-light" data-uk-height-viewport>
		<!-- overlay -->
		<div class="uk-position-cover uk-overlay-primary"></div>
		<!-- /overlay -->
		<div class="uk-position-bottom-center uk-position-small uk-visible@m uk-position-z-index">
			<span class="uk-text-small uk-text-muted">© 2019 Company Name - <a href="https://github.com/zzseba78/Kick-Off">Created by KickOff</a> | Built with <a href="http://getuikit.com" title="Visit UIkit 3 site" target="_blank" data-uk-tooltip><span data-uk-icon="uikit"></span></a></span>
		</div>
		<div class="uk-width-medium uk-padding-small uk-position-z-index" uk-scrollspy="cls: uk-animation-fade">
			
			<div class="uk-text-center uk-margin">
                <?= $this->Html->image('login-logo.svg', ['alt' => 'Logo']); ?>
			</div>

			<!-- login -->
			<?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
			<!-- action buttons -->
		</div>
		
		<!-- JS FILES -->
		<?= $this->Html->script('uikit.min.js') ?>
        <?= $this->Html->script('uikit-icons.min.js') ?>
	</body>
</html>