var csrfToken = function () {
	return window.Laravel.csrfToken;
};

var url = function (append) {
	var base = window.Laravel.baseUrl;
	return base + (append!=null ? '/' + append : '');
};

var array_pluck =  function(array, key) {
	return array.map(function(obj) {
		return obj[key];
	});
}

var strSlug = function (title) {

    //Đổi chữ hoa thành chữ thường
    slug = title.toLowerCase();
 
    //Đổi ký tự có dấu thành không dấu
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    //Xóa các ký tự đặt biệt
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    //Đổi khoảng trắng thành ký tự gạch ngang
    slug = slug.replace(/ /gi, "-");
    //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
    //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    //Xóa các ký tự gạch ngang ở đầu và cuối
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    
    return slug;
}

var fieldNamespace = function (string) {
	if (string.indexOf('.') != -1) {
		string += '.';
		var obj = string.split('.')[0];
		var params = string.match(/\..*\./g)[0];
		var params = params.replace(/^\./, '[');
		var params = params.replace(/\.$/, ']');
		var params = params.replace(/\./g, '][');
		string = obj + params;
	}
	return string;
};

var pageLoading = function () {
	App.blockUI({
		boxed: !0
	});
};

var pageStop = function () {
	App.unblockUI();
};

var ajaxSend = function (event, jqXHR, ajaxOptions) {
	pageLoading();
};

var ajaxSuccess = function (event, jqXHR, ajaxOptions, data) {
	if (data) {
		var notifyTitle = false;
		var notifyMessage = false;
		if (data.hasOwnProperty('title')) {
			notifyTitle = data.title;
		}
		
		if (data.hasOwnProperty('message')) {
			notifyMessage = data.message;
		}

		if(notifyTitle && notifyMessage) {
			notify(notifyTitle, notifyMessage, 'success');
		}
	}
};

var ajaxError = function (event, jqXHR, ajaxSettings, thrownError) {
	var notifyTitle = 'Lỗi';
	var notifyMessage = 'Thao tác không được thực hiện';

	if (jqXHR.hasOwnProperty('responseJSON')) {
		var res = jqXHR.responseJSON;
		if (res.hasOwnProperty('title')) {
			notifyTitle = res.title;
		}

		if (thrownError) {
			notifyMessage = thrownError;
		}

		if (res.hasOwnProperty('message')) {
			notifyMessage = res.message;
		}
	}

	notify(notifyTitle, notifyMessage, 'error');
};

var ajaxComplete = function (event, jqXHR, ajaxOptions) {
	if (jqXHR.hasOwnProperty('responseJSON')) {
		var res = jqXHR.responseJSON;
		// Chuyển hướng trang nếu res
		// có tham số redirect
		if (res.hasOwnProperty('redirect')) {
			window.location = res.redirect;
		}
	}
};

var ajaxStop = function() {
	pageStop();
}

var notify = function (title, message, type) {
	toastr.options.closeButton = true;
	toastr.options.progressBar = true;
	switch (type) {
		case 'success':
			toastr.success(message, title);
			break;

		case 'error':
			toastr.error(message, title);
			break;
	}
};

// form ajax
(function ($) {
	$.fn.handleAjaxForm = function (options) {
		options = $.extend({
		}, options);
		return this.each(function () {
			var object = $(this);
			object.ajaxForm({
				dataType: 'json',
            	method: 'post',
            	beforeSend: function() {
            		$('.error-message', object).remove();
                	$('.has-error', object).removeClass('has-error');
            	},
				success: function (res) {
					if (options.hasOwnProperty('success')) {
						options.success(res);
					}
				},
				error: function (xhr, status, error) {
	                var res = xhr.responseJSON;
	                if (status == 'error') {
	                    $.each(res, function (field, message) {
	                        field = fieldNamespace(field);
	                        if ($('*[name="'+ field +'[]"][type="checkbox"]').length) {
	                            // field là checkbox
	                            $('*[name="'+ field +'[]"]', object)
	                                .closest('.form-group')
	                                .addClass('has-error');

	                            $('*[name="'+ field +'[]"]', object)
	                                .closest('.checkbox-list')
	                                .after('<span class="help-block help-block-error error-message"><strong>'+ message.pop() +'</strong></span>')
	                        } else if ($('*[name="'+ field +'"][type="radio"]').length) {
	                            // field là radio
	                            $('*[name="'+ field +'"]', object)
	                                .closest('.form-group')
	                                .addClass('has-error');

	                            $('*[name="'+ field +'"]', object)
	                                .closest('.radio-list')
	                                .after('<span class="help-block help-block-error error-message"><strong>'+ message.pop() +'</strong></span>')
	                        } else {
	                            // là các ô còn lại
	                            $('*[name="'+ field +'"]', object)
	                                .after('<span class="help-block help-block-error error-message"><strong>'+ message.pop() +'</strong></span>')
	                                .closest('.form-group')
	                                .addClass('has-error');
	                        }
	                    });
	                }
	            },
			});
		});
	};
})(jQuery);

