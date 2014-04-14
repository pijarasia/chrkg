<html>
<body>
    <!--<h2><?php echo lang('data_keluarga')?></h2>-->
    <form name="form_datakeluarga" id="form_datakeluarga" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>
        <div id="loadButtonFamily">        
            <a data-toggle="modal" href="#dialog-keluarga" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>                
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
                <h4><?php echo lang('data_keluarga')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
					<div class="control-group">
						<label class="control-label" for="hubungan"><?php echo lang('hubungan')?> </label>
                        <div class="controls">
							<select name="hubungan" id="hubungan" class="input-medium">
								<option value=""><?php echo lang('pilih')?></option>
								<option value="ayah"><?php echo lang('ayah')?></option>
								<option value="ibu"><?php echo lang('ibu')?></option>
								<option value="saudara"><?php echo lang('saudara')?></option>
								<option value="suami"><?php echo lang('suami')?></option>
								<option value="istri"><?php echo lang('istri')?></option>
								<option value="anak"><?php echo lang('anak')?></option>                                
                            </select>  
                        </div>
					</div>
					<div class="control-group">
						<label class="control-label" for="namaKeluarga"><?php echo lang('nama_lengkap')?> </label>
						<div class="controls">
							<input type="text" name="namaKeluarga" id="namaKeluarga" class="input-xlarge" placeholder="<?php echo lang('nama_lengkap')?>"/> 
                        </div>
                    </div>    
                    <div class="control-group">
						<label class="control-label" for="jk"><?php echo lang('jk')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="jk" id="jkl" value="L"/>
                                <?php echo lang('pria')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="jk" id="jkp" value="P"/>
                                <?php echo lang('wanita')?>
                            </label>
                        </div>
					</div>             
                   <div class="control-group">
                        <label class="control-label" for="tmpt_lahir"><?php echo lang('tmpt_lahir')?> </label>
                        <div class="controls">
                            <input type="text" name="tmptlahir" id="tmptlahir" placeholder="<?php echo lang('tmpt_lahir')?>" class="input-large padd5AB" />
                        </div>
                    </div>                      
                    <div class="control-group">
                        <label class="control-label" for="tgl_lahir"><?php echo lang('tgl_lahir')?> </label>
                        <div class="controls">
                            <select name="tanggal" id="tanggal" style="width: 100px;">
                                <option value=""><?php echo lang('tanggal')?></option>
                                <?
                                    $tgl = 1; 
                                    for($tgl == 1; $tgl <= 31; $tgl++)
                                    {
                                        echo '<option value="'.$tgl.'">'.$tgl.'</option>';
                                    }
                                ?>    
                            </select>                 
                            <select name="bulan" id="bulan" style="width: 110px;">
                                <option value=""><?php echo lang('bulan')?></option>
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
                                <option value=""><?php echo lang('tahun')?></option>
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
                        <label class="control-label" for="pendidikan"><?php echo lang('pendidikan')?> </label>
                        <div class="controls">
							<select name="pendidikan" id="pendidikan" class="input-medium">
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
						<label class="control-label" for="pekerjaan"><?php echo lang('pekerjaan')?> </label>
						<div class="controls">
							<input type="text" name="pekerjaan" id="pekerjaan" class="input-xlarge" placeholder="<?php echo lang('pekerjaan')?>"/>
                        </div>
                    </div>                                     
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDKeluarga" id="hiddenIDKeluarga" />
                <input type="submit" class="btn btn-info" name="simpan_keluarga" id="simpan_keluarga" value="<?php echo lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?php echo lang ('batal')?></a>
            </div>
        </div>
        <div id="tblfamily"></div>
    </form>  

    <!--Dialog Delete Family-->
    <div id="dialog-delete-family" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('keluarga')?></h4>
        </div>
        <div class="modal-body" id="body-delete-family">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_keluarga" id="hidden_del_keluarga" />
            <input type="submit" class="btn btn-info" name="hapus_keluarga" id="hapus_keluarga" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>          
</body>
</html>