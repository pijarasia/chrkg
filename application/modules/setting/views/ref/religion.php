<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span5">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_code" name='s_code' placeholder="<?= $language == "english"?lang('agama')." ".lang('kode'):lang('kode')." ".lang('agama')?>" class="input-small"/>
                <input type="text" id="s_name" name='s_name' placeholder="<?=lang('agama')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>
        </div>

        <div id="dialog-religion" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?=lang('agama')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_agama" id="form_agama" method="get">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="kode">
                        <?php
                            if ($language == "english")
                                echo lang('agama')." ".lang('kode');
                            else
                                echo lang('kode')." ".lang('agama');
                        ?>
                        </label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-small" id="kode" name="kode" maxlength="1" placeholder="<?= $language == "english"?lang('agama')." ".lang('kode'):lang('kode')." ".lang('agama')?>"/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="agama"><?=lang('agama')?></label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="agama" name="agama" placeholder="<?=lang('agama')?>"/>
                        </div>
                    </div>                            
                </div> 
            </form>                                                                
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDAgama" id="hiddenIDAgama" />
                <input type="submit" class="btn btn-info" name="simpan_agama" id="simpan_agama" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
        <div class="span7" style="text-align: right;">
            <?php
                if ($bool_add)
                {
            ?>
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-religion"><i class="icon-plus"></i> <?=lang('tambah')?> <?=lang('agama')?></a>              
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
        <div id="religion-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="religion-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_id' data-sortkey='asc' style="width: 100px;">
                    <?php
                        if ($language == "english")
                            echo lang('agama')." ".lang('kode');
                        else
                            echo lang('kode')." ".lang('agama');
                    ?>
                </th>
                <th data-key='_name' data-sortkey='asc'><?=lang('agama')?></th>
                <?php
                    if ($bool_action)
                    {
                ?>
				<th data-key='control' style="width: 100px;"><?=lang('aksi')?></th>
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
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>