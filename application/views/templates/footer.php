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
            <a href="" class="details"><div>Официальный сайт <b>satoworld.ru</b></div></a>
            <div class="copyright">
                <b>© SATO 2015</b>
                <div class="about">Международная корпорация, производитель и надежный поставщик широкого спектра специальной электронной техники, электронной сантехнической продукции.</div>
            </div>
        </div>
    </div>
</footer>
</body>
</html>