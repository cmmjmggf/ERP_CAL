<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class GeneraCostosVenta extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral')->view('vMenuParametros');
                    break;
            }
            $this->load->view('vGeneraCostosVenta')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onActualizarCostos() {
        try {
            $lista = $this->input->post('Lista');
            $linea = $this->input->post('Linea');
            $corr = $this->input->post('Corrida');

            //------------------------------Obtenemos los estilos y colores con su porcentaje de desperdicio------------------------------
            $Estilos = $this->db->query("select e.clave as estilo ,
                            CASE
                            WHEN e.PiezasCorte <= 10 THEN m.PorExtra3a10
                            WHEN e.PiezasCorte > 10 AND e.PiezasCorte <= 14 THEN m.PorExtra11a14
                            WHEN e.PiezasCorte > 14 AND e.PiezasCorte <= 18 THEN m.PorExtra15a18
                            WHEN e.PiezasCorte > 18  THEN m.PorExtra19a END AS PorcenDesperd,
                            (select clave from colores where estilo = e.clave and precioventa = 1 limit 1) as numcolor,
                            (select Descripcion from colores where estilo = e.clave and precioventa = 1 limit 1) as nomcolor
                            from estilos e
                            join maquilas m on m.Clave = 1
                            where e.linea = '$linea' and e.clave <> '5418N' and e.Corrida = $corr and e.costos = 0 ")->result();

            if (!empty($Estilos)) {//Si existen estilos empezamos el proceso
                foreach ($Estilos as $key => $E) {
                    $estilo = $E->estilo;
                    $color = $E->numcolor;
                    $colord = $E->nomcolor;
                    $porcentajeDesp = $E->PorcenDesperd;
                    //------------------------------Obtenemos la materia prima "materiales"------------------------------
                    $FichaTecnica = $this->db->query("select ft.consumo, a.grupo, pm.precio
                                            from fichatecnica ft
                                            join articulos a on a.clave  = ft.articulo
                                            join preciosmaquilas pm on pm.Articulo = a.clave and pm.maquila = 1
                                            where ft.estilo = '$estilo' and ft.color = '$color' and ft.afectapv = 0
                                            order by abs(a.grupo) asc ")->result();
                    $txtmaprpt = 0;
                    $txtmaprft = 0;
                    $txtmaprig = 0;
                    $txtmapri = 0;
                    foreach ($FichaTecnica as $key => $F) {
                        $precio = floatval($F->precio);
                        $grupo = $F->grupo;
                        $consumo = floatval($F->consumo);
                        if ($grupo === '1') {
                            $txtconsu = floatval($consumo) * floatval($porcentajeDesp);
                            $txtconsup = floatval($txtconsu) * floatval($precio);
                            $txtmaprpt = floatval($txtmaprpt) + floatval($txtconsup);
                        }
                        if ($grupo === '2') {
                            $txtconsu = floatval($consumo) * floatval($porcentajeDesp);
                            $txtconsuf = floatval($txtconsu) * floatval($precio);
                            $txtmaprft = floatval($txtmaprft) + floatval($txtconsuf);
                        }
                        $txtmapr = floatval($consumo) * floatval($precio);
                        $txtmapri = floatval($txtmapri) + floatval($txtmapr);
                        $txtmaprig = floatval($txtmaprig) + floatval($txtmapr);
                    }
                    //------------------------------ Obtenemos la mano de obra ------------------------------
                    $ManoObra = $this->db->query("select sum(CostoVTA) as manoobra "
                                    . "from fraccionesxestilo "
                                    . "where estilo = '$estilo' and AfectaCostoVTA = 1 and fraccion not in ('401','402','403'); ")->result()[0]->manoobra;

                    $Tejida = $this->db->query("select sum(CostoVTA) as tejida "
                                    . "from fraccionesxestilo "
                                    . "where estilo = '9281' and AfectaCostoVTA = 1 and fraccion  in ('401','402','403'); ")->result()[0]->tejida;

                    //Nos traemos los parametros fijos GASTOS etc.
                    $ParamFijos = $this->db->query("SELECT * FROM costofijo where lista = $lista ")->result();

                    if (empty($ParamFijos)) {//No existen parametros fijos
                        print 0;
                    } else {//Existen parametros fijos y obtenemos los datos para inserar o actualizar
                        $txttolera = $ParamFijos[0]->toler;
                        $txtgfabri = $ParamFijos[0]->gfabri;
                        $txtgvta = $ParamFijos[0]->gvta;
                        $txtgadmon = $ParamFijos[0]->gadmon;
                        $txthms = $ParamFijos[0]->hms;
                        $txtutili = $ParamFijos[0]->utili;
                        $txtdesc = $ParamFijos[0]->desc;
                        $txtcomic = $ParamFijos[0]->comic;
                        $txtflete = $ParamFijos[0]->flete;

                        //Verificamos si existe ya el registro estilo-color-linea-lista para saber si inserta o actualiza
                        $CostoVaria = $this->db->query("SELECT estilo,color FROM costovaria where lista = $lista and linea = $linea and estilo = '$estilo' and color = $color and corr = $corr ")->result();

                        if (empty($CostoVaria)) {
                            //Inserta Nuevo
                            $this->db->insert("costovaria", array(
                                'lista' => $lista,
                                'estilo' => $estilo,
                                'color' => $color,
                                'colord' => $colord,
                                'linea' => $linea,
                                'matpri' => $txtmapri,
                                'maob' => $ManoObra,
                                'toler' => $txttolera,
                                'gfabri' => $txtgfabri,
                                'gvta' => $txtgvta,
                                'gadmon' => $txtgadmon,
                                'hms' => $txthms,
                                'utili' => $txtutili,
                                'desc' => $txtdesc,
                                'comic' => $txtcomic,
                                'tejida' => $Tejida,
                                'precto' => 0,
                                'flete' => $txtflete,
                                'pextr' => $porcentajeDesp,
                                'corr' => $corr,
                                'mextr' => floatval($txtmaprpt + $txtmaprft),
                                'fecha' => Date('Y-m-d')
                            ));
                        } else {
                            //Actualiza
                            $this->db->where('lista', $lista)->where('linea', $linea)->where('estilo', $estilo)->where('color', $color)->where('corr', $corr)
                                    ->update("costovaria", array(
                                        'matpri' => $txtmapri,
                                        'maob' => $ManoObra,
                                        'toler' => $txttolera,
                                        'gfabri' => $txtgfabri,
                                        'gvta' => $txtgvta,
                                        'gadmon' => $txtgadmon,
                                        'hms' => $txthms,
                                        'utili' => $txtutili,
                                        'desc' => $txtdesc,
                                        'comic' => $txtcomic,
                                        'tejida' => $Tejida,
                                        'flete' => $txtflete,
                                        'pextr' => $porcentajeDesp,
                                        'corr' => $corr,
                                        'mextr' => floatval($txtmaprpt + $txtmaprft),
                                        'fecha' => Date('Y-m-d')
                            ));
                        }
                    }
                }

                //Actualizamos el precto ya una vez actualizado los campos de costovaria
                $CostoVariaFinal = $this->db->query("SELECT * FROM costovaria where lista = $lista and linea = $linea and corr = $corr ")->result();
                if (empty($CostoVariaFinal)) {//No existen estilos en costo varia para sacar precio final
                    print 2;
                } else {//hacemos la iteración
                    $cont = 1;
                    foreach ($CostoVariaFinal as $key => $CF) {
                        $matepri = $CF->matpri;
                        $tolera = $CF->toler;
                        $maob = $CF->maob;
                        $gfabri = $CF->gfabri;
                        $gvta = $CF->gvta;
                        $gadmon = $CF->gadmon;
                        $hms = $CF->hms;
                        $desc = $CF->desc;
                        $comic = $CF->comic;
                        $tejida = $CF->tejida;
                        $mextr = $CF->mextr;
                        $flete = $CF->flete;
                        $porcentaje0 = 0.85;
                        $porcentaje1 = floatval($comic) + floatval($desc);
                        $porcentaje2 = floatval($porcentaje0) - floatval($porcentaje1);
                        $pre1 = floatval($matepri) + floatval($mextr);
                        $pre11 = floatval($pre1) * floatval($tolera);
                        $pre2 = floatval($pre11) + floatval($matepri) + floatval($maob) + floatval($gfabri) + floatval($tejida) + floatval($mextr);
                        $pre3 = floatval($pre2) + floatval($gvta) + floatval($gadmon) + floatval($hms) + floatval($flete);
                        $pre4 = floatval($pre3) / floatval($porcentaje2);
                        $pre7 = floatval($pre4);
                        $this->db->query("update costovaria set precto = $pre7 where lista = $lista and linea = $linea and corr = $corr and estilo = '$CF->estilo' and color = $CF->color ");
                    }
                }
            } else {//No existen estilos
                print 1;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFotoEstilo() {
        try {
            $estilo = $this->input->get('Estilo');
            $query = "select foto from estilos where clave = '$estilo' ";
            //print $query;
            print json_encode($this->db->query($query)->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoCostos() {
        $linea = $this->input->get('Linea');
        $lista = $this->input->get('Lista');
        $estilo = $this->input->get('Estilo');
        $color = $this->input->get('Color');
        $corr = $this->input->get('Corrida');
        $datos = array();
        /* 1. */
        $query = "select *, date_format(fecha,'%d/%m/%Y') as fecha from costovaria "
                . " where lista = $lista and linea = $linea and estilo = '$estilo' and color = $color and corr = $corr ";

        $datos['UNO'] = json_encode($this->db->query($query)->result());
        /* 2. */


        print json_encode($datos);
    }

    public function onEliminarParametroFijo() {
        try {
            $Lista = $this->input->post('Lista');
            $existeListaEnClientes = $this->db->query("select count(*) as existe from clientes where ListaPrecios = $Lista ")->result();

            if (intval($existeListaEnClientes[0]->existe) > 0) {
                //no puede eliminar porque existe en clientes
                print 1;
            } else {
                //puede eliminar
                $this->db->query("delete from costofijo where lista = $Lista ");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarParametroFijos() {
        try {
            $x = $this->input;
            $Lista = $this->input->post('Lista');
            $existeLista = $this->db->query("select lista from costofijo where lista = $Lista ")->result();

            if (empty($existeLista)) {
                //Inserta
                $this->db->insert("costofijo", array(
                    'lista' => ($x->post('Lista') !== NULL) ? $x->post('Lista') : NULL,
                    'nomlista' => ($x->post('NomLista') !== NULL) ? $x->post('NomLista') : NULL,
                    'gfabri' => ($x->post('gfabriPF') !== NULL) ? $x->post('gfabriPF') : NULL,
                    'gvta' => ($x->post('gvtaPF') !== NULL) ? $x->post('gvtaPF') : NULL,
                    'gadmon' => ($x->post('gadmonPF') !== NULL) ? $x->post('gadmonPF') : NULL,
                    'hms' => ($x->post('hmsPF') !== NULL) ? $x->post('hmsPF') : NULL,
                    'toler' => ($x->post('tolerPF') !== NULL) ? $x->post('tolerPF') : NULL,
                    'utili' => ($x->post('utiliPF') !== NULL) ? $x->post('utiliPF') : NULL,
                    'desc' => ($x->post('descPF') !== NULL) ? $x->post('descPF') : NULL,
                    'comic' => ($x->post('comicPF') !== NULL) ? $x->post('comicPF') : NULL,
                    'pextr' => ($x->post('pextrPF') !== NULL) ? $x->post('pextrPF') : NULL,
                    'flete' => ($x->post('fletePF') !== NULL) ? $x->post('fletePF') : NULL
                ));
            } else {
                //Actualiza
                $this->db->where('lista', $Lista)->update("costofijo", array(
                    'lista' => ($x->post('Lista') !== NULL) ? $x->post('Lista') : NULL,
                    'nomlista' => ($x->post('NomLista') !== NULL) ? $x->post('NomLista') : NULL,
                    'gfabri' => ($x->post('gfabriPF') !== NULL) ? $x->post('gfabriPF') : NULL,
                    'gvta' => ($x->post('gvtaPF') !== NULL) ? $x->post('gvtaPF') : NULL,
                    'gadmon' => ($x->post('gadmonPF') !== NULL) ? $x->post('gadmonPF') : NULL,
                    'hms' => ($x->post('hmsPF') !== NULL) ? $x->post('hmsPF') : NULL,
                    'toler' => ($x->post('tolerPF') !== NULL) ? $x->post('tolerPF') : NULL,
                    'utili' => ($x->post('utiliPF') !== NULL) ? $x->post('utiliPF') : NULL,
                    'desc' => ($x->post('descPF') !== NULL) ? $x->post('descPF') : NULL,
                    'comic' => ($x->post('comicPF') !== NULL) ? $x->post('comicPF') : NULL,
                    'pextr' => ($x->post('pextrPF') !== NULL) ? $x->post('pextrPF') : NULL,
                    'flete' => ($x->post('fletePF') !== NULL) ? $x->post('fletePF') : NULL
                ));
            }
            //Actualiza parametros globales
            $this->db->update("costofijo", array(
                'gfabri' => ($x->post('gfabriPF') !== NULL) ? $x->post('gfabriPF') : NULL,
                'gvta' => ($x->post('gvtaPF') !== NULL) ? $x->post('gvtaPF') : NULL,
                'gadmon' => ($x->post('gadmonPF') !== NULL) ? $x->post('gadmonPF') : NULL,
                'toler' => ($x->post('tolerPF') !== NULL) ? $x->post('tolerPF') : NULL,
                'utili' => ($x->post('utiliPF') !== NULL) ? $x->post('utiliPF') : NULL,
                'pextr' => ($x->post('pextrPF') !== NULL) ? $x->post('pextrPF') : NULL
            ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoParametrosFijos() {
        try {
            $lista = $this->input->get('Lista');

            print json_encode($this->db->query("SELECT
                                *
                                FROM costofijo
                                where lista = $lista ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParametrosFijos() {
        try {
            print json_encode($this->db->query("select * from costofijo ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onActualizarPrecioAutorizado() {
        try {
            $linea = $this->input->post('Linea');
            $lista = $this->input->post('Lista');
            $estilo = $this->input->post('Estilo');
            $color = $this->input->post('Color');
            $PrecioAut = $this->input->post('PrecioAut');
            $this->db->query("update costovaria set preaut = $PrecioAut where linea = $linea and lista = $lista and estilo = $estilo and color = $color ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarEstilo() {
        try {
            $linea = $this->input->post('Linea');
            $lista = $this->input->post('Lista');
            $estilo = $this->input->post('Estilo');
            $color = $this->input->post('Color');
            $query = "delete from costovaria where linea = $linea and lista = $lista and estilo = $estilo and color = $color ";
            //print $query;
            $this->db->query($query);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarLineaListaCorrida() {
        try {
            $linea = $this->input->post('Linea');
            $lista = $this->input->post('Lista');
            $corrida = $this->input->post('Corrida');
            $query = "delete from costovaria where linea = $linea and lista = $lista and corr = $corrida ";
            $this->db->query($query);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onMarcarTodasLineasAbiertas() {
        try {
            $this->db->query("update estilos set seguridad = 1 ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineasAbiertas() {
        try {
            print json_encode($this->db->query("select linea, clave, seguridad from estilos where Seguridad = 0 ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloLineaLista() {
        try {
            $Estilo = $this->input->get('Estilo');

            print json_encode($this->db->query("select linea,lista,estilo,color
                                                from costovaria
                                                where estilo = '$Estilo' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onMarcarLineaParaNoModificar() {
        try {
            $Linea = $this->input->post('Linea');
            $this->db->query("update estilos set seguridad = 1 where linea = '$Linea' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onDescarmarLineaParaModificar() {
        try {
            $Linea = $this->input->post('Linea');
            $this->db->query("update estilos set seguridad = 0 where linea = '$Linea' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarEstiloColorParaCosto() {
        try {
            $Estilo = $this->input->post('Estilo');
            $Color = $this->input->post('Color');
            $this->db->query("update colores set precioventa = 0 where estilo = '$Estilo' ");
            $this->db->query("update colores set precioventa = 1 where estilo = '$Estilo' and clave = '$Color' ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onVerificarExisteEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');

            print json_encode($this->db->query("select clave from estilos where clave = '$Estilo' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColores() {
        try {
            $Estilo = $this->input->get('Estilo');

            print json_encode($this->db->query("select estilo, clave as color, descripcion as nomcolor, costo,
                                                case when PrecioVenta = 1 then PrecioVenta else '' end as pventa
                                                from colores where estilo = '$Estilo'
                                                order by estilo, clave asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresByEstilo() {
        try {
            $Estilo = $this->input->get('Estilo');
            print json_encode($this->db->select("CAST(C.Clave AS SIGNED ) AS ID, CONCAT(C.Clave,'-', C.Descripcion) AS Descripcion ", false)
                                    ->from('colores AS C')
                                    ->where('C.Estilo', $Estilo)
                                    ->where('C.Estatus', 'ACTIVO')
                                    ->order_by('ID', 'ASC')
                                    ->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistros() {
        try {
            $linea = $this->input->get('Linea');
            $lista = $this->input->get('Lista');
            $corrida = $this->input->get('Corrida');

            print json_encode($this->db->query("SELECT * FROM costovaria
                                                where linea = '$linea' and corr = $corrida and lista = $lista
                                                order by linea, lista, estilo asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoInicial() {
        try {
            $linea = $this->input->get('Linea');
            $lista = $this->input->get('Lista');
            $corrida = $this->input->get('Corrida');

            print json_encode($this->db->query("SELECT
                                gtosf,
                                date_format(fecha,'%d/%m/%Y') as fecha,
                                comic,
                                `desc`,
                                matpri,
                                mextr,
                                toler,
                                maob,
                                gfabri,
                                tejida,
                                gvta,
                                gadmon,
                                hms,
                                flete
                                FROM costovaria
                                where linea = '$linea' and corr = $corrida and lista = $lista
                                order by linea, lista, estilo asc ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onActualizarGastosFijos() {
        try {
            $gastosf = $this->input->post('GastosF');
            $this->db->query("update costovaria set gtosf = $gastosf ");
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /* Reportes */

    public function onImprimirListaPrecios() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["lista"] = $this->input->post('Lista');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reporteListasPrecios.jasper');
        $jc->setFilename('REPORTE_LISTAS_PRECIO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirReporteCostos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["linea"] = $this->input->post('Linea');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\costos\reportePreciosPorLinea.jasper');
        $jc->setFilename('REPORTE_COSTOS_LINEA_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
