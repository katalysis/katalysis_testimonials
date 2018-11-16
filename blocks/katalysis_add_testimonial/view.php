<?php  defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
	$fp = FilePermissions::getGlobal();
	$tp = new TaskPermission();
	$ih = Loader::helper('concrete/ui');
	$al = Loader::helper('concrete/asset_library');

	$action = $view->action('add_testimonials');
	$PageTitle = t('New Testimonial');
	$button = t('Add');

$form = Loader::helper('form');
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
			<label for="ktTestimonial" class="control-label"><?php echo t('Testimonial')?></label>
			 <?php
			    $editor = Core::make('editor');
			    $editor->getPluginManager()->deselect(array('table', 'tableresize', 'tabletools', 'stylescombo', 'concrete5styles', 'image'));
			    echo $editor->outputBlockEditModeEditor('ktTestimonial', $ktTestimonial);
			  ?>
		</div>
	<?php echo $token->output('submit');?>
		<div class="text-right">
			<?php echo Loader::helper("form")->submit($button, $button, array('class' => 'button action'))?>
		</div>
	</fieldset>
</form>