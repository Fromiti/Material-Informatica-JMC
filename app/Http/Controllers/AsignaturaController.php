<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Archivo;
use App\User;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignaturas_s1 = Asignatura::where('semestre', 1)->get();
        $asignaturas_s2 = Asignatura::where('semestre', 2)->get();
        $asignaturas_s3 = Asignatura::where('semestre', 3)->get();
        $asignaturas_s4 = Asignatura::where('semestre', 4)->get();
        
        $todos_los_usuarios = User::all();

        $cantidad_material = array(
            'certamenes' => 0,
            'controles' => 0,
            'laboratorios' => 0,
            'otros' => 0,
        );
        
        foreach($todos_los_usuarios as $usuario){   // Cantidad de archivos de cada material
            $cantidad_material['certamenes'] += $usuario->certamenes;
            $cantidad_material['controles'] += $usuario->controles;
            $cantidad_material['laboratorios'] += $usuario->laboratorios;
            $cantidad_material['otros'] += $usuario->otros;
        }
        
        $cantidad_archivos = array();   // Cantidad de archivos por asignatura
        for($i = 1; $i <= 23; $i++){
            $cantidad = Archivo::where('numero_asignatura', $i)->count();
            $cantidad_archivos[$i] = $cantidad;
        }

        $semestre_asignatura = array(
            1 => $asignaturas_s1,
            2 => $asignaturas_s2,
            3 => $asignaturas_s3,
            4 => $asignaturas_s4,
        );

        $todas_las_asignaturas = Asignatura::all();

        return view('asignaturas.asignaturasTodas', compact('semestre_asignatura', 'cantidad_archivos', 'todas_las_asignaturas', 'cantidad_material'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(isset(auth()->user()->id)){
            if(auth()->user()->id == 1){
                return view('asignaturas.asignaturasCrear');
            }
        }
        
        return back()->with('admin', 'No tienes permiso para agregar asignaturas :(');
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nombre' => 'required|min:5|max:100',
        //     'descripcion' => 'required|min:10',
        //     'precio' => 'required|integer|gte:10000',
        //     'seccion' => 'required|min:4|max:100',
        // ]);

        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $nombre = time().$file->getClientOriginalName();
            $file->move(public_path().'/imagenes/asignaturas/',$nombre);
        }else{
            $nombre = 'default.jpg';
        } 
        $asignatura = new Asignatura(); 
        $asignatura->nombre = $request->nombre;
        $asignatura->descripcion = $request->descripcion;
        $asignatura->imagen = $nombre;
        $asignatura->semestre = $request->semestre;
        $asignatura->save();

        return back()->with('mensaje', 'Asignatura Agregada!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asignatura_detalles = Asignatura::findOrFail($id);
        $archivos_asignatura = Archivo::where('numero_asignatura', $id)->get();
        $todas_las_asignaturas = Asignatura::all();
        return view('asignaturas.asignaturasDetails', compact('asignatura_detalles', 'todas_las_asignaturas', 'archivos_asignatura'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $producto_a_eliminar = Producto::findOrFail($id);
        // $image_path = public_path().'/'.$producto_a_eliminar->imagen;
        // if (file_exists($image_path)) {    
        //     @unlink($image_path);      
        // }
        // $producto_a_eliminar->delete();

        // return redirect()->route('productos.index')->with('mensaje', 'Producto eliminado satisfactoriamente');
    }
}
