<?php

require_once(__DIR__.'\..\models\Task_Model.php');

require_once(__DIR__.'\..\..\lib\base\Controller.php');

class App_Controller extends Controller{
    public function indexAction() {
        $taskModel = new Task_Model();
        $taskDetails = $taskModel->getAllTask();
            
        $this->view-> taskDetails= $taskDetails;
        
        return  $this->view->taskDetails;
    } 
    public function getAllTaskAction() {
        
        $taskModel = new Task_Model();
        $taskDetails = $taskModel->getAllTask();
            //var_dump($taskDetails); 

        $this->view-> taskDetails= $taskDetails;          
    }
         
    
    public function createTaskAction(){
           
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $task_name=$_POST['task_name'];
            $task_description=$_POST['task_description'];
            $start_date=$_POST['start_date'];
            $finish_date=$_POST['finish_date'];
            $status=$_POST['status'];
            $created_by=$_POST['created_by'];

                $taskData = [
                    'task_name' => $task_name,
                    'task_description' =>$task_description,
                    'start_date' => $start_date,
                    'finish_date'=>$finish_date,
                    'status'=> $status,
                    'created_by'=> $created_by];
    
                $taskModel = new Task_Model();
                $taskModel->createTask($taskData);
                header("Location: AccountView.phtml");      
        }
           
    }
    public function deleteTaskAction() {
 
        if ($_SERVER["REQUEST_METHOD"] == "GET" ){
            $task_id = (int)$_GET["task_id"];
                
            $taskModel = new Task_Model();
            $taskModel->deleteTask($task_id);

            var_dump($task_id);

            header("Location: AccountView.phtml");
        } 
    }   
    public function emptyEditAction(){

    }
    
       
    public function editTaskAction() {
        $task_id = $_POST['task_id'];

        $taskModel = new Task_Model();
        $taskDetails = $taskModel->getTaskById($task_id); 
       
          //  var_dump($taskDetails); 
        $this->view->taskDetails= $taskDetails;
        return  $this->view->taskDetails;
    }
    public function saveTaskAction(){
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $task_id = (int)$_POST['task_id'];
            $task_name = $_POST['task_name'];
            $task_description = $_POST['task_description'];
            $start_date = $_POST['start_date'];
            $finish_date = $_POST['finish_date'];
            $status = $_POST['status'];
            $created_by = $_POST['created_by'];

            $newTaskData = [
                        'task_id' => $task_id,
                        'task_name' => $task_name,
                        'task_description' => $task_description,
                        'start_date' => $start_date,
                        'finish_date' => $finish_date,
                        'status' => $status,
                        'created_by' => $created_by
                    ];
            
            $taskModel = new Task_Model();
            $taskModel->saveTask($task_id, $newTaskData);
        } header("Location: AccountView.phtml");
    }
 }