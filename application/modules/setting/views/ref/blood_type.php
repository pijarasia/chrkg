<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span3">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_name" name='s_name' placeholder="<?=lang('gol_darah')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>
        </div>
        
        <div id="dialog-goldarah" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?=lang('gol_darah')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_goldarah" id="form_goldarah" method="get">
                <div class="form-inline">
                    <label class="control-label" for="gol_darah"><?=lang('gol_darah')?> </label>: 
                    <input type="text" name="gol_darah" id="gol_darah" class="input-medium" placeholder="<?=lang('gol_darah')?>" maxlength="2"/> 
                </div>                                                                 
            </form>
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDGolDarah" id="hiddenIDGolDarah" />
                <input type="submit" class="btn btn-info" name="simpan_darah" id="simpan_darah" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        
        <div class="span9" style="text-align: right;">
            <?php
                if ($bool_add)
                {
            ?>
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-goldarah"><i class="icon-plus"></i> <?=lang('tambah')?> <?=lang('gol_darah')?></a>              
            <?php
                }
            ?>
            <div class="btn-group">
                <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
                <ul class="dropdown-menu" style="min-width: 90px;">
                    <li><a onclick='Document.search(5);'>5</a></li>
                    <li><a onclick='Document.search(10);'>10</a></li>
                </ul>
            </div>
        </div>
    </div>  
    <div class="alert alert-error hide" id="alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="blood-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="blood-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_name' data-sortkey='asc'><?=lang('gol_darah')?></th>
                <?php
                    if ($bool_action)
                    {
                ?>
                <th data-key='control' style="width: 100px;"><?=lang('aksi')?></th>
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
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>