// handleBootstrapRemote
(function ($) {
	$.fn.handleBootstrapRemote = function (options) {
		options = $.extend({

		}, options);
		return this.each(function () {
			var object = $(this);
			object.on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var name = $(this).attr('data-name');
				if (url && name) {
					$.ajax({
						type: 'GET',
						url: url,
						dataType: 'html',
						success: function (res) {
							$(name).remove();
							$('body').append(res);
							$(name).modal('show');
						}
					});
				}
			});
		});
	};
})(jQuery);

// media box
(function ($) {
	$.fn.handleMediaBox = function (options) {
		options = $.extend({

		}, options);
		return this.each(function () {
			var object = $(this);
			var PopupFileBrowser = function () {
				var html;
				var options;
				return {
					create: function (options1) {
						options = $.extend({
							id: 'file-browser'
						}, options1);
						html = '<div class="modal fade" id="'+ options.id +'">'
						+'<div class="modal-dialog" style="min-width:1000px">'
						+'<div class="modal-content">'
						+'<div class="modal-body" style="padding:0">'
						+ '<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="'+ url('/admin/file/elfinder/stand-alone') +'"></iframe></div>'
						+'</div>'
						+'</div>'
						+'</div>'
						+'</div>';
						return this;
					},

					show: function () {
						this.close();
						$('body').append(html);
						$('#'+options.id).modal('show');
					},

					close: function () {
						$('#'+options.id).modal('hide');
					},
				}
			};
			var fileBrowser = new PopupFileBrowser();
			fileBrowser.create();
			$(object).on('click', '.open-file-broswer', function (e) {
				e.preventDefault();
				document.fileBrowser = $.extend(fileBrowser, {
					container: $(this).closest('.media-box-group'),
					from: 'popup',
				});
				fileBrowser.show();
			});
		});
	};
})(jQuery);

// table function
(function ($) {
	$.fn.handleTableFunction = function (options) {
		options = $.extend({

		}, options);
		return this.each(function () {
			var object = $(this);

			$(object).on('ifChanged', '.check-all', function () {
				var checkbox = $('tbody tr td input[type="checkbox"], .check-all', object);
				if ($(this).is(':checked')) {
					checkbox.iCheck('check');
				} else {
					checkbox.iCheck('uncheck');
				}
			});

			$(object).on('click', '.btn-apply', function (e) {
				e.preventDefault();
				var current = $(this).closest('.apply-action');
				var action = $('.multiple-function', current).val();
				if (!action) {
					return false;
				}
				var option = $('.multiple-function>option[value="'+action+'"]', current);
				var method = option.attr('data-method');
				var func = option.attr('data-function');
				var id = [];
				$.each($('tbody input[type="checkbox"]:checked'), function (i, item) {
					id[i] = $(item).val();
				});

				if (method == 'delete' || option.attr('data-message')) {
					var message = 'Bạn có chắc muốn thực hiện hành động này';
					if ($(this).attr('data-message')) {
						message = $(this).attr('data-message');
					}

					if (! confirm(message)) {
						return false;
					}
				}

				if (id.length!=0) {
					$.ajax({
						url: action,
						method: method,
						data: {
							_token: csrfToken(),
							_method: method,
							id: id,
						},
						success: function (res) {
							if (res.hasOwnProperty('success_id')) {
								$.each(res.success_id, function (i,id_item) {
									var checkbox = $('tbody tr td input[type="checkbox"][value="'+id_item+'"]', object);
									checkbox.prop('checked', false);
									var tr = checkbox.closest('tr');
									tr.fadeOut(400);
								});
							}

							if (res.hasOwnProperty('error_id')) {
								$.each(res.error_id, function (i, id_item) {
									var checkbox = $('tbody tr td input[type="checkbox"][value="'+id_item+'"]', object);
									checkbox.prop('checked', false);
									var tr = checkbox.closest('tr');
									tr.addClass('bounce animated bg-danger').delay(2000).queue(function () {
										$(this).removeClass('bounce animated bg-danger');  
									});
								});
							}
						},
					});
				}
			});

			$('*[data-function]', object).click(function (e) {
				e.preventDefault();
				var func = $(this).attr('data-function');
				var action = $(this).attr('href');
				var method = $(this).attr('data-method');
				var tr = $(this).closest('tr');

				if (method == 'delete' || $(this).attr('data-message')) {
					var message = 'Bạn có chắc muốn thực hiện hành động này';
					if ($(this).attr('data-message')) {
						message = $(this).attr('data-message');
					}

					if (! confirm(message)) {
						return false;
					}
				}

				$.ajax({
					url: action,
					method: method,
					data: {
						_token: csrfToken(),
						_method: method,
					},
					success: function (res) {
						tr.fadeOut(400);
					},
					error: function (xhr, status, error) {
						tr.addClass('bounce animated bg-danger').delay(1000).queue(function () {
							$(this).removeClass('bounce animated bg-danger');  
						});
					},
				});
			});
		});
	};
})(jQuery);

