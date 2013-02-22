<?php $this->renderPartial('widgetSites', array('sites'=>$sites));?>
<div class="span9 __js_mainContent">
    <div class="well">
    <?php if(query('new')):?>
    <form class="form-horizontal" id="adminForm" method="POST" action="<?=app()->createUrl('admin/sites')?>">
        <div class="control-group">
          <label class="control-label" for="inputTitle">Название сайта*:</label>
          <div class="controls">
            <input type="text" name="inputTitle" id="inputTitle" class="span4" placeholder="Короткое название" value="<?=query('inputTitle')?>">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputFolder">Папка сайта*:</label>
          <div class="controls">
            <input type="text" name="inputFolder" id="inputFolder" class="span4" placeholder="Уникальная папка для хранения сайта" value="<?=query('inputFolder')?>">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputDomains">Доменные имена*:</label>
          <div class="controls">
            <textarea rows="3" name="inputDomains" id="inputDomains" class="span6" placeholder="Разделять через запятую"><?=query('inputDomains')?></textarea>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTemplateHeader">Шапка сайта:</label>
          <div class="controls">
            <textarea rows="5" name="inputTemplateHeader" id="inputTemplateHeader" class="span6"><?=query('inputTemplateHeader')?query('inputTemplateHeader'):file_get_contents(app()->getBasePath().'/views/admin/templateHeader.tpl');?></textarea>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="inputTemplateFooter">Подвал сайта:</label>
          <div class="controls">
            <textarea rows="5" name="inputTemplateFooter" id="inputTemplateFooter" class="span6"><?=query('inputTemplateHeader')?query('inputTemplateHeader'):file_get_contents(app()->getBasePath().'/views/admin/templateFooter.tpl');?></textarea>
          </div>
        </div>
        <div class="control-group">
        <div class="controls">
            <div class="alert alert-error fade in" style="<?=$error?'':'display:none'?>"><?=$error?></div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
          </div>
        </div>
    </form>
    <?php else:?>
    Выберите сайт в левом меню или создайте новый.
    <?php endif;?>
    </div>
</div>
<?php $this->beginClip('extraJS')?>
<script>
    $(function(){
        $('.__js_pageSites').addClass('active');
        <?php if(query('new')):?>
        $('.__js_newSite').addClass('active');
        <?php endif;?>
        $('#adminForm').submit(checkForm);
        function checkForm(){
            var error = '';
            if(!$('#inputTitle').val()){
                error += '- Введите заголовок сайта<br />';
            }
            if(!$('#inputFolder').val()){
                error += '- Введите папку сайта<br />';
            }else if(!String($('#inputFolder').val()).match(/[a-zA-Z-_]/)){
                error += '- Папка сайта должна содержать только буквы латинского алфавита<br />';
            }
            if(!$('#inputDomains').val()){
                error += '- Введите домены<br />';
            // TODO: Доделать для русских доменов
            }else if(!String($('#inputDomains').val()).match(/[a-zA-Z-_\.,]/)){
                error += '- Домены должны содержать только буквы латинского алфавита<br />';
            }
            if(error){
                $('.alert').html(error);
                $('.alert').show();
                return false;
            }
            return true;                
        }
    });
</script>
<?php $this->endClip();?>