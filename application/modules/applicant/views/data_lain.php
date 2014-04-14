<html>
<body>
    <!--<h2><?php echo lang('form_lain')?></h2>-->
    <form name="form_datalain" id="form_datalain" method="get" style="padding: 15px;">
        <div class="alert alert-success hide" id="success_other">
            Data berhasil dimasukan.
        </div>
        <div class="alert alert-error hide" id="error_other">
            Data gagal dimasukan, silakan coba lagi.
        </div>
        <div class="control-group">
            <label class="control-label" for="gaji"><?php echo lang('gaji_harapan')?> <?php echo  $bool_add==false?" : ".trim($aplExpectedSalary):"-"; ?></label>
            <?php
                if ($bool_add)
                {
            ?>
            <div class="controls">
				<!-- Derry :: spy enak ngisinya-->
                <!--input type="text" name="gaji" id="gaji" value="<?php echo trim($aplExpectedSalary);?>"/-->
                <input type="number" step="500000" name="gaji" id="gaji" value="<?php echo trim($aplExpectedSalary);?>"/>
            </div>
            <?
                }

            ?>
        </div>
        <?php
            if ($bool_add)
            {
        ?>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <input type="hidden" name="hiddenIDLain" id="hiddenIDLain" />
                    <input type="submit" class="btn btn-info" name="simpan_lain" id="simpan_lain" value="<?php echo lang('simpan')?>" />
                </div>
            </div>
        </div>
        <?php
            }
        ?>
    </form>
    <div id="res"></div>
</body>
</html>