<?php         
namespace Concrete\Package\KatalysisTestimonials\Controller\SinglePage\Dashboard\KatalysisTestimonials;

use Controller;
use Loader;
use Database;

defined('C5_EXECUTE') or die(_("Access Denied."));
class SortTestimonialOrder extends Controller {
	   
	public function SortOrder()
   {
	   
	$uats = $_REQUEST['sID'];
	   
	if (is_array($uats)) {
		$uats = array_filter($uats, 'is_numeric');
	}
	
	if (count($uats)) {
		$db = Loader::db();
		for ($i = 0; $i < count($uats); $i++) {
			$v = array($uats[$i]);
			$db->query("update KatalysisTestimonials set sortOrder = {$i} where sID = ?", $v);
        }
	}
	}
}

