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
    let postForm = $('#publish-post-form');
    if(postForm[0].checkValidity()) {
        let url = '/api/post';
        let postId = postForm.find('#post-id').val();
        console.log(postId);
        if(postId) {
            url = url + '/' + postId;
        }
        let basic ='Basic '+  btoa(postForm.find('#login').val()+':'+postForm.find('#password').val());
        $.ajax({
            method: 'POST',
            url: url,
            data: {
                content: postForm.find('#post-content').val(),
            },
            headers: {
                'Authorization': basic
            },
            success: function(res) {
                if(res.code === 'OK') {
                    let alert = $('#post-form-alert');
                    alert.removeClass('hidden');
                    alert.removeClass('alert-danger');
                    alert.addClass('alert-success');
                    alert.html('<strong>'+res.data.message+'</strong>');
                    let postsObj = new Posts({});
                    if(!postId) {
                        postsObj.showOne(res.data.post, true);
                    } else {
                        console.log(res);
                    }
                }
            },
            error: function (error) {
                let response = JSON.parse(error.responseText);
                let alert = $('#post-form-alert');
                alert.removeClass('hidden');
                alert.removeClass('alert-success');
                alert.addClass('alert-danger');
                alert.html('<strong>'+response.data.error+'</strong>');
            }
        });
        if(!postId) {
            return false;
        }
    }

}

function insertEditData(button) {
    let postId = button.id.split('-').pop();
    let post = $('#post-'+postId);

    let postContent = post.find('.post-content').contents().get(0).nodeValue;
    let postUsername = post.find('.panel-title strong').text().slice(0, -1);

    let postForm = $('#publish-post-form');
    postForm.find('#post-id').val(postId);
    postForm.find('#post-content').val(postContent);
    postForm.find('#login').val(postUsername);
    postForm.find('#password').val('');
    $('html body').animate({scrollTop: 0}, 'slow');
}
