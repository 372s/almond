<script src=".././js/jquery/jquery-1.11.3.min.js"></script>
<script>
    // 测试跨域请求
    $.post(
        'http://dev.local.test/api.test.php',
        {
            name: 'wangqiang',
            token: '8888999'
        },
        function(d) {
            console.log(d)
        },
        'json'
    );

    // 测试判断ajax请求
    $.getJSON(
        'check_ajax_request.php',
        function(d) {
            console.log(d)
        }
    );

    
    $.post(
        'http://api.medlive.test/sms/custom_sms_send.php',
        {
            name: 'wangqiang',
            token: '8888999'
        },
        function(d) {
            console.log(d)
        },
        'json'
    );
</script>