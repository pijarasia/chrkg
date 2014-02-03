<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span5">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_code" name='s_code' placeholder="<?= $language == "english"?lang('bahasa')." ".lang('kode'):lang('kode')." ".lang('bahasa')?>" class="input-medium"/>
                <input type="text" id="s_name" name='s_name' placeholder="<?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>        
        </div>
        
        <div id="dialog-language" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_bahasa" id="form_bahasa" method="get">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="kode">
                        <?php
                            if ($language == "english")
                                echo lang('bahasa')." ".lang('kode');
                            else
                                echo lang('kode')." ".lang('bahasa');
                        ?>
                        </label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-small" id="kode" name="kode" maxlength="2" placeholder="<?= $language == "english"?lang('agama')." ".lang('kode'):lang('kode')." ".lang('agama')?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="english"><?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?> (English)</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="english" name="english" placeholder="<?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?> (English)"/>
                        </div>
                    </div>                               
                    <div class="control-group">
                        <label class="control-label" for="kemampuan"><?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?> (Bahasa)</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="kemampuan" name="kemampuan" placeholder="<?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?> (Bahasa)"/>
                        </div>
                    </div>                                                    
                </div>
            </form>                                                                 
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDBahasa" id="hiddenIDBahasa" />
                <input type="submit" class="btn btn-info" name="simpan_bahasa" id="simpan_bahasa" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
                    
        <div class="span7" style="text-align: right;">
                <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-language"><i class="icon-plus"></i> <?=lang('tambah')?> <?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?></a>              
                <div class="btn-group">
                    <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
                    <ul class="dropdown-menu" style="min-width: 90px;">
                        <li><a onclick='Document.search(10);'>10</a></li>
                        <li><a onclick='Document.search(20);'>20</a></li>
                    </ul>
                </div>
        </div>
    </div>  
    <div class="alert alert-error hide" id="alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="language-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="language-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_id' data-sortkey='asc' style="width: 120px;">
                    <?php
                        if ($language == "english")
                            echo lang('bahasa')." ".lang('kode');
                        else
                            echo lang('kode')." ".lang('bahasa');
                    ?>
                </th>
                <th data-key='_name' data-sortkey='asc'><?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?> (Bahasa)</th>
                <th data-key='_name' data-sortkey='asc'><?= $language == "english"?lang('bahasa')." ".lang('kemampuan'):lang('kemampuan')." ".lang('bahasa')?> (English)</th>
				<th data-key='control' style="width: 70px;"><?=lang('aksi')?></th>
            </tr>
        </thead>
        <tbody id="document-data">
            <tr>
                <td></td>            
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>