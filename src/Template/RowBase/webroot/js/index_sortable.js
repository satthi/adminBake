$(function(){
    $("#sortable tbody").sortable({
        placeholder: 'placeholder',
        opacity : 0.3,
        revert : 100,
        start : function(e, drag){
            // ドラッグ中placeholderの高さが０になってしまうのでドラッグアイテムと同じサイズにする
            $('.placeholder').height($(drag.item).css('height'));
        },
        stop : function(e, drag){
            // 一覧の上から順にhidden値を収集しデータを生成する
            // 送信データの書式はcakeに準拠した形式とする
            var data = {};
            var counter = 0;
            $('#sortable tr').each(function(){
                counter++;
                data[counter] = $(this).data('id');
            });

            // ajaxで生成したデータを飛ばして並び順を更新させる
            $.ajax({
                type: 'POST',
                url: Pack.ajaxUrl,
                data: data
            }).done(function(msg){
                if (msg['message'] != '') {
                    alert(msg['message']);
                }
            });
        }
    });
    $("#sortable tbody").disableSelection();
});
