<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
       
                function postContact() {
                    $.post("http://192.168.1.3/araskocon/index.php/Api/crateContact",
                            {
                                "model_no": "",
                                "device_id": "",
                                "brand": "",
                                "name": "",
                                "contact_no": "",

                            },
                            function (result) {
                                $("span").html(result);
                            });
                }
            
       
        </script>
    </head>
    <body>

        <p>Start typing a name in the input field below:</p>
        First name:

        <button onclick="postContact()">Press</button>

        <p>Suggestions: <span></span></p>
        <p>The file used in this example (<a href="demo_ajax_gethint.txt" target="_blank">demo_ajax_gethint</a>) is explained in our Ajax tutorial</p>

    </body>
</html>
