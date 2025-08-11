<?php

namespace App\Services\InvoiceProcessingService;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;
use TarfinLabs\ZbarPhp\Exceptions\ZbarError;
use TarfinLabs\ZbarPhp\Zbar;

class InvoiceProcessingService
{
    public int $edgeLength = 240;

    /**
     * @throws \ImagickException
     * @throws \TarfinLabs\ZbarPhp\Exceptions\UnableToOpen
     * @throws \TarfinLabs\ZbarPhp\Exceptions\InvalidFormat
     * @throws \Exception
     */
    public function readQrCode(string $filePath): string|null
    {
        $cropedQRPath = 'public/'.Str::random(40).'.png';
        $imagickInstance = $this->cropQrCodeFromPDF($filePath);

        Storage::put($cropedQRPath, $imagickInstance->getImageBlob());

        try {
            $readedCode = (new Zbar(Storage::path($cropedQRPath)))->scan();
        } catch (ZbarError) {
            $readedCode = null;
        }

        Storage::delete($cropedQRPath);

        return $readedCode;
    }

    /**
     * @throws \Exception
     */
    public function cropQrCodeFromPDF(string $filePath): Imagick
    {
        $imagick = new Imagick();
        $imagick->setResolution(128, 128);
        $imagick->readImageBlob(Storage::get($filePath));

        $imageWidth = $imagick->getImageWidth() - $this->edgeLength;
        $imagick->cropImage($this->edgeLength + 80, $this->edgeLength + 80, $imageWidth - 80 , 0);
        $imagick->resizeImage($this->edgeLength + 80, $this->edgeLength + 80, 1, 0);

        $imagick->setImageFormat('png');

        return $imagick;
    }
}
