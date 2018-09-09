$(function() {
	$("#language").select2();
	/*checkAll checkbox in index page*/
	$(document).on('click', "#checkAll", function() {
		if($(this).is(":checked")) {
			$(".checkItem").prop("checked", true);
		} else {
			$(".checkItem").prop("checked", false);
		}
	});
	$(document).on('click', ".checkItem", function() {
		if($(this).is(":checked")) {
			if($(".checkItem:checked").length == $(".checkItem").length) {
				$("#checkAll").prop("checked", true);
			}
		} else {
			$("#checkAll").prop("checked", false);
		}
	});

	/*show page*/
	$(".showPage").change(function() {
		var url = location.protocol+'//'+location.host+location.pathname;
		url += "?pageSize=" + $(this).val();
		if($("#sMsv").length == 1 && $("#sMsv").val() != "") {
			url += "&idmsv=" + $("#sMsv").val();
		}
		if($("#sName").length == 1 && $("#sName").val() != "") {
			url += "&name=" + $("#sName").val();
		}
		if($("#sType").length == 1 && $("#sType").val() != 0) {
			url += "&type=" + $("#sType").val();
		}
		if($("#sKhoa").length == 1 && $("#sKhoa").val() != 0) {
			url += "&khoa=" + $("#sKhoa").val();
		}
		if($("#sCatId").length == 1 && $("#sCatId").val() != 0) {
			url += "&catId=" + $("#sCatId").val();
		}
		location.href = url;
	});

	/*search*/
	$("#searchBtn").click(function() {
		var url = location.protocol+'//'+location.host+location.pathname;
		url += "?pageSize=" + $("#sPageSize").val();
		if($("#sMsv").length == 1 && $("#sMsv").val() != "") {
			url += "&idmsv=" + $("#sMsv").val();
		}
		if($("#sName").length == 1 && $("#sName").val() != "") {
			url += "&name=" + $("#sName").val();
		}
		if($("#sType").length == 1 && $("#sType").val() != 0) {
			url += "&type=" + $("#sType").val();
		}
		if($("#sKhoa").length == 1 && $("#sKhoa").val() != 0) {
			url += "&khoa=" + $("#sKhoa").val();
		}
		if($("#sCatId").length == 1 && $("#sCatId").val() != 0) {
			url += "&catId=" + $("#sCatId").val();
		}
		location.href = url;
	});

	/*Action search*/
    $("#actionSearchBtn").click(function() {
        var url = location.protocol+'//'+location.host+location.pathname;
        url += "?pageSize=" + $("#sPageSize").val();
        if($("#sName").length == 1 && $("#sName").val() != "") {
            url += "&name=" + $("#sName").val();
        }
        location.href = url;
    });

	/*reverse item*/
	$(document).on('click', '.reverseItem', function() {
		var tmpId = $(this).attr("id");
		var id = $(this).attr("data-id");
		$.ajax({
			url: $(this).attr("data-href"),
			type: "POST",
			async: false,
			data: {id: id},
			dataType: 'json',
			success: function(resp) {
				if(resp.error) {
					jAlert('Không tìm thấy yêu cầu của bạn!', 'Thông báo');
				} else {
					$("#"+tmpId+" i").removeClass(resp.rm);
					$("#"+tmpId+" i").addClass(resp.add);
				}
			}
		});
	});
	
	/*view item detail*/
	$('.viewItem').click(function() {
		$.ajax({
			type: "GET",
			url: $(this).attr("data-href")+'/'+$(this).attr('data-id'),
			dataType: "json",
			success: function(resp) {
				if(resp.error == undefined) {
					$('.bd-example-modal-lg .modal-body').html(resp.html);
					$('.bd-example-modal-lg').modal('show');
				} else {
					jAlert(resp.error, "Thông báo");
					return false;
				}
			}
		});
	});

	/*get category by type*/
	$("#type_cat").change(function() {
		if($(this).val() != 0) {
			$.ajax({
				type: "POST",
				url: $(this).attr("data-href"),
				data: {type: $(this).val()},
				dataType: "json",
				success: function(resp) {
					$("#parent_id").html(resp);
				}
			});
		}
	});

	$("#parent_id").click(function() {
		if($("#type_cat").val() == 0) {
			jAlert("Bạn chưa chọn loại danh mục", "Thông báo");
			return false;
		}
	});

	/*delete item*/
	$(document).on('click', ".deleteItem", function() {
		var id = $(this).attr("id");
		var href = $("#delUrl").val();
		jConfirm('Bạn chắc chắn muốn xóa?', 'Xác nhận', function (r) {
            if (r) {
                location.href = href+'/'+id;
            } else {
            	return false;
            }
        });
	});

	/*choose multi groups of action*/
    $("#groups").select2({
        placeholder: "Chọn những nhóm có quyền này",
    });

	/*action detail*/
    $(".actionDetail").click(function(){
        $("#action_name").empty();
        $("#organization_name").empty();
        $("#group_name").empty();
        $("#description").empty();
        $("#action_checkin").prop('checked', false);
        $("#action_checkout").prop('checked', false);
        $("#detail_modal").modal();
        var id = $(this).attr("data-id");
        var href = $(this).attr("data-href");
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: href,
            type: 'GET',
            dataType:"json",
            data: {
                _token: CSRF_TOKEN,
                id: id
            },
            success: function( data ){
            	var groups_name = '';
            	if(data['data']['detail']['for_all_group'] == 1) {
                    groups_name = ' Tất cả'
                }else{
					var i;
					for (i = 0; i < data['data']['detail']['groups'].length; i++) {
						groups_name += ' '+ data['data']['detail']['groups'][i]['name'] + ";";
					}
            	}
                $("#action_name").append(' ' + data['data']['detail']['name']);
                $("#organization_name").append(' ' + data['data']['detail']['organization']['name']);
                $("#group_name").append(groups_name);
                $("#description").append(' ' + data['data']['detail']['description']);
                if(data['data']['detail']['can_checkin'] == 1){
                    $("#action_checkin").prop('checked', true);
				}
                if(data['data']['detail']['can_checkout'] == 1){
                    $("#action_checkout").prop('checked', true);
                }
                console.log(data['data']['detail']);
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
	});

	/*delete all item*/
	$(".deleteAll").click(function() {
		var listId = "";
		$(".checkItem").each(function() {
			if($(this).is(":checked")) {
				if(listId.length == 0) {
					listId = $(this).val();
				} else {
					listId += ","+$(this).val();
				}
			}
		});
		var href = $("#delUrl").val();
		if(listId == "") {
			jAlert("Bạn chưa chọn bản ghi nào", "Thông báo");
			return false;
		} else {
			jConfirm('Bạn chắc chắn muốn xóa?', 'Xác nhận', function (r) {
	            if (r) {
	                location.href = href+'/'+listId;
	            } else {
	            	return false;
	            }
	        });
		}
	});

	/*tab language*/
	$('.lang-icon').click(function() {
		var id = $(this).attr("id");
      	$.ajax({
	        type: "GET",
	        url: $(this).attr('data-href'),
	        success: function() {
	          $('.lang-icon').removeClass('icon-active');
	          $("#" + id).addClass('icon-active');
	        }
      	});
    });

    $(document).on('click', 'ins.iCheck-helper', function() {
    	if($(this).closest('.icheckbox_flat-green').hasClass('checked')) {
    		if($(this).hasClass('check_all_permission')) {
    			$(this).closest('tr').find('.icheckbox_flat-green').removeClass('checked');
    			$(this).closest('tr').find('input.flat-red[name^="permission"]').prop('checked', false);
    		} else {
    			$(this).closest('.icheckbox_flat-green').removeClass('checked');
    			$(this).closest('tr').find('.check_all_permission').closest('.icheckbox_flat-green').removeClass('checked');
    		}
    	} else {
    		if($(this).hasClass('check_all_permission')) {
    			$(this).closest('tr').find('.icheckbox_flat-green').addClass('checked');
    			$(this).closest('tr').find('input.flat-red[name^="permission"]').prop('checked', true);
    		} else {
    			$(this).closest('.icheckbox_flat-green').addClass('checked');
    			if($(this).closest('tr').find('.icheckbox_flat-green.checked').length >= 5) {
    				$(this).closest('tr').find('.check_all_permission').closest('.icheckbox_flat-green').addClass('checked');
    			}
    		}
    	}

    });
});

/*attact file*/
function attactFile(file) {
	$("#icon-attact").show();
	$("#attact_file_name").text(file.name);
}

/*createAlias*/
function createAlias(string) {
	// First, remove any multi space with single space
	string = string.replace(/ +(?= )/g,'');

	// Second, remove first and last space if had
	string = string.trim();

	// Sigend to un-signed 
    var signedChars     = "àảãáạăằẳẵắặâầẩẫấậđèẻẽéẹêềểễếệìỉĩíịòỏõóọôồổỗốộơờởỡớợùủũúụưừửữứựỳỷỹýỵÀẢÃÁẠĂẰẲẴẮẶÂẦẨẪẤẬĐÈẺẼÉẸÊỀỂỄẾỆÌỈĨÍỊÒỎÕÓỌÔỒỔỖỐỘƠỜỞỠỚỢÙỦŨÚỤƯỪỬỮỨỰỲỶỸÝỴ";
    var unsignedChars   = "aaaaaaaaaaaaaaaaadeeeeeeeeeeeiiiiiooooooooooooooooouuuuuuuuuuuyyyyyAAAAAAAAAAAAAAAAADEEEEEEEEEEEIIIIIOOOOOOOOOOOOOOOOOUUUUUUUUUUUYYYYY";
    var pattern = new RegExp("[" + signedChars + "]", "g");
    var output = string.replace(pattern, function (m, key, input) {
        return unsignedChars.charAt(signedChars.indexOf(m));
    });

	// Remove all special characters
	output = output.replace(/[^a-z0-9\s]/gi, '');

	// Replace white space with dash, and lowercase all characters
	output = output.replace(/\s+/g, '-').toLowerCase();

	return output;
}