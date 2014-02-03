<div class='content-inner well'>
    <div class="row-fluid">
        <div class="span3">
        	<form class="form-inline" id="sform" method='post'>
                <div class="control-group">
                    <label for="" class="control-label">Name</label>
                    <div class="controls">
                        <input type="text" id="s_name" name='s_name' placeholder="Name" class="input-xlarge"/>
                    </div>
                </div>
                <?php echo form_dropdown($s_gr,$option['s_group']);?>
                <div class="control-group">
                    <label for="" class="control-label"></label>
                    <div class="controls">
                        <button class="btn" onclick="return Document.search(10)"><i class="icon-search"></i>Search</button>
                    </div>
                </div>
        	</form>
        </div>
        <div class="span9" style="text-align: right;">
            <a class="btn btn-small btn-primary" data-toggle="modal" data-target="#dialog-add" href="#dialog-add" id="add"><i class="icon-plus"></i> Add User</a>
            <div class="btn-group">
                <button class="btn btn-small btn-success dropdown-toggle" data-toggle="dropdown">Row/Page <span class="caret"></span></button>
                <ul class="dropdown-menu" style="min-width: 90px;">
                    <li><a onclick='Document.search(10);'>10</a></li>
                    <li><a onclick='Document.search(20);'>20</a></li>
                    <li><a onclick='Document.search(50);'>50</a></li>
                    <li><a onclick='Document.search(100);'>100</a></li>
                </ul>
            </div>
        </div>
    </div>

    <table class="table table-bordered table-striped sortable">
        <thead>
            <tr>
                <th data-key='_name' data-sortkey='asc'>Name</th>
                <th data-key='_email' data-sortkey='asc'>Email</th>
                <th data-key='control' data-sortkey='asc'>Groups</th>
                <th data-key='control' data-sortkey='asc'>Join On</th>
                <th data-key='control' style="width: 100px;">Password</th>
                <th data-key='control' style="width: 100px;">Level</th>
				<th data-key='control' style="width: 100px;">Action</th>
            </tr>
        </thead>
        <tbody id="document-data">
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="pagination pagination-centered pagination-xlarge" id="pagination"></div>
</div>

<?php echo modules::run('setting/user_modal'); ?>
<?php echo modules::run('setting/user_modal_add'); ?>
<?php echo modules::run('setting/user_modal_change_password'); ?>
<?php echo modules::run('setting/user_modal_change_level'); ?>

