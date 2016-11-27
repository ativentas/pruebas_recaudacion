
$(document).ready(function() {
  
$("#pagosdiv").css("display", "none"); 


$('span[id^="span-pagos-"]').dblclick(function() {
    $("#pagosdiv").css("display", "block");
    pago_id = $(this).parents('tr').data('id');
        //rellenar los campos con los de la linea correspondiente
    valor1 = parseFloat(numeral().unformat($('#pago1I-'+pago_id+'').val()));
    valor2 = parseFloat(numeral().unformat($('#pago2I-'+pago_id+'').val()));
    if(isNaN(valor1)){$('#m_pago1I').val('0,00');}else{$('#m_pago1I').val(numeral(valor1).format());}
    if(isNaN(valor2)){$('#m_pago2I').val('0,00');}else{$('#m_pago2I').val(numeral(valor2).format());}
    // $('#m_pago1C').val($('#pago1C-'+pago_id+'').val());   
    // $('#m_pago2C').val($('#pago2C-'+pago_id+'').val());   
    $('#m_pago1D').val($('#pago1D-'+pago_id+'').val());   
    $('#m_pago2D').val($('#pago2D-'+pago_id+'').val());   


});

$("#aceptar").click(function() {

    var pago1 = parseFloat(numeral().unformat($('#m_pago1I').val()));
    var pago2 = parseFloat(numeral().unformat($('#m_pago2I').val()));
    var sum = pago1 + pago2;
    pago1 = numeral(pago1).format();
    pago2 = numeral(pago2).format();
    $('#pagos-'+pago_id+'').val(sum);
    $('#pago1I-'+pago_id+'').val(pago1);
    $('#pago2I-'+pago_id+'').val(pago2);
    $('#pago1C-'+pago_id+'').val($('#m_pago1C').val());
    $('#pago2C-'+pago_id+'').val($('#m_pago2C').val());
    $('#pago1D-'+pago_id+'').val($('#m_pago1D').val());
    $('#pago2D-'+pago_id+'').val($('#m_pago2D').val());
    $("#pagosdiv").css("display", "none");
    $('#m_pago1I').val('');    
    $('#m_pago2I').val('');
    // $('#m_pago1C').val('');
    // $('#m_pago2C').val('');
    $('#m_pago1D').val('');
    $('#m_pago2D').val('');

    $('#span-pagos-'+pago_id+'').text(numeral(sum).format());
    $('#pagos-'+pago_id+'').change();
});


$( '.rojo' ).each(function() {
    var valor = parseFloat(numeral().unformat($(this).text()));
    if (valor<0) {$(this).attr('style', 'color:red');}
    else {$(this).attr('style', 'color:rgb(99, 107, 111)');}
});
var fila = $(this).parents('tr');
var id = fila.data('id');

$('.pendiente').change();

/*no he conseguido que funcione esto, de momento deshabilito estos botones.
Mi idea era que el botón sirviese para resaltar la linea*/
// $('button[id$="-439"]').toggle(function(){
// // $('button[id$="-'+id+'"]').toggle(function(){
//     alert('marcado');
//     // $('#tr-'+id+'').addClass("marcado");
//     // $('#tr-439').css("background-color","red");
// }, function () {
//     alert('desmarcado');
//     // $('#tr-'+id+'').removeClass("marcado");        
//     // $('#tr-439').removeClass("marcado");        
// });



// load a language
numeral.language('es-ES', {
        delimiters: {
            thousands: '.',
            decimal: ','
        },
        abbreviations: {
            thousand: 'k',
            million: 'mm',
            billion: 'b',
            trillion: 't'
        },
        ordinal: function (number) {
            var b = number % 10;
            return (b === 1 || b === 3) ? 'er' :
                (b === 2) ? 'do' :
                    (b === 7 || b === 0) ? 'mo' :
                        (b === 8) ? 'vo' :
                            (b === 9) ? 'no' : 'to';
        },
        currency: {
            symbol: '€'
        }
});
numeral.language('es-ES');
numeral.defaultFormat('0,0.00');
formato_decimales = '0,0.00'
formato_enteros = '0,0'



//para que cuando entre un valor en un input, me lo ponga en el formato que quiero
$('.decimales').change(function() {
    var valor = $(this).val();
    $(this).val(numeral(valor).format());
});

$('.enteros').change(function() {
    var valor = $(this).val();
    $(this).val(numeral(valor).format(formato_enteros));
});

$('.rojo').change(function() {
    var valor = parseFloat(numeral().unformat($(this).text()));
    if (valor<0) {$(this).attr('style', 'color:red');}
    else {$(this).attr('style', 'color:rgb(99, 107, 111)');}
});

//cuando se introducen los billetes
$('.billetes').change(function(){
    var fila = $(this).parents('tr');
    var id = fila.data('id');
    var tipo = 'R-'+id;
    var sum = 0;
    $(fila).find("input.billetes").each(function(){        
        var value = $(this).val();
        var valido = numeral(value).format('0,0');
        $(this).val(valido);
        var valor = $(this).parent().data('valor');
        if(isNaN(value)){alert(value+' no es un valor válido');}
        if (!isNaN(value) && value.length !=0) {
            calculado = parseInt(value * valor);
            sum +=parseInt(calculado);
        }
    });

    $('#span-billetes'+tipo).text(numeral(sum).format('0,0'));
    $('#billetes'+tipo).val(sum);

    sumar_columna('billetesR',formato_enteros);

    //calcular total de la columna. (quitar el linea->id al name para buscar toda la columna)
    var input_id = $(this).attr('id');   
    input_id = input_id.replace('-'+id,'');//aqui id se refiere a linea->id
    
    sumar_columna(input_id,formato_enteros);        

    parcial_lineaChange(fila,tipo);
});

//Entrada de recaudacion real y lectura
$('.parcial_linea').change(function() {
    var fila = $(this).parents('tr');
    var id = fila.data('id');
    if($(this).hasClass('real')){
        var t = 'R-';
    }
    if($(this).hasClass('lectura')){
        var t = 'L-';
    }
    var tipo = t+id;
    var input_id = $(this).attr('id');
    input_id = input_id.replace('-'+id,'');//aqui id se refiere a linea->id
    sumar_columna(input_id,formato_decimales);
    parcial_lineaChange(fila,tipo);
});

//entradas especiales: pagos y acumular siguiente plantilla
$('.entradas_especiales').change(function() {
    var fila = $(this).parents('tr');
    var id = fila.data('id');
    calcular_diferencias(fila);
    var input_id = $(this).attr('id');
    input_id = input_id.replace('-'+id,'');//aqui id se refiere a linea->id
    sumar_columna(input_id,formato_decimales);
});

//cuando cambian los totales y la diferencia y descuadre
$('.totales').change(function(){
    var fila = $(this).parents('tr');
    var id = fila.data('id');
    var input_id = $(this).attr('id');
    input_id = input_id.replace('-'+id,'');
    sumar_columna(input_id,formato_decimales);
})


/*Marca una linea (para llevar un control visual 
de los datos que vamos mentiendo))*/
// $('.btn-marcar').click(function(e){
//     e.preventDefault();
//     var fila = $(this).parents('tr');
//     var id = fila.data('id');
/*aplicar estilo amarillo a toda la linea*  FALTA HACER*/
// alert('hola');
//     fila.css('style','background-color:yellow');
//     $(this).hide();
//     $(this).next().show(); 
// });
// var htmlattri="background-color:red;";
// $('a').css("style",htmlattri);

/**
 * Guardar Datos.
 */


$('.btn-guardar').click(function(e){
    e.preventDefault();
    var form = $('#form_guardar');
    var url = form.attr('action').replace(':LINEA_ID','Algunas'); 
    var data = form.serialize();
    $.post(url, data, function(){
    }).done(function(){
        alert('cambios guardados');
    });

});

$('.btn-completar').click(function(e){
    e.preventDefault();
    if ($('#completado').prop('checked') == false) {
        alert('Tienes que marcar primero para completar la plantilla');
        return;
    }
    $('.btn-guardar').hide();
    var form = $('#form_guardar');
    var url = form.attr('action').replace(':LINEA_ID','Todas');  
    var data = form.serialize();
    $.post(url, data, function(){
    }).done(function(){
        $(location).attr("href", '/control');
    });
});



 /**
 * Funciones
 *
 */ 
 

function parcial_lineaChange (fila,tipo) {
  //elegir todos los inputs con clase parcial_linea y id acabada en L-id o R-id ;
  var sum = 0;
  $(fila).find('input[id$='+tipo+']').filter('.parcial_linea ').each(function(){
    var value = $(this).val();
        value = numeral().unformat(value);
        if(isNaN(value)){alert(value+' no es un valor válido');}
        if (!isNaN(value) && value.length !=0) {
         sum+=parseFloat(value);}
  });
  sum = numeral(sum).format();
  //poner el total de la recaudación y llamar a la función calcular_diferencia (fila)
  $('input[id=total'+tipo+']').val(sum).change();
  $('#span-total'+tipo).text(sum);
  calcular_diferencias(fila);
}

function calcular_diferencias (fila) {
    var sum = 0;
    var id = $(fila).data('id');

    // para calcular la diferencia, sumar todos, 
    // pero primero multiplicarlo cada uno por su signo: data-signo= 1 o -1
    $(fila).find('.subtotal_linea').each(function(){
        var value = $(this).val();
        value = numeral().unformat(value);
        var signo = $(this).data('signo');

        value = parseFloat(value);
        sum += value * signo;

    });
    //calcular descuadre y poner la diferencia y descuadre
    var acumular = numeral().unformat($('#acumular-'+id).val());
    var descuadre = sum - acumular;
    
    var descuadre = numeral(descuadre).format()
    var diferencia = numeral(sum).format();

    $('#diferencia-'+id).val(diferencia).change();
    $('#span-diferencia-'+id).text(diferencia).change();//para rojos negativos
    $('#descuadre-'+id).val(descuadre).change();
    $('#span-descuadre-'+id).text(descuadre).change();//para rojos negativos

}

function sumar_columna(input_id,formato){
    var columna = 0;
    $('input[id^='+input_id+']').each(function(){
        var value = $(this).val();
        // alert(value);
        value = numeral().unformat(value);       
        columna +=parseFloat(value);
    });
    //poner columna en su span e input correspondiente 
    $('#span-columna_'+input_id+'').text(numeral(columna).format(formato)).change();//para rojos negativos;
    $('#columna_'+input_id+'').val(numeral(columna).format(formato));

}


});    
