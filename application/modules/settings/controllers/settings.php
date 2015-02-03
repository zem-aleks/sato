<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Settings extends Controller {

    public $name = 'settings';
    public $md = 'mdl_settings';

    function Settings() {
        parent::__construct();
        header("Content-Type: text/html; charset=UTF-8");
        session_start();
        $this->load->model($this->md);
    }

    /* -----------------------admin function--------------------- */

    function admin_index($page = 0) {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        $content = array();
        $content['title'] = 'Настройки';
        $content['key'] = 0;
        $content['settings'] = $this->mdl_settings->getAllSettingsAdmin();

        $this->load->view('includes/admin_header', $content);
        $this->load->view('list', $content);
        $this->load->view('includes/admin_footer', $content);
    }

    function get_settings() {
        return $this->mdl_settings->getAllSettingsAdmin();
    }

    function getListSettings() {
        $settings = $this->mdl_settings->getAllSettingsAdmin();
        $result = array();
        foreach ($settings as $value) {
            $result[$value['name']] = $value['value'];
        }
        return $result;
    }

    function save() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('admin');
            exit();
        }
        if ($this->mdl_settings->save()) {
            redirect('dashboard/settings');
        }
    }

    /* ----------------end admin functions---------------------- */
}

