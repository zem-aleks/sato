<style>
    .my-table{
        width : 100%;
    }
    .my-table .top-row {
        background-color: #fdd661;
    }
    .my-table tr {
        border: 0px;
    }
    .my-table tr td {
        border: 0px;
    }
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        border: 0px;
        padding: 10px 24px;
    }
    .my-table tr.two {
        background-color: #edf0f2;
    }
    .my-table .top-row td {
        padding: 20px 24px;
        font-weight: bold;
        font-size: 20px;
    }
    .table.my-table {
        border-radius: 10px;
        -webkit-border-radius: 10px;
        overflow: hidden;
        margin-top: 30px;
        font-size: 16px;
    }
    .my-table tr.sub td {
        font-weight: bold;
    }
    .all-prices{
        position: relative;
    }
    .all-prices .container{
        position: relative;
        z-index: 333;
    }
    .table-shadow{
        -webkit-box-shadow: 0px 2px 10px 0px rgba(50, 50, 50, 0.4);
        -moz-box-shadow:    0px 2px 10px 0px rgba(50, 50, 50, 0.4);
        box-shadow:         0px 2px 10px 0px rgba(50, 50, 50, 0.4);
        border-radius: 10px;
        -webkit-border-radius: 10px;
        background-color: #fff;
    }
    input[type="text"] {
        display: inline-block;
        margin: 0px 10px;
        padding: 0px 4px;
    }
    select.price-type {
        width: 130px;
    }
    .my-table input.price-name {
        width: 300px;
    }
    .my-table input.price-value{
        width: 180px;'
        }
    </style>

    <div class="all-prices narrow">
        <div class="pattern big"></div>
        <div class="container">
            <h1>Цены</h1>
            <form action="" method="POST">
            <div class="table-shadow">
                <div class="table-icons"></div>
                <table class="table my-table">
                    <tr class="top-row">
                        <td colspan="2">Привлечение клиентов</td>
                    </tr>
                    <tr class="sub">
                        <td colspan="2">Продвижение сайта</td>
                    </tr>
                    <tr class="two">
                        <td>Продвижение сайтов с оплатой по словам</td>
                        <td class="right"><input type="text" name="prices[1]" value="<?=$prices[1] ; ?>" /></td>
                    </tr>
                    <tr >
                        <td>Продвижение молодых сайтов</td>
                        <td class="right"><input type="text" name="prices[2]" value="<?=$prices[2] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td>Продвижение с оплатой за переход</td>
                        <td class="right"><input type="text" name="prices[3]" value="<?=$prices[3] ; ?>" /></td>
                    </tr>
                    <tr class=""> 
                        <td>Продвижение с оплатой за действия</td>
                        <td class="right"><input type="text" name="prices[4]" value="<?=$prices[4] ; ?>" /></td>
                    </tr>
                    <tr class="sub two">
                        <td colspan="2">SEO-аудит сайта</td>
                    </tr>
                    <tr class=""> 
                        <td>Контекстная реклама</td>
                        <td class="right"><input type="text" name="prices[5]" value="<?=$prices[5] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td>Медийная реклама</td>
                        <td class="right"><input type="text" name="prices[6]" value="<?=$prices[6] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td class="high">Реклама в социальных сетях</td>
                        <td class="right"><input type="text" name="prices[7]" value="<?=$prices[7] ; ?>" /></td>
                    </tr>
                    <tr class="top-row">
                        <td colspan="2">Создание сайтов</td>
                    </tr>
                    <tr class=""> 
                        <td>Создание лендинговой страницы</td>
                        <td class="right"><input type="text" name="prices[8]" value="<?=$prices[8] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td>Создание корпартивного сайта</td>
                        <td class="right"><input type="text" name="prices[9]" value="<?=$prices[9] ; ?>" /></td>
                    </tr>
                    <tr class=""> 
                        <td>Порталы, сервисы и соцсети</td>
                        <td class="right"><input type="text" name="prices[10]" value="<?=$prices[10] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td class="high">Интернет магазины <br /></td>
                        <td class="right"><input type="text" name="prices[11]" value="<?=$prices[11] ; ?>" /></td>
                    </tr>
                    <tr class="top-row">
                        <td colspan="2">Другие услуги</td>
                    </tr>
                    <tr class=""> 
                        <td>Поддержка сайтов</td>
                        <td class="right"><input type="text" name="prices[12]" value="<?=$prices[12] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td>Доработка сайтов</td>
                        <td class="right"><input type="text" name="prices[13]" value="<?=$prices[13] ; ?>" /></td>
                    </tr>
                    <tr class=""> 
                        <td>Написано текстов</td>
                        <td class="right"><input type="text" name="prices[14]" value="<?=$prices[14] ; ?>" /></td>
                    </tr>
                    <tr class="two"> 
                        <td class="high">Улучшение продающих свойств сайта</td>
                        <td class="right"><input type="text" name="prices[15]" value="<?=$prices[15] ; ?>" /></td>
                    </tr>
                </table>
            </div>
                <input type="submit" value="Сохранить">
            </form>
            <br><br>
        </div>
    </div>


