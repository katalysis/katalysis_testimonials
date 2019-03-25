<?php  defined('C5_EXECUTE') or die("Access Denied.");

$fp = FilePermissions::getGlobal();
$tp = new TaskPermission();
$ih = Loader::helper('concrete/ui');
$al = Loader::helper('concrete/asset_library');

$PageTitle = t('Testimonial');

$action = $view->action('save', $sID);
$button = t('Add Testimonial');

if ($controller->getTask() == 'edit') {
    $button = t('Update Testimonial');
}

?>

<div class="ccm-dashboard-header-buttons btn-group">
    <?php
    if($Active != 1) { ?>
        <a href="<?php echo View::url('/dashboard/katalysis_testimonials/testimonial/activate', $sID)?>" class="btn btn-success"><?php  echo t("Activate Testimonial")?></a>
    <?php } else { ?>
        <a href="<?php echo View::url('/dashboard/katalysis_testimonials/testimonial/deactivate', $sID)?>" class="btn btn-danger"><?php  echo t("Deactivate Testimonial")?></a>
    <?php } ?>
</div>

<form method="post" action="<?php echo $action?>">
	<input type="hidden" id="Active" name="Active" value="<?=$Active?>"/>
    <?php
    if($Active != 1) { ?>
        <div class="alert alert-warning">
            This Testimonial is inactive.
        </div>
    <?php } ?>

    <div class="row">
		<div class="col-md-8">
			<!-- Primary testimonial details -->
			<fieldset>
				<div class="form-group">
					<label for="ktAuthor" class="control-label"><?php echo t('Author')?></label>
					<?php echo $form->text('ktAuthor', $ktAuthor)?>
				</div>
				<div class="form-group">
					<label for="ktAuthor" class="control-label"><?php echo t('Date')?></label>
					<?php echo Loader::helper('form/date_time')->date('ktDate', $ktDate)?>
				</div>
				<div class="form-group">
					<label for="ktExtract" class="control-label"><?php echo t('Extract')?></label>
					<?php echo $form->textarea('ktExtract', $ktExtract)?>
					<p class="help-block">Pick a short a short extract of the testimonial to feature.</p>
				</div>
				<div class="form-group">
					<label for="ktTestimonial" class="control-label"><?php echo t('Testimonial')?></label>
					 <?php
					    $editor = Core::make('editor');
					    $editor->getPluginManager()->deselect(array('table', 'tableresize', 'tabletools', 'stylescombo', 'concrete5styles', 'image'));
					    echo $editor->outputStandardEditor('ktTestimonial', $ktTestimonial);
					  ?>
				</div>
				<div class="form-group">
					<label for="ktOrganisation" class="control-label"><?php echo t('Organisation')?></label>
					<?php echo $form->text('ktOrganisation', $ktOrganisation)?>
				</div>
				<div class="form-group">
					<label for="ktUrl" class="control-label"><?php echo t('Link URL')?></label>
					<?php echo $form->url('ktUrl', $ktUrl)?>
				</div>
			</fieldset>
		</div>
		<div class="col-md-3 col-md-push-1">
			<!-- Membership - Product Type Options -->
			<fieldset id="options">
		        <legend>Options</legend>
				
                <?php		
				use \Concrete\Core\Tree\Type\Topic as TopicTree;
				$tree = TopicTree::getByName('Testimonial Topics');
				if (is_object($tree)): ?>
					
				<div class="form-group" data-form-row="Topics">
					<label class="control-label" for="Topics">Topics</label>	
					<?php
			        $node = $tree->getRootTreeNodeObject();
			        $node->populateChildren();
			        if (is_object($node)) {
			            foreach($node->getChildNodes() as $topic) {
							if ($topic instanceof \Concrete\Core\Tree\Node\Type\Topic) {
					            $topicArray[$topic->getTreeNodeID()] = $topic->getTreeNodeDisplayName();
					        }
			            };
			      
			     	} ?>
				        
				 	<?=$form->selectMultiple('Topics', $topicArray, $Topics, array('style' => 'width: 100%;','class' => 'topics'))?>
			    	
			    	<script>
						$(function() {
						    $('#Topics').removeClass('form-control').selectize({
						        plugins: ['remove_button']
						    });
						});
					</script>
			    </div>   
			    <?php endif; ?>
	        	
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
		</div>
	</div>        
	
	<fieldset style="margin-top:3rem">
	    <small class="form-text text-muted">
	        Created by <a href="/dashboard/users/search/view/<?php echo $CreatedBy ?>"><?php echo $CreatedByName ?></a> | <?php echo $CreatedDate ?>. Last updated by <a href="/dashboard/users/search/view/<?php echo $UpdatedBy ?>"><?php echo $UpdatedByName ?></a> | <?php echo $UpdatedDate ?>.
	    </small>
	</fieldset>

	<?php echo $token->output('submit');?>
	<div class="ccm-dashboard-form-actions-wrapper">
		<div class="ccm-dashboard-form-actions">
			<a href="<?php  echo View::url('/dashboard/katalysis_testimonials')?>" class="btn btn-default pull-left"><?php echo t('Return to Testimonial list')?></a>
			<?php echo Loader::helper("form")->submit($button, $button, array('class' => 'btn btn-primary pull-right'))?>
		</div>
	</div>
</form>