<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<!-- <div class="uk-width-1-1 ui red message" onclick="this.classList.add('hidden');"><?= $message ?></div> -->
<div class="uk-alert-danger" uk-alert onclick="this.classList.add('hidden');">
    <a class="uk-alert-close" uk-close></a>
    <p><?= $message ?></p>
</div>
