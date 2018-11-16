<?php
defined('C5_EXECUTE') or die(_("Access Denied."));
$text = Loader::helper('text');
?>

<div class="testimonial-ticker kbox kt-col1 flexslider" id="testimonial-ticker-<?php echo $bID; ?>" data-equalizer-watch>
	<i class="kicon ki-quote-open"></i>
	<ul class="st-pro-ticker slides">
	<?php foreach($testimonialslist as $tl){ ?>
		<li>
			<div class="testimonial-content">
				<h4 class="testimonial-title"><?php echo $tl->title ?></h4>
				<p><span class="testimonial-author"><?php echo $tl->author ?>,</span> <span class="testimonial-organisation"><?php echo $tl->organisation ?></span></p>
		    </div>
		</li>
	<?php    } ?>
	</ul>
	<i class="kicon ki-quote-close"></i>
</div>
<script type="text/javascript">
    $(window).load(function(){
      $('#testimonial-ticker-<?php echo $bID; ?>').flexslider({
        slideshow: true,
        controlNav: false,
        directionNav: false,
        animation: "slide",
        useCSS : false,
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
</script>