<form>
    <input id="id" type="text" value="0">
    <input id="name" type="text" value="5">
    <input id="test" type="submit">
</form>
<script>
    $("#test").on('click',function(){
        $.ajax({
            type: "POST",
            url: "http://www.inwebo.dev/libremvc/post/",
            data:{
                id : $("#id").val(),
                name:$('#name').val()

            }/*,
            headers: {
                Accept : "application/json",
                "Content-Type": "application/json"
            }*/
        }).error(function(msg){
            console.log(msg.responseText);
        })
            .done(function( msg ) {
                $("#response").val($msg);
                console.log( msg );
            });
    });
</script>
<textarea id="response"></textarea>