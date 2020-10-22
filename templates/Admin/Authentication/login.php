<!-- <form class="toggle-class" method="POST"> -->
<?= $this->Form->create() ?>
				<fieldset class="uk-fieldset">
					<div class="uk-margin-small">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: user"></span>
							<input class="uk-input uk-border-pill" name="account_code" placeholder="Account code"  type="text" value="<?= !empty($inputData) ? $inputData['account_code'] : '' ?>">
						</div>
					</div>
					<div class="uk-margin-small">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: lock"></span>
							<input class="uk-input uk-border-pill" name="password" placeholder="Password" type="password" value="<?= !empty($inputData) ? $inputData['password'] : '' ?>">
						</div>
					</div>
					<div class="uk-margin-small">
						<div class="uk-inline uk-width-1-1">
							<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: world"></span>
							<select class="uk-select uk-border-pill" onchange="change()">
								<option><a class="uk-link" href="<?=$this->Url->build('/changelang-default');?>"><i class="vn flag"></i> Việt Nam</a></option>
								<option><a class="uk-link" href="<?=$this->Url->build('/changelang');?>"><i class="gb flag"></i> English</a></option>
							</select>
						</div>
					</div>
					<div class="uk-margin-small">
						<label><input class="uk-checkbox" type="checkbox"> Keep me logged in</label>
					</div>
					<div class="uk-margin-bottom">
						<input type="submit" class="uk-button uk-button-primary uk-border-pill uk-width-1-1" value="LOGIN">
					</div>
				</fieldset>
			</form>
			<!-- /login -->

			<!-- recover password -->
			<form class="toggle-class" action="login-dark.html" hidden>
				<div class="uk-margin-small">
					<div class="uk-inline uk-width-1-1">
						<span class="uk-form-icon uk-form-icon-flip" data-uk-icon="icon: mail"></span>
						<input class="uk-input uk-border-pill" placeholder="E-mail" required type="text">
					</div>
				</div>
				<div class="uk-margin-bottom">
					<button type="submit" class="uk-button uk-button-primary uk-border-pill uk-width-1-1">SEND PASSWORD</button>
				</div>
			</form>
			<!-- /recover password -->
			
			<!-- action buttons -->
			<div>
				<div class="uk-text-center">
					<a class="uk-link-reset uk-text-small toggle-class" data-uk-toggle="target: .toggle-class ;animation: uk-animation-fade"><?= h(__('Forgot your password ?')) ?></a>
					<a class="uk-link-reset uk-text-small toggle-class" data-uk-toggle="target: .toggle-class ;animation: uk-animation-fade" hidden><span data-uk-icon="arrow-left"></span> Back to Login</a>
				</div>
			</div>
<?= $this->Form->end() ?>
<script>
	function change(){
		alert('test');
	}
</script>