<html>
<body>
    <!--<h2><?=lang('data_pelatihan')?></h2>-->
    <form name="form_datapelatihan" id="form_datapelatihan" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>        
        <div id="loadButtonCourse">
            <a data-toggle="modal" href="#dialog-non-pendidikan" class="btn"><i class="icon-plus"></i> <?=lang('tambah')?></a>                
            <br /><br />
            <?php echo lang('ket_data_pelatihan');?>
        </div>
        <br />
        <?
            }
        ?>        
        <div id="dialog-non-pendidikan" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('non_pendidikan')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
                    <div class="control-group">
                        <label class="control-label" for="pelatihan"><?=lang('pelatihan')?> </label>
                        <div class="controls">
                            <textarea name="pelatihan" id="pelatihan" placeholder="<?=lang('pelatihan')?>" rows="3" style="width: 300px;"></textarea>
                        </div>
                    </div>               
                    <div class="control-group">
                        <label class="control-label" for="penyelenggara"><?=lang('penyelenggara')?> </label>
                        <div class="controls">
                            <input type="text" name="penyelenggara" id="penyelenggara" class="input-xlarge" placeholder="<?=lang('penyelenggara')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="kota_penyelenggara"><?=lang('kota')?> <?=lang('penyelenggara')?> </label>
                        <div class="controls">
                        <input type="text" name="kota_penyelenggara" id="kota_penyelenggara" class="input-xlarge" placeholder="<?=lang('kota')?> <?=lang('penyelenggara')?>" />
                        </div>
                    </div>    
                    <div class="control-group">
                        <label class="control-label" for="sertifikat"><?=lang('sertifikat')?> </label>
                        <div class="controls">
                            <input type="text" name="sertifikat" id="sertifikat" class="input-xlarge" placeholder="<?=lang('sertifikat')?>" />
                        </div>
                    </div>                                                                            
                    <div class="control-group">
                        <label class="control-label" for="tanggal_awal"><?=lang('tanggal_awal')?> </label>
                        <div class="controls">
                            <select name="tanggalPelatihanAwal" id="tanggalPelatihanAwal" style="width: 100px;">
                                <option value=""><?=lang('tanggal')?></option>
                                    <?
                                        $tgl = 1; 
                                        for($tgl == 1; $tgl <= 31; $tgl++)
                                        {
                                            echo '<option value="'.$tgl.'">'.$tgl.'</option>';
                                        }
                                    ?>    
                            </select>                                              
                            <select name="bulanPelatihanAwal" id="bulanPelatihanAwal" style="width: 110px;">
                                <option value=""><?=lang('bulan')?></option>
                                <? 
                                    foreach ($bulan->result() as $row)
                                    {
                                        if ($language=="bahasa")
                                            $bln = $row->MonthNameID;
                                        else
                                            $bln = $row->MontNameEN;
                                                                                    
                                        echo '<option value="'.$row->MonthID.'">'.$bln.'</option>';
                                    }
                                ?>    
                            </select>
                            <select name="tahunPelatihanAwal" id="tahunPelatihanAwal" class="input-small">
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
                        <label class="control-label" for="tanggal_akhir"><?=lang('tanggal_akhir')?> </label>
                        <div class="controls">
                            <select name="tanggalPelatihanAkhir" id="tanggalPelatihanAkhir" style="width: 100px;">
                                <option value=""><?=lang('tanggal')?></option>
                                <?
                                    $tgl = 1; 
                                    for($tgl == 1; $tgl <= 31; $tgl++)
                                    {
                                        echo '<option value="'.$tgl.'">'.$tgl.'</option>';
                                    }
                                ?>    
                            </select>                                                  
                            <select name="bulanPelatihanAkhir" id="bulanPelatihanAkhir" style="width: 110px;">
                                <option value=""><?=lang('bulan')?></option>
                                <? 
                                    foreach ($bulan->result() as $row)
                                    {
                                        if ($language=="bahasa")
                                            $bln = $row->MonthNameID;
                                        else
                                            $bln = $row->MontNameEN;
                                            
                                        echo '<option value="'.$row->MonthID.'">'.$bln.'</option>';
                                    }
                                ?>    
                            </select>
                            <select name="tahunPelatihanAkhir" id="tahunPelatihanAkhir" class="input-small">
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
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDPelatihan" id="hiddenIDPelatihan" />
                <input type="submit" class="btn btn-info" name="simpan_pelatihan" id="simpan_pelatihan" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        <div id="tblcourse"></div>
    </form>  

    <!--Dialog Delete Course-->
    <div id="dialog-delete-course" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?=lang('hapus')?> <?=lang('pelatihan')?></h4>
        </div>
        <div class="modal-body" id="body-delete-course">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_pelatihan" id="hidden_del_pelatihan" />
            <input type="submit" class="btn btn-info" name="hapus_pelatihan" id="hapus_pelatihan" value="<?=lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>