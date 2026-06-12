<?php

include "connection.php";

$categories = [

    [
        "Hospital Beds",
        "hospital-beds",
        "Hospital_Beds.php"
    ],

    [
        "Tables",
        "tables",
        "Tables.php"
    ],

    [
        "Chairs",
        "chairs",
        "Chairs.php"
    ],

    [
        "Trolleys",
        "trolleys",
        "Trolleys.php"
    ],

    [
        "Cabinets & Storage",
        "cabinets-storage",
        "Cabinets_Storage.php"
    ],

    [
        "Stools",
        "stools",
        "Stools.php"
    ],

    [
        "Screens & Partitions",
        "screens-partitions",
        "Screens_Partitions.php"
    ],

    [
        "Stands & Supports",
        "stands-supports",
        "Stands_Supports.php"
    ],

    [
        "Accessories",
        "accessories",
        "Accessories.php"
    ],

    [
        "Autoclaves",
        "autoclaves",
        "Autoclaves.php"
    ],

    [
    "Vertical Autoclave",
    "vertical-autoclave",
    "Vertical_Autoclave.php"
],

[
    "Horizontal Autoclave",
    "horizontal-autoclave",
    "Horizontal_Autoclave.php"
],

[
    "Flash Autoclave",
    "flash-autoclave",
    "Flash_Autoclave.php"
],

    [
        "Basic OT",
        "basic-ot",
        "Basic_OT.php"
    ],

    [
        "Moduler OT",
        "moduler-ot",
        "Moduler_OT.php"
    ],

    [
        "Gas Pipeline Solution",
        "gas-pipeline-solution",
        "Gas_Pipeline_Solution.php"
    ],

    [
        "Oxygen Plant Maintenance",
        "oxygen-plant-maintenance",
        "Oxygen_Plant_Maintenance.php"
    ],

    [
        "BBR Maintenance",
        "bbr-maintenance",
        "BBR_Maintenance.php"
    ],

    [
        "Vaclue",
        "vaclue",
        "Vaclue.php"
    ],

    [
        "ILR",
        "ilr",
        "ILR.php"
    ],

    [
        "Critical Equipments Repair",
        "critical-equipments-repair",
        "Critical_Equipments_Repair.php"
    ],

    [
        "Non-Critical Equipments Repair",
        "non-critical-equipments-repair",
        "Non-Critical_Equipments_Repair.php"
    ],

    [
        "Bio-medical Equipment Calibration",
        "bio-medical-equipment-calibration",
        "Bio-medical_Equipment_Calibration.php"
    ],

    [
        "Radiology Equipment QA",
        "radiology-equipment-qa",
        "Radiology_Equipment_QA.php"
    ]

];

foreach($categories as $category){

    $name = $category[0];
    $slug = $category[1];
    $page = $category[2];

    $check = mysqli_query($conn,
        "SELECT * FROM product_categories
         WHERE category_slug='$slug'"
    );

    if(mysqli_num_rows($check) == 0){

        $sql = "INSERT INTO product_categories
        (
            category_name,
            category_slug,
            category_page
        )

        VALUES

        (
            '$name',
            '$slug',
            '$page'
        )";

        if(mysqli_query($conn, $sql)){
            echo $name . " Inserted Successfully <br>";
        } else {
            echo mysqli_error($conn);
        }

    } else {

        echo $name . " Already Exists <br>";

    }

}

?>