<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    public function login()
    {
        return view('users.login');
    }

    public function loginSubmitted(Request $request)
    {
        $validate = $request->validate(
            [
                'email' => 'required|max:50',
                'password' => 'required'
            ],
            [
                'email.max' => 'E-mail can not be greater than 50 charcters',
                'password.required' => 'Please put a password'
            ]
        );
        $users = AuthUser::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        
        /*$client = new Client();
        $apiKey = 'hubspot api key';
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/email/'.$request->email.'/profile';

        //dd($endpoint);
        $response = $client->get($endpoint,[
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
        ]);

        //dd(json_decode($response->getBody()));
        $visitorId = json_decode($response->getBody())->vid;
        $email = $request->email;

        //dd($visitorId);
        //dd($email);

        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/vid/'.$visitorId;

        //dd($endpoint);
        $mytime = Carbon::now();
        $data = [
            'properties' => [
                [
                    'property' => 'recent_login',
                    'value' => $mytime
                ]
            ]
        ];
        //dd(json_encode($data));
        $response = $client->put($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
            'json' => $data
        ]);
        
        return $response->getStatusCode();*/

        $client = new Client();
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact/email/'.$request->email.'/profile';
        $apiKey = 'hubspot api key';
        $response = $client->get($endpoint,[
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
        ]);

        //dd(json_decode($response->getBody()));
        $contactId = json_decode($response->getBody())->vid;
        $identifier = $request->email; // either 'vid' or 'email'
        $endpoint = "https://api.hubapi.com/contacts/v3/contact/{$identifier}/{$contactId}";
        $mytime = Carbon::now();
        // Updated properties
        $data = [
            'properties' => [
                [
                    'property' => 'recent_login',
                    'value' => $mytime
                ]
            ]
        ];
        $response = $client->patch($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
            'json' => $data
        ]);

        return $response->getStatusCode();

        if ($users) {
            $request->session()->put('user', $users->name);
            if ($users->is_admin == 1) {
                $request->session()->put('is_admin', 1);
                if ($request->remember) {
                    setcookie('remember', $request->name, time() + 36000);
                } else {
                    setcookie('remember', "");
                }
                return redirect()->route('admin.home')->with('users', $users);
            } else {
                if ($request->remember) {
                    setcookie('remember', $request->name, time() + 36000);
                } else {
                    setcookie('remember', "");
                }
                return redirect()->route('users.dashboard')->with('users', $users);
            }
        }
        return back();
    }
    public function register()
    {
        return view('users.register');
    }

    public function registerSubmitted(Request $request)
    {
        $validate = $request->validate(
            [
                'name' => 'required|min:10|max:50',
                'email' => 'email',
                'gender' => 'required|in:male,female,others',
                'img' => 'required|mimes:jpg,jpeg,png|max:102400',
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'password' => 'required|min:10',
                'confirmPassword' => 'required|min:10|same:password'
            ],
            [
                'name.required' => 'Please put your name',
                'name.min' => 'Name must be greater than 10 charcters',
                'name.max' => 'Name cannot be greater than 50 charcters',
            ]
        );

        $imageName = time() . '-' . $request->name . '.' . $request->img->extension();
        $request->img->move(public_path('images'), $imageName);

        $users = new AuthUser();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->gender = $request->gender;
        $users->image = $imageName;
        $users->phone = $request->phone;
        $users->password = $request->password;
        $users->save();

        $client = new Client();
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact';
        $apiKey = 'pat-na1-c88729b9-8866-44a5-b440-d6dfe69cc85d';
        $data = [
            'properties' => [
                [
                    'property' => 'email',
                    'value' => $users->email
                ],
                [
                    'property' => 'firstname',
                    'value' => $users->name
                ],
                [
                    'property' => 'phone',
                    'value' => $users->phone
                ]
            ]
        ];
        
        $response = $client->post($endpoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiKey
            ],
            'json' => $data
        ]);

        if ($users) {

            return redirect()->route('users.login');
        }
    }

    public function dashboard()
    {
        $users = AuthUser::where('name', session('user'))->first();
        return view('users.dashboard')->with('users', $users);
    }

    public function view()
    {
        $users = AuthUser::where('name', session('user'))->first();
        return view('users.view')->with('users', $users);
    }

    public function logout()
    {
        session()->forget('user');
        session()-> forget('is_admin');
        return redirect()->route('users.login');
    }

    public function viewCertificate()
    {
        /*
        $path = public_path('images\certificate\template..jpg');
        $image = imagecreatefromjpeg($path);

        $color = imagecolorallocate($image, 255, 255, 255);
        $string = session('user');
        $fontSize = 3;
        $fileName = public_path('images\certificate\template..jpg');
        $x = 300;
        $y = 400;

        // write on the image
        imagestring($image, $fontSize, $x, $y, $string, $color);

        // save the image
        imagejpeg($image,  $fileName, $quality = 100);*/


        header('Content-type: image/jpeg');
        $path = public_path('images\certificate\format.jpg');
        $font = public_path('fonts\arial.ttf');
        $image = imagecreatefromjpeg($path);
        $color = imagecolorallocate($image, 51, 51, 102);
        $date = date('d F, Y');
        imagettftext($image, 18, 0, 880, 188, $color, $font, $date);
        $name = session('user');
        $length = strlen($name);
        if ($length >= 30) {
            $fontSize = 35;
        } else {
            $fontSize = 50;
        }
        imagettftext($image, $fontSize, 0, 120, 520, $color, $font, $name);
        //imagejpeg($image,"certificate/$name.jpg");
        imagejpeg($image);
        imagedestroy($image);
    }
}
