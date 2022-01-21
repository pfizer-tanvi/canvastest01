<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    protected $appends = ['url'];

    public static function fromUploadedFile(UploadedFile $file)
    {
        $name = $file->getClientOriginalName();

        $media = static::make([
            'name' => $name,
            'location' => config()->get('app.media_disk'),
        ]);

        Storage::disk(config()->get('app.media_disk'))->putFileAs($media->getRelativePath(), $file, $name);

        $media->save();

        return $media;
    }

    public function getPath()
    {
        return trim($this->getRelativePath() . '/' . $this->name, '/');
    }

    public function getRelativePath(string $name = null)
    {
        return $this->location === 's3' ? sprintf('dset-%s/%s', config('app.name'), config('app.env')) : 'media';
    }

    public function getUrlAttribute()
    {
        $ttl = now()->addMinutes(15);

        if ($this->location === 'local') {
            return URL::temporarySignedRoute('media.file', $ttl, ['media' => $this]);
        }

        return Storage::temporaryUrl($this->getPath(), $ttl);
    }
}
