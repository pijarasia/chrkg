<!--<html>
<head>
    <title>Job</title>    
</head>
<body >
<div class='content-inner well' id="apply">    
<?php echo $pesan != "" ? "<div style='text-align:center;color:blue;border:1px solid #ddd;padding: 20px 10px;margin:20px;'>" . $pesan . "</div>" : ""; ?>
    <div id="tableApply">
        <input type="hidden" name="total" id="total" value="<?= $jmlpage; ?>"/>
    </div>     
    <input type="hidden" name="hal" id="hal"/>
    <input type="hidden" name="tampil" id="tampil" value="<?= $tampil; ?>"/>    
    <div class="pagination pagination-centered pagination-medium" id="pagination"></div>
    <div id="resapply"></div>
<!--Dialog Cancel Apply-->
<!--<div id="dialog-cancel-apply" class="modal custom hide fade in" style="display: none;">
    <div class="modal-body" style="padding-left: 15px;" id="body-cancel-apply">                
        <h5><?= lang('notif_batal') ?></h5>
    </div>                                    
    <div class="modal-footer">
        <input type="submit" class="btn btn-info btn-small" name="cancel_apply" id="cancel_apply" value="<?= lang('batal') ?> <?= lang('lamar') ?>" />
        <a href="#" class="btn btn-small" data-dismiss="modal"><?= lang('tidak') ?></a>
    </div>
</div>    
</div>
</body>
</html>-->
<div class="row">
  <div class="well">
    <div class="span3">
      <form class="form-inline" id="sform" method='post'>
        <div class="control-group">
          <div class="controls">
            <input type="text" id="s_posisi" name='s_posisi' placeholder="<?= lang('posisi') ?>/<?= lang('perusahaan') ?>" class="input-xlarge"/>
          </div>
        </div>
        <button class="btn" onclick="return Document.search(5)"><i class="icon-search"></i> <?= lang('cari') ?></button> 
        <div class="control-group">
          <div class="btn-group">
            <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
            <ul class="dropdown-menu" style="min-width: 90px;">
              <li><a onclick='Document.search(2);'>2</a></li>
              <li><a onclick='Document.search(5);'>5</a></li>
              <li><a onclick='Document.search(10);'>10</a></li>
              <li><a onclick='Document.search(20);'>20</a></li>
            </ul>
          </div>
        </div>
      </form>
    </div>  
    <div class="span9" style="text-align: right;">
      <div class="alert alert-error hide" id="alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="bulan-error"></div>
      </div>
      <div class="alert alert-success hide" id="alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div id="bulan-success"></div>
      </div>
      <input type="hidden" name="hiddenJobApplyID" id="hiddenJobApplyID"/>
      <table class="table table-bordered table-striped sortable">
        <thead>
          <tr>
            <th data-key='_jobTitle' data-sortkey='asc'><?= lang('posisi') ?> (<?= lang('perusahaan') ?>)</th>
            <th data-key='_jenisseleksi' data-sortkey='asc'>Jenis Seleksi</th>
            <th data-key='_status' data-sortkey='asc'>Status Seleksi</th>
            <th data-key='control' style="width: 190px;"><?= lang('aksi') ?></th>
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
      <!--Dialog Cancel Apply-->
      <div id="dialog-cancel-apply" class="modal custom hide fade in" style="display: none;">
        <div class="modal-body" style="padding-left: 15px;" id="body-cancel-apply">                
          <h5><?= lang('notif_batal') ?></h5>
        </div>                                    
        <div class="modal-footer">
          <input type="submit" class="btn btn-info btn-small" name="cancel_apply" id="cancel_apply" onclick="cancel_apply()" value="<?= lang('batal') ?> <?= lang('lamar') ?>" />
          <a href="#" class="btn btn-small" data-dismiss="modal"><?= lang('tidak') ?></a>
        </div>
      </div>  
    </div>
  </div>
</div>