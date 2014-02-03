<div id="dialog" class="modal custom hide fade in" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form <?php echo $subtitle;?></h4>
    </div>
    <div class="modal-body">
        <form id="fform" class='form-horizontal'>
            <div class="control-group">
                <label for="" class="control-label">ID</label>
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="text" name="group_id" id="group_id" class="input-xlarge" />
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Name</label>
                <div class="controls">
                    <input type="text" name="name" id="name" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Ref Name</label>
                <div class="controls">
                    <input type="text" name="refname" id="refname" class="input-xlarge">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>