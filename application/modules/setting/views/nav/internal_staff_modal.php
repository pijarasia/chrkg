<div id="dialog" class="modal custom hide fade in" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form</h4>
    </div>
    <div class="modal-body">
        <form id="fform" class='form-horizontal'>
            <div class="control-group">
                <label for="" class="control-label">Vertical</label>
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="text" name="name" id="name" class="input-xlarge" />
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Business Unit</label>
                <div class="controls">
                    <input type="text" name="business_unit" id="business_unit" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Department</label>
                <div class="controls">
                    <input type="text" name="department" id="department" class="input-xlarge">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>