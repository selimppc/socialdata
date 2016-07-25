<script type="text/javascript">
    $(function(){
        $('.publishLaterBtn').click(function(){
            var date= $('#date').val();
            var time= $('#time').val();
            if(date == '')
            {
                $('#dateRequired').show();
                return false;
            }else{
                $('#dateRequired').hide();
            }
            if(time == '')
            {
                $('#timeRequired').show();
                return false;
            }else{
                $('#timeRequired').hide();
            }
            return true;
        });
    });
</script>