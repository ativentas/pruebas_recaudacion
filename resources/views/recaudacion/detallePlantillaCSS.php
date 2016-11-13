<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Document</title>
</head>
<body>

    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default">

        <div class="panel-heading"><h2>Semana -</h2>
                
            <div class="row">
                    <ol class="breadcrumb">
                        <li><a>Listado</a></li>
                        <li><a>Nueva Recaudacion</a></li>
                        <li style="margin:0 0 0 20em;"><button class="btn-primary btn-xs btn-guardar">Guardar Cambios</button></li>
                    </ol>
            </div>
        </div>

        <div class="panel-body">
            <div class="row">

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Máquina</th>
                        <th>Mon.</th>
                        <th>5</th>
                        <th>10</th>
                        <th>20</th>
                        <th>50</th>
                        <th>100</th>
                        <th>Bill.</th>
                        <th>Total</th>
                        <th>Mon.</th>
                        <th>Bill.</th>
                        <th>Total</th>
                        <th>Dif.</th>

                    </tr>
                </thead>

             
                <tbody>
          
                    <tr>
                        <th scope="row"></th>
                        <td></td>
                        <td>
                        <input class="dinero" type="number" min="0" max="999" step="1" pattern="/d*" style="width: 3em;">
                        </td>
                <!-- billetes -->
                        <td>
                        <input class="billetes" type="number" min="0" max="999" step="5"  pattern="/d*" style="width: 4em;">
                        </td>
                        <td>
                        <input class="billetes" type="number" min="0" max="999" step="10"  pattern="/d*" style="width: 4em;">
                        </td>
                        <td>
                        <input class="billetes" type="number" min="0" max="999" step="20" pattern="/d*" style="width: 4em;">
                        </td>
                        <td>
                        <input class="billetes" type="number" min="0" max="999" step="50"  pattern="/d*" style="width: 4em;">
                        </td>
                        <td>
                        <input class="billetes" type="number" min="0" max="999" step="100" tabindex="" name="bc-{{$linea->id}}" pattern="/d*" style="width: 4em;">
                        </td>
                        <td>
                        <input class="dinero" type="number" min="0" max="9999" step="5" pattern="/d*" style="width: 4em;" disabled readonly="true">
                        </td>
                <!-- fin billetes -->
                        <td>
                        <label></label>
                        </td>
                <!-- aquí van las recaudaciones que marcan las máquinas -->
                        <td>
                        <input class="dineroI" type="number" min="0" max="999" step="1" pattern="/d*" style="width: 3em;">
                        </td>
                        <td>
                        <input class="dineroI" type="number" min="0" max="9999" step="5" pattern="/d*" style="width: 4em;">
                        </td>                    
                <!-- totales por linea y diferencia -->
                        <td>
                        <label></label>
                        </td>
                        <td>
                        <label></label>
                        </td>
                        <td>
                <!-- botones validar/modificar -->
                        <button class="btn btn-info btn-xs btn-modificar" type="button"></span>Modificar
                        </button>                   
                        </td>

                    </tr>
                </tbody>   
                <tfoot>
                    <tr>
                    <td colspan=9></td>
                    <td><label></label>
                    </td>
                    <td colspan=2></td>
                    <td><label></label>
                    </td>
                    <td>
                    <label></label>
        
                    </td>
                    </tr>
                    
                </tfoot>
            </table>
         
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Ya están pasadas TODAS las recaudaciones
                    </label>
                    <button class="btn-primary btn-xs btn-danger btn-completar" name="completar">Completado!!</button>
                </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    </div>


</body>
</html>
