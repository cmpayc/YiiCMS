<?php $this->renderPartial('widgetSites', array('sites'=>$sites));?>
<div class="span9 __js_mainContent">
    <div class="well">
      <?php if($site):?>
      <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#tab1" data-toggle="tab">Настройки</a>
            </li>
            <li><a href="#tab2" data-toggle="tab">Шаблоны</a></li>
            <li><a href="#tab3" data-toggle="tab">Меню</a></li>
            <li><a href="#tab4" data-toggle="tab">Страницы сайта</a></li>
            <li><a href="#tab5" data-toggle="tab">Структура сайта</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle"
                 data-toggle="dropdown"
                 href="#">
                  Модули
                  <b class="caret"></b>
                </a>
              <ul class="dropdown-menu">
              </ul>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active form-horizontal" id="tab1">
                <div class="control-group">
                    <label class="control-label" for="inputSiteTitle">Заголовок сайта:</label>
                    <div class="controls">
                      <input type="text" class="span4" id="inputSiteTitle" placeholder="Заголовок сайта" value="<?=$site->title?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputSiteDomains">Домены сайта:</label>
                    <div class="controls">
                      <textarea id="inputSiteDomains" class="span6" rows="3" placeholder="Домены для сайта"><?=implode(',',$site->getDomains(true))?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                      <div class="alert alert-error __js_siteError" style="display:none"></div>
                      <button class="btn btn-primary __js_saveSiteSettings">Сохранить</button>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <select id="selectTemplate">
                    <optgroup label="Основной шаблон сайта">
                        <option value="template">Шаблон сайта</option>
                    </optgroup>
                    <optgroup label="Шаблоны меню"></optgroup>
                    <optgroup label="Шаблоны инфоблоков"></optgroup>
                </select>
                <div id="embedded_ace_code" style="background-color:#FFF;opacity:0;height:500px"><?php echo str_replace(array('<','>'), array('&lt;','&gt;'),file_get_contents(app()->basePath.DS.'views'.DS.'sites'.DS.$site->folder.DS.'template.php'))?></div>
            </div>
            <div class="tab-pane" id="tab3">
                <select id="selectTemplate">
                    <optgroup label="Меню сайта">
                        <option value="new">Новое меню</option>
                    </optgroup>
                </select>
                <hr />
                <div class="form-horizontal" style="margin-top:20px">
                    <div class="control-group">
                        <label class="control-label" for="inputMenuTitle">Заголовок ссылки:</label>
                        <div class="controls">
                          <input type="text" id="inputMenuTitle" placeholder="Заголовок ссылка" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputMenuType">Тип ссылки:</label>
                        <div class="controls">
                          <select id="inputMenuType">
                              <?php foreach(MENUS::$types as $key=>$value):?>
                              <option value="<?=$key?>"><?=$value?></option>
                              <?php endforeach;?>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputMenuLink1">Путь ссылки:</label>
                        <div class="controls">
                          <select id="inputMenuLink1">
                              
                          </select>
                          <input type="text" id="inputMenuLink2" style="display:none" placeholder="Заголовок ссылка" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                          <button class="btn __js_cancelMenu">Отменить</button>
                          <button class="btn btn-primary __js_editMenu" style="display:none">Изменить</button>
                          <button class="btn btn-primary __js_addMenu">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab4">
                <div class="form-horizontal __js_pageEditor" style="display:none">
                    <input type="hidden" id="inputPageId">
                    <div class="control-group">
                        <label class="control-label" for="inputPageName">Заголовок страницы:</label>
                        <div class="controls">
                          <input type="text" id="inputPageName" placeholder="Заголовок страницы" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPageCode">URL-код:</label>
                        <div class="controls">
                          <input type="text" id="inputPageCode" placeholder="Код страницы" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <div id="ace_edit_page" style="background-color:#FFF;opacity:0;height:500px"></div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPageActive">Страница активна:</label>
                        <div class="controls">
                          <input type="checkbox" id="inputPageActive">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                          <div class="alert alert-error __js_pageError" style="display:none"></div>
                          <button class="btn __js_cancelPageEdit">Отменить</button>
                          <button class="btn btn-primary __js_savePageEdit">Сохранить</button>
                        </div>
                    </div>
                </div>
                <ul class="sortablePages" pageId="0">
                <?php foreach($pages as $page):?>
                    <li class="ui-state-default <?=$page->code == 'index'?'ui-state-disabled':''?>" pageId="<?=$page->id?>"><a href="#" class="__js_expandPage" pageId="<?=$page->id?>" style="cursor:pointer"><i class="icon-chevron-down"></i></a>&nbsp;&nbsp;&nbsp;<?=$page->name?> <a href="#" class="__js_editPage" pageId="<?=$page->id?>" style="float:right;margin:5px 10px 0 0"><i class="icon-pencil"></i></a>
                        <ul class="sortablePages" pageId="<?=$page->id?>"></ul>
                    </li>
                <?php endforeach;?>
                    <li class="ui-state-default" style="height:0px;border:0"></li> 
                </ul>
            </div>
            <div class="tab-pane" id="tab5">
                <div id="elfinder"></div>
            </div>
        </div>
      </div>
      <?php endif;?>
    </div>
