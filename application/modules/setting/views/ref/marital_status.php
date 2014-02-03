<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span5">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_name" name='s_name' placeholder="<?=lang('status')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>
        </div>

        <div id="dialog-status" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?=lang('status')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_status" id="form_status" method="get">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="kode"><?=lang('kode')?></label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-mini" id="kode" name="kode" maxlength="1" placeholder="<?=lang('kode')?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="status"><?=lang('status')?> (Bahasa)</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="status" name="status" placeholder="<?=lang('status')?> (Bahasa)"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="status"><?=lang('status')?> (English)</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="english" name="english" placeholder="<?=lang('status')?> (English)"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="urutan"><?=lang('urutan')?></label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="number" class="input-mini" id="urutan" name="urutan" placeholder="<?=lang('urutan')?>"/>
                        </div>
                    </div>                                                  
                </div>
            </form>                                                                             
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDStatus" id="hiddenIDStatus" />
                <input type="submit" class="btn btn-info" name="simpan_status" id="simpan_status" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
            
        <div class="span7" style="text-align: right;">
            <?php
                if ($bool_add)
                {
            ?>
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-status"><i class="icon-plus"></i> <?=lang('tambah')?> <?=lang('status')?></a>              
            <?php
                }
            ?>   
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
        <div id="status-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="status-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_id' data-sortkey='asc' style="width: 50px;"><?=lang('kode')?></th>
                <th data-key='_name' data-sortkey='asc'><?=lang('status')?> (Bahasa)</th>
                <th data-key='_category' data-sortkey='asc'><?=lang('status')?> (English)</th>
                <th data-key='_name' data-sortkey='asc'><?=lang('urutan')?></th>
                <?php
                    if ($bool_action)
                    {
                ?>
                <th data-key='control' style="width: 70px;"><?=lang('aksi')?></th>
                <?php
                    }
                ?>
            </tr>
        </thead>
        <tbody id="document-data">
            <tr>
                <td></td>            
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>