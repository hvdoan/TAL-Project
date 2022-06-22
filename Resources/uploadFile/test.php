<?php

$response = [
    "success" => 0,
    "file" => [
        "url" => ""
    ]
];

if (!empty($_FILES["image"]))
{
    /* Get avatar file info */
    $fileName   = basename($_FILES["image"]["name"]);
    $fileType   = pathinfo($fileName, PATHINFO_EXTENSION);
    $imagePath  = $_FILES["image"]["tmp_name"];

    /* Allow types */
    $allowTypes = array("jpg","png","jpeg","gif");

    /* Build target path */
    $date = date("Y_m_d_H_i_s");
    $targetFile = "/SASS/asset/img/public/".$date."_".$fileName;

    if(in_array($fileType, $allowTypes))
    {
        $state = move_uploaded_file($imagePath, getcwd()."/../..".$targetFile);

        $response = [
            "success" => 1,
            "file" => [
                "url" => $targetFile
            ],
            "state" => $state,
            "cwd" => realpath(dirname(getcwd()))
        ];
    }
}

echo json_encode($response);