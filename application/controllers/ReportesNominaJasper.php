<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . "/third_party/JasperPHP/src/JasperPHP/JasperPHP.php";
require_once APPPATH . "/third_party/fpdf17/fpdf.php";

class ReportesNominaJasper extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session')->helper('jaspercommand_helper')->helper('file')->helper('ReporteManoObraDestajo_helper');
        date_default_timezone_set('America/Mexico_City');

        setlocale(LC_ALL, "");
        setlocale(LC_TIME, 'spanish');
    }

    public function onImprimirCostoMOGen() {

        $this->db->query("truncate table costomanoobratemp");
        $Ano = $this->input->post('AnoCostoMOGen');
        $Sem = $this->input->post('SemCostoMOGen');

        $RegistrosNomina = $this->db->query("
                        SELECT  p.salario,
                                p.salariod,
                                p.horext,
                                p.otrper,
                                cast(ifnull(D.Clave,'999')as signed) as numdepto,
                                ifnull(D.Descripcion,'NO EXISTE DEPTO') as nomdepto,
                                E.FijoDestajoAmbos as tiposal,
                                p.numemp
                        from prenominal p
                        join empleados E on E.numero =  p.numemp
                        left join departamentos D on E.DepartamentoFisico = D.Clave
                        where p.año = $Ano
                        and p.numsem = $Sem
                        order by  numdepto asc ")->result();

        $sql = '';
        foreach ($RegistrosNomina as $key => $v) {

            $salario = floatval($v->salario);
            $salariod = floatval($v->salariod);
            $bonos = floatval($v->horext);
            $extras = floatval($v->otrper);


            $Temp = $this->db->query("select depto from costomanoobratemp where depto = $v->numdepto ")->result();
            if (empty($Temp)) { //si no existe inserta
                $this->db->insert("costomanoobratemp", array(
                    'depto' => $v->numdepto,
                    'nombreDepto' => $v->nomdepto,
                    'salario' => $salario,
                    'salariod' => $salariod,
                    'bonos' => $bonos,
                    'extras' => $extras
                ));
            } else { // si existe acumula
                $sql = "UPDATE costomanoobratemp set "
                        . "salariod = ifnull(salariod,0) + $salariod  , "
                        . "salario = ifnull(salario,0) + $salario  , "
                        . "bonos = ifnull(bonos,0) + $bonos , "
                        . "extras =ifnull(extras,0) + $extras "
                        . "WHERE depto = $v->numdepto ";
                $this->db->query($sql);
            }
        }
        /* reporte */

        $Total_Col_Por = $this->db->query("
select
SUM(
ifnull((ifnull(CMT.salario,0)+ifnull(CMT.salariod,10)+ifnull(CMT.bonos,0)+ifnull(CMT.extras,0))/
(case
when CMT.depto = 10 then -- corte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 10 and fpn.numeroempleado <> 2721 and fpn.numfrac <> 99
    ),0)
when CMT.depto = 70 then -- prel corte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 70 and fpn.numfrac = 60
    ),0)
when CMT.depto = 80 then  -- rayado contado
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 80 and fpn.numfrac = 102
    ),0)
when CMT.depto = 110 then  -- pespunte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 300
    ),0)
when CMT.depto = 170 then -- choferes
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 600
    ),0)
when CMT.depto > 220 then -- todo ls que es mayor a adorno b
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 600
    ),0)
else
    ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = CMT.depto
    ),0)
end),0)
)AS totalCostoMo
FROM costomanoobratemp CMT
")->result()[0]->totalCostoMo;

        $Registros = $this->db->query("
select
(select count(numero) from empleados where departamentofisico = CMT.depto and altabaja = 1) as totalemp,
CMT.depto,
CMT.nombreDepto,
CMT.salario,
CMT.salariod,
CMT.bonos,
CMT.extras,
ifnull(CMT.salario,0)+ifnull(CMT.salariod,10)+ifnull(CMT.bonos,0)+ifnull(CMT.extras,0) as total,
case
when CMT.depto = 10 then -- corte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 10 and fpn.numeroempleado <> 2721 and fpn.numfrac <> 99
    ),0)
when CMT.depto = 70 then -- prel corte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 70 and fpn.numfrac = 60
    ),0)
when CMT.depto = 80 then  -- rayado contado
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 80 and fpn.numfrac = 102
    ),0)
when CMT.depto = 110 then  -- pespunte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 300
    ),0)
when CMT.depto = 170 then -- choferes
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 600
    ),0)
when CMT.depto > 220 then -- todo ls que es mayor a adorno b
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 600
    ),0)
else
    ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = CMT.depto
    ),0)
end as pares,
ifnull((ifnull(CMT.salario,0)+ifnull(CMT.salariod,10)+ifnull(CMT.bonos,0)+ifnull(CMT.extras,0))/
(case
when CMT.depto = 10 then -- corte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 10 and fpn.numeroempleado <> 2721 and fpn.numfrac <> 99
    ),0)
when CMT.depto = 70 then -- prel corte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 70 and fpn.numfrac = 60
    ),0)
when CMT.depto = 80 then  -- rayado contado
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = 80 and fpn.numfrac = 102
    ),0)
when CMT.depto = 110 then  -- pespunte
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 300
    ),0)
when CMT.depto = 170 then -- choferes
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 600
    ),0)
when CMT.depto > 220 then -- todo ls que es mayor a adorno b
	ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and fpn.numfrac = 600
    ),0)
else
    ifnull((
	SELECT sum(fpn.pares) FROM fracpagnomina fpn
	join empleados E  on fpn.numeroempleado = E.numero
	where fpn.anio = $Ano and fpn.semana = $Sem and E.DepartamentoFisico = CMT.depto
    ),0)
