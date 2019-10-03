<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\User;
use App\PasswordReset;
//use JWTAuth;
use Hash;
//use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
//use \Firebase\JWT\JWT;
class AuthController extends Controller
{
    

    // Register Function 

    public function register(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $password = $request->password;
        $user = User::create(['first_name' => $first_name, 'last_name' => $last_name, 'email' => $email, 'password' => Hash::make($password)]);
        if(!$user){
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Something went wrong. Please try again.',
                ], 500);
        }

        $this->sendConfirmationEmail($user);

        return response()->json(
            [
               'success' => true,
               'msg' => 'Account Successfully Created.',
               'user_id' => $user->id
            ], 200);
    }


   //Login Function

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        // dd($credentials);
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'We cant find an account with this credentials.'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser(Request $request){
        
        try {
            
            $token = JWTAuth::getToken();

            if (! $user = JWTAuth::toUser($token)) {
                return response()->json(['success' => false, 'error' => 'User not found.'], 401);
            }else if($user->activated == 0){
                $this->invalidateToken();
                return response()->json(['success' => false, 'error' => 'Your account is not yet activated. Please check your email inbox.'], 401);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['success' => false, 'msg' => 'token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['success' => false, 'msg' => 'token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['success' => false, 'msg' => 'token_absent'], $e->getStatusCode());

        }


        return response()->json($user);
    }

    public function refreshToken(){

        $token = JWTAuth::getToken();
        
        if(!$token){
             return response()->json(['success' => false, 'msg' => 'token_not_provided'], 401);
        }
        
        try{
              $token = JWTAuth::refresh($token);
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
              return response()->json(['success' => false, 'msg' => 'token_blacklisted'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
              return response()->json(['success' => false, 'msg' => 'token_invalid'], $e->getStatusCode());
        } 
        
        return response()->json(compact('token'));
    } 

    public function existedEmail($email){
        $model = User::where(['email' => $email])->first();
        if($model){
            return response()->json(['notExisted' => false]);
        }

        return response()->json(['notExisted' => true]);
    }

    public function accountActivated($token){
          
        $appkey = env('APP_KEY');
        
        try{ 
          
          $decoded = JWT::decode($token, $appkey, array('HS256'));
          $id = $decoded->userid;
          $user = User::where(['id' => $id])->first();
          $user->activated = 1;

          if($user->save()){
              return redirect('/login');
          } else {
              return view("fe-layout.expired", ['state' => 'invalid']);
          }

        }catch (\Exception $e) {
            
            $errMsg = $e->getMessage();
            if($errMsg == "Expired token"){
                 return view("fe-layout.expired", ['state' => 'expired']);
            }else if($errMsg == "Signature verification failed"){
                 return view("fe-layout.expired", ['state' => 'invalid']);
            }
            
        }
    }
    
    public function resendLink($user_id){
        
        $user = User::where(['id' => $user_id])->first();
        
        if($user){
            $this->sendConfirmationEmail($user);
        }

        return response()->json(
            [
                'success' => true,
                'msg' => 'Email has been resent.',
            ], 200);

    }

    public function forgotPasswordResendLink($email){
        
        $user = User::where(['email' => $email])->first();
        
        if($user){
            $token = $this->createToken($user, 7200);
            $data['token'] = $token;
            $data['email'] = $user->email;
            $model = PasswordReset::create($data);
            if(!$model){
                return response()->json(
                    [
                        'success' => false,
                        'msg' => 'Something went wrong. Please try again.',
                    ], 500);
            }
            $data['name'] = $user->first_name;
            $this->sendResetPasswordEmail($data);
        }

        return response()->json(
            [
                'success' => true,
                'msg' => 'Email has been resent.',
            ], 200);

    }

    public function passwordForgot(Request $request){
      
        $email = $request->email;
        $data = ['email' => $email];
        $model = User::where($data)->first();
        
        if(!$model){
             return response()->json(['success' => false, 'msg' => 'email_not_found'], 500);
        }

        $user = User::where($data)->first();
        $token = $this->createToken($user, 7200);
        $data['token'] = $token;
        $model = PasswordReset::create($data);
        if(!$model){
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Something went wrong. Please try again.',
                ], 500);
        }

        $this->sendResetPasswordEmail(['name' => $user->first_name, 'token' => $token, 'email' => $user->email]);

        return response()->json(
                [
                    'success' => true,
                    'msg' => 'Reset Password Email has been sent.',
                ], 200);

    }

    public function passwordResetToken($token){

        $appkey = env('APP_KEY');
        $sample = "";
        try{ 
          
          $decoded = JWT::decode($token, $appkey, array('HS256'));
          $sample = $decoded;
          $password_reset = PasswordReset::where(['token' => $token])->first();
          if(!$password_reset){
             return view("fe-layout.forgot-password-expired", ['state' => 'invalid']);
          }
          $layout = !$password_reset? "forgot-password-expired" :  "resetpassword";
          return view("fe-layout.".$layout, ['user' => $decoded]);
          
    
        }catch (\Exception $e) {
            
            $errMsg = $e->getMessage();
            if($errMsg == "Expired token"){
                  return view("fe-layout.forgot-password-expired", ['state' => 'expired']);
            }else if($errMsg == "Signature verification failed"){
                 return view("fe-layout.forgot-password-expired", ['state' => 'invalid']);
            }         
        
        }

    }

    public function passwordReset(Request $request){
          
          $id = $request->id;
          $password = Hash::make($request->password);
          $data = ['password' => $password];

          $user = User::find($id);
          if(!$user->update($data)){
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Something went wrong. Please try again.',
                ], 500);
          }

          $model = PasswordReset::where(['email' => $user->email]);
          if(!$model->delete()){
            return response()->json(
                [
                    'success' => false,
                    'msg' => 'Something went wrong. Please try again.',
                ], 500);
          }

          return response()->json(
                [
                    'success' => true,
                    'msg' => 'Password has been sucessfuly reset.',
                ], 200);          

    }

    public function logout() {
        $this->invalidateToken(); 
    }

    private function sendResetPasswordEmail($data){

         Mail::to($data['email'])->send(new SendMail('email-layout.forgotpasswordemailconfirmation','Reset Password Email Confirmation', ['name' => $data['name'] ,'token' => $data['token']]));  

    }

    private function sendConfirmationEmail($user){
        
        $token = $this->createToken($user, 86400);

        Mail::to($user->email)->send(new SendMail('email-layout.emailconfirmation','Email Confirmation', ['name' => $user->first_name ,'token' => $token]));   
    }

    private function createToken($user, $time_added){

        $appkey = env('APP_KEY');      
        //1 day - 86400
        $jwt = array(
                "userid" => $user->id,
                "iat" => time(),
                "exp" => (time() + ($time_added))
            );

        return JWT::encode($jwt, $appkey);
    }

    private function invalidateToken(){
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Something went wrong, please try again.'], 500);
        }
    }
    
}