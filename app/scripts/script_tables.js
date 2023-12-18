console.log(document.getElementById('gestion-span').innerText);



fetch('./API/table_dataAPI.php')
.then(function(response) {
  return response.json();
})
.then(function(json) {
    itemJSON=json;
    console.log(itemJSON);
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
      })
      
      const table =$('#example').DataTable( {
          data: itemJSON,
          columns: [
              { data:'0'},
              { data:'1'},
              { data:'2'},
              { data:'3'},
            //   { data:'anciennete()',
              
            //       render: function ( data, type, row ) {
            //           if (data==0) {
            //               return '<span style="color:orange">'+data+'</span>';
            //           } else {
            //               return '<span style="color:green">'+data+'</span>';
            //           }
                      
            //           return data;
            //       }
            //   },
              { data:'4'},
              { data:'5'}
          ]
          
      } );
      
      table.on('click', 'tbody tr', (e) => {
          let tr = e.target.closest('tr');
          row = table.row(tr);
           let rowData =row.data();
          // document.getElementById('details').innerText = rowData.1 + ' ' +rowData.2 + ' ' + rowData.3;
        //   document.getElementById('poste').value=emp.job;
          
          myModal.show();
          
          
      });
      
    //   document.getElementById('btnSave').addEventListener('click',function() {
    //       var d = row.data();
    //       d.job=document.getElementById('poste').value;
    //       row
    //       .data( d )
    //       .draw();
    //       myModal.hide();
    //   });
}
)

