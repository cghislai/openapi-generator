<?php
declare(strict_types=1);

namespace App\DTO;

use Articus\DataTransfer\PhpAttribute as DTA;

class InlineObject1
{
    /**
     * Additional data to pass to server
     */
    #[DTA\Data(field: "additionalMetadata", nullable: true)]
    #[DTA\Validator("Scalar", ["type" => "string"])]
    public string|null $additional_metadata = null;

}
