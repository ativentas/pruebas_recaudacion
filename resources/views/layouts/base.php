<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<div class="st-wrap">
<table class="st-table" style="undefined;table-layout: fixed; width: 1005px">
<colgroup>
    <col style="width: 21px">
    <col class="ancho_maquina" style="width: 110px">
    <col class="ancho_pendiente" style="width: 66px">
    <col class="ancho_moneda_real" style="width: 66px">
    <col class="ancho_5" style="width: 31px">
    <col style="width: 31px">
    <col style="width: 31px">
    <col style="width: 31px">
    <col style="width: 31px">
    <col class="ancho_billetes_real" style="width: 50px">
    <col class="ancho_total_real" style="width: 70px">
    <col style="width: 51px">
    <col style="width: 66px">
    <col style="width: 41px">
    <col style="width: 66px">
    <col style="width: 66px">
    <col style="width: 66px">
    <col style="width: 66px">
    <col style="width: 67px">
</colgroup>
  <tr>
    <th class="st-vh0g" rowspan="2">#</th>
    <th class="st-ftxs" rowspan="2">Maquina</th>
    <th class="st-4und" colspan="10">Recaudacion</th>
    <th class="st-4und" colspan="3">Lectura</th>
    <th class="st-4und" colspan="3">Descuadres</th>
    <th class="st-il6h" rowspan="2"></th>
  </tr>
  <tr>
    <th class="st-14nr">Pdte.</th>
    <th class="st-y2da">Mon.</th>
    <th class="st-y2da ">5€</th>
    <th class="st-y2da ">10€</th>
    <th class="st-y2da ">20€</th>
    <th class="st-y2da ">50€</th>
    <th class="st-y2da ">100€</th>
    <th class="st-y2da">Tot.Bill</th>
    <th class="st-y2da">TOTAL</th>
    <th class="st-14nr">Pag.</th>
    <th class="st-y2da">Mon.</th>
    <th class="st-y2da">Bill.</th>
    <th class="st-y2da">TOTAL</th>
    <th class="st-ltqa">Dif.</th>
    <th class="st-14nr">Postp.</th>
    <th class="st-14nr">Desc.</th>
  </tr>
    <?php $i = 1;?>

  <tr data-id="999">
    <td class="st-orden">{{ $i++ }}</td>
    <td class="st-maquina">{{$linea->maquina}}</td>
    <td class="st-pendiente"></td>
    <td class="st-entrada real"><input class="parcial_linea" type="text" value="0"></td>
    <td data-valor="5" class="st-entrada"><input class="billetes" type='text' value="1" /></td>
    <td data-valor="10" class="st-entrada"><input class="billetes" type='text' value="1" /></td>
    <td data-valor="20" class="st-entrada"><input class="billetes" type='text' value="1" /></td>
    <td data-valor="50" class="st-entrada"><input class="billetes" type='text' value="1" /></td>
    <td data-valor="100" class="st-entrada"><input class="billetes" type='text' value="1" /></td>
    <td class="st-suma_billetes td-parcial_linea">185<input class="parcial_linea" type="hidden" name="billetes999" id="billetes999" value="999"></td>
    <td class="st-total">11.085,50</td>
    <td class="st-entrada">25,00</td>
    <td class="st-entrada">911,00</td>
    <td class="st-entrada">200</td>
    <td class="st-total">1.112,00</td>
    <td class="st-diferencia">-1,50</td>
    <td class="st-entrada"></td>
    <td class="st-diferencia">-1,50</td>
    <td class="st-vuu7">Validar</td>
  </tr>

  <tr>
    <td class="st-bsv2"></td>
    <td class="st-ypb4">TOTALES</td>
    <td class="st-hv2l">720,00</td>
    <td class="st-dw4u">1.210,50</td>
    <td class="st-9vst"></td>
    <td class="st-9vst">20</td>
    <td class="st-9vst">1</td>
    <td class="st-my2k"></td>
    <td class="st-my2k"></td>
    <td class="st-c7at">220</td>
    <td class="st-85oi">1.110,50</td>
    <td class="st-l2oz">25,00</td>
    <td class="st-c7at">1.011,00</td>
    <td class="st-c7at">500</td>
    <td class="st-n1j6">1.510,00</td>
    <td class="st-n1j6">320,50</td>
    <td class="st-l2oz">320,00</td>
    <td class="st-n1j6">1,50</td>
    <td class="st-my2k"></td>
  </tr>
</table></div>
	
</body>
</html>