<html>
<body>
    <!--<h2><?php echo lang('data_pendidikan')?></h2>-->
    <form name="form_datapendidikan" id="form_datapendidikan" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>
        <div id="loadButtonEducation">        
            <a data-toggle="modal" href="#dialog-pendidikan" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>                
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
                <h4><?php echo lang('non_pendidikan')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
					<div class="control-group">
						<label class="control-label" for="jenjang"><?php echo lang('jenjang')?> </label>
                        <div class="controls">
							<select name="jenjang" id="jenjang" class="input-medium">
								<option value=""><?php echo lang('pilih')?></option>
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
						<label class="control-label" for="institusi"><?php echo lang('institusi')?> </label>
						<div class="controls">
							<input type="text" name="institusi" id="institusi" class="input-xlarge" placeholder="<?php echo lang('institusi')?>" /> 
                        </div>
                    </div>    
                    <div class="control-group" id="jur">
						<label class="control-label" for="jurusan"><?php echo lang('jurusan')?> </label>
						<div class="controls">
							<input type="text" name="jurusan" id="jurusan" class="input-xlarge" placeholder="<?php echo lang('jurusan')?>" />
                        </div>
					</div>      					
                    <div class="control-group">
						<label class="control-label" for="kota"><?php echo lang('kota')?> </label>
                        <div class="controls">
							<input type="text" name="kota" id="kota" class="input-xlarge" placeholder="<?php echo lang('kota')?>" />
                        </div>
                    </div>  
                    <div class="control-group">
						<label class="control-label" for="negara"><?php echo lang('negara')?> </label>
                        <div class="controls">
							<select name="negara" id="negara" class="padd5AB">
								<option value=""><?php echo lang('pilih')?> <?php echo lang('negara')?></option>                                
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
						<label class="control-label" for="tahunMasuk"><?php echo lang('tahun_masuk')?> </label>
						<div class="controls">
							<select name="tahunMasuk" id="tahunMasuk" class="input-small">
								<option value=""><?php echo lang('pilih')?></option>
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
						<label class="control-label" for="tahunLulus"><?php echo lang('tahun_lulus')?> </label>
                        <div class="controls">
							<select name="tahunLulus" id="tahunLulus" class="input-small">
								<option value=""><?php echo lang('pilih')?></option>
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
						<label class="control-label" for="no_ijazah"><?php echo lang('no_ijazah')?> </label>
                        <div class="controls">
							<input type="text" name="no_ijazah" id="no_ijazah" class="input-large" placeholder="<?php echo lang('no_ijazah')?>"/>
                         </div>
					</div>   
					<div class="control-group">
						<label class="control-label" for="lulus"><?php echo lang('lulus')?> </label>
						<div class="controls">
							<input type="text" name="lulus" id="lulus" class="input-large" placeholder="<?php echo lang('lulus')?>" />
                        </div>
                    </div>                                     
                    <div class="control-group">
						<label class="control-label" for="gelar"><?php echo lang('gelar')?> </label>
						<div class="controls">
							<input type="text" name="gelar" id="gelar" class="input-small" placeholder="<?php echo lang('gelar')?>" />
                        </div>
                    </div>       
                    <div class="control-group">
						<label class="control-label" for="letak_gelar"><?php echo lang('letak_gelar')?> </label>
						<div class="controls">
							<label class="radio inline padd5AB">
								<input type="radio" name="letak_gelar" id="letakd" value="D" />
                                <?php echo lang('gelar_depan')?>
                            </label>
							<label class="radio inline padd5AB">
								<input type="radio" name="letak_gelar" id="letakb" value="B" />
								<?php echo lang('gelar_belakang')?>
                            </label>                                            
                        </div>
                    </div>
                    <div class="control-group">
						<label class="control-label" for="nilai"><?php echo lang('nilai_akhir')?>/<?php echo lang('ipk')?> </label>
                        <div class="controls">
							<input type="text" name="nilai" id="nilai" class="input-small" placeholder="<?php echo lang('nilai_akhir')?>" /> 
                            <div class="alert alert-success" style="width: 150px;margin-top: 10px;"><?php echo lang('pisah')?></div> 
                        </div>
                    </div>           
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDPendidikan" id="hiddenIDPendidikan" />
                <input type="submit" class="btn btn-info" name="simpan_pendidikan" id="simpan_pendidikan" value="<?php echo lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
            </div>
        </div>
        <div id="tbleducation"></div>
    </form>  

    <!--Dialog Delete Education-->
    <div id="dialog-delete-education" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('pendidikan')?></h4>
        </div>
        <div class="modal-body" id="body-delete-education">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_pendidikan" id="hidden_del_pendidikan" />
            <input type="submit" class="btn btn-info" name="hapus_pendidikan" id="hapus_pendidikan" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>