<?php if ($page && $page > 1): ?>
    <?php include_partial("kw/webtrekk_js_vars", array('pageType' => 'homepage_sezione_lista')) ?>
<?php else: ?>
    <?php include_partial("kw/webtrekk_js_vars", array('pageType' => 'homepage_sezione')) ?>
<?php endif; ?>
