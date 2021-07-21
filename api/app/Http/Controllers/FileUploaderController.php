<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Storage;
use Exception;

class FileUploaderController extends Controller
{
    public function uploads(Request $request){

        $this->validate($request, [
          
            'file_path'=>'required'
        ]);
        try {
            $file_original_path = (object) ['file_path' => ""];        
           
    
            if ($request->hasFile('file_path')) {
                $original_filename = $request->file('file_path')->getClientOriginalName();
                $original_filename_arr = explode('.', $original_filename);
                $file_ext = end($original_filename_arr);
                $destination_path = './uploads/files/';
                $file_path_name = 'C-' . time() . '.' . $file_ext;
    
                if ($request->file('file_path')->move($destination_path, $file_path_name )) {
                   
                    $uploadPath = '/uploads/files/'.$file_path_name ;
    
                  
                    return response() -> json(['path'=>$uploadPath, 'message' => 'File has been Successfully Uploaded'], 201);
                } else {
                    return response() -> json('Cannot upload file');
                }}
            } catch (Exception $e) {
                     throw new NotFoundHttpException('Upload Failed');
            }
        
    }  
    
    
    public function handle (Request $request) 
    {
            $this->validate($request,[
                'anexo' => 'required|image|max:1999' 
            ]);

            if ( $request->hasFile('anexo') )
            {
                $nomeArquivoComExt = $request->file('anexo')->getClientOriginalName();

                $nomeArquivo = pathinfo($nomeArquivoComExt, PATHINFO_FILENAME);

                $extensao = $request->file('anexo')->getClientOriginalExtension();

                $nomeArquivoParaSalvar = $nomeArquivo.'_'.time().'.'.$extensao;

                $path = $request->file('anexo')->storeAs('public/images', $nomeArquivoParaSalvar);

                return $nomeArquivoParaSalvar;
           }
    }
}
