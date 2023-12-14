<?php
class DAO{
    private function dbConnect(){
        // $pdo= new PDO('mysql:host=mysql220.phy.lolipop.lan;dbname=LAA1417839-asofes2023;charset=utf8','LAA1417839','asofes2023');
        $pdo= new PDO('mysql:host=localhost;dbname=AsoFes;charset=utf8','asofes','asofes2023');

        return $pdo; 
    }

    public function selectAllStudents(){
        $pdo = $this->dbConnect();
        $sql = "SELECT * FROM students";
        $query = $pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function updateStudent($studentId, $studentName, $daytime, $flag){
        $pdo = $this->dbConnect();
        $sql = "UPDATE students SET student_name = :student_name, daytime = :daytime, flag = :flag WHERE student_id = :student_id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':student_id', $studentId);
        $query->bindParam(':student_name', $studentName);
        $query->bindParam(':daytime', $daytime);
        $query->bindParam(':flag', $flag);
        $query->execute();
    }

    public function deleteStudent($studentId){
        $pdo = $this->dbConnect();
        $sql = "DELETE FROM students WHERE student_id = :student_id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':student_id', $studentId);
        $query->execute();
    }
    public function searchStudents($searchKeyword){
        $pdo = $this->dbConnect();
        $sql = "SELECT * FROM students WHERE student_id LIKE :searchKeyword OR student_name LIKE :searchKeyword";
        $query = $pdo->prepare($sql);
        $query->bindValue(':searchKeyword', '%' . $searchKeyword . '%', PDO::PARAM_STR);
        $query->execute();
        return $query->fetchAll();
    }
    
}
?>