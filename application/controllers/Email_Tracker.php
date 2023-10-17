<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_Tracker extends CI_Controller {

	public function index(){
		header("Content-Type: assets/images"); // it will return image 
		readfile("watermark.png");
	}
}