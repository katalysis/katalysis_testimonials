<?php      
namespace Concrete\Package\KatalysisTestimonials\Src;

use Database;
use Concrete\Core\Search\Pagination\Pagination;
use Concrete\Core\Search\ItemList\Database\ItemList as DatabaseItemList;
use Pagerfanta\Adapter\DoctrineDbalAdapter;

use Concrete\Package\KatalysisTestimonials\Src;
use Concrete\Package\KatalysisTestimonials\Src\Testimonial;
use Loader;

class TestimonialPageList extends DatabaseItemList {
	
	
	 public function createQuery()
    {
        $this->query
        ->select('t.sID')
        ->from('KatalysisTestimonials','t')
        ->orderBy('sortOrder', 'ASC');
    }
	
	public function getResult($queryRow)
    {
        return Testimonial::getByID($queryRow['sID']);
    }
	
	protected function createPaginationObject()
    {
        $adapter = new DoctrineDbalAdapter($this->deliverQueryObject(), function ($query) {
            $query->select('count(distinct t.sID)')->setMaxResults(1);
        });
        $pagination = new Pagination($this, $adapter);
        return $pagination;
    }
	
	public function getTotalResults()
    {
        $query = $this->deliverQueryObject();
        return $query->select('count(distinct t.sID)')->setMaxResults(1)->execute()->fetchColumn();
    }
    
    // Toggle whether this testimonial is featured
	function saveTestimonialFeatured($sID) {
		$db = Loader::db();
		$db->Execute("UPDATE KatalysisTestimonials SET featured = IF(featured=1, 0, 1) WHERE sID=?", array(
			$sID,
		));
	}

	
}
?>