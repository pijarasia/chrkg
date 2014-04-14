<html>
<body>
    <!--<h2><?php echo lang('data_karya')?></h2>-->
    <form name="form_datapublikasi" id="form_datapublikasi" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>        
        <div id="loadButtonPublication">
            <a data-toggle="modal" href="#dialog-publikasi" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>
            <br /><br />
            <?php echo lang('ket_data_publikasi');?>                            
        </div>
        <br />
        <?
            }
        ?>
        <div id="dialog-publikasi" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?php echo lang('data_karya')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">              
                    <div class="control-group">
                        <label class="control-label" for="judul"><?php echo lang('judul')?> </label>
                        <div class="controls">
                            <textarea name="judul" id="judul" cols="40" rows="4"></textarea>
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
                <input type="hidden" name="hiddenIDPublikasi" id="hiddenIDPublikasi" />
                <input type="submit" class="btn btn-info" name="simpan_publikasi" id="simpan_publikasi" value="<?php echo lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
            </div>
        </div>
        <div id="tblpublication"></div> 
    </form>  

    <!--Dialog Delete Publication-->
    <div id="dialog-delete-publication" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('publikasi')?></h4>
        </div>
        <div class="modal-body" id="body-delete-publication">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_publikasi" id="hidden_del_publikasi" />
            <input type="submit" class="btn btn-info" name="hapus_publikasi" id="hapus_publikasi" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>