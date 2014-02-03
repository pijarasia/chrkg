<!-- Modal -->
<div id="prevModal" class="modal hide fade custom" tabindex="-1" role="dialog" aria-labelledby="prevModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Process <span class='label' id="process_step_name"></span></h3>
  </div>
  <div class="modal-body">
    <form action="" method="POST" class="form-inline" id='fform'>
      <div class="control-group">
        <label for="" class="control-label">Action</label>
        <div class="controls">
          <select name='action' id='action' class="input-xlarge">
            <option value=''>Please Select .... </option>
            <option value='email'>Send Email</option>
            <option value='process'>Process Candidate </option>
          </select>
        </div>
      </div>
      <?php echo form_dropdown($email,$option['email_template']);?>
      <div class="control-group">
        <label for="" class="control-label">Subject Email</label>
        <div class="controls">
          <input type="text" name="process_subject" id="process_subject" class="input-xlarge" />
        </div>
      </div>
      <div class="control-group">
        <label for="" class="control-label">Body</label>
        <div class='controls'>
          <?php echo form_wysiwyg('process_body');?>
          <div id="process_body" class='editor' contenteditable="true"></div>
        </div>
      </div>
      <div class="control-group">
        <label for="" class="control-label">Comment</label>
        <div class="controls">
          <textarea name="process_comment" id="process_comment" cols="30" rows="10" class="input-xlarge"></textarea>
        </div>
      </div>
      <div class="control-group">
        <label for="" class="control-label">Rate</label>
        <div class="controls">
          <div id="star-rate" class="star-rate" data-score="" data-apply="" data-process-apply=""></div>
        </div>
      </div>
      <div class="control-group">
        <label for="" class="control-label">Test Date</label>
        <div class="controls">
          <input type="hidden" name="process_apply_id" id="process_apply_id" value="" />
          <input type="hidden" name="process_last_step" id="process_last_step" value=""/>
          <input type="hidden" name="process_job_id" id="process_job_id" value=""/>
          <select name='from_date' id='from_date' style='width: 100px;'>
            <option value=''>Date</option>
            <?php echo option_date();?>
          </select>
          <select name='from_month' id='from_month' style='width: 110px;'>
              <option value=''>Month</option>
              <?php echo option_month();?>
          </select>
          <select name='from_year' id='from_year' class='input-small'>
              <option value=''>Year</option>
              <?php echo option_year('',5);?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label for="" class="control-label">Test Time</label>
        <div class="controls">
          <select name='from_hour' id='from_hour' style='width: 100px;'>
            <option value=''>Hour</option>
            <?php echo option_hour();?>
          </select>
          <select name='from_minute' id='from_minute' style='width: 110px;'>
              <option value=''>Minute</option>
              <?php echo option_minute();?>
          </select>
        </div>
      </div>
      <div class="control-group">
        <label for="" class="control-label">Test Place</label>
        <div class="controls">
          <textarea name="process_place" id="process_place" cols="30" rows="10" class="input-xlarge"></textarea>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="save">Save</button>
  </div>
</div>