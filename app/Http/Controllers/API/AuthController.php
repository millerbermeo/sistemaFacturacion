<?php

namespace App\Http\Controllers\API;
  
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
// use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

  
class AuthController extends BaseController
{
 
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'identificacion' => 'required|string|max:255|unique:users',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Añadir validación para la imagen
        ]);
    
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
    
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
    
        // Manejar la subida de la imagen
        if ($request->hasFile('foto')) {
            $filePath = $request->file('foto')->store('fotos', 'public'); // Guarda en el disco 'public' dentro de la carpeta 'fotos'
            $input['foto'] = $filePath;
        }
    
        $user = User::create($input);
        $success['user'] = $user;
    
        return $this->sendResponse($success, 'User registered successfully.');
    }
  
  
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
      
        if (! $token = auth()->attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    
        $user = auth()->user();
        $roles = $user->roles; 
    
        $success = $this->respondWithToken($token);
        $success['user'] = $user;
        // $success['roles'] = $roles;
    
        return $this->sendResponse($success, 'User login successfully.');
    }
    
  
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        $success = auth()->user();
   
        return $this->sendResponse($success, 'Refresh token return successfully.');
    }
  
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        
        return $this->sendResponse([], 'Successfully logged out.');
    }
  
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $success = $this->respondWithToken(auth()->refresh());
   
        return $this->sendResponse($success, 'Refresh token return successfully.');
    }
  
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
