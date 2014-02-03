<div class="container">
		<div class="logo-nav">
			<a href="<?php echo base_url();?>" class="brand">Dashboard Admin</a>
		</div>
		<div class="menu-nav">
			<div class="nav-collapse">
				<ul id="main-nav" class="nav pull-right">
					<?php if ($this->auth->_allowed('Menu.Dashboard')): ?>
					<li class="dropdown my-nav" id="nav-my-taskbar">
							<a href="<?php echo base_url();?>dashboard/taskbar">
								<i class="icon-dashboard"></i>
								<span>My Taskboard</span>
							</a>
						</li>
					<?php endif;?>
					<?php if ($this->auth->_allowed('Menu.Dashboard')): ?>
					<li class="dropdown my-nav" id="nav-dashboard">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-th"></i>
							<span>Dashboards</span>
							<b class="caret"></b>
						</a>
							<ul class="dropdown-menu">
							<?php if ($this->auth->_allowed('Menu.Joborder.Job.Dashboard')):?>
							<li><a href="<?php echo base_url();?>dashboard/job">Job Dashboard</a></li>
							<?php endif;?>
								<?php if ($this->auth->_allowed('Menu.Joborder.Job.Dashboard')):?>
								<li><a href="<?php echo base_url();?>dashboard/candidate">Candidate Dashboard</a></li>
								<?php endif;?>
								<?php if ($this->auth->_allowed('Menu.Joborder.Job.Dashboard')):?>
								<li><a href="<?php echo base_url();?>dashboard/scorecard">Scorecard</a></li>
								<?php endif;?>
							</ul>
						</li>
					<?php endif;?>
					<?php if ($this->auth->_allowed('Menu.Joborder')): ?>
						<li class="dropdown my-nav" id="nav-job">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-copy"></i>
							<span>Jobs</span>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<?php if ($this->auth->_allowed('Menu.Joborder.Job')):?>
							<li><a href="<?php echo base_url();?>joborder/search">Search</a></li>
							<?php endif;?>
							<?php if ($this->auth->_allowed('Menu.Joborder.Job.Dashboard')):?>
							<li><a href="<?php echo base_url();?>joborder/dashboard">Create New</a></li>
							<?php endif;?>
						</ul>
						</li>
					<?php endif;?>
					<?php if ($this->auth->_allowed('Menu.Candidates')): ?>
					<li class="dropdown my-nav" id="nav-candidates">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-tags"></i>
							<span>Candidates</span>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
					        <?php if ($this->auth->_allowed('Menu.Candidates.Candidates')): ?>
							<li><a href="<?php echo base_url();?>candidates/search">Search</a></li>
					        <?php endif; ?>
					        <?php if ($this->auth->_allowed('Menu.Candidates.Candidates')): ?>
							<li><a href="<?php echo base_url();?>candidates">Create New</a></li>
					        <?php endif; ?>
					        <?php if ($this->auth->_allowed('Menu.Candidates.Candidates')): ?>
							<li><a href="<?php echo base_url();?>candidates">Import Candidates</a></li>
					        <?php endif; ?>
					        <?php if ($this->auth->_allowed('Menu.Candidates.Candidates')): ?>
							<li><a href="<?php echo base_url();?>candidates">Candidates</a></li>
					        <?php endif; ?>
					        <?php
		                //Gta 10 Okt cuma bisa diakses o/ internal & external
		                if ($this->session->userdata('xyz') == 10 || $this->session->userdata('xyz') == 11){
		                      //Gta 10 Okt belum lolos cv masuk biodata 1
		                      $cek_step = $this->vacancy->cek_process_apply_stepcv($this->session->userdata('email'))->num_rows();
		                      if ($cek_step == 0){
		                          if ($this->auth->_allowed('Menu.Candidates.CV1')) {
																echo "<li><a href='".base_url()."applicant/form'>Biodata</a></li>";
		                          }
		                      } else {
			                        if ($this->auth->_allowed('Menu.Candidates.CV2'))
			                        {
																echo "<li><a href='".base_url()."applicant/data'>Biodata</a></li>";
		                          }
		                      }
		                }
		              ?>
					        <?php if ($this->auth->_allowed('Menu.Candidates.Vacancy')): ?>
									<li><a href="<?php echo base_url();?>vacancy">Lowongan Kerja</a></li>
					        <?php endif;?>
					        <?php
		                //Gta 10 Okt cuma bisa diakses o/ internal & external
		                if ($this->session->userdata('xyz') == 10 || $this->session->userdata('xyz') == 11){
		                    if ($this->auth->_allowed('Menu.Candidates.ListJob')) {
													echo "<li><a href='".base_url()."jobapply'>Daftar Lamaran</a></li>";
		                    }
		                }
		            	?>
						</ul>
					</li>
					<?php endif; ?>

					<?php if($this->auth->_allowed('Menu.Calendar')): ?>
					<li class="dropdown my-nav" id="nav-calendar">
						<a href="<?php echo base_url();?>dashboard/calendar">
							<i class="icon-calendar"></i>
							<span>Calendar</span>
						</a>
					</li>
					<?php endif;?>
					<?php if($this->auth->_allowed('Menu.Reports')): ?>
						<li class="dropdown my-nav" id="nav-reports">
								<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
									<i class="icon-book"></i>
									<span>Reports</span>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url();?>reports/candidates">Total candidates received</a></li>
								</ul>
							</li>
					<?php endif;?>
					<?php if($this->auth->_allowed('Menu.Settings')): ?>
					<li class="dropdown my-nav" id="nav-settings">
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-th-large"></i>
							<span>Settings</span>
							<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<?php if($this->auth->_allowed('Menu.Settings.PartnersOption')):?>
							<li><a href="<?php echo base_url();?>setting/partner_option">Partner & Options</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.Vertical')):?>
							<li><a href="<?php echo base_url();?>setting/verticals">Vertical</a></li>
							<?php endif;?>
			        <?php if($this->auth->_allowed('Menu.Settings.CostCenters')):?>
							<li><a href="<?php echo base_url();?>setting/cost_centers">Cost Centers</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.Location')):?>
							<li><a href="<?php echo base_url();?>setting/locations">Location</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.EmailTemplates')):?>
							<li><a href="<?php echo base_url();?>ktemplate/temail">Email Templates</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.CandidatesSources')):?>
							<li><a href="<?php echo base_url();?>setting/candidate_sources">Candidates Sources</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.InternalStaff')):?>
							<li><a href="<?php echo base_url();?>setting/internal_staff">Internal Staff</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.AgencyStaff')):?>
							<li><a href="<?php echo base_url();?>setting/agency_staff">Agency Staff</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.CandidateHomePages')):?>
							<li><a href="<?php echo base_url();?>setting/candidate_home">Candidate Home Pages</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.ScorecardInternal')):?>
							<li><a href="<?php echo base_url();?>ktemplate/temail">Scorecard(Internal Staff)</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Settings.ScorecardExternal')):?>
							<li><a href="<?php echo base_url();?>ktemplate/temail">Scorecard(Candidate Sources)</a></li>
							<?php endif;?>
							<?php if($this->auth->_allowed('Menu.Usermanagement')):?>
							<li class="dropdown-submenu">
		            <a href="">User Management</a>
		            <ul class="dropdown-menu">
		            	<?php if($this->auth->_allowed('Menu.Usermanagement.User')):?>
		                <li><a href="<?php echo base_url();?>setting/user">User</a></li>
		            	<?php endif;?>
			            <?php if($this->auth->_allowed('Menu.Usermanagement.Group')):?>
									<li><a href="<?php echo base_url();?>setting/group">Group</a></li>
									<?php endif;?>
			            <?php if($this->auth->_allowed('Menu.Usermanagement.Permission')):?>
									<li><a href="<?php echo base_url();?>setting/permission">Permission</a></li>
									<?php endif;?>
		            </ul>
		        	</li>
		        	<?php endif;?>
		        	<?php if($this->auth->_allowed('Menu.References')):?>
		        	<li class="dropdown-submenu">
		          <a href="">Reference</a>
			          <ul class="dropdown-menu">
			          	<?php if($this->auth->_allowed('Menu.Usermanagement.Company')):?>
									<li><a href="<?php echo base_url();?>setting/company">Company</a></li>
									<?php endif;?>
									<?php if($this->auth->_allowed('Menu.References.BloodType')):?>
		              <li><a href="<?php echo base_url();?>setting/blood_type">Blood Type</a></li>
		            	<?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.Month')):?>
		              <li><a href="<?php echo base_url();?>setting/month">Month</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.Religion')):?>
		              <li><a href="<?php echo base_url();?>setting/religion">Religion</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.Country')):?>
		              <li><a href="<?php echo base_url();?>setting/country">Country</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.Province')):?>
		              <li><a href="<?php echo base_url();?>setting/province">Province</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.MartialStatus')):?>
		              <li><a href="<?php echo base_url();?>setting/marital_status">Marital Status</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.EducationLevel')):?>
		              <li><a href="<?php echo base_url();?>setting/education_level">Education Level</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.EmploymentType')):?>
		              <li><a href="<?php echo base_url();?>setting/employment_type">Employment Type</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.JobProcessStatus')):?>
		              <li><a href="<?php echo base_url();?>setting/process_status">Job Process Status</a></li>
		              <?php endif;?>
		            	<?php if($this->auth->_allowed('Menu.References.SelectionSteps')):?>
		              <li><a href="<?php echo base_url();?>setting/selection_steps">Selection Steps</a></li>
		            	<?php endif;?>
		          </ul>
		    		</li>
		    		<?php endif;?>
					</ul>
					</li>
					<?php endif;?>
					<li></li>
				</ul>
			</div> <!-- /.nav-collapse -->
		</div>
		<div class="clearfix"></div>
</div> <!-- /.container -->