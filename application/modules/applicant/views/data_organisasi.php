<html>
<body>
    <!--<h2><?php echo lang('data_organisasi')?></h2>-->
    <form name="form_dataorganisasi" id="form_dataorganisasi" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>        
        <div id="loadButtonOrganization">
            <a data-toggle="modal" href="#dialog-organisasi" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>                
            <br /><br />
            <?php echo lang('ket_data_organisasi');?>
        </div>
        <br />
        <?
            }
        ?>
        <div id="dialog-organisasi" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?php echo lang('organisasi')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">              
                    <div class="control-group">
                        <label class="control-label" for="organisasi"><?php echo lang('organisasi')?> </label>
                        <div class="controls">
                            <input type="text" name="organisasi" id="organisasi" class="input-xlarge" placeholder="<?php echo lang('organisasi')?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="bidang"><?php echo lang('bidang')?> </label>
                        <div class="controls">
                            <input type="text" name="bidang" id="bidang" class="input-xlarge" placeholder="<?php echo lang('bidang')?>"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="tahun_masuk"><?php echo lang('periode')?> </label>
                        <div class="controls">
                            <select name="tahun_masuk" id="tahun_masuk" class="input-small">
                                <option value=""><?php echo lang('tahun')?></option>
                                <?
                                    $tahun = date('Y'); 
                                    $tahun56 = date('Y')-56; //min 56 yrs old
                                    for($thn = $tahun; $thn >= $tahun56; $thn--)
                                    {
                                        echo '<option value="'.$thn.'">'.$thn.'</option>';
                                    }
                                ?>    
                            </select>                                                                                                                                             
                            <?php echo lang('s.d')?>
                            <select name="tahun_lulus" id="tahun_lulus" class="input-small">
                                <option value=""><?php echo lang('tahun')?></option>
                                <?
                                    $tahun = date('Y'); 
                                    $tahun56 = date('Y')-56; //min 56 yrs old
                                    for($thn = $tahun; $thn >= $tahun56; $thn--)
                                    {
                                        echo '<option value="'.$thn.'">'.$thn.'</option>';
                                    }
                                ?>    
                            </select>                                                
                        </div>
                    </div>                                                                                           
                    <div class="control-group">
                        <label class="control-label" for="kota_organisasi"><?php echo lang('kota')?> <?php echo lang('penyelenggara')?> </label>
                        <div class="controls">
                        <input type="text" name="kota_organisasi" id="kota_organisasi" class="input-xlarge" placeholder="<?php echo lang('kota')?>"/>
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label" for="posisi"><?php echo lang('posisi_organisasi')?> </label>
                        <div class="controls">
                            <input type="text" name="posisi" id="posisi" class="input-xlarge" placeholder="<?php echo lang('posisi_organisasi')?>"/>
                        </div>
                    </div>                                                                                                                                                         
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDOrganisasi" id="hiddenIDOrganisasi" />
                <input type="submit" class="btn btn-info" name="simpan_organisasi" id="simpan_organisasi" value="<?php echo lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
            </div>
        </div>
        <div id="tblorganization"></div> 
    </form>  

    <!--Dialog Delete Organization-->
    <div id="dialog-delete-organization" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('organisasi')?></h4>
        </div>
        <div class="modal-body" id="body-delete-organization">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_organisasi" id="hidden_del_organisasi" />
            <input type="submit" class="btn btn-info" name="hapus_organisasi" id="hapus_organisasi" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>