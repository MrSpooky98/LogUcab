<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');

    return view('index', ["permissions" => $permissions,"userEmail" => $userEmail]);
});

Route::get('/franchises', function () {
    $query = <<<'EOD'
    select (select b.lug_nombre from lugar a, lugar b where s.suc_lugar = a.lug_codigo and a.lug_lugar = b.lug_codigo) estado,
        s.suc_nombre nombre
    from sucursal s
EOD;
    $franchises = DB::select($query);

    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');
    return view('franchises_table',['franchises' => $franchises], ["permissions" => $permissions,"userEmail" => $userEmail]);
});

Route::get('/locations', function () {
    $query = <<<'EOD'
    select (select d.lug_nombre from lugar b,lugar c,lugar d where a.lug_lugar=b.lug_codigo and b.lug_lugar=c.lug_codigo and c.lug_lugar=d.lug_codigo) pais,
        (select c.lug_nombre from lugar b,lugar c where a.lug_lugar=b.lug_codigo and b.lug_lugar=c.lug_codigo) estado,
        (select b.lug_nombre from lugar b where a.lug_lugar=b.lug_codigo) municipio,
        a.lug_nombre parroquia 
    from lugar a 
    where a.lug_tipo = 'Parroquia'
EOD;
    $locations = DB::select($query);

    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');
    return view('locations_table',['locations' => $locations], ["permissions" => $permissions,"userEmail" => $userEmail]);
});

Route::get('/users', function () {
    $query = <<<'EOD'
    select usu_codigo,usu_email,usu_password 
    from usuario
EOD;
    $users = DB::select($query);

    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');
    return view('users_table',['users' => $users], ["permissions" => $permissions,"userEmail" => $userEmail]);
});

Route::get('/employees', function () {
    $query = <<<'EOD'
    select emp_cedula, emp_nombre || ' ' || emp_apellido as emp_nombre,
        emp_email_personal as emp_ep, emp_email_coorporativo as emp_ec 
    from empleado
EOD;
    $employees = DB::select($query);

    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');
    return view('employees_table',['employees' => $employees], ["permissions" => $permissions,"userEmail" => $userEmail]);
});

Route::get('/login', function () {

    return view('login',[]);
});

Route::post('/login', function () {
    $users = [];
    $redirect = false;
    if (array_key_exists('password2', $_POST)){
        if ($_POST['password'] == $_POST['password2'] && $_POST['password'] != '' && $_POST['email'] != ''){
            $users = DB::select('select usu_email from usuario where usu_email = \''.$_POST['email'].'\'');
            
            if (empty($users)){
                $code = DB::select('select max(usu_codigo) m from usuario');
                if (empty($code)){$code = 0;}
                else {
                    $code = $code[0]->m;
                }
                $users = DB::insert('insert into usuario (usu_codigo,usu_email,usu_password) values('.$code.'+1,\''.$_POST['email'].'\',\''.$_POST['password'].'\')');
                $message = 'Registro exitoso.';
            } else {
                $message = 'El email ('.$_POST['email'].') ya esta registrado.';
            }

        } else {
            $message = 'Las contraseñas no coinciden.';
        }
    } else {
        $users = DB::select('select usu_email from usuario where usu_email = \''.$_POST['email'].'\' and usu_password = \''.$_POST['password'].'\'');
        if (empty($users)){
            $message = 'Datos erroneos.';
        } else {
            $message = 'Bienvenido '.$_POST['email'].'.';

            Cookie::queue('permissions', 4, 60);
            Cookie::queue('user-email',$_POST['email'],60);
            $redirect = true;
        }
    }
    
    return view('login',['users' => $users, 'message' => $message, 'redirect' => $redirect]);
});

Route::get('/logout', function () {
    Cookie::forget('permissions');
    Cookie::forget('user-email');

    return view('index',['permissions' => 0]);
});

Route::get('/ship', function () {
    $types = DB::select('select tip_codigo cod, tip_tipo nombre from tipo_paquete');
    $countries = DB::select('select lug_codigo cod, lug_nombre nombre from lugar where lug_tipo=\'Pais\'');
    $states = DB::select('select lug_codigo cod, lug_nombre nombre from lugar where lug_tipo=\'Estado\'');

    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');
    return view('shipping',['permissions' => $permissions, 'userEmail' => $userEmail,'types' => $types, 'countries' => $countries, 'states' => $states]);
});

Route::post('/ship', function () {
    $types = DB::select('select tip_codigo cod, tip_tipo nombre from tipo_paquete');
    $countries = DB::select('select lug_codigo cod, lug_nombre nombre from lugar where lug_tipo=\'Pais\'');
    $states = DB::select('select lug_codigo cod, lug_nombre nombre from lugar where lug_tipo=\'Estado\'');
    $message = '';
    if ($_POST['receiverID'] == ''){
        $message = $message.'Campo receiverID Vacio. ';
    }
    if ($_POST['receiverName'] == ''){
        $message = $message.'Campo receiverName Vacio. ';
    }
    if ($_POST['senderID'] == ''){
        $message = $message.'Campo senderID Vacio. ';
    }

    $receiver = DB::select('select des_codigo cod, des_nombre nombre from destinatario');
    if (empty($receiver)){
        if ($_POST['receiverName'] != ''){
            $receiver = DB::insert('insert into destinatario(des_codigo, des_nombre) values ('.$_POST['receiverID'].', \''.$_POST['receiverName'].'\')');
        }
    }

    $sender = DB::select('select cli_codigo cod, cli_nombre nombre from cliente');
    if (empty($sender)){
        if ($_POST['senderName'] != ''){
            $sender = DB::insert('insert into destinatario(des_codigo, des_nombre) values ('.$_POST['receiverID'].', \''.$_POST['receiverName'].'\')');
        }
    }

    if ($_POST['peso'] == ''){
        $message = $message.'Campo Peso Vacio. ';
    }
    if ($_POST['alto'] == ''){
        $message = $message.'Campo Alto Vacio. ';
    }
    if ($_POST['ancho'] == ''){
        $message = $message.'Campo Ancho Vacio. ';
    }
    if ($_POST['profundidad'] == ''){
        $message = $message.'Campo Profundidad Vacio. ';
    }
    if ($_POST['tipo'] == ''){
        $message = $message.'Campo Tipo Vacio. ';
    }
    if ($_POST['country'] == ''){
        $message = $message.'Campo Pais Vacio. ';
    }
    if ($_POST['state'] == ''){
        $message = $message.'Campo Estado Vacio. ';
    }




    $permissions = Cookie::get('permissions');
    $userEmail = Cookie::get('user-email');
    return view('shipping',['permissions' => $permissions, 'userEmail' => $userEmail,'types' => $types ,'message' => $message, 'countries' => $countries, 'states' => $states]);
});