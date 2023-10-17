<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 5/24/16
 * Time: 5:56 PM
 */

// Load the files we need:
define("DOC_DIR", str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__))));
require_once DOC_DIR.'/pdf/pdfwatermarker/pdfwatermark.php';
require_once DOC_DIR.'/pdf/pdfwatermarker/pdfwatermarker.php';


class WatermarkPdf {


    public static function  watermark($file_name = null){
        //Specify path to image. The image must have a 96 DPI resolution.

//        $watermark = new PDFWatermark('assets/images/watermark.png');
        
           $logo_water= 'assets/water_mark_logo/watermark_logo.png';
           $watermark = new PDFWatermark($logo_water);
        //$watermark = new PDFWatermark('assets/images/watermark_gif.png');
        //Set the position
                $watermark->setPosition('topright');
        //Place watermark behind original PDF content. Default behavior places it over the content.
        //$watermark->setAsBackground();

        //Specify the path to the existing pdf, the path to the new pdf file, and the watermark object
                $watermarker = new PDFWatermarker($file_name,$file_name,$watermark);

        //Set page range. Use 1-based index.
                $watermarker->setPageRange(1);

        //Save the new PDF to its specified location
                $watermarker->savePdf();
    }

} 