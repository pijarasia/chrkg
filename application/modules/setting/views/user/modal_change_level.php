<div id="dialog-level" class="modal custom hide fade in custom" style="width:730px;display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form <?php echo $subtitle;?></h4>
    </div>
    <div class="modal-body">
        <form id="fform" class='form-inline' method="post" enctype="multipart/form-data">
            <div class="control-group">
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                </div>
            </div>
            <div id="level-form">
                <div class="control-group">
                    <label for="" class="control-label">Level/Company</label>
                    <div class="controls">
                        <input type="hidden" name="hidden_ug_id" id="hidden_ug_id"  value="" />
                        <select name='level[]' class="input-large">
                            <?php
                                foreach ($option['level'] as $key => $value) {
                                    echo "<option value='{$key}'>{$value}</option>";
                                }

                            ?>
                        </select>
                        <select name='costid[]' class="input-large">
                            <?php
                                foreach ($option['cost'] as $key => $value) {
                                    echo "<option value='{$key}'>{$value}</option>";
                                }

                            ?>
                        </select>
                        <select name='refid[]' class="input-large">
                            <?php
                                foreach ($option['company'] as $key => $value) {
                                    echo "<option value='{$key}'>{$value}</option>";
                                }

                            ?>
                        </select>
                        <a class="btn btn-success" data-action="add">Add</a>
                        <a class="btn btn-inverse" data-action="remove">Remove</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>
