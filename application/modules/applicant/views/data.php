<html>
<body>
<div class='content-inner well' style="background-color: #f5f5f5;padding: 5px 10px 25px 20px;min-height: 530px;">
    <!--<div class="row" style="margin-top: 10px;">
        <div class="span2" style="text-align: center;">
        </div>
        <div class="span10">
            <h4><?php echo $aplName!=""?$aplName:""; ?></h4>
            <h5><?php echo $Age!=""?$Age." Tahun":""; ?></h5>
        </div>
    </div>-->
        
    <!--<div class="btn-group btn-group-vertical">
        <button class="btn btnData active"><?php echo lang('data_diri')?></button>
        <button class="btn btnData"><?php echo lang('data_keluarga')?></button>
        <button class="btn btnData"><?php echo lang('data_pendidikan')?></button>
        <button class="btn btnData"><?php echo lang('data_pelatihan')?></button>
        <button class="btn btnData"><?php echo lang('data_bahasa')?></button>
        <button class="btn btnData"><?php echo lang('data_organisasi')?></button>
        <button class="btn btnData"><?php echo lang('data_karya')?></button>
        <button class="btn btnData"><?php echo lang('data_pendidikan')?></button>
        <button class="btn btnData"><?php echo lang('pengalaman_kerja')?></button>
        <button class="btn btnData"><?php echo lang('form_lain')?></button>
    </div>-->
    
    <?php echo $pesan!=""?"<div style='text-align:center;color:blue;border:1px solid #ddd;padding: 20px 10px;margin:20px;'>".$pesan."</div>":"";?>

    <?php 
        if ($pesan == "")
        {
    ?>    
        <form id="form_foto" name="form_foto" enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?>applicant/foto">
            <div id="dialog-foto" class="modal custom hide fade in" style="display: none;max-width: 400px;">
                <div class="modal-body" style="padding-left: 15px;" id="body-foto">                
                    <input type="hidden" name="hiddenID" id="hiddenID" value="<?php echo $person;?>"/>
                    <input type="file" title="<?php echo lang('unggah')." ".lang('foto')?>" class="btn-small" id="fileFoto" name="fileFoto"/>
                    <div id="upload" style="color: red;padding-left: 2px;"></div>
                </div>                                    
                <div class="modal-footer">
                    <input type="submit" class="btn btn-info btn-small" name="upload_foto" id="upload_foto" value="<?php echo lang('unggah')?>" onclick="fileUpload(this.form,'<?php echo base_url(); ?>applicant/foto','upload'); return false;"/>
                    <a href="#" class="btn btn-small" data-dismiss="modal"><?php echo lang('batal')?></a>
                </div>
            </div>
        </form>    
    
    <div class="row-fluid">
        <div class="span2">    
            <div style="text-align: center;padding-bottom:15px;">
                <div id="divphoto">
                    <img src="<?php echo $photo;?>" width="150"/>  
                </div>
                <?php
                    if ($bool_upload)        
                    {
                ?>                        
                <a data-toggle="modal" href="#dialog-foto" class="btn btn-inverse" id="upload" style="margin: 10px 0;"><?php echo lang('unggah')?> <?php echo lang('foto')?></a>
                <?php
                    }
                ?>                        
            </div>
            <ul class="nav nav-tabs nav-stacked" id="tabForm">
                <li class="active"><a href="#data_diri"><?php echo lang('data_diri')?></a></li>
                <li><a href="#data_keluarga"><?php echo lang('data_keluarga')?></a></li>
                <li><a href="#data_pendidikan"><?php echo lang('data_pendidikan')?></a></li>
                <li><a href="#data_pelatihan"><?php echo lang('data_pelatihan')?></a></li>
                <li><a href="#data_bahasa"><?php echo lang('data_bahasa')?></a></li>
                <li><a href="#data_organisasi"><?php echo lang('data_organisasi')?></a></li>
                <li><a href="#data_karya"><?php echo lang('data_karya')?></a></li>
                <li><a href="#data_prestasi"><?php echo lang('data_prestasi')?></a></li>
                <li><a href="#data_pengalaman"><?php echo lang('pengalaman_kerja')?></a></li>
                <li><a href="#data_lain"><?php echo lang('form_lain')?></a></li>
            </ul>
        </div>
        <div class="span10">
            <div class="tab-content" id="contentData">
                <div class="tab-pane active" id="data_diri" data-src='<?php echo base_url();?>applicant/data_diri/'>
                    <iframe src='<?php echo base_url();?>applicant/data_diri/' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 0)'></iframe> 
                </div>
                <div class="tab-pane" id="data_keluarga" data-src='<?php echo base_url();?>applicant/data_keluarga/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                 		
        		</div>
                <div class="tab-pane" id="data_pendidikan" data-src='<?php echo base_url();?>applicant/data_pendidikan/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                 		
        		</div>
                <div class="tab-pane" id="data_pelatihan" data-src='<?php echo base_url();?>applicant/data_pelatihan/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                 
                </div>
                <div class="tab-pane" id="data_bahasa" data-src='<?php echo base_url();?>applicant/data_bahasa/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                         
                </div>
                <div class="tab-pane" id="data_organisasi" data-src='<?php echo base_url();?>applicant/data_organisasi/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                                 
                </div>
                <div class="tab-pane" id="data_karya" data-src='<?php echo base_url();?>applicant/data_karya/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                                 
                </div>
                <div class="tab-pane" id="data_prestasi" data-src='<?php echo base_url();?>applicant/data_prestasi/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                                                 
                </div>
                <div class="tab-pane" id="data_pengalaman" data-src='<?php echo base_url();?>applicant/data_pengalaman/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 600)'></iframe>                         
                </div>
                <div class="tab-pane" id="data_lain"  data-src='<?php echo base_url();?>applicant/data_lain/'>
                    <iframe src='' frameborder='0' width='100%' height='100%' onload = 'javascript:resizeIframe(this, 350)'></iframe>                                 
                </div>
            </div>
        </div>
    <?
        }
    ?>
</div> 
</body>
</html>