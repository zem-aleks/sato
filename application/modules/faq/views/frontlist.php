<div class="faq-page">
    <div class="container">
        <div class="row">
            <? foreach($entries as $entry): ?>
            <a href="/faq/view/<?=$entry['chpu'];?>" class="col-xs-4">
                <div>
                    <h4><?=$entry['name'];?></h4>
                    <div class="answer">
                        <div>Ответ</div>
                        <?=$entry['answer'];?>
                    </div>
                </div>
            </a>
            <? endforeach;?>
        </div>
        
        <div class="pagination"><?=$paginator; ?></div>
    </div>
</div>