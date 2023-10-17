<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forex extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');

    }

    public function index()
    {
        $this->template->title("ForexMart | Forex Calendar")
            ->set_layout('external/main')
            ->build('forex/calendar_widget');

    }
    public function calendar()
    {

        $ch = curl_init("http://www.myfxbook.com/rss/forex-economic-calendar-events");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $xml_data = curl_exec($ch);
        $xml = new SimpleXmlElement($xml_data, LIBXML_NOCDATA);
        $cnt = count($xml->channel->item);
        for($i=0; $i<$cnt; $i++)
        {
            $url 	= $xml->channel->item[$i]->link;
            $title 	= $xml->channel->item[$i]->title;
            $desc = $xml->channel->item[$i]->description;
            //$category = $xml->channel->item[$i]->category;
/*
            echo "<ul>";
            echo '<li><a href="'.$url.'">'.$title.'</a><br>'.$desc.'<br><strong>'.$category.'</strong></li>';
            echo "</ul>";*/

        }

        $data = array(
            'xml'   =>   $xml
        );

        $this->template->title("ForexMart | Forex Calendar")
            ->set_layout('external/main')
            ->build('forex/calendar',$data);

    }

}
