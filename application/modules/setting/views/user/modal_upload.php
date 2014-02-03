<div id="dialog-upload" class="modal custom hide fade in" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form <?php echo $subtitle;?></h4>
    </div>
    <div class="modal-body">
        <form id="fform-upload" class='form-horizontal' method="post" enctype="multipart/form-data" id="form-upload">
            <div class="control-group">
                <label for="" class="control-label">Logo</label>
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input name="image" id="image" type="file" />
                </div>
            </div>
            <div class="control-group">
                <div id="output"></div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save-upload" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>