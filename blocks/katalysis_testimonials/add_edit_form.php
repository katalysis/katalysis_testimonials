<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$form = Loader::helper('form');

$kColours = array(
	'kt-transparent' => 'Transparent', 
	'kt-image' => 'Image', 
	'kt-col1-lightest' => 'Colour 1 Lightest', 
	'kt-col1-lighter' => 'Colour 1 Lighter', 
	'kt-col1-light' => 'Colour 1 Light', 
	'kt-col1' => 'Colour 1', 
	'kt-col1-dark' => 'Colour 1 Dark', 
	'kt-col1-darker' => 'Colour 1 Darker', 
	'kt-col1-darkest' => 'Colour 1 Darkest', 
	'kt-col2-lightest' => 'Colour 2 Lightest', 
	'kt-col2-lighter' => 'Colour 2 Lighter', 
	'kt-col2-light' => 'Colour 2 Light', 
	'kt-col2' => 'Colour 2', 
	'kt-col2-dark' => 'Colour 2 Dark', 
	'kt-col2-darker' => 'Colour 2 Darker', 
	'kt-col2-darkest' => 'Colour 2 Darkest', 
	'kt-vib-lightest' => 'Colour Vibrant Lightest', 
	'kt-vib-lighter' => 'Colour Vibrant Lighter', 
	'kt-vib-light' => 'Colour Vibrant Light', 
	'kt-vib' => 'Colour Vibrant', 
	'kt-vib-dark' => 'Colour Vibrant Dark', 
	'kt-vib-darker' => 'Colour Vibrant Darker', 
	'kt-vib-darkest' => 'Colour Vibrant Darkest', 
	'kt-col-white' => 'White', 
	'kt-col-neutral-light' => 'Light Grey', 
	'kt-col-neutral' => 'Grey', 
	'kt-col-neutral-dark' => 'Dark Grey', 
	'kt-col-black' => 'Black' 
	);

?>
<?php echo Core::make('helper/concrete/ui')->tabs(array(
	array('form-content', t('Content'), true),
	array('form-design', t('Design')),
));
?>
<div class="ccm-tab-content" id="ccm-tab-content-form-content">
	<fieldset>
		<?php echo $form->hidden('testimonial_ids', $testimonial_ids); ?>
		<div class="form-group">
			<?php echo $form->label('title', t('Title')); ?>
			<div class="controls">
			<?php echo $form->text('title', $title, array('class'=>'span4')); ?>
			</div>
		</div>
		<div class="form-group">
			<?php echo $form->label('displayNumber', t('Number to display')); ?>
			<div class="controls">
			<?php echo $form->text('displayNumber', $displayNumber, array('class'=>'span1')); ?>
			</div>
		</div>
		<div class="for-group">
			<label class="control-label">Selected testimonial(s)</label>
			<?php
			if (sizeof($testimonialslist)>0 && is_array($testimonialslist)) {
                $testimonialArray = array();
                foreach ($testimonialslist as $testimonial) {
                    $testimonialArray[$testimonial->sID] = $testimonial->author;

                }
                echo $form->selectMultiple('selection', $testimonialArray, $selection, array('style' => 'width: 100%;','class' => 'selection'));
            } ?>
            <script type="text/javascript">
			$(function() {
			    $('#selection').removeClass('form-control').selectize({
			        plugins: ['remove_button']
			    });
			});
			</script>
			<p class="help-block" style="margin-bottom:0;">If no entries are selected all entries will display.</p>
		</div>

	</fieldset>
</div>
<div class="ccm-tab-content" id="ccm-tab-content-form-design">
	<fieldset>
	    <div class="form-group">
		<?php echo $form->label('headingStyle', t('Heading Format'))?>
	    <?php echo $form->select('headingStyle', array('h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6'), $headingStyle); ?>
	    </div>
		<div class="form-group">
			<?php echo $form->label('background', t('Background'))?>
		    <?php echo $form->select('background', $kColours, $background); ?>
	    </div>
	    <div class="form-group">
			<?php echo $form->label('panelBackground', t('Panel Background'))?>
		    <?php echo $form->select('panelBackground', $kColours, $panelBackground); ?>
	    </div>
	    <div class="form-group">
			<label>Options</label>
			<div class="checkbox">
				<label>
				<?php echo $form->checkbox('constrain', '$constrain', $constrain ?  'checked' : ''); ?>
				Constrain grid to column width
				</label>
			</div>
			<div class="checkbox">
				<label>
				<?php echo $form->checkbox('showAllLink', '$showAllLink', $showAllLink ?  'checked' : ''); ?>
				Show link to all testimonials
				</label>
			</div>
			<div class="checkbox">
				<label>
				<?php echo $form->checkbox('featuredOnly', '1', $featuredOnly==1); ?>
				Show Featured only
				</label>
			</div>
		</div>
		<label>Include</label>
		<div class="row">
		  	<div class="col-md-6">
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeExtract', '1', $includeExtract==1); ?>
					Extract
					</label>
				</div>
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeTestimonial', '1', $includeTestimonial==1); ?>
					Testimonial
					</label>
				</div>
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeAuthor', '1', $includeAuthor==1); ?>
					Author
					</label>
				</div>
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeOrganisation', '1', $includeOrganisation==1); ?>
					Organisation
					</label>
				</div>
			</div>
			<div class="col-md-6">
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeUrl', '1', $includeUrl==1); ?>
					Link Url
					</label>
				</div>
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeDate', '1', $includeDate==1); ?>
					Date
					</label>
				</div>
				<div class="checkbox">
					<label>
					<?php echo $form->checkbox('includeImage', '1', $includeImage==1); ?>
					Image
				</label>
				</div>
		  	</div>
		</div>
	</fieldset>
</div>