<?php
 

try {

    $db = "db.json";
    $type = $_POST["type"];

    switch ($type) {
        case "crear":

            $data = file_get_contents($db);
            $data = json_decode($data, true);

            $add_arr = array(
                'nombre'     => $_POST['nombre'],
                'cantidad'   => $_POST['cantidad'],
                'precio'     => $_POST['precio'],
                'stock'      => $_POST['stock']
            );

            $data[] = $add_arr;

            $data = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents($db, $data);
            echo json_encode(["success" => true, "message" => "Agregado correctamente."], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


            break;
        case "editar":



            $id = $_POST['id'];
            $data        = file_get_contents($db);
            $data_array  = json_decode($data, true);
            $row         = $data_array[$id];
            echo json_encode(["success" => true, "data" => $row], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


            break;
        case "actualizar":


            $update_arr = array(
                'nombre'     => $_POST['nombre'],
                'cantidad'   => $_POST['cantidad'],
                'precio'     => $_POST['precio'],
                'stock'      => $_POST['stock']
            );

            $data = file_get_contents($db);
            $data_array = json_decode($data, true);

            $data_array[$_POST['id']] = $update_arr;
            $data_array = array_values($data_array);

            $data = json_encode($data_array, JSON_PRETTY_PRINT);

            file_put_contents($db, $data);

            echo json_encode(["success" => true, "message" => "actualizado correctamente"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


            break;
        case "eliminar":


            $delete_id = $_POST['id'];
            $data = file_get_contents($db);
            $data = json_decode($data, true);
 
            unset($data[$delete_id]);

 
            //encode back to json
            $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            file_put_contents($db, $data);

            echo json_encode(["success" => true, "message" => "eliminado correctamente"], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);


            break;
        case "obtenerDatos":


            $data = file_get_contents($db);
            $data = json_decode($data);
            echo json_encode(["success" => true, "data" => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            break;
    }
} catch (Exception $ex) {
    echo $ex->getMessage();
}
