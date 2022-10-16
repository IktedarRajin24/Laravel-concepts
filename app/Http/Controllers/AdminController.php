<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use App\Models\AuthUser;
use Illuminate\Support\Facades\Mail;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use Barryvdh\DomPDF\Facade\PDF;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\PhpWord;

class AdminController extends Controller
{
    public function adminHome()
    {
        $users = AuthUser::where('name', session('user'))->first();
        return view('admin.home')->with('users', $users);
    }

    public function viewAllUsers()
    {
        $users = AuthUser::where('is_admin', 0)->get();
        $warning = '';
        return view('admin.allUsers')->with('users', $users)->with('warning', $warning);
    }

    public function downloadCertificate(Request $request)
    {
        header('Content-type: image/jpeg');
        $path = public_path('images\certificate\format.jpg');
        $font = public_path('fonts\arial.ttf');
        $image = imagecreatefromjpeg($path);
        $color = imagecolorallocate($image, 51, 51, 102);
        $date = date('d F, Y');
        imagettftext($image, 18, 0, 880, 188, $color, $font, $date);
        $users = AuthUser::where('id', $request->id)->first();
        $name = $users->name;
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

    public function sendCertificate(Request $request)
    {
        header('Content-type: image/jpeg');
        $path = public_path('images\certificate\format.jpg');
        $font = public_path('fonts\arial.ttf');
        $image = imagecreatefromjpeg($path);
        $color = imagecolorallocate($image, 51, 51, 102);
        $date = date('d F, Y');
        imagettftext($image, 18, 0, 880, 188, $color, $font, $date);
        $users = AuthUser::where('id', $request->id)->first();
        $name = $users->name;
        $email = $users->email;
        $length = strlen($name);
        if ($length >= 30) {
            $fontSize = 35;
        } else {
            $fontSize = 50;
        }
        imagettftext($image, $fontSize, 0, 120, 520, $color, $font, $name);
        //imagejpeg($image,"certificate/$name.jpg");
        $pathToSave = public_path("images/ss/" . $name . ".jpg");
        $img = imagejpeg($image, $pathToSave);

        $warning = '';

        $data = array('name' => $name, 'email' => $email, 'image' => $pathToSave, 'warning' => $warning);

        Mail::send('admin\mail', $data, function ($message) use ($data) {
            $message->to($data['email'], $data['name'])->subject('Laravel test');
            $message->attach($data['image']);
            $message->from('superadmin@admin.com', session('user'));
        });
        $warning = 'mail sent successfully';
        return redirect()->back()->with('warning', $warning);
    }

    public function viewPDF(Request $request)
    {
        $users = AuthUser::where('id', $request->id)->first();
        $name = $users->name;
        $email = $users->email;
        $image = public_path('images/' . $users->image);
        $pathToSavePDF = public_path("images/PDFs/" . $name . ".pdf");
        $data = [
            'name' => $name,
            'date' => date('m/d/Y'),
            'mail' => $email,
            'image' => $image,
            'pathToPDF' => $pathToSavePDF

        ];

        $pdf = PDF::loadView('admin\viewPDF', $data)->save($pathToSavePDF);


        Mail::send('admin\mail', $data, function ($message) use ($data) {
            $message->to($data['mail'], $data['name'])->subject('Laravel test');
            $message->attach($data['pathToPDF']);
            $message->from('superadmin@admin.com', session('user'));
        });
        return redirect()->back();
    }
    public function export()
    {
        return Excel::download(new UsersExport, 'users.csv');
        return redirect()->back();
    }

    public function getWord()
    {
        $users = AuthUser::where('is_admin', 0)->get();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText(view('admin/allUsers')->with('users', $users));

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('users.docx');
    }
}
