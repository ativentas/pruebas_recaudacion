
$(document).ready(function() {

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

$('.decimales').change(function() {
    valor = $(this).val();
    $(this).val(numeral(valor).format());
});

$('.rojo').change(function() {
    valor = parseFloat(numeral().unformat($(this).text()));
    if (valor<0) {$(this).attr('style', 'color:red');}
    else {$(this).attr('style', 'color:black');}

});

//cuando se introducen los billetes
$('.billetes').change(function(){
    var fila = $(this).parents('tr');
    var id = fila.data('id');
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

    //poner el resultado en el input oculto y llamar función parcial_lineaChange       
    var tipo = 'R-'+id;

    $('#span-billetes'+tipo).text(numeral(sum).format('0,0'));
    $('#billetes'+tipo).val(sum);

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
    parcial_lineaChange(fila,tipo);
});

//entradas especiales: pagos y acumular siguiente plantilla
$('.entradas_especiales').change(function() {
    var fila = $(this).parents('tr');
    alert('ha cambiao');
    calcular_diferencias(fila);
});

function parcial_lineaChange (fila,tipo) {
  //elegir todos los inputs con clase parcial_linea y id acabada en L-id o R-id ;
  sum = 0;
  $(fila).find('input[id$='+tipo+']').filter('.parcial_linea ').each(function(){
    var value = $(this).val();
        value = numeral().unformat(value);
        if(isNaN(value)){alert(value+' no es un valor válido');}
        if (!isNaN(value) && value.length !=0) {
         sum+=parseFloat(value);}
  });
  sum = numeral(sum).format();
  //poner el total de la recaudación y llamar a la función calcular_diferencia (fila)
  $('input[id=total'+tipo+']').val(sum);
  $('#span-total'+tipo).text(sum);
  calcular_diferencias(fila);
}

function calcular_diferencias (fila) {
    sum = 0;
    id = $(fila).data('id');
    // var pendiente = $('#'). ver si me sale la otra técnica

    //creo que lo siguiente es mejor: para calcular la diferencia, sumar todos, 
    // pero primero multiplicarlo cada uno por su signo: data-signo=-1
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
    
    descuadre = numeral(descuadre).format()
    diferencia = numeral(sum).format();

    $('#diferencia-'+id).val(diferencia);
    $('#span-diferencia-'+id).text(diferencia).change();
    $('#descuadre-'+id).val(descuadre);
    $('#span-descuadre-'+id).text(descuadre).change();

}







});    
