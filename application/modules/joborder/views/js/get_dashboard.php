<?php

?>
var Document = {
  param: {
    dataperpage: 0, // jumlah data per halaman
    query: '',
    curpage: 0,
    numpage: 0,
    skey: '',
    stype: '',
    npage: 0
  },
  url: '<?php echo base_url()."joborder/dashboard";?>',
  search: function(n) {
    var $form = $("#sform");
    this.param.query = $form.serializeFormJSON() || '';
    this.param.dataperpage = n || 10;
    this.param.curpage = 0;
    this.loadData();
    return false;
  },
  refresh: function() {
    this.loadData();
    return false;
  },
  setPage: function(n) {
    this.param.curpage = n;
    this.loadData();
    return false;
  },
  sort: function(skey,stype) {
    this.param.skey = skey || '_name';
    this.param.stype = stype || 'asc';
    this.loadData();
    return false;
  },
  loadData: function() {
    $.ajax({
      url: Document.url,
      type: 'POST',
      dataType: 'json',
      data: jQuery.param(Document.param),
      beforeSend: function() {
        NProgress.start();
      },
      success: function(d) {
        Document.param.numpage = d.numpage;
        Document.param.npage = d.npage;
        var t = '',cl = '', dt = {};
        for (var i = 0; i < d.data.length; i++) {
          dt = d.data[i];
          switch(dt.flow){
            case 1:
              cl = 'internal-mobility';
              break;
            case 2:
              cl = 'external-mobility';
              break;
            case 4:
              cl = 'awaiting-of-approval';
              break;
            case 'expiring':
              cl = 'expiring-three-day';
              break;
            default:
              console.log('hello');
          }
          t +=
             '<tr><td><div class="td-priority ' + cl + '">'+ dt.priority + '</div></td>' +
             '<td><div class="td-name ' + cl + '">' + dt.name + '</div></td>' +
             '<td>' + '' + '</td>' +
             '<td>' + dt.selection_cv + '</td>' +
             '<td>' + dt.interview_hr + '</td>' +
             '<td>' + dt.interview_user + '</td>' +
             '<td>' + dt.interview_user2 + '</td>' +
             '<td>' + dt.test_bidang + '</td>' +
             '<td>' + dt.psikotes + '</td>' +
             '<td>' + dt.mcu + '</td>' +
             '<td>' + dt.persentasi + '</td>' +
             '<td>' + dt.hiring + '</td></tr>';
        }
        $('#document-data').html(t);
        $('#pagination').html(d.pagination);
      },
      error: function() {

      },
      complete: function(){
        NProgress.done();
        $("[rel='tooltip']").tooltip();
      }
    });
  },
}

$.fn.serializeFormJSON = function() {

   var o = {};
   var a = this.serializeArray();
   $.each(a, function() {
       if (o[this.name]) {
           if (!o[this.name].push) {
               o[this.name] = [o[this.name]];
           }
           o[this.name].push(this.value || '');
       } else {
           o[this.name] = this.value || '';
       }
   });
   return o;
};