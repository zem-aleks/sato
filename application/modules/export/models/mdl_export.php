<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_export extends Model {

    function Mdl_export() {
        parent::__construct();
    }

    function getTable($name) {
        $query = $this->db->get($name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        else
            return array();
    }

    function export_csv(
            $table, // Имя таблицы для экспорта
            $afields, // Массив строк - имен полей таблицы
            $filename, // Имя CSV файла для сохранения информации
            $delim = ';', // Разделитель полей в CSV файле
            $enclosed = '"', // Кавычки для содержимого полей
            $escaped = '\\\\', // Ставится перед специальными символами
            $lineend = '\\r\\n')// Чем заканчивать строку в файле CSV
     {   
        //error_reporting(E_ALL);
        $q_export =
                "SELECT " . implode(',', $afields) .
                "   INTO OUTFILE '" . $filename . "' " .
                "FIELDS TERMINATED BY '" . $delim . "' ENCLOSED BY '" . $enclosed . "' " .
                "    ESCAPED BY '" . $escaped . "' " .
                "LINES TERMINATED BY '" . $lineend . "' " .
                "FROM tbl_" . $table."
                 ORDER BY ".$afields[0]
        ;
        // Если файл существует, при экспорте будет выдана ошибка
        if (file_exists( $filename))
            unlink( $filename);
        return mysql_query($q_export);
    }

    function import_csv(
            $table, // Имя таблицы для импорта
            $afields, // Массив строк - имен полей таблицы
            $filename, // Имя CSV файла, откуда берется информация  (путь от корня web-сервера)
            $delim = ';', // Разделитель полей в CSV файле
            $enclosed = '"', // Кавычки для содержимого полей
            $escaped = '\\\\', // Ставится перед специальными символами
            $lineend = '\r\n', // Чем заканчивается строка в файле CSV
            $hasheader = FALSE) 
    {   // Пропускать ли заголовок CSV
        if ($hasheader)
            $ignore = "IGNORE 1 LINES ";
        else
            $ignore = "";
        
        $this->db->empty_table($table); 
        $q_import =
                "LOAD DATA INFILE '" . $filename . "' INTO TABLE tbl_" . $table . " " .
                "CHARACTER SET cp1251 FIELDS TERMINATED BY '" . $delim . "' ENCLOSED BY '" . $enclosed . "' " .
                "    ESCAPED BY '" . $escaped . "' " .
                "LINES TERMINATED BY '" . $lineend . "' " .
                $ignore .
                "(" . implode(',', $afields) . ")";

        return mysql_query($q_import);
    }

}