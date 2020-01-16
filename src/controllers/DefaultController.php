<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sashaef\TranslateProvider\Traits\TranslationsTrait;

class DefaultController extends Controller
{
    use TranslationsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'lang' => $request->lang,
            'data' => self::getTranslations($request->type ?? 'interface', $request->lang ?? 'en', $request->keys)
        ], 200);
    }
}