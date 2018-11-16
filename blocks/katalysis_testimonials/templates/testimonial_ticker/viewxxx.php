<?php  defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();

?>
<div class="tf-container flexslider">

<?php  if (isset($error)) { ?>

    <span class="tf-error">
        <?php  echo t('There was a problem retreving the tweets:'); ?>
        <p class="tf-error-message">
            <?php  echo $error->message; ?>
        </p>
    </span>

<?php  } elseif (is_array($account)) { ?>
    <?php  if (count($tweets) > 0) { ?>
    <ul class="tf-tweets slides">
        <?php  foreach ($tweets as $tweet) { ?>
        <li class="tf-tweet">
            <div class="tf-body">
                <?php  echo $tweet->text; ?>
            </div>
            <div class="tf-info">
                <?php  if ($show_avatars) { ?>
                <div class="tf-avatar">
                    <img src="<?php  echo $tweet->avatar_url; ?>" alt="<?php  echo $tweet->screen_name; ?>">
                </div>
              <?php  } ?>
				<?php  if ($show_authors) { ?>
				<div class="tf-meta">
	                <p class="tf-name">
	                    <?php  echo $tweet->name; ?>
	                </p>
				<?php  } ?>
                <?php  if ($show_date) { ?>
	                <p class="tf-date">
	                    <?php  echo $tweet->created_at; ?>
	                </p>
                <?php  } ?>
                 </div>
            </div>
        </li>
        <?php  } ?>
    </ul>
    <?php  } else { ?>
        <div class="tf-no-tweets-found"><?php  echo t('No tweets found.'); ?></div>
    <?php  } ?>

<?php  } elseif ($c->isEditMode()) { ?>
    <div class="ccm-edit-mode-disabled-item"><?php  echo t('In-Active Twitter Feed Block.'); ?></div>
<?php  } ?>

</div>

<script type="text/javascript">
    $(window).load(function(){
      $('.tf-container').flexslider({
        slideshow: false,
        controlNav: false,
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
</script>