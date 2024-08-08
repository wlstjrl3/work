<?php
// 업로드 디렉토리를 설정합니다.
$uploadDir = "./assets/upload/"; // 업로드 디렉토리 경로

$maxFileSize = 5 * 1024 * 1024; // 5MB

// 업로드된 파일의 정보를 가져옵니다.
$fileName = $_FILES["upload_file"]["name"];
$fileTmpName = $_FILES["upload_file"]["tmp_name"];
$fileSize = $_FILES["upload_file"]["size"];

// 파일 확장자를 체크하고 허용되는 확장자를 지정합니다.
$allowedExtensions = ["wav", "mp3", "png", "jpg"];
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

if (in_array($fileExtension, $allowedExtensions)) {
  // 파일 크기를 체크하고 원하는 크기로 제한합니다.
  if ($fileSize <= $maxFileSize) {
    // 새로운 파일 이름을 생성합니다.
    $newFileName = uniqid() . "." . $fileExtension;
    $uploadPath = $uploadDir . $newFileName;

    // 임시 파일의 경로를 UTF-8로 변환합니다.
    $utf8TmpFileName = mb_convert_encoding($fileTmpName, 'UTF-8', 'auto');

    // 파일을 이동시킵니다.
    if (move_uploaded_file($utf8TmpFileName, $uploadPath)) {
      echo $newFileName;
    } else {
      echo $utf8TmpFileName." / ".$uploadPath." / 파일 업로드 실패";
    }
  } else {
    echo "파일 크기가 너무 큽니다. 최대 파일 크기는 " . ($maxFileSize / (5 * 1024 * 1024)) . "MB입니다.";
  }
} else {
  echo "지원하지 않는 파일 형식입니다. wav, mp3, png, jpg 파일만 허용됩니다.";
}
?>