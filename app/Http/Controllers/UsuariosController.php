<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;
use App\Models\Cargos;

class UsuariosController extends Controller
{
    public function index(){
        return view('index');
    }
    public function Login_html (){
        return view('usuarios/Login');
    }
    public function formularioClientes()
    {
        // if (!Session::has('nombre')) {
        //     return view('login_prompt');
        // }
        
        $roles = Cargos::all(['id', 'descripcion']);

        return view('usuarios/formulario', compact('roles'));
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'dni' => 'required|unique:usuarios',
            'nombre' => 'required',
            'apellido' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'correo' => 'required|email|unique:usuarios',
            'contraseña' => 'required|min:6|confirmed',
            'rol' => 'required|integer',
        ]);

        try {
            DB::table('usuarios')->insert([
                'dni' => $request->input('dni'),
                'nombre' => $request->input('nombre'),
                'apellido' => $request->input('apellido'),
                'telefono' => $request->input('telefono'),
                'direccion' => $request->input('direccion'),
                'correo' => $request->input('correo'),
                'contraseña' => Hash::make($request->input('contraseña')),
                'fecha_ingreso' => now(),
                'cargo_id' => $request->input('rol'),
            ]);

            return redirect()->route('Usuario.Mostrar')->with(['mensaje' => 'Usuario registrado correctamente.', 'type'=>'Success']);
        } catch (\Exception $e) {
            return back()->withErrors(['mensaje' => 'Ocurrió un error al registrar el usuario: ' . $e->getMessage()]);
        }
    }

    public function MostrarUsuarios()
    {
        // Verifica si el usuario ha iniciado sesión
        // if (!session()->has('correo')) {
        //     return view('auth.iniciarSesion'); // Redirige a una vista de inicio de sesión si no está autenticado
        // }

        // Obtén los usuarios y sus cargos usando Eloquent
        $usuarios = Usuarios::join('cargo', 'usuarios.cargo_id', '=', 'cargo.id')
            ->select('usuarios.*', 'cargo.descripcion as cargo')
            ->get();

        return view('usuarios/MostrarUsuarios', compact('usuarios'));
    }
    function EditarU(Request $request ,$id){
        
        $mensaje = session(['mensaje'=> ' editar']);

        $usuario = Usuarios::findOrfail($id);

        $cargos = Cargos::all(['id', 'descripcion']);

        return view('usuarios/editar', compact('usuario', 'cargos', 'mensaje'));
    }
    public function ActualizarU(Request $request, $id){
        
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|numeric',
            'direccion' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'contraseña' => 'required|string|min:6',
            'cargo_id' => 'required|exists:cargo,id',
        ]);
    
        // Buscar usuario y actualizar datos
        $usuario = Usuarios::findOrFail($id);
        $usuario->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'correo' => $request->correo,
            'contraseña' => $request->contraseña ? bcrypt($request->contraseña) : $usuario->contraseña,
            'cargo_id' => $request->cargo_id,
            'fecha_actualizacion' => now(),
        ]);
        
    
        // Redirigir con mensaje
        return redirect()->route('Usuario.Mostrar', $usuario->id)->with(['mensaje'=> 'Usuario actualizado exitosamente.']);
    }
    public function EliminarU($id){
    try {

        // Ejecuta la consulta de eliminación
        $deleted = DB::table('usuarios')->where('id', $id)->delete();

        // Redirecciona dependiendo del resultado
        if ($deleted) {
            return redirect()->route('Usuario.Mostrar')->with(['mensaje'=> "El registro con ID $id fue eliminado correctamente."]);
        } else {
            return redirect()->route('Usuario.Mostrar')->with(['mensaje'=> "Ocurrió un error al intentar eliminar el registro con ID $id."]);
        }
    } catch (\Exception $e) {
        // Manejo de excepciones
        return redirect()->route('Usuario.Mostrar')->with(['mensaje'=> "Error: " . $e->getMessage()]);
    }
    }
    
public function Login(Request $request)
{
    // Validar los datos del formulario
    $validatedData = $request->validate([
        'correo' => 'required|email',
        'contraseña' => 'required|string',
    ]);

    // Obtener las credenciales del formulario
    $correo = $request->input('correo');
    $contraseña = $request->input('contraseña');

    // Consultar la base de datos para validar el usuario
    $user = DB::table('usuarios')
        ->where('correo', $correo)
        ->first();

    if ($user && Hash::check($contraseña, $user->contraseña)) {
        // Consultar la descripción del rol
        $rol = DB::table('cargo')
            ->where('id', $user->cargo_id)
            ->first();

        if (!$rol) {
            return redirect()->route('Usuario.login_html')->with('mensaje', 'Rol no encontrado.');
            // return "rol no encontrado";
        }

        // Guardar los datos en la sesión
        session([
            'id' => $user->id,
            'dni' => $user->dni,
            'nombre' => $user->nombre,
            'apellido' => $user->apellido,
            'telefono' => $user->telefono,
            'direccion' => $user->direccion,
            'correo' => $user->correo,
            'contraseña' => $user->contraseña,
            'descripcion' => $rol->descripcion,
            'cargo_id' => $user->cargo_id,
        ]);

        // Redirigir según el rol del usuario
        if ($user->cargo_id == 1) { // Administrador
            return redirect()->route('Usuario.Mostrar')->with(['mensaje'=>'Inicio de sesión exitoso.', 'type'=>'success']);
        } elseif ($user->cargo_id == 2) { // Empleado
            return redirect()->route('Usuario.Mostrar')->with(['mensaje' => 'Inicio de sesión exitoso.']);
        } else {
            return redirect()->route('Usuario.login_html')->with(['mensaje'=> 'Rol no reconocido.']);
        }
    } else {
        return redirect()->route('Usuario.login_html')->with(['mensaje' => 'Correo o contraseña incorrectos.']);
    }
    }
    public function Logout(Request $request)
    {
        // Eliminar todas las sesiones del usuario
        $request->session()->flush();

        return redirect()->route('Usuario.login_html')->with(['mensaje' => 'Sesión cerrada correctamente.']);
    }

}
