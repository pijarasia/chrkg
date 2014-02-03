<div class="span2"></div>
<div class="wrapper span8">
    <div class="logo" style="margin: 10px 0 0 0;"></div>
    <div style="padding: 0 15px 15px 15px;"></div>
    <div class="row">
        <div class="span8 pagination-centered">
            <div>
              <div class="modal-header">
                <h3>LOGIN AS</h3>
              </div>
              <div class="modal-body">
                <?php
                  foreach ($groups as $rows) {
                      $c_id = ! empty($rows['refid']) ? $company[$rows['refid']] : 'Gramedia Group';
                      echo "<button class='btn btn-large btn-block btn-primary' type='button' onclick=\"login_as('{$rows['ulid']}','{$rows['id']}','{$rows['name']}','{$rows['refid']}')\">{$rows['description']} || {$c_id}</button>";
                  }
                ?>
              </div>
              <div class="modal-footer">
              </div>
            </div>
        </div>
    </div>
</div>