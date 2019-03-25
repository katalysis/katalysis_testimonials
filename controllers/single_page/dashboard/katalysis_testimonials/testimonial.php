<?php

namespace Concrete\Package\KatalysisTestimonials\Controller\SinglePage\Dashboard\KatalysisTestimonials;

use Concrete\Core\Page\Controller\DashboardPageController;
use Loader;
use Core;
use Concrete\Core\User\User;

defined('C5_EXECUTE') or die(_("Access Denied."));
class Testimonial extends DashboardPageController {

    protected $error;

	public function view()
	{
        $this->requireAsset('core/file-manager');
	}

    // NEW FUNCTIONS
    
/*==============================================================================
    >> add: Adding a testimonial
==============================================================================*/

    public function add()
    {

        $this->view();

        // Set defaults
        $date = date('Y-m-d H:i:s');
        $dateHelper = \Core::make('helper/date');
        $u = new User();
        $user = $u->getUserID();

        $this->set('AdminOnly', 0);

        $this->set('CreatedDate', $dateHelper->formatDateTime($date));
        $this->set('CreatedBy', $user);
        $this->set('UpdatedDate', $dateHelper->formatDateTime($date));
        $this->set('UpdatedBy', $user);

        $CreatedByUser = User::getByUserID($user);
        if($CreatedByUser) {
            $this->set('CreatedByName', $CreatedByUser->getUserName());
        }
        $UpdatedByUser = User::getByUserID($user);
        if($UpdatedByUser){
            $this->set('UpdatedByName', $UpdatedByUser->getUserName());
        }

    }
    
    
/*==============================================================================
    >> edit: Editing a testimonial
==============================================================================*/

    public function edit($sID, $status = '')
    {

        $this->view();

        if ($status == 'updated') {
            $this->set("success",t("Testimonial Updated"));
        }

        if ($status == 'added') {
            $this->set("success",t("Testimonial Added"));
        }

        if ($status == 'active') {
            $this->set("success",t("This Testimonial is now Active."));
        }

        $dateHelper = \Core::make('helper/date');

        $db = Loader::db();
        
		$q = "SELECT sID, author, date, organisation, url, extract, testimonial, extra, image, featured, CreatedDate, CreatedBy, UpdatedDate, UpdatedBy, Active, Topics FROM KatalysisTestimonials WHERE sID = '{$sID}'";
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
			$this->set('CreatedDate', $dateHelper->formatDateTime($row['CreatedDate']));
            $this->set('CreatedBy', $row['CreatedBy']);
            $this->set('UpdatedDate', $dateHelper->formatDateTime($row['UpdatedDate']));
            $this->set('UpdatedBy', $row['UpdatedBy']);
            $this->set('Active', $row['Active']);
            $this->set('Topics', unserialize($row['Topics']));
            $this->set('sID', $sID);
		}

        $CreatedByUser = User::getByUserID($row['CreatedBy']);
        if($CreatedByUser) {
            $this->set('CreatedByName', $CreatedByUser->getUserName());
        }
        $UpdatedByUser = User::getByUserID($row['UpdatedBy']);
        if($UpdatedByUser){
            $this->set('UpdatedByName', $UpdatedByUser->getUserName());
        }

    }

