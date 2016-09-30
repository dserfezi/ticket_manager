$j(function($) {
    $('.js-ticket-actions').on('click', '.js-ticket-action', function (e) {
        e.preventDefault();
        var dis = $(this);
        //var ticketId = $(this).closest('tr').find('.js-ticket-id').html();
        var action = dis.data('action');

        if (confirm("Do you really want to " + action + " this ticket?")) {

            /*$.get('ticket_manager/' + action + '/id/' + ticketId, function (data) {
                console.log(data);
            }, 'json');*/
            $.get(dis.attr('href'), function (data) {
                //console.log(data);
                switch (action) {
                    case 'close':
                        if(data.success){
                            dis.closest('tr').find('.js-ticket-status').html('Resolved').attr('style','color:green;');
                            dis.closest('span').remove();
                        }
                        break;
                    case 'delete':
                        dis.closest('tr').fadeOut(400, function () {
                            dis.remove();
                        });
                        break;
                    default:
                        // Do nothing
                }
            }, 'json');

        } else {

            e.preventDefault();

        }
    });
});