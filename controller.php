<?php      
namespace Concrete\Package\KatalysisTestimonials;
use Package;
use BlockType;
use BlockTypeSet;
use SinglePage;
use Page;
use View;
use Loader;
use Route;


defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package {

	protected $pkgHandle = 'katalysis_testimonials';
	protected $appVersionRequired = '5.8.4';
	protected $pkgVersion = '1.0.8';
			
	public function on_start()
	{
		//Route::register('/katalysistestimonials/sortorder', '\Concrete\Package\KatalysisTestimonials\Controller\SinglePage\Dashboard\SortTestimonialOrder::SortOrder');
		
		
        Route::register('/dashboard/katalysis_testimonials/sortorder', '\Concrete\Package\KatalysisTestimonials\Controller\SinglePage\Dashboard\KatalysisTestimonials\SortTestimonialOrder::SortOrder');


		
		
	}
 	
	public function getPackageName() 
	{
		return t("Katalysis Testimonials");
	}

	public function getPackageDescription() 
	{
		return t("Show multiple testimonials on your site");
	}

	public function install() 
	{
		$pkg = parent::install();

		if (!BlockTypeSet::getByHandle('katalysis')) {
		    BlockTypeSet::add('katalysis', 'Katalysis', $pkg);
		}

		// install block
		BlockType::installBlockTypeFromPackage('katalysis_testimonials', $pkg);
		BlockType::installBlockTypeFromPackage('katalysis_add_testimonial', $pkg);
		
		//Install dashboard pages
		$page1 = SinglePage::add('/dashboard/katalysis_testimonials', $pkg);
        $page1->update(array('cName'=>t("Katalysis Testimonials")));
		
		$page2 = SinglePage::add('/dashboard/katalysis_testimonials/testimonial', $pkg);
        $page2->update(array('cName'=>t("Testimonial")));
                       		
		return $pkg;
	}
	
	
	public function upgrade() {

		parent::upgrade();
		
		$pkg = parent::install();

		BlockType::installBlockTypeFromPackage('katalysis_add_testimonial', $pkg);

	}


	public function uninstall() {
		parent::uninstall();
		$db = Loader::db();
		//$db->Execute('DROP TABLE KatalysisTestimonials');
		//$db->Execute('DROP TABLE btkatalysistestimonialblock');
	}

}