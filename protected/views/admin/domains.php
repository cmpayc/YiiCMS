<?php $this->renderPartial('widgetSites', array('sites'=>$sites));?>
<div class="span9">
    <div class="well">
        <table class="table table-condensed">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Домен</th>
                    <th>Сайт</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
        <?php $n = 1;?>
        <?php foreach($domains as $domain):?>
                <tr>
                    <td><?=$n?></td>
                    <td><?=$domain->domain_name?></td>
                    <td><a href="<?=app()->createUrl('admin/siteEdit/id/'.$domain->site->id)?>"><?=$domain->site->title?></a></td>
                    <td><i class="icon-pencil"></i> <i class="icon-trash"></i> </td>
                </tr>
           <?php $n++;?>
        <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->beginClip('extraJS')?>
<script>
    $(function(){
        $('.__js_pageSites').addClass('active');
        $('.__js_domains').addClass('active');
    });
</script>
<?php $this->endClip();?>