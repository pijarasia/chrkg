<div id="dialog-add" class="modal custom hide fade in custom" style="display: none;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4>Form <?php echo $subtitle;?></h4>
    </div>
    <div class="modal-body">
        <form id="fform" class='form-inline'>
            <div class="control-group">
                <label for="" class="control-label">Full Name</label>
                <div class="controls">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="text" name="full_name" id="full_name" placeholder="Full Name" class="input-xlarge" />
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Email</label>
                <div class="controls">
                    <input type="text" name="email" id="email" placeholder="Email" class="input-xlarge">
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Mobile Phone</label>
                <div class="controls">
                    <input type="text" name="mobile_phone" id="mobile_phone" placeholder="Phone" class="input-xlarge hp">
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Password</label>
                <div class="controls">
                <table>
                    <tr>
                        <td style="vertical-align: top;">
                             <input type="password" name="password" id="password" placeholder="Password" class="input-large "/>
                        </td>
                        <td  style="vertical-align: top;">
                            <div id="short" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                <div class="bar bar-danger" style="width: 10%;"></div>
                            </div>
                            <div id="weak" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                <div class="bar bar-danger" style="width: 33.3%;"></div>
                            </div>
                            <div id="good" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                <div class="bar bar-warning" style="width: 66.6%;"></div>
                            </div>
                            <div id="strong" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                <div class="bar bar-success" style="width: 80%;"></div>
                            </div>
                            <div id="very-strong" class="progress" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                <div class="bar bar-success" style="width: 99.9%;"></div>
                            </div>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
            <div class="control-group">
                <label for="" class='control-label'>Confirm Password</label>
                <div class="controls">
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="input-large">
                </div>
            </div>
            <?php // echo form_dropdown($company,$option['company']);?>
            <!-- Group Multi Select -->
        </form>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-info" name="save" id="save" value="Save" />
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
</div>