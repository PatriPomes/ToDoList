<?php

require_once(__DIR__.'\..\models\Task_Model.php');
require_once(__DIR__.'\..\..\lib\base\Controller.php');
//require_once(__DIR__.'\..\views\scripts\app_\index.phtml');


class App_Controller extends Controller 
{
     public function indexAction()
    {
        $taskModel = new Task_Model();
            $taskDetails = $taskModel->getAllTask();
            
            $this->view-> taskDetails= $taskDetails;
           
        
         
            return  $this->view->taskDetails;
    } 
    
    public function getAllTaskAction() {
        //listo y revisado
            $taskModel = new Task_Model();
            $taskDetails = $taskModel->getAllTask();
            
            $this->view-> taskDetails= $taskDetails;
           
            //var_dump($taskDetails);
         
            //return  $this->view->taskDetails;
           // return View('/')->with($taskDetails);
            
        }
         
    
    public function createTaskAction(){
           //listo y revisado. 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //$task_id= autoincrement(uniqid());
            $task_name=$_POST['task_name'];
            $task_description=$_POST['task_description'];
            $start_date=$_POST['start_date'];
            $finish_date=$_POST['finish_date'];
            $status=$_POST['status'];
            $created_by=$_POST['created_by'];

                $taskData = [
                    //'task_id'=>$task_id,
                    'task_name' => $task_name,
                    'task_description' =>$task_description,
                    'start_date' => $start_date,
                    'finish_date'=>$finish_date,
                    'status'=> $status,
                    'created_by'=> $created_by];
    
                $taskModel = new Task_Model();
                $taskModel->createTask($taskData);
                header("Location:\IT_Academy\Sprint3\web"); 
                
            }
           
        }
        public function deleteTaskAction() {
 
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["task_id"])) {
                $task_id = $_POST["task_id"];
                
                $taskModel = new Task_Model();
                //$task = $taskModel->getTaskById($task_id);
                
                if ($task_id && is_object($task_id)) {
                
                    $task_id->deleteTask($task_id);
        
                    $_SESSION['success_message'] = 'Tarea eliminada correctamente';
                    header("Location: /IT_Academy/Sprint3/web");
                } else {
                    echo "La tarea especificada no existe"; 
                }
        
            } $this->view->render('app_/index.phtml');
            
        }
      
     
    public function editTaskAction() {
       
        $task_id = $_POST['task_id'];
        
        
        $taskModel = new Task_Model();
        $taskDetails = $taskModel->getTaskById($task_id);
    
        include(__DIR__.'app\views\scripts\app_\index.phtml');
    }
    public function editTaskModalAction() {
        
        $task_id = $_POST['task_id'];
    
       
        $taskModel = new Task_Model();
        $taskData = $taskModel->getTaskById($task_id); 
    
        
        $this->view->render('app_/edittask.phtml', ['taskData' => $taskData]); 
    }

    public function saveTaskAction() {
        
        $task_id = $_POST['task_id'];
        $newTaskData = [
            'task_name' => $_POST['task_name'],
            'task_description' => $_POST['task_description'],
            'start_date' => $_POST['start_date'],
            'finish_date' => $_POST['finish_date'],
            'status' => $_POST['status'],
            'created_by' => $_POST['created_by']
        ];
    
        // Actualiza los datos de la tarea en el modelo
        $taskModel = new Task_Model();
        $taskModel->editTask($task_id, $newTaskData);
    
        // Redirige al usuario de vuelta a la página principal
        header("Location: /IT_Academy/Sprint3/web");
    }
}
