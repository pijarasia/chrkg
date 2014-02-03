<!-- Modal -->
<div id="deleteModal" class="modal hide fade custom" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Note</h3>
  </div>
  <div class="modal-body">
    <form action="" method="POST" class="form-inline" id='fform'>
      <p>Delete Job Apply</p>
      <div class="control-group">
        <div class="controls">
          <input type="hidden" name="process_apply_id" id="process_apply_id" value="" />
          <input type="hidden" name="process_last_step" id="process_last_step" value=""/>
          <input type="hidden" name="process_next_step" id="process_next_step" value=""/>
          <input type="hidden" name="process_job_id" id="process_job_id" value=""/>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="save">Save changes</button>
  </div>
</div>