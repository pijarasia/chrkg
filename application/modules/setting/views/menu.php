<div class="span12 well">
	<ul class="breacrumb">
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/plan'?>" class="brea-nav" id="plan-nav">PARTNERS &<br /> OPTIONS</a></li>
		<?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/cost_centers'?>" class="brea-nav" id="cost_centers-nav">COST <br />CENTERS</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/verticals'?>" class="brea-nav" id="verticals-nav">VERTICALS<br />&nbsp;</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/locations'?>" class="brea-nav" id="locations-nav">LOCATIONS<br />&nbsp;</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/email_template'?>" class="brea-nav" id="email_template-nav">EMAIL <br />TEMPLATES</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/candidate_sources'?>" class="brea-nav" id="candidate_sources-nav">CANDIDATE <br />SOURCES</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/internal_staff'?>" class="brea-nav" id="internal_staff-nav">INTERNAL STAFF<br />&nbsp;</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/agency_staff'?>" class="brea-nav" id="agency_staff-nav">AGENCY STAFF<br />&nbsp;</a></li>
	  <?php endif;?>
		<?php if ($this->auth->_allowed('Menu.Settings.Partners')): ?>
	  <li><a href="<?php echo base_url().'setting/candidate_home'?>" class="brea-nav" id="candidate_home-nav">CANDIDATE <br />HOMEPAGE</a></li>
		<?php endif;?>
	</ul>
</div>