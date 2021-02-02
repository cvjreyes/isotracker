 
    // DataTable
    var table = $('#tabla').DataTable({

              'columnDefs': [{
             'targets': 0,
             'searchable': false,
             'orderable': false,
             'className': 'dt-body-center',
             'render': function (data, type, full,meta){

                  var s = $('<div/>').text(full).html();
                      //if ((s.match(/RBD.*/)) || (s.match(/RBL.*/)) || (s.match(/Issued.*/)) || (s.match(/9565*/)) || (s.match(/8575*/)) || (s.match(/7595*/)) || (s.match(/MISSING*/)) || (s.match(/NO ACTIONS*/)) || (s.match(/DELETED*/)) || (s.match(/WAITING*/)) || (s.match(/BY:*/))) { // Si tiene request no se puede seleccionar

                        if ((s.match(/RBD.*/)) || (s.match(/RBL.*/)) || (s.match(/Issued.*/)) || (s.match(/MISSING*/)) || (s.match(/NO ACTIONS*/)) || (s.match(/DELETED*/)) || (s.match(/WAITING*/)) || (s.match(/CLAIMED*/))) { // Si tiene request no se puede seleccionar
                        return '<input type="checkbox" name="filenames[]" value="' + $('<div/>').text(data).html() + '" disabled>';
                      }else{
                        return '<input type="checkbox" name="filenames[]" value="' + $('<div/>').text(data).html() + '">';
                      }

                 
             }
               }],

        "order": [[ 1, 'desc' ]],"pageLength" : 8

            });

   // --------------------------------------------------------- SELECT ALL  -----------------------------------------------

      // Handle click on "Select all" control
   $('#example-select-all').on('click', function(){
      // Get all rows with search applied
      var rows = table.rows({ 'search': 'applied' }).nodes();
      // Check/uncheck checkboxes for all rows in the table
      $('input[type="checkbox"]', rows).prop('checked', this.checked);
   });

   // Handle click on checkbox to set state of "Select all" control
   $('#example tbody').on('change', 'input[type="checkbox"]', function(){
      // If checkbox is not checked
      if(!this.checked){
         var el = $('#example-select-all').get(0);
         // If "Select all" control is checked and has 'indeterminate' property
         if(el && el.checked && ('indeterminate' in el)){
            // Set visual state of "Select all" control
            // as 'indeterminate'
            el.indeterminate = true;
         }
      }
   });

    // Handle form submission event
   $('#frm-example').on('submit', function(e){
      var form = this;
       // Iterate over all checkboxes in the table
      table.$('input[type="checkbox"]').each(function(){
         // If checkbox doesn't exist in DOM
         if(!$.contains(document, this)){
            // If checkbox is checked
            if(this.checked){
               // Create a hidden element
               $(form).append(
                  $('<input>')
                     .attr('type', 'hidden')
                     .attr('name', this.name)
                     .val(this.value)
               );
            }
         }
      });
   });

   var data = table.$('input[type="checkbox"]').serialize();

// ---------------------------------------FIN SELECT ALL -------------------------------------------------
  