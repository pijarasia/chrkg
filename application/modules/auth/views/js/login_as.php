/* Ajax Redirect ikutin web redirect sesuai degan */
/* refid = null semua, kalau ga ikutin company */
/* level ngikutin kemana maunya aja ;D */

var login_as = function(ulid,id,name,refid){
    var form_data = {
      ulid: ulid,
      id:id,
      name: name,
      refid: refid
    };
    $.ajax({
        url : "<?php echo base_url(); ?>register/login_as",
        type : 'POST',
        dataType: 'json',
        data : form_data,
        beforeSend: function(){

        },
        success: function(d){
          location.href = "<?php echo base_url();?>" + d.redirect;
        },
        error: function(e){

        },
        complete: function(){
        }
    });
    return false;
}


String.prototype.supplant = function (o) {
    return this.replace(/{([^{}]*)}/g,
        function (a, b) {
            var r = o[b];
            return typeof r === 'string' || typeof r === 'number' ? r : a;
        }
    );
};