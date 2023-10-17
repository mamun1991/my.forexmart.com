<?php
class SessionLog
{
    function log() {
        $ci =& get_instance();
        $ci->log_db = $ci->load->database('logs', true);
        $ci->load->model('general_model');
        $date_today = date('Ym');
        $table_name = 'log_' . $date_today;
        $user_id = $ci->session->userdata('user_id');
        $date_now = date('Y-m-d H:i:s');
        if(!$ci->input->is_ajax_request()) {
            if ($user_id && !IPLoc::Office()) {
                if (!$ci->log_db->table_exists($table_name)) {
                    $ci->dbForge2 = $ci->load->dbforge($ci->log_db, true);
                    $ci->dbForge2->add_key('id', true);
                    $fields = array(
                        'id' => array(
                            'type' => 'INT',
                            'constraint' => 11,
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                        ),
                        'session_id' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                        ),
                        'user_id' => array(
                            'type' => 'INT',
                            'constraint' => 11,
                            'unsigned' => FALSE,
                            'auto_increment' => FALSE
                        ),
                        'page' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 800,
                        ),
                        'date_visited' => array(
                            'type' => 'DATETIME'
                        ),
                        'ip' => array(
                            'type' => 'VARCHAR',
                            'constraint' => 100,
                        ),
                    );
                    $ci->dbForge2->add_field($fields);
                    $ci->dbForge2->create_table($table_name);
                    $main_data = array(
                        'table_name' => $table_name,
                        'date_created' => $date_now
                    );
                    $ci->log_db->insert('main_log', $main_data);
                }

                $data = array(
                    'session_id' => session_id(),
                    'user_id' => $user_id,
                    'page' => current_url(),
                    'date_visited' => $date_now,
                    'ip' => $ci->input->ip_address()
                );

                $ci->log_db->insert($table_name, $data);
            }
        }
        //FXPP::preventPost();
        // only access allowed IP
        if(!IPLoc::blacklistIPs()){

            show_404(); exit();
        }
    }
}