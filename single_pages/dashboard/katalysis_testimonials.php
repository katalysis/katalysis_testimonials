<?php       defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<style>
i.item-select-list-sort:hover{cursor:row-resize;}
.ui-sortable-helper {display: table;}
</style>

<div class="ccm-dashboard-header-buttons">
	<a href="<?php echo View::url('/dashboard/katalysis_testimonials/testimonial')?>" class="btn btn-primary"><?php echo t("Add Testimonial")?></a>
</div>

<form action="" method="get">
	<div class="ccm-dashboard-content-full">
	    <div data-search-element="results">
	        <div class="table-responsive">
	    		<table cellspacing="0" cellpadding="0" border="0" class="ccm-search-results-table ccm-search-results-table-icon table-striped">
					<thead>
						<tr>
							<th style="width:30%"><span><?php echo t('Author')?></span></th>
							<th style="width:50%"><span><?php echo t('Testimonial extract')?></span></th>
							<th style="text-align:center;"><span><?php echo t('Featured')?></span></th>
							<th><span><?php echo t('Status')?></span></th>
							<th><span><?php echo t('')?></span></th>
							<th><span><?php echo t('')?></span></td>
							<th><span><?php echo t('')?></span></td>
						</tr>
					</thead>
					<tbody>
					<?php  
						
						foreach ($testimonialslist as $tl) : ?>
							<?php
								$testimonial = $tl->testimonial;
								if(strlen($testimonial) > 100) { $testimonial = substr($testimonial, 0, 100) . "...";}
							?>
				
						<tr id="sID_<?php echo($tl->sID)?>">
							<td><?php echo $tl->author; ?></td>
							<td><?php echo $tl->extract ?></td>
							<td style="text-align:center;">
								<a href="<?=$view->action('feature', $tl->sID)?>">
									<!-- Featured icon -->
									<?php if ($tl->featured == 1) { ?>
									<i class="fa fa-star" style="font-size:24px"></i>
									<?php } else { ?>
									<i class="fa fa-star-o" style="color:#CCC;font-size:24px"></i>
									<?php } ?>
								</a>
							</td>
							<td>
                                <?php if($tl->Active != 1){?>
                                    <span class="label label-danger">Inactive</span>
                                <?php } else {?>
                                    <span class="label label-success">Active</span>
                                <?php } ?>
                            </td>
							<td>
								<a class="btn btn-primary btn-xs" href="<?php  echo $view->action('testimonial', 'edit', $tl->sID)?>"><?php    echo t('Edit'); ?></a>
							</td>
							<td>
								<a class="btn btn-danger btn-xs" href="<?php  echo $view->action('delete_check', $tl->sID)?>" onclick="deleteTestimonial()"><?php    echo t('Delete'); ?></a>
							</td>
							<td><i class="fa fa-arrows-v item-select-list-sort"></i><span style="visibility: hidden"><?php echo $tl->sortorder; ?></span></td>
						</tr>
				
				   <?php  endforeach; ?>
				   </tbody>
				</table>
			</div>
		</div>
	</div>
	
	<?php  if ($paginator){
		echo $paginator->renderView('dashboard');
	} ?>	

</form>	

<script type="text/javascript">
	$(document).ready(function(){
		$('tbody').sortable({
			handle: '.item-select-list-sort',
			cursor: 'move',
            opacity: 0.5,
			stop: function( event, ui ){
				var ualist = $(this).sortable('serialize');
                $.post('<?php echo URL::to('/dashboard/katalysis_testimonials/sortorder')?>', ualist, function(r) {});
		    }
		})
	});
</script>