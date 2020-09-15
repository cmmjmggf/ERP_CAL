<?php

/* NO TOCAR */
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit('No direct script access allowed');

class AsignaDiaSemACtrlParaCorte extends CI_Controller {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Mexico_City');
        $this->load->library('session')->model('AsignaDiaSemACtrlParaCorte_model', 'adscpc')
                ->helper('jaspercommand_helper');
    }

    public function index() {
        $is_valid = false;
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vNavGeneral');
            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vMenuProduccion');
                    $is_valid = true;
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas');
                    $is_valid = true;
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuProduccion');
                    $is_valid = true;
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    $is_valid = true;
                    break;
            }
            $this->load->view('vAsignaDiaSemACtrlParaCorte')->view('vFooter');
        }
        if (!$is_valid) {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
//            print json_encode($this->adscpc->getRecords());
            $x = $this->input->get();
            $this->db->select("P.ID, CONCAT('<span class=\"font-weight-bold\">',P.Control,'</span>') AS Control, P.Cliente, "
                            . "P.Estilo, P.Color, P.Pares, "
                            . "P.Semana AS Semana", false)
                    ->from("pedidox AS P")->join('estilos AS E', 'P.Estilo = E.Clave')
                    ->join('estilostiempox AS TXE', 'P.Estilo = TXE.estilo')
                    ->join('programacion AS PR', 'P.Control = PR.Control', 'left')
                    ->where('PR.Control IS NULL', null, false)
                    ->where_not_in('P.Control', array(0))
                    ->where_not_in("P.stsavan", array(13, 14));
            if ($x['ANIO'] !== '') {
                $this->db->where('P.Ano', $x['ANIO']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('P.Semana', $x['SEMANA']);
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('P.Semana', $x['CONTROL']);
            }
            $this->db->order_by("YEAR(PR.fecha)", "DESC")->order_by("MONTH(PR.fecha)", "DESC")->order_by("DAY(PR.fecha)", "DESC");
            if ($x['ANIO'] === '' && $x['SEMANA'] === '' && $x['CONTROL'] === '') {
                $this->db->limit(25);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInfoXControl() {
        try {
            $x = $this->input->get();
            $this->db->select("P.*", false)->from("pedidox AS P");
            if ($x['CONTROL'] !== '') {
                $this->db->where('P.Control', $x['CONTROL'])
                        ->where_not_in("P.stsavan", array(13, 14))->limit(1);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getCortadores() {
        try {
            print json_encode($this->adscpc->getCortadores());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFracciones() {
        try {
            print json_encode($this->adscpc->getFracciones());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getProgramacion() {
        try {
//            print json_encode($this->adscpc->getProgramacion());
            $x = $this->input->get();

            $styl = 'style=\"font-size: 100%;\"';
            $sp = "<span class=\"badge badge-pill badge-info\" {$styl}>";
            $spbf = "<span class=\"badge badge-pill badge-fusion\" {$styl}>";
            $sps = "<span class=\"badge badge-pill badge-fusion-success\" {$styl}>";
            $spda = "<span class=\"badge badge-pill badge-danger\" {$styl}>";
            $spd = "<span class=\"badge badge-pill badge-dark\" {$styl}>";
            $spw = "<span class=\"badge badge-pill badge-warning\" {$styl}>";
            $spf = '</span>';
            $this->db->select("PR.ID, CONCAT('{$sps}',PR.numemp,'{$spf}') AS Emp, CONCAT('{$spw}',PR.control,'{$spf}') AS Control, "
                            . "PR.año AS Ano, CONCAT('{$spda}',PR.semana,'{$spf}') AS Sem, ELT(PR.diaprg,"
                            . "'{$sp}JUEVES{$spf}','{$sp}VIERNES{$spf}','{$sp}SABADO{$spf}',"
                            . "'{$sp}LUNES{$spf}','{$sp}MARTES{$spf}','{$sp}MIERCOLES{$spf}',"
                            . "'{$sp}DOMINGO{$spf}') AS Dia, "
                            . " CONCAT('{$spbf}',PR.frac,'{$spf}') AS Frac, DATE_FORMAT(PR.fecha, \"%d/%m/%Y\") AS Fecha, PR.estilo AS Estilo, "
                            . "PR.par AS Pares, PR.tiempo AS Tiempo, PR.precio AS Precio, "
                            . "PR.nomart", false)
                    ->from("programacion AS PR")->where_in("PR.frac", array(99, 100));
            if ($x['ANIO'] !== '') {
                $this->db->where('PR.año', $x['ANIO']);
            }
            if ($x['SEMANA'] !== '') {
                $this->db->where('PR.semana', $x['SEMANA']);
            }
            if ($x['DIA'] !== '') {
                $this->db->where('PR.diaprg', $x['DIA']);
            }
            if ($x['FRACCION'] !== '') {
                $this->db->where_in('PR.frac', explode(",", $x['FRACCION']));
            }
            if ($x['CORTADOR'] !== '') {
                $this->db->where('PR.numemp', $x['CORTADOR']);
            }
            if ($x['CONTROL'] !== '') {
                $this->db->where('PR.control', $x['CONTROL']);
            }
            $this->db->order_by("YEAR(PR.fecha)", "DESC")->order_by("MONTH(PR.fecha)", "DESC")
                    ->order_by("DAY(PR.fecha)", "DESC");
            if ($x['ANIO'] === '' && $x['SEMANA'] === '' && $x['CORTADOR'] === '' && $x['CONTROL'] === '') {
                $this->db->limit(25);
            }


            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onChecarSemanaValida() {
        try {
            print json_encode($this->adscpc->onChecarSemanaValida($this->input->get('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getControlesAsignados() {
        try {
            print json_encode($this->adscpc->getControlesAsignados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegresos() {
        try {
            print json_encode($this->adscpc->getRegresos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEmpleados() {
        try {
            print json_encode($this->adscpc->getEmpleados());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getParesXControl() {
        try {
            print json_encode($this->adscpc->getParesXControl($this->input->get('CONTROL')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPieles() {
        try {
            print json_encode($this->adscpc->getPieles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getForros() {
        try {
            print json_encode($this->adscpc->getForros(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTextiles() {
        try {
            print json_encode($this->adscpc->getTextiles(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getSinteticos() {
        try {
            print json_encode($this->adscpc->getSinteticos(isset($_GET['SEMANA']) ? $this->input->get('SEMANA') : '', isset($_GET['CONTROL']) ? $this->input->get('CONTROL') : ''));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getExplosionXSemanaControlFraccionArticulo() {
        try {
            print json_encode($this->adscpc->getExplosionXSemanaControlFraccionArticulo($this->input->get('SEMANA'), $this->input->get('CONTROL'), $this->input->get('FRACCION'), $this->input->get('ARTICULO'), $this->input->get('GRUPO')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloColorParesTxParPorControl() {
        try {
            $x = $this->input->get();
//            $x = $this->input;
//            print json_encode($this->adscpc->getEstiloColorParesTxParPorControl($x->get('CONTROL'), $x->get('TIPO')));

            $CONTROL = $x['CONTROL'];
            $FRACCION = $x['TIPO'];
            $tipo = "";
            $FRACCIONES = json_decode($FRACCION);
//            var_dump($FRACCIONES);
//            exit(0);
            for ($index = 0; $index < count($FRACCIONES); $index++) {
                $tipo .= $FRACCIONES[$index]->FRACCIONES;
            }
//            PRINT "TIPO : {$tipo}";
//            exit(0);
            switch (intval($tipo)) {
                case 99:
//                    print $tipo . "\n";

                    $this->db->select('FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, '
                                    . 'FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, '
                                    . 'A.Descripcion AS ARTICULO, FR.Departamento AS CLAVE_DEPARTAMENTO, '
                                    . 'PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortef AS TIEMPO, '
                                    . '(TXE.cortef) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS', false)
                            ->from('pedidox AS PE')
                            ->join('colores AS C', 'PE.Color = C.Clave AND C.Estilo = PE.Estilo')
                            ->join('fichatecnica AS FT', 'PE.Estilo = FT.Estilo AND PE.Color = FT.Color')
                            ->join('articulos AS A', 'FT.Articulo = A.Clave')
                            ->join('fraccionesxestilo AS FXE', 'FXE.Estilo = FT.Estilo')
                            ->join('fracciones AS FR', 'FXE.Fraccion = FR.Clave')
                            ->join('estilostiempox AS TXE', 'PE.Estilo = TXE.estilo');
                    $this->db->where("FR.Departamento = 10", null, false)->where_not_in("PE.stsavan", array(13, 14));
                    if ($CONTROL !== '') {
                        $this->db->where("PE.Control", $CONTROL);
                    }
                    $this->db->where("FXE.Fraccion = ", $tipo)->where_in("A.Grupo", array(2, 40))->group_by('A.Descripcion');
                    $DTM = $this->db->get()->result();
                    break;
                case 100:
//                    print $tipo . "\n";
                    $this->db->select('FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, '
                                    . 'FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, '
                                    . 'A.Descripcion AS ARTICULO, FR.Departamento AS CLAVE_DEPARTAMENTO, '
                                    . 'PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortep AS TIEMPO, '
                                    . '(TXE.cortep) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS', false)
                            ->from('pedidox AS PE')
                            ->join('colores AS C', 'PE.Color = C.Clave AND C.Estilo = PE.Estilo')
                            ->join('fichatecnica AS FT', 'PE.Estilo = FT.Estilo AND PE.Color = FT.Color')
                            ->join('articulos AS A', 'FT.Articulo = A.Clave')
                            ->join('fraccionesxestilo AS FXE', 'FXE.Estilo = FT.Estilo')
                            ->join('fracciones AS FR', 'FXE.Fraccion = FR.Clave')
                            ->join('estilostiempox AS TXE', 'PE.Estilo = TXE.estilo');
                    $this->db->where("FR.Departamento = 10", null, false);
                    if ($CONTROL !== '') {
                        $this->db->where("PE.Control", $CONTROL);
                    }
                    $this->db->where("FXE.Fraccion = ", $tipo)->where_not_in("PE.stsavan", array(13, 14))->where_in("A.Grupo", array(1))->group_by('A.Descripcion');

                    $DTM = $this->db->get()->result();
                    break;
                case 99100:
//                    print $tipo . "\n";
                    $DTM = $this->db->query("(SELECT FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, A.Descripcion AS ARTICULO,
FR.Departamento AS CLAVE_DEPARTAMENTO, PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortep AS TIEMPO, (TXE.cortep) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS FROM `pedidox` AS `PE`
JOIN `colores` AS `C` ON `PE`.`Color` = `C`.`Clave` AND `C`.`Estilo` = `PE`.`Estilo` JOIN `fichatecnica` AS `FT` ON `PE`.`Estilo` = `FT`.`Estilo` AND `PE`.`Color` = `FT`.`Color`
JOIN `articulos` AS `A` ON `FT`.`Articulo` = `A`.`Clave` JOIN `fraccionesxestilo` AS `FXE` ON `FXE`.`Estilo` = `FT`.`Estilo` JOIN `fracciones` AS `FR` ON `FXE`.`Fraccion` = `FR`.`Clave`
JOIN `estilostiempox` AS `TXE` ON `PE`.`Estilo` = `TXE`.`estilo`
WHERE FR.Departamento = 10  AND PE.Control = '{$CONTROL}'  AND `FXE`.`Fraccion` = '100' AND `A`.`Grupo` IN(1) GROUP BY `A`.`Descripcion`)
UNION
(SELECT  FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, A.Descripcion AS ARTICULO,
FR.Departamento AS CLAVE_DEPARTAMENTO, PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortef AS TIEMPO, (TXE.cortef) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS
FROM `pedidox` AS `PE` JOIN `colores` AS `C` ON `PE`.`Color` = `C`.`Clave` AND `C`.`Estilo` = `PE`.`Estilo`
JOIN `fichatecnica` AS `FT` ON `PE`.`Estilo` = `FT`.`Estilo` AND `PE`.`Color` = `FT`.`Color`
JOIN `articulos` AS `A` ON `FT`.`Articulo` = `A`.`Clave`
JOIN `fraccionesxestilo` AS `FXE` ON `FXE`.`Estilo` = `FT`.`Estilo` JOIN `fracciones` AS `FR` ON `FXE`.`Fraccion` = `FR`.`Clave`
JOIN  `estilostiempox` AS `TXE` ON `PE`.`Estilo` = `TXE`.`estilo`
 WHERE FR.Departamento = 10  AND PE.Control = '{$CONTROL}'  AND `FXE`.`Fraccion` = '99' AND `A`.`Grupo` IN(2,40) )")->result();
                    break;
                case 10099:
//                    print $tipo . "\n";
                    $DTM = $this->db->query("(SELECT FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, A.Descripcion AS ARTICULO,
FR.Departamento AS CLAVE_DEPARTAMENTO, PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortep AS TIEMPO, (TXE.cortep) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS FROM `pedidox` AS `PE`
JOIN `colores` AS `C` ON `PE`.`Color` = `C`.`Clave` AND `C`.`Estilo` = `PE`.`Estilo` JOIN `fichatecnica` AS `FT` ON `PE`.`Estilo` = `FT`.`Estilo` AND `PE`.`Color` = `FT`.`Color`
JOIN `articulos` AS `A` ON `FT`.`Articulo` = `A`.`Clave` JOIN `fraccionesxestilo` AS `FXE` ON `FXE`.`Estilo` = `FT`.`Estilo` JOIN `fracciones` AS `FR` ON `FXE`.`Fraccion` = `FR`.`Clave`
JOIN `estilostiempox` AS `TXE` ON `PE`.`Estilo` = `TXE`.`estilo`
WHERE FR.Departamento = 10 AND PE.Control = '{$CONTROL}'  AND `FXE`.`Fraccion` = '100' AND `A`.`Grupo` IN(1) GROUP BY `A`.`Descripcion`)
UNION
(SELECT  FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, A.Descripcion AS ARTICULO,
FR.Departamento AS CLAVE_DEPARTAMENTO, PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortef AS TIEMPO, (TXE.cortef) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS
FROM `pedidox` AS `PE` JOIN `colores` AS `C` ON `PE`.`Color` = `C`.`Clave` AND `C`.`Estilo` = `PE`.`Estilo`
JOIN `fichatecnica` AS `FT` ON `PE`.`Estilo` = `FT`.`Estilo` AND `PE`.`Color` = `FT`.`Color`
JOIN `articulos` AS `A` ON `FT`.`Articulo` = `A`.`Clave`
JOIN `fraccionesxestilo` AS `FXE` ON `FXE`.`Estilo` = `FT`.`Estilo` JOIN `fracciones` AS `FR` ON `FXE`.`Fraccion` = `FR`.`Clave`
JOIN  `estilostiempox` AS `TXE` ON `PE`.`Estilo` = `TXE`.`estilo`
 WHERE FR.Departamento = 10  AND PE.Control = '{$CONTROL}'  AND `FXE`.`Fraccion` = '99' AND `A`.`Grupo` IN(2,40) )")->result();
                    break;
            }
//            PRINT $this->db->last_query() . "\n";
//            exit(0);
            print json_encode($DTM);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onGuardarAsignacionDeDiaXControl() {
        try {

            $x = $this->input->post();

            $CONTROL = $x['CONTROL'];
            $FRACCIONES = json_decode($x['FRACCION']);
//            var_dump($FRACCIONES);
//            exit(0);
            for ($index = 0; $index < count($FRACCIONES); $index++) {
                $FRACCION = $FRACCIONES[$index]->FRACCIONES;
                $TIEMPO_PRECIO_ARTICULO_X_FRACCION = 0;
                switch (intval($FRACCION)) {
                    case 99:
                        $TIEMPO_PRECIO_ARTICULO_X_FRACCION = $this->db->query("SELECT FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, A.Descripcion AS ARTICULO,
FR.Departamento AS CLAVE_DEPARTAMENTO, PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortef AS TIEMPO, (TXE.cortef) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS FROM `pedidox` AS `PE`
JOIN `colores` AS `C` ON `PE`.`Color` = `C`.`Clave` AND `C`.`Estilo` = `PE`.`Estilo` JOIN `fichatecnica` AS `FT` ON `PE`.`Estilo` = `FT`.`Estilo` AND `PE`.`Color` = `FT`.`Color`
JOIN `articulos` AS `A` ON `FT`.`Articulo` = `A`.`Clave` JOIN `fraccionesxestilo` AS `FXE` ON `FXE`.`Estilo` = `FT`.`Estilo` JOIN `fracciones` AS `FR` ON `FXE`.`Fraccion` = `FR`.`Clave`
JOIN `estilostiempox` AS `TXE` ON `PE`.`Estilo` = `TXE`.`estilo`
WHERE FR.Departamento = 10  AND PE.Control = '{$CONTROL}'  AND `FXE`.`Fraccion` = '99' AND `A`.`Grupo` IN(2) GROUP BY `A`.`Descripcion`")->result();
                        break;
                    case 100:
                        $TIEMPO_PRECIO_ARTICULO_X_FRACCION = $this->db->query("(SELECT FT.Estilo AS ESTILO, FT.Color AS COLOR, C.Descripcion AS DES_COLOR, PE.Clave CLAVE_PEDIDO, FT.Articulo AS CLAVE_ARTICULO, FXE.Fraccion AS FRACCION, A.Descripcion AS ARTICULO,
FR.Departamento AS CLAVE_DEPARTAMENTO, PE.Pares AS PARES, FXE.CostoMO AS PRECIO, TXE.cortep AS TIEMPO, (TXE.cortep) AS TXPAR, (PE.Pares*FXE.CostoMO) AS PESOS FROM `pedidox` AS `PE`
JOIN `colores` AS `C` ON `PE`.`Color` = `C`.`Clave` AND `C`.`Estilo` = `PE`.`Estilo` JOIN `fichatecnica` AS `FT` ON `PE`.`Estilo` = `FT`.`Estilo` AND `PE`.`Color` = `FT`.`Color`
JOIN `articulos` AS `A` ON `FT`.`Articulo` = `A`.`Clave` JOIN `fraccionesxestilo` AS `FXE` ON `FXE`.`Estilo` = `FT`.`Estilo` JOIN `fracciones` AS `FR` ON `FXE`.`Fraccion` = `FR`.`Clave`
JOIN `estilostiempox` AS `TXE` ON `PE`.`Estilo` = `TXE`.`estilo`
WHERE FR.Departamento = 10  AND PE.Control = '{$CONTROL}'  AND `FXE`.`Fraccion` = '100' AND `A`.`Grupo` IN(1) GROUP BY `A`.`Descripcion`)")->result();
                        break;
                }

                $data = array(
                    'numemp' => $x['CORTADOR'],
                    'control' => $x['CONTROL'],
                    'año' => $x['ANIO'],
                    'semana' => $x['SEMANA'],
                    'diaprg' => $x['DIA'],
                    'frac' => $FRACCION,
                    'fecha' => Date('Y-m-d h:i:s'),
                    'estilo' => $x['ESTILO'],
                    'par' => $x['PARES'],
                    'tiempo' => $TIEMPO_PRECIO_ARTICULO_X_FRACCION[0]->TIEMPO,
                    'precio' => $TIEMPO_PRECIO_ARTICULO_X_FRACCION[0]->PRECIO,
                    'nomart' => $TIEMPO_PRECIO_ARTICULO_X_FRACCION[0]->ARTICULO
                );
                $this->db->insert('programacion', $data);
                $this->db->set('DiaProg', $x['DIA'])
                        ->set('SemProg', $x['SEMANA'])
                        ->set('AnioProg', $x['ANIO'])
                        ->set('FechaProg', Date('Y-m-d 00:00:00'))
                        ->set('HoraProg', Date('h:i:s'))
                        ->where('Control', $x['CONTROL'])
                        ->update('pedidox');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarAsignacion() {
        try {
            $this->db->delete('programacion', array('ID' => $this->input->post('ID')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAnadirAsignacion() {
        try {
            $x = $this->input;
            $data = ($this->adscpc->getEstiloColorParesTxParPorControl($x->post('CONTROL'), $x->post('FRACCION')));
            if (isset($data[0])) {
                $r = $data[0];
                $dtm = array(
                    'numemp' => $x->post('CORTADOR'),
                    'control' => $x->post('CONTROL'),
                    'año' => $x->post('ANIO'),
                    'semana' => $x->post('Semana'),
                    'diaprg' => $x->post('DIA'),
                    'frac' => $x->post('FRACCION'),
                    'fecha' => Date('Y-m-d 00:00:00'),
                    'estilo' => $x->post('Estilo'),
                    'par' => $x->post('Pares'),
                    'tiempo' => $r->TIEMPO,
                    'precio' => $r->PRECIO,
                    'nomart' => $x->CLAVE_ARTICULO
                );
                $this->db->insert('programacion', $dtm);
                /* Modificar en pedidox */
                $this->db->set('DiaProg', $x->post('DIA'))
                        ->set('SemProg', $x->post('Semana'))
                        ->set('AnioProg', $x->post('ANIO'))
                        ->set('FechaProg', Date('Y-m-d 00:00:00'))
                        ->set('HoraProg', Date('h:i:s'))
                        ->where('Control', $x->post('CONTROL'))
                        ->where_not_in("stsavan", array(13, 14))
                        ->update('pedidox');
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReporte() {
        try {
            $x = $this->input->post();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["ANO"] = $x['ANO'];
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\produccion\asidiacont.jasper');
            $jc->setFilename('asidiacont');
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getReportesXSemDiaAno() {
        try {
            $reports = array();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post();
            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["DIAT"] = $x['DIAT'];
            $P["ANO"] = $x['ANO'];

            /* 1. REPORTE Pares programados para corte de la sem - tiempos, pares, pares x tiempo , precio por par */
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\programacionxdiasem\asidiacont.jasper');
            $jc->setFilename('asidiacont_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports["1UNO"] = $jc->getReport();

            /* 2. REPORTE Entrega de material para corte del programa - agrupado empleado  */

            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["DIAT"] = $x['DIAT'];
            $P["ANO"] = $x['ANO'];
            if ($x['FRACCION'] !== "" || $x['FRACCION'] === 99 || $x['FRACCION'] === 100 ||
                    $x['FRACCION'] === "99" || $x['FRACCION'] === "100" || $x['FRACCION'] === "99,100") {
                switch ($x['FRACCION']) {
                    case "99":
                        $P["FRACCION"] = str_replace(",", "", $x['FRACCION']);
                        break;
                    case "100":
                        $P["FRACCION"] = str_replace(",", "", $x['FRACCION']);
                        break;
                    default :
                        $P["FRACCION"] = 0;
                        break;
                }
                $jc->setParametros($P);
                $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmatfraccion.jasper');
                $jc->setFilename('asidiacontmatfraccion_' . $P["FRACCION"] . '_' . Date('dmYhis'));
            } else {
                $jc->setParametros($P);
                $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmat.jasper');
                $jc->setFilename('asidiacontmat_' . Date('dmYhis'));
            }
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            /* 3. REPORTE Entrega de material para corte del programa - agrupado grupos de articulo */
            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["DIAT"] = $x['DIAT'];
            $P["ANO"] = $x['ANO'];
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmatg.jasper');
            $jc->setFilename('asidiacontmatg_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['3TRES'] = $jc->getReport();

            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    public function getReportesXSemDiaAno99() {
        try {
            $reports = array();
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $x = $this->input->post(); 
            /* 2. REPORTE Entrega de material para corte del programa - agrupado empleado  */

            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["DIAT"] = $x['DIAT'];
            $P["ANO"] = $x['ANO'];
            if ($x['FRACCION'] !== "" || $x['FRACCION'] === 99 || $x['FRACCION'] === 100 ||
                    $x['FRACCION'] === "99" || $x['FRACCION'] === "100" || $x['FRACCION'] === "99,100") {
                switch ($x['FRACCION']) {
                    case "99":
                        $P["FRACCION"] = str_replace(",", "", $x['FRACCION']);
                        break;
                    case "100":
                        $P["FRACCION"] = str_replace(",", "", $x['FRACCION']);
                        break;
                    default :
                        $P["FRACCION"] = 0;
                        break;
                }
                $jc->setParametros($P);
                $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmatfraccion99.jasper');
                $jc->setFilename('asidiacontmatfraccion_' . $P["FRACCION"] . '_' . Date('dmYhis'));
            } else {
                $jc->setParametros($P);
                $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmat.jasper');
                $jc->setFilename('asidiacontmat_' . Date('dmYhis'));
            }
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            /* 3. REPORTE Entrega de material para corte del programa - agrupado grupos de articulo */
            $P = array();
            $P["logo"] = base_url() . $this->session->LOGO;
            $P["empresa"] = $this->session->EMPRESA_RAZON;
            $P["SEMANA"] = $x['SEMANA'];
            $P["DIA"] = $x['DIA'];
            $P["DIAT"] = $x['DIAT'];
            $P["ANO"] = $x['ANO'];
            $jc->setParametros($P);
            $jc->setJasperurl('jrxml\programacionxdiasem\asidiacontmatg.jasper');
            $jc->setFilename('asidiacontmatg_' . Date('dmYhis'));
            $jc->setDocumentformat('pdf');
            $reports['3TRES'] = $jc->getReport();

            print json_encode($reports);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onRevisarSiYaEstaProgramadoConEsaFraccion() {
        try {
            $x = $this->input->get();
            $F = json_decode($x['FRACCIONES']);
            $ENCONTRADOS = 0;
            foreach ($F as $key => $v) {
                switch (intval($v->FRACCIONES)) {
                    case 99:
                        $FORRO = $this->db->query("SELECT COUNT(*) AS EXISTE_EN_FORRO FROM programacion AS P WHERE P.control = '{$x['CONTROL']}' AND P.frac = '99'")->result();
                        $ENCONTRADOS += intval($FORRO[0]->EXISTE_EN_FORRO);
                        break;
                    case 100:
                        $PIEL = $this->db->query("SELECT COUNT(*) AS EXISTE_EN_PIEL FROM programacion AS P WHERE P.control = '{$x['CONTROL']}' AND P.frac = '100'")->result();
                        $ENCONTRADOS += intval($PIEL[0]->EXISTE_EN_PIEL);
                        break;
                }
            }
            $EXISTE = '[{"ENCONTRADOS":"' . $ENCONTRADOS . '"}]';
            print $EXISTE;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
