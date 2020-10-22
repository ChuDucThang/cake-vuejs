<header id="top-head" class="uk-position-fixed" style="left: 0px;">
	<div class="uk-container uk-container-expand" style="background-color:#d20505">
		<nav class="uk-navbar uk-light" data-uk-navbar="mode:click; duration: 250">
			<div class="uk-navbar-left">
				<div class="uk-navbar-item ">
					<a class="uk-navbar-toggle" data-uk-toggle data-uk-navbar-toggle-icon href="#offcanvas-slide" title="<?= h(__('Menu')) ?>" data-uk-tooltip></a>
				</div>
				<div class="uk-navbar-item ">
					<a class="uk-logo" href="<?= $this->Url->build('admin') ?>"><?= $this->Html->image('dashboard-logo-white.svg', ['class' => 'custom-logo']); ?></a>
				</div>
				<div class="uk-navbar-item uk-visible@s">
					<form action="dashboard.html" class="uk-search uk-search-default">
						<span data-uk-search-icon></span>
						<input class="uk-search-input search-field" type="search" placeholder="<?= h(__('Search')) ?>">
					</form>
				</div>
			</div>
			<div class="uk-navbar-right">
				<ul class="uk-navbar-nav">
					<li>
						<a href="#" data-uk-icon="icon: mail"></a>
					</li>
				</ul>
				<ul class="uk-navbar-nav">
					<li>
						<a href="#"><?= h(__('Settings'))?> <span data-uk-icon="icon: triangle-down"></span></a>
						<div class="uk-navbar-dropdown">
							<ul class="uk-nav uk-navbar-dropdown-nav">
								<li class="uk-nav-header"><?= h(__('Your account')) ?></li>
								<li><a href="#"><span data-uk-icon="icon:user" title="Your profile" data-uk-tooltip></span><?= h(__('Your profile')) ?></a></li>
								<li><a href="#"><span data-uk-icon="icon: info"></span> Summary</a></li>
								<li><a href="#"><span data-uk-icon="icon: refresh"></span> Edit</a></li>
								<li class="uk-nav-divider"></li>
								<li><a href="#"><span data-uk-icon="icon: image"></span> Your Data</a></li>
								<li class="uk-nav-divider"></li>
								<li><a href="<?=$this->Url->build('/admin/logout');?>"><span data-uk-icon="icon: sign-out"></span><?= h(__('Logout'))?></a></li>
							</ul>
						</div>
					</li>
				</ul>
				<ul class="uk-navbar-nav">
					<li>
						<a href="#"><?= h(__('Language'))?> <span data-uk-icon="icon: triangle-down"></span></a>
						<div class="uk-navbar-dropdown">
							<ul class="uk-nav uk-navbar-dropdown-nav">
								<li class="uk-nav-header"><?=h(__('Choose language'))?></li>
								<li><a href="<?=$this->Url->build('/changelang-default');?>"><i class="vn flag"></i> Việt Nam</a></li>
								<li><a href="<?=$this->Url->build('/changelang');?>"><i class="gb flag"></i> English</a></li>							</ul>
						</div>
					</li>
				</ul>
			</div>
		</nav>
	</div>
</header>