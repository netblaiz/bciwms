     
        $(document).ready(function(){

            $('#linkgenerationform').on('submit', function(event){
                event.preventDefault();
                var form_data = $(this).serialize();

                // alert(form_data);

                $.ajax({
                    url:"../core/controllerAjax/linkgeneratorController.php",
                    method:"POST",
                    data:form_data,
                    dataType:"JSON",
                    success:function(data)
                    {
                        $("#file_path").val(data.formlink);
                        // $("#tokenspace").html(data.formlink);
                    }
                })
            });
            
        });