// tiny mce
(function ($) {
	$.fn.handleTinyCMCE = function (options) {
		options = $.extend({

		}, options);
		return this.each(function () {
			var object = $(this);
			options = $.extend({
				selector: "*[class=\""+ object.context.className +"\"]",
				theme: "modern",
				skins: "metronic",
				height: 300,
				plugins: [
				"advlist autolink link image lists charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
				"table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
				],
				toolbar1: "bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | styleselect | link unlink | image media | forecolor backcolor | preview code ",
				image_advtab: true ,
				file_browser_callback: elFinderBrowser,
				setup: function (editor) {
					editor.on('change', function () {
						tinymce.triggerSave();
					});
				},
			}, options);


			if (options.hasOwnProperty('switch_toolbar')) {  
				switch(options.switch_toolbar) {
					case 'base': 
					options.toolbar1 = 'bold italic underline | alignleft aligncenter alignright | bullist numlist | styleselect | link unlink | image | forecolor backcolor ';
					options.menubar = false;
					break;

					case 'advance':
					options.toolbar1 = 'bold italic underline | alignleft aligncenter alignright | bullist numlist | styleselect | link unlink | image | forecolor backcolor ';
					break;
				}
			}

			function elFinderBrowser (field_name, url1, type, win) {
				tinymce.activeEditor.windowManager.open({
					file: url('admin/file/elfinder/stand-alone'),
					title: 'Add media',
					width: 1000,  
					height: 563,
					resizable: 'yes'
				}, {
					setUrl: function (url) {
						win.document.getElementById(field_name).value = url;
					}
				});
				return false;
			};

			tinymce.init(options);
		});
	};
})(jQuery);

jQuery(document).ready(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': csrfToken(),
		},
	});
	
	$(document)
		.bind('ajaxSend', function (event, jqXHR, ajaxOptions) {
			ajaxSend(event, jqXHR, ajaxOptions);
		})
		.bind('ajaxSuccess', function (event, jqXHR, ajaxOptions, data) {
			ajaxSuccess(event, jqXHR, ajaxOptions, data);
		})
		.bind('ajaxError', function (event, jqXHR, ajaxSettings, thrownError) {
			ajaxError(event, jqXHR, ajaxSettings, thrownError);
		})
		.bind('ajaxComplete', function (event, jqXHR, ajaxOptions) {
			ajaxComplete(event, jqXHR, ajaxOptions);
		})
		.bind('ajaxStop', function () {
			ajaxStop();
		});


	$('body').handleMediaBox();
	$('.ajax-form, *[ajax-form-container]').handleAjaxForm();
	$('*[remote-modal]').handleBootstrapRemote();
	$('.texteditor').handleTinyCMCE();
	$('*[table-function-container]').handleTableFunction();
	$('.table-function-container').handleTableFunction();
});