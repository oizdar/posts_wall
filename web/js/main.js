$('#form-container').load('static/postForm.html');

$.ajax({
    type: 'GET',
    url: '/api',
    success: function (res) {
        if(res.code === 'OK') {
             posts = new Posts(res.data);
             posts.showAll();
        }
    },
    error: function (error) {
        postsData = JSON.parse(error.responseText).data.error;
    }
});


