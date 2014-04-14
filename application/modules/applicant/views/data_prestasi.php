<html>
<body>
    <!--<h2><?php echo lang('data_karya')?></h2>-->
    <form name="form_dataprestasi" id="form_dataprestasi" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>        
        <div id="loadButtonAchievements">
            <a data-toggle="modal" href="#dialog-prestasi" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>             
            <br /><br />
            <?php echo lang('ket_data_prestasi');?>               
        </div>
        <br />
        <?
            }
        ?>        
        <div id="dialog-prestasi" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?php echo lang('data_prestasi')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">              
                    <div class="control-group">
                        <label class="control-label" for="bidang"><?php echo lang('bidang')?> </label>
                        <div class="controls">
                            <textarea name="bidang" id="bidang" cols="40" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="keterangan"><?php echo lang('keterangan')?> </label>
                        <div class="controls">
                            <textarea name="keterangan" id="keterangan" cols="40" rows="4"></textarea>
                        </div>
                    </div>                                                                                                                                                      
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDPrestasi" id="hiddenIDPrestasi" />
                <input type="submit" class="btn btn-info" name="simpan_prestasi" id="simpan_prestasi" value="<?php echo lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
            </div>
        </div>
        <div id="tblachievements"></div>

    <!--Dialog Delete Achievements-->
    <div id="dialog-delete-achievements" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('data_prestasi')?></h4>
        </div>
        <div class="modal-body" id="body-delete-achievements">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_prestasi" id="hidden_del_prestasi" />
            <input type="submit" class="btn btn-info" name="hapus_prestasi" id="hapus_prestasi" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>