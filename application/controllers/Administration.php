<?php
/**
 * Created by PhpStorm.1
 * User: Zeta - Jeric Carlos
 * Date: 6/11/15
 * Time: 10:20 AM
 */
class Administration extends CI_Controller {

    public function __construct(){

        parent::__construct();

        $this->load->helper("url");
        $this->load->model("External_model");
        $this->load->library("pagination");
        $this->load->library('form_validation');
    }

    public function index(){
        if($this->session->userdata('administration'))
          {


            $data['data']["links"] = $this->pagination->create_links();
                  $this->template->title("ForexMart | Administration")
                        ->set_layout('administration/main')
                        ->build('administration');

        }else{
            redirect('signout');
        }
 
    }
    public function deleteNews(){
        if($this->session->userdata('administration')){

            $this->form_validation->set_rules('button_delete', 'button_delete', 'required');
            if ($this->form_validation->run()){
                var_dump($this->input->post( 'button_delete',true ));
                $data['delete']=array(
                    'id' => $this->input->post( 'button_delete' ,true)
                );
                $return=$this->External_model->deleteNews($data['delete']);

            }
            redirect('Administration/news');
        }else{

            redirect('signout');
        }
 
        
    }
    public function News(){

        if($this->session->userdata('administration')){
            $this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
            $this->form_validation->set_rules('message', 'Message', 'required|trim|xss_clean');
            $this->form_validation->set_rules('link', 'Link', 'required|trim|xss_clean');
            if ($this->form_validation->run()){

                $data['insert']=array(
                    'user_id' => ($this->session->userdata('user_id'))? $this->session->userdata('user_id') :0,
                    'title' => $this->input->post( 'title' ,true),
                    'message' => $this->input->post( 'message',true ),
                    'link' => $this->input->post( 'link',true )
                );
                $return=$this->External_model->insertNews($data['insert']);
                if(!$return){
                    $data['data']['saved']=false;
                }else{
                    $data['data']['saved']=true;
                }

            }else{
                $data['data']['saved']=false;
            }

            $data['data']['form_button']=  array(
                'name'          => 'sendrequest',
                'id'            => 'buttonsubmit',
                'value'         => 'sendrequest',
                'type'          => 'submit',
                'class'          => 'btn-sign',
                'content'       => 'Add News',
            );

            $data['data']['title']=  array(
                'name'          => 'title',
                'id'            => 'inputtitle',
                'value'         => set_value('title', ''),
                'type'          => 'text',
                'class'         => form_error('title')?'form-control round-0  red-border definewidth ': 'form-control round-0 definewidth' ,
                'placeholder'   => 'Title'
            );

            $data['data']['message']=  array(
                'name'          => 'message',
                'id'            => 'inputtitle',
                'value'         => set_value('message', ''),
                'type'          => 'text',
                'class'         => form_error('message')?'form-control round-0  red-border definewidth ': 'form-control round-0 definewidth' ,
                'placeholder'   => 'Message'
            );

            $data['data']['link']=  array(
                'name'          => 'link',
                'id'            => 'inputtitle',
                'value'         => set_value('link', ''),
                'type'          => 'text',
                'class'         => form_error('link')?'form-control round-0  red-border definewidth': 'form-control round-0 definewidth' ,
                'placeholder'   => 'Link'
            );

            $config = array();
            $config["base_url"] = base_url() . "Administration/news";
            $config["total_rows"] = $this->External_model->record_count();
            $config["per_page"] = 5;
            $config["uri_segment"] = 3;

            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = round($choice);

            //first link
            $config['first_tag_open']='<li class="">';
            $config['first_tag_close'] = '</li>';
            $config['first_link'] = '&#171;';

            //previous link
            $config['prev_tag_open']='<li class="">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&#139;';

            //next link
            $config['next_tag_open']='<li class="">';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = '&#155;';

            //last link
            $config['last_tag_open']='<li class="">';
            $config['last_tag_close'] = '</li>';
            $config['last_link'] = '&#187;';


            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="">';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            $data['page'] = ($this->uri->segment(3))? $this->uri->segment(3) : 0;

            $data['data']["results"] = $this->External_model->fetch_news($config["per_page"], $data['page']);

            $data['data']["links"] = $this->pagination->create_links();
            $this->template->title("Administration")
                ->set_layout('administration/main')
                ->build('administration_news',$data['data']);
        }else{

            redirect('signout');
        }

    }
    public function Feedback(){

        if($this->session->userdata('administration')){
            $config = array();
            $config["base_url"] = base_url() . "Administration/feedback";
            $config["total_rows"] = $this->External_model->record_count_feedback();
            $config["per_page"] = 5;
            $config["uri_segment"] = 3;

            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = round($choice);

            //first link
            $config['first_tag_open']='<li class="">';
            $config['first_tag_close'] = '</li>';
            $config['first_link'] = '&#171;';

            //previous link
            $config['prev_tag_open']='<li class="">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&#139;';

            //next link
            $config['next_tag_open']='<li class="">';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = '&#155;';

            //last link
            $config['last_tag_open']='<li class="">';
            $config['last_tag_close'] = '</li>';
            $config['last_link'] = '&#187;';


            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="">';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            $data['page'] = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
            $data['data']["results"] = $this->External_model->fetch_feedback($config["per_page"], $data['page']);
            $data['data']["links"] = $this->pagination->create_links();
            $this->template->title("Administration")
                ->set_layout('administration/main')
                ->build('administration_feedback',$data['data']);
        }else{

            redirect('signout');
        }
    }
    public function EnaDisableAccess(){
        if($this->session->userdata('administration')){

            $this->form_validation->set_rules('button_submit', 'Disable Enable Button', 'required');
            if ($this->form_validation->run()){


                $data['accessvalue'] = explode(" ", $this->input->post( 'button_submit',true));
                $data['delete']=array(
                    'id' => $data['accessvalue'][0],
                    'administration' =>Abs($data['accessvalue'][1] -1)
                );
                $return=$this->External_model->updateuserAdministration($data['delete']);

            }
            redirect('Administration/Access');
        }else{

            redirect('signout');
        }
    }
    public function Access(){
        if($this->session->userdata('administration')){
            $config = array();
            $config["base_url"] = base_url() . "Administration/Access";
            $config["total_rows"] = $this->External_model->record_count_users();
            $config["per_page"] = 5;
            $config["uri_segment"] = 3;

            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = round($choice);

            //first link
            $config['first_tag_open']='<li class="">';
            $config['first_tag_close'] = '</li>';
            $config['first_link'] = '&#171;';

            //previous link
            $config['prev_tag_open']='<li class="">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&#139;';

            //next link
            $config['next_tag_open']='<li class="">';
            $config['next_tag_close'] = '</li>';
            $config['next_link'] = '&#155;';

            //last link
            $config['last_tag_open']='<li class="">';
            $config['last_tag_close'] = '</li>';
            $config['last_link'] = '&#187;';


            $config['cur_tag_open'] = '<li class="active"><a>';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="">';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            $data['page'] = ($this->uri->segment(3))? $this->uri->segment(3) : 0;
            $data['data']["results"] = $this->External_model->fetch_users($config["per_page"], $data['page']);
            $data['data']["links"] = $this->pagination->create_links();
            $this->template->title("Administration")
                ->set_layout('administration/main')
                ->build('administration_usersaccess',$data['data']);
        }else{

            redirect('signout');

        }

    }
    
    
    public function manage(){
        
         if($this->session->userdata('administration'))
          {
             $data['test']=1;

            $data['data']["links"] = $this->pagination->create_links();
                  $this->template->title("ForexMart | Manage")
                       ->set_layout('admin-manage/main')
                ->build('manage_access',$data['data']);

        }else{
            redirect('signout');
        }

    }
    
    
}