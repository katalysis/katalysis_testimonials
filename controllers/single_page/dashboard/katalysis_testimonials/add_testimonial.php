<?php

namespace Concrete\Package\KatalysisTestimonials\Controller\SinglePage\Dashboard\KatalysisTestimonials;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Loader;
use \Concrete\Core\User\EditResponse as UserEditResponse;

defined('C5_EXECUTE') or die(_("Access Denied."));
class AddTestimonial extends DashboardPageController {


	public function view()
	{
		$this->requireAsset('core/file-manager');
        $this->requireAsset('core/sitemap');
		$html = Loader::helper('html');
		$this->set('form',Loader::helper('form'));
	}

	public function edit($sID)
	{
		$html = Loader::helper('html');
		$this->set('form',Loader::helper('form'));

		$testimonial = $sID;

		$db = Loader::db();
		$q = "SELECT sID, author, date, organisation, url, extract, testimonial, extra, image, featured FROM KatalysisTestimonials WHERE sID = '{$sID}'";
		$r = $db->query($q);
		if ($r) {
			 $row = $r->fetchRow();

			$this->set('ktAuthor', $row['author']);
			$this->set('ktDate', $row['date']);
			$this->set('ktOrganisation', $row['organisation']);
			$this->set('ktUrl', $row['url']);
			$this->set('ktExtract', $row['extract']);
			$this->set('ktTestimonial', $row['testimonial']);
			$this->set('ktExtra', $row['extra']);
			$this->set('ktImage', $row['image']);
			$this->set('ktFeatured', $row['featured']);
			$this->set('testimonial', $testimonial);
		}
	}


	public function edit_testimonials($sID)
	{
		$Author = $_POST['ktAuthor'];
		$Date = $_POST['ktDate'];
		$Organisation = $_POST['ktOrganisation'];
		$Url = $_POST['ktUrl'];
		$Title = $_POST['ktExtract'];
		$Testimonial = $_POST['ktTestimonial'];
		$Extra = $_POST['ktExtra'];
		$Image = $_POST['ktImage'];
		$Featured = $_POST['ktFeatured'];

		if (strlen($Author) > 255) {
			$this->error->add(t('Author Name field has too many characters'));
        }
		if (strlen($Organisation) > 255) {
			$this->error->add(t('The Organisation field has too many characters'));
        }

		if (!$this->error->has()) {
			$db = Loader::db();
			$data = array(
				'author' => $_POST['ktAuthor'],
				'date' => $_POST['ktDate'],
				'organisation' => $_POST['ktOrganisation'],
				'url' => $_POST['ktUrl'],
				'extract' => $_POST['ktExtract'],
				'testimonial' => $_POST['ktTestimonial'],
				'extra' => $_POST['ktExtra'],
				'image' => $_POST['ktImage'],
				'featured' => $_POST['ktFeatured']

			);
			$db->update('KatalysisTestimonials', $data, array('sID' => $sID));

            $this->set('success', 'Testimonial Updated.');

			} else {
				$sr = new UserEditResponse();
                $sr->setError($this->error);
        }

	}

	public function add_testimonials()
	{
		$Author = $_POST['ktAuthor'];
		$Organisation = $_POST['ktOrganisation'];


		if (strlen($Author) > 255) {
			$this->error->add(t('Author field has too many characters'));
        }
		if (strlen($Organisation) > 255) {
			$this->error->add(t('The Organisation field has too many characters'));
        }

		if (!$this->error->has()) {
			$db = Loader::db();
			$so = $db->GetOne('select max(sortOrder) from KatalysisTestimonials');
			$so++;
			$db->Execute(
				'INSERT INTO KatalysisTestimonials VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
				array(
					NULL,
					$_POST['ktAuthor'],
					$_POST['ktDate'],
					$_POST['ktOrganisation'],
					$_POST['ktUrl'],
					$_POST['ktExtract'],
					$_POST['ktTestimonial'],
					$_POST['ktExtra'],
					$_POST['ktImage'],
					$_POST['ktFeatured'],
					$so
				)
			);

            $this->set('success', 'Testimonial Added.');

            $newid = $db->lastInsertId();
            $this->edit($newid);

		} else {
				$sr = new UserEditResponse();
                $sr->setError($this->error);
        }
    }
}
?>