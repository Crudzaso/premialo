<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\GoogleUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Helpers\EmailHelperGlobal;
use App\Service\DiscordWebhookService;
use App\Events\UserLogin;
use App\Events\UserCreated;
use App\Events\ErrorOccurred;

use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    protected $discordWebhookService;

    public function __construct(DiscordWebhookService $discordWebhookService)
    {
        $this->discordWebhookService = $discordWebhookService;
    }

    public function registro(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'names' => 'required|string|max:255',
                'lastnames' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed', 
                'address' => 'required|string|max:255',
            ]);

            $user = User::create([
                'names' => $validatedData['names'],
                'lastnames' => $validatedData['lastnames'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'address' => $validatedData['address'],
            ]);

            $roleId = Role::where('name', 'user')->first()->id;
            $user->roles()->attach($roleId);
            
            Auth::login($user);

            event(new UserCreated($user));

            return redirect()->route('home')->with('success', 'Registro exitoso!');
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error en el registro', $e->getMessage()));
            return redirect()->route('register')->with('error', 'Ocurrió un error al registrar el usuario.');
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();

                event(new UserLogin($user));
                return redirect()->route('home');  
            } else {
                return redirect()->route('login')->with('error', 'Correo electrónico o contraseña incorrectos.');
            }
        } catch (\Exception $e) {
            event(new ErrorOccurred('Error al iniciar sesión', $e->getMessage()));
            return redirect()->route('login')->with('error', 'Ocurrió un error al iniciar sesión.');
        }
      
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();

            event(new UserLogin($user));
            return redirect()->route('usuarios.index');  
        } else {
            
        }
        return redirect()->route('login')->with('error', 'Correo electrónico o contraseña incorrectos.');
    }
}
