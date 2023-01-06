<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__.'/../third_party/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
class Pdf extends Dompdf  {

	protected $CI;

	public function __construct()
	{	
		$this->CI =& get_instance();
	}

	public function toPdf($file,$html)
	{

		$filename = $file;
		// include autoloader
		// reference the Dompdf namespace
		// use Dompdf\Dompdf;
	    $dompdf = new DOMPDF();
		// instantiate and use the dompdf class
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		$dompdf->set_option('isRemoteEnabled', TRUE);
		
		$dompdf->render();
		// Output the generated PDF to Browser
		// $dompdf->stream($filename);
		 $dompdf->stream($filename, array("Attachment" => false));
	}

	public function toPdf2($file,$html)
	{

		$filename = $file;
		// include autoloader
		// reference the Dompdf namespace
		// use Dompdf\Dompdf;
	    $dompdf = new DOMPDF();
		// instantiate and use the dompdf class
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');
		// Render the HTML as PDF
		$dompdf->set_option('isRemoteEnabled', TRUE);
		
		$dompdf->render();
		// Output the generated PDF to Browser
		// $dompdf->stream($filename);
		 $dompdf->stream($filename, array("Attachment" => false));
	}

	public function toPdfPotrait($file,$html)
	{

		$filename = $file;
		// include autoloader
		// reference the Dompdf namespace
		// use Dompdf\Dompdf;
	    $dompdf = new DOMPDF();
		// instantiate and use the dompdf class
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');
		// Render the HTML as PDF
		$dompdf->set_option('isRemoteEnabled', TRUE);
		
		$dompdf->render();
		// Output the generated PDF to Browser
		// $dompdf->stream($filename);
		 $dompdf->stream($filename, array("Attachment" => false));
	}

}