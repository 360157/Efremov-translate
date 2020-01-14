<?php

namespace Sashaef\TranslateProvider\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Translation\FileLoader;
use Sashaef\TranslateProvider\Requests\TransStoreRequest;
use Sashaef\TranslateProvider\Traits\LangsTrait as LangTrait;
use Sashaef\TranslateProvider\Traits\TranslationsTrait;
use Sashaef\TranslateProvider\Resources\TransCollection;
use Illuminate\Filesystem\Filesystem;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }
}
