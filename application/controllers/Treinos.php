<?php
use models\bll\CategoriaBLL;
use models\bll\ModalidadeBLL;
use models\bll\AlunoBLL;
use models\bll\PlanoBLL;
use models\bll\AulaBLL;
use models\bll\ExercicioBLL;
use \models\entidades\Agendamento;

defined('BASEPATH') or exit('No direct script access allowed');

class Treinos extends MY_Controller{
    
    public function index(){

        if ($this->usuarioLogado->getPerfil()->getNome() != 'aluno') {
            redirect("Inicio");
        }

        $modalidadeBLL = new ModalidadeBLL();
       /*  $modalidades = $this->usuarioLogado->getPlano()->getModalidades(); */

        $data['titulo'] = "Treinos";
        $data['modalidades'] = $this->usuarioLogado->getAluno()->getPlano()->getModalidades();
        $data['aluno'] =$this->usuarioLogado->getAluno();

        $this->template->load('template', 'treino/gerar', $data);
    }

    public function gerar(){

        try{

            if(empty($_POST['modalidade']) || $_POST['modalidade'] == '...'){
                redirect("Treinos/index?select=erro1");
            }
            if(empty($_POST['dificuldade']) || $_POST['dificuldade'] == '...'){
                redirect("Treinos/index?select=erro2");
            }
    
            $modalidadeBLL = new ModalidadeBLL();
    
            $modalidade = $modalidadeBLL->buscarPorId($_POST['modalidade']);
            $exercicios = $modalidade->getExercicios();

            $exe = [];

            foreach($exercicios as $exercicio){ 
                $exe[$exercicio->getCategoria()->getNome()][] = $exercicio->getNome();  
            }

            $nivel = $_POST['dificuldade'];
            $dificuldade;
            
            switch($nivel){
                case "Facíl" :
                    $dificuldade = '2x12';
                    break;

                case "Médio":
                    $dificuldade = '3x12';
                    break;

                case "Difícil":
                    $dificuldade = '4x12';
                    break;
            }
  
            //print_r($dificuldade);
            //die();   
            
            $data['nivel'] = $dificuldade;
            $data['exercicios'] = $exe;
                          
            $this->template->load('template', 'treino/exibir', $data);

        }catch(Exception $e){
            $retorno["mensagem"] = $e->getMessage();
        }    
    }

}
