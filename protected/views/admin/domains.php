<?php $this->renderPartial('widgetSites', array('sites'=>$sites));?>
<div class="span9">
    <div class="well">
        <?php if(!$sites):?>
        Не найдены сайты.<br />
        <a href="<?=app()->createUrl('admin/sites', array('new'=>1))?>">Добавить новый сайт</a>
        <?php else:?>
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th class="span1">#</th>
                    <th class="span3">Домен</th>
                    <th class="span3">Сайт</th>
                    <th class="span2">Действия</th>
                </tr>
            </thead>
            <tbody>
        <?php $n = 1;?>
        <?php foreach($domains as $domain):?>
                <tr class="__js_domain" domainId="<?=$domain->id?>">
                    <td><?=$n?></td>
                    <td><?=$domain->domain_name?></td>
                    <td><a href="<?=app()->createUrl('admin/siteEdit/id/'.$domain->site->id)?>"><?=$domain->site->title?></a></td>
                    <td><a href="#" class="__js_editDomain"><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="#" class="__js_saveDomain" isdelete="1"><i class="icon-trash"></i></a></td>
                </tr>
                <tr class="__js_editableDomain hide" domainId="<?=$domain->id?>">
                    <td><?=$n?></td>
                    <td><input type="text" class="span2 __js_domainName" value="<?=$domain->domain_name?>"></td>
                    <td><select class="span2 __js_domainSite">
                        <?php foreach($sites as $site):?>
                        <option value="<?=$site->id?>" <?=($site->id==$domain->site->id)?'selected':''?>><?=$site->title?></option>
                        <?php endforeach;?>
                    </select></td>
                    <td><a href="#" class="__js_saveDomain"><i class="icon-ok"></i></a>&nbsp;&nbsp;&nbsp;<a href="#" class="__js_closeDomain"><i class="icon-remove"></i></a></td>
                </tr>
           <?php $n++;?>
        <?php endforeach;?>
                <tr class="__js_new">
                    <td colspan="4"><a href=#" class="__js_newDomain">Добавить новый домен</a></td>
                </tr>
                <tr class="__js_newEdit hide">
                    <td><?=$n?></td>
                    <td><input type="text" class="span2 __js_domainName" value=""></td>
                    <td><select class="span2 __js_domainSite">
                        <?php foreach($sites as $site):?>
                        <option value="<?=$site->id?>"><?=$site->title?></option>
                        <?php endforeach;?>
                    </select></td>
                    <td><a href="#" class="__js_saveDomain" isnew="1"><i class="icon-ok"></i></a>&nbsp;&nbsp;&nbsp;<a href="#" class="__js_closeDomain"><i class="icon-remove"></i></a> </td>
                </tr>
            </tbody>
        </table>
        <?php endif;?>
    </div>
</div>
<?php $this->beginClip('extraJS')?>
<script>
    var adminUrl = '<?=app()->createUrl('admin')?>';
    var sites = {<?php foreach($sites as $site):?><?=('"'.$site->id.'":"'.$site->title.'",')?><?php endforeach;?>"end":1};
    $(function(){
        $('.__js_pageSites').addClass('active');
        $('.__js_domains').addClass('active');
        
        $(document).on('click','.__js_editDomain',function(e){
           e.preventDefault();
           $(this).closest('tr').hide().next().show();
        });
        
        $(document).on('click','.__js_closeDomain',function(e){
           e.preventDefault();
           $(this).closest('tr').hide().prev().show();
        });
        
        $(document).on('click','.__js_newDomain',function(e){
           e.preventDefault();
           $(this).closest('tr').hide().next().show();
        });
        
        $(document).on('click','.__js_saveDomain',function(e){
            e.preventDefault();
            var thisDomain = $(this).closest('tr');
            var request = {};
            if($(this).attr('isnew')){
                request.isnew = 1;
                request.domainName = $(this).closest('tr').find('.__js_domainName').val();
                request.siteId = $(this).closest('tr').find('.__js_domainSite').val();
            }else if($(this).attr('isdelete')){
                request.isdelete = $(this).closest('tr').attr('domainId');
            }else{
                request.id = $(this).closest('tr').attr('domainId');
                request.domainName = $(this).closest('tr').find('.__js_domainName').val();
                request.siteId = $(this).closest('tr').find('.__js_domainSite').val();
            }
            $.getJSON('<?=app()->createUrl('admin/ajaxSaveDomain')?>', request, function(json) {
                if(json.error){
                    alert(json.error);
                }else if(json.added){
                    var newDomain = '<tr class="__js_domain" domainId="'+json.added+'">' +
                    '<td>'+$(thisDomain).find('td:first').html()+'</td>' +
                    '<td>'+request.domainName+'</td>' +
                    '<td><a href="'+adminUrl+'/siteEdit/id/'+request.siteId+'">'+sites[request.siteId]+'</a></td>' +
                    '<td><a href="#" class="__js_editDomain"><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="#" class="__js_saveDomain" isdelete="1"><i class="icon-trash"></i></a></td>' +
                    '</tr>';
                    var editDomain = $('.__js_newEdit').clone().removeClass('__js_newEdit').addClass('__js_editableDomain').attr('domainId',json.added);
                    $(editDomain).find('.__js_saveDomain').removeAttr('isnew');
                    $('.__js_new').before(newDomain);
                    $('.__js_new').before(editDomain);
                    $(newDomain).show();
                    $(editDomain).hide();
                    $(thisDomain).find('.__js_closeDomain').click();
                    $(thisDomain).find('td:first').html(parseInt($('.__js_new').prev().find('td:first').html())+1);
                }else if(json.deleted){
                    $('tr[domainId="'+request.isdelete+'"]').remove();
                    $('.__js_newEdit td:first').html(parseInt($('.__js_new').prev().find('td:first').html())+1);
                }else if(json.saved){
                    $(thisDomain).prev().find('td:nth-child(2)').html(request.domainName);
                    $(thisDomain).prev().find('td:nth-child(3)').html('<a href="'+adminUrl+'/siteEdit/id/'+request.siteId+'">'+sites[request.siteId]+"</a>");
                    $(thisDomain).find('.__js_closeDomain').click();
                }
            });
        })
    });
</script>
<?php $this->endClip();?>