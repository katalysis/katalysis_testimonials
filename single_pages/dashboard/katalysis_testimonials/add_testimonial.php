<?php  defined('C5_EXECUTE') or die("Access Denied.");

$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
$ih = Loader::helper('concrete/ui');
$al = Loader::helper('concrete/asset_library');

$action = $view->action('add_testimonials');
$PageTitle = t('New Testimonial');
$button = t('Add');

if ($controller->getTask() == 'edit' || $controller->getTask() == 'edit_testimonials' || $controller->getTask() == 'add_testimonials') {
	$action = $view->action('edit_testimonials', $testimonial);
	$PageTitle = t('Edit Testimonial');
	$button = t('Update');
}
?>


<form method="post" action="<?php echo $action?>">
	<fieldset>
		<legend><?php echo($PageTitle); ?></legend>
		<div class="form-group">
			<label for="ktAuthor" class="control-label"><?php echo t('Author')?></label>
			<?php echo $form->text('ktAuthor', $ktAuthor)?>
		</div>
		<div class="form-group">
			<label for="ktAuthor" class="control-label"><?php echo t('Date')?></label>
			<?php echo Loader::helper('form/date_time')->date('ktDate', $ktDate)?>
		</div>
		<div class="form-group">
			<label for="ktOrganisation" class="control-label"><?php echo t('Organisation')?></label>
			<?php echo $form->text('ktOrganisation', $ktOrganisation)?>
		</div>
		<div class="form-group">
			<label for="ktUrl" class="control-label"><?php echo t('Link URL')?></label>
			<?php echo $form->url('ktUrl', $ktUrl)?>
		</div>

		<div class="form-group">
			<label for="ktExtract" class="control-label"><?php echo t('Extract')?></label>
			<?php echo $form->textarea('ktExtract', $ktExtract)?>
		</div>
		<div class="form-group">
			<label for="ktTestimonial" class="control-label"><?php echo t('Testimonial')?></label>
			 <?php
			    $editor = Core::make('editor');
			    $editor->getPluginManager()->deselect(array('table', 'tableresize', 'tabletools', 'stylescombo', 'concrete5styles', 'image'));
			    echo $editor->outputBlockEditModeEditor('ktTestimonial', $ktTestimonial);
			  ?>
		</div>
		<div class="form-group">
			<label for="ktExtra" class="control-label"><?php echo t('Optional Content')?></label>
			<?php
		    $editor = Core::make('editor');
		    $editor->getPluginManager()->deselect(array('table', 'tableresize', 'tabletools', 'stylescombo', 'concrete5styles', 'image'));
		    echo $editor->outputBlockEditModeEditor('ktExtra', $ktExtra);
		    ?>
		</div>
		<div class="form-group">
			<label for="ktImage" class="control-label"><?php echo t('Image')?></label>
			<?php
			if($ktImage){
				$file = File::getByID($ktImage);
			}
			echo $al->file('chooseImage', 'ktImage', t('Select Image'), ($file ? $file : null ) ); ?>
		</div>
		<div class="form-group">
			<label for="ktFeatured" class="control-label"><?php echo t('Featured')?></label>
			<?php echo $form->checkbox('ktFeatured', '1', $ktFeatured=='1')?>
		</div>
	</fieldset>
	<?php echo $token->output('submit');?>
	<div class="ccm-dashboard-form-actions-wrapper">
		<div class="ccm-dashboard-form-actions">
			<a href="<?php  echo View::url('/dashboard/katalysis_testimonials')?>" class="btn btn-default pull-left"><?php echo t('Cancel')?></a>
			<?php echo Loader::helper("form")->submit($button, $button, array('class' => 'btn btn-primary pull-right'))?>
		</div>
	</div>
</form>