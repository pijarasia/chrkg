<div id="dialog" class="modal custom hide fade in custom" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form <?php echo $subtitle;?></h4>
    </div>
    <div class="modal-body">
        <form id="fform" class='form-horizontal'>
            <div class="control-group">
                <label for="" class="control-label">Full Name</label>
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="text" name="full_name" id="full_name" placeholder="Full Name" class="input-xlarge" />
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Nomor Selular</label>
                <div class="controls">
                    <input type="text" name="mobile_phone" id="mobile_phone" placeholder="Mobile Phone" class="input-xlarge">
                </div>
            </div>
            <?php //echo form_dropdown($company,$option['company']);?>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>