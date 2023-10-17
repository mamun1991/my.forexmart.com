<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Social{

    function __construct(){
        
    }
    public static function ci(){
        $ci =& get_instance();
        return $ci;
    }

    
    
    
    
    
    
 public static function getConnecitonMethod($config=array(),$social_type='fb')
{
     
      $_SESSION['socail_login_config_data']=false;
     $default_signin_url="https://my.forexmart.com/";  
     
     $default_url="https://www.forexmart.com/social-register/";     


 
    if($social_type=="fb")
     {
          $method_link="/fblLogin/";   
          $connection_url="https://my.forexmart.com/client/fblLogin/";          
     }else{
         $method_link="/googleLogin";  
         $connection_url='https://my.forexmart.com/client/googleLogin';
     }
     
     
     
     
       if(!empty($config))
        {
           $_SESSION['socail_login_config_data']=$config;
           
            if($config['type']=="partner")
            {
                 
                
                // client account 
                   if($config['reason']=="signin")
                   { 
                          if($config['account']=="live" and $social_type=="fb")
                             {
                                  $connection_url="https://my.forexmart.com/partner/fblLogin/";   
                             }
                             else if($config['account']=="live" and $social_type=="google")
                             {
                                $connection_url='https://my.forexmart.com/partner/googleLogin';
                             }
                              
                       
                   } 
                   else 
                   {
                       // register 
                       
                            if($config['account']=="live")
                             {
                                 $connection_url= $default_url."".$method_link;
                             }else{ 
                                // demo 
                                 $connection_url= $default_url."partner".$method_link;
                             }

                       
                   } 
                
                
            }else{
                
                
                // client account 
                   if($config['reason']=="signin")
                   { 
                             if($config['account']=="live" and $social_type=="fb")
                             {
                                  $connection_url="https://my.forexmart.com/client/fblLogin/";   
                             }
                             else if($config['account']=="live" and $social_type=="google")
                             {
                                $connection_url='https://my.forexmart.com/client/googleLogin';

                             }
                              
                       
                   } 
                   else 
                   {
                       // register 
                       
                            if($config['account']=="live" and $social_type=="fb")
                             {
                                 $connection_url= "https://www.forexmart.com/social-register/";     

                             }
                             else if($config['account']=="live" and $social_type=="google")
                             {
                                 $connection_url= "https://www.forexmart.com/social-register/google";     

                             }
                             else if($config['account']=="demo" and $social_type=="fb")
                             {
                                 $connection_url= "https://www.forexmart.com/social-register/demofb";     

                             }
                             else if($config['account']=="demo" and $social_type=="google")
                             {
                                 $connection_url= "https://www.forexmart.com/social-register/demogoogle";     

                             }

                       
                   } 
                
                   
                
            }
            
            
        }



     
     

return $connection_url;     
}
    
     
    
    public static function fbAPI($config =  array()){
      
   
        
        
        require_once dirname(__FILE__) . "/facebook/autoload.php";
         


      
        $fb= new Facebook\Facebook([
        'app_id'=>'716210695642815',
        'app_secret'=>'548d0838516264c06b27569fc6c06c2f',
        'default_graph_version'=>'v8.0',

        ]);
       
         $helper = $fb->getRedirectLoginHelper();
    
         
 $connection_url= Social::getConnecitonMethod($config,'fb');
         
         
         $permissions =['email'];// ['id','name','email']; 
         $fb_login_url = $helper->getLoginUrl($connection_url,$permissions);    
           
 
        $data=array(            
            "fb_api"=>$fb,
            "fb_url"=>$fb_login_url,
        );
        
        return $data;
        

        
    }
    
   
    
    
    public static function googleAPI($config =  array()){
      
   
        
        
        require_once dirname(__FILE__) . "/google_api/vendor/autoload.php";
         


        // Creating new google client instance
        $client = new Google_Client();

              
        $connection_url= Social::getConnecitonMethod($config,'google');
     
     
        // Enter your Client ID
        $client->setClientId('477707805514-2dbdg19vfgr1htnc8ci5rfbn46vc9r1l.apps.googleusercontent.com');
        // Enter your Client Secrect
        $client->setClientSecret('Ayecesi-cfmq5RblZaNyJ9up');
        // Enter the Redirect URL
        $client->setRedirectUri($connection_url);

        // Adding those scopes which we want to get (email & profile Information)
        $client->addScope("email");
        $client->addScope("profile");

        
       $goole_login_url= $client->createAuthUrl();
        
       //  echo "<pre>"; print_r($goole_login_url);     exit; 
       
       $data=array(            
            "google_api"=>$client,
            "goole_url"=>$goole_login_url,
        );
        
        return $data;
        

        
 
        
    }


 }