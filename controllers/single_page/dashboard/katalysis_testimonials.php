<?php         
namespace Concrete\Package\KatalysisTestimonials\Controller\SinglePage\Dashboard;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Loader;
use \Concrete\Package\KatalysisTestimonials\Src\TestimonialPageList;

defined('C5_EXECUTE') or die(_("Access Denied."));
class KatalysisTestimonials extends DashboardPageController {
	public $helpers = array('form');

/*------------------------------------------------------------------------------
    On start
------------------------------------------------------------------------------*/

	public function on_start()
    {

	    $html = Loader::helper('html');
        $this->addHeaderItem($html->css('katalysis-testimonials.css', 'katalysis_testimonials'));

	}

/*------------------------------------------------------------------------------
    View
------------------------------------------------------------------------------*/

	    public function view()
    {
        $testimonialList = new TestimonialPageList();       
        $testimonialList->setItemsPerPage(25);
        $paginator = $testimonialList->getPagination();
        $pagination = $paginator->renderDefaultView();
        $this->set('testimonialslist',$paginator->getCurrentPageResults());  
        $this->set('pagination',$pagination);
        $this->set('paginator', $paginator);    

 
    }

/*------------------------------------------------------------------------------
    Feature
------------------------------------------------------------------------------*/

    public function feature($sID)
    {

        TestimonialPageList::saveTestimonialFeatured($sID);
        $this->view();

    }
	
/*------------------------------------------------------------------------------
     Delete check
------------------------------------------------------------------------------*/

	public function delete_check($sID) {
		$db = Loader::db();
		$db->Execute(
			'DELETE FROM KatalysisTestimonials WHERE sID = ' . $sID
		);
		$this->view();
	}
	
/*------------------------------------------------------------------------------
    Sort Order
------------------------------------------------------------------------------*/

	public function sortorder() {
		
	}
}

?>