<?php
namespace Concrete\Package\KatalysisTestimonials\Block\KatalysisAddTestimonial;
use Package;
use View;
use Loader;
use Page;
use Core;
use \Concrete\Core\Block\BlockController;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController {

	protected $btTable = 'btkatalysisaddtestimonialblock';
	protected $btInterfaceWidth = "400";
	protected $btInterfaceHeight = "425";
	public $num = "";
	public $paginate = "1";
	protected $btDefaultSet = 'katalysis';

	public function getBlockTypeDescription()
    {
        return t("Katalysis Add Testimonial Block. Displays form to submit a testimonial.");
    }

    public function getBlockTypeName()
    {
        return t("Add Testimonial");
    }

	public function view() {
		

    }

	public function add(){
				
		// Defaults
		$this->set('form',Loader::helper('form'));
        $this->set('title', '');
        
	}

	public function edit(){
		
		
        
	}

	public function save($data) {
		
		parent::save($data);
		
	}

}
