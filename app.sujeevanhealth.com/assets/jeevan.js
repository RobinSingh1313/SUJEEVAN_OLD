/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var adminurl    = '/Sujeevan-Admin';
var initPart    =   function(){
    $(document).find('a[data-type="order"]').each(function () {
        if ($(this).data("field") == $("#tipoOrderby").val()) {
            if ($("#orderby").val() == "ASC") { 
                $("i", this).removeClass('fa-sort-alpha-down');
                $(this).data("order", "DESC");
                $("i", this).addClass('fa-sort-alpha-up');
            } else {
                $("i", this).removeClass('fa-sort-alpha-up');
                $("i", this).addClass('fa-sort-alpha-down');
                $(this).data("order", "ASC");
            }
        } else {
            $("i", this).removeClass('fa-sort-alpha-down');
            $("i", this).addClass('fa-sort-alpha-up');
            $(this).data("order", "ASC");
        } 
    });
}
var input_rest = function(){
        $(".input_num").keypress(function(event){
                var inputValue = event.which;  
                if(!(inputValue >= 48 && inputValue <= 57) && (inputValue != 0 && inputValue != 8) ) { 
                        event.preventDefault(); 
                }
        });
        $(".input_num").keyup(function(){
                this.value = this.value.replace(/[^0-9]/g,'');
        });
        $(".input_geo").keyup(function(){
                this.value = this.value.replace(/[^0-9.]/g,'');
        });
        $(".input_char").keyup(function(){
                this.value = this.value.replace(/[^A-Z a-z.]/g,'');
        });
        $(".input_numchar").keyup(function(){
                this.value = this.value.replace(/[^A-Z 0-9a-z.]/g,'');
        });
        $(".input_geo").keypress(function(event){
                var inputValue = event.which; 
                if(!(inputValue >= 48 && inputValue <= 57) && (inputValue != 0 && inputValue != 8 &&inputValue != 46)) { 
                        event.preventDefault(); 
                }
        });
        $(".input_char").keypress(function(event){
                $(this).css("text-transform","capitalize");
                var inputValue = event.which;   
                if(!(inputValue >= 65 && inputValue <= 122) && (inputValue != 0 && inputValue != 8 && inputValue != 32 && inputValue != 46 &&  inputValue != 0)) { 
                    event.preventDefault(); 
                }
        }); 
        $(".upperceaseval").keypress(function(event){
                $(this).css("text-transform","uppercase"); 
        });
        $(".capitalizeval").keypress(function(event){
                $(this).css("text-transform","capitalize"); 
        });
};
function getdatafiled(event) {   
        initPart();
        $("#tipoOrderby").val(event.data("field"));
        $("#orderby").val(event.data("order")); 
        $("#vtipoOrderby").val(event.data("field"));
        $("#vorderby").val(event.data("order")); 
        searchFilter('',event.attr("urlvalue"));
}
function searchFilter(page_num,url,offset = "") {
        page_num        =   page_num?page_num:0; 
        var pnum        =   parseInt(page_num);
        if(offset != ""){
            pnum    =   offset;
        }
        var keywords    =   $('#FilterTextBox').val();      
        var secserach   =   $('.showsectionore').attr("valuetr");   
        var classserch  =   $('.shomoreclas').attr("valuetr");   
        var schoolserch =   $('.shoeselectmore').attr("valuetr");   
        var limitvalue  =   $('.limitvalue option:selected').val();   
        var vspvalue    =   $("#vspvalue").val();
        var vspcalss    =   "postList";
        var topv        =   $("#tipoOrderby").val();
        var orderby     =   $("#orderby").val();
        var clf     =   "pageloaderwrapper";
        if(vspvalue == 1){
            vspcalss    =   "perpostList";
            keywords    =   $('#vFilterTextBox').val();      
            limitvalue  =   $('.vlimitvalue option:selected').val();   
            topv        =   $("#vtipoOrderby").val();
            orderby     =   $("#vorderby").val();
            clf         =   "pagewrapper";
        }
        $('.'+vspcalss).html(""); 
        $.ajax({
                type    :   'POST',
                url     :   url+pnum,
                data:{ 
                        tipoOrderby :   topv,
                        orderby     :   orderby,
                        secserach   :   secserach,
                        schoolserch :   schoolserch,
                        classserch  :   classserch,
                        limitvalue  :   limitvalue,
                        keywords    :   keywords
                },
                beforeSend: function(){
                        $('.'+clf).show();
                }, 
                success: function (html) { 
                        $('.'+clf).hide();
                        $('.'+vspcalss).html(html); 
                        initPart();
                }
        });   
}  
function user_role(){
        var vale = [];
        var modiul   =   [];
        $(".user_roles option:selected").map(function(i, el) {
                vale[i]   =   $(el).val(); 
        }); 
        $(".user_modules option:selected").map(function(fs, els) {
                modiul[fs]   =   $(els).val();
        }); 
        $(".ajaxListPer").html("");
        $('.pageloaderwrapper').show();
        $.post(adminurl+"/AjaxPermission",{vale:vale,modiul:modiul},function(data){
                $(".ajaxListPer").html(data);
                $('.pageloaderwrapper').hide();
        });
}
function master_check(evt){
        var svsp    =   evt.is(":checked");
        var svpp    =   evt.val();
        if(svsp){ 
                $(".check_"+svpp).attr("checked","checked");
        }else{
                $(".check_"+svpp).removeAttr("checked");
        } 
}
function validate_fileupload(fileName){
    var allowed_extensions  =   new Array("xlsx");
    $(".validxet").html("");
    var file_extension      =   fileName.split('.').pop().toLowerCase();  
    if(allowed_extensions['0'] == file_extension){
        return true;
    } else{
        $(".validxet").html("Not valid extension");
        return false;
    }
}
function confirmationDelete(anchor, val) {
    swal({
        title: "Delete " + val,
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then(function (isConfirm) {
        if (isConfirm) { 
            var atr     =   anchor.attr("attrvalue");
//            window.location = anchor.attr("attrvalue");
            $.post(atr,function(data){
                if(data == 1){
                    loadpage();
                }
            });
            swal.close();
        }
        else {
            swal("Not Deleted....!!!", val);
        }
    });
} 
function loadpage(offset = ""){
        var urlvalue        =   $("#urlvalue").val();
        var vspvalue        =   $("#vspvalue").val();
        var permiurlvalue   =   $("#permiurlvalue").val();
        if(typeof vspvalue !== "undefined"){
            var perurlvalue   =   $("#perurlvalue").val();
            if(typeof perurlvalue !== "undefined"){
                searchFilter('',perurlvalue);
            }
        }else {
            if(typeof urlvalue !== "undefined"){
                searchFilter('',urlvalue,offset);
            }
            if(typeof permiurlvalue !== "undefined"){
                user_role();
            }
        }
} 
function activeform(evt,page,offset){
        var fields  =   evt.attr("fields");
        var status  =   evt.attr("vartie");
        var vpage    =   adminurl+"/"+page;
        swal({
            title: "Are you sure you want to " + status,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then(function (isConfirm) {
            if (isConfirm) { 
                $.post(vpage,{status:status,fields:fields},function(data){
                    if(data == 1){
                        loadpage(offset);
                    }else if(data == 0){
                        swal("No permissions ....!!!", '');
                    } else {
                        swal("Not updated any ....!!!", '');
                    }
                });
                swal.close();
            }
            else {
                swal("Not updated any ....!!!", status);
            }
        });
}
function readURLbiew(input,imgclaslobdgicon) {
    $(".spnaimage").html("");
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var image = new Image(); 
            image.src = reader.result;
            image.onload = function() { 
                $('.'+imgclaslobdgicon).html("<img src='"+e.target.result+"'  class='img imglogoho img-thumbnail mt-1 img-responsive'>");	 
            } 
        }
        reader.readAsDataURL(input.files[0]);
    }
} 
var formInit     =  function(){
        $('.validatform').validate({  
                errorClass:"text-error",
                errorElement:"span",
                rules:{
                    role_name:{
                        remote:{
                            url:adminurl+"/Ajax-Role-Check",
                            type:"post",
                            async:false,
                            data:{
                                role_name:function(){
                                    return  $.trim($(".role_name").val());
                                }
                            }
                        }
                    },
                    rolename:{
                        remote:{
                            url:adminurl+"/AjaxRoleCheck",
                            type:"post",
                            async:false,
                            data:{
                                roleid:function(){
                                    return  $(".roleid").val();
                                },
                                rolename:function(){
                                    return  $.trim($(".rolename").val());
                                }
                            }
                        }
                    },
                    packagenametype:{
                        remote:{
                            url:adminurl+"/Ajax-Package-CheckValues",
                            type:"post",
                            async:false,
                            data:{
                                packagenametype:function(){
                                    return  $.trim($(".packagenametype").val());
                                }
                            }
                        }
                    },
                    category_name:{
                        remote:{
                            url:adminurl+"/Ajax-Category-Check",
                            type:"post",
                            async:false,
                            data:{
                                module:function(){
                                    return  $(".module option:selected").val();
                                },
                                category_id:function(){
                                    return $(".category_id").val();
                                },
                                category_name:function(){
                                    return  $.trim($(".category_name").val());
                                }
                            }
                        }
                    },
                    specialization_name:{
                        remote:{
                            url:adminurl+"/Ajax-Specialization-Check",
                            type:"post",
                            async:false,
                            data:{
                                specialization_name:function(){
                                    return  $.trim($(".specialization_name").val());
                                },
                                specialization_id:function(){
                                    return $(".specialization_id").val();
                                }
                            }
                        }
                    },
                    vendor_name:{
                        remote:{
                            url:adminurl+"/Ajax-Vendor-Check",
                            type:"post",
                            async:false,
                            data:{
                                vendor_id:function(){
                                    return  $(".vendor_id").val();  
                                },
                                vendor_name:function(){
                                    return  $.trim($(".vendor_name").val());
                                }
                            }
                        }
                    },
                    package_name:{
                        remote:{
                            url:adminurl+"/Ajax-Package-Check",
                            type:"post",
                            async:false,
                            data:{
                                package_id:function(){
                                    return $(".package_id").val();
                                },
                                package_name:function(){
                                    return  $.trim($(".package_name").val());
                                }
                            }
                        }
                    },
                    test_name:{
                        remote:{
                            url:adminurl+"/Ajax-Test-Check",
                            type:"post",
                            async:false,
                            data:{
                                homecaretest_id:function(){
                                    return $(".homecaretest_id").val();
                                },
                                test_name:function(){
                                    return  $.trim($(".test_name").val());
                                }
                            }
                        }
                    },
                    sub_module_name:{
                        remote:{
                            url:adminurl+"/Ajax-Submodule-Check",
                            type:"post",
                            async:false,
                            data:{
                                sub_moduleid:function(){
                                    return $(".sub_moduleid").val();
                                },
                                module:function(){
                                    return  $(".moduleid option:selected").val();
                                },
                                sub_module_name:function(){
                                    return  $.trim($(".sub_module_name").val());
                                }
                            }
                        }
                    },
                },
                messages:{
                    role_name: {
                        required: 'Role Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Role Name already exists")
                    },
                    rolename: {
                        required: 'Role Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Role Name already exists")
                    },
                    module:{
                        required:"Module is required"
                    },
                    category_name: {
                        required: 'Category Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Category Name already exists")
                    },
                    test_name:{
                        required: 'Test Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Test Name already exists")
                    },
                    vendor_name: {
                        required: 'Vendor Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Vendor Name already exists")
                    },
                    sub_module_name: {
                        required: 'Sub Module Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Sub Module Name already exists")
                    },
                    packagenametype: {
                        required: 'Package Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Package Name already exists")
                    },
                    package_name: {
                        required: 'Package Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Package Name already exists")
                    },
                    specialization_name: {
                        required: 'Specialization Name is required',
                        remote:jQuery.validator.format("<span class='text-success'>{0}</span> : Specialization Name already exists")
                    },
                    blog_title:{
                    	required: 'Blog Title is required',
                    },
                    blog_description:{
                    	required: 'Blog Description is required',
                    }
                },
                highlight: function (input) { 
                    $(input).parents('.form-control').addClass('error');
                },
                unhighlight: function (input) {
                    $(input).parents('.form-control').removeClass('error');
                },
                errorPlacement: function (error, element) {
                    $(element).parents('.form-group').append(error); 
                }
        });
};
var selInit     =   function(){
    if($(".select2").length > 0){
        $(".select2").select2();
    }
};
var startTimeint =  function(){
    $(".datepickervalue").datepicker({
        "dateFormat": "dd-mm-yy",
        changeMonth: true,
        changeYear: true
    });
    $('.endtimepicker,.endchattimepicker').timepicker();
    $('.timepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        change:function(){
            var time    =   $(this).val();
            $('.endtimepicker').timepicker().destroy();
            endTimtinit(time);
        }
    });
    $('.chtatimepicker').timepicker({
        timeFormat: 'h:mm p',
        interval: 60,
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        change:function(){
            var time    =   $(this).val();
            $('.endchattimepicker').timepicker().destroy();
            endTimtinitwok(time);
        }
    });
};
var endTimtinitwok     =   function(time){
       $('.endchattimepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: time,
            defaultTime: time,
            startTime: time,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        }); 
};
var endTimtinit     =   function(time){
       $('.endtimepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: time,
            defaultTime: time,
            startTime: time,
            dynamic: false,
            dropdown: true,
            scrollbar: true
        }); 
};
var tinymceInit     =   function(){
        if($(".elm1class").length > 0){
            tinymce.init({
                selector: "textarea.elm1class",
                theme: "modern",
                height:300,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
                style_formats: [
                    {title: 'Bold text', inline: 'b'},
                    {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                    {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                    {title: 'Example 1', inline: 'span', classes: 'example1'},
                    {title: 'Example 2', inline: 'span', classes: 'example2'},
                    {title: 'Table styles'},
                    {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                ]
            });
        }
};
function clearfilter(pagevalue){
    $.post(adminurl+"/Clearfilter",{pagevalue:pagevalue},function(){
            $("#FilterTextBox").val("");
            loadpage();
    });
}
function pageform(){
        $(".pageurl,.pagewidgets,.rightcontent,.contentpage,.leftcontent").hide();
        $(".left_widget,.contet_widget,.right_widget").hide();
        $(".page_url").removeAttr("required");
        var page_layout     =   $(".page_layout option:selected").attr("atrvalue");
        var content_from    =   $('.page_content option:selected').attr("atrvalue");  
        if(content_from == '1'){
                $(".page_layout").removeAttr("required");
                $(".pageurl").show();
                $(".page_url").attr("required","required");
        }
        if(content_from == '2' && page_layout == '1'){
                $(".leftcontent").show(); 
                $(".contentpage").show();
               	//ckInit("cpage_leftsidebar");
                //ckInit("cpage_content");
tinymceInit();
        }
        if(content_from == '2' && page_layout == '2'){
                $(".contentpage").show();
                $(".rightcontent").show(); 
                
               // ckInit("cpage_content");
              //  ckInit("cpage_rightbar");
tinymceInit();
        }
        if(content_from == '2' && page_layout == '3'){
                $(".contentpage").show(); 
                //ckInit("cpage_content");
tinymceInit();
        }
        if(content_from == '2' && page_layout == '4'){
                $(".leftcontent").show(); 
                $(".contentpage").show();
                $(".rightcontent").show(); 
tinymceInit();
                //ckInit("cpage_leftsidebar");
                //ckInit("cpage_content");
                //ckInit("cpage_rightbar");
        }
        if(content_from == '3'){ 
                $(".pagewidgets").show();
        }
        if(content_from == '3' && page_layout == '1'){ 
                $(".left_widget").removeClass().addClass("left_widget col-md-4").show(); 
                $(".contet_widget").removeClass().addClass("contet_widget col-md-8").show();
                $(".right_widget").removeClass().addClass("right_widget");
                
        }
        if(content_from == '3' && page_layout == '2'){ 
                $(".left_widget").removeClass().addClass("left_widget");
                $(".contet_widget").removeClass().addClass("contet_widget span7 col-md-7").show();
                $(".right_widget").removeClass().addClass("right_widget span4 col-md-4").show(); 
                
        }
        if(content_from == '3' && page_layout == '3'){  
                $(".left_widget").removeClass().addClass("left_widget");
                $(".right_widget").removeClass().addClass("right_widget");
                $(".contet_widget").removeClass().addClass("contet_widget col-md-12").show();
                
        }
        if(content_from == '3' && page_layout == '4'){ 
                $(".left_widget").removeClass().addClass("left_widget col-md-4").show(); 
                $(".contet_widget").removeClass().addClass("contet_widget col-md-4").show();
                $(".right_widget").removeClass().addClass("right_widget col-md-4").show();
                
        }
}
var menudepth    =   function(){
    $('#menu-form .dd').nestable({
        maxDepth:4
    }); 
    $('#menu-form .dd').on('change', function () {
            var data =  [];
            jQuery('.dd-item').each(function(){
                    var id 		= jQuery(this).attr('data-id');
                    var parent  = jQuery(this).parent().parent().attr('data-id');
                    if(typeof parent == 'undefined')
                            parent = 0;
                    var menu = {'id':id,'parent':parent};
                    data.push(menu);
            });
            $(".top_menu").val(JSON.stringify(data)); 
            $.post(adminurl+"/Update-Menu",{menu:JSON.stringify(data)}); 
    });
    $('.row_nest .pagewidgets .dd,.row_nest .left_widget .dd,.row_nest .contet_widget .dd,.row_nest .right_widget .dd').nestable({
            maxDepth:1
    });
}
var menuInit    =   function(){  
    $('.row_nest .left_widget .dd').on('change', function () {
            var lefst = []; 
            $('.row_nest .left_widget .dd-item').each(function(){
                    var lid      =   $(this).attr('data-id');  
                    lefst.push(lid);  
            });
            $(".left_contentval").val(lefst.join(","));
    });
    $('.row_nest .contet_widget .dd').on('change', function () {
            var cnt = []; 
            $('.row_nest .contet_widget .dd-item').each(function(){
                    var lid      =   $(this).attr('data-id');  
                    cnt.push(lid);  
            });
            $(".page_conentval").val(cnt.join(",")); 
    });
    $('.row_nest .right_widget .dd').on('change', function () {
             var dcnt = []; 
            $('.row_nest .right_widget .dd-item').each(function(){
                    var lid      =   $(this).attr('data-id');  
                    dcnt.push(lid);  
            });
            $(".right_contentval").val(dcnt.join(",")); 
    });
};
var tootTip = function(){
    $('[data-toggle="tooltip-primary"]').tooltip({
        template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
    });
};
function  videotypes(){
	var videotypes 	=	$(".videotype option:selected").attr("video_type_text");
	if(videotypes  == "file"){
		$(".video_url").attr("accept",".mp4");                                    
	}
	$(".video_url").attr("type",videotypes); 
}
function addvideo(evt){
        var vsp 	=	evt.html();
        $(".videourl_err,.videoname_err").html("");
        var value_attr =   evt.attr("valueattr");   
		var videotypes 	=	$(".videotype option:selected").attr("video_type_text");
        var videotypeds 	=	$(".videotype option:selected").text();
        var videoname  =   $(".video_name").val();   
        var videourl   =   $(".video_url").val();    
        if(videourl != "" && videoname != ''){ 
            if(videotypes == "file"){
              var formData = new FormData();
              evt.html("<i class='fa fa-spin fa-spinner'></i>");
              formData.append('userfile', $('input[type=file]')[0].files[0]);
              $('.video.progress').show();
              $.ajax({
                  xhr: function() {
                      var xhr = new window.XMLHttpRequest();
                      xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                          var percentComplete = evt.loaded / evt.total;
                          percentComplete = parseInt(percentComplete * 100);
                          $('.video .progress-bar').css('width',percentComplete+"%");
                          $('.video .progress-bar').html(percentComplete+"%");
                          if (percentComplete === 100) {
                              percentComplete	=	"0";
                              $('.video .progress-bar').css('width',percentComplete+"%");
                              $('.video .progress-bar').html(percentComplete+"%");
              				  $('.video.progress').hide();
                          }
                        }
                      }, false);
                      return xhr;
                  },
                  url  : adminurl+'/Upload-Video-Files',
                  data : formData,
                  type : 'POST',
                  processData: false,
                  contentType: false,
                  success : function(dadta){ 
                	  var data    =   '<tr class="row_val'+value_attr+'">'
                                          +'<td>'+videotypeds+'<input type="hidden" value="'+videotypeds+'" name="videotypes[]"/></td>' 
                                          +'<td>'+dadta+'<input type="hidden" value="'+dadta+'" name="videourl[]"/></td>'  
                                          +'<td><a filename="'+videourl+'" onclick="remove_purchased('+value_attr+',this)" class="text-danger"><i class="fa fa-trash"></i></a></td>'
                                      +'</tr>';
                      var yattr   =   parseInt(value_attr)+parseInt(1);
                      evt.attr("valueattr",parseInt(yattr));
              		  $(".partpurchase").find("tbody").append(data);  
              		  $(".video_name,.video_url").val("");
                  }
              });
			}
            else{
                var data    =   '<tr class="row_val'+value_attr+'">'
                                    +'<td>'+videotypeds+'<input type="hidden" value="'+videotypeds+'" name="videotypes[]"/></td>' 
                                    +'<td>'+videourl+'<input type="hidden" value="'+videourl+'" name="videourl[]"/></td>'  
                                    +'<td><a onclick="remove_purchased('+value_attr+',this)" class="text-danger"><i class="fa fa-trash"></i></a></td>'
                                +'</tr>';
                var yattr   =   parseInt(value_attr)+parseInt(1);
                evt.attr("valueattr",parseInt(yattr));
                $(".partpurchase").find("tbody").append(data);  
                $(".video_name,.video_url").val("");
            }
            evt.html(vsp);
        }
        if(videourl == ""){
            $(".videourl_err").html("Video URL is required");
        }  
        if(videoname == ""){
            $(".videoname_err").html("Video Name is required");
        }  
}
function remove_purchased(value,evt){
        $.post(adminurl+"/Remove-Video",{value:value}); 
        $( ".row_val"+value ).remove(); 
}
$(function(){
        input_rest();
        loadpage();
        initPart();
        selInit();
        tinymceInit();
        formInit();
        pageform();
        menuInit();
        menudepth();
//        startTimeint();
        $(".imgclaslobdg").change(function() {
            readURLbiew(this,"imgclaslobdg");
        });
        $(".imgclaslobdgicon").change(function() {
            readURLbiew(this,"imgsloscicon");
        });
        $(".imgclaslobdgbg").change(function() {
            readURLbiew(this,"imgclaslobdgbgicon");
        });
});
$(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\"><i class='fa fa-trash'></i></span>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
/*-----------blog------------*/

function content_change(data){
    var x = data;
    var y = $( ".option1 option:selected" ).attr("fileva");
    if(y == 'file'){
        $('#content'+x).html('<input type="file" name="video[]" class="form-control"/>');
    }else {
        $('#content'+x).html('<input type="text" name="video_url[]" class="form-control" placeholder="Enter Url"/>');
    }    
}
function add_video(event){
    event.preventDefault();
    var x   =   $('#video_number').attr("data-val");
    $.ajax({
        type    :   'POST',
        url     :   adminurl+'/Ajax-Blog-Options',
        data:{ },
        success: function (html) {  
                initPart();
                $('#videoss').append(`<div class="row" id="total`+x+`">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select onchange="content_change(`+x+`)" id="option`+x+`" class="form-control" name="video_type[]" >
                                                    <option value="">Select Video Type</option>
                                                    `+html+`
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-group" id="content`+x+`">
                                        </div>
                                        </div>
                                        <div class="col-md-2">
                                            <i class="fa fa-times" aria-hidden="true" onclick="remove_div(`+x+`)"></i>
                                        </div>
                                    </div>`);
        }
    });   

                                    x++;
    $('#video_number').attr("data-val",x);                 
}
function remove_div(data){
    var x=data;
    $('#total'+x).empty();
}
function getCategory(){
    var module_id = $("#module option:selected" ).val();
    var cci =$('#cci').val();
    if($("#module").length > 0){
        if(module_id != ''){
            $.ajax({
                type    :   'POST',
                url     :   adminurl+'/Ajax-Category-List',
                data:{
                    module_id   :  module_id,
                    cci         :   cci
                 },
                success: function (html) {  
                        initPart();
                        $('#category').empty();
                        $('#category').append(html);
                }
            });   
        }    
    }
}

var vendorInit    =   function(){
    var lue =   "";
    var idvalue     =   $(".vedgincmoere").attr("valueatr");
    if(typeof idvalue !== "undefined"){
        $.post(adminurl+"/Ajax-Vendors",function(datavalue){
            datavalue   =   $.parseJSON(datavalue);
            $.each(datavalue,function(index,item){
                    var vid     =   (item.id);
                    var vtd     =   (item.text);
                    var seck    =   (vid == idvalue)?"selected='selected'":"";
                    lue +=  '<option value="'+vid+'" '+seck+'>'+vtd+'</option>';
            });
            $(".vedgincmoere").html(lue);
        });
    }
    if($(".vendorSelect").length > 0){
        $(".vendorSelect").select2({
            placeholder:"Search Vendors",
            ajax: {
                url: adminurl+'/Ajax-Vendors',
                type: "post",
                dataType: 'json',
                data: function (params) {
                    return {
                        term: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }
};
function addvlauepes(){
    var value_attr  =   $(".btn_termsattr").attr("payattr");  
    var data        =  "<div class='mtop-10 form-group row rowtval"+value_attr+"'>" 
            +"<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>" 
            +'<input type="hidden" name="termid['+value_attr+']" value="0"/>'
            +'<input class="form-control" name="item['+value_attr+']" placeholder="Item Name"/>'
            +"</div>"   
            +"<div class='col-lg-4 col-md-4 col-sm-4 col-xs-12'>" 
            +'<input class="form-control" name="quantity['+value_attr+']" placeholder="Quantity"/>'
            +"</div>"   
            +"<div class='col-lg-2 col-md-2 col-sm-2 col-xs-12'><a onclick='removeterms("+value_attr+")' class='text-danger'><i class='fa fa-trash '></i></a></div>"
            +"</div>";
    $(".ternsconfition").append(data+"<script>input_rest();</script>");
    $('.conditiond_val').val(value_attr); 
    var yattr   =   parseInt(value_attr)+parseInt(1); 
    $('.btn_termsattr').attr("payattr",parseInt(yattr)); 
}
function removeterms(value){
    $( ".rowtval"+value ).remove();
}
function viewsavetempalte(evt){
    var viewsavetdi     =   evt.attr("regvind");
    $.post(adminurl+"/Ajax-Vendor-View",{regvind:regvind},function(){
        $(".modal").modal("show"); 
    });
}
function updaatehealth(){
    var module  =   $(".module option:selected").val();
    $.post(adminurl+"/Ajax-Health-Category",{module:module},function(daa){
        $(".healthcategory").html(daa); 
    });
}
function updaatehealthcategory(){
    var healthcategory  =   $(".healthcategory option:selected").val();
    $.post(adminurl+"/Ajax-Health-Sub-Category",{healthcategory:healthcategory},function(daa){
        $(".healthcategorysub").html(daa); 
    });
}
function statusupdate(evt){
        var status  =   evt.find('option:selected').val();
        var url  =   evt.attr("url_v"); 
        var id  =   evt.attr("user_id"); 
        $.post(adminurl + "/"+url, {id : id ,status: status}, function (data) {
                // $(".ordest"+id).html(ordeid);
        });
}
function user_history(id){
    $('.user'+id).css('visibility','hidden');
    $('.loader'+id).css('display','block');
    $('.loader'+id).html(`<div class="sk-wave">
                      <div class="sk-rect sk-rect1 bg-gray-800"></div>
                      <div class="sk-rect sk-rect2 bg-gray-800"></div>
                      <div class="sk-rect sk-rect3 bg-gray-800"></div>
                      <div class="sk-rect sk-rect4 bg-gray-800"></div>
                      <div class="sk-rect sk-rect5 bg-gray-800"></div>
                    </div>`);
    $.post(adminurl + "/Ajax-User-History", {id : id}, function (data) {
                $('.user'+id).css('visibility','visible');
                $('.loader'+id).css('display','none');
                $("#user_history").html(data);
                $('#modaldemo6').modal('show');
        });
}

function user_history_new(id, history_id,moduleid){
    $('.user'+history_id).css('visibility','hidden');
    $('.loader'+history_id).css('display','block');
    $('.loader'+history_id).html(`<div class="sk-wave">
                      <div class="sk-rect sk-rect1 bg-gray-800"></div>
                      <div class="sk-rect sk-rect2 bg-gray-800"></div>
                      <div class="sk-rect sk-rect3 bg-gray-800"></div>
                      <div class="sk-rect sk-rect4 bg-gray-800"></div>
                      <div class="sk-rect sk-rect5 bg-gray-800"></div>
                    </div>`);
    $.post(adminurl + "/Ajax-User-History", {id : id, moduleid:moduleid,history_id:history_id}, function (data) {
                $('.user'+history_id).css('visibility','visible');
                $('.loader'+history_id).css('display','none');
                $("#user_history").html(data);
                $('#modaldemo6').modal('show');
        });
}

function user_history_mempur(id, mempur_id){
    $('.user'+mempur_id).css('visibility','hidden');
    $('.loader'+mempur_id).css('display','block');
    $('.loader'+mempur_id).html(`<div class="sk-wave">
                      <div class="sk-rect sk-rect1 bg-gray-800"></div>
                      <div class="sk-rect sk-rect2 bg-gray-800"></div>
                      <div class="sk-rect sk-rect3 bg-gray-800"></div>
                      <div class="sk-rect sk-rect4 bg-gray-800"></div>
                      <div class="sk-rect sk-rect5 bg-gray-800"></div>
                    </div>`);
    $.post(adminurl + "/Ajax-User-History", {id : id}, function (data) {
                $('.user'+mempur_id).css('visibility','visible');
                $('.loader'+mempur_id).css('display','none');
                $("#user_history").html(data);
                $('#modaldemo6').modal('show');
    });
}

function update_response(eve){
    var registration_id = $('#registration_id').val();
    $.post(adminurl + "/Ajax-Update-Response", {id : eve.val() ,registration_id:registration_id}, function (data) {
        $("#update_response").html(data);
    });
    // alert(eve.val());
}
function update_doctor_select(spec_id){
    var vendor_id  =   $("#vendor_list"+spec_id+" option:selected").val();
    var idd  =   $("#specialization_id"+spec_id+" option:selected").val();
    var doctor_id  =   $("#assigned_doctor"+spec_id).val();
    if(vendor_id !=''){
        $.post(adminurl + "/Ajax-Doctor-Select", {specialization_id : idd, doctor_id : doctor_id ,vendor_id : vendor_id}, function (data) {
            $("#doctor_list"+spec_id).html(data);
        });
    }
        
}
function update_health_condition(spec_id){
    var health_condition  =   $("#update_health"+spec_id).val();
    var visit_address  =   $("#update_address"+spec_id).val();
    if(health_condition !='' || visit_address !=''){
        $.post(adminurl + "/Ajax-Update-Health-Condition", {health_condition : health_condition, membership_id:spec_id , visit_address : visit_address}, function (data) {
            swal("Updated health condition successfully", '');
        });
    }
        
}
function assign_doctor(spec_id){
    var idd  =   $("#specialization_id"+spec_id+" option:selected").val();
    var doctor_id  =   $("#doctor_list"+spec_id+" option:selected").val();
    var doctor_name  =   $("#doctor_list"+spec_id+" option:selected").text();
        swal({
            title: "Are you sure you want to Assign " + doctor_name +" to membership",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then(function (isConfirm) {
            if (isConfirm) { 
                $.post(adminurl + "/Ajax-Doctor-Assign", {specialization_id : idd, doctor_id : doctor_id, membership_id:spec_id }, function (data) {
                    if(data == 1){
                        swal("Successfully Doctor Assigned", '');
                    }else if(data == 0){
                        swal("No permissions ....!!!", '');
                    } else {
                        swal("Not updated any ....!!!", '');
                    }
                });
                swal.close(); 
            }
            else {
                swal("Not updated any ....!!!", status);
            }
        });
}
function append_vendors(){
    var extra_feilds = `<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"> 
                            <div class="form-group">
                                <input type="number" class="form-control" name="vendor_days[]" required placeholder="Enter No of Days assigned"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                            <div class="form-group">
                                <input type="number" class="form-control" name="vendor_amount[]" required placeholder="Enter amount"/>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"> 
                            <div class="form-group">
                                <button class="btn btn-danger" onclick="$(this).closest('.col-lg-12').remove();event.preventDefault();">Remove Vendor </button>
                            </div>
                        </div>`;
    $.post(adminurl + "/Ajax-Select-VendorList", function (data) {
            $("#append_vendors_data").append('<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 row">'+data+extra_feilds+'</div>');
            // $("#append_vendors_data").append(data);
            // $("#append_vendors_data").append(extra_feilds);
            // $("#append_vendors_data").append('</div>');
    });
}
function append_membership_assign_feilds(evt){
    var id = parseInt(evt.attr("data-value"));id++;
    $.post(adminurl + "/Ajax-Membership-Assign-Feilds",{id : id,last_date : $('#last_date').val()}, function (data) {
            $("#append_vendors_data").append(data);
    });
    evt.attr("data-value",id);
}
function get_package_data(){
    var id  =   $("#membership_id option:selected").val();
    if(id !=''){
        $.post(adminurl + "/Ajax-Get-Package-Details",{membership_id:id}, function (data) {
            var data = JSON.parse(data);
            $(".user_package_price").val(data.membership_price);
            $(".user_package_after_disc").val(data.membership_after_disc);
            $(".user_package_days").val(data.membership_days);
            $(".user_package_about").val(data.membership_about);
        });
    }
}
function customer_request_status(spec_id){
    var status  =   $("#statt"+spec_id+" option:selected").val();
        swal({
            title: "Are you sure you want to change status to "+status,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then(function (isConfirm) {
            if (isConfirm) { 
                $.post(adminurl + "/Ajax-Customer-Request-Status", { support_id:spec_id , status:status }, function (data) {
                    if(data == 1){
                        swal("Successfully Status Changed", '');
                    }else if(data == 0){
                        swal("No permissions ....!!!", '');
                    } else {
                        swal("Not updated any ....!!!", '');
                    }
                });
                swal.close(); 
            }
            else {
                swal("Not updated any ....!!!", status);
            }
        });
}
function update_contact_response(spec_id){
    var contact_response  =   $("#contact_response"+spec_id).val();
    if(contact_response !=''){
        $.post(adminurl + "/Ajax-Update-Contact-Response", {support_id:spec_id ,contact_response : contact_response}, function (data) {
            if(data == 2){
                swal("not Updated", '');
            }else{
                swal("Updated Response successfully", '');
            }
            
        });
    }
        
}
function getsubmoduleSelect(){
    var module_id  =   $("#module_id option:selected").val();
    var sub_module_id = $('#sub_module_id').val();
    $.post(adminurl+"/Ajax-Sub-Module",{module_id:module_id,sub_module_id:sub_module_id},function(daa){
        $("#submodule").html(daa); 
    });
}
function vaccine_request_status(spec_id){
    var status  =   $("#statt"+spec_id+" option:selected").val();
        swal({
            title: "Are you sure you want to change status to "+status,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then(function (isConfirm) {
            if (isConfirm) { 
                $.post(adminurl + "/Ajax-Vaccine-Request-Status", { vaccine_id:spec_id , status:status }, function (data) {
                    if(data == 1){
                        swal("Successfully Status Changed", '');
                    }else if(data == 0){
                        swal("No permissions ....!!!", '');
                    } else {
                        swal("Not updated any ....!!!", '');
                    }
                });
                swal.close(); 
            }
            else {
                swal("Not updated any ....!!!", status);
            }
        });
}
function bookappointment_request_status(spec_id){
    var status  =   $("#statt"+spec_id+" option:selected").val();
        swal({
            title: "Are you sure you want to change status to "+status,
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then(function (isConfirm) {
            if (isConfirm) { 
                $.post(adminurl + "/Ajax-bookappointment-Request-Status", { bookappointment_id:spec_id , status:status }, function (data) {
                    if(data == 1){
                        swal("Successfully Status Changed", '');
                    }else if(data == 0){
                        swal("No permissions ....!!!", '');
                    } else {
                        swal("Not updated any ....!!!", '');
                    }
                });
                swal.close(); 
            }
            else {
                swal("Not updated any ....!!!", status);
            }
        });
}
$(function(){
        vendorInit();
        getCategory();
        getsubmoduleSelect();
        $('#summernote').summernote({
          height: 300
        });
});