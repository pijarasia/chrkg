<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span5">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_name" name='s_name' placeholder="<?=lang('status_proses')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>
        </div>

        <div id="dialog-status" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?=lang('status_proses')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_status" id="form_status" method="get">
                <div class="form-inline">
                    <label class="control-label" for="status"><?=lang('status_proses')?> </label>: 
                    <input type="text" name="status" id="status" class="input-xlarge" placeholder="<?=lang('status_proses')?>"/> 
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
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-status"><i class="icon-plus"></i> <?=lang('tambah')?> <?=lang('status_proses')?></a>              
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
                <th data-key='_name' data-sortkey='asc'><?=lang('status_proses')?></th>
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
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>