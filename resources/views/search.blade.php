<script>
        $(document).ready(function() {
           $( "#search" ).autocomplete({
        
               source: function(request, response) {
                   $.ajax({
                   url: "{{url('autocomplete')}}",
                   data: {
                           term : request.term
                    },
                   dataType: "json",
                   success: function(data){
                      var resp = $.map(data,function(obj){
                           //console.log(obj.city_name);
                           return obj.name;
                      }); 
        
                      response(resp);
                   }
               });
           },
           minLength: 1
        });
       });
        
       </script>  