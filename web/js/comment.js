class Comments {
    constructor(postCommentsContainerId, commentsData) {
        this.commentsContainerId = postCommentsContainerId;
        this.commentsData = commentsData;
        this.commentsList = '<ul class="list-group"></ul>';
        this.commentsElement = '<li class="list-group-item"></li>';
        this.commentContent = '<div class="comment-body">Not found any comments.</div>';
        this.commentFooter = '<h5 class="text-info text-right comment-header"></h5>';
        this.like = ' <span class="glyphicon glyphicon-thumbs-up"></span>';
        this.badge = '<span class="badge"></span>';
        $('#' + this.commentsContainerId).append(this.commentsList);
    };


    showComments() {
        const commentsList = '#' + this.commentsContainerId + ' > ul';
        let element;
        if(this.commentsData.length === 0) {
            element = this.createEmpty();
            $(commentsList).append(element);
        } else {
            this.commentsData.forEach(function(comment) {
                element = this.createComment(comment);
                $(commentsList).append(element);
            }.bind(this));
        }
    }

    createComment(comment) {
        let commentId = 'comment-'+comment.id;
        let element = $(this.commentsElement).attr('id', commentId);
        element.append($(this.commentContent).html(this.parseContent(comment.content)));

        let footerHtml = '<strong>'+comment.user+':</strong> ' + new Date(comment.create_date).toLocaleString();
        let likesBadge = $(this.badge).text(comment.likes);
        element.append($(this.commentFooter).append(footerHtml).append(likesBadge).append(this.like));
        return element;
    }

    createEmpty() {
        let element = $(this.commentsElement).addClass('empty');
        element.append($(this.commentContent));
        element.append(this.commentFooter);
        return element;
    }

    parseContent(content) {
        return ContentParser.parseLinks(content);
    }

    createCommentForm(postId) {
        let element = $(this.commentsElement).attr('id', 'comments-form-'+postId);
        element.load('static/commentForm.html');
        element.fadeIn('slow');
        return element;
    }

}

