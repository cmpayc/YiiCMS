<script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/js/jquery-1.9.1.min.js"></script>
<script>
    $(function(){
        var html = '<div style="position:fixed;top:0px;left:0px;width:100%;height:30px;border:#000 1px solid">APPLICATION PANEL</div>' +
                   '<div style="margin-top:30px"></div>';
        $('body').prepend(html);
    });
</script>