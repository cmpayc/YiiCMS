<div class="span3">
        <ul class="nav nav-list" role="menu" aria-labelledby="dropdownMenu" style="width:200px;">
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