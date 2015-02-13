<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mail extends Controller 
{
    var $headers=null;
    var $images=null;
    
    function Mail() 
    {
        parent::__construct();
        session_start();
        $this->headers='MIME-Version: 1.0' . "\r\n";
        $this->headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        //$this->headers .= 'From: SATO <no_reply@smokegadgets.com>' . "\r\n";
    }
    
    function sendMessage($email, $title, $text)
    {
        mail($email, $title, $text,  $this->headers);
    }
    
    function sendFeedback($name,$email,$feedback)
    {
        $text="<table border='1' align='center' cellpadding='5' cellspacing='0' width='600'><tbody><tr>";
        $text.="<td width='300' align='center'>Имя: ".$name."</td>";
        $text.="<td width='300' align='center'>Email: ".$email."</td>";
        $text.="</tr>";
        $text.="<tr><td colspan='2' align='left'>".$feedback."</td></tr>";
        $text.="</tbody></table>";
        $settings=$this->load->module('settings')->getListSettings();
        $email= $settings['emailFeedback'];
            
        if(!empty($email))
            mail($email, 'Сообщение отправленное через обратную связь', $text,  $this->headers);
    }
    
    function sendPurchase($info, $items)
    {
        $settings = $this->load->module('settings')->getListSettings();
        //$cities = explode("\n", $settings['city_list']);
        //$delivery = explode("\n", $settings['delivery_list']);
        //$pay = explode("\n", $settings['pay_list']); 
        
        $address = $info['address'];
        $idUser = $this->load->module('users')->addUser($info['name'], $info['phone'], $info['email'], $address, 1);
        
        $text  = '<table border="1" align="center" cellpadding="5" cellspacing="0" width="800"><tbody><tr>';
        $text .=    '<td align="center" colspan="3">'
                  . '<a href="'.base_url().'">'
                  . '<img src="'.base_url().'images/front/logo-header.jpg" title="Sato" alt="Sato" />' 
                  . '</a>'
                  . '</td>';
        $text .= '</tr><tr>';
        $text .= "<td>Имя получателя (ФИО): " . $info['name'] . "</td>";
        $text .= '<td>' . $info['delivery'] . '</td>';
        $text .= '<td>Оплата</td>';
        $text .= '</tr><tr>';
        $text .= "<td>Телефон: " . $info['phone'] . " E-mail: " . $info['email'] . "</td>";
        $text .= '<td>Адрес: ' . $address . '</td>';
        $text .= '<td>' . $info['pay'] . '</td>';
        $text .= '</tr><tr>';
        $text .= '<td colspan="3">Комментарий: ' . $info['comment'] . '</td>';
        $text .= '</tr>';
        $text .= "</tbody></table>";


        $del='<br/>';
        $text.=$del.$del;
        $text.="<table border='1' align='center' cellpadding='5' cellspacing='0' width='800'><thead><tr>";
        $text.='
        <td>№ п/п</td> 
        <td>ID</td>   
        <td>Название</td> 
        <td>Цена за шт.</td>  
        <td>Количество</td> 
        <td>Сумма</td>  
        </tr></thead><tbody>';
        $k=1;
        $sum=0.;
        foreach($items as $item)
        {
            $detail = $item['detail']? ' (Размер - ' . $item['detail'] . ')' : '';
            $text.='<tr>';
            $text.='<td>'.$k++.'</td>';
            $text.='<td>'.$item['ID'].'</td>';
            $text.='<td>'.$item['name']. $detail . '</td>';
            $text.='<td>'.$item['price'].' руб.</td>';
            $text.='<td>'.$item['count'].'</td>';
            $text.='<td>'.$item['count']*$item['original_price'].' руб.</td>';
            $text.='</tr>';
            
            $sum+=$item['count']*$item['original_price'];
        }
        $text.='<tr><td align="right" colspan="6">Итого: '.$sum.' руб.</td></tr>';
        $text.='</tbody></table>';
        
        $email = $settings['emailContact'];
        
        $id_order = $this->load->module('orders')->add($info['name'], $info['phone'], $info['email'], $address,  $text, $items);
        $text='<center><b>Номер заказа: ' . $id_order . '</b></center><br/>'.$text;
        
        if (!empty($email)) {
            if (mail($info['email'], 'Заказ товара', $text, $this->headers) 
                && mail($email, 'Заказ товара', $text, $this->headers)
            ) {
                /*$this->load->helper('sms');
                $account = getAccount();
                if (!empty($account['login']) && !empty($account['password']) && !empty($account['from']) ) {
                    $sms = 'Postupil zakaz №' . $id_order . ' na summu ' . $sum . ' grn.';
                    //sms_send($account['login'], $account['password'], $account['from'], $settings['sms'], $sms);
                    
                    $sms = 'Spasibo za vash zakaz №' . $id_order 
                            . ' na summu ' . $sum
                            . ' grn. My svyajemsya s vami v blijayshee vremya dlya utochneniya detaley zakaza.';
                    sms_send($account['login'], $account['password'], $account['from'], $info['phone'], $sms);
                } */
                return $id_order;
            }
            else
                return false;
        }
        return false;
    }
    
    
    function sendPurchaseQuick($info, $items)
    {
        $settings = $this->load->module('settings')->getListSettings();
        $this->load->module('users')->addUser($info['name'], $info['phone'], $info['email'], $address, 1);
        
        $text  = '<table border="1" align="center" cellpadding="5" cellspacing="0" width="800"><tbody><tr>';
        $text .=    '<td align="center" colspan="3">'
                  . '<a href="http://smoke-gadgets.com">'
                  . '<img src="http://smoke-gadgets.com/images/front/logo.png" title="Smoke Gadgets" alt="Smoke Gadgets" />' 
                  . '</a>'
                  . '</td>';
        $text .= '</tr><tr>';
        $text .= "<td>Имя получателя (ФИО): " . $info['name'] . "</td>";
        $text .= "<td>Телефон: " . $info['phone'] . "</td>";
        $text .= "<td>E-mail: " . $info['email'] . "</td>";
        $text .= '</tr>';
        $text .= "</tbody></table>";


        $del='<br/>';
        $text.=$del.$del;
        $text.="<table border='1' align='center' cellpadding='5' cellspacing='0' width='800'><thead><tr>";
        $text.='
        <td>№ п/п</td> 
        <td>ID</td>   
        <td>Название</td> 
        <td>Цена за шт.</td>  
        <td>Количество</td> 
        <td>Сумма</td>  
        </tr></thead><tbody>';
        $k=1;
        $sum=0.;
        foreach($items as $item)
        {
            $text.='<tr>';
            $text.='<td>'.$k++.'</td>';
            $text.='<td>'.$item['ID'].'</td>';
            $text.='<td>'.$item['name'].'</td>';
            $text.='<td>'.$item['price'].' грн.</td>';
            $text.='<td>'.$item['count'].'</td>';
            $text.='<td>'.$item['count']*$item['price'].' грн.</td>';
            $text.='</tr>';
            
            $sum+=$item['count']*$item['price'];
        }
        $text.='<tr><td align="right" colspan="6">Итого: '.$sum.' грн. + Доставка: ' . $settings['delivery_price'] . ' грн.</td></tr>';
        $text.='</tbody></table>';
        
        $email = $settings['emailItems'];
        
        $id_order = $this->load->module('orders')->add($info['name'], $info['phone'], $info['email'], $address,  $text, $items, 1);
        $text='<center><b>Номер заказа: ' . $id_order . '</b></center><br/>'.$text;
        
        
        
        if (!empty($email)) {
            if (mail($email, 'Заказ товара', $text, $this->headers)) {
                if(!empty($info['email']))
                    mail($info['email'], 'Заказ товара', $text, $this->headers);
                $this->load->helper('sms');
                $account = getAccount();
                if (!empty($account['login']) && !empty($account['password']) && !empty($account['from']) ) {
                    $sms = 'Postupil zakaz №' . $id_order . ' na summu ' . $sum . ' grn.';
                    sms_send($account['login'], $account['password'], $account['from'], $settings['sms'], $sms);
                    
                    $sms = 'Spasibo za vash zakaz №' . $id_order 
                            . ' na summu ' . $sum
                            . ' grn. My svyajemsya s vami v blijayshee vremya dlya utochneniya detaley zakaza.';
                    sms_send($account['login'], $account['password'], $account['from'], $info['phone'], $sms);
                } 
                return $id_order;
            }
            else
                return false;
        }
        return false;
    }
    
    function sendMail($code)
    {
        if($code == 'top-secret') {
            $mail = $this->load->view('templates/mail', '', true);
            $this->db->select('email');
            $query = $this->db->get('users');
            $users = $query->result_array();
            foreach ($users as $user) {
                mail($user['email'], 'Выиграй Farida Gold одним кликом', $mail, $this->headers);
            }
            echo 'Success';
        } elseif($code == 'test') {
            $mail = $this->load->view('templates/mail', '', true);
            mail('aleksz_07@mail.ru', 'Выиграй Farida Gold одним кликом', $mail, $this->headers);
            mail('nlight115@gmail.com', 'Выиграй Farida Gold одним кликом', $mail, $this->headers);
            mail('8rowling8@gmail.com', 'Выиграй Farida Gold одним кликом', $mail, $this->headers);
        } else { 
            show_404 ();
        }
    }
    
}
?>
