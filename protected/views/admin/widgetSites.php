<div class="span2 __js_leftMenu" style="width:160px">
        <ul class="nav nav-list" role="menu" aria-labelledby="dropdownMenu" style="width:160px;">
          <li class="__js_newSite"><a tabindex="-1" href="<?=app()->createUrl('admin/sites/new/1')?>">Добавить новый</a></li>
          <li class="divider"></li>
          <li class="__js_domains"><a tabindex="-1" href="<?=app()->createUrl('admin/domains')?>">Редактировать домены</a></li>
          <?php if($sites):?>
          <li class="divider"></li>
          <li class="nav-header">Активные сайты</li>
          <?php foreach($sites as $site):?>
          <li class="__js_site<?=$site->id?>"><a tabindex="-1" href="<?=app()->createUrl('admin/siteEdit/id/'.$site->id)?>"><?=$site->title?></a></li>
          <?php endforeach;?>
          <?php endif;?>
        </ul>
</div>
<div class="span1 __js_hideMenu" style="width:15px;margin-right:-15px;cursor:pointer;border:#ccc 1px solid;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;background-color: #f1f1f1"><i class="icon-arrow-left"></i></div>
<?php $this->beginClip('widgetJS')?>
<script>
    $(function(){
        $('.__js_hideMenu').css('height',(parseInt($('.__js_leftMenu').height())/2)+15);
        $('.__js_hideMenu').css('padding-top',(parseInt($('.__js_leftMenu').height())/2)-15);
        $('.__js_hideMenu').click(function(e){
            e.preventDefault();
            if($('.span2').css('display') == 'none'){
                $(this).html('<i class="icon-arrow-left"></i>')
                $('.__js_mainContent').removeClass('span11').addClass('span9');
                $('.__js_leftMenu').show('fast');
            }else{
                $(this).html('<i class="icon-arrow-right"></i>')
                $('.__js_leftMenu').hide('fast', function(){
                    $('.__js_mainContent').removeClass('span9').addClass('span11');
                });
            }
        })
    });
</script>
<?php $this->endClip();?>