<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class FichaTecnica extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->model('Fichatecnica_model', 'ftm');
    }

    public function index() {
        if (session_status() === 2 && isset($_SESSION["LOGGED"])) {
            $this->load->view('vEncabezado')->view('vFondo');

            switch ($this->session->userdata["TipoAcceso"]) {
                case 'SUPER ADMINISTRADOR':
                    $this->load->view('vNavGeneral');
                    //Validamos que no venga vacia y asignamos un valor por defecto
                    $Origen = isset($_GET['origen']) ? $_GET['origen'] : "";

                    if ($Origen === 'FICHASTECNICAS') {
                        $this->load->view('vMenuFichasTecnicas')->view('vFichaTecnica');
                    } else if ($Origen === 'MATERIALES') {
                        $this->load->view('vMenuMateriales')->view('vFichaTecnicaConsulta');
                    } else {
                        $this->load->view('vMenuPrincipal')->view('vFichaTecnica');
                    }
                    break;
                case 'DISEÑO Y DESARROLLO':
                    $this->load->view('vMenuFichasTecnicas')->view('vFichaTecnica');
                    break;
                case 'ALMACEN':
                    $this->load->view('vMenuMateriales')->view('vFichaTecnicaConsulta');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    if ($Seguridad === '1') {
                        $this->load->view('vFichaTecnica');
                    } else {
                        $this->load->view('vFichaTecnicaConsulta');
                    }
            }
            $this->load->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function getRecords() {
        try {
            $this->ftm->onLimpiarTabla();
            $this->ftm->onGenerarRecords();
            print json_encode($this->ftm->getRecords());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosRequeridos() {
        try {
            print json_encode($this->ftm->getArticulosRequeridos($this->input->get('Grupo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getGrupos() {
        try {
            print json_encode($this->ftm->getGrupos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilosFoto() {
        try {
            $burl = base_url();
            print json_encode(
                            $this->db->select('E.Clave AS CLAVE, CONCAT("' . $burl . '",E.Foto) AS URL, REPLACE(E.Foto,"uploads/Estilos/","") AS FOTO ', false)
                                    ->from('estilos AS E')->group_by('E.Foto')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onCopiarFT() {
        try {
            $ESTILOACOPIAR = $this->input->post('ESTILOACOPIAR');
            $COLORACOPIAR = $this->input->post('COLORACOPIAR');

            $ESTILO = $this->input->post('ESTILO');
            $COLOR = $this->input->post('COLOR');
            $ft = $this->db->select("FT.Estilo, FT.Color, FT.Pieza, FT.Articulo, FT.Precio, FT.Consumo, FT.PzXPar, FT.Estatus, FT.FechaAlta, FT.AfectaPV ")
                            ->from("fichatecnica AS FT")
                            ->where("Estilo LIKE '$ESTILOACOPIAR' AND Color = $COLORACOPIAR", null, false)
                            ->get()->result();
            foreach ($ft as $k => $v) {
                $nft = array(
                    'Estilo' => $ESTILO,
                    'Color' => $COLOR,
                    'Pieza' => $v->Pieza,
                    'Articulo' => $v->Articulo,
                    'Precio' => $v->Precio,
                    'Consumo' => $v->Consumo,
                    'PzXPar' => $v->PzXPar,
                    'Estatus' => $v->Estatus,
                    'FechaAlta' => Date('d/m/Y'),
                    'AfectaPV' => $v->AfectaPV
                );
                $this->db->insert('fichatecnica', $nft);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichasXEstilo() {
        try {
            $Estilo = $this->input->get('ESTILO');
            print json_encode(
                            $this->db->query("SELECT COUNT(*) AS FICHAS_X_ESTILO FROM "
                                    . "(SELECT COUNT(*) FROM fichatecnica AS FT "
                                    . "WHERE FT.Estilo LIKE '$Estilo' "
                                    . "GROUP BY FT.Estilo, FT.Color) AS X")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichasAEliminarXEstilo() {
        try {
            $Estilo = $this->input->get('ESTILO');
            print json_encode(
                            $this->db->query("SELECT COUNT(*) AS FICHAS_A_ELIMINAR FROM "
                                    . "(SELECT COUNT(*) FROM fichatecnica AS FT "
                                    . "WHERE FT.Estilo LIKE '$Estilo' "
                                    . "GROUP BY FT.Estilo, FT.Color) AS X")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarFTXEstilo() {
        try {
            $Estilo = $this->input->post('ESTILO');
            $x = $this->db;
            $x->trans_begin();
            $this->db->where('Estilo', $Estilo);
            $this->db->delete('fichatecnica');
            if ($x->trans_status() === FALSE) {
                $x->trans_rollback();
            } else {
                $x->trans_commit();
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezas() {
        try {
            print json_encode($this->ftm->getPiezas());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulos() {
        try {
            print json_encode($this->ftm->getArticulos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosSuplex() {
        try {
            print json_encode($this->ftm->getArticulosSuplex());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getArticulosByClave() {
        try {
            print json_encode($this->ftm->getArticulosByClave($this->input->post('Articulo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onComprobarExisteEstiloColor() {
        try {
            print json_encode($this->ftm->onComprobarExisteEstiloColor($this->input->get('Estilo'), $this->input->get('Color')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilos() {
        try {
            print json_encode($this->ftm->getEstilos());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineas() {
        try {
            print json_encode(
                            $this->db->query("SELECT  L.Clave AS CLAVE, CONCAT(L.Clave,\" \",L.Descripcion) AS LINEA FROM lineas AS L ORDER BY L.Clave ASC;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNumPiezasASuplir() {
        try {
            $PZA = $this->input->get('PZA');
            print json_encode(
                            $this->db->query("SELECT COUNT(*) AS PIEZAS_A_SUPLIR FROM (SELECT FT.ID FROM fichatecnica AS FT WHERE FT.Pieza = $PZA GROUP BY Estilo, Color) AS PIEZAS_A_SUPLIR;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNumMaterialesASuplir() {
        try {
            $MATERIAL = $this->input->get('MATERIAL');
            print json_encode(
                            $this->db->query("SELECT COUNT(*) AS MATERIALES_A_SUPLIR FROM (SELECT FT.ID FROM fichatecnica AS FT WHERE Articulo = $MATERIAL GROUP BY Estilo, Color) AS MATERIALES_A_SUPLIR;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNumMaterialesASuplirXLinea() {
        try {
            $LINEA = $this->input->get('LINEA');
            $MATERIAL = $this->input->get('MATERIAL');
            print json_encode(
                            $this->db->query("SELECT COUNT(*) AS MATERIALES_A_SUPLIR_X_LIN FROM (SELECT FT.ID FROM fichatecnica AS FT INNER JOIN estilos AS E ON FT.Estilo = E.Clave  WHERE FT.Articulo = $MATERIAL AND E.Linea = $LINEA GROUP BY FT.Estilo, FT.Color) AS MATERIALES_A_SUPLIR_X_LIN;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getNumMaterialesASuplirXConsumo() {
        try {
            $ESTILO = $this->input->get('ESTILO');
            $PZA = $this->input->get('PZA');
            $MATERIAL = $this->input->get('MATERIAL');
            print json_encode(
                            $this->db->query("SELECT COUNT(*) AS MATERIALES_A_SUPLIR FROM (SELECT FT.ID FROM fichatecnica AS FT INNER JOIN estilos AS E ON FT.Estilo = E.Clave  WHERE FT.Articulo = $MATERIAL AND FT.Pieza = $PZA AND E.Clave = $ESTILO GROUP BY FT.Estilo, FT.Color) AS MATERIALES_A_SUPLIR;")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSuplirPieza() {
        try {
            $PZA = $this->input->post('PZA');
            $PZANUEVA = $this->input->post('PZANUEVA');
            $this->db->set('Pieza', $PZANUEVA)
                    ->where('Pieza', $PZA)
                    ->update('fichatecnica');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSuplirMaterialArticulo() {
        try {
            $MATERIAL = $this->input->post('MATERIAL');
            $MATERIALNUEVO = $this->input->post('MATERIALNUEVO');
            $this->db->set('Articulo', $MATERIALNUEVO)
                    ->where('Articulo', $MATERIAL)
                    ->update('fichatecnica');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSuplirMaterialArticuloXLinea() {
        try {
            $LINEA = $this->input->post('LINEA');
            $MATERIAL = $this->input->post('MATERIAL');
            $MATERIALNUEVO = $this->input->post('MATERIALNUEVO');
            $CONSUMO = $this->input->post('CONSUMO');
            if ($CONSUMO !== '' && intval($CONSUMO) > 0) {
                $this->db->query("UPDATE fichatecnica AS FT 
                INNER JOIN estilos AS E ON FT.Estilo = E.Clave 
                SET FT.Articulo = {$MATERIALNUEVO} 
            WHERE E.Linea = {$LINEA}  AND FT.Articulo = $MATERIAL;");
            } else {
                $this->db->query("UPDATE fichatecnica AS FT 
                INNER JOIN estilos AS E ON FT.Estilo = E.Clave 
                SET FT.Articulo = {$MATERIALNUEVO} , FT.Consumo = {$CONSUMO}
            WHERE E.Linea = {$LINEA}  AND FT.Articulo = {$MATERIAL};");
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onSuplirConsumos() {
        try {
            $ESTILO = $this->input->get('ESTILO');
            $PZA = $this->input->get('PZA');
            $MATERIAL = $this->input->get('MATERIAL');
            $NUEVOCONSUMO = $this->input->get('NUEVOCONSUMO');

            $this->db->set('Consumo', $NUEVOCONSUMO)
                    ->where('Estilo', $ESTILO)
                    ->where('Pieza', $PZA)
                    ->where('Articulo', $MATERIAL)
                    ->update('fichatecnica');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezasTable() {
        try {
            $PZA = $this->input->get('PZA');
            $this->db->select('FT.ID,FT.Estilo AS ESTILO, FT.Color AS COLOR, '
                            . 'FT.Pieza AS PIEZA, P.Descripcion AS PIEZAT,  '
                            . 'P.Departamento AS SEC, FT.Articulo AS ARTICULO, '
                            . 'A.Descripcion AS ARTICULOT, '
                            . 'FT.Consumo AS CONSUMO, P.Rango AS RANGO', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave');
            if ($PZA !== '') {
                $this->db->where('FT.Pieza', $PZA);
            } else {
                $this->db->limit(999);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezasMaterial() {
        try {
            $MATERIAL = $this->input->get('MATERIAL');
            $this->db->select('FT.ID,FT.Estilo AS ESTILO, FT.Color AS COLOR, '
                            . 'FT.Pieza AS PIEZA, P.Descripcion AS PIEZAT,  '
                            . 'P.Departamento AS SEC, FT.Articulo AS ARTICULO, '
                            . 'A.Descripcion AS ARTICULOT, '
                            . 'FT.Consumo AS CONSUMO, P.Rango AS RANGO', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave');
            if ($MATERIAL !== '') {
                $this->db->where('FT.Articulo', $MATERIAL);
            } else {
                $this->db->limit(2000);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezasMaterialXLinea() {
        try {
            $LINEA = $this->input->get('LINEA');
            $MATERIAL = $this->input->get('MATERIAL');
            $this->db->select('FT.ID,FT.Estilo AS ESTILO, FT.Color AS COLOR, '
                            . 'FT.Pieza AS PIEZA, P.Descripcion AS PIEZAT,  '
                            . 'P.Departamento AS SEC, FT.Articulo AS ARTICULO, '
                            . 'A.Descripcion AS ARTICULOT, '
                            . 'FT.Consumo AS CONSUMO, P.Rango AS RANGO', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('estilos AS E', 'FT.Estilo = E.Clave');
            if ($LINEA !== '') {
                $this->db->where('E.Linea', $LINEA);
            }
            if ($MATERIAL !== '') {
                $this->db->where('FT.Articulo', $MATERIAL);
            }
            if ($LINEA === '' && $MATERIAL === '') {
                $this->db->limit(2000);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPiezasMaterialXConsumos() {
        try {
            $ESTILO = $this->input->get('ESTILO');
            $PIEZA = $this->input->get('PIEZA');
            $MATERIAL = $this->input->get('MATERIAL');
            $this->db->select('FT.ID,FT.Estilo AS ESTILO, FT.Color AS COLOR, '
                            . 'FT.Pieza AS PIEZA, P.Descripcion AS PIEZAT,  '
                            . 'P.Departamento AS SEC, FT.Articulo AS ARTICULO, '
                            . 'A.Descripcion AS ARTICULOT, '
                            . 'FT.Consumo AS CONSUMO, P.Rango AS RANGO', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('estilos AS E', 'FT.Estilo = E.Clave');
            if ($ESTILO !== '') {
                $this->db->where('E.Clave', $ESTILO);
            }
            if ($PIEZA !== '') {
                $this->db->where('FT.Pieza', $PIEZA);
            }
            if ($MATERIAL !== '') {
                $this->db->where('FT.Articulo', $MATERIAL);
            }
            if ($ESTILO === '' && $PIEZA === '' && $MATERIAL === '') {
                $this->db->limit(2000);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getLineaPiezasMaterialXConsumos() {
        try {
            $LINEA = $this->input->get('LINEA');
            $PIEZA = $this->input->get('PIEZA');
            $MATERIAL = $this->input->get('MATERIAL');
            $this->db->select('FT.ID,E.Linea AS LINEA, FT.Estilo AS ESTILO, FT.Color AS COLOR, '
                            . 'FT.Pieza AS PIEZA, P.Descripcion AS PIEZAT,  '
                            . 'P.Departamento AS SEC, FT.Articulo AS ARTICULO, '
                            . 'A.Descripcion AS ARTICULOT, '
                            . 'FT.Consumo AS CONSUMO, P.Rango AS RANGO', false)
                    ->from('fichatecnica AS FT')
                    ->join('piezas AS P', 'FT.Pieza = P.Clave')
                    ->join('articulos AS A', 'FT.Articulo = A.Clave')
                    ->join('estilos AS E', 'FT.Estilo = E.Clave');
            if ($LINEA !== '') {
                $this->db->where('E.Linea', $LINEA);
            }
            if ($PIEZA !== '') {
                $this->db->where('FT.Pieza', $PIEZA);
            }
            if ($MATERIAL !== '') {
                $this->db->where('FT.Articulo', $MATERIAL);
            }
            if ($LINEA === '' && $PIEZA === '' && $MATERIAL === '') {
                $this->db->limit(2000);
            }
            print json_encode($this->db->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilosByLinea() {
        try {
            print json_encode($this->ftm->getEstilosByLinea($this->input->get('Linea')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstiloByID() {
        try {
            print json_encode($this->ftm->getEstiloByID($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getEstilosConsumos() {
        try {
            print json_encode(
                            $this->db->select('E.Clave AS CLAVE, CONCAT(E.Clave," - ",E.Descripcion) AS ESTILO ', false)
                                    ->from('fichatecnica AS FT')
                                    ->join('estilos AS E', 'FT.Estilo = E.Clave')
                                    ->group_by('FT.Estilo')->get()->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaFija() {
        try {

            $ESTILO = $this->input->post('ESTILO');
            $COLOR = $this->input->post('COLOR');

            $ftf = $this->db->select("(SELECT PM.Precio FROM preciosmaquilas AS PM WHERE PM.Articulo = A.Clave LIMIT 1) AS PRECIO,
                            FTF.Pieza AS CLAVE_PIEZA, P.Descripcion AS PIEZA, 
                            FTF.Articulo AS CLAVE_ARTICULO, A.Descripcion AS ARTICULO,
                            A.UnidadMedida AS UNIDAD,  FTF.Consumo AS CONSUMO, 0 AS pzXPar, 0 AS ID,
                            CONCAT(D.Clave, ' - ', D.Descripcion) AS DeptoCat, D.Clave AS DEPTO", false)
                            ->from('fichatecnicafija AS FTF')
                            ->join('piezas AS P', 'FTF.Pieza = P.Clave')
                            ->join('articulos AS A', 'A.Clave = FTF.Articulo')
                            ->join('departamentos AS D', 'D.Clave = P. Departamento')
                            ->get()->result();

            foreach ($ftf as $k => $v) {
                $ftf = array('Estilo' => $ESTILO, 'Color' => $COLOR,
                    'Pieza' => $v->CLAVE_PIEZA, 'Articulo' => $v->CLAVE_ARTICULO,
                    'Precio' => $v->PRECIO, 'Consumo' => $v->CONSUMO, 'PzXPar' => 0, 'Estatus' => 'ACTIVO', 'FechaAlta' => Date('d/m/Y'), 'AfectaPV' => 0);
                $this->db->insert('fichatecnica', $ftf);
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getColoresXEstilo() {
        try {
            print json_encode($this->ftm->getColoresXEstilo($this->input->get('Estilo')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaDetalleByID() {
        try {
            print json_encode($this->ftm->getFichaTecnicaDetalleByID($this->input->get('Estilo'), $this->input->get('Color')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getFichaTecnicaByEstiloByColor() {
        try {
            print json_encode($this->ftm->getFichaTecnicaByEstiloByColor($this->input->get('Estilo'), $this->input->get('Color')));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onAgregar() {
        try {
            $x = $this->input;
            $PRECIO = $this->ftm->getPrecioPorArticuloByID($x->post('Articulo'));
            $data = array(
                'Estilo' => ($x->post('Estilo') !== NULL) ? $x->post('Estilo') : NULL,
                'Color' => ($x->post('Color') !== NULL) ? $x->post('Color') : NULL,
                'Pieza' => ($x->post('Pieza') !== NULL) ? $x->post('Pieza') : NULL,
                'Articulo' => ($x->post('Articulo') !== NULL) ? $x->post('Articulo') : NULL,
                'Consumo' => ($x->post('Consumo') !== NULL) ? $x->post('Consumo') : 0,
                'PzXPar' => ($x->post('PzXPar') !== NULL) ? $x->post('PzXPar') : NULL,
                'AfectaPV' => ($x->post('AfectaPV') !== NULL) ? $x->post('AfectaPV') : 0,
                'Estatus' => 'ACTIVO'
            );
            if (isset($PRECIO[0])) {
                $data["Precio"] = $PRECIO[0]->PRECIO;
            } else {
                $data["Precio"] = 0;
            }
            $ID = $this->ftm->onAgregar($data);
            print $ID;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificarDetalle() {
        try {
            $x = $this->input;
            $data = array(
                'Pieza' => ($x->post('Pieza') !== NULL) ? $x->post('Pieza') : NULL,
                'Articulo' => ($x->post('Articulo') !== NULL) ? $x->post('Articulo') : NULL,
                'Consumo' => ($x->post('Consumo') !== NULL) ? $x->post('Consumo') : 0,
                'PzXPar' => ($x->post('PzXPar') !== NULL) ? $x->post('PzXPar') : NULL,
                'AfectaPV' => ($x->post('AfectaPV') !== NULL) ? $x->post('AfectaPV') : 0,
            );
            $this->ftm->onModificar($this->input->post('ID'), $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminar() {
        try {
            $this->ftm->onEliminar($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarRenglonDetalle() {
        try {
            $this->ftm->onEliminarRenglonDetalle($this->input->post('ID'));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onEliminarArticuloID() {
        try {
            $this->db->where('ID', $this->input->post('ID'))->delete('fichatecnica');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirFraccionesXEstilo() {
        $cm = $this->FraccionesXEstilo_model;

        $DatosEmpresa = $cm->getDatosEmpresa();
        $Encabezado = $cm->getEncabezadoFXE($this->input->get('Estilo'));
        $Departamentos = $cm->getDeptosFXE($this->input->get('Estilo'));
        $Fracciones = $cm->getFraccionesFXE($this->input->get('Estilo'));

        if (!empty($Encabezado)) {

            $pdf = new PDF('P', 'mm', array(215.9, 279.4));

            $pdf->Logo = $DatosEmpresa[0]->Logo;
            $pdf->Empresa = $DatosEmpresa[0]->Empresa;
            $pdf->Estilo = $Encabezado[0]->ESTILO;
            $pdf->Clinea = $Encabezado[0]->CLINEA;
            $pdf->Dlinea = $Encabezado[0]->DLINEA;

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 10);

            $GTotalD_CVTA = 0;
            $GTotalD_CMO = 0;
            foreach ($Departamentos as $key => $D) {
                $pdf->SetX(5);
                $pdf->SetFont('Arial', 'BI', 8.5);
                $pdf->Cell(10, 5, utf8_decode($D->CDEPTO) . ' ' . utf8_decode($D->DDEPTO), 0/* BORDE */, 1, 'L');

                $TotalD_CVTA = 0;
                $TotalD_CMO = 0;
                foreach ($Fracciones as $key => $F) {
                    if ($F->CDEPTO === $D->CDEPTO) {

                        $pdf->SetFont('Arial', '', 7.5);
                        $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
                        $aligns = array('L', 'L', 'L', 'L');
                        $pdf->SetAligns($aligns);
                        $pdf->SetWidths($anchos);
                        $pdf->SetMarginLeft(70);
                        $pdf->RowX(array(
                            utf8_decode($F->CFRACCION),
                            utf8_decode($F->DFRACCION),
                            utf8_decode($F->COSTOMO),
                            utf8_decode($F->COSTOVTA)
                        ));

                        $TotalD_CVTA += $F->COSTOVTA;
                        $TotalD_CMO += $F->COSTOMO;

                        $GTotalD_CVTA += $F->COSTOVTA;
                        $GTotalD_CMO += $F->COSTOMO;
                    }
                }
                $pdf->SetX(110);
                $pdf->SetFont('Arial', 'BI', 8.5);
                $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
                $aligns = array('L', 'C', 'L', 'L');
                $pdf->SetAligns($aligns);
                $pdf->SetWidths($anchos);
                $pdf->SetMarginLeft(70);
                $pdf->RowNoBorder(array(
                    "",
                    "Total x Depto",
                    $TotalD_CVTA,
                    $TotalD_CMO
                ));
            }
            $pdf->SetX(110);
            $pdf->SetFont('Arial', 'BI', 9.5);
            $anchos = array(10/* 0 */, 80/* 0 */, 30/* 1 */, 15/* 2 */);
            $aligns = array('L', 'C', 'L', 'L');
            $pdf->SetAligns($aligns);
            $pdf->SetWidths($anchos);
            $pdf->SetMarginLeft(70);
            $pdf->RowNoBorder(array(
                "",
                "Total x Estilo",
                $GTotalD_CVTA,
                $GTotalD_CMO
            ));


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Nomina';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "FRACCIONES POR ESTILO " . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Nomina/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

}
