<html>
<body>
    <!--<h2><?=lang('data_pendidikan')?></h2>-->
    <form name="form_datapendidikan" id="form_datapendidikan" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>
        <div id="loadButtonEducation">        
            <a data-toggle="modal" href="#dialog-pendidikan" class="btn"><i class="icon-plus"></i> <?=lang('tambah')?></a>                
            <br /><br />
            <?php echo lang('ket_data_pendidikan');?>
        </div>
        <br />
        <?
            }
        ?>
        <div id="dialog-pendidikan" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('non_pendidikan')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
					<div class="control-group">
						<label class="control-label" for="jenjang"><?=lang('jenjang')?> </label>
                        <div class="controls">
							<select name="jenjang" id="jenjang" class="input-medium">
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
						<label class="control-label" for="institusi"><?=lang('institusi')?> </label>
						<div class="controls">
							<input type="text" name="institusi" id="institusi" class="input-xlarge" placeholder="<?=lang('institusi')?>" /> 
                        </div>
                    </div>    
                    <div class="control-group" id="jur">
						<label class="control-label" for="jurusan"><?=lang('jurusan')?> </label>
						<div class="controls">
							<input type="text" name="jurusan" id="jurusan" class="input-xlarge" placeholder="<?=lang('jurusan')?>" />
                        </div>
					</div>      					
                    <div class="control-group">
						<label class="control-label" for="kota"><?=lang('kota')?> </label>
                        <div class="controls">
							<input type="text" name="kota" id="kota" class="input-xlarge" placeholder="<?=lang('kota')?>" />
                        </div>
                    </div>  
                    <div class="control-group">
						<label class="control-label" for="negara"><?=lang('negara')?> </label>
                        <div class="controls">
							<select name="negara" id="negara" class="padd5AB">
								<option value=""><?=lang('pilih')?> <?=lang('negara')?></option>                                
                                <? 
									foreach ($negara->result() as $row)
                                    {
                                        echo '<option value="'.$row->CountryCode.'">'.ucwords(strtolower($row->CountryName)).'</option>';;
                                    }
                                ?>                                  	
							</select>
                        </div>
                    </div>  
                    <div class="control-group">
						<label class="control-label" for="tahunMasuk"><?=lang('tahun_masuk')?> </label>
						<div class="controls">
							<select name="tahunMasuk" id="tahunMasuk" class="input-small">
								<option value=""><?=lang('pilih')?></option>
                                <?
                                    $tahunAkhir = (date("Y")-15);
                                    for ($i = (date("Y")+1); $i--; $i > $tahunAkhir)
                                    {
                                        if ($i >= $tahunAkhir)
                                            echo '<option value="'.$i.'">'.$i.'</option>';;
                                    }
                                ?>                            
                            </select> 
                        </div>
                    </div>    
                    <div class="control-group">
						<label class="control-label" for="tahunLulus"><?=lang('tahun_lulus')?> </label>
                        <div class="controls">
							<select name="tahunLulus" id="tahunLulus" class="input-small">
								<option value=""><?=lang('pilih')?></option>
                                <? 
									$tahunAkhir = (date("Y")-15);
                                    for ($i = (date("Y")+1); $i--; $i > $tahunAkhir)
                                    {
                                        if ($i >= $tahunAkhir)
											echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                ?>
                            </select>    
                        </div>
                    </div>                    
					<div class="control-group">
						<label class="control-label" for="no_ijazah"><?=lang('no_ijazah')?> </label>
                        <div class="controls">
							<input type="text" name="no_ijazah" id="no_ijazah" class="input-large" placeholder="<?=lang('no_ijazah')?>"/>
                         </div>
					</div>   
					<div class="control-group">
						<label class="control-label" for="lulus"><?=lang('lulus')?> </label>
						<div class="controls">
							<input type="text" name="lulus" id="lulus" class="input-large" placeholder="<?=lang('lulus')?>" />
                        </div>
                    </div>                                     
                    <div class="control-group">
						<label class="control-label" for="gelar"><?=lang('gelar')?> </label>
						<div class="controls">
							<input type="text" name="gelar" id="gelar" class="input-small" placeholder="<?=lang('gelar')?>" />
                        </div>
                    </div>       
                    <div class="control-group">
						<label class="control-label" for="letak_gelar"><?=lang('letak_gelar')?> </label>
						<div class="controls">
							<label class="radio inline padd5AB">
								<input type="radio" name="letak_gelar" id="letakd" value="D" />
                                <?=lang('gelar_depan')?>
                            </label>
							<label class="radio inline padd5AB">
								<input type="radio" name="letak_gelar" id="letakb" value="B" />
								<?=lang('gelar_belakang')?>
                            </label>                                            
                        </div>
                    </div>
                    <div class="control-group">
						<label class="control-label" for="nilai"><?=lang('nilai_akhir')?>/<?=lang('ipk')?> </label>
                        <div class="controls">
							<input type="text" name="nilai" id="nilai" class="input-small" placeholder="<?=lang('nilai_akhir')?>" /> 
                            <div class="alert alert-success" style="width: 150px;margin-top: 10px;"><?=lang('pisah')?></div> 
                        </div>
                    </div>           
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDPendidikan" id="hiddenIDPendidikan" />
                <input type="submit" class="btn btn-info" name="simpan_pendidikan" id="simpan_pendidikan" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        <div id="tbleducation"></div>
    </form>  

    <!--Dialog Delete Education-->
    <div id="dialog-delete-education" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?=lang('hapus')?> <?=lang('pendidikan')?></h4>
        </div>
        <div class="modal-body" id="body-delete-education">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_pendidikan" id="hidden_del_pendidikan" />
            <input type="submit" class="btn btn-info" name="hapus_pendidikan" id="hapus_pendidikan" value="<?=lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>