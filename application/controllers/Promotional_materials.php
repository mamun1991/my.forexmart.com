<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 2/25/16
 * Time: 12:33 PM
 */

class Promotional_materials extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->lang->load('datatable');
        $this->lang->load('banners');
       $this->lang->load('logos');
       $this->load->model('partners_model');
//        $this->lang->load('partners_model');
        $this->load->model('Banners_model');
       // if(!IPLoc::Office()){redirect('');}
        if(!$this->session->userdata('logged')){redirect('');}
    }




    public function index(){

        $getAllSizes = $this->Banners_model->getAllSizes();
        $tempArray = '';
        $user_id = $this->session->userdata('user_id');
        foreach($getAllSizes as $index => $details) {
            $rownumber = $index + 1;
            $size = $details["size"];
            $getBannerDetails = $this->Banners_model->getBannerDetailsBySize($size);
            $showButton = '<button af="" class="btn-show-banner" id="'.$details['size'].'">'.lang("b_t_td_5").'</button>';

            $tempArray .= '<tr id="'.$details['id'].'">'
                . '<td>'.$rownumber.'</td>'
                . '<td>'.$size.'</td>'
                . '<td>'.count($getBannerDetails).'</td>'
                . '<td>image</td>'
                . '<td>'.$showButton.'</td></tr>';
        }

        $data['affiliate_codes'] = $this->partners_model->getAffiliateCodeById($user_id);
        $data['bannerList'] = $tempArray;
        $data['active_tab'] = "promotional-materials";
        $data['metadata_description'] = lang('b_dsc');
        $data['metadata_keyword'] = lang('b_kew');
        $this->template->title(lang('b_tit'))
            ->append_metadata_js('
                <script src="https://code.jquery.com/jquery-1.12.0.min.js" ></script>
                <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.10.9/js/dataTables.bootstrap.min.js"></script>
                ')
            ->append_metadata_css("
            <link rel='stylesheet' type='text/css' href='https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css'/>
                 ")
            ->set_layout('internal/main')
            ->build('promotional_materials/banners', $data);
    }

    public function BannersShow() {
        if (!$this->input->is_ajax_request()) {
            redirect('');
        }
        $size = $this->input->post('pagename',true);
        $af = $this->input->post('af',true);
        $data['lang'] = $this->input->post('lang',true);
        $getBanners = $this->Banners_model->getBanner($size);
        $stringHtml = '';

        switch($data['lang']){
            case 'ru':
                $data['folder']='banners_ru';
                break;
            case 'es':
                $data['folder']='banners_es';
                break;
            case 'de':
                $data['folder']='banners_de';
                break;
            case 'pt':
                $data['folder']='banners_pt';
                break;
            case 'fr':
                $data['folder']='banners_fr';
                break;
            case 'id':
                $data['folder']='banners_id';
                break;
            default:
                $data['folder']='banners';
        }
        $affiliate_code = $this->partners_model->getAffiliateCodeById($this->session->userdata('user_id'));

        if(strlen($af)==0){
            $data['affiliate_code'] = $affiliate_code[0]['affiliate_code'];
        }else{
            $data['affiliate_code'] = $af;
        }

        if($getBanners){
            $stringHtml .= '<div class="forex-banners-holder col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            $stringHtml .= ' <div class="forex-banners-title"><h1>Size: '.$size.'</h1></div>';
            foreach($getBanners as $key => $r){
                $banners = array('400x80', '468x60', '550x500', '580x51', '580x70', '728x90', '970x90', '775x60', '970x250', '600x425');
                $customStyleForBanners = in_array($r['size'], $banners) ? '12' : '4';
                $responsiveWidthForTextrea = in_array($r['size'], $banners) ? '30%' : '100%';
                $stringHtml .= '<div class="col-lg-'.$customStyleForBanners.' col-md-'.$customStyleForBanners.'" col-sm-12 col-xs-12">';
                $stringHtml .= '<div class="forex-banner-container">';
                $stringHtml .= '<a href="'.FXPP::loc_url($r['url']).'" target="_blank" style="outline: none"><img src="'.FXPP::www_url('assets/images/').$data['folder'].'/'.$r['size'].'/'.$r['banner_name'].'"></a>';
                $stringHtml .= '<a class="donalodFile" href="'.FXPP::www_url('assets/images/').$data['folder'].'/'.$r['size'].'/'.$r['banner_name'].'" download>Download file</a><br>';
                $stringHtml .= '<textarea style="width: '.$responsiveWidthForTextrea.';height: 150px;"><a href="'.FXPP::www_url().'register?id='.$data['affiliate_code'].'" target="_blank" style="outline: none"><img src="'.FXPP::www_url('assets/images/').$data['folder'].'/'.$r['size'].'/'.$r['banner_name'].'" width="'.$r['width'].'" height="'.$r['height'].'" alt="Forexmart" border="0" /></a></textarea>';
                $stringHtml .= '</div>';
                $stringHtml .= '</div>';
            }
            $stringHtml .= '</div>';
        }
        unset($data);
        echo $stringHtml;

    }

    public function getBanners(){
//        if (!$this->input->is_ajax_request()) {
//            redirect('');
//        }

        $this->load->model('Banners_model');

        $size = '120x600';
        $getBanners = $this->Banners_model->getBanner($size);
        $stringHtml = '';

        if($getBanners){
            $stringHtml .= '<div class="forex-banners-holder col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            $stringHtml .= ' <div class="forex-banners-title"><h1>Size: '.$size.'</h1></div>';
            foreach($getBanners as $key => $r){
                $stringHtml .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                $stringHtml .= '<div class="forex-banner-container horizontal-forex-banner banner-580x70">';
                $stringHtml .= '<img src="'.$this->template->Images().'banners/'.$r['size'].'/'.$r['banner_name'].'">';
                $stringHtml .= '<a class="donalodFile" href="'.$this->template->Images().'banners/'.$r['size'].'/'.$r['banner_name'].'" download>Download file</a><br>';
                $stringHtml .= '<textarea><a href="'.base_url().'register?id=Your_Affiliate_code" target="_blank" style="outline: none"><img src="'.$this->template->Images().'banners/'.$r['size'].'/'.$r['banner_name'].'" width="'.$r['width'].'" height="'.$r['height'].'" alt="Forexmart" border="0" /></a></textarea>';
                $stringHtml .= '</div>';
                $stringHtml .= '</div>';

            }
            $stringHtml .= '</div>';
        }

        $data['Banners'] = $stringHtml;
        $data['metadata_description'] = lang('b_dsc');
        $data['metadata_keyword'] = lang('b_kew');
        $this->template->title(lang('b_tit'))
            ->set_layout('external/main')
            ->build('banners/get_banners',$data);
    }
}

?>