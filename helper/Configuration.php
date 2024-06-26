<?php
include_once("helper/Redirect.php");
include_once("helper/MysqlDatabase.php");
include_once("helper/Router.php");
include_once("helper/Render.php");
include_once('helper/PdfGen.php');

include_once("model/LoginModel.php");
include_once("model/RegistroModel.php");
include_once("model/ContenidistaModel.php");
include_once("model/AdminModel.php");
include_once("model/InfoneteModel.php");
include_once("model/ContenidoModel.php");
include_once("model/EditorModel.php");
include_once("model/ContenidoEditModel.php");
include_once("model/LectorModel.php");

include_once("controller/InfoneteController.php");
include_once("controller/LoginController.php");
include_once("controller/RegistroController.php");
include_once("controller/ContenidistaController.php");
include_once("controller/AdminController.php");
include_once("controller/ContenidoController.php");
include_once("controller/EditorController.php");
include_once("controller/ContenidoEditController.php");
include_once("controller/LectorController.php");

include_once('third-party/mustache/src/Mustache/Autoloader.php');


class Configuration{

    private $database;
    private $view;
    private $pdfGenerator;

    public function __construct(){
        $this->database = new MysqlDatabase();
        $this->view = new Render("view/", "view/partial/");
        $this->pdfGenerator = new PdfGen();
    }

    public function getInfoneteController(){
        return new InfoneteController($this->view, $this->getInfoneteModel());
    }

    public function getInfoneteModel() : InfoneteModel{
        return new InfoneteModel($this->database);
    }

    public function getLoginController(){
        return new LoginController($this->view, $this->getLoginModel());
    }

    public function getLoginModel(){
        return new LoginModel($this->database);
    }

    public function getRegistroController(){
        return new RegistroController($this->view, $this->getRegistroModel());
    }

    public function getRegistroModel(){
        return new RegistroModel($this->database);
    }

    public function getContenidistaController(){
        return new ContenidistaController($this->view, $this->getContenidistaModel());
    }

    public function getContenidistaModel(){
        return new ContenidistaModel($this->database);
    }

    public function getContenidoController(){
        return new ContenidoController($this->view, $this->getContenidoModel());
    }

    public function getContenidoModel(){
        return new ContenidoModel($this->database);

    }

    public function getAdminController(){
        return new AdminController($this->view, $this->getAdminModel(), $this->pdfGenerator);
    }

    public function getAdminModel(){
        return new AdminModel($this->database);
    }

    public function getEditorController(){
        return new EditorController($this->view, $this->getEditorModel());
    }

    public function getEditorModel(){
        return new EditorModel($this->database);
    }

    public function getContenidoeditController(){
        return new ContenidoEditController($this->view, $this->getContenidoEditModel());
    }

    public function getContenidoEditModel(){
        return new ContenidoEditModel($this->database);
    }

    public function getLectorController(){
        return new LectorController($this->view, $this->getLectorModel());
    }

    public function getLectorModel(){
        return new LectorModel($this->database);
    }

    public function getRouter(){
        //Se llama a si mismo para referenciarse
        return new Router($this, "infonete", "list");
    }

}