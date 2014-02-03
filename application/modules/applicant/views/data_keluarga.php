<html>
<body>
    <!--<h2><?=lang('data_keluarga')?></h2>-->
    <form name="form_datakeluarga" id="form_datakeluarga" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>
        <div id="loadButtonFamily">        
            <a data-toggle="modal" href="#dialog-keluarga" class="btn"><i class="icon-plus"></i> <?=lang('tambah')?></a>                
            <br /><br />
            <?php echo lang('ket_data_keluarga');?>
        </div>
        <br />
        <?
            }
        ?>
        <div id="dialog-keluarga" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('data_keluarga')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
					<div class="control-group">
						<label class="control-label" for="hubungan"><?=lang('hubungan')?> </label>
                        <div class="controls">
							<select name="hubungan" id="hubungan" class="input-medium">
								<option value=""><?=lang('pilih')?></option>
								<option value="ayah"><?=lang('ayah')?></option>
								<option value="ibu"><?=lang('ibu')?></option>
								<option value="saudara"><?=lang('saudara')?></option>
								<option value="suami"><?=lang('suami')?></option>
								<option value="istri"><?=lang('istri')?></option>
								<option value="anak"><?=lang('anak')?></option>                                
                            </select>  
                        </div>
					</div>
					<div class="control-group">
						<label class="control-label" for="namaKeluarga"><?=lang('nama_lengkap')?> </label>
						<div class="controls">
							<input type="text" name="namaKeluarga" id="namaKeluarga" class="input-xlarge" placeholder="<?=lang('nama_lengkap')?>"/> 
                        </div>
                    </div>    
                    <div class="control-group">
						<label class="control-label" for="jk"><?=lang('jk')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="jk" id="jkl" value="L"/>
                                <?=lang('pria')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="jk" id="jkp" value="P"/>
                                <?=lang('wanita')?>
                            </label>
                        </div>
					</div>             
                   <div class="control-group">
                        <label class="control-label" for="tmpt_lahir"><?=lang('tmpt_lahir')?> </label>
                        <div class="controls">
                            <input type="text" name="tmptlahir" id="tmptlahir" placeholder="<?=lang('tmpt_lahir')?>" class="input-large padd5AB" />
                        </div>
                    </div>                      
                    <div class="control-group">
                        <label class="control-label" for="tgl_lahir"><?=lang('tgl_lahir')?> </label>
                        <div class="controls">
                            <select name="tanggal" id="tanggal" style="width: 100px;">
                                <option value=""><?=lang('tanggal')?></option>
                                <?
                                    $tgl = 1; 
                                    for($tgl == 1; $tgl <= 31; $tgl++)
                                    {
                                        echo '<option value="'.$tgl.'">'.$tgl.'</option>';
                                    }
                                ?>    
                            </select>                 
                            <select name="bulan" id="bulan" style="width: 110px;">
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
                            <select name="tahun" id="tahun" class="input-small">
                                <option value=""><?=lang('tahun')?></option>
                                <?
                                    $tahun = date('Y'); 
                                    $tahun100 = date('Y')-100; //min 56 yrs old
                                    for($thn = $tahun; $thn >= $tahun100; $thn--)
                                    {
                                        echo '<option value="'.$thn.'">'.$thn.'</option>';
                                    }
                                ?>    
                            </select> 
                        </div>
                    </div>       
					<div class="control-group">
                        <label class="control-label" for="pendidikan"><?=lang('pendidikan')?> </label>
                        <div class="controls">
							<select name="pendidikan" id="pendidikan" class="input-medium">
								<option value=""><?=lang('pilih')?></option>
                                <? 
									foreach ($ref_pendidikan->result() as $row)
                                    {
                                        echo '<option value="'.$row->EducationLevelCode.'">'.$row->EducationLevelName.'</option>';;
                                    }
                                ?>                                                                     
                            </select>  
                        </div>
					</div>   
					<div class="control-group">
						<label class="control-label" for="pekerjaan"><?=lang('pekerjaan')?> </label>
						<div class="controls">
							<input type="text" name="pekerjaan" id="pekerjaan" class="input-xlarge" placeholder="<?=lang('pekerjaan')?>"/>
                        </div>
                    </div>                                     
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDKeluarga" id="hiddenIDKeluarga" />
                <input type="submit" class="btn btn-info" name="simpan_keluarga" id="simpan_keluarga" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang ('batal')?></a>
            </div>
        </div>
        <div id="tblfamily"></div>
    </form>  

    <!--Dialog Delete Family-->
    <div id="dialog-delete-family" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?=lang('hapus')?> <?=lang('keluarga')?></h4>
        </div>
        <div class="modal-body" id="body-delete-family">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_keluarga" id="hidden_del_keluarga" />
            <input type="submit" class="btn btn-info" name="hapus_keluarga" id="hapus_keluarga" value="<?=lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>