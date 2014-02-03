<html>
<head>
    <title>Details Job</title>
</head>
<body style="width: 1200px;margin: 110px auto;">
<div class='content-inner well'>
    <h3 style="color: #aaa;">Details Job</h3>
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
            <td rowspan="7" class="atas" style="width: 140px;vertical-align:top;">
                <img src="<?php echo base_url();?>public/assets/images/company_logo/<?php echo $details->companyLogo;?>" width="140"/>
            </td>
            <td><span class="tebal"><?php echo $details->companyName;?></span></td>
        </tr>
        <tr>
            <td class="tebal">
                <?php echo $details->joborderTitle;?>
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
            <td class="tebal">
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
            <td>
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
            <td id="loadLamar">
                <?php
                    if ($cek_apply->applyID == "" || $cek_apply->applyCancel == 1)
                    {
                        if ($details->RemainingTime > -1)
                        {
                ?>
				<a class="btn btn-info" id="confirmApply" onclick="history.back();return false;"><li class="icon-home icon-white"></li>&nbsp;&nbsp;Back</a>
				&nbsp;
                <a class="btn btn-info" id="confirmApply" onclick="confirmApply('<?php echo $cek_apply->applyID;?>')"><li class="icon-hdd icon-white"></li>&nbsp;&nbsp;<?=lang('lamar')?></a>
                <?
                        }
                    } else if ($cek_apply->applyID != "" && $cek_apply->applyCancel == 0){
                ?>
				<a class="btn btn-info" id="confirmApply" onclick="history.back();return false;"><li class="icon-home icon-white"></li>&nbsp;&nbsp;Back</a>
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
</body>
</html>