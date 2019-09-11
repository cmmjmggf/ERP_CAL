<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Sesion';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE; 
/*PEDIDOS*/
$route['peds'] = 'Pedidos/getRecords';
$route['pedsid'] = 'Pedidos/getPedidosByID';
$route['pedbyid'] = 'Pedidos/getPedidoDByID';

/*ASIGNA*/
$route['pieles'] = 'AsignaPFTSACXC/getPieles';
$route['forros'] = 'AsignaPFTSACXC/getForros';
$route['textiles'] = 'AsignaPFTSACXC/getTextiles';
$route['sinteticos'] = 'AsignaPFTSACXC/getSinteticos';
$route['controlesasignados'] = 'AsignaPFTSACXC/getControlesAsignados';

/*AVANCES*/
$route['departamentos'] = 'Avance/getDepartamentos';
$route['prosmaq'] = 'Avance/getMaquilasPlantillas';
$route['avances'] = 'Avance';
$route['avance_semana_actual'] = 'Avance/getSemanasDeProduccion';
$route['avance_maqplant'] = 'Avance/getMaquilasPlantillas';
$route['avance_empleados'] = 'Avance/getEmpleados';
$route['avance_fracciones'] = 'Avance/getFracciones';
$route['avance_buscar_avance_x_control'] = 'Avance/onComprobarAvanceXControl';

/*AVANCES 999999*/
$route['buscar_avance_x_control/:num/:num'] = 'Avance9/shoes/$1/$2/';
$route['avance_x_empleadopagodenomina'] = 'Avance9';
$route['comprobar_numero_de_empleado'] = 'Avance9/onComprobarDeptoXEmpleado';
$route['obtener_semana_fecha'] = 'Avance9/getSemanaByFecha';
$route['obtener_estilo_pares_por_control_fraccion'] = 'Avance9/onComprobarRetornoDeMaterialXControl';
$route['obtener_ultimo_avance_por_control'] = 'Avance9/getUltimoAvanceXControl';
$route['avance_add_avance_x_empleado_add_nomina'] = 'Avance9/onAgregarAvanceXEmpleadoYPagoDeNomina';
$route['avance_add_avance_x_empleado_add_nominax'] = 'Avance9/onAgregarAvanceXEmpleadoYPagoDeNomina';
$route['obtener_avances_pago_nomina/:num'] = 'Avance9/getFraccionesPagoNomina/$1'; 
$route['obtener_pagos_de_nomina_x_empleado'] = 'Avance9/getPagosXEmpleadoXSemana';

/*AVANCE 888888*/ 
$route['comprobar_numero_de_empleado_ocho'] = 'Avance8/onComprobarDeptoXEmpleado';
$route['obtener_semana_fecha_ocho'] = 'Avance8/getSemanaByFecha';
$route['obtener_estilo_pares_por_control_fraccion_ocho'] = 'Avance8/onComprobarFraccionXEstilo';
$route['obtener_pagos_de_nomina_x_empleado_ocho'] = 'Avance8/getPagosXEmpleadoXSemana';
$route['obtener_ultimo_avance_por_control_ocho'] = 'Avance8/getUltimoAvanceXControl';
$route['avance_add_avance_x_empleado_add_nomina_ocho'] = 'Avance8/onAgregarAvanceXEmpleadoYPagoDeNomina';

/*AVANCE A PESPUNTE X MAQUILA */
$route['avance_a_pespunte_x_maquila'] = 'AvancePespunteMaquila';
$route['avance_a_pespunte_x_maquila_maquilas'] = 'AvancePespunteMaquila/getMaquilas';
$route['avance_a_pespunte_x_maquila_empleados'] = 'AvancePespunteMaquila/getEmpleados';
$route['avance_a_pespunte_x_maquila_colores_x_estilo'] = 'AvancePespunteMaquila/getColoresXEstilo';

/*AVANCE A TEJIDO - CHOFER*/
$route['avance_tejido'] = 'AvanceTejido';
$route['choferes'] = 'AvanceTejido/getChoferes';
$route['tejedoras'] = 'AvanceTejido/getTejedoras';
$route['colores_x_estilo'] = 'AvanceTejido/getColoresXEstilo';

/*ACCESOS*/
$route['menu_modulos'] = 'ResourceManager/getModulos';
$route['accesos_directos_x_usuario'] = 'ResourceManager/getAccesosDirectosXModulo';
$route['menu_opciones_modulos'] = 'ResourceManager/getOpcionesXModulo';

$route['accesos_modulos'] = 'Accesos/getModulos';
$route['accesos_modulos_x_usuario'] = 'Accesos/getModulosXUsuario';
$route['accesos_add_modulos'] = 'Accesos/onAgregarModulosXUsuario';

$route['accesos_opciones'] = 'Accesos/getOpciones';
$route['accesos_opciones_x_modulo_x_usuario'] = 'Accesos/getOpcionesXModuloxUsuario';
$route['accesos_add_opciones_x_modulo_x_usuario'] = 'Accesos/onAgregarOpcionesXModuloXUsuario';

$route['accesos_items'] = 'Accesos/getItems';
$route['accesos_items_x_opcion_x_modulo_x_usuario'] = 'Accesos/getItemsXOpcionXModuloxUsuario';
$route['accesos_dropdown_items_x_opcion_x_modulo_x_usuario'] = 'Accesos/getItemsConSubItemsXOpcionXModuloxUsuario';
$route['accesos_add_item_x_opcion_x_modulo_x_usuario'] = 'Accesos/onAgregarItemsXOpcionXModuloXUsuario';

$route['accesos_subitems'] = 'Accesos/getSubItems';
$route['accesos_subitems_x_item_x_opcion_x_modulo_x_usuario'] = 'Accesos/getSubItemsXItemXOpcionXModuloxUsuario';
$route['accesos_add_subitem_x_item_x_opcion_x_modulo_x_usuario'] = 'Accesos/onAgregarSubItemsXItemXOpcionXModuloXUsuario';

$route['accesos_subsubitems'] = 'Accesos/getSubSubItems';
$route['accesos_subsubitems_x_subitems_x_item_x_opcion_x_modulo_x_usuario'] = 'Accesos/getSubSubItemsXSubItemXItemXOpcionXModuloxUsuario';
$route['accesos_add_subsubitems_x_subitem_x_item_x_opcion_x_modulo_x_usuario'] = 'Accesos/onAgregarSubSubItemsXSubItemXItemXOpcionXModuloXUsuario';

$route['controles_terminados'] = 'ControlesTerminados';