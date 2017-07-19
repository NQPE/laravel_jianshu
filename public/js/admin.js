$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/**
 * 文章审核是否通过的ajax
 */
$(".post-audit").click(function (event) {
    var target = $(event.target);
    var post_id = target.attr('post-id');
    var post_action_status = target.attr('post-action-status');
    $.ajax(
        {
            url: '/admin/posts/status/' + post_id,
            method: 'POST',
            data: {"status": post_action_status},
            dataType: 'json',
            success: function (data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.parent().parent().remove();
            }
        }
    );
});
/**
 * 删除专题的ajax
 */
$(".resource-delete").click(function (event) {
    if(!confirm("确认删除吗？")){
        return false;
    }
    var target = $(event.target);
    var delete_url = target.attr('delete-url');
    $.ajax(
        {
            url: delete_url,
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.error != 0) {
                    alert(data.msg);
                    return;
                }

                target.parent().parent().remove();
            }
        }
    );
});