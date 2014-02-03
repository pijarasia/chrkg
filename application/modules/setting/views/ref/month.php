<div class='content-inner well' style="padding: 30px 20px;">
    <div class="row-fluid">
        <div class="span3">
        	<form class="form-inline" id="sform" method='post'>
                <input type="text" id="s_name" name='s_name' placeholder="<?=lang('bulan')?>" class="input-medium"/>
                <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i> <?=lang('cari')?></button> 
        	</form>        
        </div>

        <div id="dialog-bulan" class="modal custom hide fade in" style="display: none;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                                        
                <h4><?=lang('tambah')?> <?=lang('bulan')?></h4>
            </div>
            <div class="modal-body">
            <form name="form_bulan" id="form_bulan" method="get">
                <div class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="bulan"><?=lang('bulan')?> (Bahasa)</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="bulan" name="bulan" placeholder="<?=lang('bulan')?> (Bahasa)"/>
                        </div>
                    </div>        
                    <div class="control-group">
                        <label class="control-label" for="english"><?=lang('bulan')?> (English)</label>
                        <div class="controls" style="padding-top: 5px;">
                            <input type="text" class="input-xlarge" id="english" name="english" placeholder="<?=lang('bulan')?> (English)"/>
                        </div>
                    </div>                                               
                </div> 
            </form>                                                                
            </div>                                    
            <div class="modal-footer">
                <input type="hidden" name="hiddenIDBulan" id="hiddenIDBulan" />
                <input type="submit" class="btn btn-info" name="simpan_bulan" id="simpan_bulan" value="<?=lang('simpan')?>" />
                <a href="#" class="btn" data-dismiss="modal"><?=lang('batal')?></a>
            </div>
        </div>
                    
        <div class="span9" style="text-align: right;">
            <?php
                if ($bool_add)
                {
            ?>
            <a class="btn btn-small btn-primary" data-toggle="modal" href="#dialog-bulan"><i class="icon-plus"></i> <?=lang('tambah')?> <?=lang('bulan')?></a>              
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
        <div id="bulan-error"></div>
    </div>
    <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="bulan-success"></div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_name' data-sortkey='asc'><?=lang('bulan')?> (Bahasa)</th>
                <th data-key='_english' data-sortkey='asc'><?=lang('bulan')?> (English)</th>
                <?php
                    if ($bool_action)
                    {
                ?>
				<th data-key='_status' style="width: 100px;"><?=lang('aksi')?></th>
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
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
</div>