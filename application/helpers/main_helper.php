<?php

function rus2translit($string)
{
    $string = trim($string);
	$converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "",  'ы' => 'y',   'ъ' => "",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'a',   'Б' => 'b',   'В' => 'v',
        'Г' => 'g',   'Д' => 'd',   'Е' => 'e',
        'Ё' => 'e',   'Ж' => 'zh',  'З' => 'z',
        'И' => 'i',   'Й' => 'y',   'К' => 'k',
        'Л' => 'l',   'М' => 'm',   'Н' => 'n',
        'О' => 'o',   'П' => 'p',   'Р' => 'r',
        'С' => 's',   'Т' => 't',   'У' => 'u',
        'Ф' => 'f',   'Х' => 'h',   'Ц' => 'c',
        'Ч' => 'ch',  'Ш' => 'sh',  'Щ' => 'sch',
        'Ь' => "",    'Ы' => 'y',   'Ъ' => "",
        'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya',
    
        ' ' => '-',   '-' => '-',   '"' => '', 
        '\'' => '',   '`' => '',    '@' => '',
        ',' => '-',   '.' => '-',   '#' => '',
        '%' => '',    '>' => ''
        
    );
    return strtr($string, $converter);
}

function modifyDate($date)
{
    $months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня',
            'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
    $d = new DateTime($date);
    return $d->format('d') . ' ' . $months[($d->format('m') - 1)];
}
