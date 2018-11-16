<?php
namespace Concrete\Package\KatalysisTestimonials\Src;

use Database;
use Concrete\Core\Search\Pagination\Pagination;
use Concrete\Core\Search\ItemList\Database\ItemList as DatabaseItemList;
use Pagerfanta\Adapter\DoctrineDbalAdapter;

use Concrete\Package\KatalysisTestimonials\Src;
use Concrete\Package\KatalysisTestimonials\Src\Testimonial;

class TestimonialSingleList extends DatabaseItemList {

    protected $itemsPerPage = 3 ;

    public function createQuery() {

    }

    public function getTestimonials($limit = 3) {
        $this->query
        ->select('t.sID')
        ->from('KatalysisTestimonials','t')
        ->orderBy('RAND()', 'DESC')
        ->setMaxResults($limit);
    }

	public function getResult($queryRow) {
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

	public function getTotalResults() {
        $query = $this->deliverQueryObject();
        return $query->select('count(distinct t.sID)')->setMaxResults(1)->execute()->fetchColumn();
    }


}
?>