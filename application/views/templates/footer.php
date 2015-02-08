</main>
</div>
<footer>
    <div class="container">
        <nav class="footer">
            <ul>
                <li><a href="/" class="logo"></a></li>
                <? foreach($menu as $item): ?>
                    <li><a href="<?= $item['url']; ?>" class="<?= ($item['chpu'] == $page) ? 'active' : '' ?>"><?= $item['cat_name']; ?></a></li>
                <? endforeach; ?>
            </ul>
        </nav>
        <div class="btm-line">
            <div class="details">Для диллеров <b>satoworld.ru</b></div>
            <div class="copyright">
                <b>© SATO 2015</b>
                <div class="about">Международная корпорация, производитель и надежный поставщик широкого спектра специальной электронной техники, электронной сантехнической продукции.</div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>