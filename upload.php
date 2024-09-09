<?php
session_start();
$msg = null;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload'){
       if(isset($_FILES['uploadedFile']) && !empty($_FILES['uploadedFile'] && $_FILES['uploadedFile']['error'] == 0)){
          //var_dump($_FILES['uploadedFile']);
         $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
         $fileName = $_FILES['uploadedFile']['name'];
         $fileSize = $_FILES['uploadedFile']['size'];
         $fileType = $_FILES['uploadedFile']['type'];
         $fileNameSeprate = explode('.',$fileName);
        // var_dump($fileNmaeEx);
        $fileExtention = strtolower(end($fileNameSeprate));
        $newFileName = md5(time().$fileName).'.' . $fileExtention;
        $allowedFileExtentions = ['mp4','jpg','jpeg','gif','doc','zip','rar','png'];
        if(in_array($fileExtention,$allowedFileExtentions)){  
            $allowedMaxFileSize = 30 * 1024 * 1024;
            if($fileSize <  $allowedMaxFileSize){
            $uploadFileDir = 'upload/';
             $destPath =  $uploadFileDir . $newFileName;
            if(move_uploaded_file($fileTmpPath, $destPath)){
                $msg = 'فایل شما با موفقیت آپلود گردید';
            }else{
                $msg = 'خطا در آپلود فایل !!!';
            }
            }else {
                   $msg = 'حجم فایل شما بیش از حد مجاز می باشد!';
            }
            
          
        }else{
              $msg = 'فایل مورد نظر شما برای آپلود مجاز نمی باشد!';
        }

       }else{
            $msg = 'لطفا فایل مورد نظر خود را انتخاب نمایید!';
       }
    }
}
$_SESSION['msg'] = $msg;
 header("location:index.php");