end),0) as costoMo
FROM costomanoobratemp CMT
                ")->result();
        if (!empty($Registros)) {

            $pdf = new PDFManoObraGeneral('L', 'mm', array(215.9, 279.4));
            $pdf->setSem($Sem);
            $pdf->setAno($Ano);

            $pdf->AddPage();
            $pdf->SetAutoPageBreak(true, 6);
            $pdf->SetLineWidth(0.2);

            $TP1 = 0;
            $TPe1 = 0;
            $TP2 = 0;
            $TPe2 = 0;
            $TP3 = 0;
            $TPe3 = 0;
            $TPe4 = 0;
            $TP5 = 0;

            $pdf->SetFont('Calibri', '', 8);
            $Porcentaje = 0;
            foreach ($Registros as $key => $R) {

                //Calcula por renglon
                $Porcentaje = $R->costoMo / $Total_Col_Por * 100;

                $pdf->SetX(5);
                $pdf->Cell(43, 4, utf8_decode(mb_strimwidth($R->depto . ' ' . $R->nombreDepto, 0, 20, "")), 'B'/* BORDE */, 0, 'L');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(12, 4, ($R->totalemp <> 0) ? number_format($R->totalemp, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($R->salario <> 0) ? '$' . number_format($R->salario, 0, ".", ",") : '', 'LBT'/* BORDE */, 0, 'R');
                $pdf->Cell(18, 4, ($R->salariod <> 0) ? '$' . number_format($R->salariod, 0, ".", ",") : '', 'RBT'/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(15, 4, ($R->bonos <> 0) ? '$' . number_format($R->bonos, 0, ".", ",") : '', 1/* BORDE */, 0, 'R');
                $pdf->Cell(15, 4, ($R->extras <> 0) ? '$' . number_format($R->extras, 0, ".", ",") : '', 1/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(22, 4, ($R->total <> 0) ? '$' . number_format($R->total, 0, ".", ",") : '', 1/* BORDE */, 0, 'R');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(22, 4, ($R->pares <> 0) ? number_format($R->pares, 0, ".", ",") : '', 1/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(22, 4, ($R->costoMo <> 0) ? number_format($R->costoMo, 2, ".", ",") : '', 1/* BORDE */, 0, 'C');

                $pdf->SetX($pdf->GetX());
                $pdf->Cell(18, 4, ($Porcentaje <> 0) ? '%' . number_format($Porcentaje, 2, ".", ",") : '', 1/* BORDE */, 1, 'C');


                $TP1 += $R->totalemp;
                $TPe1 += $R->salario;
                $TP2 += $R->salariod;
                $TPe2 += $R->bonos;
                $TP3 += $R->extras;
                $TPe3 += $R->total;
                $TPe4 += $R->costoMo;
                $TP5 += $Porcentaje;
            }
            /* Total general */
            $pdf->SetFont('Calibri', 'B', 8);
            $pdf->SetX(5);
            $pdf->Cell(43, 5, utf8_decode('Total general:'), 0/* BORDE */, 0, 'C');
            $pdf->SetX($pdf->GetX());
            $pdf->Cell(12, 4, ($TP1 <> 0) ? number_format($TP1, 0, ".", ",") : '', 0/* BORDE */, 0, 'C');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 4, ($TPe1 <> 0) ? '$' . number_format($TPe1, 0, ".", ",") : '', 0/* BORDE */, 0, 'R');
            $pdf->Cell(18, 4, ($TP2 <> 0) ? '$' . number_format($TP2, 0, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(15, 4, ($TPe2 <> 0) ? '$' . number_format($TPe2, 0, ".", ",") : '', 0/* BORDE */, 0, 'R');
            $pdf->Cell(15, 4, ($TP3 <> 0) ? '$' . number_format($TP3, 0, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(22, 4, ($TPe3 <> 0) ? '$' . number_format($TPe3, 0, ".", ",") : '', 0/* BORDE */, 0, 'R');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(22, 4, '', 0/* BORDE */, 0, 'C');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(22, 4, ($TPe4 <> 0) ? number_format($TPe4, 2, ".", ",") : '', 0/* BORDE */, 0, 'C');

            $pdf->SetX($pdf->GetX());
            $pdf->Cell(18, 4, ($TP5 <> 0) ? '%' . number_format($TP5, 2, ".", ",") : '', 0/* BORDE */, 1, 'C');


            /* FIN RESUMEN */
            $path = 'uploads/Reportes/Produccion';
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            $file_name = "REPORTE MANO OBRA GENERAL " . ' ' . date("d-m-Y his");
            $url = $path . '/' . $file_name . '.pdf';
            /* Borramos el archivo anterior */
            if (delete_files('uploads/Reportes/Produccion/')) {
                /* ELIMINA LA EXISTENCIA DE CUALQUIER ARCHIVO EN EL DIRECTORIO */
            }
            $pdf->Output($url);
            print base_url() . $url;
        }
    }

    public function onReporteAguinaldos() {
        $x = $this->input;
        $fechaAp = $x->post('FechaAplicacionAguinaldos');
        $ano = $x->post('AnoAguinaldos');
        $sem = $x->post('SemAguinaldos');
        $this->db->query('truncate table nominabanco');
        $query = "SELECT
                    (
                    (P.salario+P.salariod+P.horext+P.otrper+P.otrper1)-
                    (P.infon+P.imss+P.impu+P.precaha+P.cajhao+P.vtazap+P.zapper+P.fune+P.Cargo+P.fonac+P.otrde+P.otrde1)
                    ) as Neto,
                    (P.salfis) as SueldoFiscal,
                    '02' as col1,
                    '90' as col3,
                    date_format(now(),'%Y%m%d') as col4,
                    '000030' as col5,
                    date_format(str_to_date('$fechaAp','%d/%m/%Y'),'%Y%m%d') as col6,
                    '00' as col7,
                    '00000000064266210201' as ctafislobo,
                    '00000000107241850201' as ctaintlobo,
                    ' 00' col8,
                    LPAD(E.TBanbajio,'20','0') as col9,
                    ' ' as col10,
                    LPAD(P.numemp,'7','0') as col11,
                    '                         ABONO EN NOMINA' as concepfis,
                    '                    DEPOSITO EN EFECTIVO' as conceptint,
                    '0000000000000000000000000000000000000000' as col12
                    FROM prenominal P
                    join empleados E on E.Numero = P.numemp
                    where P.año = $ano and P.numsem = $sem
                    order by cast(E.DepartamentoFisico as signed) asc, P.numemp asc
                     ";
        $Registros = $this->db->query($query)->result();

        if (!empty($Registros)) {
            $cont1 = 2;
            $cont2 = 2;
            $ImporteFiscal = 0;
            $ImporteInterno = 0;

            foreach ($Registros as $M) {
                if (floatval($M->Neto) > 0) {
                    $ImporteInterno = floatval($M->Neto);
                    $txt = $M->col1 .
                            str_pad($cont2, 7, "0", STR_PAD_LEFT) .
                            $M->col3 .
                            $M->col4 .
                            $M->col5 .
                            str_pad($ImporteInterno, 13, "0", STR_PAD_LEFT) . '00' .
                            $M->col6 .
                            $M->col7 .
                            $M->ctaintlobo .
                            $M->col8 .
                            $M->col9 .
                            $M->col10 .
                            $M->col11 .
                            $M->conceptint .
                            $M->col12 .
                            "\n";
                    //Agregamos el registro
                    $this->db->insert("nominabanco", array(
                        'consecutivo' => $cont2,
                        'col1' => $txt,
                        'tipo' => 2,
                        'importe' => $ImporteInterno
                    ));
                    $cont2 ++;
                }
                if (floatval($M->SueldoFiscal) > 0) {
                    $ImporteFiscal = floatval($M->SueldoFiscal);
                    $txt = $M->col1 .
                            str_pad($cont1, 7, "0", STR_PAD_LEFT) .
                            $M->col3 .
                            $M->col4 .
                            $M->col5 .
                            str_pad($ImporteFiscal, 13, "0", STR_PAD_LEFT) . '00' .
                            $M->col6 .
                            $M->col7 .
                            $M->ctafislobo .
                            $M->col8 .
                            $M->col9 .
                            $M->col10 .
                            $M->col11 .
                            $M->concepfis .
                            $M->col12 .
                            "\n";
                    //Agregamos el registro
                    $this->db->insert("nominabanco", array(
                        'consecutivo' => $cont1,
                        'col1' => $txt,
                        'tipo' => 1,
                        'importe' => $ImporteFiscal
                    ));
                    $cont1 ++;
                }
            }
        }
    }

    public function onReporteAguinaldosPDF() {
        $x = $this->input;
        $fechaAp = $x->post('FechaAplicacionAguinaldos');
        $ano = $x->post('AnoAguinaldos');
        $sem = $x->post('SemAguinaldos');
        $this->db->query('truncate table nominabanco');
        $query = "SELECT
                    (
                    (P.salario+P.salariod+P.horext+P.otrper+P.otrper1)-
                    (P.infon+P.imss+P.impu+P.precaha+P.cajhao+P.vtazap+P.zapper+P.fune+P.Cargo+P.fonac+P.otrde+P.otrde1)
                    ) as Neto,
                    (P.salfis) as SueldoFiscal,
                    E.numero as numemp,
                    E.busqueda as nomemp,
                    E.TBanbajio,
                    ifnull(D.Clave,'999') as numdepto,
                    ifnull(D.Descripcion,'NO EXISTE DEPTO') as nomdepto
                    FROM prenominal P
                    join empleados E on E.Numero = P.numemp
                    left join departamentos D on D.Clave = E.DepartamentoFisico
                    where P.año = $ano and P.numsem = $sem
                    order by cast(E.DepartamentoFisico as signed) asc, P.numemp asc
                     ";
        $Registros = $this->db->query($query)->result();

        if (!empty($Registros)) {

            foreach ($Registros as $M) {
                if (floatval($M->Neto) > 0) {
                    $this->db->insert("nominabanco", array(
                        'tipo' => 2,
                        'importe' => floatval($M->Neto),
                        'fecha' => Date('d/m/Y'),
                        'fechaap' => $fechaAp,
                        'numemp' => $M->numemp,
                        'nomemp' => $M->nomemp,
                        'ctaemp' => $M->TBanbajio,
                        'concepto' => 'DEPÓSITO EN EFECTIVO',
                        'numdepto' => $M->numdepto,
                        'nomdepto' => $M->nomdepto
                    ));
                }
                if (floatval($M->SueldoFiscal) > 0) {
                    $this->db->insert("nominabanco", array(
                        'tipo' => 1,
                        'importe' => floatval($M->SueldoFiscal),
                        'fecha' => Date('d/m/Y'),
                        'fechaap' => $fechaAp,
                        'numemp' => $M->numemp,
                        'nomemp' => $M->nomemp,
                        'ctaemp' => $M->TBanbajio,
                        'concepto' => 'ABONO EN NÓMINA',
                        'numdepto' => $M->numdepto,
                        'nomdepto' => $M->nomdepto
                    ));
                }
            }
            //Imprimimos el reporte
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            switch ($sem) {
                case '97':
                    $parametros["nombre"] = 'Depositos de caja de ahorro del';
                    break;
                case '98':
                    $parametros["nombre"] = 'Depositos de aguinaldos del';
                    break;
                case '99':
                    $parametros["nombre"] = 'Depositos de vacaciones del';
                    break;
            }
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\nominas\reporteAguinaldoBanco.jasper');
            $jc->setFilename('AGUINALDO_VACACIONES_BANCO_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        }
    }

    public function onReporteNominaBancoPDF() {
        $x = $this->input;
        $fechaAp = $x->post('FechaAplicacionNomina');
        $ano = $x->post('AnoNominaBanco');
        $sem = $x->post('SemNominaBanco');
        $this->db->query('truncate table nominabanco');
        $query = "SELECT
                    (
                    (P.salario+P.salariod+P.horext+P.otrper+P.otrper1)-
                    (P.infon+P.imss+P.impu+P.precaha+P.cajhao+P.vtazap+P.zapper+P.fune+P.Cargo+P.fonac+P.otrde+P.otrde1)
                    ) as Neto,
                    (E.SueldoFijo) as SueldoFiscal,
                    E.numero as numemp,
                    E.busqueda as nomemp,
                    E.TBanbajio,
                    ifnull(D.Clave,'999') as numdepto,
                    ifnull(D.Descripcion,'NO EXISTE DEPTO') as nomdepto
                    FROM prenominal P
                    join empleados E on E.Numero = P.numemp
                    left join departamentos D on D.Clave = E.DepartamentoFisico
                    where P.año = $ano and P.numsem = $sem
                    and E.altabaja = 1 and E.Tarjeta = 1
                    order by cast(E.DepartamentoFisico as signed) asc, P.numemp asc
                     ";
        $Registros = $this->db->query($query)->result();

        if (!empty($Registros)) {
            $ImporteFiscal = 0;
            $ImporteInterno = 0;

            foreach ($Registros as $M) {
                if (floatval($M->Neto) > 0) {//Si el importe trae algo hace todas las otras validaciones
                    if (floatval($M->SueldoFiscal) > floatval($M->Neto)) {//Si el salario fiscal es mas grande que el importe neto (per-ded)se le paga por interna ** inserta interna
                        $ImporteInterno = floatval($M->Neto);
                        //Agregamos el registro
                        $this->db->insert("nominabanco", array(
                            'tipo' => 2,
                            'importe' => $ImporteInterno,
                            'fecha' => Date('d/m/Y'),
                            'fechaap' => $fechaAp,
                            'numemp' => $M->numemp,
                            'nomemp' => $M->nomemp,
                            'ctaemp' => $M->TBanbajio,
                            'concepto' => 'DEPÓSITO EN EFECTIVO',
                            'numdepto' => $M->numdepto,
                            'nomdepto' => $M->nomdepto
                        ));
                    } else {//Si el neto es mayor al sueldo fisca ej. Christian gana 3800 en total pero su sueldo fiscal son 1407
                        if (floatval($M->SueldoFiscal) > 0) {//Si el importe fiscal es mayor a 0 ** inserta en fisca y en interna
                            $ImporteFiscal = floatval($M->SueldoFiscal); // el importe fiscal se inserta intacto
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'tipo' => 1,
                                'importe' => $ImporteFiscal,
                                'fecha' => Date('d/m/Y'),
                                'fechaap' => $fechaAp,
                                'numemp' => $M->numemp,
                                'nomemp' => $M->nomemp,
                                'ctaemp' => $M->TBanbajio,
                                'concepto' => 'ABONO EN NÓMINA',
                                'numdepto' => $M->numdepto,
                                'nomdepto' => $M->nomdepto
                            ));

                            $ImporteInterno = floatval($M->Neto) - floatval($M->SueldoFiscal); //El importe interno es lo neto menos lo que se le paga por fiscal ** inserta fiscal
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'tipo' => 2,
                                'importe' => $ImporteInterno,
                                'fecha' => Date('d/m/Y'),
                                'fechaap' => $fechaAp,
                                'numemp' => $M->numemp,
                                'nomemp' => $M->nomemp,
                                'ctaemp' => $M->TBanbajio,
                                'concepto' => 'DEPÓSITO EN EFECTIVO',
                                'numdepto' => $M->numdepto,
                                'nomdepto' => $M->nomdepto
                            ));
                        } else {//Si no se le paga por nomina fiscal se le paga todo el sueldo neto ** inserta interna
                            $ImporteInterno = floatval($M->Neto);
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'tipo' => 2,
                                'importe' => $ImporteInterno,
                                'fecha' => Date('d/m/Y'),
                                'fechaap' => $fechaAp,
                                'numemp' => $M->numemp,
                                'nomemp' => $M->nomemp,
                                'ctaemp' => $M->TBanbajio,
                                'concepto' => 'DEPÓSITO EN EFECTIVO',
                                'numdepto' => $M->numdepto,
                                'nomdepto' => $M->nomdepto
                            ));
                        }
                    }
                } else if (floatval($M->SueldoFiscal) > 0) {//Si neto viene vacio valida si fiscal viene vacio tambien para no hacer nada
                    $ImporteFiscal = floatval($M->SueldoFiscal); // el importe fiscal se inserta intacto
                    //Agregamos el registro
                    $this->db->insert("nominabanco", array(
                        'tipo' => 1,
                        'importe' => $ImporteFiscal,
                        'fecha' => Date('d/m/Y'),
                        'fechaap' => $fechaAp,
                        'numemp' => $M->numemp,
                        'nomemp' => $M->nomemp,
                        'ctaemp' => $M->TBanbajio,
                        'concepto' => 'ABONO EN NÓMINA',
                        'numdepto' => $M->numdepto,
                        'nomdepto' => $M->nomdepto
                    ));
                }
            }
            $reports = array();

            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;

            //Imprimimos el reporte
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\nominas\reporteNominaBanco.jasper');
            $jc->setFilename('NOMINA_BANCO_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            $reports['1UNO'] = $jc->getReport();
            //Imprimimos el reporte 2
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\nominas\reporteNominaBancoNormal.jasper');
            $jc->setFilename('NOMINA_BANCO_NORMAL_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            $reports['2DOS'] = $jc->getReport();

            print json_encode($reports);
        }
    }

    public function onReporteNominaBancoXLS() {
        $x = $this->input;
        $fechaAp = $x->post('FechaAplicacionNomina');
        $ano = $x->post('AnoNominaBanco');
        $sem = $x->post('SemNominaBanco');
        $this->db->query('truncate table nominabanco');
        $query = "SELECT
                    (
                    (P.salario+P.salariod+P.horext+P.otrper+P.otrper1)-
                    (P.infon+P.imss+P.impu+P.precaha+P.cajhao+P.vtazap+P.zapper+P.fune+P.Cargo+P.fonac+P.otrde+P.otrde1)
                    ) as Neto,
                    (E.SueldoFijo) as SueldoFiscal,
                    E.numero as numemp,
                    E.busqueda as nomemp,
                    E.TBanbajio,
                    ifnull(D.Clave,'999') as numdepto,
                    ifnull(D.Descripcion,'NO EXISTE DEPTO') as nomdepto
                    FROM prenominal P
                    join empleados E on E.Numero = P.numemp
                    left join departamentos D on D.Clave = E.DepartamentoFisico
                    where P.año = $ano and P.numsem = $sem
                    and E.altabaja = 1 and E.Tarjeta = 1
                    order by cast(E.DepartamentoFisico as signed) asc, P.numemp asc
                     ";
        $Registros = $this->db->query($query)->result();

        if (!empty($Registros)) {
            $ImporteFiscal = 0;
            $ImporteInterno = 0;

            foreach ($Registros as $M) {
                if (floatval($M->Neto) > 0) {//Si el importe trae algo hace todas las otras validaciones
                    if (floatval($M->SueldoFiscal) > floatval($M->Neto)) {//Si el salario fiscal es mas grande que el importe neto (per-ded)se le paga por interna ** inserta interna
                        $ImporteInterno = floatval($M->Neto);
                        //Agregamos el registro
                        $this->db->insert("nominabanco", array(
                            'tipo' => 2,
                            'importe' => $ImporteInterno,
                            'fecha' => Date('d/m/Y'),
                            'fechaap' => $fechaAp,
                            'numemp' => $M->numemp,
                            'nomemp' => $M->nomemp,
                            'ctaemp' => $M->TBanbajio,
                            'concepto' => 'DEPÓSITO EN EFECTIVO',
                            'numdepto' => $M->numdepto,
                            'nomdepto' => $M->nomdepto
                        ));
                    } else {//Si el neto es mayor al sueldo fisca ej. Christian gana 3800 en total pero su sueldo fiscal son 1407
                        if (floatval($M->SueldoFiscal) > 0) {//Si el importe fiscal es mayor a 0 ** inserta en fisca y en interna
                            $ImporteFiscal = floatval($M->SueldoFiscal); // el importe fiscal se inserta intacto
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'tipo' => 1,
                                'importe' => $ImporteFiscal,
                                'fecha' => Date('d/m/Y'),
                                'fechaap' => $fechaAp,
                                'numemp' => $M->numemp,
                                'nomemp' => $M->nomemp,
                                'ctaemp' => $M->TBanbajio,
                                'concepto' => 'ABONO EN NÓMINA',
                                'numdepto' => $M->numdepto,
                                'nomdepto' => $M->nomdepto
                            ));

                            $ImporteInterno = floatval($M->Neto) - floatval($M->SueldoFiscal); //El importe interno es lo neto menos lo que se le paga por fiscal ** inserta fiscal
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'tipo' => 2,
                                'importe' => $ImporteInterno,
                                'fecha' => Date('d/m/Y'),
                                'fechaap' => $fechaAp,
                                'numemp' => $M->numemp,
                                'nomemp' => $M->nomemp,
                                'ctaemp' => $M->TBanbajio,
                                'concepto' => 'DEPÓSITO EN EFECTIVO',
                                'numdepto' => $M->numdepto,
                                'nomdepto' => $M->nomdepto
                            ));
                        } else {//Si no se le paga por nomina fiscal se le paga todo el sueldo neto ** inserta interna
                            $ImporteInterno = floatval($M->Neto);
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'tipo' => 2,
                                'importe' => $ImporteInterno,
                                'fecha' => Date('d/m/Y'),
                                'fechaap' => $fechaAp,
                                'numemp' => $M->numemp,
                                'nomemp' => $M->nomemp,
                                'ctaemp' => $M->TBanbajio,
                                'concepto' => 'DEPÓSITO EN EFECTIVO',
                                'numdepto' => $M->numdepto,
                                'nomdepto' => $M->nomdepto
                            ));
                        }
                    }
                } else if (floatval($M->SueldoFiscal) > 0) {//Si neto viene vacio valida si fiscal viene vacio tambien para no hacer nada
                    $ImporteFiscal = floatval($M->SueldoFiscal); // el importe fiscal se inserta intacto
                    //Agregamos el registro
                    $this->db->insert("nominabanco", array(
                        'tipo' => 1,
                        'importe' => $ImporteFiscal,
                        'fecha' => Date('d/m/Y'),
                        'fechaap' => $fechaAp,
                        'numemp' => $M->numemp,
                        'nomemp' => $M->nomemp,
                        'ctaemp' => $M->TBanbajio,
                        'concepto' => 'ABONO EN NÓMINA',
                        'numdepto' => $M->numdepto,
                        'nomdepto' => $M->nomdepto
                    ));
                }
            }

            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;

            //Imprimimos el reporte
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\nominas\reporteNominaBancoXLS.jasper');
            $jc->setFilename('NOMINA_BANCO_' . Date('h_i_s'));
            $jc->setDocumentformat('xls');
            print $jc->getReport();
        }
    }

    public function generaArchivoBancoInterna() {
        $mes = Date('m');
        $arr1 = str_split($mes);
        $filename = 'D814902' . $arr1[0] . '.' . $arr1[1] . Date('d') . '.txt';
        header("Content-Description: File Transfer");
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $handle = fopen('php://output', "w");

        $Registros = $this->db->query('SELECT col1,truncate(importe,0) as importe,consecutivo FROM nominabanco where tipo = 2')->result();

        if (!empty($Registros)) {
            /*  ---------------GENERA ARCHIVO INTERNO -------------------  */
            $Ultimo_row = 0;
            $Num_rows = 0;
            $Importe = 0;
            $txt = '01' . '0000001' . '030S9000008149' . Date('Ymd') . '00000000107241850201                                                                                                                                  ' . "\n";
            fwrite($handle, $txt);
            foreach ($Registros as $M) {
                fwrite($handle, $M->col1);
                $Importe += $M->importe;
                $Ultimo_row = $M->consecutivo + 1;
                $Num_rows = $M->consecutivo - 1;
            }
            $txt = '09' . str_pad($Ultimo_row, 7, "0", STR_PAD_LEFT) . '90' . str_pad($Num_rows, 7, "0", STR_PAD_LEFT) . str_pad($Importe, 16, "0", STR_PAD_LEFT) . '00';
            fwrite($handle, $txt);
            fclose($handle);
            exit;
        }
    }

    public function generaArchivoBancoFiscal() {
        $mes = Date('m');
        $arr1 = str_split($mes);
        $filename = 'D814901' . $arr1[0] . '.' . $arr1[1] . Date('d') . '.txt';
        header("Content-Description: File Transfer");
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $handle = fopen('php://output', "w");

        $Registros = $this->db->query('SELECT col1,truncate(importe,0) as importe,consecutivo FROM nominabanco where tipo = 1')->result();

        if (!empty($Registros)) {
            /*  ---------------GENERA ARCHIVO FISCAL -------------------  */
            $Ultimo_row = 0;
            $Num_rows = 0;
            $Importe = 0;
            $txt = '01' . '0000001' . '030S9000008149' . Date('Ymd') . '00000000064266210201                                                                                                                                  ' . "\n";
            fwrite($handle, $txt);
            foreach ($Registros as $M) {
                fwrite($handle, $M->col1);
                $Importe += $M->importe;
                $Ultimo_row = $M->consecutivo + 1;
                $Num_rows = $M->consecutivo - 1;
            }
            $txt = '09' . str_pad($Ultimo_row, 7, "0", STR_PAD_LEFT) . '90' . str_pad($Num_rows, 7, "0", STR_PAD_LEFT) . str_pad($Importe, 16, "0", STR_PAD_LEFT) . '00';
            fwrite($handle, $txt);
            fclose($handle);
            exit;
        }
    }

    public function onReporteNominaBanco() {
        $x = $this->input;
        $fechaAp = $x->post('FechaAplicacionNomina');
        $ano = $x->post('AnoNominaBanco');
        $sem = $x->post('SemNominaBanco');
        $this->db->query('truncate table nominabanco');
        $query = "SELECT
                    (
                    (P.salario+P.salariod+P.horext+P.otrper+P.otrper1)-
                    (P.infon+P.imss+P.impu+P.precaha+P.cajhao+P.vtazap+P.zapper+P.fune+P.Cargo+P.fonac+P.otrde+P.otrde1)
                    ) as Neto,
                    (E.SueldoFijo) as SueldoFiscal,
                    '02' as col1,
                    '90' as col3,
                    date_format(now(),'%Y%m%d') as col4,
                    '000030' as col5,
                    date_format(str_to_date('$fechaAp','%d/%m/%Y'),'%Y%m%d') as col6,
                    '00' as col7,
                    '00000000064266210201' as ctafislobo,
                    '00000000107241850201' as ctaintlobo,
                    ' 00' col8,
                    LPAD(E.TBanbajio,'20','0') as col9,
                    ' ' as col10,
                    LPAD(P.numemp,'7','0') as col11,
                    '                         ABONO EN NOMINA' as concepfis,
                    '                    DEPOSITO EN EFECTIVO' as conceptint,
                    '0000000000000000000000000000000000000000' as col12
                    FROM prenominal P
                    join empleados E on E.Numero = P.numemp
                    where P.año = $ano and P.numsem = $sem
                    and E.altabaja = 1 and E.Tarjeta = 1
                    order by cast(E.DepartamentoFisico as signed) asc, P.numemp asc
                     ";
        $Registros = $this->db->query($query)->result();

        if (!empty($Registros)) {
            $cont1 = 2;
            $cont2 = 2;
            $ImporteFiscal = 0;
            $ImporteInterno = 0;

            foreach ($Registros as $M) {
                if (floatval($M->Neto) > 0) {//Si el importe trae algo hace todas las otras validaciones
                    if (floatval($M->SueldoFiscal) > floatval($M->Neto)) {//Si el salario fiscal es mas grande que el importe neto (per-ded)se le paga por interna ** inserta interna
                        $ImporteInterno = floatval($M->Neto);

                        $txt = $M->col1 .
                                str_pad($cont2, 7, "0", STR_PAD_LEFT) .
                                $M->col3 .
                                $M->col4 .
                                $M->col5 .
                                str_pad($ImporteInterno, 13, "0", STR_PAD_LEFT) . '00' .
                                $M->col6 .
                                $M->col7 .
                                $M->ctaintlobo .
                                $M->col8 .
                                $M->col9 .
                                $M->col10 .
                                $M->col11 .
                                $M->conceptint .
                                $M->col12 .
                                "\n";
                        //Agregamos el registro
                        $this->db->insert("nominabanco", array(
                            'consecutivo' => $cont2,
                            'col1' => $txt,
                            'tipo' => 2,
                            'importe' => $ImporteInterno
                        ));
                        $cont2 ++;
                    } else {//Si el neto es mayor al sueldo fisca ej. Christian gana 3800 en total pero su sueldo fiscal son 1407
                        if (floatval($M->SueldoFiscal) > 0) {//Si el importe fiscal es mayor a 0 ** inserta en fisca y en interna
                            $ImporteFiscal = floatval($M->SueldoFiscal); // el importe fiscal se inserta intacto

                            $txt = $M->col1 .
                                    str_pad($cont1, 7, "0", STR_PAD_LEFT) .
                                    $M->col3 .
                                    $M->col4 .
                                    $M->col5 .
                                    str_pad($ImporteFiscal, 13, "0", STR_PAD_LEFT) . '00' .
                                    $M->col6 .
                                    $M->col7 .
                                    $M->ctafislobo .
                                    $M->col8 .
                                    $M->col9 .
                                    $M->col10 .
                                    $M->col11 .
                                    $M->concepfis .
                                    $M->col12 .
                                    "\n";
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'consecutivo' => $cont1,
                                'col1' => $txt,
                                'tipo' => 1,
                                'importe' => $ImporteFiscal
                            ));
                            $cont1 ++;

                            $ImporteInterno = floatval($M->Neto) - floatval($M->SueldoFiscal); //El importe interno es lo neto menos lo que se le paga por fiscal ** inserta fiscal
                            $txt = $M->col1 .
                                    str_pad($cont2, 7, "0", STR_PAD_LEFT) .
                                    $M->col3 .
                                    $M->col4 .
                                    $M->col5 .
                                    str_pad($ImporteInterno, 13, "0", STR_PAD_LEFT) . '00' .
                                    $M->col6 .
                                    $M->col7 .
                                    $M->ctaintlobo .
                                    $M->col8 .
                                    $M->col9 .
                                    $M->col10 .
                                    $M->col11 .
                                    $M->conceptint .
                                    $M->col12 .
                                    "\n";
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'consecutivo' => $cont2,
                                'col1' => $txt,
                                'tipo' => 2,
                                'importe' => $ImporteInterno
                            ));
                            $cont2 ++;
                        } else {//Si no se le paga por nomina fiscal se le paga todo el sueldo neto ** inserta interna
                            $ImporteInterno = floatval($M->Neto);
                            $txt = $M->col1 .
                                    str_pad($cont2, 7, "0", STR_PAD_LEFT) .
                                    $M->col3 .
                                    $M->col4 .
                                    $M->col5 .
                                    str_pad($ImporteInterno, 13, "0", STR_PAD_LEFT) . '00' .
                                    $M->col6 .
                                    $M->col7 .
                                    $M->ctaintlobo .
                                    $M->col8 .
                                    $M->col9 .
                                    $M->col10 .
                                    $M->col11 .
                                    $M->conceptint .
                                    $M->col12 .
                                    "\n";
                            //Agregamos el registro
                            $this->db->insert("nominabanco", array(
                                'consecutivo' => $cont2,
                                'col1' => $txt,
                                'tipo' => 2,
                                'importe' => $ImporteInterno
                            ));
                            $cont2 ++;
                        }
                    }
                } else if (floatval($M->SueldoFiscal) > 0) {//Si neto viene vacio valida si fiscal viene vacio tambien para no hacer nada
                    $ImporteFiscal = floatval($M->SueldoFiscal); // el importe fiscal se inserta intacto

                    $txt = $M->col1 .
                            str_pad($cont1, 7, "0", STR_PAD_LEFT) .
                            $M->col3 .
                            $M->col4 .
                            $M->col5 .
                            str_pad($ImporteFiscal, 13, "0", STR_PAD_LEFT) . '00' .
                            $M->col6 .
                            $M->col7 .
                            $M->ctafislobo .
                            $M->col8 .
                            $M->col9 .
                            $M->col10 .
                            $M->col11 .
                            $M->concepfis .
                            $M->col12 .
                            "\n";
                    //Agregamos el registro
                    $this->db->insert("nominabanco", array(
                        'consecutivo' => $cont1,
                        'col1' => $txt,
                        'tipo' => 1,
                        'importe' => $ImporteFiscal
                    ));
                    $cont1 ++;
                }
            }
        }
    }

    public function onReporteAltasBanco() {
        $x = $this->input;
        $fechaI = $x->get('FechaIni');
        $fechaF = $x->get('FechaFin');
        $query = "select
                    CONCAT(
                    '95100000000000000000000AHNOM  ' ,
                    concat('0000000000000000R',      RPAD(  concat(E.PrimerNombre,'/',E.Paterno)  ,24,' ')      ),
                    RPAD(E.PrimerNombre,19,' ') ,
                    RPAD(E.SegundoNombre,25,' '),
                    RPAD(E.Paterno,25,' ') ,
                    RPAD(E.Materno,30,' ') ,
                    case when E.sexo = 'M' then 'MASCULINO' when E.sexo = 'F' then 'FEMENINO ' ELSE 'NODEFINID' END ,
                    date_format(str_to_date(E.Nacimiento,'%Y-%m-%d'),'%Y%m%d'),
                    RPAD(E.RFC,13,' ')
                    ) AS Col1,
                    CONCAT(
                    RPAD(E.Direccion,35,' '),
                    RPAD(E.Colonia,35,' '),
                    RPAD(E.Ciudad,35,' '),
                    'GTO 01240004',
                    RPAD(E.CP,5,' ') ,
                    '477',
                    case when E.Tel = '0' then '1464646'  ELSE RPAD(E.Tel,7,' ') END ,
                    E.EstadoCivil
                    ) AS Col2,
                    CONCAT(
                    RPAD(E.Beneficiario,30,' ') ,
                    RPAD(E.Parentesco,10,' ') ,
                    E.Porcentaje,
                    '0'
                    '                                        0000',
                    '                                        0000'
                    ) AS Col3
                    from empleados E
                    where E.fechaingreso
                    between str_to_date('$fechaI','%d/%m/%Y')
                    and str_to_date('$fechaF','%d/%m/%Y')
                    and E.altabaja = 1
                    order by E.Numero asc ";
        $Ingresos = $this->db->query($query)->result();

        header("Content-Description: File Transfer");
        //Tipo de archivo

        $mes = Date('m');

        $arr1 = str_split($mes);

        $filename = 'A814901' . $arr1[0] . '.' . $arr1[1] . Date('d') . '.txt';
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $filename);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');

        $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
            'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
            'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
            'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y');


        if (!empty($Ingresos)) {
            $handle = fopen('php://output', "w");
            $txt = "9500000000064266210201000008149CALZADO LOBO, S.A. DE C.V.                               RIO SANTIAGO 245            SAN MIGUEL                  LEON                        373900024CARRANZ" . "\n";
            fwrite($handle, $txt);
            foreach ($Ingresos as $M) {

                $txt = $M->Col1 . $M->Col2 . $M->Col3 . "\n";
                $str = strtr($txt, $unwanted_array);
                fwrite($handle, $str);
            }
            fclose($handle);
            exit;
        }
    }

    public function onReporteAltasBancoPDF() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["fechaIni"] = $this->input->post('FechaIni');
        $parametros["fechaFin"] = $this->input->post('FechaFin');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteAltaEmpleadosBanco.jasper');
        $jc->setFilename('ALTAS_EMPLEADOS_BANCO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirEtiquetasLockers() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["depto"] = $this->input->get('Depto');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteEtiquetasLockers.jasper');
        $jc->setFilename('ETIQUETAS_LOCKERS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirValeZapTda() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["empleado"] = $this->input->get('Empleado');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\valeZapatosTdas.jasper');
        $jc->setFilename('VALE_ZAPATOS_TIENDAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirAsistenciasF() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoAsistenciaF');
        $parametros["sem"] = $this->input->post('SemAsistenciaF');
        $parametros["empleado"] = $this->input->post('EmpleadoAsistenciaF');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\asistencias\asistenciasRelojChecadorF.jasper');
        $jc->setFilename('ASISTENCIAS_RELOJ_CHECADOR_F_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirAsistencias() {
        $x = $this->input;
        $sem = $x->post('SemAsistencia');
        $ano = $x->post('AnoAsistencia');
        $depto = $this->input->post('DeptoAsistencia');

        /* Limpiamos la tabla temporal */
        $this->db->query('truncate table relojchecadortemp');

        $query = "select
                    str_to_date(FechaIni,'%d/%m/%Y') as fec1,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 1 DAY) as fec2,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 2 DAY) as fec3,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 3 DAY) as fec4,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 4 DAY) as fec5,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 5 DAY) as fec6,
                    date_add(str_to_date(FechaIni,'%d/%m/%Y'),INTERVAL 6 DAY) as fec7
                    from semanasnomina where Sem = '$sem' and Ano = '$ano' ";
        $Semanas = $this->db->query($query)->result();

        /* Trameos los registros actuales del reloj checador */
        $query2 = "select
                cast(ifnull(D.Clave,'999') as signed) as clavedepto,
                ifnull(D.Descripcion,'NO EXISTE DEPTO') as nombredepto,
                RC.numemp,RC.nomemp,RC.año,RC.semana,date_format(RC.fecalta,'%Y-%m-%d') as fecalta,RC.turno,RC.hora
                from relojchecador RC
                join empleados E on E.Numero = RC.numemp
                left join departamentos D on D.Clave = E.DepartamentoFisico
                where RC.semana = $sem and RC.año = 2019 and E.DepartamentoFisico like '%$depto%'
                order by clavedepto asc,RC.nomemp asc, RC.fecalta asc, RC.turno asc  ";
        $Movimientos = $this->db->query($query2)->result();

        //Iteramos en los registros para hacer el insert/update
        if (!empty($Movimientos)) {
            foreach ($Movimientos as $M) {
                //Ver en que fecha insertar o actualizar al igual que el campo del turno para guardar las horas
                $fecha = '';
                $turno = '';
                switch ($M->fecalta) {
                    case $Semanas[0]->fec1:
                        $fecha = 'fecha1';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'ej1';
                                break;
                            case '2':
                                $turno = 'sj1';
                                break;
                            case '3':
                                $turno = 'ej2';
                                break;
                            case '4':
                                $turno = 'sj2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec2:
                        $fecha = 'fecha2';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'ev1';
                                break;
                            case '2':
                                $turno = 'sv1';
                                break;
                            case '3':
                                $turno = 'ev2';
                                break;
                            case '4':
                                $turno = 'sv2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec3:
                        $fecha = 'fecha3';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'es1';
                                break;
                            case '2':
                                $turno = 'ss1';
                                break;
                            case '3':
                                $turno = 'es2';
                                break;
                            case '4':
                                $turno = 'ss2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec4:
                        $fecha = 'fecha4';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'ed1';
                                break;
                            case '2':
                                $turno = 'sd1';
                                break;
                            case '3':
                                $turno = 'ed2';
                                break;
                            case '4':
                                $turno = 'sd2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec5:
                        $fecha = 'fecha5';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'el1';
                                break;
                            case '2':
                                $turno = 'sl1';
                                break;
                            case '3':
                                $turno = 'el2';
                                break;
                            case '4':
                                $turno = 'sl2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec6:
                        $fecha = 'fecha6';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'em1';
                                break;
                            case '2':
                                $turno = 'sm1';
                                break;
                            case '3':
                                $turno = 'em2';
                                break;
                            case '4':
                                $turno = 'sm2';
                                break;
                        }
                        break;
                    case $Semanas[0]->fec7:
                        $fecha = 'fecha7';
                        switch ($M->turno) {//Ver que turno
                            case '1':
                                $turno = 'emi1';
                                break;
                            case '2':
                                $turno = 'smi1';
                                break;
                            case '3':
                                $turno = 'emi2';
                                break;
                            case '4':
                                $turno = 'smi2';
                                break;
                        }
                        break;
                }

                $query3 = "select numemp from relojchecadortemp where numemp = '$M->numemp' and año = '$M->año' and sem = '$M->semana' ";
                $RelojTemp = $this->db->query($query3)->result();
                if (!empty($RelojTemp)) {//Si ya existe update
                    $this->db->where('numemp', $M->numemp)->where('sem', $M->semana)->where('año', $M->año);
                    $this->db->update("relojchecadortemp", array(
                        $fecha => $M->fecalta,
                        $turno => $M->hora
                    ));
                } else {//Si no existe insert
                    //Agregamos el registro
                    $this->db->insert("relojchecadortemp", array(
                        'numemp' => $M->numemp,
                        'nomemp' => $M->nomemp,
                        'numdep' => $M->clavedepto,
                        'nomdep' => $M->nombredepto,
                        'fecha1' => $Semanas[0]->fec1,
                        'fecha2' => $Semanas[0]->fec2,
                        'fecha3' => $Semanas[0]->fec3,
                        'fecha4' => $Semanas[0]->fec4,
                        'fecha5' => $Semanas[0]->fec5,
                        'fecha6' => $Semanas[0]->fec6,
                        'fecha7' => $Semanas[0]->fec7,
                        'año' => $M->año,
                        'sem' => $M->semana,
                        $turno => $M->hora
                    ));
                }
            }

            //Imprimir reporte
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["ano"] = $ano;
            $parametros["sem"] = $sem;
            $jc->setParametros($parametros);
            $jc->setJasperurl('jrxml\asistencias\asistenciasRelojChecador.jasper');
            $jc->setFilename('ASISTENCIAS_RELOJ_CHECADOR_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } else {//Si no trae nada mandamos 0
            print 0;
        }
    }

    public function onImprimirRecibos() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoRecibos');
        $parametros["sem"] = $this->input->post('SemRecibos');
        $parametros["depto"] = $this->input->post('DeptoRecibos');
        $parametros["empleado"] = $this->input->post('EmpleadoRecibos');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reciboNomina.jasper');
        $jc->setFilename('RECIBOS_NOMINAS_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirContrato() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["SUBREPORT_DIR"] = base_url() . '/jrxml/nominas/';
        $parametros["empleado"] = $this->input->post('Empleado');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\contratoIndividualTiempoIndefinido.jasper');
        $jc->setFilename('CONTRATO_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirIngreEgre() {
        $jc = new JasperCommand();
        $jc->setFolder('rpt/' . $this->session->USERNAME);
        $parametros = array();
        $parametros["logo"] = base_url() . $this->session->LOGO;
        $parametros["empresa"] = $this->session->EMPRESA_RAZON;
        $parametros["ano"] = $this->input->post('AnoIngreEgre');
        $parametros["dsem"] = $this->input->post('dSemIngreEgre');
        $parametros["asem"] = $this->input->post('aSemIngreEgre');
        $parametros["fechaIni"] = $this->input->post('FechaIniIngreEgre');
        $parametros["fechaFin"] = $this->input->post('FechaFinIngreEgre');
        $jc->setParametros($parametros);
        $jc->setJasperurl('jrxml\nominas\reporteEstIngre.jasper');
        if ($this->input->post('TipoEstIngEg') === '2') {
            $jc->setJasperurl('jrxml\nominas\reporteEstEgre.jasper');
        }
        $jc->setFilename('EST_ING_EGRE_' . Date('h_i_s'));
        $jc->setDocumentformat('pdf');
        PRINT $jc->getReport();
    }

    public function onImprimirCajaAhorroPrestamos() {
        $x = $this->input;
        $demp = $x->post('dEmpleadoAhorroPrestamos');
        $aemp = $x->post('aEmpleadoAhorroPrestamos');
        $ano = $x->post('AnoAhorroPrestamos');

        $tipoReporte = $x->post('TipoAhorroPrestamos');
        $tipoReportePrestamos = $x->post('TipoPrestamos');

        /* Limpiamos la tabla temporal */
        $this->db->query('truncate table prescaha');

        $query_empleados = '';
        if ($tipoReporte === '2') {//Ahorro
            $query_empleados = "select "
                    . "E.Numero, "
                    . "E.Busqueda, "
                    . "ifnull(D.Clave,'999') as numdepto,"
                    . "ifnull(D.Descripcion,'REVISAR DEPTO EXISTE') as nomdepto, "
                    . "E.Ahorro  "
                    . "from empleados E left join departamentos D on D.clave = E.DepartamentoFisico "
                    . "where E.numero between $demp and $aemp and E.Ahorro > 0 and E.AltaBaja = 1  ";
        } else {
            $query_empleados = "select "
                    . "E.Numero, "
                    . "E.Busqueda, "
                    . "ifnull(D.Clave,'999') as numdepto,"
                    . "ifnull(D.Descripcion,'REVISAR DEPTO EXISTE') as nomdepto, "
                    . "E.Ahorro  "
                    . "from empleados E left join departamentos D on D.clave = E.DepartamentoFisico "
                    . "where E.numero between $demp and $aemp and E.PressAcum > 0 and E.AltaBaja = 1  ";
        }
        $Empleados = $this->db->query($query_empleados)->result();

        //Iteramos en los registros para hacer el insert/update
        if (!empty($Empleados)) {
            foreach ($Empleados as $M) {

                $numemp = $M->Numero;
                $nomemp = $M->Busqueda;
                $depto = $M->numdepto;
                $ahorro = $M->Ahorro;
                $nomdepto = $M->nomdepto;
                $query_prestamos = '';
                $PrestamoAcum = 0;

                //Si es prestamos consultamos la tabla para obtener el acumulado
                if ($tipoReporte === '1') {
                    $query_prestamos = "SELECT ifnull(sum(preemp),0) as preemp FROM prestamos  WHERE numemp  = $numemp ";
                    $PrestamoAcum = $this->db->query($query_prestamos)->result()[0]->preemp;
                }

                //Agregamos el registro a tabla temp
                $this->db->insert("prescaha", array(
                    'numemp' => $numemp,
                    'nomemp' => $nomemp,
                    'depto' => $depto,
                    'nomdepto' => $nomdepto,
                    'presta' => ($tipoReporte === '1') ? $PrestamoAcum : $ahorro
                ));

                //Validamos que tipo de reporte es para obtener los importes
                if ($tipoReporte === '1') {
                    $query_importes = "SELECT imported,numsem FROM prenomina where numemp = $numemp and año = $ano and numcon  = 65 ";
                } else {
                    $query_importes = "SELECT imported,numsem FROM prenomina where numemp = $numemp and año = $ano and numcon  = 70 ";
                }
                $Importes = $this->db->query($query_importes)->result();
                if (!empty($Importes)) {
                    //Actualizamos la tabla con total por linea
                    $Total_Acum = 0;
                    foreach ($Importes as $I) {
                        if (floatval($I->imported) > 0) {
                            $no_sem = $I->numsem;
                            $Total_Acum += floatval($I->imported);
                            $this->db->where('numemp', $numemp);
                            $this->db->update("prescaha", array(
                                "s$no_sem" => $I->imported,
                                "total" => $Total_Acum
                            ));
                        }
                    }
                }
            }


            //Imprimir reportes
            $jc = new JasperCommand();
            $jc->setFolder('rpt/' . $this->session->USERNAME);
            $parametros = array();
            $parametros["logo"] = base_url() . $this->session->LOGO;
            $parametros["empresa"] = $this->session->EMPRESA_RAZON;
            $parametros["ano"] = $ano;
            $jc->setParametros($parametros);
            if ($tipoReporte === '1') {
                $jc->setJasperurl('jrxml\nominas\reportePrestamos.jasper');
            } else {
                $jc->setJasperurl('jrxml\nominas\reporteCajaAhorros.jasper');
            }
            $jc->setFilename('REPORTE_PRESTAMOS_CAJA_AHORROS_' . Date('h_i_s'));
            $jc->setDocumentformat('pdf');
            PRINT $jc->getReport();
        } else {//Si no trae nada mandamos 0
            print 0;
        }
    }

}
