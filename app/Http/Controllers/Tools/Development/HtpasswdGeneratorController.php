<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class HtpasswdGeneratorController extends Controller
{
    public function index()
    {
        $tool = Tool::where('slug', 'htpasswd-generator')->firstOrFail();

        return view('tools.development.htpasswd-generator', [
            'tool' => $tool,
            'slug' => 'htpasswd-generator',
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|regex:/^[a-zA-Z0-9._-]+$/',
            'password' => 'required|string|max:255',
            'algorithm' => 'required|in:bcrypt,apr1,sha1,crypt',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $algorithm = $request->input('algorithm');

        $hash = match ($algorithm) {
            'bcrypt' => password_hash($password, PASSWORD_BCRYPT),
            'apr1' => $this->apr1Hash($password),
            'sha1' => '{SHA}' . base64_encode(sha1($password, true)),
            'crypt' => crypt($password, $this->generateSalt()),
        };

        return response()->json([
            'entry' => "$username:$hash",
            'algorithm' => $algorithm,
        ]);
    }

    /**
     * Generate Apache APR1 (MD5) hash — $apr1$salt$hash format.
     */
    private function apr1Hash(string $password): string
    {
        $salt = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
        return crypt($password, '$apr1$' . $salt . '$');
    }

    /**
     * Generate a 2-character salt for traditional crypt().
     */
    private function generateSalt(): string
    {
        $chars = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        return $chars[random_int(0, 63)] . $chars[random_int(0, 63)];
    }
}
