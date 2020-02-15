/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var page_newBlock = function () {
    function formatState(repo) {
        console.log(repo);
        if (!repo.id) {
            return repo.text;
        }
        var $state = $('<span>' + repo.full_name + '</span>');
        return $state;
    }

    function formatRepoSelection(repo) {
        return repo.full_name || repo.text;
    }
    function formatRepo(repo) {
        console.log(repo)
        if (repo.loading)
            return repo.text;
        var markup = "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__avatar'></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" + repo.full_name + "</div>";
        if (repo.description) {
            markup += "<div class='select2-result-repository__description'>" + repo.description + "</div>";
        }

        markup += "<div class='select2-result-repository__statistics'>" +
                "<div class='select2-result-repository__forks'><span class='glyphicon glyphicon-flash'></span> " + repo.forks_count + " Forks</div>" +
                "<div class='select2-result-repository__stargazers'><span class='glyphicon glyphicon-star'></span> " + repo.stargazers_count + " Stars</div>" +
                "<div class='select2-result-repository__watchers'><span class='glyphicon glyphicon-eye-open'></span> " + repo.watchers_count + " Watchers</div>" +
                "</div>" +
                "</div></div>";
        return markup;
    }







    var select_blog_category = function () {
        if (App.isAngularJsApp() === false) {
            var placeholder = "Yazı Kategorisini Seçin";
            var $select = $('[data-filter="select_block_category"]')

            $select.select2({
                placeholder: placeholder,
                width: null,
                language: "tr",
                addTag: false,
                maximumSelectionLength: 1,
                ajax: {
                    url: 'https://api.github.com/search/repositories',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            q: params.term,
                        }
                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data.items
                        };
                    }
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                escapeMarkup: function (markup) {

                    return markup;
                },
                templateResult: formatState,
                templateSelection: formatRepoSelection,
            })
            $select.on("select2:select", function (e) {
                console.log(e.params.data.id + " - " + e.params.data.name)
            });
        }


    }




    return {
        init: function () {
            select_blog_category(); // handle adres Blok
        }
    }
}();


jQuery(document).ready(function () {
    page_newBlock.init(); // init metronic core componets
});