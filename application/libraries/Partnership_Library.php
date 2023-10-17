<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Partnership_Library{

    public static function recreate_cpa(){

        FXPP::CI()->load->model('General_model');
        FXPP::CI()->g_m=FXPP::CI()->General_model;
        FXPP::CI()->load->model('Logs_model');

        $partnership_reg_log = FXPP::CI()->Logs_model->get_log($table='partnership_log', $field = "partner_id", $id = $partnerid=$_SESSION['user_id'], $select = "registration_type,record1,record2,API1,record3");

        $Reg_record3 = json_decode($partnership_reg_log['record3']);
        $partnerid2 =FXPP::CI()->g_m->showssingle2($table='partnership_affiliate_code',$field='affiliate_code',$id= $Reg_record3->affiliate_code ,$select='partner_id');

        if($partnership_reg_log['registration_type']=='cpa' and $partnership_reg_log['record2']=='N/A'){
            $Reg_APi1 = json_decode($partnership_reg_log['API1']);
            $Reg_record1 = json_decode($partnership_reg_log['record1']);

            $webservice_config = array(
                'server' => 'live_new'
            );

            $phone_password =  FXPP::RandomizeCharacter(7);
            $service_data = array(
                'address' => '',
                'city' => '',
                'country' =>  $Reg_APi1->country,
                'email' =>  $Reg_APi1->email,
                'group' => $Reg_APi1->group,
                'leverage' => '',
                'name' => $Reg_APi1->name,
                'phone_number' => $Reg_APi1->phone_number,
                'state' => '',
                'zip_code' => '',
                'phone_password' => $phone_password
            );
            $WebService2 = new WebService($webservice_config);
            $WebService2->open_account_standard($service_data);

            if( $WebService2->request_status === 'RET_OK' ) {
                $reference_number2 = $WebService2->get_result('LogIn');
                $partnership_details = array(
                    'reference_num' => $reference_number2,
                    'phone_number' =>  $Reg_APi1->phone_number,
                    'target_country' => $Reg_record1->target_country,
                    'message' => $Reg_record1->message,
                    'websites' => $Reg_record1->websites,
                    'type_of_partnership' => 'cpa',

                    'status_type' => $Reg_record1->status_type,
                    'company_name' =>  $Reg_record1->company_name,
                    'registration_number' => $Reg_record1->registration_number,
                    'date_of_incorporation' => $Reg_record1->date_of_incorporation,
                    'partner_id' => $partnerid2['partner_id'],

                    'currency' =>$Reg_record1->currency,
                    'phone_password' => $phone_password,
                    'reference_subnum' =>  $Reg_record1->reference_num,
                    'prog_comment'=>'recreated account due to api error in registration'

                );

                FXPP::CI()->g_m->insert('partnership', $partnership_details);

                /*registration_log*/
                $service_datalog = $service_data;
                $service_datalog['date']= FXPP::getCurrentDateTime();
                $service_datalog['error']= false;
                $partnership_details['date']=FXPP::getCurrentDateTime();
                $data['log'] = array(
                    'API2'=>json_encode($service_datalog),
                    'record2'=>json_encode($partnership_details),
                    'location'=>'internal'
                );

                $Logsupdate = FXPP::CI()->Logs_model->update_log($table='partnership_log',$field='partner_id',$id=$partnerid ,$data=$data['log']);

                /*registration_log*/

            }else{

            }

        }




    }

}