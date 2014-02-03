<html>
<body>
    <!--<h2><?=lang('data_organisasi')?></h2>-->
    <form name="form_dataorganisasi" id="form_dataorganisasi" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>        
        <div id="loadButtonOrganization">
            <a data-toggle="modal" href="#dialog-organisasi" class="btn"><i class="icon-plus"></i> <?=lang('tambah')?></a>                
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
                <h4><?=lang('organisasi')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">              
                    <div class="control-group">
                        <label class="control-label" for="organisasi"><?=lang('organisasi')?> </label>
                        <div class="controls">
                            <input type="text" name="organisasi" id="organisasi" class="input-xlarge" placeholder="<?=lang('organisasi')?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="bidang"><?=lang('bidang')?> </label>
                        <div class="controls">
                            <input type="text" name="bidang" id="bidang" class="input-xlarge" placeholder="<?=lang('bidang')?>"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="tahun_masuk"><?=lang('periode')?> </label>
                        <div class="controls">
                            <select name="tahun_masuk" id="tahun_masuk" class="input-small">
                                <option value=""><?=lang('tahun')?></option>
                                <?
                                    $tahun = date('Y'); 
                                    $tahun56 = date('Y')-56; //min 56 yrs old
                                    for($thn = $tahun; $thn >= $tahun56; $thn--)
                                    {
                                        echo '<option value="'.$thn.'">'.$thn.'</option>';
                                    }
                                ?>    
                            </select>                                                                                                                                             
                            <?=lang('s.d')?>
                            <select name="tahun_lulus" id="tahun_lulus" class="input-small">
                                <option value=""><?=lang('tahun')?></option>
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
                        <label class="control-label" for="kota_organisasi"><?=lang('kota')?> <?=lang('penyelenggara')?> </label>
                        <div class="controls">
                        <input type="text" name="kota_organisasi" id="kota_organisasi" class="input-xlarge" placeholder="<?=lang('kota')?>"/>
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label" for="posisi"><?=lang('posisi_organisasi')?> </label>
                        <div class="controls">
                            <input type="text" name="posisi" id="posisi" class="input-xlarge" placeholder="<?=lang('posisi_organisasi')?>"/>
                        </div>
                    </div>                                                                                                                                                         
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDOrganisasi" id="hiddenIDOrganisasi" />
                <input type="submit" class="btn btn-info" name="simpan_organisasi" id="simpan_organisasi" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        <div id="tblorganization"></div> 
    </form>  

    <!--Dialog Delete Organization-->
    <div id="dialog-delete-organization" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?=lang('hapus')?> <?=lang('organisasi')?></h4>
        </div>
        <div class="modal-body" id="body-delete-organization">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_organisasi" id="hidden_del_organisasi" />
            <input type="submit" class="btn btn-info" name="hapus_organisasi" id="hapus_organisasi" value="<?=lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>