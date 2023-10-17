<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail_support extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->lang->load('datatable');
        $this->load->model(array('general_model','mailsupport_model'));
        $this->lang->load('mailsupport');
         $this->lang->load('currenttrades_lang'); 
    }

    public function compose() {
        if ($this->session->userdata('logged')) {
            $this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
            $this->form_validation->set_rules('textContent', 'Content', 'trim|required|xss_clean|callback_check_content');
            $this->form_validation->set_rules('email', 'Department', 'trim|required|xss_clean');

            $message = "";
            $hashed_img_name = null;
            $orig_img_name = null;

            if ($this->form_validation->run()) {
                $message = "display: block";
                $msg = array(
                    'userid' => $this->session->userdata('user_id'),
                    'subject' => $this->input->post('subject',true),
                    'contact_emails_id' => $this->input->post('email',true),
                    'status' => 1,
                    'date_created' => date('Y-m-d H:i:s'),
                );
                $id = $this->general_model->insert('mail_support', $msg);
                $name = $this->general_model->showssingle('user_profiles','user_id',$msg['userid'],'full_name');

                $details = array(
                    'mail_support_id' => $id,
                    'message' => $this->input->post('textContent', FALSE),
                    'sender' => $name['full_name'],
                    'user_type' => 'Trader',
                    'date_updated' => date('Y-m-d H:i:s'),
                    'status' => 1,
                );
                $new_id = $this->general_model->insert('mail_support_thread', $details);

                $ids = $this->input->post('id',true);
                $explode_ids = explode(',',$ids[0]);
                foreach ($explode_ids as $row) {
                    $updateData['mail_thread_id'] = $new_id;
                    $this->general_model->updatemy('mail_support_images','id',$row,$updateData);
                }

                $this->sendMail($this->session->userdata('user_id'));
            }

            $data['contact_emails'] = $this->general_model->show('contact_emails','','','*')->result_array();
            $data['message'] = $message;
            $data['active_tab'] = 'mail-support';
            $data['active_sub_tab'] = 'compose-message';
            $data['title_page'] = lang('sb_li_6');

            $js = $this->template->Js();
            $css = $this->template->Css();

            $data['metadata_description'] = lang('ms_com_dsc');
            $data['metadata_keyword'] = lang('ms_com_kew');
            $this->template->title(lang('ms_com_tit'))
                ->set_layout('internal/main')
                ->append_metadata_css("
                  <link rel='stylesheet' href='".$css."summernote.css'>
                  <link rel='stylesheet' href='".$css."jquery.fileupload.css'>
                ")
                ->append_metadata_js("
                    <script src='".$js."jquery-1.11.3.min.js'></script>
                    <script src='".$js."summernote.js'></script>
                    <script src='".$js."jquery.ui.widget.js'></script>
                    <script src='".$js."jquery.validate.js'></script>
                    <script src='".$js."jquery.fileupload.js'></script>
                ")
                ->build('mail_support/compose_message', $data);
        } else {
            redirect('signout');
        }
    }

    public function my_mail() {
        if ($this->session->userdata('logged')) {
            $data['inbox'] = $this->mailsupport_model->getUserMails($this->session->userdata('user_id'));

            $data['active_tab'] = 'mail-support';
            $data['active_sub_tab'] = 'my-mail';
            $data['title_page'] = lang('sb_li_6');

            $data['metadata_description'] = lang('ms_mym_dsc');
            $data['metadata_keyword'] = lang('ms_mym_kew');
            $this->template->title(lang('ms_mym_tit'))
                ->append_metadata_css('
                     <link rel="stylesheet" href="' . $this->template->Css() . 'dataTables.bootstrap.css">
                ')
                ->append_metadata_js("
                      <script src='" . $this->template->Js() . "jquery.dataTables.js'></script>
                      <script src='" . $this->template->Js() . "dataTables.bootstrap.js'></script>
                ")
                ->set_layout('internal/main')
                ->build('mail_support/my_mail', $data);
        } else {
            redirect('signout');
        }
    }

    public function mail($id) {
        if ($this->session->userdata('logged')) {
            $this->load->model('Mailsupport_model');

            $data['info'] = $this->general_model->showssingle('mail_support','id',$id,'*');
            $message = '';
            $array = array();

            $data['details'] = $this->Mailsupport_model->getMailThread($id);
            $data['contact_emails'] = $this->general_model->show('contact_emails','','','*')->result_array();
            $data['active_tab'] = 'mail-support';
            $data['active_sub_tab'] = 'my-mail';
            $data['title_page'] = lang('sb_li_6');
            $data['enable'] = $message;

            foreach ($data['details'] as $key => $value) {
                array_push($array, $value['id']);
            }

            $data['images'] = $this->Mailsupport_model->getMailImages($array);

//            echo '<pre>';
//            print_r($data);
//            echo '</pre>';exit;

            $js = $this->template->Js();
            $css = $this->template->Css();

            $this->template->title("ForexMart | Mail Support")
                ->set_layout('internal/main')
                ->append_metadata_css("
                  <link rel='stylesheet' href='".$css."summernote.css'>
                  <link rel='stylesheet' href='".$css."jquery.fileupload.css'>
                ")
                ->append_metadata_js("
                    <script src='".$js."jquery-1.11.3.min.js'></script>
                    <script src='".$js."summernote.js'></script>
                    <script src='".$js."jquery.ui.widget.js'></script>
                    <script src='".$js."jquery.validate.js'></script>
                    <script src='".$js."jquery.fileupload.js'></script>
                ")
                ->build('mail_support/mail', $data);
        } else {
            redirect('signout');
        }
    }

    public function updateMail($id) {
        if ($this->session->userdata('logged')) {
            $hashed_img_name = null;
            $orig_img_name = null;

            $this->form_validation->set_rules('textContent', 'Message', 'trim|required|xss_clean|callback_check_content');

            if ($this->form_validation->run()) {
                $name = $this->general_model->showssingle('user_profiles','user_id',$this->session->userdata('user_id'),'full_name');

                $insertData = array(
                    'mail_support_id' => $id,
                    'sender' => $name['full_name'],
                    'message' => $this->input->post('textContent', FALSE),
                    'user_type' => 'Trader',
                    'status' => 1,
                    'date_updated' => date('Y-m-d H:i:s'),
                );
                $new_id = $this->general_model->insert('mail_support_thread', $insertData);

                $ids = $this->input->post('id',true);
                $explode_ids = explode(',',$ids[0]);
                foreach ($explode_ids as $row) {
                    $updateData['mail_thread_id'] = $new_id;
                    $this->general_model->updatemy('mail_support_images','id',$row,$updateData);
                }

                $this->sendMail($this->session->userdata('user_id'));
            }
            redirect('mail_support/mail/'. $id);
        }  else {
            redirect('signout');
        }
    }

    public function uploadMailImage() {
        if ($this->session->userdata('logged') && $this->input->is_ajax_request()) {
            if (!empty($_FILES['fileupload']['name'])) {
                $allowedExtensions = array("jpeg", "jpg", "png", "x-png", "pdf");
                $temp = explode(".", $_FILES["fileupload"]["name"]);
                $extension = end($temp);
                $isError = true;
                $error = array();

                //Check if image format is valid
                if ((($_FILES["fileupload"]["type"] == "image/jpg")
                        || ($_FILES["fileupload"]["type"] == "image/jpeg")
                        || ($_FILES["fileupload"]["type"] == "image/png")
                        || ($_FILES["fileupload"]["type"] == "image/x-png")
                        || ($_FILES["fileupload"]["type"] == "application/pdf"))
                    && in_array(strtolower($extension), $allowedExtensions)
                ) {
                    $_FILES['userfile']['name'] = strtolower($_FILES['fileupload']['name']);
                    $_FILES['userfile']['type'] = $_FILES['fileupload']['type'];
                    $_FILES['userfile']['tmp_name'] = $_FILES['fileupload']['tmp_name'];
                    $_FILES['userfile']['error'] = $_FILES['fileupload']['error'];
                    $_FILES['userfile']['size'] = $_FILES['fileupload']['size'];

                    $config['file_name'] = hash('ripemd128', $_FILES['fileupload']['name']);

                    if ($extension == 'pdf') {
                        $config['upload_path'] = $this->config->item('asset_user_docs');//'/var/www/html/my.forexmart.com/assets/user_docs/';
                    } else {
                        $config['upload_path'] = $this->config->item('asset_user_images');//'/var/www/html/my.forexmart.com/assets/user_images/';
                    }

                    $config['allowed_types'] = 'pdf|jpg|jpeg|png|x-png';
                    $config['max_size'] = '52428800';
                    $config['overwrite'] = false;
                    $this->load->library('upload', $config);
                    // Alternately you can set preferences by calling the ``initialize()`` method. Useful if you auto-load the class:
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload()) {
                        $uploadData = $this->upload->data();

                        $insertData = array(
                            'image_name' => strtolower($_FILES['fileupload']['name']),
                            'image_hashed_name' => $uploadData['file_name'],
                            'size' => $this->human_filesize($_FILES['fileupload']['size']),
                            'mail_thread_id' => ''
                        );

                        $data['id'] = $this->general_model->insert('mail_support_images', $insertData);
                        $data['file_name'] = strtolower($_FILES['fileupload']['name']);
                        $data['file_size'] =  $this->human_filesize($_FILES['fileupload']['size']);
                        $data['hashed_file'] =  $uploadData['file_name'];

                        $isError = false;
                    } else {
                        $msg = $this->upload->display_errors('<p>', '</p>');
                        $msg .= print_r($this->upload->data());
                        $error = array('error' => $msg);
                    }
                }

                $data['is_error'] = $isError;
                $data['error_msg'] = $error;

                echo json_encode($data);

                /*$this->output->set_content_type('application/json')
                    ->set_output(
                        json_encode(
                            array(
                                'result' => $data,
                                'isError' => $isError,
                                'errorMsg' => $error
                            )
                        )
                    );*/
            } else {
                echo json_encode('Error: ' . $_FILES['fileupload']['error'] . '<br>');
            }
        }
    }

    public function sendMail($user_id) {
        $user_info = $this->general_model->showssingle('user_profiles','user_id',$user_id,'full_name');
        $user_email = $this->general_model->showssingle('users','id',$user_id,'email');

        // Send mail to user for notification
        $config = array(
            'mailtype'=> 'html'
        );

        $email_data['full_name'] = $user_info['full_name'];
        $email_data['body'] = '<p>This is to inform you we have received your feedback.</p>
                                       <p>Our support team will review your concern. We will get in touch with you as soon as possible.</p>
                                       <p>Please do not reply to this automated email. Thank you.</p>';
        $email_data['closing_remark'] = '<br/><span style="margin: 0 auto;font-weight: 600;color: #2988ca;">ForexMart</span> Team';
 
        

$from_email='noreply@mail.forexmart.com';        
$to_email=$user_email['email'];     //"keystationfrz@gmail.com";
$return_email='noreply@mail.forexmart.com';
$bcc_emal=false;

$subject='Mail Notification';
$message=$this->load->view('email/general_mail-html', $email_data, true);   
        
        
$this->load->library('Fx_mailer');
Fx_mailer::sender($to_email, $subject, $message, $from_email, $return_email,$bcc_emal);
                            
        
//        $this->load->library('email');
//        if($config != null){
//            $this->email->initialize($config);
//        }
//
//        $this->SMTPDebug = 1;
//        $this->email->from('noreply@mail.forexmart.com', 'ForexMart');
//        $this->email->to($user_email['email']);
//        $this->email->subject('Mail Notification');
//        $this->email->message($this->load->view('email/general_mail-html', $email_data, true));
//
//        if(!$this->email->send()){
//            echo $this->email->print_debugger();
//        }
//        
        
    }

    function human_filesize($bytes, $decimals = 2) {
        $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    public function delete_mail_image_uploaded($file) {
        if ($this->session->userdata('logged') && $this->input->is_ajax_request()) {
            $image_unlink= $this->config->item('asset_user_images');
            $return = unlink($image_unlink.$file);
            if ($return) {
                echo json_encode('successfully deleted ' . $file);
            } else {
                echo json_encode('failed');
            }
        }
    }

    public function getMailNotification() {
        if(!($this->input->is_ajax_request() && $this->session->userdata('logged'))) {die('Not authorized!');}
        $thread_id = trim($this->input->post('thread_id',true));

        $result = $this->mailsupport_model->getLastMail($thread_id);
        if ($result['user_type'] != 'Trader') {
            $data = array('status' => 0);
            $this->general_model->updatemy('mail_support_thread','mail_support_id',$thread_id, $data);
        }
    }

    public function check_content($str) {
        $content = strip_tags($this->input->post('textContent'));
        if ($content != "") {
            return true;
        } else {
            $this->form_validation->set_message('check_content', 'Content field is required.');
            return false;
        }
    }
}