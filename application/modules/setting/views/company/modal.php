<div id="dialog" class="modal custom hide fade in" style="display: none;">
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
            <?php echo form_dropdown($ba,$option['business_area']);?>
            <div class="control-group">
                <label for="" class='control-label'>Phone1</label>
                <div class="controls">
                    <input type="text" name="phone1" id="phone1" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Phone2</label>
                <div class="controls">
                    <input type="text" name="phone2" id="phone2" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Fax</label>
                <div class="controls">
                    <input type="text" name="fax" id="fax" class="input-xlarge">
                </div>
            </div>
            <?php echo form_dropdown($state,$option['province']);?>
            <div class="control-group">
                <label for="" class="control-label">City</label>
                <div class="controls">
                    <input type="text" name="city" id="city" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Address</label>
                <div class="controls">
                    <textarea name="address" id="address" rows="10" class='input-xlarge'></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Postal Code</label>
                <div class="controls">
                    <input type="text" name="postal_code" id="postal_code" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Email</label>
                <div class="controls">
                    <input type="text" name="email" id="email" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class="control-label">Url</label>
                <div class="controls">
                    <input type="text" name="url" id="url" class="input-xlarge">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>