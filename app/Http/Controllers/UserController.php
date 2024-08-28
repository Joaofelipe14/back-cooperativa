<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Cadastro de um novo usuário.
     */
    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'nome' => 'required|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:users',
                'password' => 'nullable|string|min:8|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'cpf' => 'required|string|max:14|unique:users',
                'cap' => 'nullable|string|max:20',
                'contato' => 'nullable|string|max:15',
                'tipo_usuario' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'dados' => $validator->errors()
                ], 422);
            }

            $imagePath = null;
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imagePath = $image->store('perfil', 'public');
            }

            $password = Str::random(10); 

            $user = User::create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($password), 
                'url_perfil' => $imagePath,
                'cpf' => $request->cpf,
                'cap' => $request->cap,
                'contato' => $request->contato,
                'tipo_usuario' => $request->tipo_usuario,
                'primeiro_acesso' => 'S'
            ]);

            return response()->json([
                'status' => true,
                'dados' => [
                    'mensagem' => 'Usuário cadastrado com sucesso',
                    'usuario' => $user,
                    'senha'=> $password

                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'dados' => ['mensagem' => 'Erro inesperado: ' . $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Atualização de um usuário existente.
     */
    public function update(Request $request, $id)
    {

        try {

            $validator = Validator::make($request->all(), [
                'nome' => 'nullable|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'cpf' => 'nullable|string|max:14',
                'cap' => 'nullable|string|max:20',
                'contato' => 'nullable|string|max:15',
                'tipo_usuario' => 'nullable|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'dados' => $validator->errors()
                ], 422);
            }
            $user = User::find($id);

            $userAuth = Auth::user();

            if ($userAuth->id !== $user->id) {
                return response()->json([
                    'status' => false,
                    'dados' => ['mensagem' => 'Usuário não encontrado ou não autorizado']
                ], 403);
            }

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imagePath = $image->store('perfil', 'public');
                $request->merge(['url_perfil' => $imagePath]);
            }

            $data = $request->all();
            $user->update($data);

            return response()->json([
                'sucesso' => true,
                'dados' => [
                    'mensagem' => 'Usuário atualizado com sucesso',
                    'usuario' => $user,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'sucesso' => false,
                'dados' => ['mensagem' => 'Erro inesperado: ' . $e->getMessage()]
            ], 500);
        }
    }

    /**
     * Login do usuário e geração do token.
     */
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('cpf', 'password');

            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'cpf' => ['As credenciais fornecidas estão incorretas.'],
                ]);
            }

            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            return response()->json([
                'sucesso' => true,
                'dados' => [
                    'mensagem' => 'Login realizado com sucesso',
                    'token' => $token,
                    'usuario' => $user,
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'sucesso' => false,
                'dados' => ['mensagem' => 'Erro de validação: ' . $e->getMessage()]
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'sucesso' => false,
                'dados' => ['mensagem' => 'Erro inesperado: ' . $e->getMessage()]
            ], 500);
        }
    }

    public function me()
    {

        $user = Auth::user();

        return response()->json([
            'status' => true,
            'dados' => $user,
        ]);
    }
}
