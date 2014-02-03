var action_note = function(id,url){
  var $selector = $("#action_note-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
    };
  $target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      var t = '', dt = {};
      if(d.status == 'success'){
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          t += '<p>' + dt.order + '. ' + dt.name + ':' + dt.comment + '</p>';
        }
      }
      $target.find('.modal-body').html(t);
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

var action_pdf = function(id,url){
  var $selector = $("#action_pdf-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
    };
  $target.modal('show');
  canvas = document.getElementById('the-canvas');
  context = canvas.getContext('2d');

  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      var t = '', dt = {};
      if(d.status == 'success'){
          dt = d.data;
          t += dt.path+dt.doc;
          PDFJS.disableWorker = true;
          PDFJS.getDocument(t).then(function(pdf) {
            // Using promise to fetch the page
            pdf.getPage(1).then(function(page) {
              var scale = 1.5;
              var viewport = page.getViewport(scale);
              //
              // Prepare canvas using PDF page dimensions
              //
              canvas.height = viewport.height;
              canvas.width = viewport.width;

              //
              // Render PDF page into canvas context
              //
              var renderContext = {
                canvasContext: context,
                viewport: viewport
              };
              page.render(renderContext);
            });
          });

      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

var action_detail = function(id,jobid,url){
  var $selector = $("#action_detail-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
      jobid: jobid,
    };
  $target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      var t = '', dt = {};
      if(d.status == 'success'){
        t = d.data;
      }
      $target.find('.modal-body').html(t);
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

var action_view = function(email,url){
    $form_data = {
      email: email,
    };

  $.ajax({
    url : url,
    type : 'POST',
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      if(d.status == 'success'){
        location.href = "<?php echo base_url();?>" + 'applicant/data';
      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

var action_prev = function(id,jobid,url,action){
  $("#prevModal").find('#from_date').parent().parent().hide();
  $("#prevModal").find('#from_hour').parent().parent().hide();
  $("#prevModal").find('#process_place').parent().parent().hide();
  $("#prevModal").find('#process_subject').parent().parent().hide();
  $("#prevModal").find('#process_body').parent().parent().hide();
  $("#prevModal").find('#process_comment').parent().parent().hide();
  $("#prevModal").find("#star-rate").parent().parent().hide();
  $("#prevModal").find("#email").parent().parent().hide();

  var $selector = $("#action_prev-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
      jobid: jobid,
      action: action,
      form: ''
    };
  $target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      $target.find('#process_apply_id').val(id);
      $target.find('#process_last_step').val(d.last_step.max_index);
      $target.find('#process_job_id').val(jobid);
      $target.find('#process_step_name').html(d.last_step.name);
      $target.find('#star-rate').attr('data-apply',id);
      $target.find('#star-rate').attr('data-process-apply',d.last_step.max_index);
      $target.find('#star-rate').attr('data-score',d.last_step.rate);

    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
      $.fn.raty.defaults.path = '<?php echo img_path();?>images/raty';
        $.each($('.star-rate'), function() {
          $("#" + this.id ).raty({
            score: function() {
              return $(this).attr('data-score');
            },
            click: function(score, evt) {
                var process_id = $(this).attr('data-process-apply');
                var apply_id = $(this).attr('data-apply');
                $.ajax({
                  url: '<?php echo base_url()."joborder/rating_process";?>',
                  type: 'POST',
                  dataType: 'json',
                  data: {'process_id':process_id,
                          'apply_id':apply_id,
                          'score':score
                  },
                  success: function(d) {
                    $target.find('#star-rate').attr('data-score',d.processRate);
                  },
                  error: function() {

                  },
                  complete: function(){
                  }
                });
              }
            });
        });
    }
  });
  return false;
}

var action_next = function(id,jobid,url,action){
  var $selector = $("#action_next-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
      jobid: jobid,
      action: action,
      form: ''
    };
  $target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      $target.find('#process_max_step').val(d.order.max_value);
      $target.find('#process_apply_id').val(d.record.processApplyID);
      $target.find('#process_last_step').val(d.last_step.max_index);
      $target.find('#process_job_id').val(jobid);
      if(d.last_step.status == 0){
        $target.find('#process_next_step').val(d.next_step.stepsID);
        $target.find('#process_next_step_name').html(d.next_step.name);
      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

var action_stop = function(id,jobid,url,action){
  var $selector = $("#action_stop-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
      jobid: jobid,
      action: action,
      form: ''
    };
$target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      $target.find('#process_max_step').val(d.order.max_value);
      $target.find('#process_apply_id').val(d.record.processApplyID);
      $target.find('#process_last_step').val(d.last_step.max_index);
      // $target.find('#process_next_step').val(d.next_step.stepsID);
      // $target.find('#process_next_step_name').html(d.next_step.name);
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}

var action_delete = function(id,jobid,url,action){
  var $selector = $("#action_delete-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
      jobid: jobid,
      action: action,
      form: ''
    };
  $target.modal('show');
  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
    },
    success: function(d){
      $target.find('#process_max_step').val(d.order.max_value);
      $target.find('#process_apply_id').val(d.record.processApplyID);
      $target.find('#process_last_step').val(d.last_step.max_index);
      // $target.find('#process_next_step').val(d.next_step.stepsID);
      // $target.find('#process_next_step_name').html(d.next_step.name);
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}
var action_cv = function(id,url){
  var $selector = $("#action_cv-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
    };

  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
      $("#view_document").html('Waiting .... ');
    },
    success: function(d){
      var t = '', dt = {}, text ='';
      if(d.status == 'success'){
          dt = d.data;
          t += dt.path+dt.doc+'&amp;embedded=true';
          // text += "<a href='" + t + "'>Curiculum Vitae</a>";
          var iframe = '<iframe src="http://docs.google.com/gview?url='+t+'" width="720" height="800" style="border: none;" id="document-preview"></iframe>';
          $("#view_document").html(iframe);
          $("#document-preview").responsiveIframe({ xdomain: '*'});

      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}
var action_cl = function(id,url){
  var $selector = $("#action_cl-" + id),
    $target = $($selector.attr('data-target')),
    $form = $target.find('form').first(),
    $form_data = {
      id: id,
    };

  $.ajax({
    url : url,
    type : 'POST',
    data : $form_data,
    dataType: 'json',
    beforeSend: function() {
      NProgress.start();
      $("#view_document").html('Waiting .... ');
    },
    success: function(d){
      var t = '', dt = {}, text ='';
      if(d.status == 'success'){
          dt = d.data;
          t += dt.path+dt.doc+'&amp;embedded=true';
          // text += "<a href='" + t + "'>Curiculum Vitae</a>";
          var iframe = '<iframe src="http://docs.google.com/gview?url='+t+'" width="720" height="800" style="border: none;max-width: 100%" id="document-preview"></iframe>';
          $("#view_document").html(iframe);
          $("#document-preview").responsiveIframe({ xdomain: '*'});

      }
    },
    error: function(){

    },
    complete: function(){
      NProgress.done();
    }
  });
  return false;
}
$.fn.resetFormCustom = function()
{
  var $form = $(this);

  $form.find('input:text, input:hidden, input:password, input:file, textarea').val('');
  $form.find('select option:selected').removeAttr('selected');
  $form.find('input:checkbox, input:radio').removeAttr('checked');

  return this;
};