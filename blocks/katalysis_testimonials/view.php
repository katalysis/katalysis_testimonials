<?php defined('C5_EXECUTE') or die("Access Denied."); 
$th = Loader::helper('text');
$ih = Loader::helper('image');
$image_width = 250;
$image_height = 150;

$constrainedClass = 'not-constrained';

if($constrain) {
	$constrainedClass = 'constrained';
}

$mainClasses = 'class="ktestimonials ' . $background .' ' . $constrainedClass .'"';
$blockquoteClasses = ' class="' . $panelBackground .'"';

?>

<div <?php echo $mainClasses ?>>
    <?php if($constrain){ ?>
	<div class="grid-container">
	<?php } ?>
	<?php  if($title): ?>
		<<?php echo $headingStyle ?> class="text-center"><?php echo $title; ?></<?php echo $headingStyle ?>>
    <?php  endif ?>
    <div class="ktestimonials-list">
    <?php foreach($testimonialslist as $tl): ?>
        <blockquote<?php echo $blockquoteClasses ?>>
	        <div class="grid-x grid-padding-x grid-margin-x align-middle">
	        <?php if($tl->image > 0 && $includeImage == 1) { ?>
		        <div class="small-12 medium-8 large-9 cell">
			        <?php if($tl->extract && $includeExtract == 1) { ?>
			        <h3><?php echo t($tl->extract)?></h3>
			        <?php } ?>
					<?php if($tl->testimonial && $includeTestimonial == 1) { ?>
					<?php echo t($tl->testimonial)?>
			        <?php } ?>		             
		            <?php if($includeAuthor == 1 || $includeOrganisation == 1 || $includeDate == 1 ):?>
			            <p class="ktestimonials-credit">
			            <?php if($includeAuthor == 1):?>
			    	    	<span class="ktestimonials-author">
			                <?php echo $tl->author?>
			    	    	</span>
			                <?php endif ?>
			                <?php if($tl->organisation && $includeOrganisation == 1 && $tl->url && $includeUrl == 1):?>
									<a href="<?php echo t($tl->url)?>" class="ktestimonials-organisation">
										<?php echo nl2br($tl->organisation); ?>			                
									</a>
			                <?php elseif($tl->organisation && $includeOrganisation == 1):?>
									<span class="ktestimonials-organisation"><?php echo nl2br($tl->organisation); ?></span>
			                <?php endif ?>
			                <?php  if($tl->date && $includeDate == 1):?>
			                <span class="ktestimonials-date"><?php echo ' ' . date('d', strtotime($tl->date)) . '|' . date('m', strtotime($tl->date)) . '|' . date('y', strtotime($tl->date)); ?></span>
			                <?php  endif ?>
			            </p>
		            <?php  endif ?>
		        </div>
		       
				<div class="small-12 medium-4 large-3 cell ktestimonials-image">
					<?php 
					$f = File::getByID($tl->image);
					$altText = $tl->organisation;
					
			        if (is_object($f) && $f->getFileID()) {
				    if ($f->getTypeObject()->isSVG()) {
				        $tag = new \HtmlObject\Image();
				        $tag->src($f->getRelativePath());
				        $tag->addClass('ccm-svg');
				    } else {
				        $image = $app->make('html/image', [$f]);
				        $tag = $image->getTag();
				    }
				
				    $tag->addClass('ccm-image-block img-responsive bID-' . $bID);
				
				    if ($altText) {
				        $tag->alt(h($altText));
				    } else {
				        $tag->alt('');
				    }
				
				    if ($title) {
				        $tag->title(h($title));
				    }
				
				    echo $tag;
				
				}
					?>
				</div>
	        
	        <?php } else { ?>
		        <div class="small-12 cell">
			        
		        <?php if($tl->extract && $includeExtract == 1) { ?>
			        <h3><?php echo t($tl->extract)?></h3>
			        <?php } ?>
					<?php if($tl->testimonial && $includeTestimonial == 1) { ?>
					<?php echo t($tl->testimonial)?>
			        <?php } ?>		             
		            <?php if($includeAuthor == 1 || $includeOrganisation == 1 || $includeDate == 1 ):?>
			            <p class="ktestimonials-credit">
			            <?php if($includeAuthor == 1):?>
			    	    	<span class="ktestimonials-author">
			                <?php echo $tl->author?><?php  if($tl->organisation && $includeOrganisation == 1):?>,<?php  endif ?>
			    	    	</span>
			                <?php  endif ?>
			                <?php  if($tl->organisation && $includeOrganisation == 1):?>
			                <span class="ktestimonials-organisation"><?php echo nl2br($tl->organisation); ?></span>
			                <?php  endif ?>
			    	    	</span>
			                <?php  if($tl->date && $includeDate == 1):?>
			                <span class="ktestimonials-date"><?php echo ' ' . date('d', strtotime($tl->date)) . '|' . date('m', strtotime($tl->date)) . '|' . date('y', strtotime($tl->date)); ?></span>
			                <?php  endif ?>
			            </p>
		            <?php  endif ?>
		            
		        </div>
	        <?php } ?>
	        </div>
        </blockquote>
    <?php  endforeach ?>
    </div>
    <?php if($showAllLink): ?>
		<p class="kexcea-list-link text-center"><a href="/index.php?cID=<?php echo Config::get('katalysis.testimonials_parent') ; ?>">See all testimonials</a></p>
	<?php endif ?>
    <?php if($constrain){ ?>
	</div>
	<?php } ?>
</div>
