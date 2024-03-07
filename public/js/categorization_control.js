 function getAutores() {
  $(".autores").html('<option selected disabled >... Cargando ...</option>');
    props.ruta = '/panel/autores-all';
    $.ajax({
       url: props.ruta,
       type: 'GET',
       dataType: 'JSON',
       success: res =>{
          $(".autores").empty();
          res.forEach(autor =>{
             $(".autores").append(`
                   <option value="${autor.idautor}">${autor.nombre}</option>
                `);
          });
       },
       error : error =>{
          console.log(error);
       }
    });
 }

 function getRubros() {
    $(".rubros").html('<option selected disabled >... Cargando ...</option>');
    props.ruta = '/panel/rubros-all';
    $.ajax({
       url: props.ruta,
       type: 'GET',
       dataType: 'JSON',
       success: res =>{
             $(".rubros").empty();
             res.forEach((rub, index) =>{
                if(index == 0) getCategs(rub.idrubro);
                $(".rubros").append(`
                      <option value="${rub.idrubro}">${rub.nombrerubro}</option>
                   `);
             });

       },
       error: error =>{
          console.log(error);
       }
    });
 }

function getCategs(rubro_id) {
  $(".categs").html('<option selected disabled >... Cargando ...</option>');
 props.ruta = `/panel/getcategs/${rubro_id}`;
 $.ajax({
    url: props.ruta,
    type: 'GET',
    dataType: 'JSON',
    success: res =>{
       $(".categs").empty();
          res.forEach((categ, index) =>{
             if(index == 0) getSubcates(categ.idcategoria);
             $(".categs").append(`
                  <option value="${categ.idcategoria}">${categ.nombrecategoria}</option>
               `);
          });
    },
    error: error =>{
       console.log(error);
    }
 });

}

function getSubcates(categ_id) {
  $(".subcates").html('<option selected disabled >... Cargando ...</option>');
 props.ruta = `/panel/getsubcates/${categ_id}`;
 $.ajax({
    url: props.ruta,
    type: 'GET',
    dataType: 'JSON',
    success: res =>{
       $(".subcates").empty();
          res.forEach(subcate =>{
             $(".subcates").append(`
                   <option value="${subcate.idsubcategoria}">${subcate.nombresubcategoria}</option>
                `);
          });
    },
    error: error =>{
       console.log(error);
    }
 });

}

 function get_autores_to_edit(dataedit) {
  $(".autores").html('<option selected disabled >... Cargando ...</option>');
    props.ruta = '/panel/autores-all';
    $.ajax({
       url: props.ruta,
       type: 'GET',
       dataType: 'JSON',
       success: res =>{
          $(".autores").empty();
          res.forEach(autor =>{
             $(".autores").append(`
                   <option ${dataedit.post.idautor == autor.idautor ? 'selected' : ''} value="${autor.idautor}">${autor.nombre}</option>
                `);
          });
       },
       error : error =>{
          console.log(error);
       }
    });
 }
function get_rubros_to_edit(dataedit) {
  $(".rubros").html('<option selected disabled >... Cargando ...</option>');
    props.ruta = '/panel/rubros-all';
    $.ajax({
       url: props.ruta,
       type: 'GET',
       dataType: 'JSON',
       success: res =>{
             $(".rubros").empty();
             res.forEach((rub, index) =>{
                if(dataedit.post.subcategoria.categoria.idrubro == rub.idrubro){
                   $(".rubros").append(`
                      <option selected value="${rub.idrubro}">${rub.nombrerubro}</option>
                   `);
                   get_categs_to_edit(dataedit, rub.idrubro);
                }else{
                   $(".rubros").append(`
                      <option value="${rub.idrubro}">${rub.nombrerubro}</option>
                   `);
                }
             });
       },
       error: error =>{
          console.log(error);
       }
    });
}

function get_categs_to_edit(dataedit, rubro_id) {
  $(".categs").html('<option selected disabled >... Cargando ...</option>');
   props.ruta = `/panel/getcategs/${rubro_id}`;
   $.ajax({
      url: props.ruta,
      type: 'GET',
      dataType: 'JSON',
      success: res =>{
         $(".categs").empty();
            res.forEach(categ =>{
             if(dataedit.post.subcategoria.idcategoria == categ.idcategoria){
                $(".categs").append(`
                     <option selected value="${categ.idcategoria}">${categ.nombrecategoria}</option>
                  `);
                get_subcates_to_edit(dataedit, categ.idcategoria);
             }else{
               $(".categs").append(`
                    <option value="${categ.idcategoria}">${categ.nombrecategoria}</option>
                 `);
             }
            });
      },
      error: error =>{
         console.log(error);
      }
   });
}

function get_subcates_to_edit(dataedit, categ_id) {
  $(".subcates").html('<option selected disabled >... Cargando ...</option>');
   props.ruta = `/panel/getsubcates/${categ_id}`;
   $.ajax({
      url: props.ruta,
      type: 'GET',
      dataType: 'JSON',
      success: res =>{
         $(".subcates").empty();
            res.forEach(subcate =>{
               $(".subcates").append(`
                     <option ${dataedit.post.idsubcategoria == subcate.idsubcategoria ? 'selected' : ''} value="${subcate.idsubcategoria}">${subcate.nombresubcategoria}</option>
                  `);
            });
      },
      error: error =>{
         console.log(error);
      }
   });
}