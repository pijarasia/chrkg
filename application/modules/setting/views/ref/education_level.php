<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span5">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_name" name='s_name' placeholder="<?=lang('jenjang')?>" class="input-medium"/>
                <input type="text" id="s_category" name='s_category' placeholder="<?=lang('kategori')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>
        </div>

        <div id="dialog-level" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?=lang('jenjang')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_jenjang" id="form_jenjang" method="get">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="kode"><?=lang('kode')?></label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-small" id="kode" name="kode" maxlength="1" placeholder="<?=lang('kode')?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="jenjang"><?=lang('jenjang')?></label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="jenjang" name="jenjang" placeholder="<?=lang('jenjang')?>"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="kategori"><?=lang('kategori')?></label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-medium" id="kategori" name="kategori" placeholder="<?=lang('kategori')?>"/>
                        </div>
                    </div>                                                  
                </div>   
            </form>                                                              
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDJenjang" id="hiddenIDJenjang" />
                <input type="submit" class="btn btn-info" name="simpan_jenjang" id="simpan_jenjang" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
            
        <div class="span7" style="text-align: right;">
            <?php
                if ($bool_add)
                {
            ?>
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-level"><i class="icon-plus"></i> <?=lang('tambah')?> <?=lang('jenjang')?></a>              
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
        <div id="level-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="level-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_id' data-sortkey='asc' style="width: 80px;"><?=lang('kode')?></th>
                <th data-key='_name' data-sortkey='asc'><?=lang('jenjang')?></th>
                <th data-key='_category' data-sortkey='asc'><?=lang('kategori')?></th>
                <?php
                    if ($bool_action)
                    {
                ?>
				<th data-key='control' style="width: 70px;"><?=lang('aksi')?></th>
                <?
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
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>