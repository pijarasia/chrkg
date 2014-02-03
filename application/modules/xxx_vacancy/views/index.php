<div class='content-inner well'>
    <form class="form-search" id="form_vacancy" name="form_vacancy">
        <h4><?= lang('cari_pekerjaan');?></h4>
        <input type="text" class="input-large" placeholder="<?=lang('placeholder_pekerjaan')?>" id="cari" name="cari"/>
        <select name="kota" id="kota" class="input-large">
    	   <option value=""><?=lang('kota')?></option>
            <?
                foreach ($kota->result() as $row)
                {
                    if ($_POST["kota"] == $row->joborderCity)
                        $selected = "selected='selected'";
                    else
    					$selected = "";
                    echo '<option value="'.$row->joborderCity.'"'.$selected.'>'.$row->joborderCity.'</option>';;
                }
            ?>
        </select>
		<?php// echo form_dropdown('kota',$kota,'input-xlarge');?>


        <select name="tipe_kerja" id="tipe_kerja" class="input-large">
    	   <option value=""><?=lang('tipe_pekerjaan')?></option>
            <?
                foreach ($tipe_kerja->result() as $row)
                {
                    if ($_POST["tipe"] == $row->EmploymentTypeID)
                        $selected = "selected='selected'";
                    else
    					$selected = "";
                    echo '<option value="'.$row->EmploymentTypeID.'"'.$selected.'>'.$row->EmploymentType.'</option>';;
                }
            ?>
         </select>
        <select name="bisnis" id="bisnis" class="input-large">
    	   <option value=""><?=lang('area_bisnis')?></option>
            <?
                foreach ($bisnis->result() as $row)
                {
                    if ($_POST["business"] == $row->BusinessID)
                        $selected = "selected='selected'";
                    else
    					$selected = "";
                    echo '<option value="'.$row->BusinessID.'"'.$selected.'>'.$row->BusinessArea.'</option>';;
                }
            ?>
        </select>
        <!--input type="text" class="input-small" placeholder="<?=lang('kota')?>" id="kota" name="kota"/-->
        <a class="btn btn-small" id="searchJob"><?=lang('cari_pekerjaan')?></a>
    </form>
    <form class="form-search" id="form_vacancy_apply" name="form_vacancy_apply" action="../register" method="post">
    <div id="tableJob">
        <!--input type="hidden" name="total" id="total" value="<?= $jmlpage;?>"/-->
    </div>

	<div id="contact-link">
	<input type="submit" name="submit" value="Apply for these Jobs"></input>
	</div>

	</form>
    <input type="hidden" name="hal" id="hal"/>
    <input type="hidden" name="tampil" id="tampil" value="<?= $tampil;?>"/>
    <!--div class="pagination pagination-centered pagination-medium" id="pagination"></div-->
</div>