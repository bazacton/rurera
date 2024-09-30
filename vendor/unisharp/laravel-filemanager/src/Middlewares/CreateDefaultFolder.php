<?php

namespace UniSharp\LaravelFilemanager\Middlewares;

use Closure;
use UniSharp\LaravelFilemanager\Lfm;
use UniSharp\LaravelFilemanager\LfmPath;
use App\Http\Controllers\Admin\QuestionsBankController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class CreateDefaultFolder
{
    private $lfm;
    private $helper;

    public function __construct()
    {
        $this->lfm = app(LfmPath::class);
        $this->helper = app(Lfm::class);
    }

    public function handle($request, Closure $next)
    {
        $this->checkDefaultFolderExists('user');
        $this->checkDefaultFolderExists('share');

        return $next($request);
    }

    private function checkDefaultFolderExists($type = 'share')
    {
        if (! $this->helper->allowFolderType($type)) {
            return;
        }

        $mediaFolder = Cache::get('mediaFolder', QuestionsBankController::$mediaFolder);
        if( $mediaFolder != '') {
            Config::set('filesystems.disks.upload.root', public_path('media/' . $mediaFolder));
            Config::set('filesystems.disks.upload.url', '/media/' . $mediaFolder);
        }
        $mediaFolder = ($mediaFolder != '')? $mediaFolder :$type;
        $this->lfm->dir($this->helper->getRootFolder($mediaFolder))->createFolder();
    }
}
