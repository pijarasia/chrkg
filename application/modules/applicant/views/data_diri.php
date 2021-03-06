<html>
<body>
    <form name="form_datadiri" id="form_datadiri" method="get" class="form-vertical">
        <div class="alert alert-success hide" id="success_personal">
            Data berhasil dimasukan.
        </div>
        <div class="alert alert-error hide" id="error_personal">
            Data gagal dimasukan, silakan coba lagi.
        </div>
        <!--<h2><?php echo lang('data_diri')?></h2>-->
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="gaji"><?php echo lang('nama_lengkap')?> <?php echo  $bool_add==false?" : ".trim($aplName):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="nama" id="nama" placeholder="<?php echo lang('nama_lengkap')?>" class="input-xlarge padd5AB" value="<?php echo $aplName; ?>"/>
                    </div>
                    <?
                        }
                    ?>                    
                </div>                                       
            </div>
            <div class="span6">
                <div class="control-group">
                    <?
                        if (trim($aplSex)=="P")
                            $kl = "Wanita";
                        else if (trim($aplSex)=="L")
                            $kl = "Pria";
                        else
                            $kl = "";
                    ?>
                    <label class="control-label" for="jk"><?php echo lang('jk')?> <?php echo  $bool_add==false?" : ".$kl:""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <label class="radio inline padd5AB">
                            <input type="radio" name="jk" id="jkl" value="L" <?php echo $aplSex=="L"?"checked='checked'":""; ?>/>
                            <?php echo lang('pria')?>
                        </label>
                        <label class="radio inline padd5AB">
                            <input type="radio" name="jk" id="jkp" value="P" <?php echo $aplSex=="P"?"checked='checked'":""; ?>/>
                            <?php echo lang('wanita')?>
                        </label>
                    </div>
                    <?
                        }
                    ?>                    
                </div>                                    
            </div>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="tmpt_lahir"><?php echo lang('tmpt_lahir')?> <?php echo  $bool_add==false?" : ".trim($aplPlaceOfBirth):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="tmptlahir" id="tmptlahir" placeholder="<?php echo lang('tmpt_lahir')?>" class="input-large padd5AB" value="<?php echo $aplPlaceOfBirth; ?>"/>
                    </div>
                    <?
                        }
                    ?>                    
                </div> 
            </div>                                
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="tgl_lahir"><?php echo lang('tgl_lahir')?> <?php echo  $bool_add==false?" : ".date('d', strtotime($aplDateOfBirth))." ".date('M', strtotime($aplDateOfBirth))." ".date('Y', strtotime($aplDateOfBirth)):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <select name="tanggal" id="tanggal" style="width: 100px;">
                            <option value=""><?php echo lang('tanggal')?></option>
                            <?
                                $tgl = 1; 
                                for($tgl == 1; $tgl <= 31; $tgl++)
                                {
                                    if ($aplDateOfBirth != "")
                                        $date = date('d', strtotime($aplDateOfBirth));
                                    else 
                                        $date = "";
                                    if ($date == $tgl)
                                        $selected = "selected";
                                    else
                                        $selected = "";                                                            
                                    echo '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
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
                                        $bln = $row->MonthNameEN;
                                                                
                                    if ($aplDateOfBirth != "")
                                        $month = date('m', strtotime($aplDateOfBirth));
                                    else 
                                        $month = "";

                                    if ($month == $row->MonthID)
                                        $selected = "selected";
                                    else
                                        $selected = "";                                                            
                                                                
                                    echo '<option value="'.$row->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                }
                            ?>    
                        </select>
                        <select name="tahun" id="tahun" class="input-small">
                            <option value=""><?php echo lang('tahun')?></option>
                            <?
                                $tahun = date('Y'); 
                                $thn = date('Y')-17; //min 17 yrs old
                                $tahun56 = date('Y')-56; //min 56 yrs old
                                for($thn == date('Y'); $thn >= $tahun56; $thn--)
                                {
                                    if ($aplDateOfBirth != "")
                                        $year = date('Y', strtotime($aplDateOfBirth));
                                    else 
                                        $year = "";
                                                
                                    if ($year == $thn)
                                        $selected = "selected";
                                    else
                                        $selected = "";                                                                                                                    
                                                            
                                    echo '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                }
                            ?>    
                        </select> 
                    </div>
                    <?
                        }
                    ?>                                        
                </div>                                        
            </div>
        </div>  
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="no_identitas"><?php echo lang('no_ktp')?> <?php echo  $bool_add==false?" : ".trim($aplIdentityNumber):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="no_identitas" id="no_identitas" placeholder="<?php echo lang('no_ktp')?>" class="padd5AB" value="<?php echo $aplIdentityNumber; ?>"/>
                    </div>
                    <?
                        }
                    ?>                                        
                </div>                                    
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="identitas_berlaku"><?php echo lang('identitas_berlaku')?> <?php echo  $bool_add==false?" : ".date('d', strtotime($aplIdentityValid))." ".date('M', strtotime($aplIdentityValid))." ".date('Y', strtotime($aplIdentityValid)):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <select name="tanggalberlaku" id="tanggalberlaku" style="width: 100px;">
                            <option value=""><?php echo lang('tanggal')?></option>
                            <?
                                $tgl = 1; 
                                for($tgl == 1; $tgl <= 31; $tgl++)
                                {
                                    if ($aplIdentityValid != "")
                                        $date = date('d', strtotime($aplIdentityValid));
                                    else 
                                        $date = "";
                                    if ($date == $tgl)
                                        $selected = "selected";
                                    else
                                        $selected = "";                                                            
                                    echo '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                }
                            ?>    
                        </select>                 
                        <select name="bulanberlaku" id="bulanberlaku" style="width: 110px;">
                            <option value=""><?php echo lang('bulan')?></option>
                            <? 
                                foreach ($bulan->result() as $row)
                                {
                                    if ($language=="bahasa")
                                        $bln = $row->MonthNameID;
                                    else
                                        $bln = $row->MonthNameEN;
                                                                        
                                    if ($aplIdentityValid != "")
                                        $month = date('m', strtotime($aplIdentityValid));
                                    else 
                                        $month = "";                                                                        
                                                                        
                                    if ($month == $row->MonthID)
                                        $selected = "selected";
                                    else
                                        $selected = "";                                                            
                                                                        
                                    echo '<option value="'.$row->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                }
                            ?>      
                        </select>
                        <select name="tahunberlaku" id="tahunberlaku" class="input-small">
                            <option value=""><?php echo lang('tahun')?></option>
                            <?
                                $tahun = date('Y')+5; 
                                $tahun56 = date('Y')-56; //min 56 yrs old
                                for($thn = $tahun; $thn >= $tahun56; $thn--)
                                {
                                    if ($aplIdentityValid != "")
                                        $year = date('Y', strtotime($aplIdentityValid));
                                    else 
                                        $year = "";                                                            
                                                            
                                    if ($year == $thn)
                                        $selected = "selected";
                                    else
                                        $selected = "";                                                                                                                    
                                                                    
                                    echo '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                }
                            ?>    
                        </select>                                                 
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                        
            </div>                                   
        </div>                                   
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="statusMarital"><?php echo lang('status')?> <?php echo  $bool_add==false?" : ".trim($aplMaritalStatusName):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <select name="statusMarital" id="statusMarital" class="padd5AB">
                            <option value=""><?php echo lang('pilih')?> <?php echo lang('status')?></option>                                
                            <? 
                                foreach ($marital->result() as $row)
                                {
                                    if ($language=="bahasa")
                                        $status = $row->MaritalName;
                                    else
                                        $status = $row->MaritalEnglish;                                                        
                                                            
                                    if ($aplMaritalStatus == $row->MaritalCode)
                                        $selected = "selected='selected'";
                                    else
                                        $selected = "";
                                    echo '<option value="'.$row->MaritalCode.'"'.$selected.'>'.$status.'</option>';;
                                }
                            ?>                                
                        </select>       
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                       
            </div>                                 
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="agama"><?php echo lang('agama')?> <?php echo  $bool_add==false?" : ".trim($aplReligionName):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <select name="agama" id="agama" class="padd5AB">
                            <option value=""><?php echo lang('pilih')?> <?php echo lang('agama')?></option>                                
                            <? 
                                foreach ($agama->result() as $row)
                                {
                                    if ($aplReligion == $row->ReligionCode)
                                        $selected = "selected='selected'";
                                    else
                                        $selected = "";
                                    echo '<option value="'.$row->ReligionCode.'"'.$selected.'>'.$row->ReligionName.'</option>';;
                                }
                            ?>
                        </select> 
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                    
            </div>
        </div> 
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="email"><?php echo lang('email')?> <?php echo  $bool_add==false?" : ".trim($aplEmail):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="email" id="email" placeholder="<?php echo lang('email')?>" class="input-xlarge padd5AB" value="<?php echo $aplEmail; ?>"/>       
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                       
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="alternatif_email"><?php echo lang('email2')?> <?php echo  $bool_add==false?" : ".trim($aplAlternateEmail):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="alternatif_email" id="alternatif_email" placeholder="<?php echo lang('email2')?>" class="input-xlarge padd5AB" value="<?php echo $aplAlternateEmail; ?>"/>       
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                       
            </div>
        </div>   
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="nohp"><?php echo lang('no_hp')?> <?php echo  $bool_add==false?" : ".trim($aplCellular):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="nohp" id="nohp" placeholder="<?php echo lang('no_hp')?>" class="padd5AB hp" value="<?php echo $aplCellular; ?>"/> 
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                    
            </div>
            <div class="span6">
                <div class="control-group">
                    <label class="control-label" for="alternatif_nohp"><?php echo lang('no_hp2')?> <?php echo  $bool_add==false?" : ".trim($aplAlternateCellular):""; ?></label>                    
                    <?php
                        if ($bool_add)        
                        {
                    ?>  
                    <div class="controls">
                        <input type="text" name="alternatif_nohp" id="alternatif_nohp" placeholder="<?php echo lang('no_hp2')?>" class="padd5AB hp" value="<?php echo $aplAlternateCellular; ?>"/> 
                    </div>
                    <?
                        }
                    ?>                                                            
                </div>                                    
            </div>
        </div>
        <?php
            if ($bool_add)        
            {
        ?>  
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <input type="submit" class="btn btn-info" name="simpan_datadiri" id="simpan_datadiri" value="<?php echo lang('simpan')?>" />
                </div>                                    
            </div>
        </div>
        <?php
            }
        ?>  
    </form>      
</body>
</html>