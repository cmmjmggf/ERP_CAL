<?php

/**
 * Description of JasperCommand
 *
 * @author Y700
 */
class JasperCommand {

    //put your code here
    private $dbname = "erp_cal";
    private $dbuser = "lobo";
    private $dbpassword = "abcd1234";
    private $dbtype = "mysql";
    private $ip = "192.168.0.1";
    private $dbport = "3306";
    //SI ES WINDOWS JAVA -JAR
    private $jasperurlsoftware = 'java -jar application\third_party\JasperPHP\src\JasperStarter\lib\jasperstarter.jar';
    //SI ES LINUX JAVA -JAR
//    private $jasperurlsoftware = 'java -jar application/third_party/JasperPHP/src/JasperStarter/lib/jasperstarter.jar';
//
//    private $jasperurlsoftware = 'application\third_party\JasperPHP\src\JasperStarter\bin\jasperstarter.exe';
    private $jasperurl;
    private $folder;
    private $filename;
    private $documentformat;
    private $parametros;

    function getParametros() {
        return $this->parametros;
    }

    function setParametros($parametros) {
        $this->parametros = $parametros;
    }

    function getDbname() {
        return $this->dbname;
    }

    function getDbuser() {
        return $this->dbuser;
    }

    function getDbpassword() {
        return $this->dbpassword;
    }

    function getDbtype() {
        return $this->dbtype;
    }

    function getIp() {
        return $this->ip;
    }

    function getDbport() {
        return $this->dbport;
    }

    function getJasperurlsoftware() {
        return $this->jasperurlsoftware;
    }

    function getJasperurl() {
        return $this->jasperurl;
    }

    function getFolder() {
        return $this->folder;
    }

    function getFilename() {
        return $this->filename;
    }

    function getDocumentformat() {
        return $this->documentformat;
    }

    function setDbname($dbname) {
        $this->dbname = $dbname;
    }

    function setDbuser($dbuser) {
        $this->dbuser = $dbuser;
    }

    function setDbpassword($dbpassword) {
        $this->dbpassword = $dbpassword;
    }

    function setDbtype($dbtype) {
        $this->dbtype = $dbtype;
    }

    function setIp($ip) {
        $this->ip = $ip;
    }

    function setDbport($dbport) {
        $this->dbport = $dbport;
    }

    function setJasperurlsoftware($jasperurlsoftware) {
        $this->jasperurlsoftware = $jasperurlsoftware;
    }

    function setJasperurl($jasperurl) {
        $this->jasperurl = $jasperurl;
    }

    function setFolder($folder) {
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        if (delete_files($folder)) {

        }
        $this->folder = $folder;
    }

    function setFilename($filename) {
        $this->filename = $filename;
    }

    function setDocumentformat($documentformat) {
        $this->documentformat = $documentformat;
    }

    public function getReport() {
        try {
            $parametros_finales = "";
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {

                if (count($this->getParametros()) > 0) {
                    $parametros_finales .= " -P";
                    foreach ($this->getParametros() as $key => $value) {
                        if (is_string($value)) {
                            $parametros_finales .= " $key=\"$value\"";
                        } else {
                            $parametros_finales .= " $key=$value";
                        }
                    }
                }
                $cmd = "{$this->getJasperurlsoftware()} pr {$this->getJasperurl()} -o {$this->getFolder()}/{$this->getFilename()} {$parametros_finales} -f {$this->getDocumentformat()} -t {$this->getDbtype()} -H {$this->getIp()} -u {$this->getDbuser()} -p {$this->getDbpassword()} -n {$this->getDbname()} --db-port {$this->getDbport()}";
                $command_esc = escapeshellcmd($cmd);
                print $cmd;
                passthru($command_esc);
                return base_url("{$this->getFolder()}/{$this->getFilename()}.{$this->getDocumentformat()}");
            } else {
//                su -c "application/third_party/JasperPHP/src/JasperStarter/bin/jasperstarter pr jrxml/materiales/relacionCoreHiloTejido.jasper -o rpt/777777/ReporteDelSistema02_07_21_191001012  -P logo="http://192.168.0.3/uploads/Empresas/1/lsbck.png" empresa='CALZADO LOBO, S.A. DE C.V.' maq=1 ano=2018 sem=49 Nmaq='CALZADO LOBO 12345' -f pdf -t mysql -H 127.0.0.1 -u root -n lobo_solo --db-port 3306"
                if (count($this->getParametros()) > 0) {
                    $parametros_finales .= " -P";
                    foreach ($this->getParametros() as $key => $value) {
                        if (is_string($value)) {
                            $parametros_finales .= " $key='$value'";
                        } else {
                            $parametros_finales .= " $key=$value";
                        }
                    }
                }

                /* PRESETS */
                $home = "/opt/lampp/htdocs/ERP_LS/";
                $this->setJasperurlsoftware("{$home}application/third_party/JasperPHP/src/JasperStarter/lib/jasperstarter.jar");
                $this->setJasperurl("{$home}jrxml/materiales/relacionCoreHiloTejido.jasper");
                $file_url = base_url("{$this->getFolder()}/{$this->getFilename()}.{$this->getDocumentformat()}");
                $this->setFolder("{$home}{$this->getFolder()}");
//sudo bash -c
                $cmd = "java -jar {$this->getJasperurlsoftware()} pr {$this->getJasperurl()} -o {$this->getFolder()}\/{$this->getFilename()} {$parametros_finales} -f {$this->getDocumentformat()} -t {$this->getDbtype()} -H {$this->getIp()} -u {$this->getDbuser()} -n {$this->getDbname()} --db-port {$this->getDbport()} 2>&1 ";
                //su -c "application/third_party/JasperPHP/src/JasperStarter/bin/jasperstarter pr jrxml/materiales/relacionCoreHiloTejido.jasper -o rpt/777777/ReporteDelSistema21022019  -P logo="uploads/Empresas/1/lsbck.png" empresa='CALZADO LOBO S.A. DE C.V.' maq=1 ano=2018 sem=49 Nmaq='CALZADO LOBO' -f pdf -t mysql -H 127.0.0.1 -u root -n lobo_solo --db-port 3306"
//                $command_esc = escapeshellcmd($cmd);
                $output = array();
                shell_exec($cmd);
//                print($cmd);
                return $file_url;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
