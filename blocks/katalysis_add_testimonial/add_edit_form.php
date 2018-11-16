<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form');
?>
<fieldset>
	<div class="form-group">
		<?php echo $form->label('title', t('Title')); ?>
		<div class="controls">
		<?php echo $form->text('title', $title, array('class'=>'span4')); ?>
		</div>
	</div>
</fieldset>
