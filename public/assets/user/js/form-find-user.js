'use strick';

var findUser = function(options) {
    var placeholder = options.placeholder ? options.placeholder : 'Select a State';
    $.fn.select2.defaults.set("theme", "bootstrap");
    
    $(".select2-allow-clear").select2({
        allowClear: false,
        width: null
    });
    
    function formatRepo(repo) {
        if (repo.loading)
            return repo.text;
        
        return '<div class="select2-result-repository clearfix">'
                +'<div class="select2-result-repository__avatar"><img src="'+(repo.avatar ? repo.avatar : defaultAvatar)+'" /></div>'
                +'<div class="select2-result-repository__meta">'
                    +'<div class="select2-result-repository__title">'+repo.last_name+' '+repo.first_name+'</div>'
                    +'<div class="select2-result-repository__statistics">'
                        +'<div class="select2-result-repository__forks"><span class="glyphicon glyphicon glyphicon-calendar"></span> NS: '+repo.birth+'</div>'
                        +'<div class="select2-result-repository__stargazers"><span class="glyphicon glyphicon-phone"></span> SDT: '+repo.phone+'</div>'
                        +'<div class="select2-result-repository__watchers"><span class="fa fa-envelope"></span> Email: ' + repo.email + '</div>'
                    +'</div>'
                +'</div>'
            +'</div>';
    }

    function formatRepoSelection(repo) {
        if (repo.hasOwnProperty('last_name') && repo.last_name.trim()) {
            return repo.last_name+' '+repo.first_name;    
        }
        return repo.text;
    }

    $(options.el).select2({
        minimumInputLength: 3,
        allowClear: true,
        width: "off",
        
        placeholder: {
            placeholder: placeholder,
        },
        
        ajax: {
            url: options.url,
            dataType: 'json',
            delay: 1000,
            data: function(params) {
                return {
                    _keyword: params.term,
                    page: params.page
                };
            },
            processResults: function(data, page) {
                return {
                    results: data
                };
            },
            cache: true,
        },

        escapeMarkup: function(markup) {
            return markup;
        },

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

    $(".select2, .select2-multiple, .select2-allow-clear,"+options.el).on("select2:open", function() {
        if ($(this).parents("[class*='has-']").length) {
            var classNames = $(this).parents("[class*='has-']")[0].className.split(/\s+/);

            for (var i = 0; i < classNames.length; ++i) {
                if (classNames[i].match("has-")) {
                    $("body > .select2-container").addClass(classNames[i]);
                }
            }
        }
    });

};