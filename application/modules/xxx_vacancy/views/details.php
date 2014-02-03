<!--<body style="width: 1200px;margin: 110px auto;">-->
<div class='content-inner well'>
    <h5 style="color: #aaa;">Job Description</h5>
    <?php
        $details = $details->row();
        if (count($details) > 0)
        {
    ?>
    <input type="hidden" name="hiddenJobApplyID" id="hiddenJobApplyID" value="<?php echo $details->applyID;?>"/>
    <input type="hidden" name="hiddenID" id="hiddenID" value="<?php echo $details->joborderID;?>"/>
    <!-- - <span style="color: #aaa;"><?php echo $details->joborderCity;?>, <?php echo $details->joborderState;?></span>-->
    <table class="tblDalam">
        <tr>
            <!--<td rowspan="7" class="atas" style="width: 140px;vertical-align:top;">
                <img src="<?php echo base_url();?>public/assets/images/company_logo/<?php echo $details->companyLogo;?>" width="140"/>
            </td>-->
            <td width="80%"><span class="tebal"><?php echo $details->companyName;?></span></td>
			<!--SHAREMEDIA-->
			<td width="20%" style="align:right;">
			<div class="MeaWrap MeaRight">
				         	<div class="Media">
				         		<!-- AddThis Button BEGIN -->
								<div class="addthis_toolbox addthis_default_style addthis_32x32_style" addthis:url="http://bit.ly/1eSM9EG">
									<a class="addthis_button_facebook at300b" title="Facebook" href="#"><span class=" at300bs at15nc at15t_facebook"><span class="at_a11y">Share on facebook</span></span></a>
									<a class="addthis_button_twitter addthis_button_preferred_1 at300b" title="Tweet" href="#"><span class=" at300bs at15nc at15t_twitter"><span class="at_a11y">twitter</span></span></a>
									<a class="addthis_button_email addthis_button_preferred_2 at300b" target="_blank" title="Email" href="#"><span class=" at300bs at15nc at15t_email"><span class="at_a11y">email</span></span></a>
									<a class="addthis_button_print addthis_button_preferred_3 at300b" title="Print" href="#"><span class=" at300bs at15nc at15t_print"><span class="at_a11y">print</span></span></a>
									<a class="addthis_button_compact at300m" href="#"><span class=" at300bs at15nc at15t_compact"><span class="at_a11y">More Sharing Services</span></span></a>
								<div class="atclear" tabindex="1000"></div></div>
								<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50f64d057c8657d1">
								</script><div id="_atssh" style="visibility: hidden; height: 1px; width: 1px; position: absolute; z-index: 100000;">
								<iframe id="_atssh373" title="AddThis utility frame" style="height: 1px; width: 1px; position: absolute; z-index: 100000; border: 0px; left: 0px; top: 0px;" src="//ct1.addthis.com/static/r07/sh142.html#iit=1384772343261&amp;tmr=load%3D1384772342606%26core%3D1384772342715%26main%3D1384772343246%26ifr%3D1384772343261&amp;cb=0&amp;cdn=1&amp;chr=UTF-8&amp;kw=&amp;ab=-&amp;dh=kompasgramedia.hiringboss.com&amp;dr=http%3A%2F%2Fkompasgramedia.hiringboss.com%2FcandidateApplication_initSearchJobsPage.do%3Fsubdomain%3Dkompasgramedia%26languageCode%3Den&amp;du=http%3A%2F%2Fkompasgramedia.hiringboss.com%2FcandidateApplication_detailJobadthis.do%3FjobId%3D34399%26candidateSourceId%3D32668%26jobIds%3D34399%26searchOtherJob%3D%26languageCode%3Den&amp;dt=ACCOUNT%20EXECUTIVE%20DEVELOPMENT%20PROGRAM%20(AEDP)%20-%20Kompas%20Gramedia&amp;dbg=0&amp;md=0&amp;cap=tc%3D0%26ab%3D0&amp;inst=1&amp;vcl=1&amp;jsl=1&amp;prod=undefined&amp;lng=en-US&amp;ogt=height%2Cwidth%2Cimage%2Cdescription%2Ctitle%2Ctype%3Darticle&amp;pc=men&amp;pub=ra-50f64d057c8657d1&amp;ssl=0&amp;sid=5289f2f64898d083&amp;srpl=1&amp;srcs=1&amp;srd=1&amp;srf=1&amp;srx=1&amp;ver=300&amp;xck=0&amp;xtr=0&amp;og=type%3Darticle%26title%3DACCOUNT%2520EXECUTIVE%2520DEVELOPMENT%2520PROGRAM%2520(AEDP)%2520-%2520Kompas%2520Gramedia%26description%3DACCOUNT%2520EXECUTIVE%2520DEVELOPMENT%2520PROGRAM%2520(AEDP)%2520-%2520Kompas%2520Gramedia%26image%3Dhttp%253A%252F%252Fkompasgramedia.hiringboss.com%252Fimages%252Fcompany_logo.png%26image%253Awidth%3D200%26image%253Aheight%3D200&amp;aa=0&amp;rev=124737&amp;ct=1&amp;xld=1&amp;xd=1"></iframe></div><script type="text/javascript" src="http://ct1.addthis.com/static/r07/core109.js"></script>
								<!-- AddThis Button END -->
							</div>
				         	<!--h1 class="detail-job-title Text"> ACCOUNT EXECUTIVE DEVELOPMENT PROGRAM (AEDP)</h1-->
				         </div>
			</td>
			<!--SHAREMEDIA-->
        </tr>
        <tr>
            <td class="tebal" colspan="2">
                <h1><?php echo $details->joborderTitle;?></h1>
                <!--<span id="person">
                    <?php
                        if ($cek_person_apply->Jml > 0) {
                    ?>
                    <i class="icon-user"></i> <?php echo $cek_person_apply->Jml;?> <?=lang('telah_melamar')?>
                    <?
                        }
                    ?>
                </span>-->
            </td>
        </tr>
        <tr>
            <td class="tebal" colspan="2">
                <i class="icon-upload"></i> <?=lang('posted')?>: <?php echo date("d M Y", strtotime($details->joborderStartDate));?> -
                <?
                    if ($details->RemainingTime > -1)
                    {
                ?>
                        <i class="icon-time"></i>
                    <?php
                        if ($details->RemainingTime == 0 && $details->RemainingTime == "")
                        {
                    ?>
                        Hari ini
                    <?
                        } else {
                    ?>
                        <?php echo $details->RemainingTime;?> <?=lang('hari_lagi')?>
                    <?

                        }
                    } else
                        echo '<span style="color:red;"><i class="icon-warning-sign"></i> '.lang('periode_ditutup')."</span>";
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table>
                    <tr>
                        <td style="width: 120px;"><?=lang('tipe_pekerjaan')?></td>
                        <td style="width: 10px;">:</td>
                        <td><?php echo ucwords($details->EmploymentType);?></td>
                    </tr>
                    <tr>
                        <td class="atas"><?=lang('deskripsi_pekerjaan')?></td>
                        <td class="atas">:</td>
                        <td><?php echo $details->joborderDescription;?></td>
                    </tr>
                    <tr>
                        <td class="atas"><?=lang('persyaratan')?></td>
                        <td class="atas">:</td>
                        <td><?php echo $details->jobOrderNotes!=""?$details->jobOrderNotes:"-";?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?
            //if ($this->session->userdata('xyz') == 10 || $this->session->userdata('xyz') == 11)
            //{
        ?>
        <tr>
            <td id="loadLamar" colspan="2">
                <?php
                    if ($cek_apply->applyID == "" || $cek_apply->applyCancel == 1)
                    {
                        if ($details->RemainingTime > -1)
                        {
                ?>
				<a class="btn btn-info" id="confirmApply" onclick="history.back();return false;"><li class="icon-home icon-white"></li>&nbsp;&nbsp;Back to Search Result</a>
				&nbsp;
                <a class="btn btn-info" id="confirmApply" onclick="confirmApply('<?php echo $cek_apply->applyID;?>')"><li class="icon-hdd icon-white"></li>&nbsp;&nbsp;<?=lang('lamar')?></a>
                <?
                        }
                    } else if ($cek_apply->applyID != "" && $cek_apply->applyCancel == 0){
                ?>
				<a class="btn btn-info" id="confirmApply" onclick="history.back();return false;"><li class="icon-home icon-white"></li>&nbsp;&nbsp;Back to Search Result</a>
				&nbsp;
                <a class="btn btn-info" id="cancelApply" onclick="cancelApply('<?php echo $cek_apply->applyID;?>')"><li class="icon-remove icon-white"></li>&nbsp;<?=lang('batal')?> <?=lang('lamar')?></a>
                <a class="btn btn-info" id="listlApply" onclick="listApply()"><li class="icon-list-alt icon-white"></li>&nbsp;<?=lang('listjob')?></a>
                <?
                    }
                ?>
            </td>
        </tr>
        <?
            //}
        ?>
    </table>
    <?php
        }
    ?>
    <div id="resapply"></div>


    <!--Dialog Apply Job-->
    <form id="form_lamar" name="form_lamar" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>vacancy/apply">
        <div id="dialog-apply-job" class="modal custom hide fade in" style="display: none;">
            <div class="modal-body" style="padding-left: 15px;" id="body-apply-job">
                <h5><?=lang('notif_lamar')?></h5>
                <input type="hidden" name="hiddenID" id="hiddenID" value="<?php echo $details->joborderID;?>"/>
                <div style="padding: 5px 0;">
                    <input type="file" title="1. <?php echo lang('unggah')." ".lang('cover_letter')?>" class="btn-small" id="fileCoverLetter" name="fileCoverLetter"/>
                    <div id="upload" style="color: #800000;padding-left: 2px;"></div>
                </div>
                <div style="padding: 5px 0;">
                    <input type="file" title="2. <?php echo lang('unggah')." ".lang('cv')?>" class="btn-small" id="fileCV" name="fileCV"/>
                    <div id="uploadcv" style="color: #800000;padding-left: 2px;"></div>
                </div>
                <div id="result" style="color: #800000;padding-left: 2px;font-weight: bold;"></div>
            </div>
            <div class="modal-footer">
                <input type="submit" class="btn btn-info btn-small" name="apply_job" id="apply_job" value="<?=lang('lamar')?>" onclick="fileUpload(this.form,'<?php echo base_url(); ?>vacancy/apply','result'); return false;"/>
                <a href="#" class="btn btn-small" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
    </form>

    <!--Dialog Cancel Apply-->
    <div id="dialog-cancel-apply" class="modal custom hide fade in" style="display: none;">
        <div class="modal-body" style="padding-left: 15px;" id="body-cancel-apply">
            <h5><?=lang('notif_batal')?></h5>
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-info btn-small" name="cancel_apply" id="cancel_apply" value="<?=lang('batal')?> <?=lang('lamar')?>" />
            <a href="#" class="btn btn-small" data-dismiss="modal"><?=lang('tidak')?></a>
        </div>
    </div>
</div>