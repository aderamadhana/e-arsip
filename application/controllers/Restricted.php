<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restricted extends MY_Controller {

	public function index()
	{
		echo '<link rel="stylesheet" href="'.base_url('assets/').'bower_components/bootstrap/dist/css/bootstrap.min.css">';
		echo '<div class="alert alert-danger ks-solid ks-active-border" role="alert">';
		echo '	<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
		echo '		<span aria-hidden="true" class="fa fa-close"></span>';
		echo '	</button>';
		echo '	<h5 class="alert-heading">Warning</h5>';
		echo '		<ul>';
    	echo "			<li>Access forbidden</li>";
		echo '		</ul>';
		echo '</div>';
	}

}

/* End of file restricted.php */
/* Location: ./application/controllers/restricted.php */