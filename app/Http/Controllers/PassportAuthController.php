<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Support\Str;

class PassportAuthController extends Controller
{
    /**
     * Registration
     */
    public function register(Request $request)
    {

 		try{
         $this->validate($request, [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
	    'id_role' => '2',
            'password' => bcrypt($request->password)
        ]);
         $accessToken = $user->createToken('LaravelAuthApp')->accessToken;

        $success = 'Usuario Creado';
     
        return response(['user'=> $user, 'access_token'=> $accessToken, 'message' =>  $success,]);
        }catch(\Exception $e){
             return redirect()->route('login')->with('danger','Usuario Existe');
 		     return response(['Usuario ya existe']);
    	}
       
       
    }
    /**
     * Registration Google
     */
    public function register(Request $request)
    {

	try{
       
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
	    'photo' => $request->photo,
	    'id_role' => '2',
            'password' => bcrypt($request->password)
        ]);
         $accessToken = $user->createToken('LaravelAuthApp')->accessToken;

        $success = 'Usuario Creado';
     
        return response(['user'=> $user, 'access_token'=> $accessToken, 'message' =>  $success,]);
        }catch(\Exception $e){
             return redirect()->route('login')->with('danger','Usuario Existe');
 		     return response(['Usuario ya existe']);
    	}
       
       
    }
 
    /**
     * Login
     */
    public function login(Request $request)
    {
    	try{
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
 
        if (auth()->attempt($data)) {

            $name =auth()->user()->name;
            $email =auth()->user()->email;
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json(['name' => $name,'email' => $email,'token' => $token], 200);

        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
            
        }
        }catch(\Exception $e){
 		return response(['Error']);
    	}	
    }   

}