</div>
<?php $this->beginClip('extraCSS')?>
<link rel="stylesheet" type="text/css" media="screen" href="<?=app()->request->baseUrl?>/admin/css/smoothness/jquery-ui-1.10.1.custom.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=app()->request->baseUrl?>/admin/css/elfinder/elfinder.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?=app()->request->baseUrl?>/admin/css/elfinder/theme.css">
<style type="text/css" media="screen">
#embedded_ace_code {
height: 525px;
}
#ace_editor_demo, #embedded_ace_code {
height: 275px;
border: 1px solid #DDD;
border-radius: 4px;
border-bottom-right-radius: 0px;
margin-top: 5px;
}
.ace_editor {
    position:relative !important;
}
.sortablePages { list-style-type: none; margin: 0; padding: 8px; width: 300px; }
.sortablePages li { margin: 0 3px 3px 3px; padding: 0px; padding-left: 20px;background: #DDD }
.ui-state-highlight { height: 20px; line-height: 5px; }
.ui-state-disabled {opacity: 1}
</style>
<?php $this->endClip();?>
<?php $this->beginClip('extraJS')?>
<script type="text/javascript" src="<?=app()->request->baseUrl?>/admin/js/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="<?=app()->request->baseUrl?>/admin/js/elfinder/elfinder.min.js"></script>
<script type="text/javascript" src="<?=app()->request->baseUrl?>/admin/js/elfinder/elfinder.ru.js"></script>
<script src="http://d1n0x3qji82z53.cloudfront.net/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    $(function(){
        $('.__js_pageSites').addClass('active');
        $('.__js_site<?=query('id')?>').addClass('active');
        
        // Настройки сайта
        $('.__js_saveSiteSettings').click(function(e){
            e.preventDefault();
            var error = '';
            if(!$('#inputSiteTitle').val()){
                error += '- Введите заголовок сайта<br />';
            }
            if(!$('#inputSiteDomains').val()){
                error += '- Введите домены<br />';
            // TODO: Доделать для русских доменов
            }else if(!String($('#inputSiteDomains').val()).match(/^[a-zA-Z0-9-_\.,]+$/)){
                error += '- Домены должны содержать только буквы латинского алфавита<br />';
            }
            if(error){
                $('.__js_siteError').removeClass('alert-success alert-error').addClass('alert-error');
                $('.__js_siteError').html(error);
                $('.__js_siteError').show();
                return false;
            }
            var request = {};
            request.siteId = '<?=$site?$site->id:''?>';
            request.title = $('#inputSiteTitle').val();
            request.domains = $('#inputSiteDomains').val();
            $.getJSON('<?=app()->createUrl('admin/ajaxSaveSiteSettings')?>', request, function(json) {
                if(json.error){
                    $('.__js_siteError').removeClass('alert-success alert-error').addClass('alert-error');
                    $('.__js_siteError').html(json.error);
                    $('.__js_siteError').show();
                }else if(json.save){
                    $('.__js_siteError').removeClass('alert-success alert-error').addClass('alert-success');
                    $('.__js_siteError').html('Успешно сохранено');
                    $('.__js_siteError').show();
                }
            });
        })
        
        // Подключаем ACE для шаблонов
        var embedded_editor = ace.edit("embedded_ace_code");
        embedded_editor.container.style.opacity = "";
        embedded_editor.getSession().setMode("ace/mode/php");
        
        // Страницы
        // Подключаем ACE для страниц
        var page_editor = ace.edit("ace_edit_page");
        page_editor.container.style.opacity = "";
        page_editor.getSession().setMode("ace/mode/php");
        page_editor.setValue('');
        // Подключаем сортировку страниц
        $(".sortablePages" ).sortable({
            items: "li:not(.ui-state-disabled)",
            placeholder: "ui-state-highlight",
            connectWith: ".sortablePages",
            opacity: 0.8,
            dropOnEmpty: true,
            receive: function( event, ui ) {
                // Куда помещаем: event.target, откуда помещаем: ui.item
                var request = {};
                request.siteId = '<?=$site?$site->id:''?>';
                request.pageId = $(ui.item).attr('pageId');
                request.parent = $(event.target).attr('pageId');
                $.getJSON('<?=app()->createUrl('admin/ajaxChangePageParent')?>', request, function(json) {
                    if(json.error){
                        alert(json.error);
                    }else{
                    }
                });
            }
        }).disableSelection();
        $(document).on('click','.__js_expandPage',function(e){
            e.preventDefault();
            var pageId = $(this).attr('pageId');
            $('.sortablePages[pageId="'+pageId+'"]').empty();
            if($(this).hasClass('__js_expanded')){
                $(this).find('i').removeClass('icon-chevron-up').addClass('icon-chevron-down');
                $(this).removeClass('__js_expanded');
            }else{
                var request = {'pageId':pageId};
                $(this).find('i').removeClass('icon-chevron-down').addClass('icon-chevron-up');
                $(this).addClass('__js_expanded');
                $.getJSON('<?=app()->createUrl('admin/ajaxLoadPages')?>', request, function(json) {
                    if(json.error){
                        alert(json.error);
                    }else if(json.pages){
                        $(this).find('i').removeClass('icon-chevron-up').addClass('icon-chevron-down');
                        for(var key in json.pages){
                            $('.sortablePages[pageId="'+pageId+'"]').append('<li class="ui-state-default" pageId="'+key+'"><a href="#" class="__js_expandPage" pageId="'+key+'" style="cursor:pointer"><i class="icon-chevron-down"></i></a>&nbsp;&nbsp;&nbsp;'+json.pages[key]+'<a href="#" class="__js_editPage" pageId="'+key+'" style="float:right;margin:5px 10px 0 0"><i class="icon-pencil"></i></a> <ul class="sortablePages" pageId="'+key+'"></ul>');
                        }
                    }
                });
            }
        });
        $(document).on('click','.__js_editPage', function(e){
            e.preventDefault();
            $('#inputPageName').val('');
            $('#inputPageCode').val('');
            page_editor.setValue('');
            $('.__js_pageEditor').hide('fast');
            var request = {};
            request.pageId = $(this).attr('pageId');
            request.siteId = '<?=$site?$site->id:''?>';
            $.getJSON('<?=app()->createUrl('admin/ajaxLoadPage')?>', request, function(json) {
                if(json.error){
                    alert(json.error);
                }else{
                    $('#inputPageId').val(json.id);
                    $('#inputPageName').val(json.name);
                    $('#inputPageCode').val(json.code);
                    if(json.code == 'index' && json.parent == 0){
                        $('#inputPageCode').attr('disabled','disabled');
                    }else{
                        $('#inputPageCode').removeAttr('disabled');
                    }
                    page_editor.setValue(json.content);
                    page_editor.clearSelection();
                    if(json.active == 1){
                        $('#inputPageActive').attr('checked','checked');
                    }else{
                        $('#inputPageActive').removeAttr('checked');
                    }
                    $('.__js_pageEditor').show('fast');
                }
            });
        });
        $(document).on('click','.__js_cancelPageEdit', function(e){
           e.preventDefault();
           $('#inputPageName').val('');
           $('#inputPageCode').val('');
           page_editor.setValue('');
           $('.__js_pageEditor').hide('fast');
        });
        $(document).on('click','.__js_savePageEdit', function(e){
            e.preventDefault();
            var request = {};
            request.pageId = $('#inputPageId').val();
            request.siteId = '<?=$site?$site->id:''?>';
            request.name = $('#inputPageName').val();
            request.code = $('#inputPageCode').val();
            request.content = page_editor.getValue();
            request.active = $('#inputPageActive:checked')[0]?1:0;
            $.getJSON('<?=app()->createUrl('admin/ajaxSavePage')?>', request, function(json) {
                if(json.error){
                    $('.__js_pageError').removeClass('alert-success').addClass('alert-error');
                    $('.__js_pageError').html(json.error).show();
                }else if(json.save){
                    $('.__js_pageError').hide();
                    $('.__js_cancelPageEdit').click();
                }
            });
        })
        
        
        // Подключаем ElFinder
        // elfinder options
        var aceEditor = false;
        var opts = {
          commandsOptions : {
            edit : {
              editors : [
                {
                  mimes : ['text/html','text/plain'],  // add here other mimes if required
                  load : function(textarea) {
                    $('#'+textarea.id).closest('div').prepend('<div id="editor" style="background-color:#FFF;width:100%;height:'+$('#'+textarea.id).height()+'px">'+(String(String(textarea.value).replace(/</gi,'&lt;')).replace(/>/gi,'&gt;'))+'</div>');
                    $('#'+textarea.id).hide();
                    aceEditor = ace.edit('editor');
                    aceEditor.container.style.opacity = "";
                    aceEditor.getSession().setMode("ace/mode/html");
                    //tinyMCE.execCommand('mceAddControl', true, textarea.id);
                  },
                  close : function(textarea, instance) {
                    $('#editor').remove();
                    //tinyMCE.execCommand('mceRemoveControl', false, textarea.id);
                  },
                  save : function(textarea, editor) {
                    textarea.value = aceEditor.getValue();
                    //textarea.value = tinyMCE.get(textarea.id).selection.getContent({format : 'html'});
                    //tinyMCE.execCommand('mceRemoveControl', false, textarea.id);
                  }
                }
              ]
            }
          },
          url : '<?=app()->createUrl('admin/ajaxElfinder/siteId/'.($site?$site->id:''))?>',
          lang: 'ru'
        }
        var elf = $('#elfinder').elfinder(opts).elfinder('instance');
    });
</script>
<?php $this->endClip();?>