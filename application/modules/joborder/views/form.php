<div class='content-inner well'>
    <div class="page-header">
    </div>
<div id="rootwizard">
    <div class="row">
        <div class="span12">
            <div class="tab-content">
                <ul>
                    <li id="job_detail"><a href="#tab1" data-toggle="tab"><span class="label">1</span>Detail</a></li>
                    <li id="job_description"><a href="#tab2" data-toggle="tab"><span class="label">2</span>Descriptions</a></li>
        			<li id="job_timeline"><a href="#tab3" data-toggle="tab"><span class="label">3</span></a>Requirement</li>
                    <li id="job_setting"><a href="#tab4" data-toggle="tab"><span class="label">4</span>Settings</a></li>
        			<li id="job_other"><a href="#tab5" data-toggle="tab"><span class="label">5</span>Other Detail</a></li>
				</ul>
				<div class="tab-content">
				    <ul class="pager wizard">
                        <li class="previous"><a href="javascript:;"><i class="icon-backward"> Prev</i></a></li>
                        <li class="next"><a href="javascript:;">Next <i class="icon-forward"></i></a></li>
                        <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li>
                    </ul>
                    <div class="tab-pane" id="tab1">
                        <?php echo modules::run('joborder/form_wizard1',$in); ?>
				    </div>
				    <div class="tab-pane" id="tab2">
                        <?php echo modules::run('joborder/form_wizard2',$in); ?>
				    </div>
                    <div class="tab-pane" id="tab3">
                        <?php echo modules::run('joborder/form_wizard3',$in); ?>
                    </div>
                    <div class="tab-pane" id="tab4">
                        <?php echo modules::run('joborder/form_wizard4',$in); ?>
                    </div>
                    <div class="tab-pane" id="tab5">
                        <?php echo modules::run('joborder/form_wizard5',$in); ?>
                    </div>
                    <ul class="pager wizard">
                        <li class="previous"><a href="javascript:;"><i class="icon-backward"> Prev</i></a></li>
                        <li class="next"><a href="javascript:;">Next <i class="icon-forward"></i></a></li>
                        <li class="next finish" style="display:none;"><a href="javascript:;">Finish</a></li>
                    </ul>
			    </div>
            </div>
        </div>
   </div>
</div>
</div>