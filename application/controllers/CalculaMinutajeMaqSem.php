<?php

require_once APPPATH . "/third_party/fpdf17/fpdf.php";
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";

class CalculaMinutajeMaqSem extends CI_Controller {

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
                    $this->load->view('vNavGeneral');
                    $this->load->view('vMenuProduccion');
                    break;
                case 'RECURSOS HUMANOS':
                    $this->load->view('vMenuNomina');
                    break;
                case 'INGENIERIA':
                    $this->load->view('vMenuIngenieria');
                    break;
                case 'PRODUCCION':
                    $this->load->view('vMenuProduccion');
                    break;
            }

            $this->load->view('vFondo')->view('vCalculaMinutajeMaqSem')->view('vFooter');
        } else {
            $this->load->view('vEncabezado')->view('vSesion')->view('vFooter');
        }
    }

    public function onCerrarSemana() {
        try {
            $x = $this->input->post();

            $data = array(
                'año' => $x['ano'],
                'sem' => $x['sem'],
                'maq' => $x['maq'],
                'pares' => $x['pares'],
                'minutos' => $x['minutos'],
                'fecha' => Date('Y-m-d H:i:s'),
                'ticor' => $x['tecorte'],
                'tiray' => $x['terayado'],
                'tireb' => $x['terebaja'],
                'tifol' => $x['tefolead'],
                'tient' => $x['teentrete'],
                'tipes' => $x['tepespu'],
                'tiens' => $x['teensuel'],
                'tiprp' => $x['teprepes'],
                'titej' => $x['tetejido'],
                'timon' => $x['temontado'],
                'tiado' => $x['teadorno'],
                'titot' => $x['tetotal'],
                'pecor' => $x['pcorte'],
                'peray' => $x['prayado'],
                'pereb' => $x['prebaja'],
                'pefol' => $x['pfolead'],
                'peent' => $x['pentrete'],
                'pepes' => $x['ppespu'],
                'peens' => $x['pensuel'],
                'peprp' => $x['pprepes'],
                'petej' => $x['ptejido'],
                'pemon' => $x['pmontado'],
                'peado' => $x['padorno'],
                'petot' => $x['ptotal'],
                'micor' => $x['mcorte'],
                'miray' => $x['mrayado'],
                'mireb' => $x['mrebaja'],
                'mifol' => $x['mfolead'],
                'mient' => $x['mentrete'],
                'mipes' => $x['mpespu'],
                'miens' => $x['mensuel'],
                'miprp' => $x['mprepes'],
                'mitej' => $x['mtejido'],
                'mimon' => $x['mmontado'],
                'miado' => $x['madorno'],
                'mitot' => $x['mtotal'],
                'dicor' => $x['dcorte'],
                'diray' => $x['drayado'],
                'direb' => $x['drebaja'],
                'difol' => $x['dfolead'],
                'dient' => $x['dentrete'],
                'dipes' => $x['dpespu'],
                'diens' => $x['densuel'],
                'diprp' => $x['dprepes'],
                'ditej' => $x['dtejido'],
                'dimon' => $x['dmontado'],
                'diado' => $x['dadorno'],
                'ditot' => $x['dtotal']
            );
            $this->db->insert("cierrasem", $data);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPersonal() {
        try {
            $maq = $this->input->get('maq');
            if ($maq === '1') {
                print json_encode($this->db->query("select
                                                ifnull(count(case when e.departamentofisico ='10' then numero end),0) as corte,
                                                ifnull(count(case when e.departamentofisico ='20' then numero end),0) as rayado,
                                                ifnull(count(case when e.departamentofisico ='30' then numero end),0) as rebajado,
                                                ifnull(count(case when e.departamentofisico ='40' then numero end),0) as foleado,
                                                ifnull(count(case when e.departamentofisico ='90' then numero end),0) as entrete,
                                                ifnull(count(case when e.departamentofisico ='110' then numero end),0) as pespu,
                                                ifnull(count(case when e.departamentofisico ='140' then numero end),0) as ensuelado,
                                                ifnull(count(case when e.departamentofisico ='120' then numero end),0) as prepes,
                                                ifnull(count(case when e.departamentofisico ='60' then numero end),0) as laser,
                                                ifnull(count(case when e.departamentofisico in('180','190') then numero end),0) as montado,
                                                ifnull(count(case when e.departamentofisico in('210','220') then numero end),0) as adorno
                                                from empleados e
                                                where e.AltaBaja = '1' ")->result());
            } else {
                print json_encode($this->db->query("SELECT
                                                dep10 as corte ,
                                                dep15 as rayado,
                                                dep20 as rebajado,
                                                dep24 as foleado,
                                                dep35 as entrete,
                                                dep40 as pespu,
                                                dep46 as ensuelado,
                                                dep45 as prepes,
                                                dep60 as laser,
                                                dep80 as montado,
                                                dep90 as adorno
                                                FROM deptosmaq where numcia = $maq ")->result());
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getTiemposEstilo() {
        try {
            $estilo = $this->input->get('Estilo');
            print json_encode($this->db->query("select * from estilostiempox where estilo= '$estilo' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPedidosParaMinutaje() {
        try {
            $Ano = $this->input->get('Ano');
            $Sem = $this->input->get('Sem');
            $Maq = $this->input->get('Maq');
            print json_encode($this->db->query("select
                                                pe.estilo, sum(pe.pares) as pares
                                                from pedidox pe where pe.ano = $Ano and pe.maquila = $Maq and pe.semana = $Sem and pe.estatus <> 'C'
                                                group by pe.estilo ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getPares() {
        try {
            $Ano = $this->input->get('Ano');
            $Sem = $this->input->get('Sem');
            $Maq = $this->input->get('Maq');
            print json_encode($this->db->query("select IFNULL(sum(pares),0) as pares from pedidox where ano = $Ano and maquila = $Maq and semana = $Sem and estatus <> 'C' ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistrosPorCliente() {
        try {
            $Cliente = $this->input->get('Cliente');
            $Pedido = $this->input->get('Pedido');
            print json_encode($this->db->query("select "
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', clave ,''' onchange=''onModificarPedido(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')"
                                    . "else clave "
                                    . "end as pedido, "
                                    . ""
                                    . "cliente,
                                    (select razons from clientes where clave = cliente) as nomcliente,
                                     "
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', FechaEntrega ,''' onchange=''onModificarFechaEntrega(this.value,',ID ,')'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />') "
                                    . "else FechaEntrega "
                                    . "end as fecent, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', ano ,''' onchange=''onModificarAno(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')   "
                                    . "else ano "
                                    . "end as ano, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', semana ,''' onchange=''onModificarSemana(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')  "
                                    . "else semana "
                                    . "end as semana, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', maquila ,''' onchange=''onModificarMaquila(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')  "
                                    . "else maquila "
                                    . "end as maquila, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', estilo ,''' onchange=''onModificarEstilo(this.value,',ID ,')'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />') "
                                    . "else estilo "
                                    . "end as estilo,"
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', color ,''' onchange=''onModificarColor(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')  "
                                    . "else color "
                                    . "end as color, "
                                    . ""
                                    . "pares,
                                       stsavan,
                                       precio, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', Observacion ,''' onchange=''onModificarObservacion(this.value,',ID ,')'' class=''form-control form-control-sm fat'' onpaste= ''return false;''  />')  "
                                    . "else Observacion "
                                    . "end as Observacion, "
                                    . ""
                                    . "ObservacionDetalle
                                    from pedidox where cliente = $Cliente and clave = $Pedido and estatus <> 'C'
  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getRegistros() {
        try {
            $Ano = $this->input->get('Ano');
            $Sem = $this->input->get('Sem');
            $Maq = $this->input->get('Maq');
            print json_encode($this->db->query("select "
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', clave ,''' onchange=''onModificarPedido(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')"
                                    . "else clave "
                                    . "end as pedido, "
                                    . ""
                                    . "cliente,
                                    (select razons from clientes where clave = cliente) as nomcliente,
                                     "
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', FechaEntrega ,''' onchange=''onModificarFechaEntrega(this.value,',ID ,')'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />') "
                                    . "else FechaEntrega "
                                    . "end as fecent, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', ano ,''' onchange=''onModificarAno(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')   "
                                    . "else ano "
                                    . "end as ano, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', semana ,''' onchange=''onModificarSemana(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')  "
                                    . "else semana "
                                    . "end as semana, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', maquila ,''' onchange=''onModificarMaquila(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')  "
                                    . "else maquila "
                                    . "end as maquila, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', estilo ,''' onchange=''onModificarEstilo(this.value,',ID ,')'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />') "
                                    . "else estilo "
                                    . "end as estilo,"
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', color ,''' onchange=''onModificarColor(this.value,',ID ,')'' onkeypress=''validate(event, this.value);'' class=''form-control form-control-sm slim'' onpaste= ''return false;''  />')  "
                                    . "else color "
                                    . "end as color, "
                                    . ""
                                    . "pares,
                                       stsavan,
                                       precio, "
                                    . ""
                                    . "case when stsavan not in ('13','14') then "
                                    . "CONCAT('<input type=''text'' value=''', Observacion ,''' onchange=''onModificarObservacion(this.value,',ID ,')'' class=''form-control form-control-sm fat'' onpaste= ''return false;''  />')  "
                                    . "else Observacion "
                                    . "end as Observacion, "
                                    . ""
                                    . "ObservacionDetalle
                                    from pedidox where ano =$Ano and maquila = $Maq and semana = $Sem and estatus <> 'C'
  ")->result());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onModificar() {
        try {
            extract($this->input->post());
            $ID = $this->input->post('ID');
            unset($_POST['ID']);
            $this->db->where('ID', $ID);
            $this->db->update("pedidox", $this->input->post());
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function onImprimirHistorico() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->get('Ano');
        $parametros["sem"] = $this->input->get('Sem');
        $parametros["maq"] = $this->input->get('Maq');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\minutajes\reporteMinutajeHistorico.jasper');
        $jc->setFilename('REPORTAJE_MINUTAJE_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

}
