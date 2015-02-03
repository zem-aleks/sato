<div class="our-works shadow">
    <div class="container">
        <div class="title"><?=$title;?> <a href="/portfolio" class="more">Все работы</a></div>
        <div class="flexslider slider container">
            <ul class="slides">
                <? foreach($works as $work): ?>
                <li>
                    <div class="info left">
                        <a href="/portfolio/view/<?=$work['chpu'];?>" class="name"><?=$work['type'];?><br><span><?=$work['name'];?></span></a>
                        <div class="desc"><?=$work['annotation'];?></div>
                        <a href="<?=$work['link'];?>" class="link"><?=$work['link'];?></a>
                    </div>
                    <div class="thumb left"><img src="/uploads/<?=$upload_folder;?>/<?=$work['image'];?>" alt="" title=""></div>
                    <div class="clear"></div>
                </li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>
</div>