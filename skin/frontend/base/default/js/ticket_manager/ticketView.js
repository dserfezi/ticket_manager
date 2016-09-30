$j(function($) {
    $('.js-save-reply').on('click', function (e) {
        e.preventDefault();
        var wrapper = $(this).closest('div');
        var ticketId = wrapper.find('.js-ticket-id').val();
        var reply = wrapper.find('#reply').val();

        $.post(
            wrapper.closest('form').attr('action'),
            {
                'ticketId' : ticketId,
                'reply' : reply
            },
            function (data) {
                if(data.success){
                    wrapper.closest('form')[0].reset();
                    var ticketReply = '<div class="ticket-reply" style="border-bottom:1px solid #ededed;margin-bottom:20px;">';
                    ticketReply += '<div style="text-align:right;">';
                    ticketReply += '<span>' + data.customer + '</span>';
                    ticketReply += '<span>' + data.timestamp + '</span>';
                    ticketReply += '</div>';
                    ticketReply += '<div>' + data.reply + '</div>';
                    ticketReply += '</div>';
                    $('.ticket-replies').append(ticketReply);
                }
            }, 'json'
        );
    });
});