<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {


    public function __construct()
    {
        parent::__construct();

    }

    public function getCurrentNotificationCount(){
        $this->load->library('FXAPI');
        $ret = FXAPI::GetCurrentNotificationCount(array());
        $data['count'] = $ret['data']->Common;
        $this->output->set_content_type('application/json')->set_output(json_encode($data));

    }

    public function getCurrentNotification(){
        if ($this->input->is_ajax_request()) {

            $start = $this->input->post('start');
            $this->load->library('FXAPI');
            $ret = FXAPI::GetNotifications(array('Offset' => $start, 'Limit' => 10));


            $data['loadMore'] = $ret['data']->LoadMore;
            $data['unseenNotif'] = $ret['data']->UnseenNotification;
            $notifData = $ret['data']->Notifications;
            $notifs = '';
            foreach ($notifData->NotificationInfo as $key => $value) {
              //  $title = $value->IsRead == 1 ? 'Mark as Unread' : 'Mark as Read';
                $dotClass = $value->IsRead == 1 ? ' ' : 'mark-active';
              

                $data['lastId'] =  $value->Id;
                $date = gmdate("m.d.Y H:i", $value->ProcessTime);


                $notifs .= '<li class="notif-list notif-item-'.$value->Id.'"><a href="javascript:;" class="notification-link"><div class="notification-img"> <span class="icons icons-notif icons-rollover"></span> </div>';
                $notifs .= '<div class="notification">';

                $notifs .= '<h4 class="notification-title">'.$value->Title.'</h4>';
                $notifs .= '<div class="notification-message">'.$value->Body.'</div>';
                $notifs .= '<div class="notification-date">'. $date . '</div>';
                $notifs .= '</div>';
                $notifs .= '<ul class="notification-action">';
                $notifs .= '<li class="li-icon-remove" onclick="updateNotification('.$value->Id.',1,1'.')"><div class=" notification-remove active" data-toggle="tooltip"  title="Clear notification" data-placement="auto" ><i class="fa fa-times" ></i></div></li>';
                $notifs .= ' <li class="li-icon-read" onclick="updateNotification('.$value->Id.','.$value->IsRead.',2'.')"><div id="notif-read-'.$value->Id.'" data-tempstatus='.$value->IsRead.' class="btn-toggle-mark  notification-dot  tooltip-style '.$dotClass.'" data-toggle="tooltip" data-placement="auto" ><i class="fa fa-circle"></i></div></li>';
                $notifs .= '</ul></a></li>';
            }

            $data['notifs']  = $notifs;
            /* if($data['loadMore'] > 0){
                $data['notifMore'] = '<h4 class="menu-title view-more-notif">View More<i class="glyphicon glyphicon-circle-arrow-right"></i> </h4>';

            }*/
            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        }
    }


    public function setRead(){
        $id = $this->input->post('id');
        $req = array('Id' => $id, 'Status' => true);

        $this->load->library('FXAPI');
        $ret = FXAPI::UpdateNotificationReadStatus($req);
         if($ret['RET'] == 'RET_OK'){
            $data= array(
                'success' => true,
            );
        }else{
            $data= array(
                'success' => false,
            );
        }
       
       $this->output->set_content_type('application/json')->set_output(json_encode($data));
  
     }

     public function setUnread(){
        $id = $this->input->post('id');
        $req = array('Id' => $id, 'Status' => false);
        $this->load->library('FXAPI');
        $ret = FXAPI::UpdateNotificationReadStatus($req);
        if($ret['RET'] == 'RET_OK'){
                $data = array(
                    'success' => true,
                );
            }else{
                $data = array(
                    'success' => false,
                );
            }
           
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
      
     }

    public function updateNotification(){
        $this->load->library('FXAPI');
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        $type = $this->input->post('type');

        if($type == 1) { //delete
            $ret = FXAPI::UpdateNotificationDeleteStatus(array('Id' => $id, 'Status' => true));

        }else{
            $ret = FXAPI::MarkAllNotificationAsRead(array());
        }

        if($ret['RET'] == 'RET_OK'){
            $data = array(
                'success' => true,
            );
        }else{
            $data = array(
                'success' => false,
            );
        }



        $this->output->set_content_type('application/json')->set_output(json_encode($data));


    }

  

}