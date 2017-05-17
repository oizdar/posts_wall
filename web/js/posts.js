class Posts {
    constructor(data) {
        this.data = data;
        this.prefix = 'post-';
        this.postContainerHtml = '<div class="panel panel-info"></div>';
        this.panelHeading = '<div class="panel-heading"></div>';
        this.panelTitle = '<h5 class="panel-title "></h5>';
        this.panelButtons = '<div class="btn-group-xs text-right"><a class="btn btn-default" id="edit-post">Edit »</a> <a class="btn btn-success" id="add-post-comment">Add Comment »</a></div>';
        this.panelBody = '<div class="panel-body"></div>';
        this.postContent = '<div class="post-content text-justify" id="post-content"></div>';
        this.postCommentsContainer = '<div class="col-xs-offset-2 col-xs-10"></div>';
        this.like = '<span class="glyphicon glyphicon-thumbs-up"></span>';
        this.badge = '<span class="badge"></span>';

    }

    showAll() {
        if(this.data.length < 10) {
            let button = $('#load-more-posts');
                button.text('All posts loaded');
                button.addClass('disabled');
        }

        this.data.forEach(function(post) {
           this.showOne(post)
        }.bind(this));
    }

    parseContent(content) {
        return ContentParser.parseLinks(content);
    }

    showComments(postId, comments) {
            let commentsContainerId = 'comments-' + postId;
            this.commentsList = new Comments(commentsContainerId, comments);
            this.commentsList.showComments();
    }

    showAddCommentForm(postId) {
        self = this;
        return function() {
            if($('#comments-form-' + postId).length === 0) {
                let commentsContainerId = '#comments-' + postId + '> ul ';
                let emptyElement = commentsContainerId + ' .empty';
                if($(emptyElement).length) {
                   $(emptyElement).remove();
                }
                let element = self.commentsList.createCommentForm(postId);
                $(commentsContainerId).prepend(element);
            }
        }
    }

    showOne(post, before = false) {
        let postId = this.prefix + post.id;
        let postElement = $(this.postContainerHtml).attr('id', postId);
        let title = ' <strong>' + post.user + ':</strong> '
            + new Date(post.create_date).toLocaleString();

        let panelButtons = $(this.panelButtons);
        panelButtons.find('#edit-post').attr('id', 'edit-'+postId).attr('onclick', 'insertEditData(this)');
        panelButtons.find('#add-post-comment').attr('id', 'add-post-comment-'+postId).on('click', this.showAddCommentForm(postId));
        let likesBadge = $(this.badge).text(post.likes);
        let panelTitle = $(this.panelTitle).append(this.like).append(likesBadge).append(title).append(panelButtons);
        let panelHeading = $(this.panelHeading).append(panelTitle);
        postElement.append(panelHeading);

        let postContent = $(this.postContent).html(this.parseContent(post.content));
        postContent.append($(this.postCommentsContainer).attr('id', 'comments-'+postId));
        let panelBody = $(this.panelBody).append(postContent);
        postElement.append(panelBody);
        if(before) {
            postElement.fadeIn('slow');
            $('#posts-container').prepend(postElement);
            $(':input', '#publish-post-form').val('');

        } else {
            $('#posts-container').append(postElement);
        }

        this.showComments(postId, post.comments);
    }
}
