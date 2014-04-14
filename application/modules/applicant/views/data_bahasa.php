<html>
<body>
    <!--<h2><?php echo lang('data_bahasa')?></h2>-->
    <form name="form_databahasa" id="form_databahasa" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>
        <div id="loadButtonLanguage">
            <a data-toggle="modal" href="#dialog-bahasa" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>                
            <br /><br />
            <?php echo lang('ket_data_bahasa');?>
        </div>
        <br />
        <?
            }
        ?>
        <div id="dialog-bahasa" class="modal custom hide fade in" style="display: none; ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?php echo lang('data_bahasa')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
					<div class="control-group">
						<label class="control-label" for="bahasa"><?php echo lang('bahasa')?> </label>
						<div class="controls">
							<input type="text" name="bahasa" id="bahasa" class="input-xlarge" placeholder="<?php echo lang('bahasa')?>"/> 
                        </div>
                    </div>    
                    <div class="control-group">
						<label class="control-label" for="writing"><?php echo lang('writing')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writingp" value="P"/>
                                <?php echo lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writingf" value="F"/>
                                <?php echo lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writingg" value="G"/>
                                <?php echo lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writinge" value="E"/>
                                <?php echo lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                    <div class="control-group">
						<label class="control-label" for="understanding"><?php echo lang('understanding')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandingp" value="P"/>
                                <?php echo lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandingf" value="F"/>
                                <?php echo lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandingg" value="G"/>
                                <?php echo lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandinge" value="E"/>
                                <?php echo lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                    <div class="control-group">
						<label class="control-label" for="speaking"><?php echo lang('speaking')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakingp" value="P"/>
                                <?php echo lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakingf" value="F"/>
                                <?php echo lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakingg" value="G"/>
                                <?php echo lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakinge" value="E"/>
                                <?php echo lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                    <div class="control-group">
						<label class="control-label" for="reading"><?php echo lang('reading')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readingp" value="P"/>
                                <?php echo lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readingf" value="F"/>
                                <?php echo lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readingg" value="G"/>
                                <?php echo lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readinge" value="E"/>
                                <?php echo lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDBahasa" id="hiddenIDBahasa" />
                <input type="submit" class="btn btn-info" name="simpan_bahasa" id="simpan_bahasa" value="<?php echo lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?php echo lang ('batal')?></a>
            </div>
        </div>
        <div id="tbllanguage"></div> 
    </form>  

    <!--Dialog Delete Language-->
    <div id="dialog-delete-language" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('bahasa')?></h4>
        </div>
        <div class="modal-body" id="body-delete-language">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_bahasa" id="hidden_del_bahasa" />
            <input type="submit" class="btn btn-info" name="hapus_bahasa" id="hapus_bahasa" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>
</body>
</html>