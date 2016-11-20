
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

//cuando se introducen los billetes
    $('.billetes').change(function(){

        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var sum = 0;

        $(fila).find("input.billetes").each(function(){
            
            var value = $(this).val();
            var valido = numeral(value).format('0,0');
            alert('valido: '+valido);
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
        $('#billetes'+tipo).val(sum);
        $('#span-billetes'+tipo).text(numeral(sum).format('0,0'));

        parcial_lineaChange(fila,tipo);

    });


    function parcial_lineaChange (fila,tipo) {
      //elegir todos los inputs con clase parcial_linea y id acabada en -id ;
      sum = 0;
      // $(fila).find('input[id$='+tipo'].parcial_linea ').each(function(){
      $(fila).find('input[id$='+tipo+']').filter('.parcial_linea ').each(function(){
        var value = $(this).val();
            if(isNaN(value)){alert(value+' no es un valor válido');}
            if (!isNaN(value) && value.length !=0) {
             sum+=parseFloat(value);}
      });
      sum = numeral(sum).format('0,0.00');
      //poner el total de la recaudación y llamar a la función calcular_diferencia (fila)
      alert(sum);


    }
//ver si vale la pena usar esta función. Creo que será mejor con numeral
    function isNumber(n) {
    'use strict';
    n = n.replace(/\./g, '').replace(',', '.');
    return !isNaN(parseFloat(n)) && isFinite(n);
}   




});    
