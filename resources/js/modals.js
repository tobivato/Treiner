let ajaxLoaded = false;
let current_fs, next_fs, previous_fs; //fieldsets
let jobPlaces;

addModalEventListener();

$('').on('shown.bs.modal', setModalBindings(''));

$(window).on('load',function(){
    $('#review-modal').modal('show');
});

if(window.location.hash == '#create-job-post') {
    loadModal('jobs/create');
}

function addModalEventListener() {
    $('.post-job').on("click", function(e) {
        e.preventDefault();
        loadModal('jobs/create');
    });

    $('.request-session').on("click", function(e) {
        e.preventDefault();
        loadModal('jobs/request-session/' + $(this).data("coach-id"));
    });
};

function loadModal(url) {
    if ("ga" in window) {
        ga('send', 'pageview', '/jobs/create')
    }
        
    if (!ajaxLoaded) {    
        fetch(window.baseUrl + url, {
            headers: { 
                "Content-Type": "application/json; charset=utf-8",
                "X-Requested-With": "XMLHttpRequest",
            },
        })
        .then(function (res) {
            if (res.status != 200) {
                window.location = window.baseUrl + 'login';
            }
            return res;
        })
        .then(res => res.text())
        .then(html => {
            document.body.innerHTML += html;
            $('#postJob').modal();
            ajaxLoaded = true;
            
            $(document).trigger("ModalLoad");

            $('#job-post-title').select2({
                theme: "bootstrap4",
                placeholder: $('#job-post-title').attr('data-placeholder'),
                allowClear: false,
                tags: true,
            });

            $('.job-addable').click(function() {
                $('#job-textarea').html($(this).html());
            });
            
            jobPlaces = places({
                appId: 'plX2RRT8OCW8',
                apiKey: 'c72d462e77bb408272bc43c7a68f9356',
                container: document.querySelector('#job-location')
                }).configure({
                countries: ['au', 'nz', 'my', 'sg', 'us', 'ca', 'hk'],
            });           

            document.querySelector('#job-location').setCustomValidity('You must choose a location from the list.');

            jobPlaces.on('clear', function() {
                document.querySelector('#latitude').value = '';
                document.querySelector('#longitude').value = '';
                document.querySelector('#locality').value = '';
                document.querySelector('#country').value = '';
            });

            jobPlaces.on('change', function resultSelected(e) {                
                document.querySelector('#latitude').value = e.suggestion.latlng.lat || '';
                document.querySelector('#longitude').value = e.suggestion.latlng.lng || '';
                document.querySelector('#locality').value = e.suggestion.name || '';
                document.querySelector('#country').value = e.suggestion.country || '';

                if (document.querySelector('#latitude').value == '' || document.querySelector('#longitude').value == '')
                {                    
                    document.querySelector('#job-location').setCustomValidity('You must choose a location from the list.');
                }
                else {                    
                    document.querySelector('#job-location').setCustomValidity('');
                }

                let valid = !(document.querySelector('#job-location').checkValidity());
                let next = $('#' + $('#job-location').data('next'));
                next.attr('disabled', valid);    
            });

            setModalBindings();
        })
        .catch(err => {
            console.error(err);
        });
    }
    else {
        $('#postJob').modal('show');
        setModalBindings();
    }
}

function setModalBindings(url = '/jobs/create/stage/') {
    $(document).on("keydown", ":input:not(textarea)", function(event) {
        if (event.key == "Enter") {
            event.preventDefault();
        }
    });
      
    document.querySelectorAll('[data-length-indicator]').forEach(element => {
        element.oninput = function() {
            let length = element.value.length;        
            let indicator = document.getElementById(element.dataset.lengthIndicator);        
            indicator.innerHTML = element.maxLength - length;
        };
    });

    $('#postJob').on('hidden.bs.modal', addModalEventListener);

    $(".next").click(function (e) {        
        e.preventDefault();
        current_fs = $(this).parents('fieldset');
        next_fs = $(this).parents('fieldset').next();
    
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($(".fieldsetStep").index(next_fs)).addClass("active");
        
        console.log(url + next_fs.data("name"));
        
        if ("ga" in window) {
            ga('send', 'pageview', url + next_fs.data("name"))
        }        
    
        next_fs.show();
        current_fs.hide();
    });

    $(".previous").click(function (e) {
        e.preventDefault();
        current_fs = $(this).parents('fieldset');
        previous_fs = $(this).parents('fieldset').prev();
        
        //de-activate current step on progressbar
        $("#progressbar li").eq($(".fieldsetStep").index(current_fs)).removeClass("active");
        
        console.log(url + previous_fs.data("name"));
        
        if ("ga" in window) {
            ga('send', 'pageview', url + previous_fs.data("name"))
        }
        previous_fs.show();
        current_fs.hide();
    });

    $('input,select,textarea').each(function () {
        $(this).on('input change', function() {
            let valid = !(this.checkValidity());
            let next = $('#' + $(this).data('next'));
            next.attr('disabled', valid);
        });
    });
}