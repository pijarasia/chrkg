<div id="dialog" class="modal custom hide fade in custom" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form <?php echo $subtitle;?></h4>
    </div>
    <div class="modal-body">
        <form id="fform" class='form-horizontal'>
            <div class="control-group">
                <label for="" class="control-label">Name</label>
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="text" name="name" id="name" class="input-xlarge" />
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Description</label>
                <div class="controls">
                    <textarea name="description" id="description" rows="10" class='input-xlarge'></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Status</label>
                <div class="controls">
                    <select name="status" id="status" class="input-xlarge">
                        <option value="">Select Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>