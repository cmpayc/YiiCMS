<?php $this->renderPartial('widgetSites', array('sites'=>$sites));?>
<div class="span9">
    <div class="well">
        
    </div>
</div>
<?php $this->beginClip('extraJS')?>
<script>
    $(function(){
        $('.__js_pageSites').addClass('active');
        $('.__js_site<?=query('id')?>').addClass('active');
    });
</script>
<?php $this->endClip();?>