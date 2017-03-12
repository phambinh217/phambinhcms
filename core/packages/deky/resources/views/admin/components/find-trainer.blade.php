@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/select2/css/select2.min.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset_url('admin', 'global/plugins/select2/css/select2-bootstrap.min.css') }}" />
@endpush

@push('js_footer')
	<script type="text/javascript" src="{{ asset_url('admin', 'global/plugins/select2/js/select2.full.min.js') }}"></script>
	<script type="text/javascript">
		$(function(){
			var ComponentsSelect2Trainer = function() {

			    var handleFindtrainer = function() {

			        $.fn.select2.defaults.set("theme", "bootstrap");

			        var placeholder = "Select a State";

			        $(".select2-allow-clear").select2({
			            allowClear: true,
			            placeholder: placeholder,
			            width: null
			        });

			        function formatRepo(repo) {
			            if (repo.loading) return repo.text;

			            var markup = "<div class='select2-result-repository clearfix'>";
			            
			            if(repo.avatar != 'null') {
				            markup += "<div class='select2-result-repository__avatar'><img src='" + "{{ url(setting('default-avatar')) }}" + "' /></div>";
			            } else {
			            	markup += "<div class='select2-result-repository__avatar'><img src='" + repo.avatar + "' /></div>";
			            }
				        
				        markup += "<div class='select2-result-repository__meta'>" +
				        "<div class='select2-result-repository__title'>" + repo.last_name + " " + repo.first_name  +  "</div>";

			            markup += "<div class='select2-result-repository__statistics'>" +
			                "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon glyphicon-calendar'></span> NS " + repo.birth + " Forks</div>" +
			                "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-phone'></span> SDT " + repo.phone + "</div>" +
			                "<div class='select2-result-repository__watchers'><span class='fa fa-envelope'></span> Email " + repo.email + "</div>" +
			                "</div>" +
			                "</div></div>";

			            return markup;
			        }

			        function formatRepoSelection(repo) {
			            return repo.last_name + repo.first_name || repo.text;
			        }

			        $(".find-trainer").select2({
			        	allowClear: true,
			        	placeholder: {
						    id: '',
						    placeholder: placeholder,
						},
			            width: "off",
			            ajax: {
			                url: "{{ api_url('v1/trainer') }}",
			                dataType: 'json',
			                delay: 250,
			                data: function(params) {
			                    return {
			                        _keyword: params.term, // search term
			                        page: params.page
			                    };
			                },
			                processResults: function(data, page) {
			                    // parse the results into the format expected by Select2.
			                    // since we are using custom formatting functions we do not need to
			                    // alter the remote JSON data
			                    return {
			                        results: data
			                    };
			                },
			                cache: true
			            },
			            escapeMarkup: function(markup) {
			                return markup;
			            }, // let our custom formatter work
			            minimumInputLength: 1,
			            templateResult: function(item) {
						    if (item.placeholder) {
						    	return item.placeholder;	
						    }
						    return formatRepo(item);
						},
			            templateSelection: function (item) {
						    if (item.placeholder) {
						    	return item.placeholder;
						    }

						    return formatRepoSelection(item);
						}
			        });

			        $("button[data-select2-open]").click(function() {
			            $("#" + $(this).data("select2-open")).select2("open");
			        });

			        $(":checkbox").on("click", function() {
			            $(this).parent().nextAll("select").prop("disabled", !this.checked);
			        });

			        // copy Bootstrap validation states to Select2 dropdown
			        //
			        // add .has-waring, .has-error, .has-succes to the Select2 dropdown
			        // (was #select2-drop in Select2 v3.x, in Select2 v4 can be selected via
			        // body > .select2-container) if _any_ of the opened Select2's parents
			        // has one of these forementioned classes (YUCK! ;-))
			        $(".select2, .select2-multiple, .select2-allow-clear, .find-trainer").on("select2:open", function() {
			            if ($(this).parents("[class*='has-']").length) {
			                var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

			                for (var i = 0; i < classNames.length; ++i) {
			                    if (classNames[i].match("has-")) {
			                        $("body > .select2-container").addClass(classNames[i]);
			                    }
			                }
			            }
			        });

			        $(".js-btn-set-scaling-classes").on("click", function() {
			            $("#select2-multiple-input-sm, #select2-single-input-sm").next(".select2-container--bootstrap").addClass("input-sm");
			            $("#select2-multiple-input-lg, #select2-single-input-lg").next(".select2-container--bootstrap").addClass("input-lg");
			            $(this).removeClass("btn-primary btn-outline").prop("disabled", true);
			        });
			    }

			    return {
			        //main function to initiate the module
			        init: function() {
			            handleFindtrainer();
			        }
			    };

			}();
			ComponentsSelect2Trainer.init();
		});
	</script>
@endpush