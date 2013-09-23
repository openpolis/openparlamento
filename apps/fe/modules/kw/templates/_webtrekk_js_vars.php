<!-- classificazione WebTrekk per Kataweb -->
<script type="text/javascript">
    var webtrekkPageConfig = {
        pageHref: "<?php echo $sf_request->getURI() ?>",
        pageType: "<?php echo $pageType ?>",
        <?php if (isset($pageSearchKeyword)): ?>
        pageSearchKeyword: "<?php echo $pageSearchKeyword ?>"
        <?php endif; ?>
    };
</script>
