<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function show_editor($selectorString) {
    $editor = '
        <script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
        <script type="text/javaScript">
            $(window).ready(function(){
		tinymce.init({
                    selector: "' . $selectorString . '",
                    theme: "modern",
                    language : "ru",
                    plugins: [
                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                        "insertdatetime media nonbreaking save table contextmenu directionality",
                        "emoticons template paste textcolor jbimages"
                    ],
                    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
                    toolbar2: "print preview media | forecolor backcolor emoticons",
                    image_advtab: true,
                    height: 500,
                    relative_urls: false
                });
            });
	</script>';
    return $editor;
}

function uploadImage($path, $inputName = '', $watermark = 'white') {
    $result = array('status' => 0);
    
        $CI = & get_instance();
        $config['upload_path'] = $path . 'original/';  // задаем путь к директории upload
        $config['allowed_types'] = 'jpg|jpeg|png|gif'; // указываем допустимые расширения
        $config['max_size'] = '10024';  // max размер файла в Kb
        $config['max_width'] = '4000';  // max размер  по вертикали
        $config['max_height'] = '4000'; // max размер  по горизонтали
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = TRUE;

        $CI->load->library('upload', $config);
        if ($CI->upload->do_upload($inputName)) {   // сообщение об ошибке загрузки
            $result['status'] = 1;
            $result['img'] = $CI->upload->data();

            $width = $result['img']['image_width'];
            $height = $result['img']['image_height'];

            // croping main image
            /*if ($width > 900 || $height > 900) {
                $x_axis = 0;
                $y_axis = 0;
                if ($width > 900)
                    $x_axis = (int) (($width - 900) / 2);
                if ($height > 900)
                    $y_axis = (int) (($height - 900) / 2);
                $img_cfg_crop['image_library'] = 'gd2';
                $img_cfg_crop['source_image'] = $path . 'original/' . $result['img']['file_name'];
                $img_cfg_crop['maintain_ratio'] = FALSE;
                $img_cfg_crop['width'] = 900;
                $img_cfg_crop['height'] = 900;
                $img_cfg_crop['x_axis'] = $x_axis;
                $img_cfg_crop['y_axis'] = $y_axis;
                $CI->load->library('image_lib');
                $CI->image_lib->initialize($img_cfg_crop);
                $CI->image_lib->crop();
                $CI->image_lib->clear();
            }*/

            // create a thumb
            //$CI->image_lib->clear();
            $img_cfg_thumb['image_library'] = 'gd2';
            $img_cfg_thumb['source_image'] = $path . 'original/' . $result['img']['file_name'];
            $img_cfg_thumb['maintain_ratio'] = TRUE;
            $img_cfg_thumb['new_image'] = $path . 'thumb/' . $result['img']['file_name'];
            $img_cfg_thumb['width'] = 280;
            $img_cfg_thumb['height'] = 280;
            $CI->load->library('image_lib');
            $CI->image_lib->initialize($img_cfg_thumb);
            $CI->image_lib->resize();
            $CI->image_lib->clear();

            // add watermark
            /*
            $img_cfg_water['image_library'] = 'gd2';
            $img_cfg_water['source_image'] = $path . 'original/' . $result['img']['file_name'];
            $img_cfg_water['wm_vrt_alignment'] = 'middle';
            $img_cfg_water['wm_hor_alignment'] = 'center';
            if ($watermark == 'black')
                $img_cfg_water['wm_overlay_path'] = $_SERVER['DOCUMENT_ROOT'] . '/images/front/water_white.png';
            else
                $img_cfg_water['wm_overlay_path'] = $_SERVER['DOCUMENT_ROOT'] . '/images/front/water_black.png';
            $img_cfg_water['wm_opacity'] = 1;
            $img_cfg_water['wm_type'] = 'overlay';
            $CI->load->library('image_lib');
            $CI->image_lib->initialize($img_cfg_water);
            $CI->image_lib->watermark();
            $CI->image_lib->clear();*/
        } else {  // вывод параметров  переданного файла
            $result['status'] = -1;
            $result['error'] = $CI->upload->display_errors();
        }

    return $result;
}

function form_select($name = '', $sel_key, $sel_val, $options = array(), $selected = array(), $optgroup = false, $extra = '') {
    if (!is_array($selected)) {
        $selected = array($selected);
    }

    // If no selected state was submitted we will attempt to set it automatically
    if (count($selected) === 0) {
        // If the form name appears in the $_POST array we have a winner!
        if (isset($_POST[$name])) {
            $selected = array($_POST[$name]);
        }
    }

    if ($extra != '')
        $extra = ' ' . $extra;

    $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

    $form = '<select name="' . $name . '" id="' . $name . '"' . $extra . $multiple . ">\n";
    $form .= "<option value=''>Выбор из списка</option>\n";

    if (!empty($options))
        foreach ($options as $key => $val) {
            $key = (string) $key;



            if (is_array($val) && $optgroup) {
                $form .= '<optgroup label="' . $key . '">' . "\n";

                foreach ($val as $optgroup_key => $optgroup_val) {
                    $sel = (in_array($optgroup_val[$sel_key], $selected)) ? ' selected="selected"' : '';

                    $form .= '<option value="' . $optgroup_val[$sel_key] . '"' . $sel . '>' . (string) $optgroup_val[$sel_val] . "</option>\n";
                }

                $form .= '</optgroup>' . "\n";
            } else {

                $key2 = (!empty($val[$sel_key])) ? $val[$sel_key] : false;
                $val2 = (!empty($val[$sel_val])) ? $val[$sel_val] : false;

                if ($key2 && $val2) {
                    $sel = (in_array($key2, $selected)) ? ' selected="selected"' : '';
                    $form .= '<option value="' . $key2 . '"' . $sel . '>' . (string) $val2 . "</option>\n";
                }
            }
        }

    $form .= '</select>';

    return $form;
}



function resizeImage() {
    $img_cfg_thumb['image_library'] = 'gd2';
    $img_cfg_thumb['source_image'] = $path . 'original/' . $result['img']['file_name'];
    $img_cfg_thumb['maintain_ratio'] = TRUE;
    $img_cfg_thumb['new_image'] = $path . 'thumb/' . $result['img']['file_name'];
    $img_cfg_thumb['width'] = 150;
    $img_cfg_thumb['height'] = 150;
    $CI->load->library('image_lib');
    $CI->image_lib->initialize($img_cfg_thumb);
    $CI->image_lib->resize();
}