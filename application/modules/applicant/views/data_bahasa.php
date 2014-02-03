<html>
<body>
    <!--<h2><?=lang('data_bahasa')?></h2>-->
    <form name="form_databahasa" id="form_databahasa" method="get" style="padding: 15px;">
        <br />
        <?php
            if ($bool_add)        
            {
        ?>
        <div id="loadButtonLanguage">
            <a data-toggle="modal" href="#dialog-bahasa" class="btn"><i class="icon-plus"></i> <?=lang('tambah')?></a>                
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
                <h4><?=lang('data_bahasa')?></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal" style="margin-left: -40px;">
					<div class="control-group">
						<label class="control-label" for="bahasa"><?=lang('bahasa')?> </label>
						<div class="controls">
							<input type="text" name="bahasa" id="bahasa" class="input-xlarge" placeholder="<?=lang('bahasa')?>"/> 
                        </div>
                    </div>    
                    <div class="control-group">
						<label class="control-label" for="writing"><?=lang('writing')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writingp" value="P"/>
                                <?=lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writingf" value="F"/>
                                <?=lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writingg" value="G"/>
                                <?=lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="writing" id="writinge" value="E"/>
                                <?=lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                    <div class="control-group">
						<label class="control-label" for="understanding"><?=lang('understanding')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandingp" value="P"/>
                                <?=lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandingf" value="F"/>
                                <?=lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandingg" value="G"/>
                                <?=lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="understanding" id="understandinge" value="E"/>
                                <?=lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                    <div class="control-group">
						<label class="control-label" for="speaking"><?=lang('speaking')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakingp" value="P"/>
                                <?=lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakingf" value="F"/>
                                <?=lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakingg" value="G"/>
                                <?=lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="speaking" id="speakinge" value="E"/>
                                <?=lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                    <div class="control-group">
						<label class="control-label" for="reading"><?=lang('reading')?> </label>
						<div class="controls">
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readingp" value="P"/>
                                <?=lang('kurang')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readingf" value="F"/>
                                <?=lang('cukup')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readingg" value="G"/>
                                <?=lang('baik')?>
                            </label>
                            <label class="radio inline padd5AB">
                                <input type="radio" name="reading" id="readinge" value="E"/>
                                <?=lang('sangat_baik')?>
                            </label>
                        </div>
					</div>             
                </div>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDBahasa" id="hiddenIDBahasa" />
                <input type="submit" class="btn btn-info" name="simpan_bahasa" id="simpan_bahasa" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang ('batal')?></a>
            </div>
        </div>
        <div id="tbllanguage"></div> 
    </form>  

    <!--Dialog Delete Language-->
    <div id="dialog-delete-language" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?=lang('hapus')?> <?=lang('bahasa')?></h4>
        </div>
        <div class="modal-body" id="body-delete-language">                
        </div>                                    
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_bahasa" id="hidden_del_bahasa" />
            <input type="submit" class="btn btn-info" name="hapus_bahasa" id="hapus_bahasa" value="<?=lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
        </div>
    </div>    
    
    <div id="res"></div>
</body>
</html>