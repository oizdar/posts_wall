function toggleRegisterForm() {
    $('#form-container').fadeOut('slow', function() {
        $('#form-container').load('static/registerForm.html', function() {
            $('#form-container').fadeIn('slow');
        });
    });
}

function togglePostForm() {
    $('#form-container').fadeOut('slow', function() {
        $('#form-container').load('static/postForm.html', function() {
            $('#form-container').fadeIn('slow');
        });
    });
}

function publishPost() {
    if($('#publish-post-form')[0].checkValidity()) {
        let basic ='Basic '+  btoa($('#publish-post-form #login').val()+':'+$('#publish-post-form #password').val());
        $.ajax({
            method: 'POST',
            url: '/api/post',
            data: {
                content: $('#publish-post-form #post-content').val(),
            },
            headers: {
                'Authorization': basic
            },
            success: function(res) {
                if(res.code === 'OK') {
                    let alert = $('#post-form-alert');
                    alert.removeClass('hidden');
                    alert.addClass('alert-success');
                    alert.html('<strong>'+res.data.message+'</strong>');
                    let postsObj = new Posts({});
                    postsObj.showOne(res.data.post, true);
                }
                return false;
            },
            error: function (error) {
                console.log(error);
                let response = JSON.parse(error.responseText);
                let alert = $('#post-form-alert');
                alert.removeClass('hidden');
                alert.addClass('alert-danger');
                alert.html('<strong>'+response.data.error+'</strong>');
                return false;
            }
        });
    } else console.log("invalid form");
}