/*==============================================================================
    >> save: Save changes to a testimonial
==============================================================================*/

    public function save($sID = 0)
    {

        $this->view();

        $u = new User();

        // Get the posted values
		$ktAuthor = $_POST['ktAuthor'];
		$ktDate = $_POST['ktDate'];
		$ktOrganisation = $_POST['ktOrganisation'];
		$ktUrl = $_POST['ktUrl'];
		$ktExtract = $_POST['ktExtract'];
		$ktTestimonial = $_POST['ktTestimonial'];
		$ktExtra = $_POST['ktExtra'];
		$ktImage = $_POST['ktImage'];
		$ktFeatured = $_POST['ktFeatured'];
        $CreatedDate = $_POST['CreatedDate'];
        $CreatedBy = $_POST['CreatedBy'];
        $UpdatedDate = $_POST['UpdatedDate'];
        $UpdatedBy = $_POST['UpdatedBy'];
        $Topics = serialize($_POST['Topics']);


        $date = date('Y-m-d H:i:s');
        $user = $u->getUserID();

        // Validation
        if ($ktExtract == '') {
            $this->error->add(t('Please enter a value for Extract.'));
        }

        if ($ktTestimonial == '') {
            $this->error->add(t('Please select a value for Testimonial.'));
        }

        // If no errors, save these values
        if (!$this->error->has()) {
	        
			$db = Loader::db();
			
			$so = $db->GetOne('select max(sortOrder) from KatalysisTestimonials');
			$so++;
			
			// If we have no testimonial Id, it is a new testimonial
            if ($sID == 0) {

			$db->Execute(
				'INSERT INTO KatalysisTestimonials VALUES(
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?, 
					?)',
				array(
					NULL,
					$ktAuthor,
					$ktDate,
					$ktOrganisation,
					$ktUrl,
					$ktExtract,
					$ktTestimonial,
					$ktExtra,
					$ktImage,
					$ktFeatured,
                    $so,
                    $date,
                    $user,
                    $date,
                    $user,
                    $Active,
                    $Topics
				));

                $newid = $db->lastInsertId();
                $this->set('newid', $newid);
                $this->redirect('/dashboard/katalysis_testimonials/testimonial/edit/'. $newid, 'added');


            } else {
                // Update an existing testimonial

                $db->Execute("UPDATE
                    KatalysisTestimonials
                SET
                    author=?,
                    date=?,
                    organisation=?,
                    url=?,
                    extract=?,
                    testimonial=?,
                    extra=?,
                    image=?,
                    featured=?,
                    UpdatedDate=?,
                    UpdatedBy=?,
                    Topics=?
                WHERE sID=?
                LIMIT 1", array(
                        $ktAuthor,
                        $ktDate,
                        $ktOrganisation,
                        $ktUrl,
                        $ktExtract,
                        $ktTestimonial,
                        $ktExtra,
                        $ktImage,
                        isset($ktFeatured) ? 1 : 0,
                        $date,
                        $user,
                        $Topics,
                        $sID,
                    )
                );

                $this->redirect('/dashboard/katalysis_testimonials/testimonial/edit/'. $sID, 'updated');

            }

        } else {

            // Set posted values
            $this->set('ID', $ID);
            $this->set('ktAuthor', $ktAuthor);
            $this->set('ktDate', $ktDate);
            $this->set('ktOrganisation', $ktOrganisation);
            $this->set('ktUrl', $ktUrl);
            $this->set('ktExtract', $ktExtract);
            $this->set('ktTestimonial', $ktTestimonial);
            $this->set('ktExtra', $ktExtra);
            $this->set('ktImage', $ktImage);
            $this->set('ktFeatured', isset($ktFeatured) ? 1 : 0);
            $this->set('UpdatedDate', $date);
            $this->set('UpdatedBy', $user);
            $this->set('Active', $Active);
            $this->set('Topics', unserialize($Topics));
            $this->set('sID', $sID);

        }

    }
    
/*==============================================================================
    activate: Make a testimonial available
==============================================================================*/

    public function activate($sID)
    {
        $db = Loader::db();
        $db->Execute("UPDATE KatalysisTestimonials SET Active=1 WHERE sID=$sID");

        $this->redirect('/dashboard/katalysis_testimonials/testimonial/edit/'. $sID, 'active');

    }


/*==============================================================================
 deactivate: Make a testimonial unavailable
==============================================================================*/

    public function deactivate($sID)
    {
        $db = Loader::db();
        $db->Execute("UPDATE KatalysisTestimonials SET Active=0 WHERE sID=$sID");

        $this->redirect('/dashboard/katalysis_testimonials/testimonial/edit/'. $sID, 'inactive');

    }

    

}
?>