<?php
class Change_Config {
    public function change_session_expiration() {
        $ci = & get_instance();

        $remember = $ci->session->userdata('remember_me');

        if($remember && $ci->session->sess_expire_on_close) {
            $new_expiration = (60*60*24*365); //A year milliseconds

            $ci->config->set_item('sess_expiration', $new_expiration);
            $ci->config->set_item('sess_expire_on_close', FALSE);

            $ci->session->sess_expiration = $new_expiration;
            $ci->session->sess_expire_on_close = FALSE;
        }
    }
}