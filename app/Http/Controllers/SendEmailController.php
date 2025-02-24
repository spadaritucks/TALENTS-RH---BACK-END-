<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        try {

            $nome = $request->nome;
            $email = $request->email;
            $assunto = $request->assunto;
            $mensagem = $request->mensagem;

            Mail::to($email)->send(new SendEmail($nome, $assunto, $email, $mensagem));

            return response()->json([
                'success' => true,
                'message' => 'E-mail enviado com sucesso!'
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar e-mail: ' . $e->getMessage()
            ]);
        }
    }
}
