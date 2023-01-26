<script type="text/javascript">
    @if($errors->count())
    $.notify({
            icon: 'icon flaticon-warning-sign',
            message: "{{ Session::get('danger') }}"

        },{
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: true,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            spacing: 10,
            z_index: 10000,
            delay: 5000,
            timer: 1000,
            offset: {
                x: 30,
                y: 30
            },
            animate: {
                enter: 'animate__animated animate__bounce',
                exit: 'animate__animated animate__bounce'
            }
        });
    @elseif(Session::has('danger'))
        $.notify({
            icon: 'fa fa-bell-o',
            title: 'Error Occurred',
            message: "{{ Session::get('danger') }}"

        },{
            element: 'body',
            position: null,
            type: "danger",
            allow_dismiss: true,
            newest_on_top: true,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            spacing: 10,
            z_index: 10000,
            delay: 5000,
            timer: 1000,
            offset: {
                x: 30,
                y: 30
            },
            animate: {
                enter: 'animate__animated animate__bounce',
                exit: 'animate__animated animate__bounce'
            }
        });
        
    @elseif(Session::has('info'))
    $.notify({
            icon: 'fa fa-check',
            title: 'Info',
            message: "{{ Session::get('info') }}"

        },{
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: true,
            showProgressbar: false,
            placement: {
                from: "top",
                align: "right"
            },
            spacing: 10,
            z_index: 10000,
            delay: 5000,
            timer: 1000,
            offset: {
                x: 30,
                y: 30
            },
            animate: {
                enter: 'animate__animated animate__bounce',
                exit: 'animate__animated animate__bounce'
            }
        });
    @elseif(Session::has('success'))
        $.notify({
                icon: 'fa fa-check',
                title: 'Success',
                message: "{{ Session::get('success') }}"

            },{
                element: 'body',
                position: null,
                type: "success",
                allow_dismiss: true,
                newest_on_top: true,
                showProgressbar: false,
                placement: {
                    from: "top",
                    align: "right"
                },
                spacing: 10,
                z_index: 10000,
                delay: 5000,
                timer: 1000,
                offset: {
                    x: 30,
                    y: 30
                },
                animate: {
                    enter: 'animate__animated animate__bounce',
                    exit: 'animate__animated animate__bounce'
                }
            });
    @endif
</script>
