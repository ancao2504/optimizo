<?php

namespace App\Http\Controllers\Tools\Development;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use Illuminate\Http\Request;

class HashGeneratorController extends Controller
{
    /**
     * Map of tool slugs to their PHP hash algorithm names and display info.
     */
    private static $algorithms = [
        'adler32-hash-generator' => ['algo' => 'adler32', 'name' => 'Adler-32'],
        'crc32-hash-generator' => ['algo' => 'crc32', 'name' => 'CRC-32'],
        'crc32b-hash-generator' => ['algo' => 'crc32b', 'name' => 'CRC-32B'],
        'md4-hash-generator' => ['algo' => 'md4', 'name' => 'MD4'],
        'sha1-hash-generator' => ['algo' => 'sha1', 'name' => 'SHA-1'],
        'sha256-hash-generator' => ['algo' => 'sha256', 'name' => 'SHA-256'],
        'sha384-hash-generator' => ['algo' => 'sha384', 'name' => 'SHA-384'],
        'sha512-hash-generator' => ['algo' => 'sha512', 'name' => 'SHA-512'],
        'ripemd128-hash-generator' => ['algo' => 'ripemd128', 'name' => 'RIPEMD-128'],
        'ripemd160-hash-generator' => ['algo' => 'ripemd160', 'name' => 'RIPEMD-160'],
        'tiger128-hash-generator' => ['algo' => 'tiger128,3', 'name' => 'Tiger-128'],
        'tiger160-hash-generator' => ['algo' => 'tiger160,3', 'name' => 'Tiger-160'],
        'tiger192-hash-generator' => ['algo' => 'tiger192,3', 'name' => 'Tiger-192'],
        'whirlpool-hash-generator' => ['algo' => 'whirlpool', 'name' => 'Whirlpool'],
        'snefru-hash-generator' => ['algo' => 'snefru', 'name' => 'Snefru'],
        'haval128-hash-generator' => ['algo' => 'haval128,3', 'name' => 'Haval-128'],
        'gost-hash-generator' => ['algo' => 'gost', 'name' => 'GOST'],
    ];

    public function index(string $slug)
    {
        $tool = Tool::where('slug', $slug)->firstOrFail();
        $algoInfo = self::$algorithms[$slug] ?? abort(404);

        return view('tools.development.hash-generator', [
            'tool' => $tool,
            'slug' => $slug,
            'algoName' => $algoInfo['name'],
            'algoKey' => $algoInfo['algo'],
        ]);
    }

    public function process(Request $request, string $slug)
    {
        $request->validate(['text' => 'required|string|max:100000']);

        $algoInfo = self::$algorithms[$slug] ?? abort(404);
        $hash = hash($algoInfo['algo'], $request->input('text'));

        return response()->json([
            'hash' => $hash,
            'algorithm' => $algoInfo['name'],
        ]);
    }
}
