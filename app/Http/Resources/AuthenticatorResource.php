<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use OTPHP\TOTP;

class AuthenticatorResource extends JsonResource
{
   public function toArray($request): array
   {
       return [
           'authenticator_id' => $this->id,
           'account_name' => $this->account_name,
           'secret_key' => $this->secret_key
       ];
   }
}
