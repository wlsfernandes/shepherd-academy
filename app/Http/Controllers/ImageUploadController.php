<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Helpers\S3Uploader;
use App\Helpers\S3FolderGenerator;
use Aws\S3\S3Client;
use Illuminate\Database\Eloquent\Model;

class ImageUploadController extends BaseController
{
    protected array $models = [
        'about' => \App\Models\About::class,
        'events' => \App\Models\Event::class,
        'blogs' => \App\Models\Blog::class,
        'banners' => \App\Models\Banner::class,
        'partners' => \App\Models\Partner::class,
        'positions' => \App\Models\Position::class,
        'testimonials' => \App\Models\Testimonial::class,
        'teams' => \App\Models\Team::class,
        'pages' => \App\Models\Page::class,
        'resources' => \App\Models\Resource::class,
        'settings' => \App\Models\Setting::class,
        // add more models here
    ];

    /**
     * Preview image from S3
     */
    public function preview(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        abort_if(!$instance->image_url, 404);

        $client = new S3Client([
            'version' => 'latest',
            'region' => config('filesystems.disks.s3.region'),
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);

        $cmd = $client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key' => $instance->image_url,
        ]);

        $request = $client->createPresignedRequest($cmd, '+10 minutes');

        return redirect((string) $request->getUri());
    }

    public function edit(string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        return view('admin.images.edit', [
            'modelKey' => $model,
            'model' => $instance,
            'image' => $instance->image_url,
        ]);
    }

    public function update(Request $request, string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        $request->validate([
            'image' => 'required|image|max:5120', // 5MB
        ]);

        // Delete old image if exists
        if (!empty($instance->image_url)) {
            S3Uploader::deletePath($instance->image_url);
        }

        // Upload new image (WebP)
        $directory = S3FolderGenerator::createFolder("{$model}/images");

        $path = S3Uploader::uploadImageAsWebp(
            $request->file('image'),
            $directory
        );

        $instance->update([
            'image_url' => $path,
        ]);

        return redirect()
            ->route("{$model}.index")
            ->with('success', 'Image uploaded successfully.');
    }


    protected function resolveModel(string $model, int $id): Model
    {
        abort_unless(isset($this->models[$model]), 404);

        return $this->models[$model]::findOrFail($id);
    }
}
