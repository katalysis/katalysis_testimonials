<?php
namespace Concrete\Package\KatalysisTestimonials\Block\KatalysisTestimonials;
use Package;
use View;
use Loader;
use Page;
use Core;
use \Concrete\Core\Block\BlockController;
use \Concrete\Package\KatalysisTestimonials\Src\TestimonialSingleList;
use \Concrete\Package\KatalysisTestimonials\Src\TestimonialPageList;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController {

		protected $btTable = 'btkatalysistestimonialblock';
		protected $btInterfaceWidth = "400";
		protected $btInterfaceHeight = "425";
		protected $btDefaultSet = 'katalysis';

		public $num = "";
		public $paginate = "1";

	public function getBlockTypeDescription()
    {
        return t("Katalysis Testimonials Block. Displays a random Testimonial to a page.");
    }

    public function getBlockTypeName()
    {
        return t("Testimonials");
    }

	public function view() {
		
		$testimonialList = new TestimonialSingleList();
		if ($this->featuredOnly) $testimonialList->filter('featured', $this->featuredOnly);
		// $testimonialList->setItemsPerPage($this->displayNumber);

		$testimonialList->getTestimonials($this->displayNumber);
		$selection=@array_filter(unserialize($this->selection));
		if(sizeof($selection)>0){
			$testimonialList->filter(false,'sID in ('.implode(', ',$selection).')');
		}
		$testimonialList = $testimonialList->getResults();


		$this->set('testimonialslist', $testimonialList);

    }

	public function add(){
				
		$this->requireAsset('javascript', 'selectize');
        $this->requireAsset('css', 'selectize');

		// Defaults
		$this->set('form',Loader::helper('form'));
        $this->set('title', '');
        $this->set('displayNumber', 0);
        $this->set(unserialize('selection'), '');
        $this->set('includeDate', 0);
        $this->set('includeAuthor', 0);
        $this->set('includeOrganisation', 0);
        $this->set('includeUrl', 0);
        $this->set('includeExtract', 0);
        $this->set('includeTestimonial', 0);
        $this->set('includeOptional', 0);
        $this->set('includeImage', 0);
        $this->set('featuredOnly', 0);
        $this->set('constrain', 0);
        $this->set('showAllLink', 1);
        
		// Get a list of testimonials
		$testimonialList = new TestimonialPageList();
        $this->set('testimonialslist', $testimonialList->getResults());
	}

	public function edit(){
		
		$this->requireAsset('javascript', 'selectize');
        $this->requireAsset('css', 'selectize');

        $this->set('selection', unserialize($this->selection));
		
		// Get a list of testimonials
		$testimonialList = new TestimonialPageList();
        $this->set('testimonialslist', $testimonialList->getResults());
        
	}

	public function save($data) {
		$data['selection'] = serialize($data['selection']);
		$data['featuredOnly'] = isset($data['featuredOnly']) ? '1' : '0' ;
		$data['includeDate'] = isset($data['includeDate']) ? '1' : '0' ;
		$data['includeOrganisation'] = isset($data['includeOrganisation']) ? '1' : '0' ;
		$data['includeUrl'] = isset($data['includeOrganisation']) ? '1' : '0' ;
		$data['includeExtract'] = isset($data['includeExtract']) ? '1' : '0' ;
		$data['includeTestimonial'] = isset($data['includeTestimonial']) ? '1' : '0' ;
		$data['includeOptional'] = isset($data['includeOptional']) ? '1' : '0' ;
		$data['includeImage'] = isset($data['includeImage']) ? '1' : '0' ;
		$data['constrain'] = isset($data['constrain']) ? '1' : '0' ;
		$data['showAllLink'] = isset($data['showAllLink']) ? '1' : '0' ;
		parent::save($data);
	}

}
