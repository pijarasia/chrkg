<html>
<body>
    <!--<h2><?=lang('pengalaman_kerja')?></h2>-->
    <form name="form_datapengalaman" id="form_datapengalaman" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>        
        <div id="loadButtonWork">
            <a data-toggle="modal" href="#dialog-pengalaman" class="btn"><i class="icon-plus"></i> <?=lang('tambah')?></a>     
            <br /><br />
            <?php echo lang('ket_data_pengalaman');?>                       
        </div>
        <br />
        <?
            }
        ?>        
        <div id="dialog-pengalaman" class="modal custom hide fade in" style="display: none; ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('pengalaman_kerja')?></h4>
            </div>
            <div class="modal-body"> 
                <div class="form-vertical">
                    <div class="control-group">
                        <label class="control-label" for="perusahaan"><?=lang('perusahaan')?> </label>
                        <div class="controls">
                            <input type="text" name="perusahaan" id="perusahaan" class="input-xlarge" placeholder="<?=lang('perusahaan')?>"/>
                        </div>
                    </div>               
                    <div class="control-group">
                        <label class="control-label" for="alamat_perusahaan"><?=lang('alamat')?> </label>
                        <div class="controls">
                            <textarea name="alamat_perusahaan" id="alamat_perusahaan" placeholder="<?=lang('alamat')?>" rows="3" style="width: 300px;"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="kota_perusahaan"><?=lang('kota')?> </label>
                        <div class="controls">
                            <input type="text" name="kota_perusahaan" id="kota_perusahaan" class="input-xlarge" placeholder="<?=lang('kota')?>"/>
                        </div>
                    </div>         
                    <div class="control-group">
                        <label class="control-label" for="telp_perusahaan"><?=lang('no_telp')?> </label>
                        <div class="controls">
                            <input type="text" name="telp_perusahaan" id="telp_perusahaan" class="input-xlarge hp" placeholder="<?=lang('no_telp')?>" />
                        </div>
                    </div> 
                    <div class="control-group">
                        <label class="control-label" for="atasan"><?=lang('atasan')?> </label>
                        <div class="controls">
                            <input type="text" name="atasan" id="atasan" class="input-xlarge" placeholder="<?=lang('atasan')?>" />
                        </div>
                    </div>                                                                                                                                                                          
                    <div class="control-group">
                        <label class="control-label" for="posisi"><?=lang('posisi')?> </label>
                        <div class="controls">
                            <input type="text" name="posisi" id="posisi" class="input-xlarge" placeholder="<?=lang('posisi')?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="periode_kerja"><?=lang('periode')?> </label>
                        <div class="controls">
                            <select name="bulanKerjaAwal" id="bulanKerjaAwal" style="width: 110px;">
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
                            <select name="tahunKerjaAwal" id="tahunKerjaAwal" class="input-small">
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
                            s.d
                            <select name="bulanKerjaAkhir" id="bulanKerjaAkhir" style="width: 110px;">
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
                            <select name="tahunKerjaAkhir" id="tahunKerjaAkhir" class="input-small">
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
                            <label for="masih_bekerja">
                                <input type="checkbox" name="masih_bekerja" id="masih_bekerja"/>
                                <?=lang('masih_bekerja')?>
                            </label>                                                                                                                           
                        </div>
                    </div>              
                    <div class="control-group">
                        <label class="control-label" for="gaji_awal"><?=lang('gaji_awal')?> </label>
                        <div class="controls">
                            <input type="text" name="gaji_awal" id="gaji_awal" class="input-medium gaji" placeholder="<?=lang('gaji_awal')?>" value="<?php ?>" class="gaji"/>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label" for="gaji_akhir"><?=lang('gaji_akhir')?> </label>
                        <div class="controls">
                            <input type="text" name="gaji_akhir" id="gaji_akhir" class="input-medium gaji" placeholder="<?=lang('gaji_akhir')?>" value="<?php ?>" class="gaji"/>
                        </div>
                    </div>      
                    <div class="control-group">
                        <label class="control-label" for="deskripsi"><?=lang('deskripsi')?> </label>
                        <div class="controls">
                            <textarea name="deskripsi" id="deskripsi" placeholder="<?=lang('deskripsi')?>" rows="3" style="width: 300px;"></textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="alasan_keluar"><?=lang('alasan_keluar')?> </label>
                        <div class="controls">
                            <textarea name="alasan_keluar" id="alasan_keluar" placeholder="<?=lang('alasan_keluar')?>" rows="3" style="width: 300px;"></textarea>
                        </div>
                    </div>                                                                                                                                               
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDPengalaman" id="hiddenIDPengalaman" />
                <input type="submit" class="btn btn-info" name="simpan_pengalaman" id="simpan_pengalaman" value="<?=lang('simpan')?>" />
                <a class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        <div id="tblwork"></div>
     
    </form>   

    <!--Dialog Delete Work-->
    <div id="dialog-delete-work" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?=lang('hapus')?> <?=lang('pengalaman_kerja')?></h4>
        </div>
        <div class="modal-body" id="body-delete-work">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_pengalaman" id="hidden_del_pengalaman" />
            <input type="submit" class="btn btn-info" name="hapus_pengalaman" id="hapus_pengalaman" value="<?=lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
        </div>
    </div>  
    
    <div id="res"></div>                     
</body>
</html>