<script src="js/bootstrap-notify.js" type="text/javascript"></script>
@if(Session::has('error'))
<script>
    $.notify({
        message: "{{Session::get('error')}}"
    },{
        type: 'danger',
        offset: 50,
        placement: {
            from: "bottom",
            align: "right"
        },
    });
 </script>
@endif 

@if(Session::has('success'))
<script>
    $.notify({
        message: "{{Session::get('success')}}"
    },{
        type: 'success',
        offset: 50,
        placement: {
            from: "bottom",
            align: "right"
        },
    });
 </script>
@endif 